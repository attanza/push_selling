<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Area;
use App\Models\Market;
use App\Models\Stokiest;
use App\Models\Item;
use App\Models\Outlet;
use App\Models\SellerTarget;
use App\Models\Transaction;
use Excel;
use Auth;
use Carbon\Carbon;
use Validator;

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
        $role = Auth::user()->roles()->first()->slug;
        if ($role == 'seller') {
            $outlets = Outlet::with('market', 'detail')
            ->whereHas('detail', function ($query) {
                $query->where('seller_id', Auth::id());
            })->get();
        } else {
            $outlets = Outlet::with('market', 'detail')->get();
        }

        Excel::create('Outlets', function ($excel) use ($outlets) {
            $excel->sheet('Outlets', function ($sheet) use ($outlets) {
                $sheet->mergeCells('A1:N1');
                $sheet->loadView('exports.outlet')->with('outlets', $outlets);
            });
        })->download('xlsx');
        return redirect()->back()->withSuccess('Data Exported');
    }

    public function exportSellerTarget()
    {
        $seller_targets = SellerTarget::with('seller', 'item', 'creator')->orderBy('created_at')->get();
        Excel::create('SellerTargets', function ($excel) use ($seller_targets) {
            $excel->sheet('SellerTargets', function ($sheet) use ($seller_targets) {
                $sheet->mergeCells('A1:I1');
                $sheet->loadView('exports.seller_target')->with('seller_targets', $seller_targets);
            });
        })->download('xlsx');
        return redirect()->back()->withSuccess('Data Exported');
    }

    public function exportTransaction(Request $request, $dates)
    {
        // convert strinf to array
        $array_dates = explode(',', $dates);
        $date_data = [
            'start_date' => $array_dates[0],
            'end_date' => $array_dates[1],
        ];
        // Validate Date Data
        $validator = Validator::make($date_data, [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        // if validation fails return to transaction index page
        if ($validator->fails()) {
            return redirect('/transaction')
                ->withError($validator->errors());
        }
        // parse with carbon
        $start_date = Carbon::parse($date_data['start_date'])->format('Y-m-d');
        $end_date = Carbon::parse($date_data['end_date'])->format('Y-m-d');

        // Detect user role
        $role = Auth::user()->roles()->first()->slug;
        if ($role == 'seller') {
            $transactions = Transaction::whereBetween('created_at', [$start_date, $end_date])
                ->where('seller_id', Auth::id())
                ->orderBy('created_at')
                ->get();
        } else {
            $transactions = Transaction::whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('created_at')
                ->get();
        }

        Excel::create('Transactions', function ($excel) use ($transactions) {
            $excel->sheet('Transactions', function ($sheet) use ($transactions) {
                $sheet->mergeCells('A1:J1');
                $sheet->loadView('exports.transaction')->with('transactions', $transactions);
            });
        })->download('xlsx');
        // return redirect()->back()->withSuccess('Data Exported');
        return new Response($file, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $file->filename . '.' . $file->ext . '"',
            'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT', // Date in the past
            'Last-Modified' => Carbon::now()->format('D, d M Y H:i:s'),
            'Cache-Control' => 'cache, must-revalidate',
            'Pragma' => 'public',
        ]);
    }


    public function exportTransactionPdf($code)
    {
        $transaction = Transaction::where('code', $code)->first();
        if (count($transaction) < 1) {
            return redirect('/transaction')->withError('Transaction not found');
        }
        // return $transaction->outlet->market->area->stokiest;
        $stokiest = $transaction->outlet->market->area->stokiest;
        $market = $transaction->outlet->market;
        $today = Carbon::now();
        // return view('exports.transactionPdf')->with([
        //   'transaction' => $transaction,
        //   'stokiest' => $stokiest,
        //   'today' => $today,
        //   'market' => $market,
        // ]);
        Excel::create('Transactions', function ($excel) use ($transaction, $stokiest, $market, $today) {
            $excel->sheet('Transactions', function ($sheet) use ($transaction, $stokiest, $market, $today) {
                $sheet->loadView('exports.transactionPdf')->with($transaction, $stokiest, $market, $today);
            });
        })->download('xlsx');
    }
}
