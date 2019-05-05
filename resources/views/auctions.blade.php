@extends('layout')

@section('content')
    <h1 class="display-4">Current Auctions</h1>
    <br>
    @if(count($items)>0)
        <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Starting Price</th>
                    <th scope="col">Highest Bid</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Seller</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                    <td><a href="/items/{{$item->id}}">{{$item->title}}</a></th>
                    <td>{{ $item->starting_price }} ETH </td>
                    <td>{{ $item->highest_bid ? $item->highest_bid . ' ' . $item->currency : 'No bids yet' }}</td>
                    <td>{{$item->endDate}}</td>
                    <td>{{$item->seller}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$items->links()}}
        @else
            <p> No items for sale </p>
        @endif  
@endsection