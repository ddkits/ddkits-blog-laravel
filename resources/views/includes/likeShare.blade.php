<div class="pull-right btn-group-xs">
    <div class="btn btn-default btn-xs">
      <i class="badge fa" id="likes-{{ $post->id }}">{{ $likes->getLikes($post->id, 'post') }}</i>
      <div id="likeSuccess" hidden>Done</div>
      <a class="btn btn-default btn-xs" id="likesForm" href="{{ route('likes.store.link', ['nid'=>$post->id, 'uid'=>Auth::user()->id, 'type'=>'post']) }}" nid="{{ $post->id }}" type="post" uid="{{ Auth::user()->id }}">Like</a><i class="fa fa-heart" aria-hidden="true" ></i>
      
      </div>
      <div id="share-{{ $post->id }}" class="btn btn-default btn-xs">
      {!! Form::open(['route' => 'reshare.store', 'id'=>'shareForm-'.$post->id]) !!}
      <div hidden>
      {!! Form::text('type', 'post') !!}
      {!! Form::number('uid', Auth::user()->id) !!}
      {!! Form::number('nid', $post->id); !!}
      </div>
      <i class="fa fa-retweet" aria-hidden="true"></i>{!! Form::submit('Reshare', ["class"=> 'btn btn-default btn-xs']); !!}
      {!! Form::close(); !!}
        </div>
</div>
