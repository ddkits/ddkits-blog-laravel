@extends('layouts.profile')

@section('meta')
<meta name="title" content="Creat New Article">
@stop

@section('title')

<h2>Creat New Article</h2>

@stop

@section('leftSideBar')
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
          @include('includes.profileBio')
          </div>
@stop
@section('styles')

@stop

@section('content')
  <div class="">
 <img src="" id="blog-loaded-image" style="width:100%;height: 300px;z-index: -10;opacity: 0.5; margin-bottom: -150px;">
</div>

	<div class="media">
		
	
	
    {!! Form::open(array('route' => 'blog.store', 'files'=>'true')) !!}
    <div class="col-md-12 ">
      <div class="btn-file pull-left well">
        {{ Form::label('image', 'Article Image:', ['class'=>'btn btn-default'])  }}{{ Form::file('image', ['onchange' => 'readURL(this);' ,"class" => 'btn btn-file', 'style'=> 'display: none;']) }}
          </div>
          <div hidden>
            {{ Form::number('uid', Auth::user()->id) }}
          </div>
       <div class="pull-right well">
               
           {{ Form::submit('Create Post', ['class' => 'btn btn-success']) }}
            <a href="{{ route('blog.index') }}" class="btn btn-danger">Cancel</a>
        </div>
      <div class="form-group well">
          {{ Form::label('title', 'Title:', ['class'=>'col-md-12']) }}{{ Form::text('title', null, array('class' => 'form-control', 'required' => 'true')) }}
        
      </div>
       <div class="well">
            {{ Form::textarea('body', null, array('class' => 'form-control ckeditor', 'required' => 'required')) }}
        </div> 

        <!-- tags and categories -->
        <div class="form-group">
           <div class="col-md-6 well">
      
        {{ Form::label('tags[]', strtoupper(str_replace('_', ' ', 'Tags: '))) }}
         
              {{ Form::select('tags[]', $tags ,[], ['class'=>'form-control select2','id'=>'tags', 'multiple'=>'multiple']) }}
            </div>

           <div class="col-md-6 well">
        {{ Form::label('categories[]', strtoupper(str_replace('_', ' ', 'Categories: '))) }}
         {{ Form::select('categories[]', $categories ,[], ['class'=>'form-control select2', 'id'=>'categories', 'multiple'=>'multiple']) }}

           </div>
        </div>
        
        <div class="left-col align-items-center justify-content-between">
            <div class="time">Author: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
        </div>

    </div>

  <section class="well col-md-12 no-padding-top bg-white has-shadow">
            <div class="container-fluid">
              <div class="pull-right" >
                            <div><span  id="filesUploadedHere" hidden></span></div>
                               {{ Form::label('files[]', 'Upload Files', ['class'=>'btn btn-success', 'style'=>'margin: 20px;border: 2px solid #000;cursor: pointer;']) }} 
                               {{ Form::text('number', null, ['hidden'=>1, 'id'=>'numberoffiles' ,'disabled'=>1, 'size'=>'3']) }}
                            <div hidden>
                              {{ Form::file('files[]' ,['onchange' => 'readFiles(this);', 'class' => 'form-control', 'multiple'=>'true']) }}
                                  {{ Form::number('uid', Auth::user()->id ) }}
                            </div>
                    </div>
          </div>
        </section>
        {!! Form::close() !!}
       
    
		
  
</div>

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
@stop