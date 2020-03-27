@inject('profile', 'App\Http\Controllers\ProfileCont')
@inject('posts', 'App\Http\Controllers\PostCont')
@inject('proPosts', 'App\Http\Controllers\ProPostCont')

@if($user->id == Auth::user()->id)

<div class="panel panel-default">
      <div class="panel-body">
                    {!! Form::open(['action' => 'ProPostCont@store', 'id'=>'proPostForm']) !!}
                    {{ Form::number('uid', Auth::user()->id, ['hidden'=>'']) }} 
                    {{ Form::number('profileID', $profile->getProfInfo(Auth::user()->id)->id, ['hidden'=>'']) }} 
                    <br>
                    {{ Form::textarea('body', null, array('class' => 'form-control col-md-10', 'required' => '', 'rows'=>'4')) }}
                    
                     <span>
                      
                        <div class="dropdown pull-right col-md-2">
                           {{ Form::submit('Share', ['class' => 'btn  btn-default btn-block']) }}
                        </div>
                    </span>
                    <br><hr>
                    <span class="pull-left">
                        <a class="btn btn-link" style="text-decoration:none;"><i class="fa fa-fw fa-files-o" aria-hidden="true"></i> Posts <span class="badge">{{ $proPosts->getUserProPostsCount(Auth::user()->id) }}</span></a>
                        <a href="/blog" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-fw icon-screen" aria-hidden="true"></i> Blogs <span class="badge">{{ $posts->getUserBlogsCount(Auth::user()->id) }}</span></a>
                    </span>
                    <span class="pull-right">
                        <!-- <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-at" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Mention"></i></a>
                        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-envelope-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Message"></i></a>
                        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-lg fa-ban" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Ignore"></i></a> -->
                        {{ Form::select('public', ['1'=>'public', '2'=>'private'], ['1'], array('class' => 'form-control', 'required' => '')) }} 
                    </span>
  {!! Form::close() !!}
  </div>
</div>
@else

@endif