<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\ResetPasswordMail;
use App\Traits\GlobalTrait;

class PasswordUtilityController extends Controller
{
    use GlobalTrait;

    public function changePassword(Request $request, $user_id)
    {
        if (Auth::id() != $user_id) {
            return response()->json([
              'msg' => 'Request Forbidden'
            ], 403);
        }

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required',
        ]);

        $user = User::find($user_id);
        if (Hash::check($request->password, $user->password)) {
            return response()->json([
              'msg' => 'Old Password Incorrect'
            ], 422);
        } else {
            $user->password = bcrypt($request->password);
            $user->save();

            if ($user->id == Auth::id()) {
                $activity = "Change his/her own password";
            } else {
                $activity = "Change $user->email password";
            }

            $this->saveActivity($request, $activity);

            return response()->json([
                'msg' => 'Success'
            ], 200);
        }
    }

    public function resetPassword(Request $request, $user_id)
    {
        if (Auth::user()->roles()->first()->slug == 'admin' || Auth::id() == $user_id) {
            $password = str_random(6);
            $user = User::find($user_id);
            $user->password = bcrypt($password);
            $user->save();
            // Send Email
            Mail::to($user)->send(new ResetPasswordMail($user, $password));

            if ($user->id == Auth::id()) {
                $activity = "Change his/her own password";
            } else {
                $activity = "Change $user->email password";
            }

            $this->saveActivity($request, $activity);

            return response()->json([
              'msg' => 'Success'
            ], 200);
        } else {
            return response()->json([
              'msg' => 'Request Forbidden'
            ], 403);
        }
    }

    public function getForgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function postForgotPassword(Request $request)
    {
        $this->validate($request, [
          'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->where('is_active', 1)->first();
        if (!$user) {
            return redirect('/login')->withError('A Reset password mail has sent to your email');
        }

        $password = str_random(6);
        $user->password = bcrypt($password);
        $user->save();
        // Send Email
        Mail::to($user)->send(new ResetPasswordMail($user, $password));

        return redirect('/login')->withSuccess('A Reset password mail has sent to your email');
    }
}
