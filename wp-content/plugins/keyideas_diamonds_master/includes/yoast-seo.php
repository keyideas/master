<?php 


include_once(ABSPATH.'wp-admin/includes/plugin.php');
function yoastSeoUpdate($diamond_post_id,$product_title,$description){

	global $wpdb;
	if(function_exists('is_plugin_active') ){
		if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) {
			$seo_post_id   		= $diamond_post_id; 
			$meta_key_title  	= '_yoast_wpseo_title'; 
			$meta_value_title	= $product_title; 
			$meta_key_desc  	= '_yoast_wpseo_metadesc'; 
			$meta_value_desc	= $description; 
			$meta_key_fkw  		= '_yoast_wpseo_focuskw'; 
			$meta_value_fkw		= $product_title; 

			$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value_title' WHERE post_id='$seo_post_id' AND meta_key='$meta_key_title'");
			$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value_desc' WHERE post_id='$seo_post_id' AND meta_key='$meta_key_desc'");
			$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value_fkw' WHERE post_id='$seo_post_id' AND meta_key='$meta_key_fkw'");
		}
	}
}
function getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues){
	if(function_exists('is_plugin_active') ){
		if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) {
			$seo_post_id   		= $new_diamond_id; 
			$meta_key_title  	= '_yoast_wpseo_title'; 
			$meta_value_title	= $product_title; 
			$seovalues		.= "('$seo_post_id', '$meta_key_title', '$meta_value_title'),";
			$meta_key_desc  	= '_yoast_wpseo_metadesc'; 
			$meta_value_desc	= $description; 
			$seovalues		.= "('$seo_post_id', '$meta_key_desc', '$meta_value_desc'),";
			$meta_key_fkw  		= '_yoast_wpseo_focuskw'; 
			$meta_value_fkw		= $product_title; 
			$seovalues		.= "('$seo_post_id', '$meta_key_fkw', '$meta_value_fkw'),";
			return $seovalues;
		}
	}
			
}



?>