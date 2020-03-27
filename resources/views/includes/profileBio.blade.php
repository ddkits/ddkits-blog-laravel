@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('posts', 'App\Http\Controllers\PostCont')
@inject('proPosts', 'App\Http\Controllers\ProPostCont')
@inject('encode', 'App\Http\Controllers\AdminCont')
@inject('followers', 'App\Http\Controllers\FollowersCont')
@inject('friends', 'App\Http\Controllers\FriendsCont')

<div class="panel panel-default">
<div class="panel-body">
    <div class="media ">
        <div align="center">
        <a href="{{ route('profile.show', $profile->getProfInfo($user->id)->id) }}">
            <img class="thumbnail img-responsive" src="/{{ $profile->getProfInfo($user->id)->picture }}"  alt="{{ $user->firstname }} {{ $user->lastname }}">
            {{ $user->firstname }} {{ $user->lastname }}
        </a>
        <div align="center" id="tableBioProfile">
            <table class="table table-hover"  >
                    <tr>
                        <td class="table-active"><span class="badge">{{ $proPosts->getUserProPostsCount($user->id) }}</span> Posts </td>
                        <td><span class="badge">{{ $posts->getUserBlogsCount($user->id) }}</span> Blogs </td>
                    </tr>
                    <tr>
                        <td><span class="badge">{{ $followers->getFollowers($user->id) }}</span> Followers </td>
                        <td class="table-active">
                            <span class="badge">{{ $friends->getfriendsCount($user->id) }}</span> Freinds
                        </td>
                    </tr>
         @if($user->id != Auth::user()->id)
         <tr><td>
      @if($user->id != Auth::user()->id)
             {!! Form::open(['route' => 'followers.store', 'id'=>'followUserForm']) !!}
              <div hidden>
              {!! Form::number('uid', Auth::user()->id) !!}
              {!! Form::number('who', $user->id); !!}
              </div>
               {!! Form::submit('Follow', ["class"=> 'btn btn-default btn-block']); !!}
              {!! Form::close(); !!}
         @endif
         </td><td>
        @if($friends->checkIfFriends($user->id, Auth::user()->id) == 'no')

             {!! Form::open(['route' => 'friends.store', 'id'=>'friendsUserForm']) !!}
              <div hidden>
              {!! Form::number('uid1', Auth::user()->id) !!}
              {!! Form::number('uid2', $user->id); !!}
              </div>
               {!! Form::submit('Add friend', ["class"=> 'btn btn-default btn-block']); !!}
              {!! Form::close(); !!}
            @endif

            @if($friends->checkIfFriends($user->id, Auth::user()->id) == 'notYet')
                <span class="btn btn-default btn-block"> Not Confirmed Yet</span>
            @endif

            @if($friends->checkIfFriends($user->id, Auth::user()->id) == 'yes')
             <a href="{{ $friends->destroy($friends->getFriendsInfo(Auth::user()->id, $user->id)->id) }}" class="btn btn-default btn-block"> Remove Friend </a>
            @endif
            </td></tr>
      @endif
    </table>
</div>
</div>
        <script language="javascript" type="text/javascript">
              $(function ($) {
                $('#followUserForm').on('submit', function (e) {
                  e.preventDefault();
                  $.ajax({
                    type: 'post',
                    url: '/followers',
                    data: $('#followUserForm').serialize(),
                    success: function () {
                      $("#tableBioProfile").load(location.href + " #tableBioProfile");
                    }
                  });
                });
              });
              $(function ($) {
                $('#friendsUserForm').on('submit', function (e) {
                  e.preventDefault();
                  $.ajax({
                    type: 'post',
                    url: '/friends',
                    data: $('#friendsUserForm').serialize(),
                    success: function () {
                      $("#tableBioProfile").load(location.href + " #tableBioProfile");
                    }
                  });
                });
              });
            </script>
        <div class="media-body">
            <hr>
            <h3><strong>Bio</strong></h3>
            <p>
                {{ $encode->encoded($profile->getProfInfo($user->id)->description, 500, 0, 'yes') }}
            </p>
            <hr>
            <h3><strong>Industry</strong></h3>
            <p>{{$user->industry}}</p>
            <hr>
            <h3><strong>Job Title</strong></h3>
            <p>{{$user->job_title}}</p>
            <hr>
            <h3><strong>Member Since</strong></h3>
            <p>{{ date('M j,Y', strtotime($user->created_at)) }}</p>
        </div>
</div>
</div>
</div>
