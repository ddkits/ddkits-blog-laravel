@if( !empty(Auth::user() ))
<div class="main-menu">
  @include('admin.navUser')
</div>
@else
<div class="admin-menu">
  @include('admin.navGuest')
</div>
@endif