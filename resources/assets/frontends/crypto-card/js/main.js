$(function ($) {
  "use strict";

  jQuery(document).ready(function () {

    // Click To Scroll 
    $(".nav-link").click(function () {
      $(".nav-link").removeClass("active");
      $(this).addClass("active");
    }); 
    
    // Click To Scroll 
    $(".mein-menu .navbar-nav a").on("click", function (event) {
      var $anchor = $(this);
      $("html, body")
        .stop()
        .animate(
          {
            scrollTop: $($anchor.attr("href")).offset().top - 80,
          },
          100
        );
      event.preventDefault();
    });


    // /* niceSelect */
    $("select").niceSelect();

    // /* Wow js */
    new WOW().init();

    // /*back to top-*/
    $(document).on("click", "#scrollUp", function () {
      $("html,body").animate({
        scrollTop: 0,
      },
        100
      );
    });

    // /* sticky navigation menu */
    var lastScrollTop = "";
    $(window).on("scroll", function () {
      var $window = $(window);
      if ($window.scrollTop() > 0) {
        $(".mein-menu").addClass("nav-fixed");
      } else {
        $(".mein-menu").removeClass("nav-fixed");
      }

      /*---------------------------
         back to top show / hide
     ---------------------------*/
      var st = $(this).scrollTop();
      if ($(window).scrollTop() > 500) {
        $("#scrollUp").fadeIn();
      } else {
        $("#scrollUp").fadeOut();
      }
      lastScrollTop = st;
    });

  });

  $(window).on("load", function () {
    /*Preloader*/
    $('.preloader').fadeOut(1000);
    var img = $('.bg_img');
    img.css('background-image', function () {
      var bg = ('url(' + $(this).data('background') + ')');
      return bg;
    });
  });
});



