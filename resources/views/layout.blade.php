<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="../../../../favicon.ico">

    <title>@yield('title', 'Blockchain Auctions')</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('/css/bootstrap.min.css') }}">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ URL::asset('/css/style.css') }}">

  </head>

  <body>
    <!-- Navbar -->
    @include('navbar')
    
    <!-- Main content -->
    <div id="app" class="container">
      @yield('content')

    </div>  

    @include('modal')
    <!-- Footer -->
    @include('footer')

    <!-- Scripts: Placed at the end of the document so the pages load faster -->
    <script src="{{ URL::asset('https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js') }} "></script>
    <script src="{{ URL::asset('js/scripts.js') }}"></script>
    <script src="{{ URL::asset('js/app.js') }}"></script>


  </body>
</html>