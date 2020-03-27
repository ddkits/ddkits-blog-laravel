$(document).ready(function () {

    'use strict';

function showddkitsPopup() {
    $("#ddkitsPopup").dialog({
        autoOpen: true,
        resizable: false,
        height: 'auto',
        width: 'auto',
        modal: true,
        //show: { effect: "puff", duration: 300 }, 
        draggable: true
    });

    $(".ui-widget-header").css({"display":"none"}); 
}

function closeddkitsPopup() { $("#ddkitsPopup").dialog('close'); }

/* Submit Resources Popup */

function submitResources(id){   

    $("#ddkitsPopup").dialog('open');

    $.ajax({
        url:'ddkits_page.php',
        data:'act=loadResourcesFrm&id='+id,
        type:'POST',
        error:function(){},
        success:function(data){ 
            $('#ddkitsPopup').html(data); 
            showddkitsPopup();
        }
    });
}

// ------------------------------------------------------- //
    // Search Box
    // ------------------------------------------------------ //
    $('#search').on('click', function (e) {
        e.preventDefault();
        $('.search-box').fadeIn();
    });
    $('.dismiss').on('click', function () {
        $('.search-box').fadeOut();
    });
    
});

var delay = (function(){
              var timer = 0;
              return function(callback, ms){
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                  };
            })();