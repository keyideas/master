<?php
/**
 * Template name: Diamond List
 */
get_header();
$page_id = get_the_ID();

global $post,$wpdb,$woocommerce;

$start ="";
$page = 1;
if(!empty($_GET["page"])) {
	$page = $_GET["page"];
}
require_once("pagination.class.php");
$perPage = new PerPage();

if($start < 0) {$start = 0;}
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
if (strpos($actual_link,'round') !== false) {
	$shape_name='round';
}elseif(strpos($actual_link,'princess') !== false){
	$shape_name='princess'; 
}elseif(strpos($actual_link,'cushion') !== false){
	$shape_name='cushion';
}elseif(strpos($actual_link,'emerald') !== false){
	$shape_name='emerald';
}elseif(strpos($actual_link,'pear') !== false){
	$shape_name='pear';
}elseif(strpos($actual_link,'oval') !== false){
	$shape_name='oval';
}elseif(strpos($actual_link,'radiant') !== false){
	$shape_name='radiant';
}elseif(strpos($actual_link,'asscher') !== false){
	$shape_name='asscher';
}elseif(strpos($actual_link,'marquise') !== false){
	$shape_name='marquise';
}elseif(strpos($actual_link,'heart') !== false){
	$shape_name='heart';
}else{
	if (!empty($_GET['shape'])) {
		$shape_name=$_GET['shape'];
	} else {
		$shape_name='';
	}
}
if(empty($_GET['cut'])){
	$cut_max_ct="Good,Very%20Good,Excellent,Ideal";
}else{
	$cut_max_ct = str_replace(" ","%20", $_GET['cut']);
	$cut_max_ct=$cut_max_ct;
}

if($shape_name=='')
{
	$shape_name="round,cushion,oval,radiant,emerald,pear,princess,asscher,marquise,heart";
}else{
	$shape_name =$shape_name;
}

if(empty($_GET['color'])){
	$color_max_col="L,K,J,I,H,G,F,E,D";
}else{
	$color_max_col = $_GET['color'];
}

if(empty($_GET['clarity'])) {
	$clarity_max_cal="I1,SI2,SI1,VS2,VS1,VVS2,VVS1,FL,IF";
}else{
	$clarity_max_cal =$_GET['clarity'];
}

if(empty($_GET['status'])) {
	$statuss='1';
}else{
	$statuss = $_GET['status'];
}
$result_val = filter_curl_function();

if(!empty($_GET['carat_min'])) {
	$carat_min = $_GET['carat_min'];
} else {
	$carat_min = $result_val['carat'][0]['mincarat'];
}
if(!empty($_GET['carat_max'])) {
	$carat_max = $_GET['carat_max'];
} else {
	$carat_max = $result_val['carat'][0]['maxcarat'];
}
if(!empty($_GET['price_min'])) {
	$price_min = $_GET['price_min'];
} else {
	$price_min = $result_val['price'][0]['minprice'];
}
if(!empty($_GET['price_max'])) {
	$price_max = $_GET['price_max'];
} else {
	$price_max = $result_val['price'][0]['maxprice'];
}

$price_symbol = $_GET['price_symbol'];

if(!empty($_GET['orderby'])) {
	$order_by = $_GET['orderby'];
} else {
	$order_by = "";
}

if($order_by!='' && $order_by!='publish-date') {
	$filt = explode('-',$order_by);
	$key_value = $filt[0];
	$value_ord = $filt[1];
	$order_by_data = "&".$key_value."=".$value_ord;
}else{
	$order_by_data ="";
}

if(!empty($_GET['orderby'])) {
	$mind_lg = $_GET['diamond_type'];
	$mind_lg = "&type=".$mind_lg;
}

$price_max_arr = array('2000','2500','3000','4000');
$caret_max_arr = array('0.75','1.00','1.5','2','2.5','3');

if(in_array($price_max, $price_max_arr)) {
	$order_by = 'Orderbyprice-desc';
	$order_by_data = "&Orderbyprice=desc";
}

if(in_array($carat_max, $caret_max_arr)) {
	$order_by = 'Orderbycarat-desc';
	$order_by_data = "&Orderbycarat=desc";
}

$file = get_site_url()."/wp-json/diamond/v1/list/?shape=$shape_name&color=$color_max_col&clarity=$clarity_max_cal&mincarat=$carat_min&maxcarat=$carat_max&minprice=$price_min&maxprice=$price_max&cut=$cut_max_ct$order_by_data";

$diamond_data = get_listing_api_data($file);

$totle_product = $diamond_data['Total'];
if($totle_product!=''){
	$total_diamond = $totle_product;
	$paginationlink = "?page=";
	$perpageresult = $perPage->getAllPageLinks($totle_product, $paginationlink);
	$rowcount = count($diamond_data['data']);
} else {
	$total_diamond =0;
}
$current_user_id = get_current_user_id();
?>
<style type="text/css">
.active { background-color: #EDE7E7;}
#example th { cursor: pointer; }
div#overlay.pre_loader {
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,.2);
	position: absolute;
	left: 0;
	top: 0;
	z-index: 9;
	display: none;
}
div#overlay img {
	top: 25%;
	left: 40%;
	position: absolute;
}
</style>
<div class="diamond-listing-wrapper pb-5 customize-ur-ring-wrapper">
	<div class="top-heading text-center">
		<?php echo get_the_content(); ?>
	</div>
	<?php echo do_shortcode('[keyideas-filter]'); ?>
	<div class="product-information-details mb-md-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8 custom-col-sm-8">
					<div class="row">
						<div class="product-info-tabs w-100">
							<ul class="nav nav-tabs d-flex justify-content-between">
								<li class="w-100 text-center" style="flex-basis: 100%;"><a data-toggle="tab" href="#home">Results (<span id="totalDiamond"><?php echo $total_diamond;?></span>)</a></li>
							</ul>
							<div class="tab-content">
								<div id="overlay" class="pre_loader">
									<div><img src="<?php echo get_template_directory_uri();?>/images/loading_large.gif" width="" height=""/></div>
								</div>
								<div id="home" class="tab-pane fade in active show">
									<div class="results-table table-responsive">
										<!-- <div class="ajax_result_data" id="ajax_result_data"> -->
										<table id="example" class="table mb-0 sort-by display diamond-result-table">
											<thead>
												<tr>
													<th>Shape</th>
													<th id="sortByCarat">Carat <span><i class="fa fa-caret-down" aria-hidden="true"></i></span></th>
													<th id="sortByColor">Color <span><i class="fa fa-caret-down" aria-hidden="true"></i></span></th>
													<th id="sortByClarity">Clarity <span><i class="fa fa-caret-down" aria-hidden="true"></i></span></th>
													<th id="sortByCut">Cut <span><i class="fa fa-caret-down" aria-hidden="true"></i></span></th>
													<th id="sortByPrice">Price <span><i class="fa fa-caret-down" aria-hidden="true"></i></span></th>
													<!-- <th class="d-block d-sm-block d-md-none">View</th> -->
												</tr>
											</thead>
											<tbody class="ajax_result_data" id="ajax_result_data">
												<?php
												$diamonds = serialize($diamond_data['data']);
												echo do_shortcode( "[DiamondReaponse data='".$diamonds."'  perpageresult='".$perpageresult."']" );
												?>
											</tbody>
										</table>
										<!-- </div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 custom-col-sm-4 d-none d-md-block">
					<div class="row">
						<div class="product-info-inner">
							<div id="defaultInfo">
								<h3>Product Information</h3>
								<div class="product-info-img text-center">
									<img src="<?php echo get_template_directory_uri();?>/images/diamond-hd-png.png" class="img-fluid" alt="diamond-img" style="height: 200px;">
								</div>
								<p style="padding: 0 20%; text-align: center;">Click over a diamond to see further details and shipping Information.</p>
							</div>
							<div class="product-top-info" id="diamondInfo" style="display: none;">
								<h3>Product Information</h3>
								<div class="product-top-info-inner">
									<div class="d-flex">
										<div class="product-small-info-inner text-center">
											<img src="<?php echo get_template_directory_uri();?>/images/diamond-spec.jpg" class="img-fluid" alt="diamond-spec" id="diamond-img-thumb" title="">
											<img src="<?php echo get_template_directory_uri();?>/images/Image-5.png" class="img-fluid" alt="diamond-spec" title="" certificate="<?php echo get_template_directory_uri();?>/images/Image-5.png" id="videolink">
											<img src="<?php echo get_template_directory_uri();?>/images/GIA_Logo.png" class="img-fluid" alt="diamond-spec" title="" videolink="<?php echo get_template_directory_uri();?>/images/GIA_Logo.png" id="certificatelink">
										</div>
										<div class="product-info-img text-center" id="productInfo">
											<img src="<?php echo get_template_directory_uri();?>/images/diamond-hd-png.png" class="img-fluid" alt="diamond-img" id="diamond-img-lg" title="">
										</div>
									</div>
									<div class="product-info-btn text-center mt-4">
										<button class="btn btn-ad-ring" onClick="javascript:void(0);" id="viewDiamond">View Diamond</button>
										<button class="btn btn-ad-compare" onClick="window.location.href='<?php echo get_site_url();?>/contact-us'" id="sendInquery">Send An Inquiry</button>
									</div>
									<div class="product-description">
										<h4>Product Description</h4>
										<div class="engangement-ring-dtl-wrapper">
											<div class="engangement-ring-dtl-row">
												<label>Stock Number</label>
												<span id="stockno">47539</span>
											</div>
											<!-- <div class="engangement-ring-dtl-row">
												<label>Sku</label>
												<span id="sku">Medium</span>
											</div> -->
											<div class="engangement-ring-dtl-row">
												<label>Measurements</label>
												<span id="measurements">4.36mm x 3.24mm x 2.21mm</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Price</label>
												<span id="price">$410</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Table</label>
												<span id="table">62.0%</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Carat Weight</label>
												<span id="caret">0.70</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Depth</label>
												<span id="depth">68.1%</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Shape</label>
												<span id="shape">Round</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Symmetry</label>
												<span id="symmetry">Excellent</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Cut</label>
												<span id="cut">Super Ideal</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Polish</label>
												<span id="polish">Excellent</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Color</label>
												<span id="color">D</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Girdle</label>
												<span id="girdle">Slightly Thick - Very Thick</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Clarity</label>
												<span id="clarity">VS1</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Culet</label>
												<span id="culet">None</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Fluorescence</label>
												<span id="fluorescence">None</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Length-To-Width Ratio</label>
												<span id="lwratio">1.35</span>
											</div>
											<div class="engangement-ring-dtl-row">
												<label>Certificate No</label>
												<span id="certificate_num"></span>
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
<script type="text/javascript">
/*jQuery(document).ready(function() {
	jQuery('#example').DataTable({
		"fnDrawCallback": function(oSettings) {
			if (jQuery('#example tr').length <= <?php //echo filterApi['per_page_count'];?>+1) {
				jQuery('.dataTables_paginate').hide();
			}
		},
		"bFilter": false,
		"bLengthChange": false,
		"pageLength": <?php //echo filterApi['per_page_count'];?>,
		// "bInfo": false,
		"order": [[ 3, "desc" ]]
	});
});*/

jQuery(document).ready(function() {
	jQuery("#example").DataTable({
		"bFilter": false,
		"ordering": false,
		"bLengthChange": false,
		"order": [[ 3, "desc" ]],
		"bDestroy": true,
		"bPaginate": false,
		"bInfo": false
	});
});
function productDesc(a,image,stockno,sku,measurements,price,table,caret,depth,shape,symmetry,cut,polish,color,girdle,clarity,culet,fluorescence,lwratio,viewDiamond,certificate,videolink,certificateThumb,certificateNum) {
	jQuery("#defaultInfo").css("display","none");
	jQuery("#diamondInfo").css("display","block");
	jQuery("#ajax_result_data tr").removeClass('selected-row');
	jQuery("#tr-"+a).addClass('selected-row');
	jQuery("#productInfo").html('<img src="'+image+'" class="img-fluid" alt="diamond-img" id="diamond-img-lg">');
	jQuery("#diamond-img-thumb").attr("src",image);
	if(certificate!="") {
		jQuery("#certificatelink").attr("src",certificateThumb);
		jQuery("#certificatelink").attr("certificate",certificate);
	} else {
		jQuery("#certificatelink").remove();
	}
	if(videolink!="") {
		jQuery("#videolink").attr("videolink",videolink);
	} else {
		jQuery("#videolink").remove();
	}
	jQuery("#stockno").text(stockno);
	jQuery("#sku").text(sku);
	jQuery("#measurements").text(measurements);
	jQuery("#price").text(price);
	jQuery("#table").text(table);
	jQuery("#caret").text(caret);
	jQuery("#depth").text(depth);
	jQuery("#shape").text(shape);
	jQuery("#symmetry").text(symmetry);
	jQuery("#cut").text(cut);
	jQuery("#polish").text(polish);
	jQuery("#color").text(color);
	jQuery("#girdle").text(girdle);
	jQuery("#clarity").text(clarity);
	jQuery("#culet").text(culet);
	jQuery("#fluorescence").text(fluorescence);
	jQuery("#lwratio").text(lwratio);
	if(certificateNum!="") {
		jQuery("#certificate_num").text(certificateNum);
	} else {
		jQuery("#certificate_num").parent('div').remove();
	}
	jQuery("#viewDiamond").attr("onClick","window.location.href='"+viewDiamond+"'");
}
jQuery(document).ready(function() {
	jQuery("#diamond-img-thumb").click(function(){
		var imagePath = jQuery('#diamond-img-thumb').attr('src');
		jQuery("#productInfo").html('<img src="'+imagePath+'" class="img-fluid" alt="diamond-img" id="diamond-img-lg">');
	});
	jQuery("#certificatelink").click(function(){
		var certificatelink = jQuery('#certificatelink').attr('certificate');
		jQuery("#productInfo").html('<iframe src="'+certificatelink+'" class="img-fluid"></iframe>');
	});
	jQuery("#videolink").click(function(){
		var videolink = jQuery('#videolink').attr('videolink');
		jQuery("#productInfo").html('<iframe src="'+videolink+'" class="img-fluid"></iframe>');
	});
});
</script>
<?php get_footer();?>