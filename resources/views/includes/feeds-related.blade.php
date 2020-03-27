@inject('feedsCont', 'App\Http\Controllers\feedsCont')
@inject('feeds','App\Http\Controllers\FeedsCont')

{{-- Related Feeds --}}
@php
    $last_id = 0;
    $sli = ($splice)?? 0;
@endphp
<!-- show all after last row  -->
@foreach ($feedsCont->getSourceNews($source, $random)->paginate($howMany)->splice($sli) as $post)
@php
    $last_id = $post->id;
@endphp
<a href="{{ route('feeds.showPage', $post->path) }}" class="black fondo-ddkits-home  col-md-6" data-id="{{ $last_id }}" >
<div class="ddkits-blog-content-home col-md-11 col-sx-11" >
<div class="img-ddkits-principal-home col-sx-4 col-md-2 ">
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
<button type="button" name="load_more_button" class="btn form-control" data-id="{{ $last_id }}"  source="{{ $source }}" id="load_more_button">Load More News</button>
</div>
@endif
<script>
$(document).ready(function(){

    var _token = $('input[name="_token"]').val();
    function load_data(id="", soce=false, _token)
    {
    $.ajax({
    url:"{{ route('feeds.LoadMore') }}",
    method:"GET",
    data:{id:id, source:soce, _token:_token},
    success:function(data)
    {
    $('#load_more_button').remove();
    $('#post_data').append(data);
    }
    })
}

    $(document).on('click', '#load_more_button', function(){
        var id = $(this).attr('data-id');
        var source = $(this).attr('source');
        if(id == '0'){
            $('#load_more_button').remove();
        }else{
            var before = $('#load_more_button').html();
            $('#load_more_button').html('<b>Loading...</b>');
            load_data(id, source, _token);
        }

    });

});
</script>
