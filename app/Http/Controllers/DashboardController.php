<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Market;
use App\Models\Stokiest;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->roles->first()->slug;
        if ($role == 'admin') {
            return view('dashboards.admin_dashboard')->with([
              'market_maps' => $this->getMarketMap(),
              'stokiest_maps' => $this->getStokiestMap()
            ]);
        } elseif ($role == 'supervisor') {
            return view('dashboards.supervisor_dashboard');
        } elseif ($role == 'seller') {
            return view('dashboards.seller_dashboard');
        } else {
            return view('dashboards.other_dashboard');
        }
    }

    private function getMarketMap()
    {
        $data = Market::select('lat', 'lng')->get();
        return $data;
    }

    private function getStokiestMap()
    {
        $data = Stokiest::select('lat', 'lng')->get();
        return $data;
    }
}
