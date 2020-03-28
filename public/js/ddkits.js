$(document).ready(function($) {
    "use strict";
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
    var MQL = 400;

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
                    if (
                        currentTop > headerHeight &&
                        !$("#mainNav").hasClass("is-fixed")
                    )
                        $("#mainNav").addClass("is-visible is-fixed");
                }
                this.previousTop = currentTop;
            }
        );
    }

    // $('#mainNav').hover(
    //      function(){ $(".masthead").addClass('blur') },
    //      function(){ $(".masthead").removeClass('blur') }
    //   );
});

$(document).ready(function($) {
    var i = 0;
    var txt = $("#mainTitle").attr("title");
    var speed = 50;
    typeWriter();

    function typeWriter() {
        if (txt && i < txt.length) {
            document.getElementById("mainTitle").innerHTML += txt.charAt(i);
            i++;
            setTimeout(typeWriter, speed);
        }
    }
});

(function($) {
    $("a.popup").click(function(e) {
        e.preventDefault();
        var $this = $(this);
        var $iframe = $("<iframe>")
            .attr("src", $this.data("link"))
            .attr("style", "width:100%;height:400px");
        var $title = $("<h1>").text($this.data("title"));
        $("#video-view")
            .append($iframe)
            .show();
        $iframe.wrap("<div class='class-video'>");
    });
    $("a#closevideo").click(function(e) {
        e.preventDefault();
        $("#video-view iframe").remove();
        $("#video-view").hide();
    });
})(jQuery);
