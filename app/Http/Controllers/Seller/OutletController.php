<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\GlobalTrait;
use App\Models\Outlet;
use App\Models\Market;
use App\Http\Requests\StoreOutletRequest;
use Auth;
use Mail;
use App\Mail\NewOutletMail;
use App\User;

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
            $outlets = $this->getSearchQuery($request);
        } else {
            $outlets = $this->getQuery($request);
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
        $role = Auth::user()->roles()->first()->slug;
        if ($role != 'seller') {
            return response()->json([
              'msg' => 'Request forbidden'
            ], 403);
        }
        $outlet = new Outlet;
        $this->saveData($outlet, $request);
        $this->saveOutletDetail($outlet);
        $activity = "Register new Outlet ~ $outlet->name";
        $this->saveActivity($request, $activity);
        // Send email
        $outlet = Outlet::with('detail')->find($outlet->id);
        $this->sendNewOutletMail($outlet, 'register');
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

    private function saveOutletDetail($outlet)
    {
        return $outlet->detail()->create([
            'seller_id' => Auth::id()
        ]);
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
        // Delete Media and photos
        if (count($outlet->medias) > 0) {
            foreach ($outlet->medias as $media) {
                $this->deletePhotoIfExists($media->folder, $media->filename);
                $media->delete();
            }
        }
        // Save Activity
        $activity = "Delete stokiest ~ $outlet->name";
        $this->saveActivity($request, $activity);

        // Delete Stokiest
        $outlet->delete();
        return response()->json([
          'msg' => 'Outlet Deleted'
        ], 200);
    }

    public function setVerify(Request $request, $id)
    {
        // check if auth user is supervisor
        $role = Auth::user()->roles()->first()->slug;
        if ($role != 'supervisor') {
            return response()->json([
              'msg' => 'Request forbidden'
            ], 403);
        }
        // find Outlet
        $outlet = Outlet::find($id);
        if (count($outlet) < 1 && count($outlet->detail) < 1) {
            return response()->json([
              'msg' => 'Outlet not found'
            ], 404);
        }
        // Update Detail
        $outlet->detail->update([
            'verified' => 1,
            'verified_at' => \Carbon\Carbon::now(),
            'supervisor_id' => Auth::id()
        ]);
        // Send email
        $outlet = Outlet::with('detail')->find($outlet->id);
        $this->sendNewOutletMail($outlet, 'verify');
        // Return
        return response()->json([
            'msg' => 'Outlet verified'
        ], 200);
    }

    private function getSearchQuery($request)
    {
        $role = Auth::user()->roles()->first()->slug;
        if ($role == 'seller') {
            $outlets = Outlet::with('market')->where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")->orWhere('address', 'LIKE', "%$query%")
            ->orWhere('pic', 'LIKE', "%$query%")->orWhere('owner', 'LIKE', "%$query%")
            ->orWhere('code', 'LIKE', "%$query%")->orWhere('phone1', 'LIKE', "%$query%")
            ->orWhere('phone2', 'LIKE', "%$query%")
            ->whereHas('detail', function ($query) {
                $query->where('seller_id', Auth::id());
            })
            ->paginate($request->paginate);
        } else {
            $outlets = Outlet::with('market')->where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")->orWhere('address', 'LIKE', "%$query%")
            ->orWhere('pic', 'LIKE', "%$query%")->orWhere('owner', 'LIKE', "%$query%")
            ->orWhere('code', 'LIKE', "%$query%")->orWhere('phone1', 'LIKE', "%$query%")
            ->orWhere('phone2', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        }
        return $outlets;
    }

    private function getQuery($request)
    {
        $role = Auth::user()->roles()->first()->slug;
        if ($role == 'seller') {
            $outlets = Outlet::with('market', 'detail')
            ->whereHas('detail', function ($query) {
                $query->where('seller_id', Auth::id());
            })->paginate($request->paginate);
        } else {
            $outlets = Outlet::with('market', 'detail')->paginate($request->paginate);
        }
        return $outlets;
    }

    private function sendNewOutletMail($outlet, $type)
    {
        if ($type == 'register') {
            $supervisors = User::whereHas('roles', function ($query) {
                $query->where('slug', 'supervisor');
            })->get();
            Mail::to($supervisors)->send(new NewOutletMail($outlet, $type));
        } elseif ($type = 'verify') {
              Mail::to($outlet->detail->seller)->send(new NewOutletMail($outlet, $type));
        }
    }
}
