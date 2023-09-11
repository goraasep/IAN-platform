<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'panels' => Panel::where('dashboard_id', $dashboard->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dashboard_name' => 'required|max:255',
            'description' => 'max:1024|required',
        ]);
        Dashboard::create($validatedData);
        return redirect('/admin-panel')->with('success', 'New site has been added!');
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
