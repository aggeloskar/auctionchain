@extends('layout')

@section('content')
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Blockchain auctions</h1>
      <p class="lead">Decentralized auctions with key benefits. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce at sollicitudin orci. Ut auctor, nunc id mattis faucibus, est ante fermentum turpis, et porta ligula nulla ut justo. </p>
    </div>
    <example-component></example-component>


    <div class="container">
      <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Ethereum Status</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
              <li>Address:<span id='account'></span></li>
              <li>Balance:</li>
              <li>Network:</li>
            </ul>
          </div>
        </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Latest Auctions</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
              @foreach($items as $item)
              <li><a href="/items/{{$item->id}}">{{$item->title}}</a></li>
              @endforeach
            </ul>
            <a href="/items" role="button" class="btn btn-lg btn-block btn-primary">View All</a>
          </div>
        </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Auctions</h4>
          </div>
          <div class="card-body">
            <!--<h1 class="card-title pricing-card-title">$29 <small class="text-muted">/ mo</small></h1>-->
            <ul class="list-unstyled mt-3 mb-4">
              <li>Lorem ipsum dolor sit amet.</li>
              <li>Adipisicing elit commodi. </li>
              <li>Corrupti est molestias. </li>
              <li>Accusantium porro alias. </li>
            </ul>
            <a href="/new-auction" role="button" class="btn btn-lg btn-block btn-primary">New Auction</a>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection