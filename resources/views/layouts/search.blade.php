<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    {{-- <link rel="canonical" href="{{ env('APP_URL') }}"> --}}
    <link rel="canonical" href="https://english.mawajez.com">
    @include('includes.headHome')
    @yield('meta')

</head>
<body>
@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->

<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <!-- Search Box-->
      @include('includes.headerHome')
    </nav>

    <!-- Page Header -->
    <!-- <header class="masthead" style="background: url('/{{ $getInfo->getValue('homepage_image') }}') no-repeat;
    background-attachment: absolute;
    background-size: 100% 100%;"> -->

      <header class="masthead col-md-12">
        <div id="highlights-load">

        <div id="header-background"></div>

    </div>
    </header>
    @include('includes.google-ad')
     <section>
     @yield('content')
      <div id="ddkitsPopup" style="padding:0; margin:0; display:none;"></div>
     </section>
    <hr>

    <!-- Footer -->
    <footer>
      <div class="container">
            @include('includes.footer')
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/popper/popper.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/ddkits.min.js"></script>
    <script src="/js/all.js"></script>
    <!-- Custom scripts for this template -->

  <!-- Google Analytics -->
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
