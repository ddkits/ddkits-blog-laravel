<!DOCTYPE html>
<html>
  <head>
  {{-- <link rel="canonical" href="{{ env('APP_URL') }}"> --}}
  <link rel="canonical" href="https://english.mawajez.com">
  @yield('meta')
    @include('includes.head')
     @yield('styles')
</head>


@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->

 <div class="page home-page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="/dashboard" class="navbar-brand">
                  <div class="brand-text brand-big hidden-lg-down"><span> {{ $getInfo->getValue('sitename') }}</span><strong> Dashboard </strong></div>
                  <div class="brand-text brand-small"><strong> {{ $getInfo->getValue('sitename') }} </strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              @include('includes.header')
              </div>
          </div>
        </nav>
      </header>
      <div id="ddkitsPopup" style="padding:0; margin:0; display:none;"></div>
<body>



    <div id="containerBody" class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
          @include('admin.profileBlock')

          <!-- Sidebar Navidation Menus-->
          <span class="heading">Main</span>
            @include('includes.menu')
        </nav>
        <div class="content-inner">
        <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">@yield('title')</h2>
            </div>
          </header>
          @include('partials._messages')
          <section class="charts">
            <div class="container-fluid">
              <div class="row">
          @yield('content')
              </div>
            </div>
          </section>
          <!-- Page Footer-->
          <footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p>@include('includes.footer')</p>
                </div>
                <div class="col-sm-6 text-right">
                </div>
              </div>
            </div>
          </footer>
        </div>
      </div>
            <div id="ddkitsPopup" style="padding:0; margin:0; display:none;"></div>

      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create',"{{ $getInfo->getValue('google_analytic') }}");ga('send','pageview');
    </script>
  </body>
</html>
