<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;
use Image;
use App\User;
use Auth;
use App\Traits\GlobalTrait;

class UploadAvatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalTrait;

    public $file;
    public $user;

    public function __construct(User $user, string $file)
    {
        $this->file = $file;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->file;
        $user = $this->user;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $image_data = base64_decode($data);

        $folder = 'app/public/avatars/';
        $mainFileName = $user->username.'.'.'jpg';

        if (!file_exists(storage_path($folder))) {
            mkdir(storage_path($folder), 0755, true);
        }

        $mainImage = Image::make($image_data)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($folder).$mainFileName);

        $user->avatar = 'public/avatars/'.$mainFileName;
        $user->save();

        $this->saveMedia($user->id, 'App\User', 'public/avatars/', $mainFileName, $image_data);

        return redirect()->route('profile.index', ['username'=> $user->username])
          ->withSuccess('Avatar updated');
    }
}
