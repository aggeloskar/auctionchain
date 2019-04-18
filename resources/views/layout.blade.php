<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
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
    <div class="container">
    @yield('content')
    </div>  

    <!-- Footer -->
    @include('footer')

    <!-- Scripts: Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/holder.min.js') }}"></script>
    <script src="{{ URL::asset('js/App.js') }}"></script>

  </body>
</html>