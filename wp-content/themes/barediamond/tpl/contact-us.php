<?php
/**
 Template Name: Contact us
*/

get_header();
?>
<style>
a:hover {
	text-decoration: none !important;
}
</style>

<div class="customize-ur-ring-wrapper">
	<div class="top-heading">
		<h1>GET IN TOUCH!</h1>
	</div>
	<div class="customize-ring-form">
		<div class="container">
			<?php echo do_shortcode('[contact-form-7 id="81" title="Contact Us"]');?>
		</div>
	</div>
	<div class="contact-map">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-lg-5">
					<div class="contact-left-section">
						<div class="contact-left-info p-md-4">
							<div class="contact-search-row position-relative my-4">
								<input type="text" class="form-control" placeholder="Search Location" />
								<span><i class="fa fa-search" aria-hidden="true"></i></span>
							</div>
							<div class="contact-info-dtl">
								<div class="contact-left-info-row">
									<h3>Bailey Banks and Biddle – Dallas Galleria</h3>
									<p>13350 Dallas Parkway Suite 1325,<br>
										Dallas, Texas 75240<br>
										United States<br>
										Tel: 972.239.5511<br>
									</p>
									<p class="more-info-direction"><span><a href="">More Info</a></span><span>Directions</span></p>
								</div>
								<div class="contact-left-info-row mt-4">
									<h3>Bailey Banks and Biddle – Dallas Galleria</h3>
									<p>13350 Dallas Parkway Suite 1325,<br>
										Dallas, Texas 75240<br>
										United States<br>
										Tel: 972.239.5511<br>
									</p>
									<p class="more-info-direction"><span><a href="">More Info</a></span><span>Directions</span></p>
								</div>
								<div class="contact-left-info-row mt-4">
									<h3>Bailey Banks and Biddle – Dallas Galleria</h3>
									<p>13350 Dallas Parkway Suite 1325,<br>
										Dallas, Texas 75240<br>
										United States<br>
										Tel: 972.239.5511<br>
									</p>
									<p class="more-info-direction"><span><a href="">More Info</a></span><span>Directions</span></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-7">
					<div class="row">
						<img src="<?php echo get_template_directory_uri();?>/images/contact-us-map.png" class="img-fluid w-100" alt="contact-us-map" title="contact-us-map" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="inquiry-section">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<div class="row">
						<img src="<?php echo get_template_directory_uri();?>/images/our-contactus-stones-hold.png" class="img-fluid w-100" alt="our-contactus-stones-hold" title="our-contactus-stones-hold" />
					</div>
				</div>
				<div class="col-sm-6">
					<div class="inquiry-section-right d-flex flex-column justify-content-center align-items-center h-100">
						<div class="inquiry-row mb-3 mb-md-3 mb-lg-5 d-flex flex-column justify-content-center align-items-center">
							<label>INQUIRIES</label>
							<p><a href="mailto:info@barediamond.com">info@barediamond.com</a></p>
						</div>
						<div class="inquiry-row mb-3 mb-md-3 mb-lg-5 d-flex flex-column justify-content-center align-items-center">
							<label>PHONE</label>
							<p><a href="tel:917-971-2216">917-971-2216</a></p>
						</div>
						<div class="inquiry-row d-flex flex-column justify-content-center align-items-center">
							<label>STAY CONNECTED</label>
							<ul class="m-0 p-0 list-unstyled d-flex contact-social-icons">
								<li><a href="https://www.facebook.com/BareDiamond/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="https://twitter.com/thebarediamond"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a href="https://www.instagram.com/thebarediamond/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>