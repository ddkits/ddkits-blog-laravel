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
  My Inbox
 @stop
@section('content')
<div class="fluid-container col-md-12">
	
			@if($msg)	
			<table class="table col-md-12 table-bordered">			
			<tr class="bg-white has-shadow"><td><a href="/profile/{{ $profile->getProfInfo($msg->from)->id }}"><img src="/{{ $profile->getProfInfo($msg->from)->picture }}" class="avatar img-fluid rounded-circle has-shadow" width="75" height="75" /> {{ $user->find($msg->from)->firstname }} {{ $user->find($msg->from)->lastname }}</a></td><td class="col-xs-10 col-md-10">{{ $msg->body }} <div class="pull-right"> <i class="fa fa-bell-o"></i><span class="badge bg-red">{{ $msgsBar->getReplies($msg->id)->count() }}</span></div> </td></tr>
				<tr>
					<td colspan="2">
				{{ Form::open(['route' => 'messages.store', 'method'=>'POST', 'id'=>'newMsgForm']) }}
                    <div hidden>
                    {{ Form::number('from', Auth::user()->id) }}
                    {{ Form::number('reply', 1) }}
                    {{ Form::number('original', $msg->id) }} 
                    {{ Form::number('profileID', $profile->getProfInfo(Auth::user()->id)->id) }} 
                    </div>
                    <div>
                    	{{ Form::text('to', $msg->from, ['hidden' => 'true']) }}
                    </div>
                    {{ Form::label('body', 'Message: ')}}<br>
                    {{ Form::textarea('body', null, array('class' => 'form-control', 'required' => 'true', 'rows'=>'4')) }}
                    
                     
                    <br><hr>
                    <span class="pull-right">
                        <input type="checkbox" class="btn btn-link" style="text-decoration:none;" name="send"><i class="fa fa-lg fa-at" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Mention"></i></input>
                  	</span>
                  	<span>
                      {{ Form::submit('Send', ['class' => 'btn btn-default btn-block']) }}
                    </span>
					  {{ Form::close() }}
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						@if($msgsBar->getReplies($msg->id))
							<table class="table table-bordered">
												@foreach($msgsBar->getReplies($msg->id)->get() as $reply1)
													<tr class="well has-shadow"><td><a href="/profile/{{ $profile->getProfInfo($reply1->from)->id }}"><img src="/{{ $profile->getProfInfo($reply1->from)->picture }}" class="avatar img-fluid rounded-circle has-shadow" width="75" height="75" /> {{ $user->find($reply1->from)->firstname }} {{ $user->find($reply1->from)->lastname }}</a></td><td class="col-xs-8 col-md-8">{{ $reply1->body }} </td></tr>
												@endforeach
							</table>
						@endif
					</td>
				</tr>
			</table>
		
			@endif

		
</div>
@stop