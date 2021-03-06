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

<section class="banner-section banner_home_page">
	<div class="banner-inner position-relative">
		<img src="<?php echo get_template_directory_uri();?>/images/bgd-home-banner.jpg" class="img-fluid w-100 d-none d-sm-none d-md-block" alt="bgd_home_banner" title="bgd_home_banner">
		<img src="<?php echo get_template_directory_uri();?>/images/bgd-home-banner-mobile.jpg" class="img-fluid w-100 d-block d-sm-block d-md-none" alt="bgd_home_banner" title="bgd_home_banner">
		<div class="banner-caption d-md-flex flex-column justify-content-md-center">
			<h1>Latest Collection</h1>
			<div class="banner_para_text">Elegant but modern pieces with distinctive style</div>
			<a class="btn banner-btn mt-4" href="<?php bloginfo('url')?>/engagement-rings">Shop Engagement Rings</a>
		</div>
	</div>
</section>

<section class="shop_wedding_rings_section position-relative">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-7 col-lg-6 col-xl-6">
				<div class="shop_wedding_rings_text d-flex justify-content-center align-content-center flex-column">
					<h2>Shop for Men and Women Wedding Bands</h2>
					<p>Browse our exclusive line of uniquely hand-crafted wedding bands</p>
					<div class="shop_wedding_rings_btn">
                        <a href="<?php bloginfo('url')?>/wedding-rings" class="btn btn-wedding_rings">Shop Wedding Bands</a>
                    </div>
				</div>
			</div>
			<div class="col-sm-6 col-md-5 col-lg-6 col-xl-6">
				<div class="bgd_wedding_ring">
				<img src="<?php echo get_template_directory_uri();?>/images/bgd_wedding_ring.jpg" class="img-fluid w-100" alt="bgd_wedding_ring" />
				</div>
			</div>
		</div>
	</div>
</section>

<section class="bgd-bridal-feature_section position-relative pb-md-5">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-5 col-lg-5 col-xl-5">
				<video height="650" preload="auto" autoplay loop="loop" muted="muted" style="width: 100%;">
                    <source src="https://barediamond.com/wp-content/product-images/engagement-rings/bm4047-cu/video/bm4047-cu_video_4.mp4" type="video/mp4">
                </video>
			</div>
			<div class="col-sm-6 col-md-7 col-lg-7 col-xl-7">
				<div class="bgd-bridal-feature-image">
					<img src="<?php echo get_template_directory_uri();?>/images/bgd-bridal-feature-image.jpg" class="img-fluid" alt="bridal image" />
				</div>
			</div>
		</div>
	</div>
</section>

<section class="world_of_jewelry_section bg-f4f4f4 py-5">
	<div class="container-fluid">
		<div class="row">
			<?php if ( wp_is_mobile() ) : ?>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<h2 class="mb-5 text-center">Hand-Finished Pieces For Every Style Discover a World of Jewelry</h2>
						</div>
						<div class="col-12">
							<div class="mobile-Jewelry-section">
								<div class="world_jewelry_img position-relative">
									<a href="<?php echo get_bloginfo('url'); ?>/fashion-rings/"><img src="<?php echo get_template_directory_uri();?>/images/bgd_world_jewelry_1.jpg" class="img-fluid w-100" alt="bgd_world_jewelry_1" /></a>
									<h3 class="figure-caption"><a href="<?php echo get_bloginfo('url'); ?>/fashion-rings/">Fashion Rings</a></h3>
								</div>
								<div class="world_jewelry_img position-relative">
									<a href="<?php echo get_bloginfo('url'); ?>/earrings/"><img src="<?php echo get_template_directory_uri();?>/images/bgd_world_jewelry_2.jpg" class="img-fluid w-100" alt="bgd_world_jewelry_2" /><a>
									<h3 class="figure-caption"><a href="<?php echo get_bloginfo('url'); ?>/earrings/">Earrings</a></h3>
								</div>
								<div class="world_jewelry_img position-relative">
									<a href="<?php echo get_bloginfo('url'); ?>/necklaces/"><img src="<?php echo get_template_directory_uri();?>/images/bgd_world_jewelry_3.jpg" class="img-fluid w-100" alt="bgd_world_jewelry_3" /></a>
									<h3 class="figure-caption"><a href="<?php echo get_bloginfo('url'); ?>/necklaces/">Necklaces and Pendants</a></h3>
								</div>
								<div class="world_jewelry_img position-relative">
									<a href="<?php echo get_bloginfo('url'); ?>/bracelets/"><img src="<?php echo get_template_directory_uri();?>/images/bgd_world_jewelry_4.jpg" class="img-fluid w-100" alt="bgd_world_jewelry_4" /></a>
									<h3 class="figure-caption"><a href="<?php echo get_bloginfo('url'); ?>/bracelets/">Bracelets</a></h3>
								</div>
							</div>
						</div>
					</div>		
				</div>
			<?php else : ?>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<h2 class="mb-5 text-center">Hand-Finished Pieces For Every Style <br> Discover a World of Jewelry</h2>
						</div>
						<div class="col-sm-3 col-6 mb-3 mb-sm-0">
							<div class="grid">
								<figure class="effect-layla">
									<a href="<?php bloginfo('url')?>/fashion-rings/">
										<img src="<?php echo get_template_directory_uri();?>/images/bgd_world_jewelry_1.jpg" class="img-fluid w-100" alt="bgd_world_jewelry_1" />
										<span></span>	
									</a>		
								</figure>
								<h3 class="figure-caption"><a href="<?php bloginfo('url')?>/fashion-rings/">Fashion Rings</a></h3>
							</div>
						</div>
						<div class="col-sm-3 col-6 mb-3 mb-sm-0">
							<div class="grid">
								<figure class="effect-layla">
									<a href="<?php bloginfo('url')?>/earrings/">
										<img src="<?php echo get_template_directory_uri();?>/images/bgd_world_jewelry_2.jpg" class="img-fluid w-100" alt="bgd_world_jewelry_2" />
										<span></span>
									</a>			
								</figure>
								<h3 class="figure-caption"><a href="<?php bloginfo('url')?>/earrings/">Earrings</a></h3>
							</div>
						</div>
						<div class="col-sm-3 col-6">
							<div class="grid">
								<figure class="effect-layla">
									<a href="<?php bloginfo('url')?>/necklaces/">
										<img src="<?php echo get_template_directory_uri();?>/images/bgd_world_jewelry_3.jpg" class="img-fluid w-100" alt="bgd_world_jewelry_3" />
										<span></span>	
									</a>		
								</figure>
								<h3 class="figure-caption"><a href="<?php bloginfo('url')?>/necklaces/">Necklaces and Pendants</a></h3>
							</div>
						</div>
						<div class="col-sm-3 col-6">
							<div class="grid">
								<figure class="effect-layla">
									<a href="<?php bloginfo('url')?>/bracelets/">
										<img src="<?php echo get_template_directory_uri();?>/images/bgd_world_jewelry_4.jpg" class="img-fluid w-100" alt="bgd_world_jewelry_4" />
										<span></span>
									</a>			
								</figure>
								<h3 class="figure-caption"><a href="<?php bloginfo('url')?>/bracelets/">Bracelets</a></h3>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="shop-diamond-shape glb-heading py-5">
	<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
		<div class="row">
			<h2 class="text-center w-100 mb-0">Shop by Diamond Shape</h2>
			<div class="col-sm-12">
				<div class="row">
					<div class="diff-diamond-images w-100 d-flex justify-content-center align-items-center flex-wrap pb-lg-4">
						<div class="round diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Round">
								<img src="<?php echo get_template_directory_uri();?>/images/round.png" class="img-fluid" alt="round" title="">
								<p>Round</p>
							</a>
						</div>
						<div class="oval diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Oval">
								<img src="<?php echo get_template_directory_uri();?>/images/oval.png" class="img-fluid" alt="oval" title="">
								<p>Oval</p>
							</a>
						</div> 
						<div class="cushion diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Cushion">
								<img src="<?php echo get_template_directory_uri();?>/images/cushion.png" class="img-fluid" alt="cushion" title="">
								<p>Cushion</p>
							</a>
						</div>
						<div class="princess diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Princess">
								<img src="<?php echo get_template_directory_uri();?>/images/princess.png" class="img-fluid" alt="princess" title="">
								<p>Princess</p>
							</a>
						</div>
						<div class="pear diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Pear">
								<img src="<?php echo get_template_directory_uri();?>/images/pear.png" class="img-fluid" alt="pear" title="">
								<p>Pear</p>
							</a>
						</div>
						<div class="emerald diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Emerald">
								<img src="<?php echo get_template_directory_uri();?>/images/emerald.png" class="img-fluid" alt="emarld" title="">
								<p>Emerald</p>
							</a>
						</div>
						<div class="marquise diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Marquise">
								<img src="<?php echo get_template_directory_uri();?>/images/marquise.png" class="img-fluid" alt="marquise" title="">
								<p>Marquise</p>
							</a>
						</div>
						<div class="asscher diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Asscher">
								<img src="<?php echo get_template_directory_uri();?>/images/asscher.png" class="img-fluid" alt="asscher" title="">
								<p>Asscher</p>
							</a>
						</div>
						<div class="radient diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Radiant">
								<img src="<?php echo get_template_directory_uri();?>/images/radient.png" class="img-fluid" alt="radient" title="">
								<p>Radiant</p>
							</a>
						</div>
						<div class="heart diamond-spirit-img">
							<a href="<?php bloginfo('url');?>/diamonds/?shape=Heart">
								<img src="<?php echo get_template_directory_uri();?>/images/heart.png" class="img-fluid" alt="heart" title="">
								<p>Heart</p>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="shop_wedding_rings_section created_specially_for_you position-relative py-5">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="bgd_wedding_ring">
					<img src="<?php echo get_template_directory_uri();?>/images/bgd_specially_ring.jpg" class="img-fluid" alt="bgd_specially_ring" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="shop_wedding_rings_text d-md-flex justify-content-md-center align-content-md-center flex-column">
					<h2>Created Specially For You</h2>
					<p>Our team of highly skilled diamond experts are here to assist you in designing and creating the ring of your dreams</p>
					<div class="shop_wedding_rings_btn">
						<a href="<?php bloginfo('url')?>/customize-your-ring/" class="btn btn-wedding_rings">Customize your ring</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="education_ourstory_section py-3 py-md-5">
	<div class="container">
		<div class="row">
			<div class="col-7 col-sm-6 offset-sm-0 mb-4">
				<div class="hover15 education_section">
					<div>
						<a href="<?php echo get_bloginfo('url'); ?>/education">
							<figure><img src="<?php echo get_template_directory_uri();?>/images/bgd_education_img.jpg" class="img-fluid w-100" alt="education image" /></figure>
							<h2>EDUCATION</h2>
						</a>
					</div>
				</div>
			</div>
			<div class="col-7 offset-5 col-sm-6 offset-sm-0">
				<div class="hover15 ourstory_section">
					<div>
						<a href="<?php echo get_bloginfo('url'); ?>/our-story">
							<figure><img src="<?php echo get_template_directory_uri();?>/images/bgd_our_story_img.jpg" class="img-fluid w-100" alt="our story image" /></figure>
							<h2>OUR STORY</h2>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>



<!--Home page content end-->

<?php get_footer();?>