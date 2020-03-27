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
            <div class="panel-default shadow">
               <div class="post-content row">
                        {!! $encode->encodeOnly($post->shared) !!}
                    </div>
            </div>
            <div class="panel ">
              
                {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'put']) !!}
                <div hidden>
                    {{ Form::number('uid', Auth::user()->id) }}
                    {{ Form::number('nid', $post->id) }}
                </div>


                       {{ Form::textarea('body', $post->body, array('class' => 'form-control row ckeditor', 'required' => '')) }}
                   
                     <span class="col-md-10">
                      {{ Form::select('public', ['1'=>'public', '2'=>'private'], $post->public, array('class' => 'form-control', 'required' => '')) }}
                        
                    </span>
                    <div class="select2 pull-right col-md-2">
                           {{ Form::submit('Share', ['class' => 'btn btn-success']) }}
                        </div>

                                
                    <br><hr>
                    <span class="pull-right">
                        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-at" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Mention"></i></a>
                        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-envelope-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Message"></i></a>
                        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-ban" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Ignore"></i></a>
                    </span>
        {!! Form::close() !!}
            </div>

@stop