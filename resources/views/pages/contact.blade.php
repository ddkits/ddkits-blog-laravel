@extends('layouts.admin')

@section('title', 'Contact Us')

@section('styles')

@endsection

@section('content')

    {!! Form::open(array('route' => 'blog.store', 'data-parsley-validate' => '')) !!}
        {{ form::label('title', 'Title:') }}
        {{ form::text('title', null, array('class' => 'form-control', 'required' => '')) }}
        {{ form::label('body', 'Blog Body:') }}
        {{ form::textarea('body', null, array('class' => 'form-control', 'required' => '')) }}
        {{ form::submit('Create Post'), array('class' => 'btn btn-block btn-success btn-lg', 'style' => 'margin-top:20px;') }}
    {!! Form::close() !!}

@endsection
