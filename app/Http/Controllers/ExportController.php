<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Area;
use App\Models\Market;
use App\Models\Stokiest;
use App\Models\Item;
use App\Models\Outlet;
use Excel;

class ExportController extends Controller
{
    public function exportUser()
    {
        $users = User::with('detail')->get();
        Excel::create('Users', function ($excel) use ($users) {
            $excel->sheet('Users', function ($sheet) use ($users) {
                $sheet->mergeCells('A1:G1');
                $sheet->loadView('exports.user')->with('users', $users);
            });
        })->download('xlsx');
        return redirect()->back()->withSuccess('Data Exported');
    }

    public function exportArea()
    {
        $areas = Area::all();
        Excel::create('Areas', function ($excel) use ($areas) {
            $excel->sheet('Areas', function ($sheet) use ($areas) {
                $sheet->mergeCells('A1:C1');
                $sheet->loadView('exports.area')->with('areas', $areas);
            });
        })->download('xlsx');
        return redirect()->back()->withSuccess('Data Exported');
    }

    public function exportMarket()
    {
        $markets = Market::with('area')->get();
        Excel::create('Markets', function ($excel) use ($markets) {
            $excel->sheet('Markets', function ($sheet) use ($markets) {
                $sheet->mergeCells('A1:E1');
                $sheet->loadView('exports.market')->with('markets', $markets);
            });
        })->download('xlsx');
        return redirect()->back()->withSuccess('Data Exported');
    }

    public function exportStokiest()
    {
        $stokiests = Stokiest::with('area')->get();
        Excel::create('Stokiests', function ($excel) use ($stokiests) {
            $excel->sheet('Stokiests', function ($sheet) use ($stokiests) {
                $sheet->mergeCells('A1:L1');
                $sheet->loadView('exports.stokiest')->with('stokiests', $stokiests);
            });
        })->download('xlsx');
        return redirect()->back()->withSuccess('Data Exported');
    }

    public function exportItem()
    {
        $items = Item::all();
        Excel::create('Items', function ($excel) use ($items) {
            $excel->sheet('Items', function ($sheet) use ($items) {
                $sheet->mergeCells('A1:I1');
                $sheet->loadView('exports.item')->with('items', $items);
            });
        })->download('xlsx');
        return redirect()->back()->withSuccess('Data Exported');
    }

    public function exportOutlet()
    {
        $outlet = Outlet::all();
        Excel::create('Outlets', function ($excel) use ($outlet) {
            $excel->sheet('Outlets', function ($sheet) use ($outlet) {
                $sheet->mergeCells('A1:L1');
                $sheet->loadView('exports.outlet')->with('outlets', $outlet);
            });
        })->download('xlsx');
        return redirect()->back()->withSuccess('Data Exported');
    }
}
