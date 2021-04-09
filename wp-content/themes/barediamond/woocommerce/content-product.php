<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<div class="col-6 col-sm-3 mb-3 p-0 px-md-3">
    <div class="best-seller-col w-100">
		<?php 
			/*
			$available_variations = $product->get_available_variations();
		    $selectedPrice = '';
		    
		    foreach ( $available_variations as $variation )
		    {  

		        $isDefVariation=false;

		        foreach( $product->get_default_attributes() as $key=>$val )
		        {
		            
		            if( $variation['attributes']['attribute_'.$key] == $val )
		            {

		                $isDefVariation=true;

		            }   
		        }

		        if( $isDefVariation )
		        {
		        	
		            $price = $variation['display_price']; 
		            

		        }
		    }

		    $selectedPrice = wc_price($price);
			*/
			
		    $product_id = get_the_ID();
		    global $table_prefix, $wpdb;
		    $table_name = 'custom_prodmeta';
		    $table_name = $table_prefix . "$table_name";
		    $shape_default = $wpdb->get_results("SELECT prodmeta_shape_default  FROM $table_name WHERE product_id = '".$product_id."' AND status = 'active' ");

		    $shape = $shape_default[0]->prodmeta_shape_default ;

		    


		    $table_name = 'custom_prodattrmeta';
		    $table_name = $table_prefix . "$table_name";

		    $default_color = array('whitegold_platinum', 'rosegold', 'yellowgold', 'whitegold_yellow', 'whitegold_rose');

		    foreach ( $default_color as $val ) 
		    {
		    	$default_img_name = 'attr_'.$val.'_'.strtolower($shape).'_default_img';
				$shape_default_img = $wpdb->get_results("SELECT $default_img_name  FROM $table_name WHERE product_id = '".$product_id."' AND status = 'active' "); 

				if($shape_default_img[0]->$default_img_name) 
				{

					$shape_img = $shape_default_img[0]->$default_img_name ;
					break;

				} 
				
		    }
		  


		?>	
	  <?php if ( $shape_img ) { ?>

	  	<a href="<?php the_permalink();?>"><img src="<?php bloginfo('url');?>/wp-content/product-images/<?php echo $shape_img;?>"  class="img-fluid" alt="<?php the_title(); ?>" /></a>

	  <?php } ?>

	  <div class="slider-img-caption">
	    <a href="<?php the_permalink();?>"><label><?php the_title(); ?></label> </a> 
	    <!-- 
	    <?php if( $price ) { ?>
		    <div class="product_price">
		      <span class="Price-amount">
		        <?php echo $selectedPrice; ?>
		      </span>
		    </div>
		<?php  } ?>

	   -->
	  </div>

	</div>
</div>
