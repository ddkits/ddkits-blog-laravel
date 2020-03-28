@extends('layouts.home')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('feeds','App\Http\Controllers\FeedsCont')
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

@stop


@section('content')
<!-- Main Content -->
    <section class="ddkits-blog-home">
      <div class="container items-center col-md-11 col-sx-11">
          <div class="row">
            @foreach($posts->getAllBlogs()->paginate(1) as $post)
                <div class="ddkits-blog-content col-md-8 col-sx-8">
                        <a href="{{ route('article.show', $post->path) }}" class=" fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-12 col-sx-12">
                          <img class="" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">
                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                          <div class="author"><p>By: {{ $user->find($post->uid)->firstname }} {{ $user->find($post->uid)->lastname }}</p>
                          <p>Categories:
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p></div>
                         <!-- <p>Tags:
                          @foreach($posts->nTags($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p> -->
                        </div>
                        <div class="whytopost-blog-home">
                         <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>
                      </a>
             </div>
          @endforeach

          <!-- show only on -->
          @foreach($posts->getAllBlogs()->paginate(2)->splice(1) as $post)
                <div class="ddkits-blog-content col-md-4 col-sx-4">
                        <a href="{{ route('article.show', $post->path) }}" class="black fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-12 col-sx-12">
                          <img class="" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">
                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                          <div class="author"><p>By: {{ $user->find($post->uid)->firstname }} {{ $user->find($post->uid)->lastname }}</p>
                          <p>Categories:
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p></div>
                         <!-- <p>Tags:
                          @foreach($posts->nTags($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p> -->
                        </div>
                        <div class="whytopost-blog-home">
                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>
                      </a>
             </div>
          @endforeach

          <!-- show all after first tow  -->
            @foreach($posts->getAllBlogs()->paginate(5)->splice(2) as $post)
                <div class="ddkits-blog-content col-md-4 col-sx-4">
                        <a href="{{ route('article.show', $post->path) }}" class="black fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-12 col-sx-12">
                          <img class="" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">
                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                          <div class="author"><p>By: {{ $user->find($post->uid)->firstname }} {{ $user->find($post->uid)->lastname }}</p>
                          <p>Categories:
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p></div>
                         <!-- <p>Tags:
                          @foreach($posts->nTags($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p> -->
                        </div>
                        <div class="whytopost-blog-home">
                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>
                      </a>
             </div>
          @endforeach
          <!-- show all after last row  -->
            @foreach($posts->getAllBlogs()->paginate(6)->splice(5) as $post)
                <div class="ddkits-blog-content col-md-4 col-sx-4">
                        <a href="{{ route('article.show', $post->path) }}" class="black fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-12 col-sx-12">
                          <img class="" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">
                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6 col-sx-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 120, 'yes') }}</p></div>
                          <div class="author"><p>By: {{ $user->find($post->uid)->firstname }} {{ $user->find($post->uid)->lastname }}</p>
                          <p>Categories:
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p></div>
                         <!-- <p>Tags:
                          @foreach($posts->nTags($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p> -->
                        </div>
                        <div class="whytopost-blog-home">

                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>
                      </a>
             </div>
          @endforeach

             <!-- show all after last row  -->
            @foreach($posts->getAllBlogs()->paginate(7)->splice(6) as $post)
                <div class="ddkits-blog-content col-md-8 col-sx-8">
                        <a href="{{ route('article.show', $post->path) }}" class="black fondo-ddkits-home">
                        <div class="img-ddkits-principal-home col-md-6">
                          <img class="" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">
                        </div>
                        <div class="whytopost-ddkits-principal-home pull-right col-md-6">
                          <div class="title">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 150, 'yes') }}</p></div>
                          <div class="author"><p>By: {{ $user->find($post->uid)->firstname }} {{ $user->find($post->uid)->lastname }}</p>
                          <p>Categories:
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p></div>
                         <!-- <p>Tags:
                          @foreach($posts->nTags($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p> -->
                        </div>
                        <div class="whytopost-blog-home">
                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>
                      </a>
             </div>
          @endforeach
        </div>
      </div>
  </section>
@include('includes.google-ad')
  <section  class="ddkits-blog-home-recent">
      <div class="container items-center col-md-11 col-sx-11">
        <div class="row">
           <!-- show all after last row  -->
           @include('includes.feeds-related', ['howMany' => 10,'random' => false, 'showMore' => 1, 'source' => false])
          @include('includes.google-ad')
            @foreach($posts->getHomeBlogs()->paginate(10) as $post)
            <a href="{{ route('article.show', $post->path) }}" class="black fondo-ddkits-home  col-md-6">
                <div class="ddkits-blog-content-home col-md-12 col-sx-12" >

                        <div class="img-ddkits-principal-home">
                          <img class="ddkits" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">
                        </div>
                        <div class="whytopost-ddkits-principal-home">
                          <div class="title col-md-12">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
                          <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 50, 'yes') }}</p></div>
                          <div class="author col-md-2 col-xs-2"><p>By: {{ $user->find($post->uid)->firstname }} {{ $user->find($post->uid)->lastname }}</p>
                          <!-- <p>Categories:
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p> --></div>
                         <!-- <p>Tags:
                          @foreach($posts->nTags($post->id, 'blog') as $catKey => $cat)
                              {{ $cat }},
                           @endforeach
                         </p> -->
                        </div>
                        <div class="whytopost-blog-home">
                          <span>Read more about {{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</span><br>
                          @foreach($posts->nCategories($post->id, 'blog') as $catKey => $cat)
                              "{{ $cat }}"
                           @endforeach
                        </div>
              </div>
             </a>
          @endforeach

          </div>
      </div>
       <!-- Pager -->
          <div class="clearfix center">
            <a class="btn btn-primary" href="{{ route('blog.index') }}">More Posts &rarr;</a>
          </div>
          @include('includes.google-ad')
  </section>
<script>
  function clearMouse() {
      $("titlesContent").hide();
  }
  </script>
@stop


