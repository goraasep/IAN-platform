<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    //
    // need to show:
    // -dashboards
    // -devices
    // -parameters
    // -users

    public function index()
    {
        return view('admin.index', [
            'title' => 'Home',
            'breadcrumb' => 'Admin Panel',
            'subtitle' => 'test',
        ]);
    }
}
