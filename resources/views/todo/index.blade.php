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

@section('title')
  To Do List
 @stop

@section('meta')
<meta name="title" content="{{ $user->firstname  }} {{ $user->lastname  }}">
<meta name="description" content="{{ $user->firstname  }} {{ $user->lastname  }} To do List page">
  <meta name="keywords" content="{{ $user->firstname  }}, {{ $user->lastname  }}">
  <meta name="author" content="{{ $user->firstname  }} {{ $user->lastname  }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <i class="fa fa-check text-success" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $user->firstname  }} {{ $user->lastname  }} is sharing with you"></i> -->
@stop


@section('content')
<section class="well col-md-12 no-padding-top">
      <div class="well pull-right bg-white has-shadow container-fluid text-center" ><a  class="btn btn-default" href="{{ route('my_to_do_list.create')}}">Create New</a></td></div>
    </section>
        <section class="well col-md-12 no-padding-top">
            <div class="container-fluid">
              
          @if($allToDo)
              @foreach($allToDo->get() as $todo)
                  <!-- task content  -->
                  <table class="bg-white has-shadow table table-bordered table-hoverable">
                     <tr> <td class="post-content">
                        <a href="{{ route('my_to_do_list.show', $todo->id)}}">{{ $getInfo->encoded($todo->body, 0, 200, 'yes') }}</a></td>
                        <td class="pull-right">{{ $todo->Date_from }} - {{ $todo->Date_to }} </td>
                    </tr>
                  </table>
               @endforeach
             @else
                <div class="row bg-white has-shadow">
                    Nothing to do yet, create new to do task by clicking here.
                </div>
             @endif
       </div>       

</section>
    
@stop