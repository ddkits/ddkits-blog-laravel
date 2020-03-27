@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->
<div class="search-box">
      <button class="dismiss"><i class="icon-close"></i>x</button>
      {{ Form::open(['method'=>'GET', 'url'=>'search', 'id'=>'searchForm', 'role'=>'search']) }}
      {{ Form::text('search', '', ['class'=>'form-control', 'placeholder'=>'What are you looking for...'] ) }}
      {{ Form::close() }}
    </div>
<div class="container">
        <a class="navbar-brand" href="/">{{ $getInfo->getValue('sitename') }}</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item d-flex align-items-center" id="search"><a id="search"><i class="icon-search"></i>Search</a></li>
              @include('includes.homemainmenu')
            @if (Auth::guest())
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
            @else
            <li class="nav-item">
              <a class="nav-link" href="/dashboard">
              {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            @endif
          </ul>
        </div>
      </div>

