@extends('layouts.admin')
@inject('views', 'App\Http\Controllers\ViewsCont')
@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('followers', 'App\Http\Controllers\FollowersCont')
@inject('friends', 'App\Http\Controllers\FriendsCont')
@inject('msgsBar', 'App\Http\Controllers\MsgCont')



@section('title')
  New Message
 @stop
@section('content')
<script>
  $( function() {
    var availableTags = "{{ json_encode($msgsBar->getFriendsList()) }}";
    $( "#auto" ).autocomplete({
      source: availableTags;
    });
  } );
  </script>
      <div class="panel-body bg-white col-md-12 col-xs-12 box-shadow">
                    {!! Form::open(['action' => 'MsgCont@store', 'method'=>'POST', 'id'=>'newMsgForm']) !!}
                    <div hidden>
                    {{ Form::number('from', Auth::user()->id) }} 
                    {{ Form::number('profileID', $profile->getProfInfo(Auth::user()->id)->id) }} 
                    </div>
                    <br>
                    <div>
                    	{{ Form::label('to', 'To: ')}}
                    	{{ Form::select('to', $form_to, null, ['class' => 'form-control select2', 'required'=>'true']) }}
                    	
                    </div>
                    {{ Form::label('body', 'Message: ')}}<br>
                    {{ Form::textarea('body', null, array('class' => 'form-control col-md-10', 'required' => '', 'rows'=>'4')) }}
                    
                     <span>
                      
                           {{ Form::submit('Send', ['class' => 'btn btn-default btn-block']) }}
                    </span>
                    <br><hr>
                    <span class="pull-right">
                        <input type="checkbox" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-at" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Mention"></i></input>
                  
                    </span>
  {!! Form::close() !!}
</div>
@stop