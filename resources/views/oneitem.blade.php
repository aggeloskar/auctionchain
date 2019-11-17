@extends('layout')

@section('content')
    <h1 class="display-4">{{$item->title}}</h1>
    @if($highest_bidder == Auth::user()->name && $item->status == 'sold')
    {{-- <div class="alert alert-success">
        You have won this auction! Click <a href="{{$item->id}}/pay" class="alert-link">here</a> to continiue to payment.
    </div> --}}
    <div class="alert alert-success">
        You have won this auction!
    </div>
    @endif
    <div class="row">
        <div class="col-md-3">
            <img src="https://dummyimage.com/200x250/005f96/ffffff&text=Item+image">
        </div>
        <div class="col-md-6">
            <dl class="row">
                <dt class="col-sm-4">Starting Price</dt>
                <dd class="col-sm-8">{{rtrim(rtrim($item->starting_price, '0'), '.') . ' ' . $item->currency}} </dd>

                <dt class="col-sm-4">Reserve Price</dt>
                <dd class="col-sm-8">{{rtrim(rtrim($item->reserve_price, '0'), '.') . ' ' . $item->currency}} </dd>

                <dt class="col-sm-4">Highest Bid</dt>
                <dd class="col-sm-8"> {{ rtrim(rtrim($highest_bid, '0'), '.') . ' ' . $item->currency }} </dd>

                <dt class="col-sm-4">Highest Bidder</dt>
                <dd class="col-sm-8"> {{ $highest_bidder }} </dd>

                <dt class="col-sm-4">Seller</dt>
                <dd class="col-sm-8">  {{ $seller }} </dd>

                <dt class="col-sm-4">Description</dt>
                <dd class="col-sm-8"> {{ $item->description }} </dd>

                <dt class="col-sm-4">End date</dt>
                <dd class="col-sm-8"> {{ formatDate($item->end_date) }} </dd>

                </dd>
            </dl>
            
            @if(count($item->bids))
                    <ol>
                        @foreach($item->bids as $bid)
                            <li class="{{ $bid->user_id == Auth::id() ? 'you' : '' }}">
                                Ξ {{ rtrim(rtrim($bid->price, '0'), '.') }}, {{ $bid->user->name }}, {{ formatDate($bid->created_at) }}
                            </li>
                        @endforeach
                    </ol>
                @else
                    <p>No bids yet</p>
                @endif 
        </div>

        <div class="col-md-3">
            @if($item->status == 'active')
            <place-bid :itemid = "{{$item->id}}" :highestbid = "'{{$highest_bid}}'" :contractaddress = "'{{$item->contract_address}}'"></place-bid>
            @elseif($item->status == 'sold')
            <div class="alert alert-primary" role="alert">
                <h4 class="alert-heading">This auction has ended</h4>
                <hr>
                <p>The item has been sold to user {{$highest_bidder}}</p> 
            </div>
            @elseif($item->status == 'expired')
            <div class="alert alert-primary" role="alert">
                <h4 class="alert-heading">This auction has expired</h4>
                <hr>
                <p>Not enough bids placed</p> 
            </div>
            @endif

            {{-- <div class="alert alert-info" role="alert">
                <strong>Time Left: </strong> 
            </div>

            <form method="POST" action="placebid">
            @csrf
                <div class="form-group">
                    <label for="exampleInputPassword1">New Bid</label>
                    <input type="text" class="form-control" name="bid">
                    <input type="hidden" value="{{$item->id}}" name="id">
                </div>
                @if($item->status == 'active')  
                    <button type="submit" class="btn btn-primary btn-block">Place bid</button>
                @else
                    <button type="submit" class="btn btn-primary btn-block" disabled>Place bid</button>
                @endif
            </form> --}}
            @if (\Session::has('success'))
                <br>
                <div class="alert alert-success">
                    {!! \Session::get('success') !!}                        
                </div>
            @elseif (\Session::has('fail'))
                <br>
                <div class="alert alert-danger">
                    {!! \Session::get('fail') !!}                        
                </div>
            @endif
        </div>
    </div>
@endsection