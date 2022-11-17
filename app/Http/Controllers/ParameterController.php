<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameters;
use App\Models\Devices;
use Illuminate\Support\Facades\Schema;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\App;
use LaracraftTech\LaravelDynamicModel\DynamicModel;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 'hehe';
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'unit' => 'max:255',
            'type' => 'required|max:255',
            'th_H' => 'required',
            'th_H_enable' => 'required',
            'th_L' => 'required',
            'th_L_enable' => 'required',
        ]);
        $slug = SlugService::createSlug(Parameters::class, 'slug', $validatedData['name']);
        $validatedData['slug'] = $slug;
        $device_id = Devices::where('uuid', $request['uuid'])->first()->id;
        $validatedData['device_id'] = $device_id;
        Parameters::create($validatedData);

        Schema::table('device_' . $device_id . '_log', function ($table) use ($validatedData) {
            if ($validatedData['type'] == 'number') {
                $table->double($validatedData['slug'])->default(0);
            } elseif ($validatedData['type'] == 'string') {
                $table->string($validatedData['slug'])->nullable();
            }
        });
        return redirect('/devices/' . $request['uuid'])->with('success', 'New post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
        $validatedData = $request->validate([
            'unit' => 'max:255',
            'th_H' => 'required',
            'th_H_enable' => 'required',
            'th_L' => 'required',
            'th_L_enable' => 'required',
        ]);
        // $device_id = Devices::where('uuid', $request['uuid'])->first()->id;
        Parameters::where('slug', $slug)->update($validatedData);
        return redirect('/devices/' . $request['uuid'])->with('success', 'Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        //
        $device_id = Devices::where('uuid', $request['uuid'])->first()->id;
        Parameters::where('slug', $slug)->delete();
        Schema::table('device_' . $device_id . '_log', function ($table) use ($slug) {
            $table->dropColumn($slug);
        });
        return redirect('/devices/' . $request['uuid'])->with('success', 'Post has been updated!');
    }

    //custom function
    public function liveData(Request $request)
    {
        // $request->slug
        $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $request->device_id . '_log'])->latest();
        $value = $parameters_log->first() ?: 0;
        return json_encode(['value' => $value, 'log' => $parameters_log->take(20)->get()]);
    }
}
