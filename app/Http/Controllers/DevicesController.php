<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Parameters;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\App;
// use LaracraftTech\LaravelDynamicModel\DynamicModel;
// use Illuminate\Support\Str;
use App\Charts\NumberParametersChart;
use App\Models\Sites;
// use SebastianBergmann\Type\NullType;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = [
            'title' => 'Devices',
            'breadcrumb' => 'List',
            'subtitle' => 'Devices',
            'sites' => Sites::all()
        ];
        return view('devices.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return $request;
        $validatedData = $request->validate([
            'site_id' => 'nullable',
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024',
            'description' => 'max:1024|required'
        ]);
        if (array_key_exists('image', $validatedData)) {
            $filename = $validatedData['image']->hashName();
            $validatedData['image']->storeAs(
                'public/images',
                $filename
            );
            $validatedData['image'] = $filename;
        }
        Devices::create($validatedData);
        $last_inserted_id = Devices::latest()->first()->id;
        Schema::create('device_' . $last_inserted_id . '_log', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->timestamp('created_at')->useCurrent();
        });
        Schema::create('device_' . $last_inserted_id . '_alert', function (Blueprint $table) {
            $table->id();
            $table->string('parameter');
            $table->string('value');
            $table->timestamp('created_at')->useCurrent();
        });
        return redirect('/devices')->with('success', 'New post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Devices $device, Request $request)
    {
        // $parameters = Parameters::where('device_id', $device->id)->get()->map(function ($query) {
        //     return $query->slug;
        // });
        // $parameters = Parameters::where('device_id', $device->id)->get()->map(function ($query) {
        //     return $query->slug;
        // });
        // dd($tt);
        //eager load
        // Devices::with('parameters')->get();
        // $alert_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $device->id . '_alert']);
        // dd($request->input());
        // if ($request->input('range')) {
        //     dd($request->input('range'));
        // }

        $parameters = Parameters::where('device_id', $device->id)->get();
        $parameters_number = $parameters->where('type', 'number');
        $parameters_string = $parameters->where('type', 'string');
        $parameters_special = $parameters->where('type', 'special');
        // $range = 1;
        $range = (int)$request->input('range') ?: 1;
        $from = (int)$request->input('from') ?: 0;
        $to = (int)$request->input('to') ?: 0;
        $data = [
            'title' => 'Devices',
            'breadcrumb' => 'Device',
            'subtitle' => $device->name,
            'device' => $device,
            // 'parameters' => Parameters::where('device_id', $device->id),
            'parameters' => $parameters,
            'parameters_number' => $parameters_number,
            'parameters_string' => $parameters_string,
            'parameters_special' => $parameters_special,
            'range' => $range,
            'from' => $from,
            'to' => $to,
            'request' => $request
            // 'charts' => $this->renderChart($device->id, $parameters_number)
            // 'alerts' => $alert_log->paginate(10)->withQueryString()
        ];
        // dd($parameters_number);
        if ($parameters_number) {
            $data['charts'] = $this->renderChart($device->id, $parameters_number, $range, $from, $to);
        }
        // $alert_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $device->id . '_alert']);
        // dd($alert_log->first());
        // Devices::latest()->with('parameters')->filter(request(['search']))->paginate(10)->withQueryString(),
        return view('devices.device', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Devices $device)
    {
        //
        $data = [
            'title' => 'Devices',
            'breadcrumb' => 'Device',
            'subtitle' => $device->name,
            'device' => $device,
            'sites' => Sites::all()
        ];
        return view('devices.edit', $data);
        // return 'sadsadsa';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Devices $device)
    {
        //
        $validatedData = $request->validate([
            'site_id' => 'nullable',
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024',
            'description' => 'max:1024'
        ]);
        if (array_key_exists('image', $validatedData)) {
            Storage::delete('/public/images/' . $device->image);
            $filename = $validatedData['image']->hashName();
            $validatedData['image']->storeAs(
                'public/images',
                $filename
            );
            $validatedData['image'] = $filename;
        }
        // ddd($request);
        Devices::where('uuid', $device->uuid)->update($validatedData);
        return redirect('/devices/' . $device->uuid . '/edit')->with('success', 'Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $device = Devices::where('uuid', $request['uuid'])->first();
        Storage::delete('/public/images/' . $device->image);
        Schema::dropIfExists('device_' . $device->id . '_log');
        Schema::dropIfExists('device_' . $device->id . '_alert');
        Devices::where('uuid', $request['uuid'])->delete();
        // Schema::table('device_' . $device_id . '_log', function ($table) use ($slug) {
        //     $table->dropColumn($slug);
        // });
        return redirect('/devices')->with('success', 'Success!');
    }

    //custom method

    // public function showDevice($uuid)
    // {
    //     // ddd(Devices::where('uuid', $uuid)->get());
    //     $device = Devices::where('uuid', $uuid)->first();
    //     $data = [
    //         'title' => 'Devices',
    //         'breadcrumb' => 'Device',
    //         'subtitle' => $device->name
    //     ];
    //     return view('devices.device', $data);
    // }

    public function renderChart($device_id, $parameters, $requested_range, $from, $to)
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

        $gauge_options2 = [
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

        $line_options = [
            'tooltip' => [
                'trigger' => 'axis',
                'show' => true
            ],
            // 'grid' => [
            //     'left' => '3%',
            //     'right' => '4%',
            //     'bottom' => '3%',
            //     'containLabel' => true
            // ],
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
                // 'inverse' => true
            ],
            'yAxis' => [
                'type' => 'value',
                'boundaryGap' => [0, '100%']
            ],
            'dataZoom' => [
                [
                    'type' => 'slider',
                    // 'start' => 0,
                    // 'end' => 100
                ],
                // [
                //     'start' => 0,
                //     'end' => 20
                // ]
            ],
            // 'visualMap' => [
            //     'show' => true,
            //     'type' => 'piecewise',
            //     'seriesIndex' => 0,
            //     'min' => 200,
            //     'max' => 400,
            //     // 'inRange' => [
            //     //     'color' => ['#F49D1A', '#54B435', '#DC3535'],
            //     // ]
            //     'pieces' => [
            //         //     [0.7, '#F49D1A'],
            //         //     [0.8, '#54B435'],
            //         //     [1, '#DC3535']
            //         [
            //             'gt' => 0,
            //             'lte' => 200,
            //             'color' => '#45C4B0'
            //         ],
            //         [
            //             'gt' => 200,
            //             'lte' => 300,
            //             'color' => '#13678A'
            //         ],
            //         [
            //             'gt' => 300,
            //             'lte' => 500,
            //             'color' => '#012030'
            //         ]
            //     ]
            // ]

            // 'dimensions' => [
            //     null, // use null if you do not want dimension name.
            //     'amount',
            //     ['name' => 'product', 'type' => 'time']
            // ]
        ];

        $charts_gauge = [];
        $charts_line = [];
        // $parameters_log_ranged = [];
        // $table_ = 'device_' . $device_id . '_log';
        // dd($table_);
        // $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $device_id . '_log']);
        // if ($from && $to) {
        //     $from = date("Y-m-d H:i:s", $from / 1000);
        //     $to = date("Y-m-d H:i:s", $to / 1000);
        //     $parameters_log_ranged = $parameters_log->where([
        //         ['created_at', '>=', $from], ['created_at', '<=', $to]
        //     ])->latest()->get();
        // } else {
        //     $parameters_log_ranged = $parameters_log->where('created_at', '>=', Carbon::now()->subDays($requested_range))->latest()->get();
        // }
        foreach ($parameters as $parameter) {
            // $first_log = $parameters_log_ranged->first() ?: 0;
            $chart_gauge = new NumberParametersChart;
            $chart_gauge->dataset('', 'gauge', [NULL])
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
            array_push($charts_gauge, $chart_gauge);
            $chart_line = new NumberParametersChart;
            $chart_line->dataset('', 'line', [NULL, NULL])->options([
                'smooth' => true,
                // 'step' => 'start',
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
                // 'markPoint' => [
                //     'data' => [
                //         ['type' => 'max', 'name' => 'Max', 'itemStyle' => ['color' => 'blue']],
                //         ['type' => 'min', 'name' => 'Min', 'itemStyle' => ['color' => 'green']]
                //     ]
                // ],
            ]);
            $chart_line->options($line_options);
            array_push($charts_line, $chart_line);
        }
        $data = [
            'charts_gauge' => $charts_gauge,
            'charts_line' => $charts_line
        ];
        return $data;
    }
}
