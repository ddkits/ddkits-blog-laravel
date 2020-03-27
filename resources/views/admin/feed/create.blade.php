@extends('layouts.profile')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('isAdmin', 'App\Http\Controllers\AdminCont')
@inject('feedList', 'App\Http\Controllers\feedsCont')

<!-- {{ $getInfo->getValue('sitename') }} -->
@if( $isAdmin->adminInfo( Auth::user()->id )->level == 0)
@section('title', 'Creat New feed link')

@section('styles')

@stop

@section('content')

	<div class="container-fluid col-lg-12 ">
		{!! Form::open(array('route' => 'feeds.store')) !!}
		    {{ Form::number('uid', Auth::user()->id, ['hidden'=>'']) }}
			<div class="project">
        <div class="row bg-white has-shadow">
        <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
            <div class="project-title d-flex align-items-center">
            <div class="text">
                {{ Form::label('title', 'Title:', array('class' => 'col-md-12')) }}{{ Form::text('title', null, array('class' => 'form-control col-md-12', 'required' => '')) }}

            <!-- tags and categories -->
            <div class="form-group">
              <div class="col-md-12 well">
                {{ Form::label('tags[]', strtoupper(str_replace('_', ' ', 'Tags: '))) }}
                {{ Form::select('tags[]', $tags ,[], ['class'=>'form-control select2','id'=>'tags', 'multiple'=>'multiple']) }}
                </div>
              <div class="col-md-12 well">
                {{ Form::label('categories[]', strtoupper(str_replace('_', ' ', 'Categories: '))) }}
                {{ Form::select('categories[]', $categories ,[], ['class'=>'form-control select2', 'id'=>'categories', 'multiple'=>'multiple']) }}
              </div>
            </div>
            {{ Form::label('feed_url', 'feed url:', array('class' => 'col-md-12')) }} {{ Form::textarea('feed_url', null, array('class' => 'form-control col-md-12')) }}
            {{ Form::label('youtube', 'Youtube Channel: ex. UCQlltBK46W42R1OQpWk917A', array('class' => 'col-md-12')) }} {{ Form::textarea('youtube', null, array('class' => 'form-control col-md-12')) }}
          </div>
        </div>
      </div>
      <div class="right-col col-lg-8 col-suffix-4 d-flex align-items-center">
        <div > {{ Form::submit('Create feed', array('class' => 'btn btn-success')) }}</div>
        <div ><a href="{{ route('feeds.index') }}" class="edit btn btn-danger">Cancel</a></div>
    </div>
  </div>
		{!! Form::close() !!}
</div>
@stop
@else
 <div> Accsess Denied!</div>
@endif
