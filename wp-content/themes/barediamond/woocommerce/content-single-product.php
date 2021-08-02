<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$parent_cat = get_parent_category_by_product_id($product->get_id());
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

<div class="barediamond-details-page global_er_wr_jewelry">
        <div class="container">
          <div class="row">
          	<?php 

			$product_id = get_the_ID();
			$product_url = get_the_permalink();
		    global $table_prefix, $wpdb;
		    $table_name = 'custom_prodmeta';
		    $table_name = $table_prefix . "$table_name";
		    $shape_default = $wpdb->get_results("SELECT prodmeta_ship_days, prodmeta_shape_default, prodmeta_videoURL  FROM $table_name WHERE product_id = '".$product_id."' AND status = 'active' ");

		  $shape = $shape_default[0]->prodmeta_shape_default ;

			$ship_days = $shape_default[0]->prodmeta_ship_days ;
			if(empty($ship_days)){
				$ship_days = "2";
			}

		    $table_name = 'custom_prodattrmeta';
		    $table_name = $table_prefix . "$table_name";
		    $shape_img = '';
		    $default_color = array('whitegold_platinum', 'rosegold', 'yellowgold', 'whitegold_yellow', 'whitegold_rose');

			    if (strpos(basename($_SERVER['REQUEST_URI']), '14k-rose-gold') !== false) {
              $metal_val = 'rosegold';
              $metal_color = '14k-rose-gold';
              $metal_name = '14K Rose Gold';
          } else if (strpos(basename($_SERVER['REQUEST_URI']), '18k-rose-gold') !== false) {
              $metal_val = 'rosegold';  
              $metal_color = '18k-rose-gold';
              $metal_name = '18K Rose Gold'; 
          } else if (strpos(basename($_SERVER['REQUEST_URI']), '14k-yellow-gold') !== false) {
              $metal_val = 'yellowgold';  
              $metal_color = '14k-yellow-gold';
              $metal_name = '14K Yellow Gold';  
          } else if (strpos(basename($_SERVER['REQUEST_URI']), '18k-yellow-gold') !== false) {
              $metal_val = 'yellowgold';  
              $metal_color = '18k-yellow-gold';
              $metal_name = '18K Yellow Gold';  
          } else if (strpos(basename($_SERVER['REQUEST_URI']), '14k-white-gold') !== false) {
               $metal_val = 'whitegold';
              $metal_color = '14k-white-gold'; 
              $metal_name = '14K White Gold';   
          } else if (strpos(basename($_SERVER['REQUEST_URI']), '18k-white-gold') !== false) {
              $metal_val = 'whitegold';
              $metal_color = '18k-white-gold'; 
              $metal_name = '18K White Gold';         
          } else if (strpos(basename($_SERVER['REQUEST_URI']), 'platinum') !== false) {
              $metal_val = 'platinum';  
              $metal_color = 'platinum'; 
              $metal_name = 'Platinum'; 
          } else {

              $metal_val = 'whitegold';
              $metal_color = '14k-white-gold'; 
              $metal_name = '14K White Gold';

          }    

         if(in_array($metal_val, $default_color))
          $default_color = array($metal_val);
        else if(in_array($metal_color, $default_color))
          $default_color = array($metal_color); 
          
		    $shape_all_img = array();


		    foreach ( $default_color as $val ) 
		    {

		    	$default_img_name = 'attr_'.$val.'_'.strtolower($shape).'_default_img';
		    	$img_name = 'attr_'.$val.'_'.strtolower($shape).'_img';

				$shape_img = $wpdb->get_results("SELECT $default_img_name, $img_name  FROM $table_name WHERE product_id = '".$product_id."' AND status = 'active' "); 

				if( $shape_img[0]->$default_img_name || $shape_img[0]->$img_name) 
				{
										
					$shape_all_img[] = $shape_img[0]->$default_img_name;

					if( $shape_img[0]->$img_name )
					{

						$shape_img = explode(',', $shape_img[0]->$img_name) ;
						$shape_all_img = array_merge($shape_all_img, $shape_img);

					}

					break;

				} 
				
		    }
		

		     ?>

            <div class="col-sm-6">
              <div class="vehicle-detail-banner banner-content clearfix">
                  <div class="banner-slider">
                    
                
                <div class="slider1 slider-for">

                  	<?php foreach($shape_all_img as $val) {?>
                  		<div class="slider-banner-image">
                            <img src="<?php bloginfo('url');?>/wp-content/product-images/<?php echo $val; ?>" alt="large-ring"/>
                           
                        </div> 
                    	
                	<?php } ?>  

                   <?php
                    if($shape_default[0]->prodmeta_videoURL)
                    {
                      $videolink = $shape_default[0]->prodmeta_videoURL;
                      ?>   
                      <div class="slider-banner-image">                            
                        <video width="100%" height="450" autoplay="true" loop="true" muted="true" plays-inline="">
                        <source src="<?php bloginfo('url');?>/wp-content/product-images/<?php echo $videolink?>" type="video/mp4">
                      </video>
                    </div>
                       <?php 
                    } ?>   


                 
                </div>

                <div class="slider1 slider-nav thumb-image">
                  	<?php foreach($shape_all_img as $val) {?>
                  		<div class="thumbnail-image">
                          <div class="thumbImg">
                              <img src="<?php bloginfo('url');?>/wp-content/product-images/<?php echo $val; ?>" alt="ring-small-img"/>
                          </div>
                      </div>
                    
                 	<?php }
                  
                    if($shape_default[0]->prodmeta_videoURL)
                    {
                   
                      ?>  
                      <div class="thumbnail-image">
                          <div class="thumbImg">                             
                            <img src="<?php bloginfo('url');?>/wp-content/themes/barediamond/images/Image-5.png" alt="ring-small-img"/>
                         </div>
                      </div>
                       <?php 
                    } ?>
                  </div>
                  
              </div>
            </div>
        </div>


            <div class="col-sm-6">
              <div class="diamond-right-details">
                 <h1>
                <?php $term_id = $product->get_category_ids();
                  
                    if(!empty($term_id))
                    {

                      $term = get_term($term_id[0], 'product_cat' );
                      $title = $term->name.' ';                    

                    }
                    $title .= get_the_title();
                      
                ?>
                <?php echo $title;?></h1>
                <?php if($product->get_sku()) echo '<b>SKU: '.$product->get_sku().'</b>';?>
                <?php    
                    $attributes =   wc_get_product_terms( $product->id, 'pa_eo_metal_attr', array( 'fields' => 'all' ) );
                   ?>

              

               

                <div class="justify-content-center select-metal add-diamond">
                  <h2>Choose Metal Type: <?php echo ucwords(str_replace("-"," ",$metal_color));?></h2>
                  <div class="metal-color-type">
                    <ul>
                     
                       <?php foreach ( $attributes as $val ) : 

                        $val = $val->slug;
                        $metal_color_calss = '';
                        $metal_arr = explode('-', $val);
                        
                        if($metal_arr[1])
                          $metal_color_calss .= $metal_arr[1];
                        if($metal_arr[2])
                          $metal_color_calss .= '-'.$metal_arr[2];


                        if($val=='14k-white-and-rose-gold' || $val=='18k-white-and-rose-gold')
                          $metal_color_calss = 'wrg';
                        else if($val=='14k-white-and-yellow-gold' || $val=='18k-white-and-yellow-gold')
                          $metal_color_calss = 'wyg';

                        
                        $product_url = get_the_permalink().$val;
                      ?>                  
                       <li data-value="<?php echo $val;?>"  data-url="<?php echo $product_url;?>"  class="metal-list <?php echo str_replace('gold', 'ring', trim($metal_color_calss)); echo ($metal_arr[0]=='platinum') ? ' pt' : '';   if($metal_color==$val) echo ' active';?>"><p><?php echo ($metal_arr[0]=='platinum') ? 'PT' : strtoupper($metal_arr[0]);?></p></li>
                                               
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              
                <div class="max-width-3001">
                  <button class="btn btn-add-ring mt-3" id="placeBtn" data-toggle="modal" data-target="#exampleModalRing">SEND AN INQUIRY</button>                
                </div>  

                 
                  <div class="shipping-txt-btm mt-2 mt-md-4">
                    Free Shipping & 30 Day Returns On U.S Orders <br>
                    <label>Delivery Time:</label> <?php echo $ship_days;?> days From Order Date <br>
                    <span>(EXPECT PRODUCTION & SHIPPING DELAYS DUE TO COVID-19)</span>
                </div>
                <div class="max-width-3001">
                  <!-- <div class="contact-social-icon mt-5 mb-3 mb-sm-3 mb-md-3">
                    <ul class="m-0 p-0 list-unstyled">
                      <li class="social-icon d-flex justify-content-center">
                        <a href="https://www.facebook.com/BareDiamond/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="https://www.instagram.com/thebarediamond/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>                       
                        <a href="https://twitter.com/thebarediamond" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                      </li>
                    </ul>
                  </div> -->
                  <div class="contact-info details_contact_info d-none d-sm-none d-md-block">
                    <div class="top-inner-left d-flex justify-content-between">
                      <a href="tel:646-415-8007">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        (646)-415-8007
                      </a>
                      <a href="mailto:info@barediamond.com">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        Email
                      </a>
                    </div>
                  </div>
                </div>

                <?php                

        $product_id = get_the_ID();
	    global $table_prefix, $wpdb;
	    $table_name = 'custom_prodmeta';
	    $table_name = $table_prefix . "$table_name";
	    $meta_details_arr = $wpdb->get_results("SELECT *  FROM $table_name WHERE product_id = '".$product_id."' AND status = 'active' ", ARRAY_A);


	    $meta_details = $meta_details_arr[0];
	   
      $leave_fields_arr = array('id', 'product_id', 'prodmeta_option_ringsize', 'prodmeta_showas_topring', 'prodmeta_videoURL', 'prodmeta_option_settings', 'prodmeta_shape_default', 'status', 'update_date', 'prodmeta_ship_days');

	    if(!empty( $meta_details )){ ?>	

        <div class="diamond-detail-wrapper">
          <div class="container">
            <div class="row">
              <h3 class="col-sm-12 color-a93f3f"><?php echo strtoupper(get_the_title());?> Details</h3>
                <div class="col-sm-12">
                    <div class="engangement-ring-dtl-wrapper row">
                          <?php
  
                          // $attr_arr = array('attr_14k', 'attr_18k','attr_20k', 'attr_22k', 'platinum');
                            $attr_arr = array('attr_14k', 'attr_18k');
                            $metal_available_attr = array();
                            $table_name = 'custom_prodattrmeta';
                            $table_name = $table_prefix . "$table_name";
                        
                              foreach ($attr_arr as $val)
                              {

                                  $metal_available_name = $val.'_metal_available';
                                  $shape_img = $wpdb->get_results("SELECT $metal_available_name  FROM $table_name WHERE product_id = '".$product_id."' AND status = 'active' "); 
                                  
                                  if($shape_img[0]->$metal_available_name)
                                  { ?>
                                
                                    <!-- <div class="engangement-ring-dtl-row">
                                              <label>Metal</label>
                                              <span><?php //echo $shape_img[0]->$metal_available_name; ?></span>
                                            </div> -->


                                <?php 
                                  }
                              }          

                          ?>

                          <?php 

                          $count =1;
                          foreach( $meta_details as $key => $val) {

                                if( $val && !in_array($key, $leave_fields_arr) ) {

                                  $key_name = str_replace('prodmeta_', '', $key);
                                  //$key_name = strtoupper(str_replace('_', ' ', $key_name));
                                  $key_name = ucwords(str_replace('_', ' ', $key_name));

                                ?>

                                <div class="engangement-ring-dtl-row">
                                  <label><?php echo $key_name; ?></label>
                                  <span><?php if($key=='prodmeta_side_diamonds_ctw') echo round($val,2); else echo $val;?></span>
                                </div>

                              <?php 

                              $count++; 
                            } ?>

                          <?php } ?>

                      </div>
                </div>
            </div>
          </div>
        </div>

        

    <?php } 

    if($count==1)
      echo '<style>.diamond-detail-wrapper{display:none;}</style>';
    ?>


               

              </div>
            </div>
          </div>
        </div>
      </div>


        
                 
  <!-- Modal -->
      <div class="modal fade place-order-popup-wrapper mt-md-5" id="exampleModalRing" tabindex="-1" role="dialog" aria-labelledby="exampleModalRingLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-title" id="exampleModalRingLabel">Place An Order For <?php echo $title;?></div>
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
	
</div>

<script>
jQuery(document).ready(function(){
	jQuery("#placeBtn").click(function(){
			var product = jQuery('#product_title').val();
			var product_url = jQuery('#product_url').val();
			jQuery("input[name=product-name]").val(product);
			jQuery("input[name=product-url]").val(product_url);
			jQuery("input[name=sku]").val("s12345");
		});
});
</script>

<?php do_action( 'woocommerce_after_single_product' ); ?>