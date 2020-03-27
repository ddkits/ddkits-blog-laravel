<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	 <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="all,follow">
   {{-- <link rel="canonical" href="{{ env('APP_URL') }}"> --}}
   <link rel="canonical" href="https://english.mawajez.com">
    @include('includes.profileHead')
    @yield('meta')
     @yield('styles')
</head>
<body class="mainbody container-fluid">

	 @inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->
  <div id="containerBody">
           <div class="navbar-wrapper">
            <div class="container-fluid">
                <div class="navbar navbar-default navbar-static-top" role="navigation">
                    @include('includes.navBar')
                </div>
            </div>
        </div>

    <div style="padding-top:50px;"> </div>
        @yield('leftSideBar')
        <!-- Page Header-->
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          	@include('partials._messages')
          	@yield('title')
		</div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" >
            @yield('content')
            @include('includes.google-ad')
    </div>
  </div>
    <!-- Javascript files-->

    <script language="JavaScript" type="text/javascript" src="/js/tether.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="/js/jquery.cookie.js"></script>
    <script language="JavaScript" type="text/javascript" src="/js/jquery.validate.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="/js/front.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="/js/all.js"></script>
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create',"{{ $getInfo->getValue('google_analytic') }}");ga('send','pageview');
    </script>
        <div id="ddkitsPopup" style="padding:0; margin:0; display:none;"></div>

  </body>
</html>
