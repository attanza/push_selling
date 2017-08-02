<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Traits\GlobalTrait;
use App\Http\Requests\StoreItemRequest;
use Image;
use Storage;
use App\Models\Media;
use DB;

class ItemController extends Controller
{
    use GlobalTrait;

    public function index()
    {
        if (!$this->checkAdmin()) {
            return redirect('/')->withError('Operation not allowed');
        }
        return view('admin.item.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $items = Item::where('name', 'LIKE', "%$query%")
            ->orWhere('code', 'LIKE', "%$query%")->orWhere('measurement', 'LIKE', "%$query%")
            ->orWhere('price', 'LIKE', "%$query%")->orWhere('target_by', 'LIKE', "%$query%")
            ->orWhere('target_count', 'LIKE', "%$query%")->orWhere('start_date', 'LIKE', "%$query%")
            ->orWhere('end_date', 'LIKE', "%$query%")
            ->orderBy('name')
            ->paginate($request->paginate);
        } else {
            $items = Item::orderBy('name')->paginate($request->paginate);
        }

        $response = [
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem()
            ],
            'items' => $items
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function store(StoreItemRequest $request)
    {
        // return $request->all();
        $item = Item::create($request->all());
        // Save Activity
        $activity = "Add new Item ~ $item->name";
        $this->saveActivity($request, $activity);

        return response()->json([
          'item' => $item
        ], 200);
    }

    public function show($code)
    {
        $item = Item::where('code', $code)->first();
        if (count($item) == 0) {
            return redirect('/item')->withError('Item not found');
        }

        return view('admin.item.show')->withItem($item);
    }

    public function update(StoreItemRequest $request, $id)
    {
        $item = Item::find($id);
        // Save Activity
        $activity = "Update Item ~ $item->name";
        $this->saveActivity($request, $activity);

        if (count($item) == 0) {
            return response()->json([
              'msg' => "Item not found"
            ], 404);
        }

        $item->update($request->all());
        return response()->json([
          'item' => $item
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        // Find Item
        $item = Item::findOrFail($id);
        // Delete Media and photos
        if (count($item->medias) > 0) {
            foreach ($item->medias as $media) {
                $this->deletePhotoIfExists($media->folder, $media->filename);
                $media->delete();
            }
        }
        // Delete Relation if any TODO
        // Save Activity
        $activity = "Delete Item ~ $item->name";
        $this->saveActivity($request, $activity);
        // Delete Item
        $item->delete();
        return response()->json([
            'msg' => 'Item Deleted'
        ], 200);
    }
}
