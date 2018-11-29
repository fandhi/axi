jQuery(document).ready(function($) {
   //initialise Stellar.js only desktop n tablet
   var viewPortWidth = $(window).width();
   if (viewPortWidth > 750)
      {$(window).stellar();}
   else {    }
   // Click menu go to section that you want it
   //Cache some variables
    var links = $('.nav').find('li');
    slide = $('.data_slide');
    mywindow = $(window);
    htmlbody = $('html,body');
   function goToByScroll(dataslide) {
        htmlbody.animate({
            scrollTop: $('.data_slide[data-slide="' + dataslide + '"]').offset().top
        }, 2000, 'easeInOutQuint');
    }
    //Setup waypoints plugin
    slide.waypoint(function (event, direction) {
       dataslide = $(this).attr('data-slide');
       if (direction === 'down') {
            $('.nav li[data-slide="' + dataslide + '"]').addClass('active').prev().removeClass('active');
        }
        else {
            $('.nav li[data-slide="' + dataslide + '"]').addClass('active').next().removeClass('active');
        }
    });
    
    mywindow.scroll(function () {
        if (mywindow.scrollTop() === 0) {
            $('.nav li[data-slide="1"]').addClass('active');
            $('.nav li[data-slide="3"]').removeClass('active');
        }
    });
    
    function goToByScroll(dataslide) {
        htmlbody.animate({
            scrollTop: $('.data_slide[data-slide="' + dataslide + '"]').offset().top
        }, 2000, 'easeInOutQuint');
    }
    
    //When the user clicks on the navigation links, get the data-slide attribute value of the link and pass that variable to the goToByScroll function
    links.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });
    
    //
   $(window).scroll(function() {
      if ($(this).scrollTop() >= 100) {
//         if (!$("#header").hasClass('bg_white')) {
            TweenMax.to($(".container"), 0.01, {
               css: {'height': "50px"},
               onComplete: function() {
                  $(".navbar-fixed-top").addClass('bg_white');
                  $(".logo_a").fadeOut(10);
                  $(".logo_b").fadeIn();
               },
               ease: Cubic.easeIn
            });
            TweenMax.to($(".navbar-fixed-top"), 0.2, {"backgroundColor": "rgba(255,255,255,0.9)"});
            TweenMax.to($(".navbar .brand"), 0.3, {"paddingTop": "0", "paddingBottom": 0});
            TweenMax.to($(".navbar .nav"), 0.3,{marginTop: 18});
//         }
      }
      else if ($(this).scrollTop() <= 20) {
//         if ($("header .navbar-fixed-top").hasClass('bg_white')) {
            if (!TweenMax.isTweening($(".navbar-fixed-top"))) {
               TweenMax.to($(".container"), 0.01, {
                  css: {'height': "138px"},
                  ease: Cubic.easeOut,
                  onComplete: function() {
                     $(".navbar-fixed-top").removeClass("bg_white");
                     $(".logo_a").fadeIn();
                     $(".logo_b").fadeOut(5);
                  }
               });
               TweenMax.to($(".navbar-fixed-top"),1.2,{"backgroundColor": "rgba(255,255,255,0)"});
               TweenMax.to($(".navbar .brand"),0.3,{"paddingTop": "10","paddingBottom": 20});
               TweenMax.to($(".navbar .nav"), 0.3,{marginTop: 35});
            }
//         }
      }
   });
   //SLIDE KONTENT
   $('.axi_caption').cycle({ 
			fx:     'fade',
			speed:  1500,
			timeout: 4000,
			prev:   '#back',
			next:   '#forward',
			pause:  1,
			pager:  '#pager'
		});
   //UNTUK MAP
   function initialize() {
      var myLatlng = new google.maps.LatLng(-6.233128, 106.8653664);
      var mapOptions = {
         zoom: 15,
         scrollwheel: false,
         center: myLatlng
      }
      var map = new google.maps.Map(document.getElementById('axiMap'), mapOptions);

      var marker = new google.maps.Marker({
         position: myLatlng,
         map: map,
         title: 'Place'
      });
   }

   google.maps.event.addDomListener(window, 'load', initialize);

   //POP UP
   $(".fancybox").fancybox({
      transitionIn: 'fade',
      transitionOut: 'fade',
      scrolling: 'no',
      afterShow: function() {
         $('.scroll-pane').jScrollPane();//SCROLL CUSTOM
      }
   });

   //SLIDER, CAROUSEL
   $('#basicCarousel').owlCarousel({
      navigation: true,
      pagination: false,
      items: 3, //10 items above 1000px browser width
      itemsDesktop: [1000, 3], //5 items between 1000px and 901px
      itemsDesktopSmall: [900, 2], // betweem 900px and 711px
      itemsTablet: [710, 1], //2 items between 710 and 0;
      itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
   });

//SMOOTH MOUSE SCROLLING
jQuery.extend(jQuery.easing, {
      easeOutQuint: function(x, t, b, c, d) {
         return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
      }
   });

   var wheel = false,
           $docH = $(document).height() - $(window).height(),
           $scrollTop = $(window).scrollTop();

   $(window).bind("scroll", function() {
      if (wheel === false) {
         $scrollTop = $(this).scrollTop();
      }
   });
   $(document).bind("DOMMouseScroll mousewheel", function(e, delta) {
      delta = delta || -e.originalEvent.detail / 3 || e.originalEvent.wheelDelta / 120;
      wheel = true;

      $scrollTop = Math.min($docH, Math.max(0, parseInt($scrollTop - delta * 100)));
      $($.browser.webkit ? "body" : "html").stop().animate({scrollTop: $scrollTop + "px"},
      2000, "easeOutQuint", function() {
         wheel = false;
      });
      return false;
   });
});

