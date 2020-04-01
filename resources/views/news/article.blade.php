@extends('layouts.article')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->


@section('meta')
<title>{{ $getInfo->getValue('sitename') }} | {{ $post->title }}</title>
<meta name="title" content="{{ $post->title }}">
<meta name="description" content="{{ $getInfo->encoded($post->body, 0, 200, 'yes') }}">
<meta name="keywords" content="{{ $getInfo->getValue('main_keywords') }}, {{ $post->tags }}, {{ $post->categories }}">
<meta name="author" content="{{ $post->author }}">
<meta property="og:title" content="{{ $post->title }}" />
<meta property="og:type" content="blog.news" />
<meta property="og:url" content="{{ Request::url() }}" />
@php
   $image= env('APP_URL').'/'.$post->image;
@endphp
<meta property="og:image" content="{{ $image }}" />
<meta property="og:site_name" content="{{ $getInfo->getValue('sitename') }}" />
<meta property="og:description" content="{{ $getInfo->encoded($post->body, 0, 200, 'yes') }}" />

@stop

@section('header')
@if (strpos($post->image, 'http') !== true)
    <header class="masthead ddkits-trans container" style="margin-top:75px;background: url('/{{ $post->image }}') no-repeat;
    background-attachment: absolute;
    background-size: 100% 100%;height: 300px;
    " alt="{{ $post->title }}">
    </header>
      @else
    <header class="masthead ddkits-trans container" style="margin-top:75px;background: url('{{ $post->image }}') no-repeat;
    background-attachment: absolute;
    background-size: 100% 100%;height: 300px;
    " alt="{{ $post->title }}">
    </header>
  @endif
@stop

@section('content')

<section class="ddkits-blog-home ">
      <div class="container ">
        <div class="">
          <div class="container">

              <div class="col-lg-8 col-md-10 mx-auto box-shadow">
                <div class="site-heading hoverable">

                  <h1>{{ $post->title }}{!! $Views->addView($post->id) !!}</h1>

              </div>
            </div>
          </div>
          <div class="row-page align-items-center">
        <div class="ddkits-blog-content col-md-12">
          <section>
                  <p>{!! $getInfo->encodeOnly($post->body) !!}</p>
                  @include('includes.social-media')
                  @include('includes.google-ad')

          </section>
                  <p><a href="{{ $post->guid }}" target="_blank" rel="nofollow"> {{ $post->guid }}</a></p>
                  @if($posts->nCategories($post->id, 'feed'))
                  <span class="categories">
                      @foreach($posts->nCategories($post->id, 'feed') as $catKey => $cat)
                              <div hidden>{{ $cat }}
                              {{ Form::open(['method'=>'GET', 'url'=>'search', 'id'=>$cat, 'role'=>'categories']) }}
                              {{ Form::text('categories', $cat) }}
                            </div>
                              {{ Form::submit($cat) }}
                              {{ Form::close() }}
                           @endforeach
                  </span>
                  @endif
                  <p>By: {{ $post->author }} - Viewed: {{ $Views->getFeedViews($post->id) }}

            </div>
        </div>
      </div>
    </div>
    @include('includes.google-ad')

  </section>
  <section id="comments" class=" ddkits-blog-home col-md-12 col-xs-12">
      <div class="container">
        <div class="">
          <div class="row-page align-items-center">
        <div class="ddkits-blog-content col-md-12 col-xs-12">
           @if($comments)
          @foreach ($comments as $comment)
                          <hr>
                      <div>
                          <div class="post-content">
                              <div class="panel-default">
                                  <div class="row panel-body" style="text-decoration:none;">
                                        <div class="imageComments col-md-1 col-xs-1 align-items-right">
                                          <img src="/{{ $getProfile->getProfInfo($comment->uid)->picture  }}" width="35px" height="35px" >
                                        </div>
                                          <div class="nameComments col-md-2 col-xs-2">
                                            <a href="/profile/{{ $getProfile->getProfInfo($comment->uid)->id }} " style="text-decoration:none;"><strong>{{ $getProfile->getUserInfo($comment->uid)->firstname }} {{ $getProfile->getUserInfo($comment->uid)->lastname }}</strong></a>
                                          </div>
                                      <div class="right-col col-md-9 pull-right comment-body">
                                          {{ $comment->body }}
                                          <br><small><small><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at }}</i></a></small></small>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
               @endforeach
               @endif
              </div>
        </div>
      </div>
    </div>
  </section>

  @if(Auth::user())
  <section class="col-md-12" id="commentForm">
    <script>
              $(function () {
                $('form').on('submit', function (e) {
                  e.preventDefault();
                  $.ajax({
                    type: 'post',
                    url: '/comment',
                    data: $('form').serialize(),
                    success: function () {
                      $("form").trigger('reset');
                      $("#comments").load(location.href + " #comments");
                    }
                  });
                });
              });
            </script>
      <div class="container">
        <div class="">
      <div class="row-page align-items-center">
        <div class="ddkits-blog-content row">
          <div class="col-md-1 imageComments">
                  <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}" width="35px" height="35px" style="margin-left:3px; margin-right:-5px;">
          </div>

         <div class="pull-right col-md-11">
              {!! Form::open(['route' => 'comment.store']) !!}

                   {{ Form::textarea('body', null, array('class' => 'Form-control col-md-9 pull-left d-flex align-items-center', 'required' => '', 'rows' => 1)) }}
                   <div hidden>
                    {{ Form::text('title', $post->uid) }}
                    {{ Form::text('nid', $post->id) }}
                    {{ Form::text('uid', Auth::user()->id) }}
                    {{ Form::text('redirect', 'blog.show') }}
                    {{ Form::number('redirectID', $post->id ) }}
                    {{ Form::text('type', 'blog') }}
                  </div>
                  <div class="col-md-3 pull-right">
                  {!! Form::submit('Comment', ['class'=>'btn btn-xs commentBtn']); !!}
                  </div>
                       {!! Form::close() !!}
            </div>
          </div>
       </div>
        </div>
      </div>
  </section>
  @else
      <section class="ddkits-blog-home col-md-12 row">
          <div class="container">
            <div class="">
          <div class="row-page align-items-center">
            <div class="ddkits-blog-content row">
           </div>
            </div>
          </div>
      </section>
    @endif
    <div class="col-md-12 align-middle">
            <section  class="ddkits-blog-home-recent">
                    <div class="container items-center">
                      <div class="row">
                            @include('includes.feeds-related', [
                                'howMany' => 10,
                                'random' => true,
                                'showMore' => 0,
                                'source' => $post->source
                                ])
                      </div>
                    </div>
</section>
<section  class="ddkits-blog-home-recent">
        <div class="container items-center">
          <div class="row">
                @include('includes.blogs-related')
          </div>
        </div>
</section>


@stop
