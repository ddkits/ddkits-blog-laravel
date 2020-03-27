@inject('feedsCont', 'App\Http\Controllers\feedsCont')
@inject('feeds','App\Http\Controllers\FeedsCont')

{{-- Related Feeds --}}
@php
    $last_id = 0;
    $last_date = 0;
    $sli = ($splice)?? 0;
@endphp
<!-- show all after last row  -->
@foreach ($feedsCont->getFeedsHomeNews('all')->paginate($howMany)->splice($sli) as $post)
@php
    $last_id = $post->id;
    $last_date = $post->created_at;
@endphp
<a href="{{ route('feeds.showPage', $post->path) }}" class="black fondo-ddkits-home  col-md-6" data-id="{{ $last_id }}" >
<div class="ddkits-blog-content-home col-md-11 col-sx-11" >
<div class="img-ddkits-principal-home">
        <img class="ddkits" src="/{{ $post->image }}" style="background-position: absolute;background-attachment: fixed;background-size: 100% 100%;"  alt="{{$post->title}}">
</div>
<div class="whytopost-ddkits-principal-home">
<div>{{ $getInfo->encoded($post->title, 0, 50, 'yes') }} <div class="small">{{ date('M/d/Y', strtotime($post->created_at)) }}</div> </div>
<div class="author col-md-2 col-xs-2">
</div>
</div>
</div>
</a>

@endforeach
<div id="post_data"></div>
@if ($showMore == 1)
<div id="load_more" class="align-text-center align-items-center col-md-12">
<button type="button" name="load_more_button" class="btn form-control" data-id="{{ $last_id }}"  data-source="{{ $source }}" data-date="{{ $last_date }}" id="load_more_button">Load More News</button>
</div>
@endif
<script>
$(document).ready(function(){

    var _token = $('input[name="_token"]').val();
    function load_data(id="", source=false, date=false, _token)
    {
        if(!source){
            source =false;
        }
        if(!date){
            date =false;
        }
    $.ajax({
    url:"/feeds-load-more",
    method:"GET",
    data:{id:id, source:source, date:date, _token:_token},
    success:function(data)
    {
    $('#load_more_button').remove();
    $('#post_data').append(data);
    },error: function(req, err){ console.log('my message' + err); }
    })
}

    $(document).on('click', '#load_more_button', function(){
        var id = $(this).data('id');
        var source = $(this).data('source');
        var date = $(this).attr('data-date');

        if(id == '0'){
            $('#load_more_button').remove();
        }else{
            var before = $('#load_more_button').html();
            $('#load_more_button').html('<b>Loading...</b>');
            load_data(id, source, date, _token);
        }

    });

});
</script>
