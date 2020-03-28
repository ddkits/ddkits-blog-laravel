@extends('layouts.search')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->

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
    <section class="ddkits-blog-home">
      <div class="container">
      	<div class="pull-right">Found: {{$results->count() }} Video(s)</div>
        <div class="">
          <div class="row-page row">

   @if($results->count() > 0)
        @foreach($results->paginate(9) as $postRes)
            <div class="ddkits-blog-content col-md-4 col-sx-4">
                <a class="popup fondo-ddkits-home"  data-link="{{ str_replace('//www.youtube.com/watch?v=','//www.youtube.com/embed/',$postRes->guid) }}" >
                <div class="img-ddkits-principal-home col-md-6 col-sx-6">
                    <img class="" src="/{{ $postRes->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;">
                </div>
                <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                    <div class="title">{{ $getInfo->encoded($postRes->title, 0, 50, 'yes') }}</div>
                    <div class="author">
                    <p>Categories:
                    {{ $postRes->tags }}
                    </p></div>

                </div>
                <div class="whytopost-blog-home">
                    <span>Read</span><br>
                    {{ $postRes->categories }}
                </div>
                </a>
              </div>
              @endforeach
            {{ $results->paginate(9)->links() }}
     	@endif
     	</div>
      </div>

  </section>

@stop
