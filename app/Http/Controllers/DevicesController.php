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
    public function show(Devices $device)
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
        $data = [
            'title' => 'Devices',
            'breadcrumb' => 'Device',
            'subtitle' => $device->name,
            'device' => $device,
            // 'parameters' => Parameters::where('device_id', $device->id),
            'parameters' => Parameters::where('device_id', $device->id)->get()
            // 'alerts' => $alert_log->paginate(10)->withQueryString()
        ];
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

}
