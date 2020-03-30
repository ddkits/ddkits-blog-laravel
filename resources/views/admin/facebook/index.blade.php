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
	    			{!! Form::open(array('route' => 'admin-facebook.store')) !!}
	    			<tr>
	    				<td>
                            {{ Form::text('title','', ['class'=>'form-control', 'placeholder'=>'Title']) }}
                        </td>
                        <td>
                            {{ Form::text('appId', '', ['class'=>'form-control', 'placeholder'=>'appId']) }}
                       </td>
                       <td>
                             {{ Form::text('appSecret', '', ['class'=>'form-control', 'placeholder'=>'appSecret']) }}
                        </td>
                        <td>
                            {{ Form::text('pageId','', ['class'=>'form-control', 'placeholder'=>'pageId']) }}
                        </td>
                        <td>
                            {{ Form::text('userAccessToken', '', ['class'=>'form-control', 'placeholder'=>'userAccessToken']) }}
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
                 <thead><tr>
                    <th class="info"> Title </th>
                    <th class="info"> appId </th>
                    <th class="info"> pageId </th>
                    <th class="info">Added by UID</th>
                    <th class="info danger">Delete</th></tr>
                </thead>


          @foreach($settings as $settings)
          {{ Form::open(['route' => ['admin-facebook.destroy', $settings->id ], 'method'=>'DELETE', 'id'=>'newMsgForm']) }}
             <tr>
                 <td> {{ $settings->title }}</td>
                <td> {{ $settings->appId }}</td>
                <td> {{ $settings->pageId }}</td>
                <td>{{ ($user->find($settings->uid)) ? $user->find($settings->uid)->firstname : '' }}</td>
                <td> {{ Form::submit('Delete', ['class'=>'btn btn-danger']) }}</td>
            </tr>

			{{ Form::close()  }}
			@endforeach
			</table>

			<hr>
			<h1>Site Extra</h1>
	    	<table class="table table-bordered col-lg-12">
	    		<tbody>
	    			<tr>
	    				<td>
	    					Bulk Posts (bulk Posts)
	    				</td>
	    				<td>
	    					{{ Form::open(array('route' => 'admin-facebook.post')) }}
		    				{{ Form::submit('Bulk Posts', ['class'=>'form-control btn-success']) }}
		    				{{ Form::close() }}
	    				</td>

	    			</tr>
	    		</tbody>
			</table>


	      </div>
@endsection

@endif

