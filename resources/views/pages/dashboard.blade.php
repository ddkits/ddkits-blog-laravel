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
  Welcome {{ Auth::user()->name }}
 @stop
 @section('meta')
 <script src="//code.highcharts.com/highcharts.js"></script>
 <script src="//code.highcharts.com/modules/exporting.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
 @endsection

  @section('content')

  <!-- Dashboard Admin level 0 only Counts Section-->

  @if( ($getInfo->getAdmin(Auth::user()->id) == 1  AND $getInfo->getAdminLevel() == 0)  || Auth::user()->id == 1)
        @if( $getInfo->adminInfo(Auth::user()->id)->level == 0 )
        <section class="well col-md-12 dashboard-counts no-padding-bottom">
                <div class="container-fluid">
                  <div class="row bg-white has-shadow">
                    <!-- Item -->
                    <div class="col-xl-2 col-sm-6">
                      <div class="item d-flex align-items-center">
                        <div class="icon bg-violet"><i class="icon-user"></i></div>
                        <div class="title"><span>Blogs</span>
                          <div class="progress">
                            <div role="progressbar" style="width: '{{ $postsc }}'; height: 4px;" aria-valuenow="25%" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>{{ $postsc }}
                          </div>
                        </div>
                        <div class="number"><strong></strong></div>
                      </div>
                    </div>
                    <!-- Item -->
                    <div class="col-xl-2 col-sm-6">
                      <div class="item d-flex align-items-center">
                        <div class="icon bg-red"><i class="icon-padnote"></i></div>
                        <div class="title"><span>Comments</span>
                          <div class="progress">
                            <div role="progressbar" style="width: '{{ $commentsc }}'; height: 4px;" aria-valuenow="25%" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>{{ $commentsc }}
                          </div>
                        </div>
                        <div class="number"><strong></strong></div>
                      </div>
                    </div>
                    <!-- Item -->
                    <div class="col-xl-2 col-sm-6">
                      <div class="item d-flex align-items-center">
                        <div class="icon bg-green"><i class="icon-bill"></i></div>
                        <div class="title"><a href="{{ route('admin.users') }}"><span>Users</span>
                          <div class="progress">
                            <div role="progressbar" style="width: '{{ Auth::user()->count() }}'; height: 4px;" aria-valuenow="25%" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>{{ Auth::user()->count() }}
                          </div>
                          </a>
                        </div>
                        <div class="number"><strong></strong></div>
                      </div>
                    </div>
                    <!-- Item -->
                    <div class="col-xl-2 col-sm-6">
                      <div class="item d-flex align-items-center">
                        <div class="icon bg-yellow"><i class="icon-bill"></i></div>
                        <div class="title"><a href="{{ route('feeds.index') }}"><span>Feeds</span>
                          <div class="progress">
                            <div role="progressbar" style="width: '{{ $feedsCount }}'; height: 4px;" aria-valuenow="25%" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>{{ $feedsCount }} </div>
                          </a>
                        </div>
                        <div class="number"><strong></strong></div>
                      </div>
                    </div>
                    <!-- Item -->
                    <div class="col-xl-2 col-sm-6">
                      <div class="item d-flex align-items-center">
                        <div class="icon bg-orange"><i class="icon-check"></i></div>
                        <div class="title"><span>Admins</span>
                          <div class="progress">
                            <div role="progressbar" style="width: '{{ $adminsCount }}'; height: 4px;" aria-valuenow="{{ $adminsCount }}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange"></div>{{ $adminsCount }}
                          </div>
                        </div>
                        <div class="number"><strong></strong></div>
                      </div>
                    </div>
                  </div>
                </div>
        </section>

          @endif
      @endif
          <!-- Dashboard Header Section    -->
          <section class="well col-md-12 dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row">
                <!-- Statistics -->
                <div class="statistics col-lg-3 col-12">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="icon-user"></i></div>
                    <a href=" {{ route('friends.index') }}"><div class="text"><strong>{{ $friendsc }}</strong><br><small>Friends</small></a></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-calendar-o"></i></div>
                    <div class="text"><strong>{{ $followersc }}</strong><br><small>Followers</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-paper-plane-o"></i></div>
                    <div class="text"><strong>{{ $myPostsViews }}</strong><br><small>Views</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                   <div class="icon bg-violet"><i class="fa fa-tasks"></i></div>
                    <a href="{{ route('blog.index') }}"><div class="text"><strong>{{ $myPostsCount }}</strong><br><small>Articles</small></a></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-blue"><i class="fa fa-tasks"></i></div>
                    <a href="{{ route('media.index') }}"><div class="text"><strong>{{ (($myFiles) ?$myFiles->count() : 0) }}</strong><br><small>Files</small></a></div>
                  </div>
                </div>
                <!-- Line Chart  -->
                <div class="chart col-lg-6 col-12">
                  <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow">
                    <div id="friendsChart" style="width: 80%; height: 400px; max-width: auto; margin: 0 auto"></div>
                    <script type="text/javascript">
                      Highcharts.chart('friendsChart', {
                            chart: {
                                type: 'pie',
                                options3d: {
                                    enabled: true,
                                    alpha: 45,
                                    beta: 0
                                }
                            },
                            title: {
                                text: 'Articles Views Chart'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    depth: 35,
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.name}'
                                    }
                                }
                            },
                            credits: {
                                    enabled: false
                                },
                            series: [{
                                type: 'pie',
                                name: 'Posts',
                                data: [
                                    <?php foreach ($myViewsChart as $key => $value): ?>
                                        [ '{{ substr($key, 0, 15) }}' ,   {{ $value }}],
                                    <?php endforeach ?>
                                ]
                            }]
                        });
                    </script>
                  </div>
                </div>
                <div class="chart col-lg-3 col-12">
                  <!-- Bar Chart   -->
                  <div class="bar-chart has-shadow bg-white">
                    <div class="title"><strong class="text-violet"></strong><br><small></small></div>
                    <div id="postsBarChart" style="width: 90%; height: 400px; max-width: auto; margin: 0 auto"></div>
                    <script type="text/javascript">
                      // postsBarChart
                        Highcharts.chart('postsBarChart', {
                            chart: {
                                type: 'column',
                                    options3d: {
                                        enabled: true,
                                        alpha: 10,
                                        beta: 25,
                                        depth: 70
                                    }
                            },
                            title: {
                                text: 'Articles Post chart by Day'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    depth: 35,
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.name}'
                                    }
                                }
                            },
                            credits: {
                                    enabled: false
                                },
                            series: [{
                                type: 'pie',
                                name: 'Posts',
                                data: [
                                    <?php foreach ($myPostsChart as $key => $value): ?>
                                        [ '{{  $value["month"] }} {{  $value["day"] }},{{  $value["year"] }} = {{  $value["count"] }} Posts' ,   {{  $value["count"] }}],
                                    <?php endforeach ?>
                                ]
                            }]
                        });

                    </script>
                  </div>
                  <!-- Numbers-->
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-line-chart"></i></div>
                    <div class="text"><strong>{{( ($myPostsCount ? (round((($myPostsCount) * 100), 2) . '%') : '0' ) )}}</strong><br><small>Your Rate comparing to other</small></div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Posts Section-->
          <section class="projects no-padding-top col-md-12">
            <div class="container-fluid">
         @foreach($myPosts->paginate(5, ['*'], 'myposts') as $myPost)
              <!-- Project-->
              <div class="project">
                <div class="row bg-white has-shadow">
                  <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
                    <div class="project-title d-flex align-items-center">
                      <div class="image image-thumbnail"><img src="/{{ $myPost->image  }}" alt="{{ $myPost->title }}" class="img-fluid" width="35" height="35"></div>
                      <div class="text">
                        <a href="/news/{{ $myPost->path }}"><h3 class="h4">{{ $myPost->title }}</h3></a>
                      </div>
                    </div>
                    <div class="project-date"><span class="hidden-sm-down">{{ date('M j, Y', strtotime($myPost->created_at)) }}</span></div>
                  </div>
                  <div class="right-col col-lg-6 d-flex align-items-center">
                    <div class="time"><i class="fa fa-clock-o"></i>{{ date('H:i:s', strtotime($myPost->created_at)) }}</div>
                    <div class="comments"><i class="fa fa-comment-o"></i>{{ $postCommentsCount[$myPost->id] }}</div>
                    <div class="project-progress">
                      <div class="progress">
                        <div role="progressbar" style="width: {{ $myPostViews[$myPost->id] }}; height: 6px;" aria-valuenow="{{ ($myPostViews[$myPost->id] * 100) }}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>{{ $myPostViews[$myPost->id] }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              <div class="well">{{ $myPosts->paginate(5, ['*'], 'myposts')->links() }}</div>
            </div>
          </section>
          <!-- Client Section-->
          <section class="client no-padding-top col-md-12">
            <div class="container-fluid">
              <div class="row">
                <!-- Work Amount  -->
                <div class=" well col-md-4">
                  <div class="work-amount card">
                    <div class="card-close">
                      <div class="dropdown">
                        <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a></div>
                      </div>
                    </div>
                    <div class="card-body">
                      <h3>Member Since</h3><small>Last Update was in {{ Auth::user()->updated_at }}</small>
                      <div class="chart text-center">
                        <div class="text"><strong>{{ Auth::user()->created_at }}</strong><br><span></span></div>
                        <canvas id="pieChart"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Client Profile -->
                <div class="col-lg-4 well pull-left">
                  <div class="client card">
                    <div class="card-close">
                      <div class="dropdown">
                        <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a></div>
                      </div>
                    </div>
                    <div class="card-body text-center">
                      <div class="client-avatar"><img src="/{{ $profile->getProfInfo($randomUser->id)->picture }}" alt="..." class="img-fluid rounded-circle">
                        <div class="status bg-green"></div>
                      </div>
                      <div id="randomUser" class="client-title">
                        <h3>{{ $randomUser->firstname }} {{ $randomUser->lastname }}</h3><span>{{ $randomUser->job_title }}</span>
                        <p>
                          @if($user->id != Auth::user()->id)
                               {!! Form::open(['route' => 'followers.store', 'id'=>'randomUserForm']) !!}
                                <div hidden>
                                {!! Form::number('uid', Auth::user()->id) !!}
                                {!! Form::number('who', $randomUser->id); !!}
                                </div>
                                 {!! Form::submit('Follow', ["class"=> 'btn btn-default btn-block']); !!}
                                {!! Form::close(); !!}
                           @endif
                        </p>
                      </div>
                      <div class="client-info">
                        <div class="row">
                          <div class="col-4"><strong>{{ $articles->getUserBlogsCount($randomUser->id) }}</strong><br><small>Articles</small></div>
                          <div class="col-4"><strong>{{ $friends->getfriendsCount($randomUser->id) }}</strong><br><small>Friends</small></div>
                          <div class="col-4"><strong>{{ $followers->getFollowers($randomUser->id) }}</strong><br><small>Followers</small></div>
                        </div>
                      </div>
                      <div class="client-social d-flex justify-content-between"><a href="#" target="_blank"><i class="fa fa-facebook"></i></a><a href="#" target="_blank"><i class="fa fa-twitter"></i></a><a href="#" target="_blank"><i class="fa fa-google-plus"></i></a><a href="#" target="_blank"><i class="fa fa-instagram"></i></a><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a></div>
                    </div>
                  </div>
                </div>
            <script>
              $(function () {
                $('#randomUserForm').on('submit', function (e) {
                  e.preventDefault();
                  $.ajax({
                    type: 'post',
                    url: '/followers',
                    data: $('#randomUserForm').serialize(),
                    success: function () {
                      $("#randomUser").load(location.href + " #randomUser");
                      $("body").load(location.href + "body");
                    }
                  });
                });
              });
            </script>

                <!-- Total Overdue   -->
                <div class="col-lg-4 well">
                  <div class="overdue card">
                    <div class="card-close">
                      <div class="dropdown">
                        <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a></div>
                      </div>
                    </div>
                    <div class="card-body">
                      <h3>Articles Worth</h3><small class="bg-green">Your balance</small>
                      <div class="number text-center ">$ {{ ( $myPostsViews * (0.0001 * $myPostsCount) ) }}</div>
                      <div class="chart">
                        <canvas id="lineChart1">                               </canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Feeds Section-->
          <section class="feeds no-padding-top col-md-12">
            <div class="container-fluid">
              <div class="row">
                <!-- Trending Articles-->
                <div class="col-lg-6">
                  <div class="articles card">
                    <div class="card-close">
                      <div class="dropdown">
                        <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a></div>
                      </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                      <h2 class="h3">Trending Articles   </h2>
                      <div class="badge badge-rounded bg-green"></div>
                    </div>

                    <!-- start trending from here -->
                    <div class="card-body no-padding">
                      @if($newArticles)
                      @foreach($newArticles->paginate(5, ['*'], 'articles') as $article)
                      <div class="item d-flex align-items-center">
                        <div class="image"><img src="/{{ $article->image }}" alt="{{ $user->find($article->uid)->firstname }} {{ $user->find($article->uid)->lastname }}" class="img-fluid rounded-circle"></div>
                        <div class="text"><a href="#">
                            <h3 class="h5">{{ $article->title }}</h3></a><small>{{ $article->created_at }} by {{ $user->find($article->uid)->firstname }} {{ $user->find($article->uid)->lastname }}.   </small></div>
                      </div>
                      @endforeach
                      <div class="well">{{ $newArticles->paginate(5, ['*'], 'articles')->links() }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <!-- Check List -->
                <div class="col-lg-6">
                  <div class="checklist card">
                    <div class="card-close">
                      <div class="dropdown">
                        <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="{{ route('my_to_do_list.create') }}" class="dropdown-item edit"> <i class="fa fa-gear"></i>Add New</a><a class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a></div>
                      </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                      <a href="{{ route('my_to_do_list.index') }}"><h2 class="h3">To Do List </h2></a>
                    </div>
                    <div class="card-body no-padding">
                   @if($toDoList)
                      @foreach($toDoList->paginate(5) as $todo)
                      <div class="item d-flex">
                        <input type="checkbox" id="input-6" name="input-6" class="checkbox-template">
                        <label for="input-6"> <a href="{{ route('my_to_do_list.show', $todo->id)}}">{{ $getInfo->encoded($todo->body, 0, 200, 'yes') }}</a></label>
                      </div>
                      @endforeach
                      <div class="well">{{ $toDoList->paginate(5)->links() }}</div>
                    @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>



              </div>
            </div>
          </section>
@endsection
