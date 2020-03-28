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
    <div id="video-view" style="top:20%;left:0;display:none;width:100%;position:fixed;z-index:10;background:black;padding:50px">
        <a id="closevideo" class="pull-right col-md-12" style="cursor:pointer" aria-valuetext="close video"><h3>X Close</h3></a>
        @include('includes.google-ad')
    </div>


    @include('includes.google-ad')

     <section>

     @yield('content')
      <div id="ddkitsPopup" style="padding:0; margin:0; display:none;"></div>
      <script>
        $("a.popup").click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var $iframe = $("<iframe>")
                .attr("src", $this.data("link"))
                .attr("style", "width:100%;height:400px");
            var $title = $("<h1>").text($this.data("title"));
            $("#video-view")
                .append($iframe)
                .show();
            $iframe.wrap("<div class='class-video'>");
        });
        $("a#closevideo").click(function(e) {
            e.preventDefault();
            $("#video-view iframe").remove();
            $("#video-view").hide();
        });
</script>
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
