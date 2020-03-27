@inject('getInfo', 'App\Http\Controllers\AdminCont')
@if( ($getInfo->getAdmin(Auth::user()->id) == 1  AND $getInfo->getAdminLevel() == 0)  || Auth::user()->id == 1)
@extends('layouts.admin')

@section('title', 'Settings Panel')

@section('content')

@endsection

@endif

