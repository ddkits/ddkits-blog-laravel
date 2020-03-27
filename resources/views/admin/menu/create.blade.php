@inject('isAdmin', 'App\Http\Controllers\AdminCont')
@inject('menuList', 'App\Http\Controllers\MenuCont')
@if( $isAdmin->adminInfo( Auth::user()->id )->level == 0)


@extends('layouts.admin')

@section('title', 'Creat New Menu link')

@section('styles')

@stop

@section('content')

	<div class="container-fluid col-lg-12 ">
		{!! Form::open(array('route' => 'menu.store')) !!}
		    {{ Form::number('uid', Auth::user()->id, ['hidden'=>'']) }}
			<div class="project">
    <div class="row bg-white has-shadow">
      <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
        <div class="project-title d-flex align-items-center">
          <div class="text">
            {{ Form::label('name', 'Name:', array('class' => 'col-md-12')) }}{{ Form::text('name', null, array('class' => 'form-control col-md-12', 'required' => '')) }}
            {{ Form::label('menu', 'Menu Type:', array('class' => 'col-md-12')) }}{{ Form::select('menu', array('mainmenu' => 'Main Menu', 'adminmenu' => 'Admin Menu', 'homemainmenu'=>'Home Main Menu'), array('class' => 'col-md-12', 'required' => '')) }}
            {{ Form::label('menuparent', 'Menu Parent:', array('class' => 'col-md-12')) }}
            {{ Form::select('menuparent', ['None'=>'None', $menuList->indexAll()], array('class' => 'form-control col-md-12')) }}

            <!-- {{ Form::label('adminlevel', 'Admin Level:') }}{{ Form::number('adminlevel', 1, array('class' => 'form-control col-md-12')) }} -->

            {{ Form::label('weight', 'Weight:', array('class' => 'col-md-12')) }}{{ Form::number('weight', 0, array('class' => 'form-control col-md-12')) }}

            {{ Form::label('link', 'Link:', array('class' => 'col-md-12')) }}{{ Form::text('link', '/', array('class' => 'form-control col-md-12')) }}

            {{ Form::label('class', 'Class:', array('class' => 'col-md-12')) }}{{ Form::text('class', null, array('class' => 'form-control col-md-12')) }}
            {{ Form::label('iconclass', 'Icon Class:') }}{{ Form::text('iconclass', null, array('class' => 'form-control col-md-12')) }}

            {{ Form::label('description', 'Menu Description:', array('class' => 'col-md-12')) }} {{ Form::textarea('description', null, array('class' => 'form-control col-md-12', 'required' => '')) }}
          </div>
        </div>
      </div>
      <div class="right-col col-lg-8 col-suffix-4 d-flex align-items-center">
        <div > {{ Form::submit('Create Menu', array('class' => 'btn btn-success')) }}</div>
        <div ><a href="{{ route('menu.index') }}" class="edit btn btn-danger">Cancel</a></div>
    </div>
  </div>
		{!! Form::close() !!}
</div>
@stop
@else
 <div> Accsess Denied!</div>
@endif
