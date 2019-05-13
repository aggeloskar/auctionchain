<?php

namespace App\Http\Middleware;

use Closure;
use App\Item;
use Carbon\Carbon;
use App\Bid;
use App\User;
use Auth;


class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->itemid;

        $item = Item::find($id);
        $highest_bid = Bid::where('item_id', 'like', $id)->orderBy('price','desc')->first();
        if ($highest_bid){
            $highest_bidder = User::find($highest_bid->user_id);
            return $next($request);
        }
        else{
            $highest_bidder = "No bids yet";
            return redirect('/');
        }
        
    }
}
