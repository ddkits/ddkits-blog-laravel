@inject('getInfo', 'App\Http\Controllers\AdminCont')
<!-- {{ $getInfo->getValue('sitename') }} -->
@inject('feedList', 'App\Http\Controllers\feedsCont')

@if( $getInfo->adminInfo( Auth::user()->id )->level == 0)

@extends('layouts.admin')

@section('title', 'feed links')

@section('styles')

@stop

@section('content')
    {{ print_r($message) }}
@endsection
@endif