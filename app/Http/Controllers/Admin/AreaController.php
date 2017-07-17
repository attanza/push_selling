<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;
use App\Traits\GlobalTrait;
use Auth;

class AreaController extends Controller
{
    use GlobalTrait;

    public function index()
    {
        $role = Auth::user()->roles()->first()->slug;
        if ($role == 'manager' || $role == 'seller') {
            return redirect('/')->withError('Operation not allowed');
        }
        return view('admin.area.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $areas = Area::where('name', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        } else {
            $areas = Area::paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $areas->total(),
                'per_page' => $areas->perPage(),
                'current_page' => $areas->currentPage(),
                'last_page' => $areas->lastPage(),
                'from' => $areas->firstItem(),
                'to' => $areas->lastItem()
            ],
            'areas' => $areas
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'name' => 'required|max:50'
        ]);
        // Check if area exist
        $area = Area::withTrashed()->where('name', $request->name)->first();
        if (count($area) > 0 && $area->trashed()) {
            $area->restore();
            $area->update($request->all());
        } elseif (count($area) > 0) {
            return response()->json([
              'msg' => 'The Area already registered'
            ], 422);
        } else {
            $area = Area::create($request->all());
        }

        $activity = "Register new area $area->name";
        $this->saveActivity($request, $activity);
        return response()->json([
            'area' => $area
        ]);
    }

    public function update(StoreAreaRequest $request, $id)
    {
        $area = Area::find($id);
        $area->update($request->all());
        $activity = "Update area $area->name";
        $this->saveActivity($request, $activity);
        return response()->json([
          'area' => $area
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $area = Area::find($id);
        $activity = "Delete area $area->name";
        $this->saveActivity($request, $activity);
        $area->delete();
        return response()->json([
          'msg' => 'Area Deleted'
        ], 200);
    }

    public function getAreaForDropdown()
    {
        $areas = Area::select('id', 'name')->orderBy('name')->get();
        return response()->json([
          'areas' => $areas
        ], 200);
    }
}
