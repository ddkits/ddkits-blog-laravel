@extends('layouts.admin')
@inject('viewsAccess', 'App\Http\Controllers\ViewsCont')
@inject('myInfo', 'App\Http\Controllers\DashBoard')
@inject('views', 'App\Http\Controllers\ViewsCont')
@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('followers', 'App\Http\Controllers\FollowersCont')
@inject('friends', 'App\Http\Controllers\FriendsCont')
@inject('articles', 'App\Http\Controllers\PostCont')

@section('title')
  To Do List
 @stop

@section('meta')
<meta name="title" content="{{ $user->firstname  }} {{ $user->lastname  }}">
<meta name="description" content="{{ $user->firstname  }} {{ $user->lastname  }} Files">
  <meta name="keywords" content="{{ $user->firstname  }}, {{ $user->lastname  }}">
  <meta name="author" content="{{ $user->firstname  }} {{ $user->lastname  }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <i class="fa fa-check text-success" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $user->firstname  }} {{ $user->lastname  }} is sharing with you"></i> -->
@stop


@section('content')
<section class="well col-md-12 no-padding-top bg-white has-shadow">
            <div class="container-fluid">
    <div class="pull-right">
                        {!! Form::open(array('route' => ['media.store'], 'method'=>'POST', 'files'=>'true', 'id' => 'uploadmedia')) !!}
                               {{ Form::label('file[]', 'Upload Files', ['class'=>'btn btn-success', 'style'=>'margin: 20px;border: 2px solid #000;cursor: pointer;']) }} 
                            <div hidden>
                              {{ Form::file('file[]' ,['onchange' => 'readURL(this);', 'multiple'=>'true']) }}
                                  {{ Form::number('uid', Auth::user()->id ) }}
                                </div>
                            {!! Form::close() !!}                     
                    </div>
          </div>
        </section>


        <section class="well col-md-12 no-padding-top bg-white has-shadow">
            <div class="container-fluid">
               
         @if($files->count() > 0)
                  <div class="">
                  Files: {{ $files->count() }}
                  <br>
                    @foreach($files->paginate(6) as $file)
                        <a href="/{{ $file->file }}" id="todo-loaded-files" target="_blank" class="has-shadow well pull-left" style="margin: 20px;border: 2px solid #000;"><i class="fa">{{ Form::open(['route' => ['media.destroy', $file->id], 'method' => 'DELETE']) }}
                  {{ Form::submit('X', ['class'=>'fa btn-danger btn-xs']) }}
                  {{ Form::close() }}</i><img src="/{{ $file->file }}" id="todo-loaded-files-thumb" class="rounded mx-auto d-block" width="250" height="250" style="margin: 10px;"><br> {{ $file->ftype }}</a>
                    @endforeach
                @else
                <div class="has-shadow well pull-left">
                  No files.

                </div>
              </div>

             @endif
       </div>     
       
       
</section>
<div class="form-control text-align-center">
         {{ $files->paginate(6)->links() }}
       </div>  
    <script type="text/javascript">
  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            $("#uploadmedia").change(function() {
			    this.submit();
			  });
        }
    }
</script>
@stop