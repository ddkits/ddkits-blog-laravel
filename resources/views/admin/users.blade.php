@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('msgsBar', 'App\Http\Controllers\MsgCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('user', 'Illuminate\Foundation\Auth\User')

@if( ($getInfo->getAdmin(Auth::user()->id) == 1  AND $getInfo->getAdminLevel() == 0)  || Auth::user()->id == 1)
@extends('layouts.admin')

@section('title', 'Users Admin Panel')

@section('content')
	    <!-- edit form column -->	      	
	    <div class="well bg-white col-lg-12 has-shadow align-items-center text-center">
	    	<h1>Users Configurations</h1>
	    	<p> {{ $adminUsers->paginate(20)->links() }} </p>
	    	 <hr>
	    	 <table  class="table table-bordered col-lg-12">
	    	 	<thead><tr><td class="info">UID</td><td class="info"> Name </td><td class="info"> Email </td><td class="info"> Ip </td><td class="info">Profile ID</td><td class="info">Admin</td><td class="info">Block</td></tr></thead>
	    {{ Form::open(['route' => 'admin.users.save', 'method'=>'POST', 'id'=>'newUsersUpdates']) }}
        {{ Form::submit('Save', ['class'=>'btn btn-success pull-right']) }}        
	      @foreach($adminUsers->paginate(20) as $users)
	     	<tr>
	     		<td>{{ Form::text('user[' . $users->id . '][id]', $users->id, ['class'=>'form-control', 'size'=>'32', 'hidden'=>1]) }}{{  $users->id }}</td>
	     		<td>{{ Form::text('user[' . $users->id . '][username]', $users->username, ['class'=>'form-control', 'size'=>'32']) }}</td>
	     		<td>{{ Form::text('user[' . $users->id . '][email]', $users->email, ['class'=>'form-control', 'size'=>'32']) }}</td>
	     		<td>{{ $users->ip }}</td>
	     		<td>{{ $users->profile }}</td>
	     		<td>{{ Form::select('user[' . $users->id . '][admin]', ['No', 'Yes'], (($getInfo->getAdmin($users->id) == 1) ? [1] : [0] ), ['class'=>'form-control select2']) }}</td>
	     		<td>{{ Form::select('user[' . $users->id . '][blocked]', ['No', 'Yes'], (( $users->blocked == 1) ? [1] : [0] ), ['class'=>'form-control select2']) }}</td>
	     	</tr>
			@endforeach
			</table>
			
			{{ Form::close()  }}
		
			<hr>
			
	        </div>	    
@endsection

@endif

