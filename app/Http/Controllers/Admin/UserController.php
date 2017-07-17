<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use Mail;
use App\Mail\NewPasswordMail;
use DB;
use App\Traits\GlobalTrait;
use Auth;

class UserController extends Controller
{
    use GlobalTrait;

    public function index()
    {
        return view('admin.users.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $users = User::with('roles')->where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        } else {
            $users = User::with('roles')->paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'users' => $users
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('admin.users.create')->withRoles($roles);
    }

    public function store(StoreUserRequest $request)
    {
        // Save User
        $password = str_random(6);
        $user = User::create([
          'name' => $request->input('name'),
          'username' => $request->input('username'),
          'email' => $request->input('email'),
          'password' => bcrypt($password),
        ]);

        // Save User Detail
        $user_detail = $user->detail()->create([
          'ktp' => $request->ktp,
          'gender' => $request->gender,
          'dob' => $request->dob,
          'phone1' => $request->phone1,
          'phone2' => $request->phone2,
          'address' => $request->address
        ]);

        // Save User role
        DB::table('role_user')->insert([
          'user_id' => $user->id,
          'role_id' => $request->role
        ]);

        $this->sendMail($user, $password);
        $activity = "Register new user $user->email";
        $this->saveActivity($request, $activity);
        if ($request->ajax()) {
            return response()->json(['msg'=>'Saving data Success'], 200);
        }
    }

    public function checkMail(Request $request, $email)
    {
        $check_email = User::select('id')->where('email', $email)->first();
        if (count($check_email) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkUsername(Request $request, $username)
    {
        $check_username = User::select('id')->where('username', $username)->first();
        if (count($check_username) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    private function sendMail($user, $password)
    {
        Mail::to($user)->send(new NewPasswordMail($user, $password));
    }
}
