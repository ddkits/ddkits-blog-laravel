@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->
@inject('menuList', 'App\Http\Controllers\MenuCont')

@if( $getInfo->adminInfo( Auth::user()->id )->level == 0)

@extends('layouts.admin')

@section('title', 'Menu links')

@section('styles')

@stop

@section('content')
   <hr>
   @if( empty($menus) )
   <div class="project col-md-12">
     <h3 class="h4 row">No Menus yet</h3></div>
   @else
    <div class="project col-md-12">
      <div class="row well bg-white has-shadow">
      <h3 class="align-items-center">Admin Menus</h3>
        @foreach($menus as $menu)
           @if ($menu->menu == 'adminmenu')
                       <div class="col-md-12 d-flex align-items-center justify-content-between">
                          <div class="project-title d-flex align-items-center edit">
                          {!! Form::open(['route' => ['menu.update', $menu->id], 'method' => 'put']) !!}
                            <div class="row text col-lg-12">
                              <a href="#index-{{$menu->id}}" aria-expanded="false" data-toggle="collapse"><i class="{{$menu->iconclass}}"></i>#{{$menu->id}}: {{$menu->name}}</a>
                          <div id="index-{{$menu->id}}" class="collapse">
                              {{ Form::label('name', 'Name:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('name', $menu->name, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('menu', 'Menu Type:', array('class' => 'Form-control col-md-3')) }} {{ Form::text('menu', $menu->menu, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('menuparent', 'Parent menu:', array('class' => 'Form-control col-md-3')) }}{{ Form::number('menuparent', $menu->menuparent, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('link', 'Link:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('link', $menu->link, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('class', 'Class:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('class', $menu->class, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('iconclass', 'Icon Class:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('iconclass', $menu->iconclass, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('description', 'Menu Description:', array('class' => 'Form-control col-md-3')) }} {{ Form::textarea('description', $menu->description, array('class' => 'Form-control col-md-8', 'rows'=>'1')) }}
                                {{ Form::label('adminlevel', 'Admin Level:', array('class' => 'Form-control col-md-3')) }}{{ Form::number('adminlevel', $menu->adminLevel, array('class' => 'Form-control col-md-8')) }}
                                {{ Form::label('weight', 'Weight:', array('class' => 'Form-control col-md-3')) }}{{ Form::number('weight', $menu->weight, array('class' => 'Form-control col-md-8')) }}
                          <div class="row well">
                          {{ Form::submit('Save', ["class"=>"btn btn-success btn-block"]) }}
                            {!! Form::close() !!}</div>
                            <div class="row well">{!! Form::open(['route'=>['menu.destroy', $menu->id], 'method'=> 'DELETE'])!!}
                              {!! Form::submit('Delete', ["class"=> 'btn-danger btn btn-block']); !!}
                          {!! Form::close(); !!}</div>
                            </div>
                            </div>
                          </div>
                        </div>
             @endif
        @endforeach
        </div>
      </div>
    <div class="project col-md-12">
      <div class="row well bg-white has-shadow">
      <h3 class="text align-items-center portfolio-item" >Left Dashboard Main Menus</h3>
        @foreach($menus as $menu)
           @if ($menu->menu == 'mainmenu')
                        <div class="col-md-12 d-flex align-items-center justify-content-between">
                          <div class="project-title d-flex align-items-center edit">
                          {!! Form::open(['route' => ['menu.update', $menu->id], 'method' => 'put']) !!}
                            <div class="row text col-lg-12">
                              <a href="#index-{{$menu->id}}" aria-expanded="false" data-toggle="collapse"><i class="{{$menu->iconclass}}"></i>#{{$menu->id}}: {{$menu->name}}</a>
                          <div id="index-{{$menu->id}}" class="collapse">
                              {{ Form::label('name', 'Name:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('name', $menu->name, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('menu', 'Menu Type:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('menu', $menu->menu, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('menuparent', 'Parent menu:', array('class' => 'Form-control col-md-3')) }}{{ Form::number('menuparent', $menu->menuparent, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('link', 'Link:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('link', $menu->link, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('class', 'Class:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('class', $menu->class, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('iconclass', 'Icon Class:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('iconclass', $menu->iconclass, array('class' => 'Form-control col-md-8')) }}
                              {{ Form::label('description', 'Menu Description:', array('class' => 'Form-control col-md-3')) }} {{ Form::textarea('description', $menu->description, array('class' => 'Form-control col-md-8', 'rows'=>'1')) }}
                              {{ Form::label('weight', 'Weight:', array('class' => 'Form-control col-md-3')) }}{{ Form::number('weight', $menu->weight, array('class' => 'Form-control col-md-8')) }}
                          <div class="row well">{{ Form::submit('Save', ["class"=>'btn btn-success btn-block']) }}
                            {!! Form::close() !!}
                            {!! Form::open(['route'=>['menu.destroy', $menu->id], 'method'=> 'DELETE'])!!}
                              {!! Form::submit('Delete', ["class"=> 'btn-danger btn btn-block']); !!}
                          {!! Form::close(); !!}</div>
                            </div>
                            </div>
                          </div>
                        </div>

                 @endif
        @endforeach
         </div>
      </div>
    <hr>
    <div class="project col-md-12">
        <div class="row well bg-white has-shadow">
        <h3 class="text align-items-center portfolio-item" >Home Main Menus</h3>
          @foreach($menus as $menu)
             @if ($menu->menu == 'homemainmenu')
                          <div class="col-md-12 d-flex align-items-center justify-content-between">
                            <div class="project-title d-flex align-items-center edit">
                            {!! Form::open(['route' => ['menu.update', $menu->id], 'method' => 'put']) !!}
                              <div class="row text col-lg-12">
                                <a href="#index-{{$menu->id}}" aria-expanded="false" data-toggle="collapse"><i class="{{$menu->iconclass}}"></i>#{{$menu->id}}: {{$menu->name}}</a>
                            <div id="index-{{$menu->id}}" class="collapse">
                                {{ Form::label('name', 'Name:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('name', $menu->name, array('class' => 'Form-control col-md-8')) }}
                                {{ Form::label('menu', 'Menu Type:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('menu', $menu->menu, array('class' => 'Form-control col-md-8')) }}
                                {{ Form::label('menuparent', 'Parent menu:', array('class' => 'Form-control col-md-3')) }}{{ Form::number('menuparent', $menu->menuparent, array('class' => 'Form-control col-md-8')) }}
                                {{ Form::label('link', 'Link:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('link', $menu->link, array('class' => 'Form-control col-md-8')) }}
                                {{ Form::label('class', 'Class:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('class', $menu->class, array('class' => 'Form-control col-md-8')) }}
                                {{ Form::label('iconclass', 'Icon Class:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('iconclass', $menu->iconclass, array('class' => 'Form-control col-md-8')) }}
                                {{ Form::label('description', 'Menu Description:', array('class' => 'Form-control col-md-3')) }} {{ Form::textarea('description', $menu->description, array('class' => 'Form-control col-md-8', 'rows'=>'1')) }}
                                {{ Form::label('weight', 'Weight:', array('class' => 'Form-control col-md-3')) }}{{ Form::number('weight', $menu->weight, array('class' => 'Form-control col-md-8')) }}
                            <div class="row well">{{ Form::submit('Save', ["class"=>'btn btn-success btn-block']) }}
                              {!! Form::close() !!}
                              {!! Form::open(['route'=>['menu.destroy', $menu->id], 'method'=> 'DELETE'])!!}
                                {!! Form::submit('Delete', ["class"=> 'btn-danger btn btn-block']); !!}
                            {!! Form::close(); !!}</div>
                              </div>
                              </div>
                            </div>
                          </div>

                   @endif
          @endforeach
           </div>
        </div>
      <hr>
  @endif
@stop

@else
 <div> Accsess Denied!</div>
@endif
