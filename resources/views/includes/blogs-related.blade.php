@inject('blogsCont', 'App\Http\Controllers\PostCont')

{{-- Related Feeds --}}
    <!-- show all after last row  -->
    @foreach ($blogsCont->postsRelated()->paginate(4) as $post)
    @php
    $last_id = $post->id;
@endphp
    <a href="{{ route('article.show', $post->path) }}" class="black fondo-ddkits-home  col-md-6"  >
    <div class="ddkits-blog-content-home col-md-11 col-sx-11" >
    <div class="img-ddkits-principal-home">
    <img class="ddkits" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;"  alt="{{$post->title}}">
    </div>
    <div class="whytopost-ddkits-principal-home">
    <div class=" col-md-12">{{ $getInfo->encoded($post->title, 0, 50, 'yes') }}</div>
    <div class="author col-md-2 col-xs-2">
    </div>
    </div>
    </div>
    </a>

@endforeach

