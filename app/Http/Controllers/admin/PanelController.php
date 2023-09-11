<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Panel;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    //
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'panel_name' => 'required|max:255',
            'parameter_id' => 'required|integer',
            'dashboard_id' => 'required|integer',
            // 'type' => 'required|max:255',
            'size' => 'required|integer',
            'order' => 'required|integer',
        ]);
        Panel::create($validatedData);
        return back()->with('success', 'New site has been added!');
    }
}
