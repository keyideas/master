<?php
/*
*
* Plugin Name: Keyideas Diamonds Master
* Author URI:  www.keyideasinfotech.com
* Description: it provides easy way to import WooCommerce products into store with attributes and meta information.
* Version:     2.22
* Author:      Keyideas
* Text Domain: keyideas_diamonds_master
*
*/
$plugin_dir = basename(dirname(__FILE__));
add_action( 'init', 'keyideas_diamonds_master_init' );
function keyideas_diamonds_master_init(){
	load_plugin_textdomain( 'keyideas_diamonds_master', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
if ( ! defined( 'KDIPATH' )){
	define( 'KDIPATH', plugin_dir_path( __FILE__ ) );
}
function getUserDefinedConstants() {
	$constants = get_defined_constants(true);
	return (isset($constants['user']) ? $constants['user'] : array());
}
$constantsBeforeInclude = getUserDefinedConstants();
include_once ABSPATH.'config.php';
$constantsAfterInclude = getUserDefinedConstants();
$kdmConstants = array_diff_assoc($constantsAfterInclude, $constantsBeforeInclude);
/*if (is_admin()){*/
	if ( ! defined( 'KDILINKURL' )){
		define( 'KDILINKURL', plugins_url('keyideas-diamonds-master') );
	}
	include_once KDIPATH. '/includes/init.php';
	//include_once KDIPATH . '/includes/html/index.php';
	if ( ! function_exists( 'diamond_menu_pages' ) ) {
		function diamond_menu_pages() {
			add_menu_page( 'Keyideas Diamonds Master', __( 'Keyideas Diamonds Master', 'keyideas-diamonds-importer' ), 'manage_options', 'keyideas-diamonds-importer', 'keyideas_diamonds_importer_menu_output_function', plugins_url('/assets/images/diamond-32.png', __FILE__), 55 );
		}
	}
	if ( ! function_exists( 'keyideas_diamonds_importer_menu_output_function' ) ) {
		function keyideas_diamonds_importer_menu_output_function() {
			global $wpdb;
			ini_set('max_execution_time', '0');
			ini_set('display_errors', 0);
			include_once KDIPATH . '/includes/html/index.php';
		}
	}
	//include_once KDIPATH . '/includes/functions.php';
	include_once KDIPATH . '/includes/cron.php';
	add_action('admin_enqueue_scripts', 'diamond_importer_assets_scripts');

	//kdm Import Single Cron
	add_action( 'wp_loaded', 'register_kdm_import_event_new') ;
	add_action('kdm_vendor_update_new','custom_kdm_diamonds_import_cron');
	// add_action('init','custom_kdm_diamonds_import_cron');
	//End KDM
	add_action('admin_menu', 'diamond_menu_pages');
	register_activation_hook( __FILE__, 'KDM_install' );
	//register_activation_hook( __FILE__, 'KDM_install_data' );
	register_deactivation_hook( __FILE__, 'KDM_deactivate' );
	register_uninstall_hook( __FILE__, 'KDM_uninstall' );
/*}*/
/**
 * This is our callback function that embeds our phrase in a WP_REST_Response
 */
function get_kdm_diamonds() {
    // rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
    global $wpdb;
	ini_set('max_execution_time', '0');
	$getdiamonds="SELECT cd.*, p.post_date,p.post_content,p.post_title,p.post_excerpt,p.post_status,p.post_modified,T2.name as vendorName,T2.shipdays as shipping,T2.id as vendor,T2.vendor_code FROM ".$wpdb->prefix."custom_kdmdiamonds as cd INNER JOIN ".$wpdb->prefix."posts as p ON cd.posts_id=p.ID INNER JOIN ".$wpdb->prefix."custom_kdmvendors T2 ON cd.vendor = T2.id WHERE cd.status <> 3 AND cd.status <> 2 AND cd.Cut <> 'Good'";
	
	$diamondresults=$wpdb->get_results($getdiamonds);

	foreach ($diamondresults as $key => $result) {

		// Price
		$product_price='';	
		if(!empty($result->WholesalePrice)){
			$product_price = get_post_meta($result->posts_id, '_price', true);
		}
		$jsonArr[]=array(
							'ID' => $result->posts_id,
						    'product_name' => $result->Style,
						    'product_display_name' => $result->post_title,
						    'product_stock_number' => $result->stockNumber,
						    'product_description' => $result->post_content,
						    'product_price' => $product_price,
						    'product_price_ct' => $result->PriceCt,
						    'product_measurements' => $result->Measurements,
						    'product_certificate_url' => $result->CertLink,
						    'product_carat' => $result->SizeCt,
						    'product_video' => $result->VideoLink,
						    'product_rapnet_image' => $result->Image,
						    'product_inventoryID' => $result->Sku,
						    'product_polish' => $result->Polish,
						    'product_symmetry' => $result->Symmetry,
						    'product_depth' => number_format($result->DepthPct,1),
						    'product_girdle' => $result->Girdle,
						    'product_culet' => $result->Culet,
						    'product_dTable' => number_format($result->TablePct,1),
						    'shipping' => $result->shipping,
						    'color_title' => $result->Color,
						    'clarity_title' => $result->Clarity,
						    'cut_title' => $result->Cut,
						    'display_name' => $result->vendorName,
						    'shape_title' => $result->ShapeCode,
						    'certificate_name' => $result->CertType,
						    'vendor' => $result->vendor,
						    'vendor_code' => $result->vendor_code,
							'wholesale_price' => $result->WholesalePrice,
	  				);
	}
	//$diamonds_data = json_encode($jsonArr);
	return rest_ensure_response( $jsonArr );
}
function get_kdm_mined_diamonds() {
    // rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
    global $wpdb;
	ini_set('max_execution_time', '0');
	$getdiamonds="SELECT cd.*, p.post_date,p.post_content,p.post_title,p.post_excerpt,p.post_status,p.post_modified,T2.name, T2.vendor_code, T2.abbreviation, T2.shipdays FROM ".$wpdb->prefix."custom_kdmdiamonds as cd INNER JOIN ".$wpdb->prefix."posts as p ON cd.posts_id=p.ID INNER JOIN ".$wpdb->prefix."custom_kdmvendors T2 ON cd.vendor = T2.id WHERE cd.status <> 3 AND cd.status <> 2 AND T2.type = 'M' AND cd.Cut <> 'Good'";
	
	$diamondresults=$wpdb->get_results($getdiamonds);

	//$diamonds_data = json_encode($jsonArr);
	return rest_ensure_response( $diamondresults, ARRAY_A );
}

/**
 * This function is where we register our routes for our example endpoint.
 */
add_action( 'rest_api_init', 'get_diamond_import_list' );
function get_diamond_import_list() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'diamond/v1', '/import', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::ALLMETHODS,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'custom_kdm_diamonds_import_cron',
    ) );
}
function KDM_diamonds_feed_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'kdm/v1', '/dsfeed', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::ALLMETHODS,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'get_kdm_diamonds',
    ) );
}
add_action( 'rest_api_init', 'KDM_diamonds_feed_routes' );

function KDM_mined_diamonds_feed_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'kdm/v1', '/dsfeed_mined', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::ALLMETHODS,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'get_kdm_mined_diamonds',
    ) );
}
add_action( 'rest_api_init', 'KDM_mined_diamonds_feed_routes' );
/**
 * Diamond details API.
 */
if ( ! defined( 'KDIAPATH' )){
	    define( 'KDIAPATH', plugin_dir_path( __FILE__ ) );
	}
	include_once KDIAPATH . '/includes/filter_diamonds_api.php';
function get_diamond_details_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'diamond/v1', '/details(?:/(?P<id>\d+))?', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::ALLMETHODS,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'getDiamondDetailsByPostID',
    ) );
}
add_action( 'rest_api_init', 'get_diamond_details_routes' );
function get_diamond_list_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'diamond/v1', '/list', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::ALLMETHODS,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'getDiamondsListingBycondition',
    ) );
}
add_action( 'rest_api_init', 'get_diamond_list_routes' );

function get_similar_diamond_list() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'diamond/v1', '/similar_diamonds', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::ALLMETHODS,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'getSimilarDiamonds',
    ) );
}
add_action( 'rest_api_init', 'get_similar_diamond_list' );


function get_filter_data() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'diamond/v1', '/filterdata', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::ALLMETHODS,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'getFilterData',
    ) );
}
add_action( 'rest_api_init', 'get_filter_data' );
/**
 * This is our callback function that embeds our phrase in a WP_REST_Response
 */
function KDM_download_rc_csv() {
	global $wpdb;
	//die('I am here...');
	$date = date("j-M-Y");
	$data=array('Id,URL,ImagesURL,VideosURL,CertificateLab,CertificateURL,CertificateID,Price,Shape,Carat,Cut,Color,Clarity,Fluorescence,Polish,Symmetry,TableWidth,TableWidthPercentage,Girdle Thin,Girdle Thick,GirdleThickness,GirdleDiameter,Culet,CuletSize,CuletAngle,CrownHeight,CrownHeightPercentage,CrownAngle,PavilionDepth,PavilionDepthPercentage,PavilionAngle,DepthPercentage,LengthToWidthRatio,Measurements,GirdleToTableDistance,StarLength,StarLengthPercentage,GirdleToCuletDistance,LowerHalfLength,LowerHalfLengthPercentage,ShippingDays,WirePrice,Eye Clean,Lab Grown,Availability,Country,State,City');
		$fp = fopen('php://memory', 'w');
		foreach ($data as $line) {
			$val = explode(",", $line);
			fputcsv($fp, $val, ",");
		}
	$getdiamonds="SELECT cd.*, p.post_date,p.post_content,p.post_title,p.post_excerpt,p.post_status,p.post_modified,
				  p.post_name FROM ".$wpdb->prefix."custom_kdmdiamonds as cd INNER JOIN ".$wpdb->prefix."posts as p ON 
				  cd.posts_id=p.ID WHERE cd.status <> 4";
	$diamondresults=$wpdb->get_results($getdiamonds);
	$i=0;
	foreach ($diamondresults as $key => $diamond) {
        $Id							=  $diamond->Style;
		$URL						=  site_url().'/product/'.$diamond->post_name;
		$ImagesURL					=  $diamond->Image;
		$VideosURL					=  $diamond->VideoLink;
		$CertificateLab				=  $diamond->CertType;
		$CertificateURL				=  $diamond->CertLink;
		$CertificateID				=  '';
		$Price						=  $diamond->WholesalePrice;
		$Shape						=  $diamond->ShapeCode;
		$Carat						=  $diamond->SizeCt;
		$Cut						=  $diamond->Cut;
		$Color						=  $diamond->Color;
		$Clarity					=  $diamond->Clarity;
		$Fluorescence				=  $diamond->Fluorescence;
		$Polish						=  $diamond->Polish;
		$Symmetry					=  $diamond->Symmetry;
		$TableWidth					=  '';
		$TableWidthPercentage		=  $diamond->TablePct;
		$GirdleThin					=  '';
		$GirdleThick				=  '';
		$GirdleThickness			=  '';
		$GirdleDiameter				=  '';
		$Culet						=  '';
		$CuletSize					=  '';
		$CuletAngle					=  '';
		$CrownHeight				=  '';
		$CrownHeightPercentage		=  '';
		$CrownAngle					=  '';
		$PavilionDepth				=  '';
		$PavilionDepthPercentage	=  '';
		$PavilionAngle				=  '';
		$DepthPercentage			=  $diamond->DepthPct;
		$LengthToWidthRatio			=  '';
		$Measurements				=  $diamond->Measurements;
		$GirdleToTableDistance		=  '';
		$StarLength					=  '';
		$StarLengthPercentage		=  '';
		$GirdleToCuletDistance		=  '';
		$LowerHalfLength			=  '';
		$LowerHalfLengthPercentage	=  '';
		$ShippingDays				=  '3';
		$WirePrice					=  '';
		$EyeClean					=  '';
		$LabGrown					=  'Yes';
		$Availability				=  'Y';
		$Country					=  '';
		$State						=  '';
		$City						=  '';
    	$val=[
				'0' => (!empty($Id)?str_replace(","," ",trim($Id)):""),
				'1' => (!empty($URL)?str_replace(","," ",trim($URL)):""),
				'2' => (!empty($ImagesURL)?str_replace(","," ",trim($ImagesURL)):""),
				'3' => (!empty($VideosURL)?str_replace(","," ",trim($VideosURL)):""),
				'4' => (!empty($CertificateLab)?str_replace(","," ",trim($CertificateLab)):""),
				'5' => (!empty($CertificateURL)?str_replace(","," ",trim($CertificateURL)):""),
				'6' => (!empty($CertificateID)?str_replace(","," ",trim($CertificateID)):""),
				'7' => (!empty($Price)?str_replace(","," ",trim($Price)):""),
				'8' => (!empty($Shape)?str_replace(","," ",trim($Shape)):""),
				'9' => (!empty($Carat)?str_replace(","," ",trim($Carat)):""),
				'10' => (!empty($Cut)?str_replace(","," ",trim($Cut)):""),
				'11' => (!empty($Color)?str_replace(","," ",trim($Color)):""),
				'12' => (!empty($Clarity)?str_replace(","," ",trim($Clarity)):""),
				'13' => (!empty($Fluorescence)?str_replace(","," ",trim($Fluorescence)):""),
				'14' => (!empty($Polish)?str_replace(","," ",trim($Polish)):""),
				'15' => (!empty($Symmetry)?str_replace(","," ",trim($Symmetry)):""),
				'16' => (!empty($TableWidth)?str_replace(","," ",trim($TableWidth)):""),
				'17' => (!empty($TableWidthPercentage)?str_replace(","," ",trim($TableWidthPercentage)):""),
				'18' => (!empty($GirdleThin)?str_replace(","," ",trim($GirdleThin)):""),
				'19' => (!empty($GirdleThick)?str_replace(","," ",trim($GirdleThick)):""),
				'20' => (!empty($GirdleThickness)?str_replace(","," ",trim($GirdleThickness)):""),
				'21' => (!empty($GirdleDiameter)?str_replace(","," ",trim($GirdleDiameter)):""),
				'22' => (!empty($Culet)?str_replace(","," ",trim($Culet)):""),
				'23' => (!empty($CuletSize)?str_replace(","," ",trim($CuletSize)):""),
				'24' => (!empty($CuletAngle)?str_replace(","," ",trim($CuletAngle)):""),
				'25' => (!empty($CrownHeight)?str_replace(","," ",trim($CrownHeight)):""),
				'26' => (!empty($CrownHeightPercentage)?str_replace(","," ",trim($CrownHeightPercentage)):""),
				'27' => (!empty($CrownAngle)?str_replace(","," ",trim($CrownAngle)):""),
				'28' => (!empty($PavilionDepth)?str_replace(","," ",trim($PavilionDepth)):""),
				'29' => (!empty($PavilionDepthPercentage)?str_replace(","," ",trim($PavilionDepthPercentage)):""),
				'30' => (!empty($PavilionAngle)?str_replace(","," ",trim($PavilionAngle)):""),
				'31' => (!empty($DepthPercentage)?str_replace(","," ",trim($DepthPercentage)):""),
				'32' => (!empty($LengthToWidthRatio)?str_replace(","," ",trim($LengthToWidthRatio)):""),
				'33' => (!empty($Measurements)?str_replace(","," ",trim($Measurements)):""),
				'34' => (!empty($GirdleToTableDistance)?str_replace(","," ",trim($GirdleToTableDistance)):""),
				'35' => (!empty($StarLength)?str_replace(","," ",trim($StarLength)):""),
				'36' => (!empty($StarLengthPercentage)?str_replace(","," ",trim($StarLengthPercentage)):""),
				'37' => (!empty($GirdleToCuletDistance)?str_replace(","," ",trim($GirdleToCuletDistance)):""),
				'38' => (!empty($LowerHalfLength)?str_replace(","," ",trim($LowerHalfLength)):""),
				'39' => (!empty($LowerHalfLengthPercentage)?str_replace(","," ",trim($LowerHalfLengthPercentage)):""),
				'40' => (!empty($ShippingDays)?str_replace(","," ",trim($ShippingDays)):""),
				'41' => (!empty($WirePrice)?str_replace(","," ",trim($WirePrice)):""),
				'42' => (!empty($EyeClean)?str_replace(","," ",trim($EyeClean)):""),
				'43' => (!empty($LabGrown)?str_replace(","," ",trim($LabGrown)):""),
				'44' => (!empty($Availability)?str_replace(","," ",trim($Availability)):""),
				'45' => (!empty($Country)?str_replace(","," ",trim($Country)):""),
				'46' => (!empty($State)?str_replace(","," ",trim($State)):""),
				'47' => (!empty($City)?str_replace(","," ",trim($City)):""),
			];
		
		fputcsv($fp, $val, ",");
	}
	fseek($fp, 0);
	header('Content-Encoding: UTF-8');
	header('Content-Type: application/csv; charset=UTF-8');
	$filename='NuminedDiamondInventory-'.$date.'.csv';
	header('Content-Disposition: attachment; filename="'.$filename.'";');
	fpassthru($fp);
	die();
}
 
/**
 * This function is where we register our routes for our example endpoint.
 */
function KDM_rc_feed_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'kdm/v1', '/rcfeed', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::READABLE,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'KDM_download_rc_csv',
    ) );
}
add_action( 'rest_api_init', 'KDM_rc_feed_routes' );
/**
 * This is our callback function that embeds our phrase in a WP_REST_Response
 */
function KDM_download_nu_csv() {
	global $wpdb;
	$date = date("j-M-Y");
	$data=array('Lot#,Shape,Color,Clarity,Weight,Lab,Cut Grade,Polish,Symmetry,Flouressence,CertificateNo,Length,Width,Depth,Depth%,Table%,Girdle,Culet,Desc,Origin,PricePerCt,PricePerPc,PriceCode,Certificate URL,Video Link,ImageLink,Image');
		$fp = fopen('php://memory', 'w');
		foreach ($data as $line) {
			$val = explode(",", $line);
			fputcsv($fp, $val, ",");
		}
	$getdiamonds="SELECT cd.*, p.post_date,p.post_content,p.post_title,p.post_excerpt,p.post_status,p.post_modified,
				  p.post_name,p.ID FROM ".$wpdb->prefix."custom_kdmdiamonds as cd INNER JOIN ".$wpdb->prefix."posts as p
				  ON cd.posts_id=p.ID WHERE cd.status <> 4 AND cd.vendor=";
	$diamondresults=$wpdb->get_results($getdiamonds);
	$i=0;
	foreach ($diamondresults as $key => $diamond) {
		//Polish
		if($diamond->Polish=='EX'){$product_polish='Excellent';}
		else if($diamond->Polish =='VG'){$product_polish='Very Good';}
		else if($diamond->Polish =='GD'){$product_polish='Good';}
		else if($diamond->Polish =='FR'){$product_polish='Fair';}
		else{ $product_polish=$diamond->Polish; }
		// Symmetry
		if($diamond->Symmetry=="EX"){ $product_symmetry='Excellent';}
		else if($diamond->Symmetry=="VG"){ $product_symmetry='Very Good';}
		else if($diamond->Symmetry=="GD"){ $product_symmetry='Good';}
		else if($diamond->Symmetry=="FR"){ $product_symmetry='Fair';}
		else {	$product_symmetry = $diamond->Symmetry;} 
		// Get SEO details
		/*$yoast_wpseo_focuskw	=	get_post_meta($diamond->ID, '_yoast_wpseo_focuskw', true);
		$yoast_wpseo_metadesc	=	get_post_meta($diamond->ID, '_yoast_wpseo_metadesc', true);
		$yoast_wpseo_title		=	get_post_meta($diamond->ID, '_yoast_wpseo_title', true);*/
		// Price	
		/*if($diamond->vendor==1){
			$regular_price 	= get_post_meta($diamond->ID, '_regular_price', true);
			$sale_price 	= get_post_meta($diamond->ID, '_sale_price', true);
			$price 			= get_post_meta($diamond->ID, '_price', true);
		}*/
        //$Id							=  $diamond->ID;
        $Sku						=  $diamond->Sku;
        //$post_title					=  $diamond->post_title;
        //$post_excerpt				=  $diamond->post_excerpt;
        //$post_content				=  $diamond->post_content;
        //$post_status				=  $diamond->post_status;
        //$regular_price				=  $regular_price;
        //$sale_price					=  $sale_price;
        //$price						=  $price;
        //$yoast_wpseo_focuskw		=  $yoast_wpseo_focuskw;
        //$yoast_wpseo_metadesc		=  $yoast_wpseo_metadesc;
        //$yoast_wpseo_title			=  $yoast_wpseo_title;
		//$URL						=  site_url().'/product/'.$diamond->post_name;
		$ImagesURL					=  $diamond->Image;
		$VideosURL					=  $diamond->VideoLink;
		$CertificateLab				=  $diamond->CertType;
		$CertificateURL				=  $diamond->CertLink;
		$CertificateNo				=  $diamond->Style;
		$Price						=  $diamond->WholesalePrice;
		$Shape						=  $diamond->ShapeCode;
		$Carat						=  $diamond->SizeCt;
		$Cut						=  $diamond->Cut;
		$Color						=  $diamond->Color;
		$Clarity					=  $diamond->Clarity;
		$Fluorescence				=  $diamond->Fluorescence;
		$Polish						=  $product_polish;
		$Symmetry					=  $product_symmetry;
		//$TableWidth					=  '';
		$Table_per					=  $diamond->TablePct;
		$Depth_per					=  $diamond->DepthPct;
		//$LengthToWidthRatio			=  '';
		$Measurements				=  $diamond->Measurements;
		//$ShippingDays				=  '3';
		//$Availability				=  'Y';
		$Girdle						=  $diamond->Girdle;
		$Culet						=  $diamond->Culet;
		$Desc						=  ' ';
		$Origin						=  ' ';
		$PricePerCt					=  $diamond->PriceCt;
		$PricePerPc					=  '';
		$PriceCode					=  '';
		$MeasurementsArr			=	explode('*', $Measurements);
		$Length						=  $MeasurementsArr[0];
		$Width						=  $MeasurementsArr[1];
		$Depth						=  $MeasurementsArr[2];		
    	$val=[
				'0'  => (!empty($Sku)?$Sku:""),
				'1'  => (!empty($Shape)?$Shape:""),
				'2'  => (!empty($Color)?$Color:""),
				'3'  => (!empty($Clarity)?$Clarity:""),
				'4'  => (!empty($Carat)?$Carat:""),
				'5'  => (!empty($CertificateLab)?$CertificateLab:""),
				'6'  => (!empty($Cut)?$Cut:""),
				'7'  => (!empty($Polish)?$Polish:""),
				'8'  => (!empty($Symmetry)?$Symmetry:""),
				'9'  => (!empty($Fluorescence)?$Fluorescence:""),
				'10' => (!empty($CertificateNo)?$CertificateNo:""),
				'11' => (!empty($Length)?$Length:""),
				'12' => (!empty($Width)?$Width:""),
				'13' => (!empty($Depth)?$Depth:""),
				'14' => (!empty($Depth_per)?$Depth_per:""),
				'15' => (!empty($Table_per)?$Table_per:""),
				'16' => (!empty($Girdle)?$Girdle:""),
				'17' => (!empty($Culet)?$Culet:""),
				'18' => (!empty($Desc)?$Desc:""),
				'19' => (!empty($Origin)?$Origin:""),
				'20' => (!empty($PricePerCt)?$PricePerCt:""),
				'21' => (!empty($PricePerPc)?$PricePerPc:""),
				'22' => (!empty($PriceCode)?$PriceCode:""),
				'23' => (!empty($CertificateURL)?$CertificateURL:""),
				'24' => (!empty($VideosURL)?$VideosURL:""),
				'25' => (!empty($ImagesURL)?$ImagesURL:""),
				'26' => (!empty($Image)?$Image:"")
			];
		
		fputcsv($fp, $val, ",");
	}
	fseek($fp, 0);
	header('Content-Encoding: UTF-8');
	header('Content-Type: application/csv; charset=UTF-8');
	$filename='NuminedDiamondInventory-'.$date.'.csv';
	header('Content-Disposition: attachment; filename="'.$filename.'";');
	fpassthru($fp);
	die();
}

/**
 * This function is where we register our routes for our example endpoint.
 */
function KDM_nu_feed_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'kdm/v1', '/numineddiamonds', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::READABLE,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'KDM_download_nu_csv',
	) );
}
add_action( 'rest_api_init', 'KDM_nu_feed_routes' );


/*
 * filter shortcode for diamond
 */
include_once KDIPATH . '/filter/functions.php';
// add_action('wp_enqueue_scripts', 'diamond_filter_assets_scripts');
// include 'F:/wamp64/www/numined/wp-content/plugins/keyideas_diamonds_master/filter/functions.php';
function key_filter_shortcode(){
	include_once KDIPATH . '/filter/keyideas_filter_shortcode.php';
}
add_shortcode('keyideas-filter', 'key_filter_shortcode');

/*
 * Shortcode for diamond html response
 */
function diamond_html_response($atts) {
	// $wishlist_pro_id= unserialize($atts['wishlist']);
	$perpageresult	= $atts['perpageresult'];
	$diamond_data	= $atts['data'];
	// $is_byor		= $atts['is_byor'];
	$diamond_data_result = unserialize($diamond_data);

	$result ='';
	$price_symb = get_woocommerce_currency_symbol();
	if(count($diamond_data_result) >0 ) {
		$a =0;
		foreach($diamond_data_result as $key=>$diamond_data_val) {
			$posts_id	= $diamond_data_val['posts_id'];
			$image_url 	= $diamond_data_val['Image'];
			$ShapeCode	= $diamond_data_val['ShapeCode'];
			$VideoLink	= $diamond_data_val['VideoLink'];
			if($VideoLink!="") {
				$VideoLink	= $diamond_data_val['VideoLink']."&zoomslide=0&btn=0&sr=100&s=-10&isBorderRadius=0&z=0&sv=0&sm=0";
			}
			$CertLink	= $diamond_data_val['CertLink'];
			$CertType	= $diamond_data_val['CertType'];
			$post_title = $diamond_data_val['post_title'];
			$sale_price = $diamond_data_val['salePrice'];
			$regular_price = $diamond_data_val['regularPrice'];
			if($diamond_data_val['price'] == 0) {
				$price 		= "Price on Request";
			} else {
				$price 		= $price_symb.$diamond_data_val['price'];
			}
			// $price 		= $price_symb.$diamond_data_val['price'];
			$Clarity 	= $diamond_data_val['Clarity'];
			$Color 		= $diamond_data_val['Color'];
			$Sku 		= $diamond_data_val['Sku'];
			$StockNumber= $diamond_data_val['stockNumber'];
			$SizeCt		= $diamond_data_val['SizeCt'];
			$Cut 		= $diamond_data_val['Cut'];
			$measurements = $diamond_data_val['Measurements'];
			$table 		= $diamond_data_val['TablePct'];
			$depth 		= $diamond_data_val['DepthPct'];
			$Symmetry 	= $diamond_data_val['Symmetry'];
			$Polish 	= $diamond_data_val['Polish'];
			$Girdle 	= $diamond_data_val['Girdle'];
			$Culet 		= $diamond_data_val['Culet'];
			$Fluorescence = $diamond_data_val['Fluorescence'];
			$LWRatio 	= $diamond_data_val['LWRatio'];
			$certificateNum = $diamond_data_val['Style'];
			$image_url_dummy = shape_no_images($ShapeCode);
			if($image_url=='') {
				$image_url = shape_no_images($ShapeCode);
			}
			$cert_img_url = get_cert_img($CertType);
			$product_mp4_videos = $VideoLink;
			$a++;
			$permalink 	= get_permalink($posts_id);
			$page_title = get_the_title($posts_id);
			$params = "'".$a."','".$image_url."','".$StockNumber."','".$Sku."','".$measurements."','".$price."','".$table."','".$SizeCt."','".$depth."','".$ShapeCode."','".$Symmetry."','".$Cut."','".$Polish."','".$Color."','".$Girdle."','".$Clarity."','".$Culet."','".$Fluorescence."','".$LWRatio."','".$permalink."','".$CertLink."','".$VideoLink."','".$cert_img_url."','".$certificateNum."','".$page_title."'";
			if($a==1) { $slctedRow='class="selected-row"'; } else { $slctedRow=''; }
			$result .='<tr id="tr-'.$a.'" onClick="productDesc('.$params.');" Style="cursor: pointer;">
				<td><span class="desk_shape">'.$ShapeCode.'</span> <span class="mob_shape '.$ShapeCode.'"></span></td>
				<td>'.$SizeCt.'</td>
				<td>'.$Color.'</td>
				<td>'.$Clarity.'</td>
				<td>'.$Cut.'</td>
				<td>'.$price.'</td>
				<!-- <td class="d-block d-sm-block d-md-none"><a href="" class="">View</a></td> -->
			</tr>';
		}
	} else {
		//$appointmenturl=bloginfo("url").'/schedule-appointment/';
		$result .='<tr>
			<td colspan="6"><font size="3" color="red">Can\'t find what you\'re looking for? <a href="/schedule-appointment/">Click here</a> to book a virtual appointment with a Bare Diamond Specialist!</font</td>
		</tr>';
	}
	return $result;
}
add_shortcode('DiamondReaponse', 'diamond_html_response');