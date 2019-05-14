@extends('layout')

@section('content')
    <h1 class="display-4">Pay for {{$item->title}}</h1>
    <br>
    <div class="row mb-3">
        You have to pay {{$highest_bid}} {{$item->currency}} to user {{ $seller->name }}
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pay with PayPal</h5>
                <p class="card-text">{{$highest_bid}} {{$item->currency}}</p>
                <a href="#" class="btn btn-primary">PayPal Button</a>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pay with Ethereum</h5>
                <p class="card-text">{{$highest_bid}} {{$item->currency}}</p>
                @if($item->currency == 'ETH')
                    <button class="btn btn-primary pay-button">Pay</button>
                @else
                    <button class="btn btn-primary pay-button" disabled>Pay</button>
                @endif
            </div>
            <div id="status"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pay with Credit Card</h5>
                <p class="card-text">{{$highest_bid}} {{$item->currency}}</p>
                <button href="#" class="btn btn-primary" disabled>Pay</button>
            </div>
            </div>
        </div>
    </div>
    <div class="alert alert-status status"></div>


@endsection