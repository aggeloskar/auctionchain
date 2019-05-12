@extends('layout')

@section('content')
    <h1 class="display-4">My Profile</h1>
    <br>

    <div class="row">
        <div class="col-sm-3">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$user->name}}</h5>
                <hr>
                <p>Full Name<p>
                <p class="card-text">{{$user->email}}</p>
                
                <a href="#" class="btn btn-primary">Change email</a>
            </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Items won</h5>
                <hr>
                <ul class="list-unstyled mt-3 mb-4">
                    @foreach($items as $item)
                    <li><a href="/items/{{$item->id}}">{{$item->title}}</a></li>
                    @endforeach
                    </ul>
            </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Bids</h5>
                <hr>
                <ul class="list-unstyled mt-3 mb-4">
                        @foreach($items as $item)
                        <li><a href="/items/{{$item->id}}">{{$item->title}}</a></li>
                        @endforeach
                        </ul>
            </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Something</h5>
                <hr>
                <p>Something else</p> 
                
            </div>
            </div>
        </div>
    </div>

@endsection