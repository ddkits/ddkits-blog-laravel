@extends('layouts.profile')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\ProPostCont')
@inject('postBlog','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('encode', 'App\Http\Controllers\AdminCont')
@inject('likes', 'App\Http\Controllers\LikeCont')


@section('title')

@stop

@section('leftSideBar')
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
          @include('includes.profileBio')
          </div>
@stop


@section('content')

<div class="">
 <img src="/{{ $post->image }}" id="blog-image" style="width:100%;height: 300px;z-index: -10;opacity: 0.5; margin-bottom: -150px;" alt="{{$post->title}}">
</div>

<div class="container-fluid col-lg-12 d-flex justify-content-between panel" style="opacity: 0.8;">
      <!-- Project-->
      <div class="project">
        <div class="row">
        <div class=" well align-items-center text-center col-md-12">
          <h1>{{ $post->title }}{!! $Views->addView($post->id) !!}</h1>
          <a href="/profile/{{ $getProfile->getProfInfo($post->uid)->id }} " style="text-decoration:none;"></small> {{ $user->firstname }} {{ $user->lastname }} </small></a>
          <small><i class="fa fa-clock-o"> </i>{{ date('M j, Y', strtotime($post->created_at)) }}</small><br>
          @if( $post->uid == Auth::user()->id || Auth::user()->id == 1)
              <div class="btn-group-xs">
                  <a>{!! Form::open(['route'=>['blog.edit', $post->id], 'method'=> 'get'], ["class"=> ''])!!}
                  {!! Form::submit('Edit', ["class"=> 'btn btn-default btn-xs pull-right']); !!}
                  {!! Form::close(); !!}</a>
                  <a>{!! Form::open(['route'=>['blog.destroy', $post->id], 'method'=> 'DELETE'], ["class"=> ''])!!}
                  {!! Form::submit('Delete', ["class"=> 'btn btn-default btn-xs pull-left']); !!}
                  {!! Form::close(); !!}</a>
                  </div>
            @endif
        </div>

        <br>
          <div class="col-lg-12 d-flex justify-content-between"><br>
                {!! $encode->encodeOnly($post->body) !!}

                <br>
                <hr>
                <div class="col-md-12 well">
                  <div class="col-md-6">
                Categories:
                          @foreach($postBlog->nCategories($post->id, 'blog') as $catKey => $cat)
                              <div hidden>{{ $cat }}
                              {{ Form::open(['method'=>'GET', 'url'=>'search', 'id'=>$cat, 'role'=>'categories']) }}
                              {{ Form::text('categories', $cat) }}
                            </div>
                              {{ Form::submit($cat) }}
                              {{ Form::close() }}
                           @endforeach
                            </div>
                  <div class="col-md-6">
                Tags:
                          @foreach($postBlog->nTags($post->id, 'blog') as $catKey => $cat)
                             {{ $cat }}
                           @endforeach
               </div>
             </div>
              <div class="well">

                @include('includes.blogLikeShare')
                </div>
            </div>
            <div>

         @if($files->count() > 0)
                  <div class="">
                  Files: {{ $files->count() }}
                  <br>
                    @foreach($files->get() as $file)
                        <a href="/{{ $file->file }}" id="todo-loaded-files" target="_blank" class="has-shadow well pull-left" style="margin: 20px;border: 2px solid #000;"><img src="/{{ $file->file }}" id="todo-loaded-files-thumb" class="rounded mx-auto d-block" width="50" height="50" style="margin: 10px;" alt="{{$file->type}}"><br> {{ $file->ftype }}</a>
                    @endforeach
                @else
                <div class="has-shadow well pull-left">
                  No files.
              </div>
             @endif
            </div>
          </div>

        </div>

        <section class="col-md-12 container" id="comments">
          @if($comments)
          @foreach ($comments as $comment)
                          <hr>
                      <div>
                          <div class="post-content">
                              <div class="panel-default">
                                  <div class="panel-body" style="text-decoration:none;">
                                      <div class="left-col col-md-2" >
                                          <a href="/profile/{{ $getProfile->getProfInfo($comment->uid)->id }}">
                                              <img src="/{{ $getProfile->getProfInfo($comment->uid)->picture  }}" width="35px" height="35px" style="margin-right:8px; margin-top:-5px;">
                                          </a>

                                      <h4><a href="/profile/{{ $getProfile->getProfInfo($comment->uid)->id }}" style="text-decoration:none;"><strong>{{ $getProfile->getUserInfo($comment->uid)->firstname }} {{ $getProfile->getUserInfo($comment->uid)->lastname }}</strong></a></h4>
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
               @endif
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


           <div class="well">
          <div class="pull-left">
              <a href="/profile/{{ $getProfile->getProfInfo(Auth::user()->id)->id }}">
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
                    {{ Form::text('redirect', 'blog.show') }}
                    {{ Form::text('type', 'blog') }}
                    {{ Form::number('redirectID', $post->id ) }}
                  </div>
                  <div class="Form-control text col-md-2 d-flex align-items-center">
                  {!! Form::submit('Comment', ['class'=>'btn btn-default btn-block btn-xs']); !!}
                  </div>
                       {!! Form::close() !!}
                 </div>
              </div><br>
      </section>



@stop