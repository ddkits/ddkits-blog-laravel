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
   
<section class="well col-md-12 no-padding-top">
            <div class="container-fluid">
  
	
	
    {!! Form::open(array('route' => 'my_to_do_list.store', 'files'=>'true')) !!}
    <div class="">
      <div class=" pull-left btn-default">
        {{ Form::label('file[]', 'Add Attachment', ['class'=>'btn btn-default'])  }}{{ Form::file('file[]', ['onchange' => 'readURL(this);' , 'multiple'=> 'true', "class" => 'btn btn-file']) }}
        <a href="" id="todo-loaded-files" value="" target="_blank" style="display: none;"><img src="" id="todo-loaded-files-thumb" width="25" height="25"> Ready To Upload </a>
          </div>
          <div hidden>
            {{ Form::number('uid', Auth::user()->id) }}
          </div>
       <div class="pull-right well">
               
           {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
            <a href="{{ route('my_to_do_list.index') }}" class="btn btn-danger">Cancel</a>
        </div>
            <div >
              <table class=" table well">
                <tr><td >
                  {{ Form::text('date_from', null, array('class' => 'form-control ', 'placeholder' => 'From')) }}
              
                </td>
                <td>
                  {{ Form::text('date_to', null, array('class' => 'form-control ', 'placeholder' => 'To')) }}
                </td>
              </tr>
              </table>
              
            </div>
         
        <div class="form-group">
            {{ Form::textarea('body', null, array('class' => 'form-control ckeditor', 'required' => 'required')) }}
        </div>
        <div class="left-col align-items-center justify-content-between">
            <div class="time">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
        </div>
    </div>
        {!! Form::close() !!}
       
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