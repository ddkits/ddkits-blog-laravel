
(function () {
  $('[data-toggle="tooltip"]').tooltip()
  $('[data-toggle="popover"]').popover()
  

});

// start fade out in one second, take 300ms to fade
setTimeout( function(){
	$('.alert').hide("slow");
} , 4000);

$(document).ready(function($) {
	$("#tags").select2({
	      tags: true
	  });

	$("#categories").select2({
	      tags: true
	  });
	//  opend the edit for each post
	$("i#postedit").on( "click", function(){
		var postid = $(this).attr("post");
		$("#postedit-"+postid).toggle("slow");
	});


	$('a#likesForm').on('click', function() {
        var nid = $(this).attr("nid");
        var type = $(this).attr("type");
        var uid = $(this).attr("uid");

        jQuery.ajax({
            url: '/add-like?nid='+nid+'&uid='+uid+'&type='+type,
            type: 'GET',
            data: $('a#likesForm').serialize(),
            success: function(data) {
                $("#likes-"+nid).load(location.href + " #likes-"+nid);
                
            }

        });
        return false;
    });
});
