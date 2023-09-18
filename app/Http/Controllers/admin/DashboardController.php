<?php

namespace App\Http\Controllers\admin;

use App\Charts\NumberParametersChart;
use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Models\Panel;
use App\Models\Parameters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

use function PHPSTORM_META\map;

class DashboardController extends Controller
{
    public function show(Dashboard $dashboard)
    {
        // return $dashboard;
        // $issue->load(['services' => function ($services) {
        //     $services->with(['verifications'])->get();
        // }, 'vehicle']
        $dashboard = $dashboard->load(['panels' => function ($panels) {
            $panels->orderBy('order', 'ASC');
            $panels->with(['parameter']);
        }]);
        // $test = [];
        // foreach ($dashboard->panels as $panel) {
        //     // $this->renderGauge($panel->parameter);
        //     $test = array_merge($test, [$panel->parameter->id => $this->renderGauge($panel->parameter)]);
        // }
        $charts = $dashboard->panels->map(
            function ($panel) {
                // dd($panel->parameter->type);
                if ($panel->parameter) {
                    return $this->renderGauge($panel->parameter);
                }
            }
        );
        // dd($test);
        return view('admin.dashboard', [
            'title' => 'Home',
            'breadcrumb' => 'Dashboard',
            'subtitle' => 'test',
            'dashboard' => $dashboard,
            'parameters' => Parameters::all(),
            'charts' => $charts
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
}
