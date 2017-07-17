<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class DashboardUtilityController extends Controller
{
    public function getUserCount()
    {
        if (Auth::user()->roles()->first()->slug == 'admin') {
            $user = User::select('id')->get()->count();
            return response()->json([
              'user_count' => $user
            ], 200);
        } else {
            return response()->json([
              'msg' => 'Forbidden Request'
            ], 403);
        }
    }
}
