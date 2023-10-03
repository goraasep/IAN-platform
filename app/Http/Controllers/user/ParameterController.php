<?php

namespace App\Http\Controllers\user;

use App\Charts\NumberParametersChart;
use App\Exports\SingleParameterExport;
use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Models\Parameters;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParameterController extends Controller
{
    //
    public function show(Request $request, Parameters $parameter)
    {
        $access = Auth::user()->access;
        $dashboards = [];
        if (sizeof($access) > 0) {
            $dashboard = Dashboard::find($access[0]->dashboard_id);
            array_push($dashboards, $dashboard);
        }
        $default_time = $request->datetimerange ?: Carbon::now()->toDateString() . ' 00:00:00 to ' . Carbon::now()->toDateString() . ' 23:59:00';
        $default_group = $request->group ?: 'hour';
        $data = [
            'title' => 'Home',
            'breadcrumb' => 'Parameter',
            'subtitle' => 'test',
            'parameter' => $parameter,
            'charts' => [
                'chart_gauge' => $this->renderGauge($parameter),
                'chart_line' => $this->renderLine($parameter, $default_time, $default_group)
            ],
            'datetimerange' => $default_time,
            'dashboards' => $dashboards,
            'group' => $default_group
        ];
        // $data['charts'] = $this->renderChart($parameter);
        return view('user.parameter', $data);
    }

    private function renderGauge($parameter)
    {
        $gauge_options =
            [
                'radius' => '50%',
                'type' => 'gauge',
                'center' => ['50%', '50%'],
                'startAngle' => 200,
                'endAngle' => -20,
                'splitNumber' => 10,
                'itemStyle' => [
                    'color' => '#13678A'
                ],
                'progress' => [
                    'show' => true,
                    'width' => 30
                ],
                'pointer' => [
                    'show' => false
                ],
                'axisLine' => [
                    'lineStyle' => [
                        'width' => 30
                    ]
                ],
                'axisTick' => [
                    'distance' => -45,
                    'splitNumber' => 5,
                    'lineStyle' => [
                        'width' => 2,
                        'color' => '#000'
                    ]
                ],
                'splitLine' => [
                    'distance' => -52,
                    'length' => 14,
                    'lineStyle' => [
                        'width' => 3,
                        'color' => '#000'
                    ]
                ],
                'axisLabel' => [
                    'distance' => -15,
                    'color' => '#000',
                    'fontSize' => 18
                ],
                'anchor' => [
                    'show' => false
                ],
                'title' => [
                    'show' => false
                ],
                'detail' => [
                    'valueAnimation' => true,
                    'width' => '60%',
                    'lineHeight' => 40,
                    'borderRadius' => 8,
                    'offsetCenter' => [0, '-15%'],
                    'fontWeight' => 'bolder',
                    'color' => 'auto',
                    'fontSize' => 20,
                ]
            ];
        $gauge_options2 =
            [
                'radius' => '50%',
                'type' => 'gauge',
                'center' => ['50%', '50%'],
                'startAngle' => 200,
                'endAngle' => -20,
                // 'itemStyle' => [
                //     'color' => '#FD7347'
                // ],
                'progress' => [
                    'show' => false,
                    'width' => 8
                ],
                'pointer' => [
                    'show' => false
                ],
                'axisLine' => [
                    'show' => true,
                    'lineStyle' => [
                        'width' => -5,
                        // 'color' => [
                        //     [0.7, '#F49D1A'],
                        //     [0.8, '#54B435'],
                        //     [1, '#DC3535']
                        // ]
                    ]
                ],
                'axisTick' => [
                    'show' => false
                ],
                'splitLine' => [
                    'show' => false
                ],
                'axisLabel' => [
                    'show' => false
                ],
                'anchor' => [
                    'show' => false
                ],
                'title' => [
                    'show' => false
                ],
                'detail' => [
                    'show' => false
                ],
                'data' => [
                    'value' => 55
                ]
            ];
        $chart_gauge = new NumberParametersChart;
        $chart_gauge->dataset('', 'gauge', [$parameter->actual_value])
            ->options([
                'detail' => [
                    'formatter' => '{value} ' . $parameter->unit,
                ],
                'min' => $parameter->min,
                'max' => $parameter->max,
            ])
            ->options($gauge_options);
        $chart_gauge->dataset('', 'gauge', [0])
            ->options([
                'min' => $parameter->min,
                'max' => $parameter->max,
                'axisLine' => [
                    'lineStyle' => [
                        'color' => [
                            [$parameter->max ? ($parameter->th_L / $parameter->max) : 0, '#F49D1A'],
                            [$parameter->max ? ($parameter->th_H / $parameter->max) : 0, '#54B435'],
                            [1, '#DC3535']
                        ]
                    ]
                ],
            ])
            ->options($gauge_options2);;
        return $chart_gauge;
    }

    private function renderLine($parameter, $datetimerange, $default_group)
    {
        $datetimeexplode = explode(' to ', $datetimerange);
        $datetimestart = $datetimeexplode[0];
        $datetimeend = $datetimeexplode[1];
        $parameter_log = DB::table('parameter_log_' . $parameter->id)
            ->select('created_at', 'log_value')
            ->where([
                ['created_at', '>=', $datetimestart],
                ['created_at', '<=',  $datetimeend],
            ]);
        if ($default_group == 'hour') {
            $parameter_log = $parameter_log->groupByRaw('date(created_at)');
            $parameter_log = $parameter_log->groupByRaw('hour(created_at)');
        } elseif ($default_group == 'date') {
            $parameter_log = $parameter_log->groupByRaw('date(created_at)');
        }
        $parameter_log = $parameter_log->get();
        // $parameter_log = DB::table('parameter_log_' . $parameter->id)
        //     ->select('created_at', 'log_value')
        //     ->where([
        //         ['created_at', '>=', $datetimestart],
        //         ['created_at', '<=',  $datetimeend],
        //     ])
        //     ->get();
        $arr_parameter_log = collect($parameter_log)->map(function ($log) {
            return [$log->created_at, $log->log_value];
        });

        $line_options = [
            'tooltip' => [
                'trigger' => 'axis',
                'show' => true
            ],
            'color' => '#13678A',
            'toolbox' => [
                'feature' => [
                    'dataZoom' => [
                        'yAxisIndex' > false
                    ],
                    'restore' => [],
                    'saveAsImage' => []
                ],
            ],

            'xAxis' => [
                'type' => 'time',
                'boundaryGap' => false,
            ],
            'yAxis' => [
                'type' => 'value',
                'boundaryGap' => [0, '100%']
            ],
            'dataZoom' => [
                [
                    'type' => 'slider',
                ],
            ],
        ];

        $chart_line = new NumberParametersChart;
        $chart_line->dataset('', 'line', $arr_parameter_log)->options([
            'smooth' => true,
            'areaStyle' => [
                'opacity' => 0.2
            ],
            'markLine' => [
                'silent' => false,
                'lineStyle' => [
                    'color' => '#333'
                ],
                'data' => [
                    [
                        'yAxis' => $parameter->th_L,
                        'label' => [
                            'show' => true,
                            'formatter' => '{c} Low'
                        ],
                    ],
                    [
                        'yAxis' => $parameter->th_H,
                        'label' => [
                            'show' => true,
                            'formatter' => '{c} High'
                        ],
                    ],
                ]
            ]
        ]);
        $chart_line->options($line_options);
        return $chart_line;
    }

    public function liveData(Request $request)
    {
        $parameter_id = $request->input('parameter_id');
        $parameter = Parameters::find($parameter_id);
        return json_encode($parameter);
    }

    public function graphData(Request $request)
    {
        $parameter_id = $request->input('parameter_id');
        $datetimerange = $request->input('datetimerange');
        $datetimeexplode = explode(' to ', $datetimerange);
        $datetimestart = $datetimeexplode[0];
        $datetimeend = $datetimeexplode[1];
        $parameter_log = DB::table('parameter_log_' . $parameter_id)
            ->where([
                ['created_at', '>=', $datetimestart],
                ['created_at', '<=',  $datetimeend],
            ])->get();
        // $parameter_log = DB::table('parameter_log_' . $parameter_id)
        //     ->get();
        return json_encode($parameter_log);
    }

    public function historical_log(Request $request)
    {

        $datetimerange = $request->input('datetimerange');
        $datetimeexplode = explode(' to ', $datetimerange);
        $datetimestart = $datetimeexplode[0];
        $datetimeend = $datetimeexplode[1];

        $columns = array(
            'created_at',
            'log_value',
        );
        $parameter_id = $request->input('parameter_id');
        $collection = DB::table('parameter_log_' . $parameter_id)
            ->where([
                ['created_at', '>=', $datetimestart],
                ['created_at', '<=',  $datetimeend],
            ]);
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
                $nestedData[] = $row->created_at;
                $nestedData[] = $row->log_value;
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

    public function alert_log(Request $request)
    {
        $datetimerange = $request->input('datetimerange');
        $datetimeexplode = explode(' to ', $datetimerange);
        $datetimestart = $datetimeexplode[0];
        $datetimeend = $datetimeexplode[1];

        $columns = array(
            'created_at',
            'alert',
        );
        $parameter_id = $request->input('parameter_id');
        $collection = DB::table('parameter_alert_' . $parameter_id);
        // ->where([
        //     ['created_at', '>=', $datetimestart],
        //     ['created_at', '<=',  $datetimeend],
        // ]);
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
                $nestedData[] = $row->created_at;
                $nestedData[] = $row->alert;
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

    public function export(Request $request)
    {
        // dd($request->all());
        return new SingleParameterExport($request);
    }
}
