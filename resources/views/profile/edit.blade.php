@extends('layouts.admin')

@section('title')
{{ Auth::user()->username }}

@stop
@section('content')

@inject('getProfile','App\Http\Controllers\ProfileCont')
<script type="text/javascript">
  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-loaded-image')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<section>
 {!! Form::open(['route' => ['profile.update', $profile->id], 'id'=>'profileform', 'method' => 'put','files'=>'true']) !!}
<div class="fluid-container has-shadow bg-white col-lg-12 d-flex align-items-center" style="padding-top: 60px;">  
  <div class="row">
    <!-- left column -->
    <div class="col-md-6 col-sm-6">
      <div class="text-center">
        <img src="/{{ $profile->picture }}" style="border-radius: 50%; width:60%;" id='profile-loaded-image' class="avatar img-circle img-thumbnail" alt="avatar">
        
      {{ Form::file('image', ['id' => 'profile-image', 'onchange' => 'readURL(this);' , 'class'=>'btn btn-default btn-file']) }}
        {{ Form::label('body', 'Bio:', ["class" => 'col-md-12 ']) }}{{ Form::textarea('description', $profile->description, ["class" => 'form-control', 'required' => 'true']) }}
        {{ Form::number('uid', Auth::user()->id, ["class" => 'form-control', "hidden"=>1]) }}
      </div>
    </div>
    <!-- edit form column -->
    <div class="col-md-6 col-sm-6 personal-info">
      <h3>Personal info</h3>
      <form class="form-horizontal" role="form">
       
        <div class="form-group">
          <div class="col-lg-8">
           {{ Form::label('email', 'E-mail:', ["class" => 'col-md-12 ']) }}{{ Form::text('email', $getProfile->getUserInfo($profile->uid)->email, ["class" => 'form-control', 'disabled'=>1]) }}
          </div>
        </div>

        <div class="form-group">
          <div class="col-lg-8">
            {{ Form::label('firstname', 'Firstname:', ["class" => 'col-md-12 ']) }}{{ Form::text('firstname', $getProfile->getUserInfo($profile->uid)->firstname, ["class" => 'form-control', 'required' => 'true']) }}
          </div>
        </div>

        <div class="form-group">
          <div class="col-lg-8">
           {{ Form::label('lastname', 'Lastname:', ["class" => 'col-md-12 ']) }}{{ Form::text('lastname', $getProfile->getUserInfo($profile->uid)->lastname, ["class" => 'form-control', 'required' => 'true']) }}
          </div>
        </div>

        <div class="form-group">
          <div class="col-lg-8">
           {{ Form::label('job_title', 'Job Title:', ["class" => 'col-md-12 ']) }}{{ Form::text('job_title', $getProfile->getUserInfo($profile->uid)->job_title, ["class" => 'form-control']) }}
          </div>
        </div>

        <div class="form-group">
          <div class="col-lg-8">
           {{ Form::label('industry', 'Industry:', ["class" => 'col-md-12 ']) }}{{ Form::text('industry', $getProfile->getUserInfo($profile->uid)->industry, ["class" => 'form-control']) }}
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-lg-8">
           {{ Form::label('password', 'Current Password:', ["class" => 'col-md-12 required']) }}{{ Form::password('password', null, ["class" => 'form-control col-md-12 block', 'required' => 'true']) }}
          </div>
        </div>

        <div class="form-group">
          <div class="col-lg-8">
           {{ Form::label('new_password', 'New Password:', ["class" => 'col-md-12 ']) }}{{ Form::password('new_password', null, ["class" => 'form-control col-md-12 block']) }}
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            {{ Form::submit('Save', ['class'=>'btn btn-primary']) }}
            <span></span>
            <input class="btn btn-default" value="Cancel" type="reset">
          </div>
        
        </div>
      </form>
    </div>
    
  </div>
</div>
{!! Form::close() !!}
</section>
@stop