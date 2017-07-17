<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\User;
use Mail;
use App\Mail\NewPasswordMail;
use DB;

class RegisterUserDetailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $request;
    public $user;
    public $password;

    public function __construct(array $request, User $user, $password)
    {
        $this->request = $request;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      // Save User Detail
        $user_detail = $this->user->detail()->create([
          'ktp' => $this->request->ktp,
          'gender' => $this->request->gender,
          'dob' => $this->request->dob,
          'phone1' => $this->request->phone1,
          'phone2' => $this->request->phone2,
          'address' => $this->request->address
        ]);

        // Save User role
        DB::table('role_user')->insert([
          'user_id' => $this->user->id,
          'role_id' => $this->request->role
        ]);
        $user_data = $this->user;
        $password_data = $this->password;

        $this->sendMail($user_data, $password_data);
    }
}
