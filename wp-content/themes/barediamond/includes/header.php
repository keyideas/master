<?php 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/header-menu.css">
   
    <title><?php wp_title(''); ?></title>
    <?php wp_head(); ?>
    
  </head>
  <body class="">

      <div class="container">
      <header class="header_checkout">
            <div class="custom-navbar">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="https://barediamond.com/">
                        <img src="http://www.keyideasglobal.com/qa/barediamond/wp-content/themes/barediamond/images/logo.png" alt="logo"
                            title="logo" class="full-logo">
                    </a>
                    <div class="collapse navbar-collapse  justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="capitalize-text" href="" target="_blank">Need
                                    help?</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href=""><i class="fa fa-envelope"
                                        aria-hidden="true"></i> info@barediamond.com</a>
                            </li>
                            <li class="nav-item">
                                <a href="tel:+646-415-8007"> <i class="fa fa-phone" aria-hidden="true"></i> (646)-415-8007</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
  </div>
<!-- Header Section End -->