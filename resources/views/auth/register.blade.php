@extends('layouts.login')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->

@section('meta')
<meta name="title" content="{{ $getInfo->getValue('sitename') }} | Register">
<meta name="description" content="{{ $getInfo->getValue('description') }}">
<meta name="keywords" content="{{ $getInfo->getValue('main_keywords') }}">
<meta name="author" content="{{ $getInfo->getValue('powered_by') }}">

@stop
@section('title')
Sign Up
@stop
@section('content')
                <form id="register-form" class="form-horizontal" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('ip') ? ' has-error' : '' }}">
                      <!-- <input id="ip" type="text" class="form-control" name="ip" value="{{ Request::ip() }}" required autofocus disabled>
                      @if ($errors->has('ip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ip') }}</strong>
                                    </span>
                                @endif
                      <label for="register-ip" class="label-material">User Ip Address</label>
                    </div> -->
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                      <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                      @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                      <label for="register-username" class="label-material">User Name</label>
                    </div>
                    <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                      <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required autofocus>
                      @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                      <label for="register-firstname" class="label-material">First Name</label>
                    </div>
                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                      <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus>
                      @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                      <label for="register-lastname" class="label-material">First Name</label>
                    </div>
                    <div class="form-group{{ $errors->has('industry') ? ' has-error' : '' }}">
                      <input id="industry" type="text" class="form-control" name="industry" value="{{ old('industry') }}" required autofocus>
                      @if ($errors->has('industry'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('industry') }}</strong>
                                    </span>
                                @endif
                      <label for="register-userindustry" class="label-material">Industry</label>
                    </div>
                    <div class="form-group{{ $errors->has('job_title') ? ' has-error' : '' }}">
                      <input id="job_title" type="text" class="form-control" name="job_title" value="{{ old('job_title') }}" required autofocus>
                      @if ($errors->has('job_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('job_title') }}</strong>
                                    </span>
                                @endif
                      <label for="register-userjob_title" class="label-material">Job Title</label>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                       @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                      <label for="register-email" class="label-material">E-Mail Address</label>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <input id="password" type="password" class="form-control" name="password" required>
                      @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                      <label for="register-passowrd" class="label-material">password</label>
                    </div>


                    <div class="form-group terms-conditions">
                      <input id="license" type="checkbox" class="checkbox-template" required class="form-group{{ $errors->has('license') ? ' has-error' : '' }}">
                      @if ($errors->has('license'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('license') }}</strong>
                                    </span>
                                @endif
                      <label for="license">Agree the terms and policy</label>
                    </div>
                     <div class="row">
                    <button type="submit" id="register" type="submit" value="Register" class="btn btn-primary">
                    Register </button>
                     </div>
                  </form>
                  <hr>
                  <div class="row">
                  <a href="/login" class="btn">Login</a>
                  </div>

@endsection
