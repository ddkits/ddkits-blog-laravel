@extends('layouts.admin')
@inject('views', 'App\Http\Controllers\ViewsCont')
@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('followers', 'App\Http\Controllers\FollowersCont')
@inject('friends', 'App\Http\Controllers\FriendsCont')

@section('title')
  My Outbox
 @stop
@section('content')
<div class="fluid-container col-md-12">
		<table class="table col-md-12">
		<tbody>
	@if($msgs->count() >= 1)
		@foreach($msgs as $msg)
			
			<table class="table col-md-12 table-bordered">
				<colgroup>
		            <col class="col-xs-3">
		            <col class="col-xs-6">
		            <col class="col-xs-3">
		        </colgroup>
			<tr class="bg-white has-shadow"><td ><a href="/profile/{{ $profile->getProfInfo($msg->to)->id }}"><img src="/{{ $profile->getProfInfo($msg->to)->picture }}" class="avatar img-fluid rounded-circle has-shadow" width="75" height="75" /> {{ $user->find($msg->to)->firstname }} {{ $user->find($msg->to)->lastname }}</a></td><td class="col-xs-3 col-mc-3 col-lg-3">{{ $getInfo->encoded($msg->body, 0, 100) }} 
				
				<td ><a href="{{ route('messages.show', $msg->id) }}" id="show-{{ $msg->id }}" class="btn btn-primary pull-right" > View </a></td></div></td></tr>
			</table>
		@endforeach
	@endif
		</tbody>
</table>
		
</div>
@stop