<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('login.index');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->hasRole('Admin')) {
                return redirect('/admin-panel');
            } else {
                return redirect('/');
            }
        }
        return back()->with('loginError', 'Login failed!');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function showAccount()
    {
        $data = [];
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $data = [
                'title' => 'Home',
                'breadcrumb' => 'Account'
            ];
        } else {
            $access = Auth::user()->access;
            $dashboards = [];
            if (sizeof($access) > 0) {
                $dashboard = Dashboard::find($access[0]->dashboard_id);
                array_push($dashboards, $dashboard);
            }
            $data = [
                'title' => 'Home',
                'breadcrumb' => 'Account',
                'dashboards' => $dashboards
            ];
        }


        return view('account.index', $data);
    }

    public function updatePassword(Request $request)
    {
        # Validation
        // dd($request);
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        // dd($request);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
}
