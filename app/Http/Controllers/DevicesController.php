<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use App\Models\Parameters;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use LaracraftTech\LaravelDynamicModel\DynamicModel;
use Illuminate\Support\Str;
use App\Charts\NumberParametersChart;
use SebastianBergmann\Type\NullType;
use Illuminate\Support\Carbon;

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
            'devices' => Devices::latest()->filter(request(['search']))->paginate(10)->withQueryString()
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
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024',
            'description' => 'max:1024|required'
        ]);
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
        $data = [
            'title' => 'Devices',
            'breadcrumb' => 'Device',
            'subtitle' => $device->name,
            'device' => $device,
            // 'parameters' => Parameters::where('device_id', $device->id),
            'parameters' => $parameters,
            'parameters_number' => $parameters_number,
            'range' => (int)$request->input('range') ?: 1
            // 'charts' => $this->renderChart($device->id, $parameters_number)
            // 'alerts' => $alert_log->paginate(10)->withQueryString()
        ];
        // dd($parameters_number);
        $range = 1;
        $range = (int)$request->input('range') ?: $range;
        if ($parameters_number) {
            $data['charts'] = $this->renderChart($device->id, $parameters_number, $range);
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
            'device' => $device
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
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024',
            'description' => 'max:1024'
        ]);
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
    public function destroy($id)
    {
        //
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

    public function renderChart($device_id, $parameters, $requested_range)
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
                    'start' => 0,
                    'end' => 100
                ],
                // [
                //     'start' => 0,
                //     'end' => 20
                // ]
            ],

            // 'dimensions' => [
            //     null, // use null if you do not want dimension name.
            //     'amount',
            //     ['name' => 'product', 'type' => 'time']
            // ]
        ];

        $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $device_id . '_log']);
        $charts_gauge = [];
        $charts_line = [];
        $first_log = $parameters_log->latest()->first() ?: 0;
        // $parameters_log_ranged = $parameters_log->where('created_at', '>=', Carbon::now()->subDay())->get();
        $parameters_log_ranged = $parameters_log->where('created_at', '>=', Carbon::now()->subDays($requested_range))->latest()->get();
        // dd($parameters_log_ranged);
        foreach ($parameters as $parameter) {
            $chart_gauge = new NumberParametersChart;
            $chart_gauge->dataset('', 'gauge', [$first_log ? $first_log->{$parameter->slug} : NULL])
                ->options([
                    'detail' => [
                        'formatter' => '{value} ' . $parameter->unit,
                    ]
                ])
                ->options($gauge_options);
            array_push($charts_gauge, $chart_gauge);
            $chart_line = new NumberParametersChart;
            $chart_line->dataset('', 'line', $first_log ? $parameters_log_ranged->map(function ($query) use ($parameter) {
                return [$query->created_at, $query->{$parameter->slug}];
            }) : [NULL, NULL])->options([
                'smooth' => true,
                'markPoint' => [
                    'data' => [
                        ['type' => 'max', 'name' => 'Max', 'itemStyle' => ['color' => 'red']],
                        ['type' => 'min', 'name' => 'Min', 'itemStyle' => ['color' => 'orange']]
                    ]
                ],
                // 'markLine' => [
                //     'data' => [['type' => 'average', 'name' => 'Avg']]
                // ]
            ]);
            $chart_line->options($line_options);
                // $chart_line->options([
                //     'xAxis' => [
                //         'data' => $first_log ? $parameters_log_ranged->map(function ($query) {
                //             return $query->created_at;
                //         })->toArray() : 0
                //     ],
                // ])
            ;

            array_push($charts_line, $chart_line);
        }
        $data = [
            'charts_gauge' => $charts_gauge,
            'charts_line' => $charts_line
        ];
        return $data;
    }
}
