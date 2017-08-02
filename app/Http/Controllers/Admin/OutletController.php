<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GlobalTrait;
use App\Models\Outlet;
use App\Models\Market;
use App\Http\Requests\StoreOutletRequest;

class OutletController extends Controller
{
    use GlobalTrait;

    public function index()
    {
        return view('admin.outlet.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $outlets = Outlet::with('market')->where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")->orWhere('address', 'LIKE', "%$query%")
            ->orWhere('pic', 'LIKE', "%$query%")->orWhere('owner', 'LIKE', "%$query%")
            ->orWhere('code', 'LIKE', "%$query%")->orWhere('phone1', 'LIKE', "%$query%")
            ->orWhere('phone2', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        } else {
            $outlets = Outlet::with('market')->paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $outlets->total(),
                'per_page' => $outlets->perPage(),
                'current_page' => $outlets->currentPage(),
                'last_page' => $outlets->lastPage(),
                'from' => $outlets->firstItem(),
                'to' => $outlets->lastItem()
            ],
            'outlets' => $outlets
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function create()
    {
        $markets = Market::select('id', 'name')->orderBy('name')->get();
        return view('admin.outlet.create')->withMarkets($markets);
    }

    public function store(StoreOutletRequest $request)
    {
        // return $request->all();
        $outlet = new Outlet;
        $this->saveData($outlet, $request);
        $activity = "Register new Outlet ~ $outlet->name";
        $this->saveActivity($request, $activity);
        return response()->json([
          'outlet' => $outlet
        ], 200);
    }

    private function saveData($outlet, $request)
    {
        $outlet->market_id = $request->market_id;
        $outlet->code = $request->code;
        $outlet->name = $request->name;
        $outlet->owner = $request->owner;
        $outlet->pic = $request->pic;
        $outlet->phone1 = $request->phone1;
        $outlet->phone2 = $request->phone2;
        $outlet->email = $request->email;
        $outlet->address = $request->address;
        $outlet->lat = $request->lat;
        $outlet->lng = $request->lng;
        $outlet->save();
    }

    public function show($code)
    {
        $outlet = Outlet::with('market')->where('code', $code)->first();
        if (count($outlet) == 0) {
            return redirect('/outlet')->withError('No Stokiest found');
        }
        $markets = Market::select('id', 'name')->orderBy('name')->get();
        return view('admin.outlet.show')->withOutlet($outlet)
            ->withMarkets($markets);
    }

    public function update(StoreOutletRequest $request, $id)
    {
        // return $request->all();
        $outlet = Outlet::find($id);
        $this->saveData($outlet, $request);
        $activity = "Update Outlet data ~ $outlet->name";
        $this->saveActivity($request, $activity);
        return response()->json([
            'outlet' => Outlet::with('market')->find($id)
        ], 200);
    }

    public function setLocation(Request $request, $id)
    {
        $this->validate($request, [
          'lat' => 'numeric',
          'lng' => 'numeric',
        ]);

        $outlet = Outlet::find($id);
        if (count($outlet) == 1) {
            $outlet->lat = $request->lat;
            $outlet->lng = $request->lng;
            $outlet->save();
            $activity = "Set place ~ $outlet->name";
            $this->saveActivity($request, $activity);
            return response()->json([
              'outlet' => Outlet::with('market')->find($id)
            ], 200);
        } else {
            return response()->json([
              'msg' => 'Outlet not found'
            ], 404);
        }
    }

    public function destroy(Request $request, $id)
    {
        $outlet = Outlet::find($id);
        $activity = "Delete stokiest ~ $outlet->name";
        $this->saveActivity($request, $activity);
        // delete all relations
        // $this->deleteRelations($outlet);
        // Delete Stokiest
        $outlet->delete();
        return response()->json([
          'msg' => 'Outlet Deleted'
        ], 200);
    }
}
