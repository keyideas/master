$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
  fade: true,
  asNavFor: '.slider-nav'
});

$('.slider-nav').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: false,
  prevArrow: '<button class="slide-arrow prev-arrow"></button>',
  nextArrow: '<button class="slide-arrow next-arrow"></button>',
  focusOnSelect: true,
  verticalSwiping:true,
});
/*
$(window).scroll(function() {    
  var scroll = $(window).scrollTop();

  if (scroll >= 100) {
      $(".header-section").addClass("fixedHeader");
  } else {
      $(".header-section").removeClass("fixedHeader");
  }
});
*/
/*
$('.best-seller-slider').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  arrow: false,
  responsive: [
    {
      breakpoint: 1023,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      },
      breakpoint: 991,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      },
      breakpoint: 768,
        settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    }
  ]
});

$('.shop-by-style-slider').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  arrow: false,
  initialSlide: 3,
  responsive: [
    {
       breakpoint: 767,
       settings: "unslick"
    },
  ]
});
*/
/*
$('.slider').on('initialized.owl.carousel changed.owl.carousel', function(e) {
  if (!e.namespace)  {
  return;
  }
  var carousel = e.relatedTarget;
  $('.slider-counter').text(carousel.relative(carousel.current()) + 1 + '/' + carousel.items().length);
}).owlCarousel({
    items: 1,
    loop:true,
    margin:0,
    nav:true,
    dots: false,
    navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
});
*/
/*
$( function() {
  $( "#slider-range" ).slider({
    range: true,
    min: 0,
    max: 500,
    values: [ 75, 300 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range" ).slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range1" ).slider({
    range: true,
    min: 0,
    max: 500,
    values: [ 75, 300 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range1" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range1" ).slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range6" ).slider({
    range: true,
    min: 0,
    max: 2,
    values: [ 1, 2 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range6" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range6" ).slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range7" ).slider({
    range: true,
    min: 0,
    max: 500,
    values: [ 115, 400 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range7" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range7" ).slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range8" ).slider({
    range: true,
    min: 0,
    max: 2,
    values: [ 1, 2 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range8" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range8" ).slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range9" ).slider({
    range: true,
    min: 0,
    max: 8,
    values: [ 2, 5 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range9" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range9" ).slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range61" ).slider({
    range: true,
    min: 0,
    max: 500,
    values: [ 75, 300 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range61" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range61" ).slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range71" ).slider({
    range: true,
    min: 0,
    max: 2,
    values: [ 1, 2 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range71" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range71" ).slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range81").slider({
    range: true,
    min: 0,
    max: 2,
    values: [ 1, 2 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range81").slider( "values", 0 ) +
    " - $" + $( "#slider-range81").slider( "values", 1 ) );
} );

$( function() {
  $( "#slider-range91" ).slider({
    range: true,
    min: 0,
    max: 2,
    values: [ 1, 2 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range91" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range91" ).slider( "values", 1 ) );
} );
*/


/***************SideMenu JS End****************/
/*
$('.options li').on('click', function(e) {
  $('div#'+$(this).attr('data-value')).show();
  $('.selected').html( $(this).text() );
  $('.options').removeClass('show');
  $('.selected').removeClass('selected-active');
});
$('.selected').on('click', function() {
  $(this).toggleClass('selected-active');
  $('.options').toggleClass('show');
});
*/
/*
$('.menunav').click(function() {
  $('html').removeClass('sidebar_active');
  $('.nav-trigger').removeClass('closemenu');
});
*/
/*
$(".mobile-Jewelry-section").slick({
  dots: true,
  autoplay: true,
  speed: 1000,
  autoplaySpeed: 3000,
});
*/