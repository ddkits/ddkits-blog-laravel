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
	    	 <hr>
	    	 <table  class="table table-bordered col-lg-12">
	    	 	<thead><tr><td class="info"> Title </td><td class="info"> Author </td><td class="info"> Homepage </td><td class="info">Added by UID</td></tr></thead>
	    	 	{{ Form::open(['route' => 'admin.posts.save', 'method'=>'POST', 'id'=>'savePosts']) }}
                    
	      @foreach($adminPosts->paginate(10) as $posts)
	     		<tr>
	     			<td>
	     			{{ $posts->title }}
		     		</td>
		     		<td>
	     			{{ $user->find($posts->uid)->firstname }}
		     		</td>
		     		<td>
	     			{{ Form::select('homepage[' . $posts->id . ']', [0=>'No', 1=>'Normal', 2=>'High'], (($posts->homepage) ? $posts->homepage : [0] )) }}
		     		</td>
		     	</tr>
			@endforeach
			</table>
			{{ Form::submit('Save', ['class'=>'btn btn-success']) }}
		{{ Form::close()  }}
			<hr>
			<div class="well"> {{ $adminPosts->paginate(10)->links()  }} </div>
	        </div>	    
@endsection

@endif

