<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stokiest;
use App\Traits\GlobalTrait;
use App\Models\Area;
use App\Http\Requests\StoreStokiestRequest;
use Auth;

class StokiestController extends Controller
{
    use GlobalTrait;

    public function index()
    {
        return view('admin.stokiest.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $stokiests = Stokiest::with('areas')->where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")->orWhere('address', 'LIKE', "%$query%")
            ->orWhere('pic', 'LIKE', "%$query%")->orWhere('owner', 'LIKE', "%$query%")
            ->orWhere('code', 'LIKE', "%$query%")->orWhere('phone1', 'LIKE', "%$query%")
            ->orWhere('phone2', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        } else {
            $stokiests = Stokiest::with('areas')->paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $stokiests->total(),
                'per_page' => $stokiests->perPage(),
                'current_page' => $stokiests->currentPage(),
                'last_page' => $stokiests->lastPage(),
                'from' => $stokiests->firstItem(),
                'to' => $stokiests->lastItem()
            ],
            'stokiests' => $stokiests
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function create()
    {
        $areas = Area::doesntHave('stokiests')->orderBy('name')->get();
        return view('admin.stokiest.create')->withAreas($areas);
    }

    public function store(StoreStokiestRequest $request)
    {
        $stokiest = new Stokiest;
        $this->saveData($stokiest, $request);
        $activity = "Register new Stokiest ~ $stokiest->name";
        $this->saveActivity($request, $activity);
        return response()->json([
          'stokiest' => $stokiest
        ], 200);
    }

    public function show($code)
    {
        $this->checkUser();
        $stokiest = Stokiest::with('areas')->where('code', $code)->first();
        $areas = Area::doesntHave('stokiests')->orderBy('name')->get();
        if (count($stokiest) == 0) {
            return redirect('/stokiest')->withError('No Stokiest found');
        }

        return view('admin.stokiest.show')->withStokiest($stokiest)
            ->withAreas($areas);
    }

    public function update(StoreStokiestRequest $request, $id)
    {
        // return $request->all();
        $stokiest = Stokiest::find($id);
        $this->saveData($stokiest, $request);
        $activity = "Update Stokiest data ~ $stokiest->name";
        $this->saveActivity($request, $activity);
        return response()->json([
            'stokiest' => Stokiest::find($id)
        ], 200);
    }

    public function uploadPhoto(Request $request, $id)
    {
        $this->validate($request, [
          'file' => 'required|image|max:5000'
        ]);
        $stokiest = Stokiest::find($id);
        $file = $request->file('file');
        $folder = 'app/public/stokiest/';
        $model = 'App\Models\Stokiest';

        // Save Photo
        $this->savePhoto($file, $stokiest, $folder, $model);

        // Save Activity
        $activity = "Upload Stokiest photo ~ $stokiest->name";
        $this->saveActivity($request, $activity);

        return response()->json([
          'stokiest'=> Stokiest::find($stokiest->id)
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $stokiest = Stokiest::find($id);
        $activity = "Delete stokiest ~ $stokiest->name";
        $this->saveActivity($request, $activity);
        // delete all relations
        $this->deleteRelations($stokiest);
        // Delete Stokiest
        $stokiest->delete();
        return response()->json([
          'msg' => 'Stokiest Deleted'
        ], 200);
    }

    private function deleteRelations($stokiest)
    {
        // delete media
        $this->deleteMedia($stokiest, 'App\Models\Stokiest');

        // detach areas
        if (count($stokiest->areas) > 0) {
            // return $request->area;
            $area_id = [];
            foreach ($stokiest->areas as $data) {
                array_push($area_id, $data['id']);
            }
            $stokiest->areas()->toggle($area_id);
        }
    }

    private function saveData($stokiest, $request)
    {
        $stokiest->code = $request->code;
        $stokiest->name = $request->name;
        $stokiest->owner = $request->owner;
        $stokiest->pic = $request->pic;
        $stokiest->phone1 = $request->phone1;
        $stokiest->phone2 = $request->phone2;
        $stokiest->email = $request->email;
        $stokiest->address = $request->address;
        $stokiest->lat = $request->lat;
        $stokiest->lng = $request->lng;
        $stokiest->save();
        if (count($request->area) > 0) {
            // return $request->area;
            $area_id = [];
            foreach ($request->area as $data) {
                array_push($area_id, $data['id']);
            }
            $stokiest->areas()->sync($area_id);
            $stokiest->save();
        }
    }

    private function checkUser()
    {
        $role = Auth::user()->roles()->first()->slug;
        if ($role == 'manager' || $role == 'seller') {
            return redirect('/')->withError('Operation not allowed');
        }
    }
}
