<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParameterController extends Controller
{
    //
    public function parameter_list(Request $request)
    {
        $columns = array(
            'name',
            'slug',
            'type',
            'unit',
            'th_H',
            'th_H_enable',
            'th_L',
            'th_L_enable',
            'max',
            'min',
            'created_at'
        );
        $collection = DB::table('parameters');
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
                $nestedData[] = $row->name;
                $nestedData[] = $row->slug;
                $nestedData[] = $row->type;
                $nestedData[] = $row->unit;
                $nestedData[] = $row->th_H;
                $nestedData[] = $row->th_H_enable;
                $nestedData[] = $row->th_L;
                $nestedData[] = $row->th_L_enable;
                $nestedData[] = $row->max;
                $nestedData[] = $row->min;
                $nestedData[] = $row->created_at;
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
