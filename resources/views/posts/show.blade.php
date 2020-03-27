@extends('layouts.profile')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('proPosts','App\Http\Controllers\ProPostCont')
@inject('allComments','App\Http\Controllers\CommentCont')
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

            <!-- Simple post content example. -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-left">
                        <a href="#">
                            <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo($post->uid)->picture  }}" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;" alt="{{$post->title}}">
                        </a>
                    </div>
                    <h4><a href="/profile/{{$getProfile->getProfInfo($post->uid)->id}} " style="text-decoration:none;"><strong>{{ $user->firstname  }} {{ $user->lastname  }}</strong></a> – <small><small><a href="#" style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date('M j,Y', strtotime($post->created_at)) }}</i></a></small></small></h4>
                    <span>

                            @if( Auth::user()->id == $post->uid AND empty($post->shared))
                            <div id="edit-menu" post-id="{{ $post->id }}">
                              <div id="show-edit-menu" class="pull-right post{{ $post->id }}">
                                  <button class="fa">
                                      {!! Form::open(['route'=>['posts.edit', $post->id], 'method'=> 'get'])!!}
                                      {!! Form::submit('Edit', ["class"=> '']); !!}
                                      {!! Form::close(); !!}
                                 </button>
                                    <button class="fa">
                                    {!! Form::open(['route'=>['posts.destroy', $post->id], 'method'=> 'DELETE'])!!}
                                    {!! Form::submit('Delete', ["class"=> '']); !!}
                                    {!! Form::close(); !!}
                                  </button>
                                  </div>
                              </div>
                          @endif

                    </span>
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
                    <hr>
                    </div>

          <div class="media" id="comments">
                        @foreach ($allComments->indexOnePostAll($post->id, 'pro_post') as $comment)
                                        <hr>
                                    <div >
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
                           </div>
                         <script>
              $(function () {
                $('#commentForm').on('submit', function (e) {
                  e.preventDefault();
                  $.ajax({
                    type: 'post',
                    url: '/comment',
                    data: $('#commentForm').serialize(),
                    success: function () {
                      $('#commentForm').trigger('reset');
                      $("#comments").load(location.href + " #comments");
                    }
                  });
                });
              });
            </script>
                       <div class="media">
                        <div class="pull-left">
                            <a href="#">
                                <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}" width="35px" height="35px" style="margin-left:3px; margin-right:-5px;">
                            </a>
                        </div>
                        <div id="comment-{{ $post->id }}" class="media-body">
              {!! Form::open(['route' => 'comment.store', 'id'=>'commentForm']) !!}

                   {{ Form::textarea('body', null, array('class' => 'Form-control text col-md-10 d-flex align-items-center', 'required' => '', 'rows' => 1)) }}
                   <div hidden>
                    {{ Form::text('title', $post->uid) }}
                    {{ Form::text('nid', $post->id) }}
                    {{ Form::text('uid', Auth::user()->id) }}
                    {{ Form::text('type', 'pro_post') }}
                  </div>
                  <div class="Form-control text col-md-2 d-flex align-items-center">
                  {!! Form::submit('Comment', ['class'=>'btn btn-default btn-block btn-xs']); !!}
                  </div>
                       {!! Form::close() !!}
                       <br>
                       <br>
                        </div>
          </div>
            {{ $Views->addProView($post->id) }}
@stop