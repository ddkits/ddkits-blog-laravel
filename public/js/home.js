$(document).ready(function($) {
    "use strict"; // Start of use strict

    // Floating label headings for the contact form
    $("body")
        .on("input propertychange", ".floating-label-form-group", function(e) {
            $(this).toggleClass(
                "floating-label-form-group-with-value",
                !!$(e.target).val()
            );
        })
        .on("focus", ".floating-label-form-group", function() {
            $(this).addClass("floating-label-form-group-with-focus");
        })
        .on("blur", ".floating-label-form-group", function() {
            $(this).removeClass("floating-label-form-group-with-focus");
        });

    // Show the navbar when the page is scrolled up
    var MQL = 1170;

    //primary navigation slide-in effect
    if ($(window).width() > MQL) {
        var headerHeight = $("#mainNav").height();
        $(window).on(
            "scroll",
            {
                previousTop: 0
            },
            function() {
                var currentTop = $(window).scrollTop();
                //check if user is scrolling up
                if (currentTop < this.previousTop) {
                    //if scrolling up...
                    if (currentTop > 0 && $("#mainNav").hasClass("is-fixed")) {
                        $("#mainNav").addClass("is-visible");
                    } else {
                        $("#mainNav").removeClass("is-visible is-fixed");
                    }
                } else if (currentTop > this.previousTop) {
                    //if scrolling down...
                    $("#mainNav").removeClass("is-visible");
                    if (
                        currentTop > headerHeight &&
                        !$("#mainNav").hasClass("is-fixed")
                    )
                        $("#mainNav").addClass("is-fixed");
                }
                this.previousTop = currentTop;
            }
        );
    }
    // ------------------------------------------------------- //
    // Search Box
    // ------------------------------------------------------ //
    $("#search").on("click", function(e) {
        e.preventDefault();
        $(".search-box").fadeIn();
    });
    $(".dismiss").on("click", function() {
        $(".search-box").fadeOut();
    });

    // homepage highlights
    // $('a').on('click', function() {
    //       var url = $(this).attr("href");

    //       jQuery.ajax({
    //           url: url,
    //           type: 'GET',
    //           data: $('#highlights-load').serialize(),
    //           success: function(data) {
    //               $("#highlights-load").load(location.href + " #highlights-load");
    //           }

    //       });
    //       return false;
    //   });
});

(function($) {
    $("a#closevideo").click(function(e) {
        e.preventDefault();
        $("#video-view iframe").remove();
        $("#video-view").hide();
    });
})(jQuery);

function showVideo(linkIs) {
    var $iframe = $("<iframe>")
        .attr("src", linkIs)
        .attr("style", "width:100%;height:400px");
    $("#video-view")
        .append($iframe)
        .show();
    $iframe.wrap("<div class='class-video'>");
}

function closeVideo() {
    $("#video-view iframe").remove();
    $("#video-view").hide();
}

$(document).scroll(function(e) {
    //bind scroll event
    e.preventDefault();

    var intBottomMargin = 500; //Pixels from bottom when script should trigger

    //if less than intBottomMargin px from bottom
    if (
        $(window).scrollTop() >=
        $(document).height() - $(window).height() - intBottomMargin
    ) {
        $("a#load_more_button").click(); //trigger click
    }
});
