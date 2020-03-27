@inject('menuLinks', 'App\Http\Controllers\MenuCont')
@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('isAdmin', 'App\Http\Controllers\AdminCont')
<!-- {{ $isAdmin->getValue('sitename') }} -->

<div class="container-fluid">
                        <div class="navbar-header">
                            
                            <a class="navbar-brand" href="/">{{ $isAdmin->getValue('sitename') }}</a>
                            <i class="brand_network"><small><small>Powered By DDKits</small></small></i>
                        </div>
                        <div class="navbar-collapse collapse">
                             <ul class="nav navbar-nav">
                            @foreach( $menuLinks->mainMenu() as $menu )
                                @if($menu->menuparent == null)
                                <li> <a href="{{$menu->link}}" class="{{$menu->class}}"> <i class="{{$menu->iconclass}}"></i>{{$menu->name}}</a>
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
                                        <li><span class="badge badge-important">0</span><a href="/dashboard"><i class="fa fa-bell-o fa-lg" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i></a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li ><a href="/register" class="btn"> Sign Up </a>
                                </li>
                            </ul>
                        </div>
                    </div>