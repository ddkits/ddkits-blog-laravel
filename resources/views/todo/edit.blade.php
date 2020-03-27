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

@section('meta')
<meta name="title" content="Creat New Article">
@stop

@section('title')

<h2>Creat New To Do</h2>

@stop


@section('styles')

@stop

@section('content')
   
   
          
<section class="well col-md-12 no-padding-bottom no-padding-top">
            <div class="container-fluid">
	
    {!! Form::open(array('route' => ['my_to_do_list.update', $todo->id], 'method'=>'PUT', 'files'=>'true')) !!}
    <div class="">
      <div class=" pull-left btn-default">
        {{ Form::label('file[]', 'Add Attachment', ['class'=>'btn btn-default']) }} {{ Form::file('file[]' ,['onchange' => 'readURL(this);' ,"class" => 'btn btn-file', 'multiple'=>'true']) }}
      </div>
          <div hidden>
            {{ Form::number('uid', $todo->uid) }}
          </div>
       <div class="pull-right well">
               
           {{ Form::submit('Update', ['class' => 'btn btn-success']) }}
            <a href="{{ route('blog.index') }}" class="btn btn-danger">Cancel</a>
        </div>
            <div >
              <table class=" table well">
                <tr><td >
                  {{ Form::text('date_from', ( ($todo->Date_from) ? $todo->Date_from : '' ), array('class' => 'form-control ', 'placeholder' => 'From')) }}
              
                </td>
                <td>
                  {{ Form::text('date_to', ( ($todo->Date_from) ? $todo->Date_to : '' ), array('class' => 'form-control ', 'placeholder' => 'To')) }}
                </td>
              </tr>
              </table>
              
            </div>
         
        <div class="form-group">
            {{ Form::textarea('body', ( ($todo->body) ? $todo->body : '' ), array('class' => 'form-control ckeditor', 'required' => 'required')) }}
        </div>
         
        <div class="left-col align-items-center justify-content-between">
            <div class="time">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
        </div>
    </div>

        {!! Form::close() !!}
       @if($files->count() > 0)
          @foreach($files->get() as $file)
          <div class="has-shadow bg-white">
            <a href="/{{ $file->file }}" id="todo-loaded-files" target="_blank" class="rounded" style="margin: 20px;border: 2px solid #000;"><i class="fa">{{ Form::open(['route' => ['media.destroy', $file->id], 'method' => 'DELETE']) }}
                  {{ Form::submit('X', ['class'=>'fa btn-danger btn-xs']) }}
                  {{ Form::close() }}</i><img src="/{{ $file->file }}" id="todo-loaded-files-thumb" class="rounded mx-auto d-block" width="250" height="250" style="margin: 10px;"><br> {{ $file->ftype }}</a>
          @endforeach
        @endif
</div>

<script type="text/javascript">
  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#todo-loaded-files')
                    .attr('href', e.target.result);
                $('#todo-loaded-files-thumb')
                    .attr('src', e.target.result);
                 $('#todo-loaded-files').toggle("slow");
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</section>
@stop