<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Panel;
use Illuminate\Http\Request;
use Throwable;

class PanelController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'panel_name' => 'required|max:255',
                'parameter_id' => 'required|integer',
                'dashboard_id' => 'required|integer',
                'size' => 'required|integer',
                'order' => 'required|integer',
            ]);
            Panel::create($validatedData);
            alert()->success('Success', 'New panel has been added!');
            return back()->with('success', 'New Panel has been added!');
        } catch (Throwable $e) {
            alert()->warning('Failed', "Add panel failed, " . $e->getMessage());
            return back()->with('failed', "Add panel failed, " . $e->getMessage());
        }
    }
    public function update(Request $request, Panel $panel)
    {
        try {
            $validatedData = $request->validate([
                'panel_name' => 'required|max:255',
                'parameter_id' => 'required|integer',
                'size' => 'required|integer',
                'order' => 'required|integer',
            ]);
            Panel::where('id', $panel->id)->update($validatedData);
            alert()->success('Success', 'Edit panel success!');
            return back()->with('success', "Edit panel success");
        } catch (Throwable $e) {
            alert()->warning('Failed', "Edit panel failed, " . $e->getMessage());
            return back()->with('failed', "Edit panel failed, " . $e->getMessage());
        }
    }

    public function destroy(Panel $panel)
    {
        //
        try {
            Panel::where('id', $panel->id)->delete();
            alert()->success('Success', 'Delete panel success!');
            return back()->with('success', "Delete panel success");
        } catch (Throwable $e) {
            alert()->warning('Failed', "Delete panel failed, " . $e->getMessage());
            return back()->with('failed', "Delete panel failed, " . $e->getMessage());
        }
    }
}
