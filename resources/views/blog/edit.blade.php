@extends('layouts.profile')

@section('title')

Edit " {{ $post->title }} "

@stop
@section('styles')

@stop

@section('leftSideBar')
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
          @include('includes.profileBio')
          </div>
@stop

@section('content')
	 <div class="">
 <img src="/{{ $post->image }}" id="blog-loaded-image" style="width:100%;height: 300px;z-index: -10;opacity: 0.5; margin-bottom: -150px;">
</div>

<div class="container-fluid">
  <!-- Project-->
      
        {!! Form::open(array('route' => ['blog.update', $post->id], 'method' => 'put', 'files'=>'true')) !!}

  <div class="project">
    <div class="row bg-white has-shadow">
        <div class="well col-lg-12 row project-title d-flex align-items-center">
          <div class="text col-lg-12">

        <div class="btn-file pull-left well">
        {{ Form::label('image', 'Article Image:', ['class'=>'btn btn-default'])  }}{{ Form::file('image', ['onchange' => 'readURL(this);' ,"class" => 'btn btn-file', 'style'=> 'display: none;']) }}
          </div>
        <div class="right-col d-flex align-items-center col-md-4 pull-right">
                  {{ Form::submit('Save', ['class' => 'btn btn-success col-md-6']) }}
                    {!! Form::open(['route'=>['blog.show', $post->id], 'class'=>'col-md-2'])!!}
                    {!! Form::submit('Cancel', ["class"=> 'btn-danger btn col-md-6']); !!}
                    {!! Form::close(); !!}
          </div>
      
          <div hidden>
            {{ Form::number('uid', Auth::user()->id) }}
          </div>
          <div class="row col-lg-12 row project-title d-flex align-items-center">
          <div>
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title', $post->title, ["class" => 'form-control']) }}{{ Form::label('body', 'Body:') }}{{ Form::textarea('body', $post->body, ["class" => 'form-control ckeditor']) }}
          </div>

         <!-- tags and categories -->
        <div class="form-group">
           <div class="col-md-6 well">
      
        {{ Form::label('tags[]', strtoupper(str_replace('_', ' ', 'Tags: '))) }}
         
              {{ Form::select('tags[]', $tags ,$nTags, ['class'=>'form-control select2','id'=>'tags', 'multiple'=>'multiple']) }}
            </div>

           <div class="col-md-6 well">
        {{ Form::label('categories[]', strtoupper(str_replace('_', ' ', 'Categories: '))) }}
         {{ Form::select('categories[]', $categories ,$nCategories, ['class'=>'form-control select2', 'id'=>'categories', 'multiple'=>'multiple']) }}

           </div>
        </div>
            <div class="project-date left-col col-lg-8">
                  <div class="time">Author: {{ Auth::user($post->id)->username }}
                  <span class="hidden-sm-down">{{ $post->created_at }}</span>
            </div>
            </div>
            
        </div>
      </div>
     </div>
       
     </div>
<section class="well col-md-12 no-padding-top bg-white has-shadow">
            <div class="container-fluid">
              <div class="pull-right" >
                            <div><span  id="filesUploadedHere" hidden></span></div>
                               {{ Form::label('newfiles[]', 'Upload Files', ['class'=>'btn btn-success', 'style'=>'margin: 20px;border: 2px solid #000;cursor: pointer;']) }} 
                               {{ Form::text('number', null, ['hidden'=>1, 'id'=>'numberoffiles' ,'disabled'=>1, 'size'=>'3']) }}
                            <div hidden>
                              {{ Form::file('newfiles[]' ,['onchange' => 'readFiles(this);', 'class' => 'form-control', 'multiple'=>'true']) }}
                                  {{ Form::number('uid', Auth::user()->id ) }}
                            </div>
                    </div>
          </div>
        
      </section>
    </div>
   {!! Form::close() !!}
 </div>
  <section class="col-md-12 no-padding-top bg-white has-shadow">
            <div class="container-fluid">
               
         @if($files->count() > 0)
                  <div class="">
                  Files: {{ $files->count() }}
                  <br>
                    @foreach($files->get() as $file)
                        <a href="/{{ $file->file }}" id="todo-loaded-files" target="_blank" class="has-shadow well pull-left" style="margin: 20px;border: 2px solid #000;"><i class="fa">{{ Form::open(['route' => ['media.destroy', $file->id], 'method' => 'DELETE']) }}
                        {{ Form::submit('X', ['class'=>'fa btn-danger btn-xs']) }}
                        {{ Form::close() }}</i><img src="/{{ $file->file }}" id="todo-loaded-files-thumb" class="rounded mx-auto d-block" width="50" height="50" style="margin: 10px;"><br> {{ $file->ftype }}</a>
                    @endforeach
                @else
                
              
             @endif
           </div>
       </div>       
  </section>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blog-loaded-image')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

  function readFiles(input) {
        if (input.files && input.files[0]) {
            var count = 0;
            var reader = new FileReader();
           
              
            reader.onload = function (e) {
                
            for (var i = 0; i <= input.files.length; i++) {
              count++;
            }
            $('#filesUploadedHere').show("slow").html('<img src="'+e.target.result+'" style="width:30px;height:30px;" />...');
            $('#numberoffiles').val(count+ ' Files').show("slow");
            $('#uploaded-files').val('Files Added').show("slow");
            };
            
                reader.readAsDataURL(input.files[0]);            
        }
    }
</script>
@endsection



