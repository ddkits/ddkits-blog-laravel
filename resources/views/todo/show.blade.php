@extends('layouts.admin')
@inject('viewsAccess', 'App\Http\Controllers\ViewsCont')
@inject('myInfo', 'App\Http\Controllers\DashBoard')
@inject('views', 'App\Http\Controllers\ViewsCont')
@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('getInfo', 'App\Http\Controllers\AdminCont')
@inject('followers', 'App\Http\Controllers\FollowersCont')
@inject('friends', 'App\Http\Controllers\FriendsCont')
@inject('articles', 'App\Http\Controllers\PostCont')

@section('meta')
<meta name="title" content="Creat New Article">
@stop

@section('title')

<h2> <a href="{{ route('my_to_do_list.show', $todo->id)}}">{{ $getInfo->encoded($todo->body, 0, 100, 'yes') }}</a></h2>

@stop


@section('styles')

@stop

@section('content')
   <section class="well col-md-12 no-padding-bottom no-padding-top">
      <div class="well pull-right" >
        <table class="table has-shadow">
        <tr>
          <td>
            <a class="btn btn-success" href="{{ route('my_to_do_list.edit', $todo->id ) }}">Edit</a>
          </td>
          <td>
            <a class="btn btn-danger" href="{{ route('my_to_do_list.destroy', $todo->id )}}">Delete</a>
          </td>
        </tr>
      </table>
    </div>
    </section>
<section class="well col-md-12 dashboard-counts no-padding-top">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
             <div class="post-content">
                {!! $getInfo->encodeOnly($todo->body) !!}
                  @if($files->count() > 0)
                  <div class="has-shadow well pull-left">
                  Files: {{ $files->count() }}
                  <br>
                    @foreach($files->get() as $file)
                      
                        <a href="/{{ $file->file }}" id="todo-loaded-files" target="_blank"><img src="/{{ $file->file }}" id="todo-loaded-files-thumb" width="250" height="250" style="margin: 10px;"><br> {{ $file->ftype }}</a>
                       
                    @endforeach
                    </div>
                  @endif
            </div>
</div>
</div>


</section>
@stop