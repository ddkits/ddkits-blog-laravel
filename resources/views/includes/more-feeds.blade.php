{{-- Feeds homepage --}}
@foreach($feeds->paginate(16) as $post)
@php
$last_id = $post->id;
@endphp
<a href="{{ route('feeds.showPage', $post->path) }}" class="black fondo-ddkits-home  col-md-6"  >
    <div class="ddkits-blog-content-home col-md-11 col-sx-11" >
    <div class="img-ddkits-principal-home">
        <img class="ddkits" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;" alt="{{$post->title}}">
    </div>
    <div class="whytopost-ddkits-principal-home">
        <div class="title col-md-12">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
        <div class="body"><p>{{ $getInfo->encoded($post->body, 0, 50, 'yes') }}</p></div>
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
