<?php

namespace App\Http\Controllers\user;

use App\Charts\NumberParametersChart;
use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $access = Auth::user()->access;
        $dashboards = [];
        if (sizeof($access) > 0) {
            foreach ($access as $dashboard_list) {
                $dashboard = Dashboard::find($dashboard_list->dashboard_id);
                array_push($dashboards, $dashboard);
            }
        }
        return view('user.index', [
            'title' => 'Home',
            'breadcrumb' => 'Home',
            'subtitle' => 'test',
            'dashboards' => $dashboards,
            'access' => $access
        ]);
    }

    public function show(Dashboard $dashboard)
    {
        $access = collect(Auth::user()->access);
        $dashboard_access = $access->where('dashboard_id', $dashboard->id);
        if (sizeof($dashboard_access) > 0) {
            $dashboard = $dashboard->load(['panels' => function ($panels) {
                $panels->orderBy('order', 'ASC');
                $panels->with(['parameter']);
            }]);
            $charts = $dashboard->panels->map(
                function ($panel) {
                    if ($panel->parameter) {
                        return $this->renderGauge($panel->parameter);
                    }
                }
            );
            $dashboards = [];
            if (sizeof($access) > 0) {
                foreach ($access as $dashboard_list) {
                    $_dashboard = Dashboard::find($dashboard_list->dashboard_id);
                    array_push($dashboards, $_dashboard);
                }
            }
            return view('user.dashboard', [
                'title' => 'Home',
                'breadcrumb' => 'Dashboard',
                'subtitle' => 'test',
                'dashboard' => $dashboard,
                'charts' => $charts,
                'access' => $access,
                'dashboards' => $dashboards
            ]);
        } else {
            alert()->warning('Failed', 'You dont have access to this dashboard.');
            return redirect('/');
        }
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
