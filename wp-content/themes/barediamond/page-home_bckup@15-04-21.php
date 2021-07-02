<?php
/**
 * The Front home page template file
*/

get_header(); 

$page_id = get_the_ID();

//banner section
$banner_image_data = get_field('banner_image',$page_id);
if(!empty($banner_image_data)){
	$banner_image_src = $banner_image_data['url'];
}else{
	$banner_image_src = home_url()."/wp-includes/images/media/default.png";
}
$banner_label_1 = get_field('banner_label_1',$page_id);
$banner_label_2 = get_field('banner_label_2',$page_id);
$banner_link = get_field('banner_link',$page_id);
$banner_button_text = get_field('banner_button_text',$page_id);
$banner_button_text = !empty($banner_button_text) ? $banner_button_text : 'View';

//strip section
$strip_text = get_field('strip_text',$page_id);

//special section
$special_section_image_data = get_field('special_section_image',$page_id);
if(!empty($special_section_image_data)){
	$special_section_image_src = $special_section_image_data['url'];
}else{
	$special_section_image_src = home_url()."/wp-includes/images/media/default.png";
}
$special_section_title = get_field('special_section_title',$page_id);
$special_section_description = get_field('special_section_description',$page_id);
$special_section_link = get_field('special_section_link',$page_id);
$special_button_text = get_field('special_button_text',$page_id);
$special_button_text = !empty($special_button_text) ? $special_button_text : 'View';

//ethical left section
$ethical_left_image_data = get_field('ethical_left_image',$page_id);
if(!empty($ethical_left_image_data)){
	$ethical_left_image_src = $ethical_left_image_data['url'];
}else{
	$ethical_left_image_src = home_url()."/wp-includes/images/media/default.png";
}
$ethical_left_title = get_field('ethical_left_title',$page_id);
$ethical_left_description = get_field('ethical_left_description',$page_id);
$ethical_left_link = get_field('ethical_left_link',$page_id);
$ethical_left_button_text = get_field('ethical_left_button_text',$page_id);
$ethical_left_button_text = !empty($ethical_left_button_text) ? $ethical_left_button_text : 'View';

//ethical right section
$ethical_right_image_data = get_field('ethical_right_image',$page_id);
if(!empty($ethical_right_image_data)){
	$ethical_right_image_src = $ethical_right_image_data['url'];
}else{
	$ethical_right_image_src = home_url()."/wp-includes/images/media/default.png";
}
$ethical_right_title = get_field('ethical_right_title',$page_id);
$ethical_right_description = get_field('ethical_right_description',$page_id);
$ethical_right_link = get_field('ethical_right_link',$page_id);
$ethical_right_button_text = get_field('ethical_right_button_text',$page_id);
$ethical_right_button_text = !empty($ethical_right_button_text) ? $ethical_right_button_text : 'View';

?>
<!--Home page body content start-->
<section class="banner-section">
	<div class="banner-inner position-relative">
	  <img src="<?php echo get_template_directory_uri();?>/images/home-banner.png" class="img-fluid w-100 d-none d-sm-none d-md-block" alt="home-banner" title="home-banner" />
	  <img src="<?php echo get_template_directory_uri();?>/images/home-banner-mobile.png" class="img-fluid w-100 d-block d-sm-block d-md-none" title="ethically-secure-banner" alt="ethically-secure-banner" />
	  <div class="banner-caption d-flex flex-column justify-content-center">
		<?php if(!empty($banner_label_1)){?> <h1><?php echo $banner_label_1;?></h1> <?php } ?>
		<?php if(!empty($banner_label_2)){?> <h2><?php echo $banner_label_2;?></h2> <?php } ?>
		<!--<button class="btn banner-btn mt-2 mt-md-4">LEARN MORE</button>-->
		<a href="<?php echo $banner_link;?>" class="btn banner-btn mt-4 mt-md-5"><?php echo $banner_button_text;?></a>
	  </div>
	</div>
</section>

<section class="strip-section text-center d-none d-sm-none d-md-block">
	<?php if(!empty($strip_text)){?>
		<h2><?php echo $strip_text;?></h2>
	<?php } ?>
</section>

<section class="created-specially-section">
	<div class="container-fluid">
	  <div class="row">
		<div class="col-sm-6">
		  <div class="row">
			<div class="create-banner-left p-0 w-100">
				<img src="<?php echo get_template_directory_uri();?>/images/create-banner.png" class="img-fluid w-100 d-none d-sm-none d-md-block" alt="create-banner" title="create-banner">
                <img src="<?php echo get_template_directory_uri();?>/images/create-banner-mobile.png" class="img-fluid w-100 d-block d-sm-block d-md-none" alt="create-banner" title="create-banner">
			</div>
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="created-specially-right d-flex justify-content-center h-100 flex-column">
			<?php if(!empty($special_section_title)){?>
				<h3 class=""><?php echo $special_section_title;?></h3>
			<?php } ?>
			<?php if(!empty($special_section_description)){?>
				<p><?php echo $special_section_description;?></p>
			<?php } ?>
			<!--<button class="btn view-diamond-btn mt-3 mt-md-3 mt-lg-5">VIEW OUR DIAMONDS</button>-->
			<a href="<?php echo $special_section_link;?>" class="btn view-diamond-btn mt-4 mt-md-4 mt-lg-5"><?php echo $special_button_text;?></a>
		  </div>
		</div>
	  </div>
	</div>
</section>

<section class="ecology-progressive-banner position-relative">
	<div class="container-fluid">
	  <div class="row">
		<div class="ecology-progressive-inner w-100">
		  <img src="<?php echo get_template_directory_uri();?>/images/banner-4.jpg" class="img-fluid d-none d-sm-none d-md-block w-100" title="banner-slider" alt="banner-slider" />
		  <img src="<?php echo get_template_directory_uri();?>/images/banner-4-mobile.png" class="img-fluid d-block d-sm-block d-md-none w-100" title="banner-slider" alt="banner-slider" />
		  <div class="banner-slider-caption max-width-310">
			<h3>FLAWLESS PEDIGREE</h3>
			<p>Painstakingly recreating the precise environment that nature uses has enabled us to create flawless diamonds that are virtually identical to those created in the ground.</p>
			<!-- <button class="btn btn-our-jewelry mt-3 mt-md-3 mt-lg-5">VIEW BRACELETS</button> -->
			<a href="<?php echo home_url();?>/bracelet" class="btn btn-our-jewelry mt-3 mt-md-3 mt-lg-5">VIEW BRACELETS</a>
		  </div>
		</div>
	  </div>
	</div>
</section>

<!-- <div class="best-seller-wrapper py-7">
	<div class="container">
	  <div class="row">
		<h3 class="text-center position-relative w-100 mb-3 mb-sm-3 mb-md-5"><span>POPULAR AT BARE GROWN</span></h3>
		<div class="col-sm-12">
		  <div class="row">
			<div class="best-seller-slider w-100">
			  <div class="item">
				<img src="<?php //echo get_template_directory_uri();?>/images/slider-img1.png" class="img-fluid" alt="" title="">
				<div class="slider-img-caption">
				  <label>White Gold Diamond</label>
				  <span>(SETTING ONLY)</span>
				  <div class="product_price">
					<span class="Price-amount">
					  <span class="Price-currencySymbol">$</span>1,750
					</span>
				  </div>
				</div>
			  </div>
			  <div class="item">
				<img src="<?php //echo get_template_directory_uri();?>/images/slider-img2.png" class="img-fluid" alt="" title="">
				<div class="slider-img-caption">
				  <label>White Gold Diamond</label>
				  <span>(SETTING ONLY)</span>
				  <div class="product_price">
					<span class="Price-amount">
					  <span class="Price-currencySymbol">$</span>1,750
					</span>
				  </div>
				</div>
			  </div>
			  <div class="item">
				<img src="<?php //echo get_template_directory_uri();?>/images/slider-img3.png" class="img-fluid" alt="" title="">
				<div class="slider-img-caption">
				  <label>White Gold Diamond</label>
				  <span>(SETTING ONLY)</span>
				  <div class="product_price">
					<span class="Price-amount">
					  <span class="Price-currencySymbol">$</span>1,750
					</span>
				  </div>
				</div>
			  </div>
			  <div class="item">
				<img src="<?php //echo get_template_directory_uri();?>/images/slider-img4.png" class="img-fluid" alt="" title="">
				<div class="slider-img-caption">
				  <label>White Gold Diamond</label>
				  <span>(SETTING ONLY)</span>
				  <div class="product_price">
					<span class="Price-amount">
					  <span class="Price-currencySymbol">$</span>1,750
					</span>
				  </div>
				</div>
			  </div>
			  <div class="item d-none d-sm-none d-md-block">
				<img src="<?php //echo get_template_directory_uri();?>/images/slider-img1.png" class="img-fluid" alt="" title="">
				<div class="slider-img-caption">
				  <label>White Gold Diamond</label>
				  <span>(SETTING ONLY)</span>
				  <div class="product_price">
					<span class="Price-amount">
					  <span class="Price-currencySymbol">$</span>1,750
					</span>
				  </div>
				</div>
			  </div>
			  <div class="item d-none d-sm-none d-md-block">
				<img src="<?php //echo get_template_directory_uri();?>/images/slider-img2.png" class="img-fluid" alt="" title="">
				<div class="slider-img-caption">
				  <label>White Gold Diamond</label>
				  <span>(SETTING ONLY)</span>
				  <div class="product_price">
					<span class="Price-amount">
					  <span class="Price-currencySymbol">$</span>1,750
					</span>
				  </div>
				</div>
			  </div>
			  <div class="item d-none d-sm-none d-md-block">
				<img src="<?php //echo //get_template_directory_uri();?>/images/slider-img3.png" class="img-fluid" alt="" title="">
				<div class="slider-img-caption">
				  <label>White Gold Diamond</label>
				  <span>(SETTING ONLY)</span>
				  <div class="product_price">
					<span class="Price-amount">
					  <span class="Price-currencySymbol">$</span>1,750
					</span>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</div> -->

<?php /* ?>
<section class="our-jewelry-slider position-relative" id="panel4">
	<div class="slider owl-carousel">
	<?php
	$args = array(
				'posts_per_page' 	=> -1,
				'post_type' 		=> 'slider',
				'orderby'          	=> 'date',
				'order'            	=> 'DESC',
			);
			
	$slider = get_posts( $args );
	?>
	<?php foreach($slider as $key => $slide) { ?>
			<?php
			$slide_desktop_image_src = get_the_post_thumbnail_url($slide->ID);
			$slide_mobile_image_data = get_field('mobile_slide_image',$slide->ID);
			$slide_mobile_image_src = $slide_mobile_image_data['url'];
			$slide_link = get_field('slide_link',$slide->ID);
			$slide_button_text = get_field('slide_button_text',$slide->ID);
			$slide_title = $slide->post_title;
			$slide_content = $slide->post_content;
			?>
			<div class="slider-row">
				<img src="<?php echo $slide_desktop_image_src;?>" class="img-fluid d-none d-sm-none d-md-block" title="banner-slider" alt="banner-slider" />
				<img src="<?php echo $slide_mobile_image_src;?>" class="img-fluid d-block d-sm-block d-md-none" title="banner-slider" alt="banner-slider" />
				<div class="banner-slider-caption">
				  <h3><?php echo $slide_title;?></h3>
				  <p><?php echo $slide_content;?></p>
				  <!--<button class="btn btn-our-jewelry mt-3 mt-md-5">SEE OUR JEWELRY</button>-->
				  <a href="<?php echo $slide_link;?>" class="btn btn-our-jewelry mt-3 mt-md-5"><?php echo $slide_button_text;?></a>
				</div>
			 </div>
	<?php } ?>
	</div>
	<div class="slider-counter"></div>
</section>
<?php */ ?>

<div class="shop-diamond-shape glb-heading py-7">
	<div class="container">
	  <div class="row">
		<h3 class="text-center position-relative w-100 mb-4 mb-sm-4 mb-md-5"><span>SHOP BY DIAMOND SHAPE</span></h3>
		<div class="col-sm-12">
		  <div class="row">
			<div class="diff-diamond-images w-100 d-flex justify-content-center align-items-center flex-wrap pb-lg-4">
			  <div class="round diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Round">
					<img src="<?php echo get_template_directory_uri();?>/images/round.png" class="img-fluid" alt="round" title="">
					<p>Round</p>
				</a>
			  </div>
			  <div class="oval diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Oval">
					<img src="<?php echo get_template_directory_uri();?>/images/oval.png" class="img-fluid" alt="oval" title="">
					<p>Oval</p>
				</a>
			  </div> 
			  <div class="cushion diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Cushion">
					<img src="<?php echo get_template_directory_uri();?>/images/cushion.png" class="img-fluid" alt="cushion" title="">
					<p>Cushion</p>
				</a>
			  </div>
			  <div class="princess diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Princess">
					<img src="<?php echo get_template_directory_uri();?>/images/princess.png" class="img-fluid" alt="princess" title="">
					<p>Princess</p>
				</a>
			  </div>
			  <div class="pear diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Pear">
					<img src="<?php echo get_template_directory_uri();?>/images/pear.png" class="img-fluid" alt="pear" title="">
					<p>Pear</p>
				</a>
			  </div>
			  <div class="emerald diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Emerald">
					<img src="<?php echo get_template_directory_uri();?>/images/emerald.png" class="img-fluid" alt="emarld" title="">
					<p>Emerald</p>
				</a>
			  </div>
			  <div class="marquise diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Marquise">
					<img src="<?php echo get_template_directory_uri();?>/images/marquise.png" class="img-fluid" alt="marquise" title="">
					<p>Marquise</p>
				</a>
			  </div>
			  <div class="asscher diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Asscher">
					<img src="<?php echo get_template_directory_uri();?>/images/asscher.png" class="img-fluid" alt="asscher" title="">
					<p>Asscher</p>
				</a>
			  </div>
			  <div class="radient diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Radiant">
					<img src="<?php echo get_template_directory_uri();?>/images/radient.png" class="img-fluid" alt="radient" title="">
					<p>Radient</p>
				</a>
			  </div>
			  <div class="heart diamond-spirit-img">
				<a href="<?php echo home_url();?>/diamonds/?shape=Heart">
					<img src="<?php echo get_template_directory_uri();?>/images/heart.png" class="img-fluid" alt="heart" title="">
					<p>Heart</p>
				</a>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</div>

<section class="ecology-progressive-banner position-relative">
	<div class="container-fluid">
	  <div class="row">
		<div class="ecology-progressive-inner w-100">
		  <img src="<?php echo get_template_directory_uri();?>/images/lovelingly-hand-crafted.jpg" class="img-fluid d-none d-sm-none d-md-block w-100" title="lovelingly-hand-crafted" alt="lovelingly-hand-crafted" />
		  <img src="<?php echo get_template_directory_uri();?>/images/lovelingly-hand-crafted-mobile.png" class="img-fluid d-block d-sm-block d-md-none w-100" title="lovelingly-hand-crafted" alt="lovelingly-hand-crafted" />
		  <div class="banner-slider-caption lovingly-banner-text">
			<h3>LOVINGLY HAND CRAFTED</h3>
			<p class="mb-0 max-width-web-65">We’ve recreated the conditions that nature uses to create diamonds with no human or environmental cost.</p>
			<!-- <button class="btn btn-our-jewelry mt-4 mt-md-4 mt-lg-5">VIEW WEDDING RINGS</button> -->
			<a href="<?php echo home_url();?>/wedding-rings" class="btn btn-our-jewelry mt-4 mt-md-4 mt-lg-5">VIEW WEDDING RINGS</a>
		  </div>
		</div>
	  </div>
	</div>
</section>

<!-- <section class="ecology-progressive-banner position-relative">
	<div class="container-fluid">
	  <div class="row">
		<div class="ecology-progressive-inner w-100">
		  <img src="<?php //echo get_template_directory_uri();?>/images/home-banner-2.png" class="img-fluid d-none d-sm-none d-md-block w-100" title="ecology-progressive" alt="ecology-progressive" />
		  <img src="<?php //echo get_template_directory_uri();?>/images/home-banner-2-mobile.png" class="img-fluid d-block d-sm-block d-md-none w-100" title="ecology-progressive" alt="ecology-progressive" />
		  <div class="banner-slider-caption max-width-300">
			<h3>ECOLOGICALLY PROGRASSIVE</h3>
			<p class="mb-0 max-width-web-70">Similar to flowers, diamonds grow at different rates but end up with the same genetic makeup</p>
			<button class="btn btn-our-jewelry mt-3 mt-md-3 mt-lg-5">SEE OUR JEWELRY</button>
		  </div>
		</div>
	  </div>
	</div>
</section> -->

<section class="grid-column-section">
	<div class="container-fluid">
	  <div class="row">
		<div class="col-sm-6">
		  <div class="row">
			<div class="ethical-sourced-left p-0 position-relative w-100">
			  <!-- <img src="<?php // echo $ethical_left_image_src;?>" class="img-fluid w-100" title="ethically-secure-banner" alt="ethically-secure-banner" /> -->
			  	<img src="<?php echo get_template_directory_uri();?>/images/ethically-secure-banner.jpg" class="img-fluid w-100 d-none d-sm-none d-md-block" title="ethically-secure-banner" alt="ethically-secure-banner" />
                <img src="<?php echo get_template_directory_uri();?>/images/ethically-secure-banner-mobile.png" class="img-fluid w-100 d-block d-sm-block d-md-none" title="ethically-secure-banner" alt="ethically-secure-banner" />
			  <div class="ethical-sourced-caption d-flex flex-column justify-content-center text-center">
				<?php if(!empty($ethical_left_title)){?> <h3><?php echo $ethical_left_title;?></h3> <?php } ?>
				<?php if(!empty($ethical_left_description)){?> <p><?php echo $ethical_left_description;?></p> <?php } ?>
				<!--<button class="btn btn-grown mt-4 mt-md-5">GROWN DIAMONDS</button>-->
				<a href="<?php echo $ethical_left_link;?>" class="btn btn-grown mt-3 mt-md-3 mt-lg-5"><?php echo $ethical_left_button_text;?></a>
			  </div>
			</div>
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="row">
			<div class="ethical-sourced-right p-0 position-relative w-100">
			  <img src="<?php echo $ethical_right_image_src;?>" class="img-fluid w-100" title="ethically-secure-banner" alt="ethically-secure-banner" />
			  <div class="ecology-sourced-caption d-flex flex-column justify-content-center text-center">
				<?php if(!empty($ethical_right_title)){?> <h3><?php echo $ethical_right_title;?></h3> <?php } ?>
				<?php if(!empty($ethical_right_description)){?> <p><?php echo $ethical_right_description;?></p> <?php } ?>
				<!--<button class="btn btn-grown mt-4 mt-md-5">WHERE TO BUY</button>-->
				<a href="<?php echo $ethical_right_link;?>" class="btn btn-grown mt-3 mt-md-3 mt-lg-5"><?php echo $ethical_right_button_text;?></a>
				
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</section>

<!--get instagram fedd-->
<?php echo do_shortcode('[instagram-feed]');?>

<!--Home page content end-->

<?php get_footer();?>