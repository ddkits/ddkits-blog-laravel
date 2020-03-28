@extends('layouts.news')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('feedsCont', 'App\Http\Controllers\FeedsCont')
@inject('feeds','App\Http\Controllers\FeedsCont')

<!-- {{ $getInfo->getValue('sitename') }} -->

@section('meta')
<title>{{ $getInfo->getValue('sitename') }} | News</title>
<meta name="description" content="{{ $getInfo->getValue('description') }}">
<meta name="keywords" content="{{ $getInfo->getValue('main_keywords') }}, News">
<meta name="title" content="{{ $getInfo->getValue('sitename') }} | News">
<meta name="author" content="Mutasem Elayyoub">
<meta property="og:title" content="{{ $getInfo->getValue('sitename') }}| News" />
<meta property="og:type" content="blog.news" />
<meta property="og:url" content="{{ Request::url() }}" />
<meta property="og:site_name" content="{{ $getInfo->getValue('sitename') }} | News" />
<meta property="og:description" content="{{ $getInfo->getValue('description') }}" />
<meta property="og:image" content="{{ Request::url() }}{{ $getInfo->getValue('homepage_image') }}" />

@stop


@section('content')
@php
  $date = '';
  @endphp
<!-- Main Content -->
    <section class="ddkits-blog-home">
      <div class="container items-center col-md-11 col-sx-11">
          <div class="row">
            @foreach($feedsCont->getHomeNews(false, false)->paginate(1) as $post)
                <div class="ddkits-blog-content col-md-8 col-sx-8">
                        <a href="{{ route('feeds.showPage', $post->path) }}" class=" fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-6 col-sx-6">
                          <img class="" src="{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">
                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                          <div class="small">{{ date('D M/d/Y', strtotime($post->created_at)) }}</div>
                          <div class="author"><p>By: {{ $post->author }}</p>
                          </div>
                        </div>
                        {{--  <div class="whytopost-blog-home">
                         <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'feed') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>  --}}
                      </a>
             </div>
             @php
            $date=$post->created_at;
           @endphp
          @endforeach
          <!-- show only on -->
          @foreach($feedsCont->getHomeNews(false, false)->paginate(2)->splice(1) as $post)
                <div class="ddkits-blog-content col-md-4 ">
                        <a href="{{ route('feeds.showPage', $post->path) }}" class="black fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-6 col-sx-6">
                          <img class="" src="{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">                        </div>
                          <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                          <div class="small">{{ date('D M/d/Y', strtotime($post->created_at)) }}</div>
                          <div class="author"><p>By: {{ $post->author }}</p>                          </div>
                        </div>
                        {{--  <div class="whytopost-blog-home">
                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'feed') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>  --}}
                      </a>
             </div>
             @php
            $date=$post->created_at;
           @endphp
          @endforeach
          <div class="ddkits-blog-content col-md-4 ">
                      <div class="black fondo-ddkits-home">
                        @include('includes.google-ad')
                      </div>
                  </div>
          <!-- show all after first tow  -->
            @foreach($feedsCont->getHomeNews(false, false)->paginate(4)->splice(2) as $post)
                <div class="ddkits-blog-content col-md-4 ">
                        <a href="{{ route('feeds.showPage', $post->path) }}" class="black fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-6 col-sx-6">
                          <img class="" src="{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                          <div class="small">{{ date('D M/d/Y', strtotime($post->created_at)) }}</div>
                          <div class="author"><p>By: {{ $post->author }}</p>                          </div>
                        </div>
                        {{--  <div class="whytopost-blog-home">
                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'feed') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>  --}}
                      </a>
             </div>
             @php
            $date=$post->created_at;
           @endphp
          @endforeach
          <!-- show all after last row  -->
            @foreach($feedsCont->getHomeNews(false, false)->paginate(5)->splice(4) as $post)
                <div class="ddkits-blog-content col-md-4 ">
                        <a href="{{ route('feeds.showPage', $post->path) }}" class="black fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-6 col-sx-6">
                          <img class="" src="{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 120, 'yes') }}</p></div>
                          <div class="small">{{ date('D M/d/Y', strtotime($post->created_at)) }}</div>
                          <div class="author"><p>By: {{ $post->author }}</p>                          </div>
                        </div>
                        {{--  <div class="whytopost-blog-home">
                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'feed') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>  --}}
                      </a>
             </div>
             @php
            $date=$post->created_at;
           @endphp
          @endforeach
             <!-- show all after last row  -->
            @foreach($feedsCont->getHomeNews(false, false)->paginate(6)->splice(5) as $post)
                <div class="ddkits-blog-content col-md-8 col-sx-8">
                        <a href="{{ route('feeds.showPage', $post->path) }}" class="black fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-6">
                          <img class="" src="{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                          <div class="small">{{ date('D M/d/Y', strtotime($post->created_at)) }}</div>
                          <div class="author"><p>By: {{ $post->author }}</p>             </div></div>
                        {{--  <div class="whytopost-blog-home">
                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'feed') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>  --}}
                      </a>
               </div>
             @php
            $date=$post->created_at;
           @endphp
          @endforeach
                <div class="ddkits-blog-content col-md-4 ">
                      <div class="black fondo-ddkits-home">
                        @include('includes.google-ad')
                      </div>
                  </div>
          <!-- show all after first tow  -->
          @foreach($feedsCont->getHomeNews(false, false)->paginate(13)->splice(6) as $post)
              <div class="ddkits-blog-content col-md-4 ">
                      <a href="{{ route('feeds.showPage', $post->path) }}" class="black fondo-ddkits-home">
                      <div class="img-ddkits-principal-home col-md-6 col-sx-6">
                        <img class="" src="{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">                        </div>
                      <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                        <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                        <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                        <div class="small">{{ date('D M/d/Y', strtotime($post->created_at)) }}</div>
                        <div class="author"><p>By: {{ $post->author }}</p></div>
                      </div>
                      {{--  <div class="whytopost-blog-home">
                        <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                        @foreach($posts->nCategories($post->id, 'feed') as $catKey => $cat)
                            "{{ $cat }}"
                         @endforeach
                      </div>  --}}
                    </a>
           </div>
           @php
            $date=$post->created_at;
           @endphp
        @endforeach
        <div class="ddkits-blog-content col-md-4 ">
                      <div class="black fondo-ddkits-home">
                        @include('includes.google-ad')
                      </div>
                  </div>
        </div>
      </div>
  </section>
  <section  class="ddkits-blog-home-recent">
      <div class="container items-center col-md-11 col-sx-11">
        <div class="row">
           <!-- show all after last row  -->
           @include('includes.feedsHome-related', [
               'howMany' => 26,
               'random' => false,
               'showMore' => 1,
               'date' => $date,
               'source' => 'all',
               'splice'=> 13
               ])
          @include('includes.google-ad')
          </div>
      </div>
  </section>
<script>
  function clearMouse() {
      $("titlesContent").hide();
  }
  </script>
@stop


