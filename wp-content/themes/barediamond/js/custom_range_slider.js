/*$('.slider').on('initialized.owl.carousel changed.owl.carousel', function(e) {
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