<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Transaction;
use App\Models\OutletSeller;
use App\Traits\GlobalTrait;
use Auth;
use App\Http\Requests\StoreTransactionRequest;
use Mail;
use App\Mail\NewTransactionMail;
use App\Mail\TransactionAfterVerificationMail;
use App\Mail\TransactionSendOrderToStokiestMail;
use Carbon\Carbon;

class TransactionController extends Controller
{
    use GlobalTrait;

    public function index()
    {
        return view('seller.transaction.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $transactions = $this->getSearchQuery($request);
        } else {
            $transactions = $this->getQuery($request);
        }
        $response = [
            'pagination' => [
                'total' => $transactions->total(),
                'per_page' => $transactions->perPage(),
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'from' => $transactions->firstItem(),
                'to' => $transactions->lastItem()
            ],
            'transactions' => $transactions
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function create()
    {
        $role = Auth::user()->getRole();
        if ($role != 'seller') {
            return redirect('/transaction')->withError('Request not allowed');
        }

        $selectData = $this->getItemOutletData();
        return view('seller.transaction.create')->with([
          'items' => $selectData['items'],
          'outlets' => $selectData['outlets'],
        ]);
    }

    public function store(StoreTransactionRequest $request)
    {
        // Save data
        $transaction = Transaction::create($request->all());
        // Save Activity
        $activity = "Submit a Transaction ~ $transaction->code";
        $this->saveActivity($request, $activity);
        // Send Email
        $this->sendNewTransactionMail($transaction);
        // Return
        return response()->json(1, 200);
    }

    public function show($code)
    {
        $transaction = Transaction::where('code', $code)->first();
        if (count($transaction) < 1) {
            return redirect('/transaction')->withError('Transaction not found');
        }
        // return $transaction->outlet->market->area->stokiest;
        $stokiest = $transaction->outlet->market->area->stokiest;
        $market = $transaction->outlet->market;
        $today = $transaction->verified_at;
        $selectData = $this->getItemOutletData();

        return view('seller.transaction.show')->with([
            'transaction' => $transaction,
            'stokiest' => $stokiest,
            'today' => $today,
            'market' => $market,
            'item_data' => $selectData['items'],
            'outlet_data' => $selectData['outlets'],
        ]);
    }

    public function update(StoreTransactionRequest $request, $id)
    {
        // Find transaction
        $transaction = Transaction::find($id);
        if (count($transaction) < 1) {
            return response()->json([
                'msg' => 'Transaction not found'
            ], 404);
        }
        // Check if this transaction created by current Seller
        if ($transaction->seller_id != Auth::id()) {
            return response()->json([
                'msg' => 'Forbidden request'
            ], 403);
        }
        // Update Transaction data
        $transaction->update($request->all());
        // Save Activity
        $activity = "Submit a Transaction ~ $transaction->code";
        $this->saveActivity($request, $activity);
        // Return
        return response()->json([
          'transaction' => $transaction
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        // Find Transaction
        $transaction = Transaction::find($id);
        if (count($transaction) < 1) {
            return response()->json([
                'msg' => 'Transaction not found'
            ], 404);
        }
        // Check verified
        if ($transaction->verified) {
            return response()->json([
                'msg' => 'This transaction is already verified'
            ], 403);
        }
        // save activity
        $activity = "Delete transaction ~ $transaction->code";
        $this->saveActivity($request, $activity);
        // Delete Transaction
        $transaction->delete();
        // return
        return response()->json([
            'msg' => 'Transaction deleted'
        ], 200);
    }

    public function setVerified(Request $request, $id)
    {
        // Find Transaction
        $transaction = Transaction::find($id);
        if (count($transaction) < 1) {
            return response()->json([
                'msg' => 'Transaction not found'
            ], 404);
        }
        // Check Role
        $role = Auth::user()->getRole();
        if ($role != 'supervisor') {
            return response()->json([
                'msg' => 'Request not allowed'
            ], 403);
        }
        // Check verified
        if ($transaction->verified) {
            return response()->json([
                'msg' => 'This transaction is already verified'
            ], 403);
        }
        // Set verified
        $transaction->verified = 1;
        $transaction->verified_at = Carbon::now();
        $transaction->supervisor_id = Auth::id();
        $transaction->save();
        // Save Activity
        $activity = "Verify transaction ~ $transaction->code";
        $this->saveActivity($request, $activity);
        // Send Email to Seller and Stokiest after verified
        $transaction = Transaction::find($id);
        $this->sendEmailAfterVerification($transaction);
        // Return
        return response()->json([
            'msg' => 'Transaction verified'
        ], 200);
    }

    private function sendNewTransactionMail($transaction)
    {
        $supervisors = User::whereHas('roles', function ($query) {
            $query->where('slug', 'supervisor');
        })->get();

        Mail::to($supervisors)->send(new NewTransactionMail($transaction));
    }

    private function sendEmailAfterVerification($transaction)
    {
        $stokiest = $transaction->outlet->market->area->stokiest;
        $market = $transaction->outlet->market;
        $today = Carbon::now();
        Mail::to($transaction->seller)->send(new TransactionAfterVerificationMail($transaction));
        Mail::to($stokiest->email)
            ->send(new TransactionSendOrderToStokiestMail($transaction, $stokiest, $market, $today));
    }

    private function getItemOutletData()
    {
        $seller = Auth::user();
        $items = [];
        $outlets = [];

        foreach ($seller->targets as $target) {
            array_push($items, $target->item);
        }
        $outlet_sellers = OutletSeller::with('outlet')->where('seller_id', Auth::id())->get();
        foreach ($outlet_sellers as $outlet_seller) {
            array_push($outlets, $outlet_seller->outlet);
        }

        return [
          'items' => collect($items),
          'outlets' => collect($outlets),
        ];
    }

    private function getSearchQuery($request)
    {
        $role = Auth::user()->getRole();
        if ($role == 'seller') {
            $transactions = Transaction::where('code', 'LIKE', "%$query%")
            ->orWhere('qty', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")
            ->where('seller_id', Auth::id())
            ->paginate($request->paginate);
        } else {
            $transactions = Transaction::where('code', 'LIKE', "%$query%")
            ->orWhere('qty', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        }
        return $transactions;
    }

    private function getQuery($request)
    {
        $role = Auth::user()->getRole();
        if ($role == 'seller') {
            $transactions = Transaction::where('seller_id', Auth::id())->paginate($request->paginate);
        } else {
            $transactions = Transaction::paginate($request->paginate);
        }
        return $transactions;
    }
}
