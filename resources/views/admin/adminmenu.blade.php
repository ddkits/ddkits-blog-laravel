@inject('isAdmin', 'App\Http\Controllers\AdminCont')
@inject('msgsBar', 'App\Http\Controllers\MsgCont')




@inject('menuLinks', 'App\Http\Controllers\MenuCont')
<span class="heading">{{ $getInfo->getValue('sitename') }}</span>
<ul class="list-unstyled menuTree1">
@foreach( $menuLinks->adminMenu() as $menu )
    @if($menu->menuparent == null)
      <script>
      $(document).ready(function(){
           var delay=1000, setTimeoutConst;
              $("#show-{{ $menu->id }}").hover( function() {
                   setTimeoutConst = setTimeout(function(){
                          $("#menu-{{ $menu->id }}").show("slow");
                   }, delay);
              }, function(){
                $("#menu-{{ $menu->id }}").hide("slow");
                   clearTimeout(setTimeoutConst );

            });
         
      });
      </script>
      @if( ($getInfo->getAdmin(Auth::user()->id) == 1 AND $getInfo->getAdminLevel() == 0) || Auth::user()->id == 1)
        <li id="show-{{ $menu->id }}"> <a href="{{$menu->link}}" class="{{$menu->class}}"> <i class="{{$menu->iconclass}}"></i>{{$menu->name}}<i class="logDown fa pull-right">v</i></a>
        <ul id="menu-{{$menu->id}}" class="list-unstyled" style="display: none;">
          @foreach( $menuLinks->adminMenu() as $menu2 )
              @if( $menu->id == $menu2->menuparent )            
                  <li><a href="{{$menu2->link}}" class="{{$menu2->class}}"> <i class="{{$menu2->iconclass}}"></i>-{{$menu2->name}}</a>
                    <ul id="menu-{{$menu2->id}}" class="list-unstyled menuTree2">
                        @foreach( $menuLinks->adminMenu() as $menu3 )
                            @if( $menu2->id == $menu3->menuparent )            
                                <li><small><a href="{{$menu3->link}}" class="{{$menu3->class}}"> <i class="{{$menu3->iconclass}}"></i>--{{$menu3->name}}</a></small></li>
                            @endif
                        @endforeach
                        </ul>
                  </li>
              @endif
          @endforeach

          </ul>
        </li>
      @endif
   @endif
@endforeach
<li> <a href="http://ddkits.com/contact"> <i class="icon-mail"></i>Contact Us</a></li>
<li> <a href="http://ddkits.com/"> <i class="icon-screen"></i>Visit Us</a></li>
</ul>

