<?php

namespace App\Http\Controllers\Supervisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SellerTarget;
use App\User;
use App\Models\Item;
use App\Http\Requests\StoreSellerTargetRequest;
use App\Traits\GlobalTrait;
use Mail;
use App\Mail\NewSellerTargetMail;

class SellerTargetController extends Controller
{
    use GlobalTrait;

    public function index()
    {
        $sellers = User::select('id', 'name')->whereHas('roles', function ($query) {
            $query->where('slug', '=', 'seller');
        })->orderBy('name')->get();
        $items = Item::select('id', 'name')->orderBy('name')->get();
        return view('supervisor.seller_target.index')->with([
            'items' => $items,
            'sellers' => $sellers
        ]);
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $seller_targets = SellerTarget::with('seller', 'item', 'creator')->where('name', 'LIKE', "%$query%")
            ->orWhere('target_count', 'LIKE', "%$query%")->orWhere('start_date', 'LIKE', "%$query%")
            ->orWhere('end_date_date', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        } else {
            $seller_targets = SellerTarget::with('seller', 'item', 'creator')->paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $seller_targets->total(),
                'per_page' => $seller_targets->perPage(),
                'current_page' => $seller_targets->currentPage(),
                'last_page' => $seller_targets->lastPage(),
                'from' => $seller_targets->firstItem(),
                'to' => $seller_targets->lastItem()
            ],
            'seller_targets' => $seller_targets
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function store(StoreSellerTargetRequest $request)
    {
        // Save Data
        $seller_target = SellerTarget::create($request->all());
        // Save Activity
        $activity = "Register new Seller Target ~ $seller_target->name";
        $this->saveActivity($request, $activity);

        $data = SellerTarget::with('seller', 'item', 'creator')->find($seller_target->id);
        $this->sendMail($data);
        // return
        return response()->json([
            'seller_target' => $data
        ], 200);
    }

    public function update(StoreSellerTargetRequest $request, $id)
    {
        // Find Seller Target
        $seller_target = SellerTarget::find($id);
        // if not found
        if (count($seller_target) < 1) {
            return response()->json([
                'msg' => 'Seller Target not found'
            ], 404);
        }
        // Update Data
        $seller_target->update($request->all());
        // Save Activity
        $activity = "Update Seller Target ~ $seller_target->name";
        $this->saveActivity($request, $activity);
        // return
        return response()->json([
            'seller_target' => $seller_target
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        // find seller target
        $seller_target = SellerTarget::find($id);
        if (count($seller_target) < 1) {
            return response()->json([
                'msg' => 'Seller Target not found'
            ], 404);
        }
        // Check Realation
        // save Activity
        $activity = "Delete Seller Target ~ $seller_target->name";
        $this->saveActivity($request, $activity);
        // Delete Seller target
        $seller_target->delete();
        // Return
        return response()->json([
            'msg' => 'Seller Target Deleted'
        ], 200);
    }

    private function sendMail($data)
    {
        Mail::to($data->seller)
        ->cc($data->creator)
        ->queue(new NewSellerTargetMail($data));
    }
}
