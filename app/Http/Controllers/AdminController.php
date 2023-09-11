<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//delete this later
class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.index', [
            'title' => 'Home',
            'breadcrumb' => 'Admin Panel',
            'subtitle' => 'test',
        ]);
    }
}
