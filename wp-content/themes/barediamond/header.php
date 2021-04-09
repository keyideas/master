<?php
/**
 * The header for our theme
 */
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/slick.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/slick-theme.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/jquery-ui.css">
    <?php if(is_page( array('our-story','education'))) { ?>
      <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/magnific-popup.css"> 
		<?php } ?>
    <title><?php wp_title(''); ?></title>
    <?php wp_head(); ?>
  </head>
<body>
	<!--Header Start--> 
	<main>
      <header class="header-section pt-4 pb-4 pb-md-0 px-3 pt-md-4">
        <div class="too-header-logo text-md-center pb-lg-3">
          <a href="<?php echo home_url();?>">
			<img src="<?php echo get_template_directory_uri();?>/images/logo.png" class="img-fluid" title="logo" alt="logo" />
		  </a>
        </div>
        <nav class="navbar navbar-light navbar-expand-lg pb-md-0 pt-md-0">
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarCollapse">
			<?php      	
	          wp_nav_menu( array(
	              'menu' => 'main-menu',
	              'depth' => 2,
	              'container' => false,
	              'menu_class' => 'navbar-nav'
	            ));
			?>
          </div>
        </nav>
      </header>

	<!--Header End-->