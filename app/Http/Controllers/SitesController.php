<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sites;
use Illuminate\Support\Facades\Storage;

class SitesController extends Controller
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
            'title' => 'Sites',
            'breadcrumb' => 'List',
            'sites' => Sites::latest()->filter(request(['search']))->paginate(10)->withQueryString()
        ];
        return view('sites.index', $data);
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
        // $attribute = array(
        //     'lng' => 'longitude',
        //     'lat' => 'latitude',
        // );
        // $validator = Validator::make ( Input::all (), $rules );
        // $validator->setAttributeNames($attribute);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024',
            'description' => 'max:1024|required',
            'lng' => 'required',
            'lat' => 'required'
        ]);
        if (array_key_exists('image', $validatedData)) {
            $filename = $validatedData['image']->hashName();
            $validatedData['image']->storeAs(
                'public/images',
                $filename
            );
            $validatedData['image'] = $filename;
        }
        Sites::create($validatedData);
        return redirect('/sites')->with('success', 'New site has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sites $site, Request $request)
    {
        //
        $data = [
            'title' => 'Sites',
            'breadcrumb' => 'Site',
            'subtitle' => $site->name,
            'site' => $site
        ];
        return view('sites.site', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Sites $site)
    {
        //
        $data = [
            'title' => 'Sites',
            'breadcrumb' => 'Site',
            'subtitle' => $site->name,
            'site' => $site
        ];
        // dd($data);
        return view('sites.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sites $site)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024',
            'description' => 'max:1024',
            'lng' => 'required',
            'lat' => 'required'
        ]);
        if (array_key_exists('image', $validatedData)) {
            Storage::delete('/public/images/' . $site->image);
            $filename = $validatedData['image']->hashName();
            $validatedData['image']->storeAs(
                'public/images',
                $filename
            );
            $validatedData['image'] = $filename;
        }
        // ddd($request);
        Sites::where('slug', $site->slug)->update($validatedData);
        return redirect('/sites/' . $site->slug . '/edit')->with('success', 'Success!');
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
        $site = Sites::where('slug', $request['slug'])->first();
        Storage::delete('/public/images/' . $site->image);
        Sites::where('slug', $request['slug'])->delete();
        // Schema::table('device_' . $device_id . '_log', function ($table) use ($slug) {
        //     $table->dropColumn($slug);
        // });
        return redirect('/sites')->with('success', 'Success!');
    }
}
