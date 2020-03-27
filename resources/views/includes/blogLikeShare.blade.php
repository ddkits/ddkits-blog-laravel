<div class="pull-right btn-group-xs">
      <div class="btn btn-default btn-xs">
      <i class="badge fa" id="likes-{{ $post->id }}">{{ $likes->getLikes($post->id, 'blog') }}</i>
      <div id="likeSuccess" hidden>Done</div>
      <a class="btn btn-default btn-xs" id="likesForm" href="{{ route('likes.store.link', ['nid'=>$post->id, 'uid'=>Auth::user()->id, 'type'=>'blog']) }}" nid="{{ $post->id }}" type="blog" uid="{{ Auth::user()->id }}">Like</a><i class="fa fa-heart" aria-hidden="true" ></i>
      
      </div>
        <a class="btn btn-default btn-xs">
      {!! Form::open(['route' => 'reshare.store']) !!}
      <div hidden>
      {!! Form::text('type', 'blog') !!}
      {!! Form::number('uid', Auth::user()->id) !!}
      {!! Form::number('nid', $post->id); !!}
      </div>
      <i class="fa fa-retweet" aria-hidden="true"></i>{!! Form::submit('Reshare', ["class"=> 'btn btn-default btn-xs']); !!}
      {!! Form::close(); !!}
        </a>
 
</div>