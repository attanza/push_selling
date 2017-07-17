<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\UploadAvatarJob;
use App\User;
use App\Traits\GlobalTrait;
use Auth;

class UploadController extends Controller
{
    use GlobalTrait;

    public function uploadAvatar(Request $request, $user_id)
    {
        $this->validate($request, [
            'file' => 'required|string'
        ]);
        $user = User::find($user_id);

        $file = $request->input('file');

        $this->dispatch(new UploadAvatarJob($user, $file));

        if ($user->id == Auth::id()) {
            $activity = "Upload Avatar";
        } else {
            $activity = "Upload $user->email avatar";
        }
        $this->saveActivity($request, $activity);

        return response()->json([
            'user' => User::find($user_id)
        ], 201);
    }
}
