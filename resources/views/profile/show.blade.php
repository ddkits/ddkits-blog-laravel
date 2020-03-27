@extends('layouts.profile')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\ProPostCont')
@inject('comments','App\Http\Controllers\CommentCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('encode', 'App\Http\Controllers\AdminCont')
@inject('likes', 'App\Http\Controllers\LikeCont')


@section('meta')
<meta name="title" content="{{ $user->firstname  }} {{ $user->lastname  }}">
<meta name="description" content="{{ $user->firstname  }} {{ $user->lastname  }} profile page">
  <meta name="keywords" content="{{ $user->firstname  }}, {{ $user->lastname  }}">
  <meta name="author" content="{{ $user->firstname  }} {{ $user->lastname  }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <i class="fa fa-check text-success" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $user->firstname  }} {{ $user->lastname  }} is sharing with you"></i> -->
@stop

@section('leftSideBar')
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
          @include('includes.profileBio')
          </div>
@stop


@section('content')

    
@include('includes.profilePost')

  <div id="main-body-timeline">
    @foreach($posts->getUserProPosts($user->id) as $post)
            {{ $Views->addProView($post->id) }}
          
        <div class="panel panel-default postid-{{ $post->id }}" post="{{ $post->id }}">
            @if(Auth::user()->id != $user->id)
                @if($post->public == 1)
                <!-- post content  -->
                <div class="panel-body">
                    <div class="pull-left">
                        <a href="#">
                            <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo($post->uid)->picture  }}" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                        </a>
                    </div>
                    <h4><a href="#" style="text-decoration:none;"><strong>{{ $user->firstname  }} {{ $user->lastname  }}</strong></a> – <small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date('M j,Y', strtotime($post->created_at)) }}</i></a></small></small></h4>
                    <hr>
                    <div class="post-content">
                        {!! $encode->encodeOnly($post->body) !!}
                    </div>
                    <hr>
                    <div>
                        @include('includes.likeShare')
                        <div class="pull-left">
                            <p class="text-muted" style="margin-left:5px;"><i class="fa fa-globe" aria-hidden="true"></i> 
                                @if($post->public == 1)
                                   Public
                                @endif
                                @if($post->public == 2)
                                   Private
                                @endif
                            </p>
                        </div>
                        <br>
                    </div>
                </div>
                <!-- end of  post content  -->

                <!-- start of comments  --> 
        <div id="comment-{{ $post->id }}">
            @if($comments->indexOnePostCount($post->id, 'pro_post') > 2)
      <div class="center align-items-center text-center text-uppercase" > <a href="{{ route('posts.show', $post->id) }}" class="btn btn-default btn-xs"><i class="fa fa-bars" aria-hidden="true"></i>  show All comments </a></div>
              @endif
                @foreach ($comments->indexOnePost($post->id, 'pro_post') as $comment)
                      <div >
                          <div class="post-content">
                              <div class="panel-default">
                                  <div class="panel-body" style="text-decoration:none;">
                                      <div class="left-col col-md-2" >
                                          <a href="/profile/{{ $getProfile->getProfInfo($comment->uid)->id  }}">
                                              <img src="/{{ $getProfile->getProfInfo($comment->uid)->picture  }}" width="35px" height="35px" style="margin-right:8px; margin-top:-5px;">
                                          </a>
                                      
                                      <a href="/profile/{{ $getProfile->getProfInfo($comment->uid)->id  }}" style="text-decoration:none;"><strong>{{ $getProfile->getUserInfo($comment->uid)->firstname }} {{ $getProfile->getUserInfo($comment->uid)->lastname }}</strong></a>
                                      </div>
                                      <div class="post-content">
                                {{ $comment->body }}
                                <br><small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at }}</i></a></small></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
     @endforeach
            
               <div class="media">
                <div class="pull-left">
                    <a href="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}">
                                <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}" width="35px" height="35px" style="margin-left:3px; margin-right:-5px;">
                            </a>
                        </div>
                        <div class="media-body row">
      {!! Form::open(['route' => 'comment.store', 'id'=>'commentForm-'.$post->id]) !!}
        
           {{ Form::textarea('body', null, array('class' => 'Form-control text col-md-10 d-flex align-items-center', 'required' => '', 'rows' => 1)) }}
           <div hidden>  
            {{ Form::text('title', $post->uid) }}
            {{ Form::text('nid', $post->id) }}
            {{ Form::text('type', 'pro_post') }}
            {{ Form::text('uid', Auth::user()->id) }}
          </div>
          <div class="Form-control text col-md-2 d-flex align-items-center">
          {!! Form::submit('Comment', ['class'=>'btn btn-default btn-block btn-xs']); !!}
          </div>
               {!! Form::close() !!}
                </div>
                <br>
            </div>
        </div>
       <script>
        $(function () {
          $('#commentForm-{{ $post->id }}').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
              type: 'post',
              url: '/comment',
              data: $('#commentForm-{{ $post->id }}' ).serialize(),
              success: function () {
                $("#comment-{{ $post->id }}").load(location.href + " #comment-{{ $post->id }}");
                $("#containerBody").load(location.href + "#containerBody");
              }
            });
          });
        });
      </script> 

            <!-- end of comments  -->
                @endif
            @endif


            <!-- if the user of that page -->
    @if(Auth::user()->id == $user->id)

            <!-- post content  -->
                <div class="panel-body">
                    <div class="pull-left">
                        <a href="/profile/{{$post->uid}}">
                            <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo($post->uid)->picture  }}" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                        </a>
                    </div>
                    <h4><a href="/profile/{{$post->uid}}" style="text-decoration:none;"><strong>{{ $user->firstname  }} {{ $user->lastname  }}</strong></a> – <small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date('M j,Y', strtotime($post->created_at)) }}</i></a></small></small></h4>
                     <div class="pull-right"> <i class="fa fa-bars" id="postedit" post="{{ $post->id }}"></i>
                        <span id="postedit-{{ $post->id }}" hidden>
                          @if( Auth::user()->id == $post->uid AND empty($post->shared))
                            <div id="edit-menu" post-id="{{ $post->id }}">
                              <div id="show-edit-menu" class="pull-right post{{ $post->id }}">
                                      {!! Form::open(['route'=>['posts.edit', $post->id], 'method'=> 'get'])!!}
                                      {!! Form::submit('Edit', ["class"=> '']); !!}
                                      {!! Form::close(); !!}
                                    {!! Form::open(['route'=>['posts.destroy', $post->id], 'method'=> 'DELETE'])!!}
                                    {!! Form::submit('Delete', ["class"=> '']); !!}
                                    {!! Form::close(); !!}
                                  </div>
                              </div>
                          @endif
                        
                        </span>
                        </div>
                    <hr>
                    <div class="post-content">
                        {!! (!empty($post->shared)) ? $encode->encodeOnly($post->shared) : $encode->encodeOnly($post->body) !!}
                    </div>
                    <hr>
                    <div>
                        @include('includes.likeShare')
                        <div class="pull-left">
                            <p class="text-muted" style="margin-left:5px;"><i class="fa fa-globe" aria-hidden="true"></i> 
                                @if($post->public == 1)
                                   Public
                                @endif
                                @if($post->public == 2)
                                   Private
                                @endif
                            </p>
                        </div>
                        <br>
                    </div>
                </div>
            <!-- start of comments  --> 
        <div id="comment-{{ $post->id }}">
            @if($comments->indexOnePostCount($post->id, 'pro_post') > 2)
      <div class="center align-items-center text-center text-uppercase" > <a href="{{ route('posts.show', $post->id) }}" class="btn btn-default btn-xs"><i class="fa fa-bars" aria-hidden="true"></i>  show All comments </a></div>
              @endif
                @foreach ($comments->indexOnePost($post->id, 'pro_post') as $comment)
                      <div >
                          <div class="post-content">
                              <div class="panel-default">
                                  <div class="panel-body" style="text-decoration:none;">
                                      <div class="left-col col-md-2" >
                                          <a href="/profile/{{ $comment->uid }}">
                                              <img src="/{{ $getProfile->getProfInfo($comment->uid)->picture  }}" width="35px" height="35px" style="margin-right:8px; margin-top:-5px;">
                                          </a>
                                      
                                      <a href="/profile/{{ $getProfile->getProfInfo($comment->uid)->id  }}" style="text-decoration:none;"><strong>{{ $getProfile->getUserInfo($comment->uid)->firstname }} {{ $getProfile->getUserInfo($comment->uid)->lastname }}</strong></a>
                                      </div>
                                      <div class="post-content">
                                {{ $comment->body }}
                                <br><small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at }}</i></a></small></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
     @endforeach
            
               <div class="media">
                <div class="pull-left">
                                <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}" width="35px" height="35px" style="margin-left:3px; margin-right:-5px;">
                        </div>
                        <div class="media-body row">
      {!! Form::open(['route' => 'comment.store', 'id'=>'commentForm-'.$post->id]) !!}
        
           {{ Form::textarea('body', null, array('class' => 'Form-control text col-md-10 d-flex align-items-center', 'required' => '', 'rows' => 1)) }}
           <div hidden>  
            {{ Form::text('title', $post->uid) }}
            {{ Form::text('nid', $post->id) }}
            {{ Form::text('type', 'pro_post') }}
            {{ Form::text('uid', Auth::user()->id) }}
          </div>
          <div class="Form-control text col-md-2 d-flex align-items-center">
          {!! Form::submit('Comment', ['class'=>'btn btn-default btn-block btn-xs']); !!}
          </div>
               {!! Form::close() !!}
                </div>
                <br>
            </div>
        </div>
       <script>
        $(function () {
          $('#commentForm-{{ $post->id }}').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
              type: 'post',
              url: '/comment',
              data: $('#commentForm-{{ $post->id }}' ).serialize(),
              success: function () {
                $("#comment-{{ $post->id }}").load(location.href + " #comment-{{ $post->id }}");
                $("#containerBody").load(location.href + "#containerBody");
              }
            });
          });
        });
      </script> 

             <!-- end of post content  -->
              @endif  
       </div>       
@endforeach
</div>
       {{ $posts->getUserProPosts($user->id)->links() }}

    
@stop