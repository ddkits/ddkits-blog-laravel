@extends('layouts.error')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->

@section('meta')
<meta name="title" content="{{ $getInfo->getValue('sitename') }}">
<meta name="description" content="{{ $getInfo->getValue('description') }}, {{ $exception->getMessage() }}">
<meta name="keywords" content="{{ $getInfo->getValue('main_keywords') }}">
<meta name="author" content="{{ $getInfo->getValue('powered_by') }}">
<style type="text/css">
    .site-heading{
        display:none;
    }
    .masthead{
        height: 100px;
    }
  </style>
@stop


@section('content')
<!-- Main Content -->
            <form id="login-form">
            <div class="title" style="color: black;">We are sorry, not found. </div>
            <br><a class="btn" href="{{ redirect()->getUrlGenerator()->previous() }}">Click Here to go back</a>
             </form>
@stop
