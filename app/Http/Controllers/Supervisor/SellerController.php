<?php

namespace App\Http\Controllers\Supervisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class SellerController extends Controller
{
    public function index()
    {
        return view('supervisor.seller.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
            'paginate' => 'required|integer',
            'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $sellers = User::whereHas('roles', function ($query) {
                $query->where('slug', '=', 'seller');
            })->where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        } else {
            $sellers = User::whereHas('roles', function ($query) {
                $query->where('slug', '=', 'seller');
            })->paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $sellers->total(),
                'per_page' => $sellers->perPage(),
                'current_page' => $sellers->currentPage(),
                'last_page' => $sellers->lastPage(),
                'from' => $sellers->firstItem(),
                'to' => $sellers->lastItem()
            ],
            'sellers' => $sellers
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function create()
    {
        return view('supervisor.seller.create');
    }
}
