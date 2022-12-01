<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Parameters;
use App\Models\Sites;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.index', [
            'title' => 'Home',
            'breadcrumb' => 'Dashboard',
            'subtitle' => 'test',
            'sites_count' => Sites::count(),
            'devices_count' => Devices::count(),
            'parameters_count' => Parameters::count()
        ]);
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
    public function update(Request $request, $id)
    {
        //
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

    //custom
    public function siteMap(Request $request)
    {
        //
        $sites = Sites::all();
        $arrJson = [];
        foreach ($sites as $site) {
            $data = [
                'location' => [
                    'lat' => $site->lat,
                    'lng' => $site->lng
                ],
                'url' => url('sites/' . $site->slug),
                'contentData' => $site->name
            ];
            array_push($arrJson, $data);
        }
        return response()->json($arrJson);
    }
}
