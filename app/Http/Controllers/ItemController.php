<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('created_at','desc')->paginate(10);
        return view('auctions')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newauction');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'starting_price' => 'required|numeric'

        ]);

        $item = new Item();
        $item->title = request('title');
        $item->description = request('description');
        $item->starting_price = request('starting_price');
        $item->currency = request('currency');
        $item->reserve_price = request('reservePrice');
        $item->startDate = date('Y-m-d H:i:s'); //TODO
        $item->duration = request('duration');
        $item->endDate = date('Y-m-d H:i:s', strtotime($item->startDate . ' + ' . request('duration') . ' days'));
        $item->seller = Auth::user()->name;
        //$item->seller_id = Auth::user()->id;
        $item->save();
        return back()->with('success', 'You have created a new auction!'); ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return view('oneitem')->with('item', $item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function placebid(Request $request)
    {   
        $id = request('id');
        $item = Item::find($id);
        $bid = request('bid');
        if ($bid > $item->highest_bid && $bid > $item->starting_price){
            $item->highest_bid = $bid;
            $item->highest_bidder = Auth::user()->name;
            $item->save();
            return back()->with('success', 'Bid placed successfully!'); 
        }
        else {
            return back(); 
        }
    /***** TODO: Auto-refresh page on every bid *****/
        
    }

    public function homeshow()
    {
        $items = Item::orderBy('created_at','desc')->take(4)->get();
        return view('index')->with('items', $items);
    }

    public function myauctions()
    {
        $items = Item::orderBy('created_at','desc')->where('seller',Auth::user()->name)->paginate(10);
        return view('myauctions')->with('items', $items);
    }
}

