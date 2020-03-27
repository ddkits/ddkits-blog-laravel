@extends('layouts.admin')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')

@section('meta')
<title>{{ $getInfo->getValue('sitename') }}</title>
<meta name="description" content="{{ $getInfo->getValue('description') }}">
<meta name="keywords" content="{{ $getInfo->getValue('main_keywords') }}">
<meta name="title" content="{{ $getInfo->getValue('sitename') }}">
<meta name="author" content="Mutasem Elayyoub">
<meta property="og:title" content="{{ $getInfo->getValue('sitename') }}" />
<meta property="og:type" content="blog.news" />
<meta property="og:url" content="{{ Request::url() }}" />
<meta property="og:site_name" content="{{ $getInfo->getValue('sitename') }}" />
<meta property="og:description" content="{{ $getInfo->getValue('description') }}" />
<meta property="og:image" content="{{ Request::url() }}{{ $getInfo->getValue('homepage_image') }}" />

  @stop
  @section('content')

@stop
