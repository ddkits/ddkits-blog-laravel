@extends('layouts.admin')
@inject('views', 'App\Http\Controllers\ViewsCont')
@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('followers', 'App\Http\Controllers\FollowersCont')
@inject('friends', 'App\Http\Controllers\FriendsCont')

@section('title')
  My Friends
 @stop
@section('content')
<div class="fluid-container col-md-12">
	<table class="table col-md-12">
		<tbody>
			<thead><tr class="bg-white has-shadow"><td>Name</td><td class="pull-right">Status</td></tr></thead>
		@if(!empty($friendsList))
			@foreach($friendsList as $friend)
			@if(!empty($friend))
				@if($friend->uid1 == Auth::user()->id)
					<tr class="bg-white has-shadow" id="friend-{{ $friend->id }}">
						<td>
							<a href="/profile/{{ $profile->getProfInfo($friend->uid2)->id }}">{{ $user->find($friend->uid2)->firstname }} {{ $user->find($friend->uid2)->lastname }}</a>
						</td>
						<td class="pull-right">
							@if($friend->status == 0)
								Not Confirmed by {{ $user->find($friend->uid2)->firstname }} {{ $user->find($friend->uid2)->lastname }}
							@endif
							@if($friend->status == 1)
								Confirmed
							@endif
						</td>
					</tr>
					@else
					<tr class="bg-white has-shadow" id="friend-{{ $friend->id }}">
						<td>
							<a href="/profile/{{ $profile->getProfInfo($friend->uid1)->id }}">{{ $user->find($friend->uid1)->firstname }} {{ $user->find($friend->uid1)->lastname }}</a>
						</td>
						<td class="pull-right">
							@if($friend->status == 0)
									{!! Form::open(['action'=>'FriendsCont@friendsConfirm', 'id'=>'friendForm'.$friend->id]) !!}
									<div hidden>
										{!! Form::number('id', $friend->id) !!}
									</div>
									{!! Form::submit('Confirm', ["class"=> 'btn btn-default btn-xs']); !!}
									{!! Form::close() !!}
							@endif
							@if($friend->status == 1)
								Confirmed
							@endif
						</td>
						
					</tr>
				@endif
				@endif
				 <script>
					  $(function () {
					    $('#friendForm-{{ $friend->id }}').on('submit', function (e) {
					      e.preventDefault();
					      $.ajax({
					        type: 'friend',
					        url: '/friends',
					        data: $('#friendForm-{{ $friend->id }}' ).serialize(),
					        success: function () {
					          $("#friend-{{ $friend->id }}").load(location.href + " #friend-{{ $friend->id }}");
					        }
					      });
					    });
					  });
					</script>
			@endforeach
		@endif
	</tbody>
</table>
		
</div>
@stop