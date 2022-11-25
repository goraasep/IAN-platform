<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Parameters;
use App\Models\Sites;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use LaracraftTech\LaravelDynamicModel\DynamicModel;

class DatatablesController extends Controller
{
    //
    public function allDevices(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'description',
            3 => 'created_at',
        );

        $totalData = Devices::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = Devices::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $table =  Devices::orWhere(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Devices::where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {

                $nestedData = [];

                $nestedData[] = '<div class="">
                    <div class="d-flex align-items-center">
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-1">
                        <h6 class="mb-0 text-sm font-weight-semibold">' . $row->name . '
                        </h6>
                        <p class="text-sm text-secondary mb-0">
                            ' . Str::limit($row->description, 20, '...') . '</p>
                    </div>
                </div>';
                $nestedData[] = '<span
                    class="badge badge-sm border border-success text-success bg-success">Online</span>';
                $nestedData[] = $row->created_at;
                $nestedData[] = '<a href="/devices/' . $row->uuid . '"
                    class="text-secondary font-weight-bold text-xs"
                    data-bs-toggle="tooltip" data-bs-title="Edit user">
                    <i class="fa-solid fa-pen-to-square"></i>
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
    public function allParameters(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'slug',
            2 => 'unit',
            3 => 'alert',
            4 => 'type',
        );
        $collection = Parameters::where('device_id', $request->device_id);
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
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $alert = '<span class="badge badge-sm border border-success text-success bg-success">' . $row->alert . '</span>';
                $nestedData[] = $row->name;
                $nestedData[] = $row->slug;
                $nestedData[] = $row->unit;
                $nestedData[] = $alert;
                $nestedData[] = $row->type;
                $nestedData[] = view('modal.edit-parameter', ['parameter' => $row, 'device_uuid' => $request->device_uuid])->render();
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
    public function allAlerts(Request $request)
    {
        $columns = array(
            0 => 'parameter',
            1 => 'value',
            2 => 'created_at',
        );
        $collection = App::make(DynamicModel::class, ['table_name' => 'device_' . $request->device_id . '_alert']);
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
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $alert = '<span class="badge badge-sm border border-success text-success bg-success">' . $row->alert . '</span>';
                $nestedData[] = $row->name;
                $nestedData[] = $row->actual_value;
                $nestedData[] = $row->unit;
                $nestedData[] = $alert;
                $nestedData[] = $row->type;
                $nestedData[] = '<i class="fa-solid fa-pen-to-square"></i>';
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
    public function HistoricalLog(Request $request)
    {
        // $columns = array(
        //     0 => 'created_at',
        // );
        $columns = ['created_at'];
        if ($request->parameters)
            array_merge($columns, $request->parameters);
        $collection = App::make(DynamicModel::class, ['table_name' => 'device_' . $request->device_id . '_log']);
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
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->created_at;
                foreach ($request->parameters as $parameter) {
                    $nestedData[] = $row->{$parameter};
                }
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

    public function allSites(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'description',
            2 => 'lng',
            3 => 'lat',
            4 => 'created_at',
        );

        $totalData = Sites::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = Sites::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $table =  Sites::orWhere(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Sites::where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {

                $nestedData = [];

                $nestedData[] = $row->name;
                $nestedData[] = $row->description;
                $nestedData[] = 'Lng: ' . $row->lng . ', Lat: ' . $row->lat;
                $nestedData[] = '<a href="/sites/' . $row->slug . '"
                class="text-secondary font-weight-bold text-xs"
                data-bs-toggle="tooltip" data-bs-title="Edit user">
                <i class="fa-solid fa-pen-to-square"></i>
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
