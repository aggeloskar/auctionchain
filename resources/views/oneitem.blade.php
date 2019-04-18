@extends('layout')

@section('content')
    <h1 class="display-4">{{$item->title}}</h1>
    <div class="row">
        <div class="col-md-3">
            <img src="https://dummyimage.com/200x250/005f96/ffffff&text=Item+image">
        </div>
        <div class="col-md-6">
            <dl class="row">
                <dt class="col-sm-4">Starting Price</dt>
                <dd class="col-sm-8">{{$item->starting_price}} ETH </dd>

                <dt class="col-sm-4">Highest Bid</dt>
                <dd class="col-sm-8"> {{ $item->highest_bid ? $item->highest_bid . ' ETH' : 'No bids yet' }} </dd>

                <dt class="col-sm-4">Highest Bidder</dt>
                <dd class="col-sm-8"> {{ $item->highest_bidder ? $item->highest_bidder : 'No bids yet' }} </dd>

                <dt class="col-sm-4">Seller</dt>
                <dd class="col-sm-8">  {{ $item->seller }} </dd>

                <dt class="col-sm-4">Description</dt>
                <dd class="col-sm-8">Simentum nibh, ut res massa justo sit amet risus. Sed dapibus sodales lectus, nec pulvinar dui aliquam non. </dd>
                </dd>
            </dl> 
        </div>
        <div class="col-md-3">
            <div class="alert alert-info" role="alert">
                <strong>Time Left: </strong> 1 day
            </div>
            <form method="POST" action="placebid">
            @csrf
                <div class="form-group">
                    <label for="exampleInputPassword1">New Bid</label>
                    <input type="text" class="form-control" name="bid" placeholder="{{ $item-> highest_bid+0.1 }}">
                    <input type="hidden" value="{{$item->id}}" name="id">
                </div>  
                <button type="submit" class="btn btn-primary btn-block">Place bid</button>
            </form>
            @if (\Session::has('success'))
                    <br>
                    <div class="alert alert-success">
                        {!! \Session::get('success') !!}                        
                    </div>
            @endif
        </div>
    </div>
@endsection