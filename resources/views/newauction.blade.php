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
            <label for="description" class="col-md-4 col-form-label text-md-right">Item Description</label>
            
            <div class="col-md-6">
                <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>

                @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="itemPhoto" class="col-md-4 col-form-label text-md-right">Item Photo</label>
            
            <div class="col-md-6">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="itemPhoto">
                    <label class="custom-file-label" for="itemPhoto">Choose file</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="starting_price" class="col-md-4 col-form-label text-md-right">Starting Price</label>

            <div class="col-md-3">
                <input id="starting_price" type="text" class="form-control{{ $errors->has('starting_price') ? ' is-invalid' : '' }}" name="starting_price" required>

                @if ($errors->has('starting_price'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('starting_price') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-3">
                <select class="form-control" id="currency" name="currency" required>
                    <option selected disabled value="">Select Currency</option>
                    <option value="ETH">ETH</option>
                    <option value="EUR">EUR</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="reservePrice" class="col-md-4 col-form-label text-md-right">Reserve Price</label>
            
            <div class="col-md-6">
                <input id="reservePrice" type="text" class="form-control{{ $errors->has('reservePrice') ? ' is-invalid' : '' }}" name="reservePrice" required>

                @if ($errors->has('reservePrice'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('reservePrice') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="endDate" class="col-md-4 col-form-label text-md-right">End Date</label>
            
            <div class="col-md-3">
                <input id="endDate" type="text" class="form-control{{ $errors->has('endDate') ? ' is-invalid' : '' }}" name="endDate" maxlength="8" placeholder="DD/MM/YY">

                @if ($errors->has('startDate'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('startDate') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-3">
                <select class="form-control" id="duration" name="duration" required>
                    <option selected disabled value="">Duration</option>
                    <option value="1">1 day</option>
                    <option value="3">3 days</option>
                    <option value="7">7 days</option>
                </select>
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