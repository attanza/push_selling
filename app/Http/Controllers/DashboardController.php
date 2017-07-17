<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->roles->first()->slug;
        if ($role == 'admin') {
            return view('dashboards.admin_dashboard');
        } else {
            return view('dashboards.other_dashboard');
        }
    }
}
