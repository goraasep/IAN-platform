<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Connections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConnectionController extends Controller
{
    //
    public function show(Request $request, Connections $connection)
    {
        // return $parameter;
        // dd($user->load(['access' => function ($access) {
        //     $access->with(['dashboard']);
        // }]));
        // $user = $user->load(['access' => function ($access) {
        //     $access->with(['dashboard']);
        // }]);
        // // $dashboard = $dashboard->load(['panels' => function ($panels) {
        // //     $panels->orderBy('order', 'ASC');
        // //     $panels->with(['parameter']);
        // // }]);
        $data = [
            'title' => 'Home',
            'breadcrumb' => 'Parameter',
            'subtitle' => 'test',
            // 'user' => $user,
            // 'connection' => $connection->load('topics')
            'connection' => $connection
        ];
        // dd($connection);
        return view('admin.connection', $data);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'broker_address' => 'required|max:255',
                'port' => 'integer|required',
                'username' => 'max:255|required',
                'password' => 'max:255|required',
                'client_id' => 'max:255|required',
            ]);
            Connections::create($validatedData);
            // return redirect('/admin-panel')->with('success', 'New site has been added!');
            alert()->success('Success', 'New connection has been added!');
            return back();
        } catch (Throwable $e) {
            alert()->warning('Failed', "Add connection failed, " . $e->getMessage());
            return back();
        }
    }

    public function update(Request $request, Connections $connection)
    {
        try {
            $validatedData = $request->validate([
                'broker_address' => 'required|max:255',
                'port' => 'integer|required',
                'username' => 'max:255|required',
                'password' => 'max:255|required',
                'client_id' => 'max:255|required',
            ]);
            $validatedData['conn_flag'] = 0;
            Connections::whereId($connection->id)->update($validatedData);
            alert()->success('Success', 'Change connection setting success!');
            return back();
        } catch (Throwable $e) {
            alert()->warning('Failed', "Change connection setting failed, " . $e->getMessage());
            return back();
        }
    }

    public function destroy(Connections $connection)
    {
        //
        try {
            // Connections::where('id', $connection->id)->delete();
            Connections::where('id', $connection->id)->update(['soft_delete' => 1]);

            alert()->success('Success', 'Delete connection success!');
            return redirect('/admin-panel');
        } catch (Throwable $e) {
            alert()->warning('Failed', 'Delete connection failed, ' . $e->getMessage());
            return back();
        }
    }

    public function connection_list(Request $request)
    {
        $columns = array(
            'broker_address',
            'port',
            'client_id',
            'status',
            'created_at',
        );
        $collection = DB::table('connections');
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
                $nestedData[] = $row->broker_address;
                $nestedData[] = $row->port;
                $nestedData[] = $row->client_id;
                $nestedData[] = $row->status;
                $nestedData[] = $row->created_at;
                $nestedData[] = '<a href="/admin-panel/connection/' . $row->id . '"
                class="font-weight-bold my-auto btn btn-dark">
                Edit Connection
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
