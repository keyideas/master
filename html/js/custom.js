
$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  vertical:true,
  asNavFor: '.slider-for',
  dots: false,
  prevArrow: '<button class="slide-arrow prev-arrow"></button>',
  nextArrow: '<button class="slide-arrow next-arrow"></button>',
  focusOnSelect: true,
  verticalSwiping:true,
  responsive: [
  {
      breakpoint: 992,
      // settings: {
      //   vertical: false,
      // }
  },
  {
    breakpoint: 768,
    // settings: {
    //   vertical: false,
    // }
  },
  {
    breakpoint: 580,
    // settings: {
    //   vertical: false,
    //   slidesToShow: 3,
    // }
  },
  {
    breakpoint: 380,
    // settings: {
    //   vertical: false,
    //   slidesToShow: 2,
    // }
  }
  ]
});



























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
    $( "#slider-range2" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 115, 400 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range2" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range2" ).slider( "values", 1 ) );
  } );
  
  $( function() {
    $( "#slider-range3" ).slider({
      range: true,
      min: 0,
      max: 2,
      values: [ 1, 2 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range3" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range3" ).slider( "values", 1 ) );
  } );
  
  $( function() {
    $( "#slider-range4" ).slider({
      range: true,
      min: 0,
      max: 8,
      values: [ 2, 5 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range4" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range4" ).slider( "values", 1 ) );
  } );
  
  $( function() {
    $( "#slider-range5" ).slider({
      range: true,
      min: 0,
      max: 7,
      values: [ 2, 5 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range5" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range5" ).slider( "values", 1 ) );
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
  
  $( function() {
    $( "#slider-range11" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range11" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range11" ).slider( "values", 1 ) );
  } );
  
  $( function() {
    $( "#slider-range21" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 115, 400 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range21" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range21" ).slider( "values", 1 ) );
  } );
  
  $( function() {
    $( "#slider-range31" ).slider({
      range: true,
      min: 0,
      max: 2,
      values: [ 1, 2 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range31" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range31" ).slider( "values", 1 ) );
  } );
  
  $( function() {
    $( "#slider-range41" ).slider({
      range: true,
      min: 0,
      max: 8,
      values: [ 2, 5 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range41" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range41" ).slider( "values", 1 ) );
  } );
  
  $( function() {
    $( "#slider-range51" ).slider({
      range: true,
      min: 0,
      max: 7,
      values: [ 2, 5 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range51" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range51" ).slider( "values", 1 ) );
    } );
  
  
  /***************SideMenu JS End****************/
  