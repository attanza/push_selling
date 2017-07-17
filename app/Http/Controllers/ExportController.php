<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Area;
use App\Models\Market;

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
}
