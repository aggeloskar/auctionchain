<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Carbon\Carbon;
use App\Bid;
use App\User;
use Auth;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/');
    }

    public function profile(Request $request) {
        $user = Auth::user();
        $items = Item::where('status', 'active')->take(10)->get();
        $bids = ['Bid', 'Bid'];
        return view('profile', compact('user', 'items', 'bids'));
    }
}
