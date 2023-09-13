<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class DashboardController extends Controller
{
    public function show(Dashboard $dashboard)
    {
        // return $dashboard;
        // $issue->load(['services' => function ($services) {
        //     $services->with(['verifications'])->get();
        // }, 'vehicle']
        return view('admin.dashboard', [
            'title' => 'Home',
            'breadcrumb' => 'Dashboard',
            'subtitle' => 'test',
            'dashboard' => $dashboard->load(['panels' => function ($panels) {
                $panels->orderBy('order', 'ASC');
            }]),
            // 'panels' => Panel::where('dashboard_id', $dashboard->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'dashboard_name' => 'required|max:255',
                'description' => 'max:1024|required',
            ]);
            Dashboard::create($validatedData);
            // return redirect('/admin-panel')->with('success', 'New site has been added!');
            alert()->success('Success', 'New dashboard has been added!');
            return back()->with('success', "New dashboard has been added!");
        } catch (Throwable $e) {
            alert()->warning('Failed', "Add dashboard failed, " . $e->getMessage());
            return back()->with('failed', "Add dashboard failed, " . $e->getMessage());
        }
    }

    public function update(Request $request, Dashboard $dashboard)
    {
        try {
            $validatedData = $request->validate([
                'dashboard_name' => 'required|max:255',
                'description' => 'max:1024|required',
            ]);
            Dashboard::where('id', $dashboard->id)->update($validatedData);
            alert()->success('Success', 'Edit dashboard success!');
            return back()->with('success', "Edit dashboard success");
        } catch (Throwable $e) {
            alert()->warning('Failed', "Edit dashboard failed, " . $e->getMessage());
            return back()->with('failed', "Edit dashboard failed, " . $e->getMessage());
        }
    }

    public function destroy(Dashboard $dashboard)
    {
        try {
            Dashboard::where('id', $dashboard->id)->delete();
            // return back()->with('success', "Delete dashboard success");
            alert()->success('Success', 'Delete dashboard success!');
            return redirect('/admin-panel')->with('success', 'Delete dashboard success!');
        } catch (Throwable $e) {
            alert()->warning('Failed', "Delete dashboard failed, " . $e->getMessage());
            return back()->with('failed', "Delete dashboard failed, " . $e->getMessage());
        }
    }


    public function dashboard_list(Request $request)
    {
        $columns = array(
            'dashboard_name',
            'description',
            'created_at',
        );
        $collection = DB::table('dashboards');
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
                $nestedData[] = '<a href="/admin-panel/dashboard/' . $row->id . '"
                class="font-weight-bold my-auto btn btn-dark">
                Edit Dashboard
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
}
