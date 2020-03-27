@inject('isAdmin', 'App\Http\Controllers\AdminCont')
@inject('menuList', 'App\Http\Controllers\MenuCont')

@if( $isAdmin->adminInfo( Auth::user()->id )->level == 0)
@extends('layouts.admin')

@section('title', 'Menu links')

@section('styles')

@stop

@section('content')
   <hr>
                    <!-- Project-->
                    <div class="project col-md-12">
                      <div class="row well bg-white has-shadow">
                        <div class="row col-lg-12 d-flex align-items-center justify-content-between">
                        <div class="left-col col-lg-8 d-flex align-items-center justify-content-between">
                          <div class="project-title d-flex align-items-center edit">
                          {!! Form::open(['route' => ['menu.update', $menu->id], 'method' => 'put']) !!}
                            <div class="row text col-lg-12">
                              {{ Form::label('name', 'Name:') }}{{ Form::text('name', $menu->name, array('class' => 'Form-control col-md-12')) }}
                              {{ Form::label('menu', 'Menu Type:') }}{{ Form::select('menu', array('mainmenu' => 'Main Menu', 'adminmenu' => 'Admin Menu'), array('class' => 'Form-control')) }}
                              {{ Form::label('menuparent', 'Menu Parent:') }}
                              {{ Form::select('menuparent', ['None'=>'None', $menuList->indexAll()], array('class' => 'Form-control col-md-12')) }}
                              {{ Form::label('adminlevel', 'Admin Level:') }}{{ Form::number('adminlevel', $menu->adminLevel, array('class' => 'Form-control col-md-12')) }}
                              {{ Form::label('link', 'Link:') }}{{ Form::text('link', $menu->link, array('class' => 'Form-control')) }}
                              {{ Form::label('class', 'Class:') }}{{ Form::text('class', $menu->class, array('class' => 'Form-control')) }}
                              {{ Form::label('iconclass', 'Icon Class:') }}{{ Form::text('iconclass', $menu->iconclass, array('class' => 'Form-control col-md-12')) }}
                              {{ Form::label('description', 'Menu Description:') }} {{ Form::textarea('description', $menu->description, array('class' => 'Form-control')) }}
                              {{ Form::submit('Save', ["class"=>"btn btn-success btn-block"]) }}
                            {!! Form::close() !!}
                             {!! Form::open(['route'=>['menu.destroy', $menu->id], 'method'=> 'DELETE'])!!}
                              {!! Form::submit('Delete', ["class"=> 'btn-danger btn']); !!}
                              {!! Form::close(); !!}
                            </div>
                          </div>
                          <div class="project-date"><span class="hidden-sm-down">{{ $menu->created_at }}</span></div>
                        </div>
                        <div class="right-col right-pull col-lg-4 d-flex align-items-center">
                          <div class="time"><i class="fa fa-clock-o"></i>{{ date('M j, Y', strtotime($menu->updated_at)) }} </div>
                        </div>
                      </div>
                    </div>
                  </div>
    <hr>
    <div class="text-center">
      {!! $menus->links(); !!}

    </div>
@stop
@else
 <div> Accsess Denied!</div>
@endif