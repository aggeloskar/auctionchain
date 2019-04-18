<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <a href="/" class="my-0 mr-md-auto"><img src="{{ URL::to('/') }}/images/logo.png"  height="38" alt=""></a>
    <nav class="my-2 my-md-0 mr-md-3">
    <a class="p-2 text-dark" href="/">Home</a>
    <a class="p-2 text-dark" href="/items">Auctions</a>
    @auth
        <a class="p-2 text-dark" href="/new-auction">New Auction</a>
    @endauth
    <a class="p-2 text-dark" href="/about">About</a>
    </nav>
    @guest
        <a id="loginDropdown" class="btn btn-outline-primary dropdown-toggle" href="/singin" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Join now
        </a>
        <div class="dropdown-menu" aria-labelledby="loginDropdown">
            <a class="dropdown-item" href="/login">Log in</a>
            <a class="dropdown-item" href="/register">Register</a>
        </div>
    @else 
        <a id="userDropdown" class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
        </div>
    @endguest
</div>