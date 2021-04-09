<?php 



if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.

}



function diamond_importer_assets_scripts() {

    wp_register_style( 'diamond-css', plugins_url('../assets/css/diamond.css', __FILE__) );

    wp_enqueue_style( 'diamond-css' );

    wp_enqueue_script( 'diamond-js', plugins_url('../assets/js/diamond.js', __FILE__), array( 'jquery' ) );

}

define('kdmConstants', $kdmConstants);

if ( ! function_exists( 'KDM_install' ) ) {

	function KDM_install(){

		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$charset_collate = $wpdb->get_charset_collate();

		$table_kdmdiamonds = $wpdb->prefix . 'custom_kdmdiamonds';

		$sql_kdmdiamonds = "CREATE TABLE $table_kdmdiamonds (

  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,  `posts_id` int(11) NOT NULL,  `Sku` varchar(16) NOT NULL,  `Style` varchar(16) NOT NULL,  `stockNumber` varchar(20) NOT NULL,  `Image` text NOT NULL,  `ShapeCode` varchar(15) NOT NULL,  `Color` varchar(15) NOT NULL,  `Clarity` varchar(4) NOT NULL,  `Cut` varchar(15) NOT NULL,  `SizeCt` decimal(10,2) NOT NULL,  `SizeMM` decimal(10,2) NOT NULL,  `SizeMMChar` decimal(10,2) NOT NULL,  `CertType` varchar(15) NOT NULL,  `PctOffRap` decimal(10,2) NOT NULL,  `PriceCt` decimal(10,2) NOT NULL,  `PriceEach` decimal(10,2) NOT NULL,  `Polish` varchar(15) NOT NULL,  `Symmetry` varchar(15) NOT NULL,  `DepthPct` decimal(10,1) NOT NULL,  `TablePct` decimal(10,1) NOT NULL,  `Fluorescence` varchar(15) NOT NULL,  `LWRatio` decimal(10,2) NOT NULL,  `CertLink` text NOT NULL,  `Girdle` varchar(255) NOT NULL,  `VideoLink` text NOT NULL,  `Culet` varchar(64) NOT NULL,  `WholesalePrice` decimal(10,2) NOT NULL,  `DiscountWholesalePrice` decimal(10,2) NOT NULL,  `RetailPrice` decimal(10,2) NOT NULL,  `ColorRegularFancy` varchar(15) NOT NULL,  `Measurements` varchar(32) NOT NULL,  `ImageZoomEnabled` tinyint(1) NOT NULL,  `ShapeDescription` varchar(32) NOT NULL,  `vendor` varchar(4) NOT NULL,  `status` int(11) NOT NULL,  `other` text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";



		dbDelta( $sql_kdmdiamonds );

		$table_vendors = $wpdb->prefix . 'custom_kdmvendors';
		
		$sql_vendors = "CREATE TABLE $table_vendors (id int(11) NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL,vendor_code varchar(16) NOT NULL, abbreviation varchar(16) NOT NULL, shipdays int(11) NOT NULL, onect_below_price varchar(16) NOT NULL, onect_above_price varchar(16) NOT NULL,type varchar(16) NOT NULL,source varchar(16) NOT NULL, status tinyint(1) NOT NULL, PRIMARY KEY  (id)) $charset_collate;";

		dbDelta( $sql_vendors );

		$checkvendors = "SELECT vendor_code FROM ".$wpdb->prefix."custom_kdmvendors";

		$vdsrows		= $wpdb->get_results($checkvendors, ARRAY_A);

		$vendorIds = array_column($vdsrows, 'vendor_code');
		$upQGArr= [];
		$newQGArr= [];
		foreach (kdmConstants as $key => $value) {
			if(isset($value['vendor_code'])){
				$newVendorArr[] = $value['vendor_code'];
				if(!in_array($value['vendor_code'], $vendorIds)){
				$arr = array(
						'name' => $value['name'],
						'vendor_code' => $value['vendor_code'],
						'abbreviation' => strrev($value['vendor_code']),
						'shipdays' => $value['shipdays'],
						'onect_below_price' => $value['onect_below_margin_price'],
						'onect_above_price' => $value['onect_above_margin_price'],
						'type' => $value['type'],
						'source' => $value['source'],
						'status' => $value['status']
				);
				$format = array('%s','%s','%s','%d','%s','%s','%s','%s','%d');
				$wpdb->insert($table_vendors,$arr,$format);
				}
				else{
						$upVendorArr[] = $value['vendor_code'];
						$update="UPDATE ".$table_vendors." SET name='".$value['name']."',  vendor_code='".$value['vendor_code']."',  abbreviation='".strrev($value['vendor_code'])."',  shipdays='".$value['shipdays']."',  onect_below_price='".$value['onect_below_margin_price']."',  onect_above_price='".$value['onect_above_margin_price']."',  type='".$value['type']."',  source='".$value['source']."',  status='".$value['status']."' WHERE vendor_code='".$value['vendor_code']."'";
                		$wpdb->query($update); 
					}
			}
			if(isset($value['vendors'])){
				foreach ($value['vendors'] as $key => $val) {
					if($value['status'] == 1){
						$status = $val['status'];
					}else{
						$status = $value['status'];
					}
					if(!in_array($val['vendor_code'], $vendorIds)){	
						$newVendorArr[] = $val['vendor_code'];	
						$arr = array(
							'name' => $val['name'],
							'vendor_code' => $val['vendor_code'],
							'abbreviation' => strrev($val['vendor_code']),
							'shipdays' => $val['shipdays'],
							'onect_below_price' => $val['onect_below_margin_price'],
							'onect_above_price' => $val['onect_above_margin_price'],
							'type' => $value['type'],
							'source' => $value['source'],
							'status' => $status
						);
						$format = array('%s','%s','%s','%d','%s','%s','%s','%s','%d');
						$wpdb->insert($table_vendors,$arr,$format);
					}else{
						$upVendorArr[] = $val['vendor_code'];
						$update="UPDATE ".$table_vendors." SET name='".$val['name']."',  vendor_code='".$val['vendor_code']."',  abbreviation='".strrev($val['vendor_code'])."',  shipdays='".$val['shipdays']."',  onect_below_price='".$val['onect_below_margin_price']."',  onect_above_price='".$val['onect_above_margin_price']."',  type='".$value['type']."',  source='".$value['source']."',  status='".$status."' WHERE vendor_code='".$val['vendor_code']."'";
                		$wpdb->query($update); 
					}
				}
			}
		}
		//$delQGArr=array_diff($BDcheckArr,$totalQGArr);
		$totalVendorArr=array_merge($upVendorArr,$newVendorArr);
    	$delVendorArr=array_diff($vendorIds,$totalVendorArr);
    	$vendorcodes = join("','",$delVendorArr);
		//$wpdb->query("DELETE T1 FROM `".$table_vendors."` T1 WHERE T1.vendor_code IN ('".$vendorcodes."')");
	}
}


if ( ! function_exists( 'KDM_uninstall' ) ) {

	function KDM_uninstall(){
		global $wpdb;
		$table_kdmdiamonds = $wpdb->prefix . 'custom_kdmdiamonds';
		$table_vendors = $wpdb->prefix . 'custom_kdmvendors';
		/*$wpdb->query("DELETE T1, T2, T3 FROM `".$wpdb->prefix."custom_kdmdiamonds` T1 INNER JOIN ".$wpdb->prefix."postmeta T2 ON T1.posts_id = T2.post_id INNER JOIN ".$wpdb->prefix."posts T3 ON T1.posts_id = T3.ID where T1.status!='3' AND T1.status!='4'");
		$wpdb->query( "DROP TABLE IF EXISTS ".$table_kdmdiamonds );
		$wpdb->query( "DROP TABLE IF EXISTS ".$table_vendors );*/
		// Get the timestamp of the next scheduled run		
		$timestamp = wp_next_scheduled( 'kdm_vendor_update_new' );
		// Un-schedule the event
		wp_unschedule_event( $timestamp, 'kdm_vendor_update_new' );
	}
}
// CRON JOB SCHEDULING  KDM

function register_kdm_import_event_new() {

	if ( ! wp_next_scheduled( 'kdm_vendor_update_new'))   {

			wp_schedule_event( $_SERVER['REQUEST_TIME'], 'hourly', 'kdm_vendor_update_new') ;

	}

}



function register_daily_apifeeds_dump_event() {

	if ( ! wp_next_scheduled( 'kdm_daily_vendors_apifeeds'))   {

		wp_schedule_event( $_SERVER['REQUEST_TIME'], 'daily', 'kdm_daily_vendors_apifeeds') ;

	}	

}



?>