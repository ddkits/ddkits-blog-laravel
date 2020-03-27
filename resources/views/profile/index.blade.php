@extends('layouts.profile')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('proPosts','App\Http\Controllers\ProPostCont')
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
<div id="main-content-timeline">
    @foreach($proPosts->getUserProPosts($user->id) as $proPost)
            {{ $Views->addProView($proPost->id) }}
            @if(Auth::user()->id != $user->id)
                @if($proPost->public == 1)
            <hr>
            <!-- Simple post content example. -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-left">
                        <a href="#">
                            <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo($proPost->uid)->picture  }}" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                        </a>
                    </div>
                    <h4><a href="#" style="text-decoration:none;"><strong>{{ $user->firstname  }} {{ $user->lastname  }}</strong></a> – <small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date('M j,Y', strtotime($proPost->created_at)) }}</i></a></small></small></h4>
                    <hr>
                    <div class="post-content">
                        {!! $encode->encodeOnly($proPost->body) !!}
                    </div>
                    <hr>
                    <div style="z-index:5;">
                      @include('includes.likeShare')
                        <div class="pull-left">
                            <p class="text-muted" style="margin-left:5px;"><i class="fa fa-globe" aria-hidden="true"></i> 
                                @if($proPost->public == 1)
                                   Public
                                @endif
                                @if($proPost->public == 2)
                                   Private
                                @endif
                            </p>
                        </div>
                        <br>
                    </div>
                    <hr>
                    <div class="media">
                    @if($comments->indexOnePostCount($proPost->id, 'pro_post') > 3)
                 <a href="{{ route('posts.show', $proPost->id) }}" class="btn btn-default btn-xs"><i class="fa fa-bars" aria-hidden="true"></i>  show All comments </a>
                        <hr>        
                        @endif
                        @foreach ($comments->indexOnePost($proPost->id, 'pro_post') as $comment)
                                        <hr>
                                    <div>
                                        <div class="post-content">
                                            <div class="panel-default">
                                                <div class="panel-body" style="text-decoration:none;">
                                                    <div class="left-col col-md-2" >
                                                        <a href="#">
                                                            <img src="/{{ $getProfile->getProfInfo($comment->uid)->picture  }}" width="35px" height="35px" style="margin-right:8px; margin-top:-5px;">
                                                        </a>
                                                    
                                                    <h4><a href="/profile/{{ $getProfile->getProfInfo($comment->uid)->id }} " style="text-decoration:none;"><strong>{{ $getProfile->getUserInfo($comment->uid)->firstname }} {{ $getProfile->getUserInfo($comment->uid)->lastname }}</strong></a></h4>
                                                    </div>
                                                    <div class="post-content">
                                                        {{ $comment->body }}
                                                        <br><small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at }}</i></a></small></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                             @endforeach

                       <div class="media">
                        <div class="pull-left">
                            <a href="#">
                                <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}" width="35px" height="35px" style="margin-left:3px; margin-right:-5px;">
                            </a>
                        </div>
                        <div class="media-body">
              {!! Form::open(['route' => 'comment.store']) !!}
                
                   {{ Form::textarea('body', null, array('class' => 'Form-control text col-md-10 d-flex align-items-center', 'required' => '', 'rows' => 1)) }}
                   <div hidden>  
                    {{ Form::text('title', $proPost->uid) }}
                    {{ Form::text('nid', $proPost->id) }}
                    {{ Form::text('uid', Auth::user()->id) }}
                    {{ Form::text('type', 'pro_post') }}
                    {{ Form::text('redirect', 'profile.show') }}
                    {{ Form::number('redirectID', $getProfile->getProfInfo($proPost->uid)->id ) }}
                  </div>
                  <div class="Form-control text col-md-2 d-flex align-items-center">
                  {!! Form::submit('Comment', ['class'=>'btn btn-default btn-block btn-xs']); !!}
                  </div>
                       {!! Form::close() !!}
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @if(Auth::user()->id == $user->id)
            <hr>
            <!-- Simple post content example. -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-left">
                        <a href="#">
                            <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo($proPost->uid)->picture  }}" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                        </a>
                    </div>
                    <h4><a href="#" style="text-decoration:none;"><strong>{{ $user->firstname  }} {{ $user->lastname  }}</strong></a> – <small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date('M j,Y', strtotime($proPost->created_at)) }}</i></a></small></small></h4>
                         <div class="pull-right"> <i class="fa fa-bars" id="postedit" post="{{ $proPost->id }}"></i>
                        <span id="postedit-{{ $proPost->id }}" hidden>
                          @if( Auth::user()->id == $proPost->uid AND empty($proPost->shared))
                            <div id="edit-menu" post-id="{{ $proPost->id }}">
                              <div id="show-edit-menu" class="pull-right post{{ $proPost->id }}">
                                      {!! Form::open(['route'=>['posts.edit', $proPost->id], 'method'=> 'get'])!!}
                                      {!! Form::submit('Edit', ["class"=> '']); !!}
                                      {!! Form::close(); !!}
                                    {!! Form::open(['route'=>['posts.destroy', $proPost->id], 'method'=> 'DELETE'])!!}
                                    {!! Form::submit('Delete', ["class"=> '']); !!}
                                    {!! Form::close(); !!}
                                  </div>
                              </div>
                          @endif
                        
                        </span>
                        </div>
                    <hr>
                    <div class="post-content">
                        {!! $encode->encodeOnly($proPost->body) !!}
                    </div>
                    <hr>
                    <div>
                      @include('includes.likeShare')
                        <div class="pull-left">
                            <p class="text-muted" style="margin-left:5px;"><i class="fa fa-globe" aria-hidden="true"></i> 
                                @if($proPost->public == 1)
                                   Public
                                @endif
                                @if($proPost->public == 2)
                                   Private
                                @endif
                            </p>
                        </div>
                        <br>
                    </div>
                    <hr>
                    <div class="media">
                    @if($comments->indexOnePostCount($proPost->id, 'pro_post') > 3)
                 <a href="{{ route('posts.show', $proPost->id) }}" class="btn btn-default btn-xs"><i class="fa fa-bars" aria-hidden="true"></i>  show All comments </a>
                        <hr>        
                        @endif
                        @foreach ($comments->indexOnePost($proPost->id, 'pro_post') as $comment)
                        <hr>
                    <div id="comment-{{ $comment->id }}">
                        <div class="post-content">
                            <div class="panel-default">
                                <div class="panel-body" style="text-decoration:none;">
                                                    <div class="left-col col-md-2" >
                                                        <a href="#">
                                                            <img src="/{{ $getProfile->getProfInfo($comment->uid)->picture  }}" width="35px" height="35px" style="margin-right:8px; margin-top:-5px;">
                                                        </a>
                                                    
                                                    <h4><a href="/profile/{{ $getProfile->getProfInfo($comment->uid)->id }} " style="text-decoration:none;"><strong>{{ $getProfile->getUserInfo($comment->uid)->firstname }} {{ $getProfile->getUserInfo($comment->uid)->lastname }}</strong></a></h4>
                                                    </div>
                                                    <div class="post-content">
                                                        {{ $comment->body }}
                                                        <br><small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at }}</i></a></small></small>
                                                    </div>
                                                </div>
                            </div>
                        </div>
                    </div>
             @endforeach

                       <div class="media">
                        <div class="pull-left">
                            <a href="#">
                                <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}" width="35px" height="35px" style="margin-left:3px; margin-right:-5px;">
                            </a>
                        </div>
                        <div class="media-body">
              {!! Form::open(['route' => 'comment.store', 'id'=>'commentForm'.$comment->id]) !!}
                
                   {{ Form::textarea('body', null, array('class' => 'Form-control text col-md-10 d-flex align-items-center', 'required' => '', 'rows' => 1)) }}
                   <div hidden>  
                    {{ Form::number('uid', Auth::user()->id, ['hidden'=>'']) }}  
                    {{ Form::text('title', $proPost->uid) }}
                    {{ Form::text('nid', $proPost->id) }}
                    {{ Form::text('uid', Auth::user()->id) }}
                    {{ Form::text('redirect', 'profile.show') }}
                    {{ Form::number('redirectID', $getProfile->getProfInfo($proPost->uid)->id ) }}
                  </div>
                  <div class="Form-control text col-md-2 d-flex align-items-center">
                  {!! Form::submit('Comment', ['class'=>'btn btn-default btn-block btn-xs']); !!}
                  </div>
                       {!! Form::close() !!}
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            @endif
            <script>
                      $(function () {
                        $('#commentForm-{{ $comment->id }}').on('submit', function (e) {
                          e.preventDefault();
                          $.ajax({
                            type: 'post',
                            url: '/comment',
                            data: $('#commentForm-{{ $comment->id }}' ).serialize(),
                            success: function () {
                              $("#comment-{{ $comment->id }}").load(location.href + " #comment-{{ $comment->id }}");
                            }
                          });
                        });
                      });
                    </script>
       @endforeach
       </div>
       {{ $proPosts->getUserProPosts($user->id)->links() }}
@stop