@extends('layout')
@section('content')

<h1 class="display-1 text-center">404</h1>
<h1 class="display-4 text-center">Not found</h1>

<h2>{{ $exception->getMessage() }}</h2>
@endsection