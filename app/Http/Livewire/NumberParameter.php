<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Devices;
use Illuminate\Support\Facades\App;
use LaracraftTech\LaravelDynamicModel\DynamicModel;
use App\Charts\NumberParametersChart;

class NumberParameter extends Component
{
    public $device_id;
    public function mount($device_id)
    {
        $this->device_id = $device_id;
    }


    public function render()
    {

        $gauge_options = [
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
                'color' => 'auto'
            ],
        ];

        $line_options = [
            // 'title' => [
            //     'text' => 'Stacked Line'
            // ],
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
                // 'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']
            ],
            'yAxis' => [
                'type' => 'value'
            ]
        ];

        $parameters = Devices::with('parameters')->where('id', $this->device_id)->first()->parameters->where('type', 'number');
        $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $this->device_id . '_log'])->latest();

        $charts_gauge = [];
        $charts_line = [];
        $first_log = $parameters_log->first() ?: 0;
        $parameters_log_ranged = $parameters_log->take(5)->get();
        // dd($parameters_log_ranged);
        foreach ($parameters as $parameter) {
            $chart_gauge = new NumberParametersChart;
            $chart_gauge->dataset('', 'gauge', [$first_log ? $first_log->{$parameter->slug} : 0])
                ->options([
                    'detail' => [
                        'formatter' => '{value} ' . $parameter->unit,
                    ]
                ])
                ->options($gauge_options);
            array_push($charts_gauge, $chart_gauge);
            $chart_line = new NumberParametersChart;
            $chart_line->dataset('', 'line', $first_log ? $parameters_log_ranged->map(function ($query) use ($parameter) {
                return $query->{$parameter->slug};
            }) : 0);
            $chart_line->options($line_options);
            $chart_line->options([
                'xAxis' => [
                    'data' => $first_log ? $parameters_log_ranged->map(function ($query) {
                        return $query->created_at;
                    })->toArray() : 0
                ],
            ]);

            array_push($charts_line, $chart_line);
        }
        $data = [
            // 'parameters_log' => $parameters_log->first(),
            'parameters' => $parameters,
            'charts_gauge' => $charts_gauge,
            'charts_line' => $charts_line
        ];
        return view('livewire.number-parameter', $data);
    }
}
