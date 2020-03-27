@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('menuLinks', 'App\Http\Controllers\MenuCont')

<script>
        $(document).ready(function(){
           var delay=1000, setTimeoutConst;
              $("#show-profile").hover( function() {
                   setTimeoutConst = setTimeout(function(){
                          $("#menu-profile").show("slow");
                   }, delay);
              }, function(){
                $("#menu-profile").hide("slow");
                   clearTimeout(setTimeoutConst );

            });
         
      });
      </script>
<ul class="list-unstyled">
<li id="show-profile"><a href="{{ route('profile.show', Auth::user()->id) }}" ><i class="icon-home"></i>My Profile<i class="logDown fa pull-right">v</i></a>
  <ul id="menu-profile" class="list-unstyled menuTree2" style="display: none;">
    <li><a href="/profile/{{ $profile->getProfInfo(Auth::user()->id)->id }}/edit"> <i class="icon-settings"></i>Edit Profile</a>
    </li>
  </ul>
</li>
@foreach( $menuLinks->mainMenu() as $menu )
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
      <li id="show-{{ $menu->id }}"> <a  href="{{$menu->link}}" class="{{$menu->class}}"> <i class="{{$menu->iconclass}}"></i>{{$menu->name}}<i class="logDown fa pull-right">v</i></a>
      <ul id="menu-{{$menu->id}}" class="list-unstyled" style="display: none;">
        @foreach( $menuLinks->mainMenu() as $menu2 )
            @if( $menu->id == $menu2->menuparent )            
                <li><a href="{{$menu2->link}}" class="{{$menu2->class}}"> <i class="{{$menu2->iconclass}}"></i>-{{$menu2->name}}</a>
                  <ul id="menu-{{$menu2->id}}" class="list-unstyled menuTree2">
                      @foreach( $menuLinks->mainMenu() as $menu3 )
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
@endforeach

</ul>