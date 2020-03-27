@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('msgsBar', 'App\Http\Controllers\MsgCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('user', 'Illuminate\Foundation\Auth\User')

@if( ($getInfo->getAdmin(Auth::user()->id) == 1  AND $getInfo->getAdminLevel() == 0)  || Auth::user()->id == 1)
@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('content')
	    <!-- edit form column -->	      	
	    <div class="well bg-white col-lg-12 has-shadow align-items-center text-center">
	    	<h1>Site Configurations</h1>
	    	<table class="table table-bordered col-lg-12">
	    		<tbody>
	    			{!! Form::open(array('route' => 'settings.store')) !!}
	    			<tr>
	    				<td>
	    				{{ Form::text('field_name','', ['class'=>'form-control', 'placeholder'=>'Name']) }}
	    				</td>
	    				<td>
	    				{{ Form::text('value', '', ['class'=>'form-control', 'placeholder'=>'Value']) }}
	    				</td>
	    				<td>
	    				{{ Form::select('type', ['settings'=>'Settings', 'config'=>'Config', 'private'=>'Private'], ['settings'], ['class'=>'form-control']) }}
	    				</td>
	    				<td>
	    				{{ Form::submit('Create', ['class'=>'form-control btn-success']) }}
	    				</td>
	    				
	    			</tr>
	    		</tbody>
			    <dir hidden>
			    	{{ Form::number('uid', Auth::user()->id, ['class'=>'form-control']) }}
			    </dir>
			    {!! Form::close() !!}

	    	</table>
	    	 <hr>
	    	 <table  class="table table-bordered col-lg-12">
	    	 	<thead><tr><td class="info"> Name </td><td class="info"> Value </td><td class="info"> Type </td><td class="info">Added by UID</td></tr></thead>
	    	 	{{ Form::open(['route' => 'admin.settings.save', 'method'=>'POST', 'id'=>'newMsgForm']) }}
                    
	      @foreach($settings as $settings)
	     	<tr><td>{{ str_replace('_', ' ', ucfirst($settings->field_name)) }} </td><td> {{ (($settings->field_name != 'powered_by') ? Form::text($settings->field_name, $settings->value, ['class'=>'form-control']) : $settings->value ) }} </td><td> {{ $settings->type }}</td><td>{{ ($user->find($settings->uid)) ? $user->find($settings->uid)->firstname : '' }}</td></tr>
			@endforeach
			</table>
				{{ Form::submit('Save', ['class'=>'btn btn-success']) }}
			{{ Form::close()  }}
			<hr>
			<h1>Site Extra</h1>
	    	<table class="table table-bordered col-lg-12">
	    		<tbody>
	    			<tr>
	    				<td>
	    					Update All Posts Paths (bulk update)
	    				</td>
	    				<td>
	    					{{ Form::open(array('route' => 'admin.updatePath')) }}
		    				{{ Form::submit('Bulk Update', ['class'=>'form-control btn-success']) }}
		    				{{ Form::close() }}
	    				</td>
	    				<td>
	    					Homepage Featured Posts
	    				</td>
	    				<td>
	    					<a href="/admin-posts" class="form-control btn-success">Click here</a>
	    				</td>
	    			</tr>
	    		</tbody>
			</table>
			    

	      </div>	    
@endsection

@endif

