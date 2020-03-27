@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('posts', 'App\Http\Controllers\PostCont')
@inject('proPosts', 'App\Http\Controllers\ProPostCont')

      <div class="panel-body ">
        <a href="{{ route('blog.create') }}" class="btn btn-default btn-block btn-xs"><h2>Create New Article</h2></a>
      </div>
