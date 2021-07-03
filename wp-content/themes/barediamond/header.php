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
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/bootstrap.min.css">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/owl.carousel.min.css"> -->
    
    <!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/jquery-ui.css"> -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/header-menu.css">
    <?php if(is_page( array('home'))) { ?>
      <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/slick.css">
      <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/slick-theme.css">
    <?php } ?>
    <?php if(is_page( array('diamonds'))) { ?>
      <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/jquery-ui.css">
    <?php } ?>
    <?php if(is_page( array('our-story','education'))) { ?>
      <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/magnific-popup.css"> 
    <?php } ?>
    <?php if(is_product()) { ?>
      <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/slick.css">
      <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/slick-theme.css">
    <?php } ?>
    <title><?php wp_title(''); ?></title>
    <?php wp_head(); ?>
  </head>
<body>
  <!--Header Start--> 
  <main>
      <!-- <header class="header-section pt-4 pb-4 pb-md-0 px-3 pt-md-4">
        <div class="too-header-logo text-md-center pb-lg-3">
          <a href="<?php //echo home_url();?>">
            <img src="<?php //echo get_template_directory_uri();?>/images/logo.png" class="img-fluid" title="logo" alt="logo" />
          </a>
        </div>
        <nav class="navbar navbar-light navbar-expand-lg pb-md-0 pt-md-0">
          <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarCollapse">
      <?php       
            // wp_nav_menu( array(
            //     'menu' => 'main-menu',
            //     'depth' => 2,
            //     'container' => false,
            //     'menu_class' => 'navbar-nav'
            //   ));
      ?>
          </div>
        </nav>
      </header> -->

  <!--Header End-->




<?php
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $link = "https";
else
    $link = "http";
  
// Here append the common URL characters.
$link .= "://";
  
// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];
  
// Append the requested resource location to the URL
$link .= $_SERVER['REQUEST_URI'];
$endpartofurl = basename($link);     

?>
<!--header starts-->
<header class="header-section bgd_header">
    <div class="topNav">
        <ul class="text-right">
            <li><a href="<?php bloginfo('url');?>/education">Education</a></li>
            <li><a href="<?php bloginfo('url');?>/schedule-appointment/">Schedule Appointment</a></li>
        </ul>
    </div>
    <div class="logoNav">
      <div class="content">
          <div class="brand">
            <a href="<?php echo home_url();?>">
              <img src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="Bare Diamond" title="Bare Diamond" class="full-logo">
              <img src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="Bare Diamond" title="Bare Diamond" class="small-logo">
            </a>
          </div>
          <div class="top-right-content">
            <div class="pull-right">
                <div class="trigger"><span class="nav-trigger"><span></span></span></div>
                <div class="nav-wrap">
                  <nav id="push_sidebar">
                    <div class="menunav d-lg-none"><a href="javascript:void(0)" class="closebtn">×</a></div>
                    <div class="menu-top-menu-container">

                      <ul class="nav clearfix">
                         <li class="menu-item nav-item dropdown engangement-menu jewelry_menu diamond_menu <?php if($endpartofurl=='diamonds' || $endpartofurl=='?shape=Round' || $endpartofurl=='?shape=Emerald' || $endpartofurl=='?shape=Oval' || $endpartofurl=='?shape=Marquise' || $endpartofurl=='?shape=Cushion' || $endpartofurl=='?shape=Asscher' || $endpartofurl=='?shape=Pear' || $endpartofurl=='?shape=Radiant' || $endpartofurl=='?shape=Princess' || $endpartofurl=='?shape=Asscher') echo 'active-menu';?> ">
                            <a href="<?php bloginfo('url');?>/diamonds">Diamonds <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <ul class="sub-menu dropdown-menu">
                              <li id="menu-item-1067" class="menu-item">
                                <div class="sub-menu menu_items_container">
                                  <div id="menu-item-1077" class="shape_round menu-item menu-item-type-custom menu-item-object-custom menu-item-1077"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Round" class="nav-link">Round</a></div>
                                  <div id="menu-item-1070" class="shape_emerald menu-item menu-item-type-custom menu-item-object-custom menu-item-1070"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Emerald" class="nav-link">Emerald</a></div>
                                  <div id="menu-item-1073" class="shape_oval menu-item menu-item-type-custom menu-item-object-custom menu-item-1073"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Oval" class="nav-link">Oval</a></div>
                                  <div id="menu-item-1072" class="shape_marquise menu-item menu-item-type-custom menu-item-object-custom menu-item-1072"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Marquise" class="nav-link">Marquise</a></div>
                                  <div id="menu-item-1069" class="shape_cushion menu-item menu-item-type-custom menu-item-object-custom menu-item-1069"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Cushion" class="nav-link">Cushion</a></div>
                                  <div id="menu-item-1068" class="shape_asscher menu-item menu-item-type-custom menu-item-object-custom menu-item-1068"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Asscher" class="nav-link">Asscher</a></div>
                                  <div id="menu-item-1074" class="shape_pear menu-item menu-item-type-custom menu-item-object-custom menu-item-1074"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Pear" class="nav-link">Pear</a></div>
                                  <div id="menu-item-1076" class="shape_radiant menu-item menu-item-type-custom menu-item-object-custom menu-item-1076"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Radiant" class="nav-link">Radiant</a></div>
                                  <div id="menu-item-1075" class="shape_princess menu-item menu-item-type-custom menu-item-object-custom menu-item-1075"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Princess" class="nav-link">Princess</a></div>
                                  <div id="menu-item-1071" class="shape_heart menu-item menu-item-type-custom menu-item-object-custom menu-item-1071"><a href="http://www.keyideasglobal.com/qa/barediamond/diamonds/?shape=Heart" class="nav-link">Heart</a></div>
                                </div>
                              </li> 
                            </ul>
                          </li>
                         
                          <li class="menu-item nav-item dropdown engangement-menu <?php if($endpartofurl=='engagement-rings') echo 'active-menu';?>">
                            <a href="<?php bloginfo('url');?>/engagement-rings">Engagement Rings</a>
                          </li>
                          <li class="menu-item nav-item dropdown wedding-menu <?php if($endpartofurl=='wedding-rings') echo 'active-menu';?>">
                            <a href="<?php bloginfo('url');?>/wedding-rings">Wedding Rings</a>
                          </li>
                          <li class="menu-item nav-item dropdown wedding-menu jewelry_menu <?php if($endpartofurl=='bracelets' || $endpartofurl=='earrings' || $endpartofurl=='fashion-rings' || $endpartofurl=='gents' || $endpartofurl=='necklaces' || $endpartofurl=='customize-your-ring') echo 'active-menu';?>">
                            <a href="javascript:void(0)">Jewelry <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <ul class="sub-menu dropdown-menu">
                              <li class="menu-item">
                                <div class="menu_items_container">
                                  <div><a href="<?php bloginfo('url');?>/bracelets/">Bracelets</a></div>
                                  <div><a href="<?php bloginfo('url');?>/earrings/">Earrings</a></div> 
                                  <div><a href="<?php bloginfo('url');?>/fashion-rings/">Fashion Rings</a></div>
                                  <div><a href="<?php bloginfo('url');?>/gents/">Gents</a></div>
                                  <div><a href="<?php bloginfo('url');?>/necklaces/">Necklaces</a></div>
                                  <div><a href="<?php bloginfo('url');?>/customize-your-ring/">Customize Your Jewelry</a></div>
                                </div>
                              </li>
                            </ul>
                          </li>
                          <li class="menu-item nav-item dropdown wedding-menu <?php if($endpartofurl=='our-story') echo 'active-menu';?>">
                            <a href="<?php bloginfo('url');?>/our-story">Our Story</a>
                          </li>
                          <!-- <li class="menu-item nav-item dropdown education-menu <?php if($endpartofurl=='education') echo 'active-menu';?>">
                            <a href="<?php bloginfo('url');?>/education">Education</a>
                          </li> -->
                          <li class="menu-item nav-item dropdown contact-us-menu jewelry_menu <?php if($endpartofurl=='contact-us' || $endpartofurl=='schedule-appointment') echo 'active-menu';?>">
                            <a href="<?php bloginfo('url');?>/contact-us">Contact Us </a>
                            <!-- <ul class="sub-menu dropdown-menu">
                              <li class="menu-item">
                                <div class="menu_items_container">
                                  <div><a href="<?php //bloginfo('url');?>/schedule-appointment/">Schedule Appointment</a></div>                     
                                </div>
                              </li>
                            </ul> -->
                          </li>
                      </ul>
                      <div class="stay-connected d-block d-sm-block d-md-none">
                        <label>Stay Connected</label>
                        <ul class="phone_email mb-0 d-block">
                          <li><img src="<?php echo get_template_directory_uri();?>/images/bgd_call.svg" /><a href="tel:917-971-2216">917-971-2216</a></li>
                          <li><img src="<?php echo get_template_directory_uri();?>/images/bgd_envelope.svg" /><a href="mailto:info@barediamond.com">info@barediamond.com</a></li>
                        </ul>
                        <ul class="footer_links mb-0 d-block">
                          <li><a href="https://www.facebook.com/BareDiamond/"><img alt="Facebook" title="Facebook" src="<?php echo get_template_directory_uri();?>/images/bgd_facebook.svg" /></a></li>
                          <li><a href="https://twitter.com/thebarediamond"><img alt="Twitter" title="Twitter" src="<?php echo get_template_directory_uri();?>/images/bgd_twitter.svg" /></a></li>
                          <li><a href="https://www.instagram.com/thebarediamond/"><img alt="Instagram" title="Instagram" src="<?php echo get_template_directory_uri();?>/images/bgd_instagram.svg" /></a></li>
                        </ul>
                      </div>
                    </div>
                  </nav>
                </div>
            </div>
          </div>
      </div>
    </div>
</header>
<!--header ends-->