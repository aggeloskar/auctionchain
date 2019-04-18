@extends('layout')

@section('content')
    <h1 class="display-4 text-center">New Auction</h1>
    <br>
    <form method="POST" action="items">
        @csrf

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">Item title</label>

            <div class="col-md-6">
                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('title'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="starting_price" class="col-md-4 col-form-label text-md-right">Starting Price</label>

            <div class="col-md-6">
                <input id="starting_price" type="text" class="form-control{{ $errors->has('starting_price') ? ' is-invalid' : '' }}" name="starting_price" required>

                @if ($errors->has('starting_price'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('starting_price') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </div>
    </form>
    @if (\Session::has('success'))
            <br>
            <div class="col-md-6 offset-md-4 alert alert-success">
                {!! \Session::get('success') !!}                        
            </div>
    @endif
    
@endsection