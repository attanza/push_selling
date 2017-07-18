<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Market;
use App\Traits\GlobalTrait;
use DB;
use Auth;
use App\Http\Requests\StoreMarketRequest;
use App\Http\Requests\UpdateMarketRequest;
use Image;
use Storage;

class MarketController extends Controller
{
    use GlobalTrait;

    public function index()
    {
        $this->checkUser();
        return view('admin.market.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $markets = Market::with('area')->where('name', 'LIKE', "%$query%")
            ->orWhere('slug', 'LIKE', "%$query%")->orWhere('address', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        } else {
            $markets = Market::with('area')->paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $markets->total(),
                'per_page' => $markets->perPage(),
                'current_page' => $markets->currentPage(),
                'last_page' => $markets->lastPage(),
                'from' => $markets->firstItem(),
                'to' => $markets->lastItem()
            ],
            'markets' => $markets
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function store(StoreMarketRequest $request)
    {
        // return $request->all();

        $market = Market::withTrashed()->where('name', $request->name)->first();
        if (count($market) > 0 && $market->trashed()) {
            $market->restore();
            $this->saveMarketDB($market, $request);
        } elseif (count($market) > 0) {
            return response()->json([
              'msg' => 'The Area already registered'
            ], 422);
        } else {
            $market = new Market;
            $this->saveMarketDB($market, $request);
        }

        $activity = "Register new Market ~ $market->name";
        $this->saveActivity($request, $activity);
        return response()->json([
            'market' => $market
        ], 200);
    }

    private function saveMarketDB($market, $request)
    {
        $market->name = $request->name;
        $market->area_id = $request->area_id;
        $market->address = e($request->address);
        $market->lat = $request->lat;
        $market->lng = $request->lng;
        if (!isset($market->id)) {
            $market->slug = str_slug($request->name).'-'.time();
        }
        $market->save();

        return $market;
    }

    public function show($slug)
    {
        $this->checkUser();
        $market = Market::with('area')->where('slug', $slug)->first();
        if (!$market) {
            return redirect('/')->withError('Market not found');
        }

        $areas = Area::select('id', 'name')->orderBy('name')->get();
        return view('admin.market.show')->withMarket($market)->withAreas($areas);
    }

    public function update(UpdateMarketRequest $request, $id)
    {
        $market = Market::find($id);
        $this->saveMarketDB($market, $request);

        $activity = "Update Market ~ $market->name data";
        $this->saveActivity($request, $activity);
        return response()->json([
            'market' => Market::find($market->id)
        ], 200);
    }

    private function checkUser()
    {
        $role = Auth::user()->roles()->first()->slug;
        if ($role == 'manager' || $role == 'seller') {
            return redirect('/')->withError('Operation not allowed');
        }
    }

    public function uploadPhoto(Request $request, $id)
    {
        $this->validate($request, [
          'file' => 'required|image|max:5000'
        ]);
        $market = Market::find($id);
        $file = $request->file('file');
        $folder = 'app/public/markets/';
        $model = 'App\Models\Market';

        // Save Photo
        $this->savePhoto($file, $market, $folder, $model);

        // Save Activity
        $activity = "Upload Market photo ~ $market->name";
        $this->saveActivity($request, $activity);

        return response()->json([
          'market'=> Market::find($market->id)
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $market = Market::find($id);
        $activity = "Delete market ~ $market->name";
        $this->saveActivity($request, $activity);
        $market->delete();
        return response()->json([
          'msg' => 'Market Deleted'
        ], 200);
    }

    public function setLocation(Request $request, $id)
    {
        $this->validate($request, [
          'lat' => 'numeric',
          'lng' => 'numeric',
        ]);

        $market = Market::find($id);
        if (count($market) == 1) {
            $market->lat = $request->lat;
            $market->lng = $request->lng;
            $market->save();
            return response()->json([
              'market' => $market
            ], 200);
        } else {
            return response()->json([
              'msg' => 'Market not found'
            ], 404);
        }
    }
}
