@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->
@inject('feedList', 'App\Http\Controllers\feedsCont')

@if( $getInfo->adminInfo( Auth::user()->id )->level == 0)

@extends('layouts.admin')

@section('title', 'feed links')

@section('styles')

@stop

@section('content')
   <hr>
   @if( empty($feeds->get()) )
   <div class="project col-md-12">
     <h3 class="h4 row">No feeds yet</h3></div>
   @else
    <div class="project col-md-12">
      <div class="row well bg-white has-shadow">
      <h3 class="align-items-center">All feeds</h3>
        @foreach($feeds->paginate(10) as $feed)
        <div class="col-md-12 d-flex align-items-center justify-content-between">
          <div class="project-title d-flex align-items-center edit">
            {!! Form::open(['route' => ['feeds.update', $feed->id], 'method' => 'put']) !!}
              <div class="row text col-lg-12">
                <a href="#index-{{$feed->id}}" aria-expanded="false" data-toggle="collapse">#{{$feed->id}}: {{$feed->title}}</a>
              <div id="index-{{$feed->id}}" class="collapse">
              {{ Form::label('title', 'Title:', array('class' => 'Form-control col-md-3')) }}{{ Form::text('title', $feed->title, array('class' => 'Form-control col-md-8')) }}
            {{ Form::label('categories', 'Categories:', array('class' => 'Form-control col-md-3')) }} {{ Form::textarea('categories', $feed->categories, array('class' => 'Form-control col-md-8', 'rows'=>'1')) }}
            {{ Form::label('tags', 'feed tags:', array('class' => 'Form-control col-md-3')) }} {{ Form::textarea('tags', $feed->tags, array('class' => 'Form-control col-md-8', 'rows'=>'1')) }}
          <div class="row well">
          {{ Form::submit('Save', ["class"=>"btn btn-success btn-block"]) }}
            {!! Form::close() !!}</div>
            <div class="row well">{!! Form::open(['route'=>['feeds.list.delete', $feed->id], 'method'=> 'DELETE'])!!}
              {!! Form::submit('Delete', ["class"=> 'btn-danger btn btn-block']) !!}
              {!! Form::close(); !!}
              {!! Form::open(['route'=>['feeds.sync', $feed->id], 'method'=> 'post']) !!}
              {!! Form::submit('SYNC', ["class"=> 'btn-danger btn btn-block']) !!}
              {!! Form::number('id', $feed->id , ["class"=> 'btn-danger btn btn-block', 'hidden'=>'true']) !!}

              {!! Form::close(); !!}
            </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <div class="well"> {{ $feeds->paginate(10)->links()  }} </div>
	        </div>
  @endif
@stop

@else
 <div> Accsess Denied!</div>
@endif
