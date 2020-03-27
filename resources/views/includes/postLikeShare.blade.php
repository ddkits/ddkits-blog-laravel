
<div class="pull-right btn-group-xs">
<a class="btn btn-default btn-xs">
{!! Form::open(['route' => 'likes.store']) !!}
<div hidden>
{!! Form::text('type', 'propost') !!}
{!! Form::number('uid', Auth::user()->id) !!}
{!! Form::number('nid', $post->id); !!}
</div>
<i class="fa fa-heart" aria-hidden="true"></i>{!! Form::submit('Like', ["class"=> 'btn btn-default btn-xs']); !!}<div class="badge">{{ $likes->getLikes($post->id, 'propost')->likes }}</div>
{!! Form::close(); !!}
  </a>
  <a class="btn btn-default btn-xs">
{!! Form::open(['route' => 'reshare.store']) !!}
<div hidden>
{!! Form::text('type', 'propost') !!}
{!! Form::number('uid', Auth::user()->id) !!}
{!! Form::number('nid', $post->id); !!}
</div>
<i class="fa fa-retweet" aria-hidden="true"></i>{!! Form::submit('Reshare', ["class"=> 'btn btn-default btn-xs']); !!}
{!! Form::close(); !!}
  </a>
<a href="#comment-{{ $post->id }}" class="btn btn-default btn-xs"><i class="fa fa-comment" aria-hidden="true"></i> Comment</a>

</div>