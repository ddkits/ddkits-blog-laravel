@extends('layouts.profile')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('comments','App\Http\Controllers\CommentCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('encode', 'App\Http\Controllers\AdminCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')

@section('meta')
<meta name="title" content=" Blogs">

@stop

@section('leftSideBar')
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
          @include('includes.topBlogsToday')
          </div>
@stop

@section('content')


    
@include('includes.proBlogPost')

    @foreach($blogs as $post)
            <hr>
            <!-- Simple post content example. -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-left">
                        <a href="/profile/{{ $getProfile->getProfInfo($post->uid)->id  }}">
                            <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo($post->uid)->picture  }}" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                        </a>
                    </div>
                    <h4><a href="/profile/{{ $getProfile->getProfInfo($post->uid)->id }}" style="text-decoration:none;"><strong>{{ $user->find($post->uid)->firstname  }} {{ $user->find($post->uid)->lastname  }}</strong></a> – <small><small><a style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date('M j,Y', strtotime($post->created_at)) }}</i></a></small></small></h4>
                    <span>
                        
                    @if( Auth::user()->id == $post->uid)
                    <div class="navbar-right">
                            <div class="dropdown">
                                <button class="btn btn-link btn-xs dropdown-toggle" type="button" id="dd1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dd1" style="float: right;">
                                    <li>
                                        {!! Form::open(['route'=>['blog.edit', $post->id], 'method'=> 'get'])!!}
                                        {!! Form::submit('Edit', ["class"=> 'btn-success btn btn-block']); !!}
                                        {!! Form::close(); !!}
                                    </li>
                                    <li>
                                        {!! Form::open(['route'=>['blog.destroy', $post->id], 'method'=> 'DELETE'])!!}
                                        {!! Form::submit('Delete', ["class"=> 'btn-danger btn btn-block']); !!}
                                        {!! Form::close(); !!}
                                    </li>
                                </ul>

                            </div>
                            </div>
                  @endif
                    </span>
                    <hr>
                    <!-- Body content for blogs in post view -->
                    <div class="post-content">
                      <div class="d-flex align-items-center col-md-12">
                       <a href="/blog/{{ $post->id }}"><div class="pull-left col-md-4"><img id="reshare-image" class=" img-thumbnail" alt="{{ $user->find($post->uid)->firstname }} {{ $user->find($post->uid)->lastname }}" width="304" height="236" src="/{{ $post->image }}"></div><div id="text"><h3>{{ $post->title }}</h3><br> <div id="reshare-body" height="150px" width="300">{{ $encode->encoded($post->body, 0, 300, 'yes') }} </div> <br></div></a></div>
                            
                    </div>
                    <div><hr>
                      @include('includes.blogLikeShare')
                    </div>
                  </div>
    @if($comments->indexOnePostCount($post->id, 'blog') > 2)
      <div class="center align-items-center text-center text-uppercase" > <a href="{{ route('blog.show', $post->id) }}" class="btn btn-default btn-xs"><i class="fa fa-bars" aria-hidden="true"></i>  show All comments </a></div>
              @endif
          @foreach ($comments->indexOnePost($post->id, 'blog') as $comment)
                  <hr>
                      <div>
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
                                          <br><small><small><a style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at }}</i></a></small></small>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
               @endforeach
          <hr>
            <div class="col-md-1">
                <a href="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}">
                                <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo(Auth::user()->id)->picture  }}" width="35px" height="35px" style="margin-left:3px; margin-right:-5px;">
                            </a>
                        </div>
                        <div class="media-body row">
              {!! Form::open(['route' => 'comment.store']) !!}
                
                   {{ Form::textarea('body', null, array('class' => 'Form-control text col-md-10 d-flex align-items-center', 'required' => '', 'rows' => 1)) }}
                   <div hidden>  
                    {{ Form::text('title', $post->uid) }}
                    {{ Form::text('nid', $post->id) }}
                    {{ Form::text('uid', Auth::user()->id) }}
                    {{ Form::text('type', 'blog') }}
                  </div>
                  <div class="Form-control text col-md-2 d-flex align-items-center">
                  {!! Form::submit('Comment', ['class'=>'btn btn-default btn-block btn-xs']); !!}
                  </div>
                       {!! Form::close() !!}
                  </div>
                  <br>
          </div>
       @endforeach
        <hr>
    <div class="text-center">

    </div>
@stop