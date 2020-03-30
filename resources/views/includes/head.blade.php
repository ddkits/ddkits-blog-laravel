@inject('getInfo', 'App\Http\Controllers\AdminCont')
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Google fonts - Roboto -->
    {{--  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins:300,400,700">  --}}
    <!-- Favicon-->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    {{--  <script src="//use.fontawesome.com/99347ac47f.js"></script>  --}}
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Font Icons CSS-->
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <!-- Bootstrap core CSS -->
    <!-- Custom styles for this template -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('/css/style.home.css') }}" rel="stylesheet" >
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" >
    <script src="{{ asset('/js/admin.js') }}"></script>
    <script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <!-- Javascript files-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/tether.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.cookie.js"></script>
    <script src="/js/jquery.validate.min.js"></script>

    <script src="/js/front.js"></script>
    <!-- CKeditors for laravel -->
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

    <script src="/js/select2.min.js"></script>
    <link href="/css/select2.min.css" rel="stylesheet" />
    {{--  <link href="//cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="//cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>  --}}

    <script>
    (function(){
        $('.ckeditor').ckeditor();
        });
    </script>
