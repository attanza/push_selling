<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Activity;
use App\Traits\GlobalTrait;
use App\Models\Role;
use DB;
use Auth;
use App\Http\Requests\StoreUserRequest;

class ProfileController extends Controller
{
    use GlobalTrait;

    public function index($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return redirect('/')->withError('No user found');
        }
        if (!$user->detail) {
            $user->detail()->create([]);
        }

        if ($this->checkIfCanAccess($user)) {
            $roles = Role::select('id', 'name')->get();
            $user = User::with('detail')->where('username', $username)->first();
            return view('profile.index')->with([
                'user' => $user,
                'roles' => $roles
            ]);
        } else {
            return redirect('/')->withError('Operation not allowed');
        }
    }

    public function listing(Request $request, $user_id)
    {
        $this->validate($request, [
            'paginate' => 'required|integer',
            'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $activities = Activity::where('user_id', $user_id)->where('name', 'LIKE', "%$query%")
              ->orWhere('email', 'LIKE', "%$query%")->orderBy('created_at', 'desc')
              ->paginate($request->paginate);
        } else {
            $activities = Activity::where('user_id', $user_id)
                ->orderBy('created_at', 'desc')->paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $activities->total(),
                'per_page' => $activities->perPage(),
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'from' => $activities->firstItem(),
                'to' => $activities->lastItem()
            ],
            'activities' => $activities
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function update(StoreUserRequest $request, $id)
    {
        // Save User
        $user = User::find($id);
        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'is_active' => $request->input('is_active')
        ]);

        // Save User Detail
        $user_detail = $user->detail()->update([
            'ktp' => $request->ktp,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'address' => $request->address
        ]);

        // Save User role
        DB::table('role_user')
            ->where('user_id', $user->id)
            ->update(['role_id' => $request->role]);

        if ($user->id == Auth::id()) {
            $activity = "Updating his/her own User Data";
        } else {
            $activity = "Updating $user->email user data";
        }

        $this->saveActivity($request, $activity);

        if ($request->ajax()) {
            return response()->json([
                'msg'=>'Saving data Success',
                'user' => User::with('detail')->find($user->id)
            ], 200);
        }
    }

    private function checkIfCanAccess($user)
    {
        $auth_role = Auth::user()->roles()->first()->slug;
        $user_role = $user->roles()->first()->slug;

        if ($user->id == Auth::id()) {
            return true;
        } elseif ($auth_role == 'admin') {
            return true;
        } elseif ($auth_role == 'supervisor' && $user_role == 'seller') {
            return true;
        } else {
            return false;
        }
    }
}
