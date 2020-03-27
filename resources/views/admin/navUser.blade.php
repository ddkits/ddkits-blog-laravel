@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('isAdmin', 'App\Http\Controllers\AdminCont')
@inject('msgsBar', 'App\Http\Controllers\MsgCont')
<!-- {{ $isAdmin->getValue('sitename') }} -->

<div class="container-fluid">
                        <div class="navbar-header">
                            
                            <a class="navbar-brand" href="/">{{ $isAdmin->getValue('sitename') }} </a>
                            <i class="brand_network"><small><small>Powered By DDKits</small></small></i>
                        </div>
                        <div class="navbar-collapse collapse">
                             <ul class="nav navbar-nav">
                             <li><a href="{{ route('profile.show', Auth::user()->id) }}" ><i class="icon-home"></i> My Profile</a>
                            @foreach( $menuLinks->mainMenu() as $menu )
                                @if($menu->menuparent == null)
                                <li> <a href="{{$menu->link}}" class="{{$menu->class}}"> <i class="{{$menu->iconclass}}"></i> {{$menu->name}}</a>
                                    <!-- <ul id="menu-{{$menu->id}}" class="list-unstyled">
                                    @foreach( $menuLinks->mainMenu() as $menu2 )
                                        @if( $menu->id == $menu2->menuparent )
                                            <li><a href="{{$menu2->link}}" class="{{$menu->class}}"> <i class="{{$menu->iconclass}}"></i>{{$menu2->name}}</a></li>
                                         @endif
                                    @endforeach
                                     </ul> -->
                                </li>
                                  @endif
                            @endforeach
                                        
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <!-- <li><span class="badge badge-important"></span><a href="#"><i class="fa fa-bell-o fa-lg" aria-hidden="true"></i></a></li> -->
                                        <li><a href="/messages"><i class="fa fa-envelope-o fa-lg" aria-hidden="true">{{ $msgsBar->newMsgs()->count() }}</i></a></li>
                                <li class="dropdown" drop-id="main-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                        <img src="/{{ $profile->getProfInfo(Auth::user()->id)->picture }}" class="img-responsive img-circle" title="{{ Auth::user()->firstname  }} {{ Auth::user()->lastname  }}" alt="{{ Auth::user()->firstname  }} {{ Auth::user()->lastname  }}" width="30px" height="30px">
                                    </span>
                                    <span class="user-name">
                                        {{ Auth::user()->firstname }} {{ Auth::user()->lastname  }}
                                    </span>
                                    <b class="caret"></b></a>
                                    <ul class="dropdown-menu main-menu" hidden>
                                        <li>
                                            <div class="navbar-content">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <img src="/{{ $profile->getProfInfo(Auth::user()->id)->picture }}" alt="{{ Auth::user()->firstname  }} {{ Auth::user()->lastname  }}" class="img-responsive" width="120px" height="120px" />
                                                        
                                                    </div>
                                                    <div class="col-md-7">
                                                        <span> {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} </span>
                                                        <p class="text-muted small">
                                                            {{ Auth::user()->email }}</p>
                                                        <div class="divider">
                                                        </div>
                                                        <!-- <a href="/profile/{{ $profile->getProfInfo(Auth::user()->id)->id }}/edit" class="btn btn-default btn-xs"><i class="fa fa-user-o" aria-hidden="true"></i>Edit Profile</a> -->
                                                        <a href="/friends" class="btn btn-default btn-xs"><i class="fa fa-address-card-o" aria-hidden="true"></i> Friends</a>
                                                        <a href="/profile/{{ $profile->getProfInfo(Auth::user()->id)->id }}/edit" class="btn btn-default btn-xs"><i class="fa fa-cogs" aria-hidden="true"></i> Settings</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="navbar-footer">
                                                <div class="navbar-footer-content">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <a href="/profile/{{ $profile->getProfInfo(Auth::user()->id)->id }}/edit#password" class="btn btn-default btn-sm"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Passowrd</a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="{{ route('logout') }}" class="btn btn-default btn-sm pull-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off" aria-hidden="true"></i> Sign Out</a>

                                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $('.dropdown').click(function(){
                            var number = $(this).attr( "drop-id" );
                            $('.dropdown .dropdown-menu.'+number+'').toggle("slow");
                        });
                    </script>