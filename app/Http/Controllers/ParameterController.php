<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameters;
use App\Models\Devices;
use Illuminate\Support\Facades\Schema;
use \Cviebrock\EloquentSluggable\Services\SlugService;
// use Exception;
// use Illuminate\Support\Facades\App;
// use LaracraftTech\LaravelDynamicModel\DynamicModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        $rules = [];
        if ($request->type == 'string') {
            $rules = [
                'name' => 'required|max:255',
                'type' => 'required|max:255',
                'show' => 'required'
            ];
        } elseif ($request->type == 'number') {
            $rules = [
                'name' => 'required|max:255',
                'unit' => 'max:255',
                'type' => 'required|max:255',
                'th_H' => 'required',
                'th_H_enable' => 'required',
                'th_L' => 'required',
                'th_L_enable' => 'required',
                'max' => 'required',
                'min' => 'required',
                'show' => 'required'
            ];
        } elseif ($request->type == 'special') {
            $rules = [
                'name' => 'required|max:255',
                'type' => 'required|max:255',
                'base_parameter' => 'required',
                'operator' => 'required',
                'condition_value' => 'required',
                'condition_rule' => 'required',
                'show' => 'required'
            ];
        }

        $validatedData = $request->validate($rules);
        // ddd($request);
        $slug = SlugService::createSlug(Parameters::class, 'slug', $validatedData['name']);
        $validatedData['slug'] = $slug;
        $device_id = Devices::where('uuid', $request['uuid'])->first()->id;
        $validatedData['device_id'] = $device_id;
        Parameters::create($validatedData);
        if ($request->type != 'special') {
            Schema::table('device_' . $device_id . '_log', function ($table) use ($validatedData) {
                if ($validatedData['type'] == 'number') {
                    $table->double($validatedData['slug'])->default(0);
                } elseif ($validatedData['type'] == 'string') {
                    $table->string($validatedData['slug'])->nullable();
                }
            });
        }
        return redirect()->back()->with('success', 'New post has been added!');
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
        $rules = [];
        if ($request->type == 'string') {
            $rules = [
                'type' => 'required|max:255',
                'show' => 'required'
            ];
        } elseif ($request->type == 'number') {
            $rules = [
                'unit' => 'max:255',
                'type' => 'required|max:255',
                'th_H' => 'required',
                'th_H_enable' => 'required',
                'th_L' => 'required',
                'th_L_enable' => 'required',
                'max' => 'required',
                'min' => 'required',
                'show' => 'required'
            ];
        } elseif ($request->type == 'special') {
            $rules = [
                'type' => 'required|max:255',
                'base_parameter' => 'required',
                'operator' => 'required',
                'condition_value' => 'required',
                'condition_rule' => 'required',
                'show' => 'required'
            ];
        }

        $validatedData = $request->validate($rules);
        $affected_row = Parameters::where('slug', $slug)->update($validatedData);
        if ($affected_row) {
            return redirect()->back()->with('success', 'Success!');
        }
        return redirect()->back()->with('failed', 'Failed!');
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
        return redirect()->back()->with('success', 'Success!');
    }

    //custom function
    public function liveDataOnce(Request $request)
    {
        $range = (int)$request->input('range') ?: 1;
        $from = $request->input('from');
        $to = $request->input('to');
        $parameters_log_ranged = [];
        // $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $request->device_id . '_log']);
        $parameters_log = DB::table('device_' . $request->device_id . '_log');
        if ($from && $to) {
            $from = date("Y-m-d H:i:s", $request->input('from') / 1000);
            $to = date("Y-m-d H:i:s", $request->input('to') / 1000);
            $parameters_log_ranged = $parameters_log->where([
                ['created_at', '>=', $from], ['created_at', '<=', $to]
            ])->get();
        } else {
            $parameters_log_ranged = $parameters_log->where('created_at', '>=', Carbon::now()->subDays($range))->get();
        }
        $value = $parameters_log_ranged->last() ?: 0;

        return json_encode(['value' => $value, 'log' => $parameters_log_ranged, 'special' => $this->liveDataSpecial($request)]);
    }
    public function liveData(Request $request)
    {
        $range = (int)$request->input('range') ?: 1;
        $from = $request->input('from');
        $to = $request->input('to');
        $parameters_log_ranged = [];
        // $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $request->device_id . '_log']);
        $parameters_log = DB::table('device_' . $request->device_id . '_log');
        if ($from && $to) {
            $from = date("Y-m-d H:i:s", $request->input('from') / 1000);
            $to = date("Y-m-d H:i:s", $request->input('to') / 1000);
            $parameters_log_ranged = $parameters_log->where([
                ['created_at', '>=', $from], ['created_at', '<=', $to]
            ])->latest();
        } else {
            $parameters_log_ranged = $parameters_log->where('created_at', '>=', Carbon::now()->subDays($range))->latest();
        }
        $value = $parameters_log_ranged->first() ?: 0;

        return json_encode(['value' => $value]);
    }
    public function liveDataSpecial($request)
    {
        $range = (int)$request->input('range') ?: 1;
        $from = $request->input('from');
        $to = $request->input('to');
        $parameters_log_ranged = [];
        // $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $request->device_id . '_log']);
        $parameters_log = DB::table('device_' . $request->device_id . '_log');
        if ($from && $to) {
            $from = date("Y-m-d H:i:s", $request->input('from') / 1000);
            $to = date("Y-m-d H:i:s", $request->input('to') / 1000);
            $parameters_log_ranged = $parameters_log->where([
                ['created_at', '>=', $from], ['created_at', '<=', $to]
            ])->latest();
        } else {
            $parameters_log_ranged = $parameters_log->where('created_at', '>=', Carbon::now()->subDays($range))->latest();
        }

        //need to process here
        $special_parameter = Parameters::where('type', 'special')->get();
        $result = [];
        foreach ($special_parameter as $parameter) {
            // $parameters_log_ranged->where($parameter->base_parameter,$parameter->operator,$parameter->condition_value)->first()->{$parameter->base_parameter}
            $buffer = $parameters_log_ranged->where($parameter->base_parameter, $parameter->operator, $parameter->condition_value);
            // dd($buffer);
            switch ($parameter->condition_rule) {
                case "first":
                    $result[$parameter->slug] = $buffer->get()->sortBy('created_at')->first()->{$parameter->base_parameter};

                    // dd($result[$parameter->slug]);
                    break;
                case "last":
                    $result[$parameter->slug] = $buffer->get()->sortByDesc('created_at')->first()->{$parameter->base_parameter};
                    break;
                case "count":
                    $result[$parameter->slug] = $buffer->get()->count();
                    break;
                    // case "count_group":
                    //     $result[$parameter->slug] = $buffer->get()->count();
                    // $buffer->groupBy($parameter->base_parameter)->count();
                    // break;
                case "max":
                    $result[$parameter->slug] = $buffer->max($parameter->base_parameter);
                    break;
                case "min":
                    $result[$parameter->slug] = $buffer->min($parameter->base_parameter);
                    break;
                case "average":
                    $result[$parameter->slug] = $buffer->average($parameter->base_parameter);
                    break;
                case "sum":
                    $result[$parameter->slug] = $buffer->sum($parameter->base_parameter);
                    break;
                case "difference":
                    $result[$parameter->slug] = $buffer->get()->sortByDesc('created_at')->first()->{$parameter->base_parameter} - $buffer->get()->sortBy('created_at')->first()->{$parameter->base_parameter};
                    // dd($result[$parameter->slug]);
                    break;
                default:
                    $result[$parameter->slug] = NULL;
            }
            // $result[$parameter->slug] = $buffer->first()->{$parameter->base_parameter};

            //if parameter->
        }

        // dd($special_parameter);
        // $value = $parameters_log_ranged->first() ?: 0;
        // dd($result);
        return $result;
    }
    public function liveDataOverview(Request $request)
    {
        // $parameters_log_ranged = [];
        // $parameters_log = App::make(DynamicModel::class, ['table_name' => 'device_' . $request->device_id . '_log']);
        $parameters_log = DB::table('device_' . $request->device_id . '_log');
        $value = $parameters_log->latest()->first() ?: 0;

        return json_encode(['value' => $value]);
    }
}
