@if (Session::has('Success'))

<div class="alert alert-info alert-dismissable">
  <strong>Success: </strong> {{ Session::get('Success') }}
</div>

@endif


@if (Count($errors) > 0)

<div class="alert alert-danger" role="alert">
  <strong>Something wrong: </strong> <ul>
  @foreach ($errors->all() as $error)
  	<li>{{ $error }}</li>
  @endforeach
  </ul>
</div>

@endif

