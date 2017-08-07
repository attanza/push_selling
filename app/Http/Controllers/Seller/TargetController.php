<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SellerTarget;
use Auth;

class TargetController extends Controller
{
    public function index()
    {
        $targets = SellerTarget::with('item')->where('user_id', Auth::id())->paginate(4);
        return view('seller.target.index')->withTargets($targets);
    }
}
