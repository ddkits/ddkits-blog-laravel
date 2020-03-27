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
      	<div class="pull-right">Found: {{$results->count() }} Post(s)</div>
        <div class="">
          <div class="row-page row">

   @if($results->count() > 0)
        @foreach($results->paginate(6) as $postRes)
            <div class="ddkits-blog-content col-md-4 col-sx-4">
                <a href="{{ route('articles.show', $postRes->id) }}" class="black fondo-ddkits-home">
                <div class="img-ddkits-principal-home col-md-6 col-sx-6">
                    <img class="" src="/{{ $postRes->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;">
                </div>
                <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                    <div class="title">{{ $getInfo->encoded($postRes->title, 0, 50, 'yes') }}</div>
                    <div class="body"><p>{{ $getInfo->encoded($postRes->body, 0, 150, 'yes') }}</p></div>
                    <div class="author"><p>By: {{ $user->find($postRes->uid)->firstname }} {{ $user->find($postRes->uid)->lastname }}</p>
                    <p>Categories:
                    @foreach($posts->nCategories($postRes->id, 'blog') as $catKey => $cat)
                        {{ $cat }},
                    @endforeach
                    </p></div>

                </div>
                <div class="whytopost-blog-home">
                    <span>Read</span><br>
                    @foreach($posts->nCategories($postRes->id, 'blog') as $catKey => $cat)
                        "{{ $cat }}"
                    @endforeach
                </div>
                </a>
              </div>
              @endforeach
            {{ $results->paginate(6)->links() }}
     	@endif
     	</div>
      </div>
      <div class="pull-right">Found: {{$usersResults->count() }} Author(s) {{ (($categories == 'yes' )? 'used this Category':'') }}</div>
      <div class="">
       <div class="row-page row">
     @if($usersResults->count() > 0)


    @foreach($usersResults->get() as $author)
       <div class="ddkits-blog-content col-md-4 col-sx-4">
              <a href="{{ route('profile.show', $author->profile) }}" class="black fondo-ddkits-home">
                <div class="img-ddkits-principal-home col-md-6 col-sx-6">
                  <img class="" src="/{{ $getProfile->getProfInfo($author->profile)->picture }}" style="background-position: fixed;background-attachment: fixed;background-size: cover;">
                </div>
                <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                  <h3>{{ ucfirst($author->firstname) }} {{ ucfirst($author->lastname) }}</h3>
                  <p>{{ $getProfile->getProfInfo($author->profile)->description }}</p>
                </div>
                <div class="whytopost-blog-home">
                  <span>View Profile</span>
                </div>
              </a>
            </div>
     @endforeach

     	@endif
        </div>
      </div>
      <!-- Pager -->
          <div class="clearfix center">
            <a class="btn btn-primary " href="{{ route('blog.index') }}">More Posts &rarr;</a>
          </div>
    </div>
  </section>

@stop
