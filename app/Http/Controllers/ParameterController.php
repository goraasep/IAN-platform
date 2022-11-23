<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameters;
use App\Models\Devices;
use Illuminate\Support\Facades\Schema;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Support\Facades\App;
use LaracraftTech\LaravelDynamicModel\DynamicModel;
use Illuminate\Support\Carbon;

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
            'max' => 'required',
            'min' => 'required',
        ]);
        // ddd($request);
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
            'max' => 'required',
            'min' => 'required'
        ]);
        $affected_row = Parameters::where('slug', $slug)->update($validatedData);
        if ($affected_row) {
            return redirect('/devices/' . $request['uuid'])->with('success', 'Success!');
        }
        return redirect('/devices/' . $request['uuid'])->with('failed', 'Failed!');
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
        return redirect('/devices/' . $request['uuid'])->with('success', 'Success!');
    }

    //custom function
    public function liveData(Request $request)
    {
        $range = (int)$request->input('range') ?: 1;
        $from = $request->input('from');
        $to = $request->input('to');
        $parameters_log_ranged = [];
        $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $request->device_id . '_log']);
        if ($from && $to) {
            $from = date("Y-m-d H:i:s", $request->input('from') / 1000);
            $to = date("Y-m-d H:i:s", $request->input('to') / 1000);
            $parameters_log_ranged = $parameters_log->where([
                ['created_at', '>=', $from], ['created_at', '<=', $to]
            ])->latest()->get();
        } else {
            $parameters_log_ranged = $parameters_log->where('created_at', '>=', Carbon::now()->subDays($range))->latest()->get();
        }
        $value = $parameters_log_ranged->first() ?: 0;

        return json_encode(['value' => $value, 'log' => $parameters_log_ranged]);
    }
}
