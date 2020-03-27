@if ($getInfo->homeMainMenu()->count() > 0)
    @foreach ( $getInfo->homeMainMenu()->get() as $key)
    <li class="nav-item d-flex align-items-center" id="{{ $key->class }}">
        <a href="{{ $key->link }}" id="{{ $key->class }}">
            <i class="{{ $key->iconclass }}"></i>{{ $key->name }}</a>
        </li>
    @endforeach
@endif
