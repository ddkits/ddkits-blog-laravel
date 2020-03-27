@inject('profile', 'App\Http\Controllers\ProfileCont')

<!-- Sidebar Header-->
<div class="sidebar-header d-flex align-items-center">
  <div class="avatar"><a href="{{ route('profile.show', $profile->getProfInfo(Auth::user()->id)->id) }}">

  <img src="/{{ $profile->getProfInfo(Auth::user()->id)->picture }}" alt="{{ Auth::user()->lastname }}" class="img-fluid rounded-circle"></div>
  <div class="title">
  @if( Auth::user()->firstname )
    <h1 class="h4">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h1>
    </a>
    <p>{{ Auth::user()->job_title }}</p>
  @else
    <h1 class="h4">{{ Auth::user()->username }}</h1>
    <p>{{ Auth::user()->job_title }}</p>
  @endif
  </div>
</div>