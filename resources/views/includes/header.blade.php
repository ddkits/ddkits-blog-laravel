@inject('msgsBar', 'App\Http\Controllers\MsgCont')
@inject('Followers', 'App\Followers')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('user', 'Illuminate\Foundation\Auth\User')


<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Search-->
                <div class="search-box">
                    <button class="dismiss"><i class="icon-close"></i>x</button>
                    {{ Form::open(['method'=>'GET','url'=>'search', 'id'=>'searchForm', 'role'=>'search']) }}
                    {{ Form::text('search', '', ['class'=>'form-control', 'placeholder'=>'What are you looking for...'] ) }}
                    {{ Form::close() }}

                  </div>

                <li class="nav-item d-flex align-items-center"><a id="search"><i class="icon-search"></i></a></li>
                <!-- Notifications-->
                @include('includes.homemainmenu')
                <li class="nav-item dropdown"> <a id="notifications" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell-o"></i></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a href="#" class="dropdown-item">
                        <div class="notification">
                          <div class="notification-content"><i class="fa fa-envelope bg-green"></i>You have {{ $msgsBar->newMsgs()->count() }} new messages </div>
                          <div class="notification-time"><small></small></div>
                        </div></a></li>
                    <li><a href="#" class="dropdown-item">
                        <div class="notification">
                          <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have {{ $Followers->where('who', Auth::user()->id)->count() }} followers</div>
                        </div></a></li>
                    <li><a href="/dashboard" class="dropdown-item all-notifications text-center"> <strong>View your dashboard  </strong></a></li>
                  </ul>
                </li>
                <!-- Messages-->
                <li class="nav-item dropdown"> <a id="messages" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope-o"></i><span class="badge bg-orange">{{ $msgsBar->newMsgs()->count() }}</span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    @if($msgsBar->newMsgs()->count() >= 1)

                      @foreach($msgsBar->newMsgs()->where('original', 0)->orwhere('original', null)->orderby('id', 'desc')->paginate(5) as $newMsg )
                        <li><a href="/messages/{{ $newMsg->id }}" class="dropdown-item d-flex">
                            <div class="msg-profile"> <img src="/{{ $profile->getProfInfo($newMsg->from)->picture }}" alt="{{ $user->find($newMsg->from)->firstname }} {{ $user->find($newMsg->from)->lastname }}" class="img-fluid rounded-circle"></div>
                            <div class="msg-body">
                              <h3 class="h5">{{ $user->find($newMsg->from)->firstname }} {{ $user->find($newMsg->from)->lastname }}</h3><span>Sent You Message. <div class="pull-right">
                                <span class="badge">{{ $msgsBar->getReplies($newMsg->id)->count() }} replies</span></div>
                            </div></a></li>
                      @endforeach

                      <li><a href="/messages" class="dropdown-item all-notifications text-center"> <strong>Read all messages </strong></a></li>
                    @endif
                  </ul>
                </li>
                <!-- Logout    -->
                <li class="nav-item"><a class="nav-link logout" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout<i class="fa fa-sign-out"></i></a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form></li>

              </ul>



