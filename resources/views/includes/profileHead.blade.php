    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Google fonts - Roboto -->
    <!-- Favicon-->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <!-- Bootstrap core CSS -->
    <script src="/vendor/popper/popper.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Custom styles for this template -->
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Custom styles for this template -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="/css/profile.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap2.min.css" rel="stylesheet" id="theme-stylesheet">
    {{--  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">  --}}

    <!-- CKeditors for laravel -->
 <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
 <script language="JavaScript" type="text/javascript" src="{{ asset('/js/profile.js') }}"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script src="/js/select2.min.js"></script>
    <link href="/css/select2.min.css" rel="stylesheet" />
    <script>
       (function () {
        $('.ckeditor').ckeditor();
         });
    </script>
