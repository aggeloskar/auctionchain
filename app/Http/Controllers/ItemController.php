<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Carbon\Carbon;
use App\Bid;
use App\User;
use Auth;
use Image;

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
            'starting_price' => 'required|numeric',
            'endDate' => 'required'

        ]);

        $endDate = Carbon::createFromFormat('d/m/y', $request->endDate);
        $formattedEndDate = $endDate->format('Y-m-d');
        
        if( $request->hasFile('itemPhoto') && $request->itemPhoto->isValid() ) {
            $imagePath = 'storage/uploads/images/' . $request->itemPhoto->hashName();

            Image::make($request->image)->save($imagePath, $imageQuality);
        }
        else {
            $imagePath = 'storage/uploads/images/default.png';

        }
        

        $item = new Item();
        $item->seller_id = Auth::user()->id;
        $item->title = request('title');
        $item->description = request('description');
        $item->image_path = $imagePath;
        $item->starting_price = request('starting_price');
        $item->currency = request('currency');
        $item->reserve_price = request('reservePrice');
        $item->end_date = $formattedEndDate;
        $item->seller_address = request('sellerAddress');
        $item->contract_address = request('contractAddress');
        //$item->seller = Auth::user()->name;
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
        $highest_bid = Bid::where('item_id', 'like', $id)->orderBy('price','desc')->first();
        if ($highest_bid){
            $highest_bidder = User::find($highest_bid->user_id);
            $highest_bidder = $highest_bidder->name;
            $highest_bid = $highest_bid->price;
        }
        else{
            $highest_bidder = "No bids yet";
            $highest_bid = "No bids yet";
        }

        $seller = User::where('id',$item->seller_id)->first();

        return view('oneitem')->with('item', $item)->with('highest_bidder', $highest_bidder)->with('highest_bid', $highest_bid)->with('seller', $seller->name);
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

    public function placebid(Request $request, Item $item)
    {   
        $bid = request('bid');
        $id = request('id');
        $highest_bid = Bid::where('item_id', $id)->orderBy('price','desc')->first();
        if($highest_bid == null){
            $highest_bid = $item->starting_price;
        }
        else{
            $highest_bid = $highest_bid->price;
        }

        if ($bid < $highest_bid && $bid < $item->starting_price){
            return back()->with('fail', 'Select different amount'); 
        }
        else {
            Bid::create([
                'user_id' => Auth::id(),
                'item_id' => $id,
                'price' => $bid,
            ]);
            return back()->with('success', 'Bid placed successfully!');
        } 
    
        
    }

    public function homeshow()
    {
        $items = Item::orderBy('created_at','desc')->take(4)->get();
        return view('index')->with('items', $items);
    }

    public function myauctions()
    {
        $items = Item::orderBy('created_at','desc')->where('seller_id',Auth::user()->id)->paginate(10);
        return view('myauctions')->with('items', $items);
    }

    public function past()
    {
        $items = Item::orderBy('created_at','desc')->where('status','sold')->paginate(10);
        return view('auctions')->with('items', $items);
    }

    public function pay($id)
    {
        $item = Item::find($id);
        $highest_bid = Bid::where('item_id', 'like', $id)->orderBy('price','desc')->first();
        
        $seller = User::where('id',$item->seller_id)->first();

        return view('payment')->with('item', $item)->with('highest_bid', $highest_bid->price)->with('seller', $seller);
        
    }

    public function test(Request $request){
        return response()->json([$request->all()]);
    }
   }

