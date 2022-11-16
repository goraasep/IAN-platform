<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\NumberParametersChart;

class TestController extends Controller
{
    //
    public function test()
    {
        $chart = new NumberParametersChart;
        $chart->dataset('', 'gauge', [100])
            ->options(
                [
                    'type' => 'gauge',
                    'axisLine' => [
                        'lineStyle' => [
                            'width' => 30,
                            'color' => [
                                [0.3, '#67e0e3'],
                                [0.7, '#37a2da'],
                                [1, '#fd666d']
                            ]
                        ]
                    ],
                    'pointer' => [
                        'itemStyle' => [
                            'color' => 'auto'
                        ]
                    ],
                    'axisTick' => [
                        'distance' => -30,
                        'length' => 8,
                        'lineStyle' => [
                            'color' => '#fff',
                            'width' => 2
                        ]
                    ],
                    'splitLine' => [
                        'distance' => -30,
                        'length' => 30,
                        'lineStyle' => [
                            'color' => '#fff',
                            'width' => 4
                        ]
                    ],
                    'axisLabel' => [
                        'color' => 'auto',
                        'distance' => 40,
                        'fontSize' => 20
                    ],
                    'detail' => [
                        'valueAnimation' => true,
                        'formatter' => '{value} km/h',
                        'color' => 'auto'
                    ],
                ]
            );
        $style = [
            'title' => [
                'text' => 'Stacked Line'
            ],
            'tooltip' => [
                'trigger' => 'axis',
                'show' => true
            ],
            // 'legend' => [
            //     'data' => ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine']
            // ],
            'grid' => [
                'left' => '3%',
                'right' => '4%',
                'bottom' => '3%',
                'containLabel' => true
            ],
            'toolbox' => [
                'feature' => [
                    'saveAsImage' => []
                ]
            ],
            'xAxis' => [
                'type' => 'category',
                'boundaryGap' => false,
                'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            ],
            'yAxis' => [
                'type' => 'value'
            ]
        ];
        $chart->dataset('A', 'line', [4, 3, 2, 1]);
        $chart->dataset('B', 'line', [1, 2, 3, 4]);
        $chart->options($style);
        // $chart->dataset('B', 'line', [1, 2, 3, 4])->options($style);
        // $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);
        // $chart->dataset('Sample Test', 'bar', [3, 4, 1]);
        // $chart->dataset('Sample Test 2', 'line', [1, 4, 3]);
        return view('test', [
            'title' => 'test',
            'breadcrumb' => 'test',
            'chart' => $chart
        ]);
    }
}
