$(window).scroll(function() {    
  var scroll = $(window).scrollTop();
  if (scroll >= 200) {
      $("header").addClass("fixedHeader");
  } else {
    $("header").removeClass("fixedHeader");
  }
});

$('.menunav').click(function() {
  $('html').removeClass('sidebar_active');
  $('.nav-trigger').removeClass('closemenu');
});
