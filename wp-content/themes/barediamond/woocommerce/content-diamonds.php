<?php
/**
 * The template for displaying Diamonds
*/
get_header();

global $product;

$postId = $product->get_id();
$detail_api_data 	= get_detail_api_data($postId);
$posts_id_diamond	= $detail_api_data['posts_id'];	
$certificate_num	= $detail_api_data['Style'];	
$Sku			= $detail_api_data['Sku'];
$stockNumber	= $detail_api_data['stockNumber'];
$diamondShape	= $detail_api_data['ShapeCode'];
$Color 			= $detail_api_data['Color'];
$Clarity		= $detail_api_data['Clarity'];
$Cut 			= $detail_api_data['Cut'];
$SizeCt			= $detail_api_data['SizeCt'];
$lab 			= $detail_api_data['CertType'];
$Polish			= $detail_api_data['Polish'];
$Symmetry		= $detail_api_data['Symmetry'];
$depth 			= $detail_api_data['DepthPct'];
$table 			= $detail_api_data['TablePct'];
$Fluorescence	= $detail_api_data['Fluorescence'];
$LWRatio		= $detail_api_data['LWRatio'];
$Girdle			= $detail_api_data['Girdle'];
$Culet			= $detail_api_data['Culet'];
$vendor_price	= $detail_api_data['WholesalePrice'];
$Measurements	= $detail_api_data['Measurements'];
$vendor_name	= $detail_api_data['name'];
$vendor_code	= $detail_api_data['vendor_code'];
$abbreviation	= $detail_api_data['abbreviation'];
$shipdays		= $detail_api_data['shipdays'];
$CertLink		= $detail_api_data['CertLink'];
$price			= $detail_api_data['price'];
$VideoLink 		= $detail_api_data['VideoLink'];
if($VideoLink!="") {
	$VideoLink	= $detail_api_data['VideoLink']."&zoomslide=0&btn=0&sr=100&s=-10&isBorderRadius=0&z=0&sv=0&sm=0";
}
$price_symb 	= get_woocommerce_currency_symbol();
$image_url		= $detail_api_data['Image'];
if($image_url=='') {
	$image_url = shape_no_images($diamondShape);
}
$cert_img_url = get_cert_img($lab);
$cert_sample_img_url = get_cert_sample_img($lab);
?>
<div class="barediamond-details-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="vehicle-detail-banner banner-content clearfix content_diamond_slider">
					<div class="banner-slider">
						<div class="slider1 slider-for">
							<div class="slider-banner-image">
								<img class="img-fluid w-100" src="<?php echo $image_url;?>" alt="large-ring">
							</div>
							<?php if($VideoLink!="") { ?>
								<div class="slider-banner-image">
									<iframe src="<?php echo $VideoLink;?>" scrolling="no" frameborder="0" seamless="seamless" width="100%" height="560px"></iframe>
								</div>
							<?php } ?>
							<?php /*if($CertLink!="") { ?>
								<div class="slider-banner-image">
									<iframe src="<?php echo $CertLink;?>"></iframe>
								</div>
							<?php }*/ ?>
						</div>
						<div class="slider1 slider-nav thumb-image">
							<div class="thumbnail-image">
								<div class="thumbImg">
									<img src="<?php echo $image_url;?>" alt="ring-small-img">
								</div>
							</div>
							<?php if($VideoLink!="") { ?>
								<div class="thumbnail-image">
									<div class="thumbImg">
										<img src="<?php echo get_template_directory_uri();?>/images/Image-5.png" alt="ring-small-img">
									</div>
								</div>
							<?php } ?> 
							<?php if($CertLink!="") { ?>
								<div class="thumbnail-image" data-toggle="modal" data-target="#myModal">
									<div class="thumbImg">
										<img src="<?php echo $cert_img_url;?>" alt="ring-small-img">
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="diamond-right-details">
					<h1><?php echo get_the_title();?></h1>
					<b><?php echo $Cut;?> Cut - <?php echo $Color;?> Color - <?php echo $Clarity;?> Clarity</b>
					<div class="diamond-price"><label><?php echo ($price) ? $price_symb.$price : "Price on Request"; ?></label> <span>(Diamond  Only)</span></div>
						<div class="max-width-3001">
							<button class="btn btn-add-ring mt-2" id="placeBtn" data-toggle="modal" data-target="#exampleModalRing">SEND AN INQUIRY</button>
						</div>
						<div class="shipping-txt-btm mt-2 mt-md-4">
							Free Shipping & 30 Day Returns On U.S Orders <br>
							<label>Delivery Time:</label> <?php echo $shipdays;?> days From Order Date <br>
							<span>(EXPECT SHIPPING DELAYS DUE TO COVID-19)</span>
						</div>
						<div class="max-width-3001">
							<div class="contact-info details_contact_info d-none d-sm-none d-md-block">
								<div class="top-inner-left d-flex justify-content-between">
									<a href="tel:646-415-8007">
										<i class="fa fa-phone" aria-hidden="true"></i>646-415-8007
									</a>
									<a href="mailto:info@barediamond.com">
										<i class="fa fa-envelope" aria-hidden="true"></i>Email
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="diamond-detail-wrapper diamond_details_row">
						<div class="container">
							<div class="row">
								<h2 class="col-sm-12 color-a93f3f details_heading">Product Details</h2>
								<div class="col-sm-12">
									<div class="engangement-ring-dtl-wrapper row">
										<div class="engangement-ring-dtl-row">
											<label>Stock Number</label>
											<span><?php echo $stockNumber; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Measurements</label>
											<span><?php if($Measurements!=''){echo $Measurements.' '.'mm' ; }?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Price</label>
											<span><?php echo ($price) ? $price_symb.$price : "Price on Request"; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Table</label>
											<span><?php echo $table; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Carat Weight</label>
											<span><?php echo $SizeCt; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Depth</label>
											<span><?php echo $depth; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Shape</label>
											<span><?php echo $diamondShape; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Symmetry</label>
											<span><?php echo $Symmetry; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Cut</label>
											<span><?php echo $Cut; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Polish</label>
											<span><?php echo $Polish; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Color</label>
											<span><?php echo $Color; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Girdle</label>
											<span><?php echo $Girdle; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Clarity</label>
											<span><?php echo $Clarity; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Culet</label>
											<span><?php echo $Culet; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Fluorescence</label>
											<span><?php echo $Fluorescence; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>L/W Ratio</label>
											<span><?php echo $LWRatio; ?></span>
										</div>
										<div class="engangement-ring-dtl-row">
											<label>Certificate No</label>
											<span><?php echo $certificate_num; ?></span>
										</div>
									</div>
								</div>
								<!-- <div class="col-sm-12 m-plr-0">
									<div data-toggle="modal" class="diamond-certificate minus-mt-50" data-target="#myModal" style="cursor: pointer;">
										<img src="<?php echo $cert_sample_img_url;?>" class="img-fluid" alt="diamond certificate" title="View Certificate">
									</div>
								</div> -->
								<!-- Modal for certificate -->
								<div id="myModal" class="modal certificate-modal fade show" role="dialog" style="padding-right: 16px; display: none;">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">×</button>
											</div>
											<div class="modal-body">
												<div class="text-center mb-3">
													<img src="<?php echo get_template_directory_uri();?>/images/logo.png">
												</div>
												<iframe src="<?php echo $CertLink;?>" width="100%" height="100%"></iframe>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>   
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--get instagram fedd-->
<?php echo do_shortcode('[instagram-feed]');?>
	<div class="modal fade place-order-popup-wrapper mt-md-5" id="exampleModalRing" tabindex="-1" role="dialog" aria-labelledby="exampleModalRingLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-title" id="exampleModalRingLabel">Place An Order For <?php echo $get_the_title;?></div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="place-order-popup">
				<input type="hidden" name="product_title" id="product_title" value="<?php echo $title;?>" />
				<input type="hidden" name="product_url" id="product_url" value="<?php echo $product_url;?>" />
               
				<?php echo do_shortcode('[contact-form-7 id="210" title="Place Order"]');?>
              </div>
            </div>
              <!--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>-->
          </div>
        </div>
      </div>
<script>
jQuery(document).ready(function(){
	jQuery("#placeBtn").click(function(){
		var product = jQuery('#product_title').val();
		jQuery("input[name=product-name]").val(product);
		jQuery("input[name=sku]").val("s12345");
	});
});
</script>
<?php get_footer(); ?>