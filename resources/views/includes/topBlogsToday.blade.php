@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('posts', 'App\Http\Controllers\PostCont')
@inject('proPosts', 'App\Http\Controllers\ProPostCont')
@inject('encode', 'App\Http\Controllers\AdminCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('views', 'App\Http\Controllers\ViewsCont')



<div class="panel panel-default">
<div class="panel-body">
    <div class="media">
        <div align="center">
            <h2>Top Articles</h2>
        </div>
        <div class="media-body">
          <hr>  
          @if($posts->getTopBlogs())
               @foreach($posts->getTopBlogs() as $post)
                    <div class="pull-right badge">Viewed: {{ $views->getBlogViews($post['id'], 'blog') }}</div>
                    <a href="/blog/{{ $post['id'] }}"><h3><strong>{{ $post['title'] }}</strong> </h3>
                   </a>
                    <p>
                        {{ $encode->encoded($post['body'], 0, 150, 'yes') }}
                        
                    </p>
                <hr>
               @endforeach
        @else
            <h3><strong>No blogs yet</strong> </h3>
           
            <p>                
            </p>
        <hr>
       @endif
         </div>
     </div>
    </div>
</div>