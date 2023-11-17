<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class APIDashboardController extends Controller
{
    //
    public function get_dashboards()
    {
        $access = Auth::user()->access;
        $dashboards = [];
        if (sizeof($access) > 0) {
            foreach ($access as $dashboard_list) {
                $dashboard = Dashboard::find($dashboard_list->dashboard_id);
                array_push($dashboards, $dashboard);
            }
        }
        return response()->json($dashboards, 200);
        // return view('user.index', [
        //     'title' => 'Home',
        //     'breadcrumb' => 'Home',
        //     'subtitle' => 'test',
        //     'dashboards' => $dashboards,
        //     'access' => $access
        // ]);
    }
    public function get_panels(Dashboard $dashboard)
    {
        try {
            $access = collect(Auth::user()->access);
            $dashboard_access = $access->where('dashboard_id', $dashboard->id);
            if (sizeof($dashboard_access) > 0) {
                $dashboard = $dashboard->load(['panels' => function ($panels) {
                    $panels->orderBy('order', 'ASC');
                    $panels->with(['parameter']);
                }]);
                // $charts = $dashboard->panels->map(
                //     function ($panel) {
                //         if ($panel->parameter) {
                //             return $this->renderGauge($panel->parameter);
                //         }
                //     }
                // );
                $dashboards = [];
                if (sizeof($access) > 0) {
                    foreach ($access as $dashboard_list) {
                        $_dashboard = Dashboard::find($dashboard_list->dashboard_id);
                        array_push($dashboards, $_dashboard);
                    }
                }
                return response()->json($dashboard, 200);
                // return view('user.dashboard', [
                //     'title' => 'Home',
                //     'breadcrumb' => 'Dashboard',
                //     'subtitle' => 'test',
                //     'dashboard' => $dashboard,
                //     'charts' => $charts,
                //     'access' => $access,
                //     'dashboards' => $dashboards
                // ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Restricted Access'
                ], 400);
            }
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to get panels, ' . $e->getMessage()
            ], 400);
        }
    }
}
