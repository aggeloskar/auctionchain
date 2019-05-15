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
                    <th scope="col">Reserve price</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                    <td><a href="/items/{{$item->id}}">{{$item->title}}</a></th>
                    <td>{{ $item->starting_price . ' ' . $item->currency }}  </td>
                    <td>{{ $item->reserve_price }}</td>
                    <td>{{ formatDate($item->end_date)}}</td>
                    <td>{{ $item->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$items->links()}}
        @else
            <p> No items for sale </p>
        @endif  
@endsection