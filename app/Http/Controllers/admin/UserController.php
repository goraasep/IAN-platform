<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRights;
use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    //

    public function show(Request $request, User $user)
    {
        // return $parameter;
        // dd($user->load(['access' => function ($access) {
        //     $access->with(['dashboard']);
        // }]));
        $user = $user->load(['access' => function ($access) {
            $access->with(['dashboard']);
        }]);
        // $dashboard = $dashboard->load(['panels' => function ($panels) {
        //     $panels->orderBy('order', 'ASC');
        //     $panels->with(['parameter']);
        // }]);
        $data = [
            'title' => 'Home',
            'breadcrumb' => 'Parameter',
            'subtitle' => 'test',
            'user' => $user,
            'dashboards' => Dashboard::all()
        ];
        return view('admin.user', $data);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $validatedData["password"] = Hash::make($validatedData["password"]);
            $user = User::Create($validatedData);
            $user->assignRole('User');
            alert()->success('Success', 'New user has been added!');
            return back();
        } catch (Throwable $e) {
            alert()->warning('Failed', "Add user failed, " . $e->getMessage());
            return back();
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'password' => 'required',
            ]);
            $validatedData["password"] = Hash::make($validatedData["password"]);
            User::whereId($user->id)->update([
                'password' => $validatedData["password"]
            ]);
            alert()->success('Success', 'Change password success!');
            return back();
        } catch (Throwable $e) {
            alert()->warning('Failed', "Change password failed, " . $e->getMessage());
            return back();
        }
    }

    public function addDashboardAccess(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'integer',
                'dashboard_id' => 'integer',
            ]);
            // $validatedData["user_id"] = $user->id;
            AccessRights::Create($validatedData);
            alert()->success('Success', 'New access has been added!');
            return back();
        } catch (Throwable $e) {
            alert()->warning('Failed', "Add access failed, " . $e->getMessage());
            return back();
        }
    }

    public function destroy(User $user)
    {
        //
        try {
            User::where('id', $user->id)->delete();

            alert()->success('Success', 'Delete user success!');
            return redirect('/admin-panel');
        } catch (Throwable $e) {
            alert()->warning('Failed', 'Delete user failed, ' . $e->getMessage());
            return back();
        }
    }

    public function destroy_access(AccessRights $access)
    {
        //
        try {
            AccessRights::where('id', $access->id)->delete();

            alert()->success('Success', 'Delete access success!');
            return back();
        } catch (Throwable $e) {
            alert()->warning('Failed', 'Delete access failed, ' . $e->getMessage());
            return back();
        }
    }

    public function user_list(Request $request)
    {
        $columns = array(
            'id',
            'email',
            'created_at',
        );
        $collection = DB::table('users')->select($columns);
        $totalData = $collection->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = $collection->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
            $table = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->id;
                $nestedData[] = $row->email;
                $nestedData[] = $row->created_at;
                $nestedData[] = '<a href="/admin-panel/user/' . $row->id . '"
                class="font-weight-bold my-auto btn btn-dark">
                Edit User
                </a>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }

    public function access_list(Request $request)
    {
        $columns = array(
            'dashboards.dashboard_name',
            'dashboards.description',
            'dashboards.created_at',
            'access_rights.id'
        );
        $collection = DB::table('access_rights')->select($columns)
            ->leftJoin('dashboards', 'access_rights.dashboard_id', '=', 'dashboards.id');
        // $subjoin = DB::table('service_logs')->select($subcolumns)
        //     ->leftJoin('verification_logs', 'service_logs.id', '=', 'verification_logs.service_id');
        $totalData = $collection->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = $collection->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
            $table = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->dashboard_name;
                $nestedData[] = $row->description;
                $nestedData[] = $row->created_at;
                // $nestedData[] = '<a href="/admin-panel/user/' . $row->id . '"
                // class="font-weight-bold my-auto btn btn-dark">
                // Delete
                // </a>';
                $nestedData[] = view('modal.delete_access', ['access_id' => $row->id, 'dashboard_name' => $row->dashboard_name])->render();
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }
}
