@extends('layouts.login')
@inject('getProfile','App\Http\Controllers\ProfileCont')
@inject('posts','App\Http\Controllers\PostCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('likes', 'App\Http\Controllers\LikeCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->

@section('meta')
<meta name="title" content="{{ $getInfo->getValue('sitename') }}">
<meta name="description" content="{{ $getInfo->getValue('description') }}">
<meta name="keywords" content="{{ $getInfo->getValue('main_keywords') }}">
<meta name="author" content="{{ $getInfo->getValue('powered_by') }}">

@stop

@section('title')
Sign In
@stop
@section('content')

            <form id="login-form" class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <input id="login-username" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
              @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
              <label for="login-username" class="label-material">E-mail</label>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <input id="login-password" type="password" class="form-control" name="password" required>
              @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
              <label for="login-password" class="label-material">Password</label>
              <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
            </div>

             <div class="row">
                 <button type="submit" href="index.html" class="btn btn-primary">Login</button>
             </div>
            <!-- This should be submit button but I replaced it with <a> for demo purposes-->

          </form>
          <hr>
          <div class="row">
            <div class="col-md-6">
            <a href="/email" class="btn-xs">
                            Forgot Your Password? </a>
           </div>
           <div class="col-md-6">
       <a href="/register" class="btn-xs">Signup</a>
          </div>
           </div>

@endsection
