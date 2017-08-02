<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Storage;
use Image;
use App\Traits\GlobalTrait;

class GalleryController extends Controller
{
    use GlobalTrait;

    public function getMedia($id, $db_model)
    {
        $model = $this->getModel($db_model);
        $item_medias = Media::select('id', 'caption', 'folder', 'filename')
        ->where('mediable_id', $id)->where('mediable_type', $model)
        ->orderBy('id', 'desc')->paginate(12);
        $medias = [];
        if (count($item_medias) > 0) {
            foreach ($item_medias as $media) {
                $path = Storage::url($media->folder.$media->filename);
                $data = [
                  'id' => $media->id,
                  'caption' => $media->caption,
                  'path' => $path
                ];
                array_push($medias, $data);
            }
        }

        $response = [
            'pagination' => [
                'total' => $item_medias->total(),
                'per_page' => $item_medias->perPage(),
                'current_page' => $item_medias->currentPage(),
                'last_page' => $item_medias->lastPage(),
                'from' => $item_medias->firstItem(),
                'to' => $item_medias->lastItem()
            ],
            'medias' => $medias
        ];

        return response()->json($response);
    }

    public function storeMedia(Request $request, $id, $db_model)
    {
        // return [
        //   'request' => $request->all(),
        //   'id' => $id,
        //   'model' => $db_model
        // ];

        $this->validate($request, [
          'file' => 'required|image|max:5000'
        ]);
        $model = $this->getModel($db_model);
        $item = $model::findOrFail($id);

        // Store photo
        $file = $request->file('file');
        $folder = 'app/public/'.str_plural($db_model).'/';
        $filename = uniqid().time().'.'.$file->getClientOriginalExtension();

        if (!file_exists(storage_path($folder))) {
            mkdir(storage_path($folder), 0755, true);
        }

        $mainImage = Image::make($file)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save(storage_path($folder).$filename);

        // Save Media
        $media = $this->saveMedia($folder, $filename, $id, $model);
        $path = Storage::url($media->folder.$media->filename);
        $data = [
          'caption' => $media->caption,
          'path' => $path
        ];
        // Save Activity
        $activity = "Upload Item photo ~ $item->name";
        $this->saveActivity($request, $activity);

        return response()->json([
          'medias'=> $data
        ], 200);
    }

    private function saveMedia($folder, $filename, $id, $model)
    {
        $path = explode('app/', $folder);
        $size = Storage::size($path[1].$filename);
        $mime = Storage::mimeType($path[1].$filename);
        $ext = pathinfo(storage_path().$path[1].$filename, PATHINFO_EXTENSION);

        $media = Media::create([
          'mediable_id' => $id,
          'mediable_type' => $model,
          'folder' => $path[1],
          'filename' => $filename,
          'extension' => $ext,
          'mime' => $mime,
          'size' => $size,
          'caption' => $filename
        ]);

        return $media;
    }

    public function editCaption(Request $request, $id)
    {
        $this->validate($request, [
          'caption' => 'required|max:200'
        ]);
        $media = Media::findOrFail($id);
        $media->caption = $request->caption;
        $media->save();

        return response()->json([
          'media' => $media
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $media = Media::findOrFail($id);
        // Delete file
        $this->deletePhotoIfExists($media->folder, $media->filename);
        // Save Activity
        $activity = "Delete Item photo ~ $media->caption";
        $this->saveActivity($request, $activity);
        // Delete Media
        $media->delete();
        return response()->json([
          'msg' => 'Photo deleted'
        ], 200);
    }

    private function getModel($db_model)
    {
        switch ($db_model) {
            case 'item':
                return "App\Models\Item";
                break;
            case 'outlet':
                return "App\Models\Outlet";
                break;

            default:
                break;
        }
    }
}
