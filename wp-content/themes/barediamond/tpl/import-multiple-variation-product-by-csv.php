<?php 
/*

Template Name: Import multiple Variation Product by CSV


*/



  get_header();

  if ( isset($_FILES["csv"]["size"]) ) {

      $file = $_FILES["csv"]["tmp_name"];
      $handle = fopen($file,"r");
      $row = 1;
      $fields_name = array();
      $fields_meta_name = array();
      $fields_attr_name = array();
      $product_data = array();

      while ( ( $data = fgetcsv ( $handle ) ) !== FALSE ) {

            $num = count ( $data );
            
            if ( $row == 1 ) { 


              //$fields_name = array_values($data);
  
             
                for ( $i=0; $i < $num; $i++ ) {
                    
                    if ( strncmp( "prodmeta_", $data[$i], 8 ) == 0 ) {

                        $fields_meta_name[$i] = $data[$i]; 

                    }                     

                    if ( strncmp ( "attr_", $data[$i], 5 ) == 0 ) {

                        $fields_attr_name[ $i ] = $data[ $i ]; 

                    }

                    $fields_name[ $i ] = $data[ $i ]; 
                    
                }

                global $table_prefix, $wpdb;

                /*create nu_productcustmeta table for prodmeta data  start*/

                $tblname = 'custom_prodmeta';
                $wp_track_table = $table_prefix . "$tblname";

                require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );  

                if ( $wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table ) {

                    $sql  = "CREATE TABLE `".$wp_track_table."`(";
                    $sql .= "  `id`  int(12) NOT NULL auto_increment, ";
                    $sql .= "  `product_id`  int NOT NULL, ";

                    if ( count( $fields_meta_name ) ) {

                      foreach ( $fields_meta_name as $key => $value ) {  

                        if ( $value ) {

                          $sql .= "  `$value` varchar(300) NOT NULL, ";

                        }                           

                      }

                    } 

                    $sql .= "  `status`  varchar(20) NOT NULL, ";
                    $sql .= "  `update_date`  DATE, ";
                    $sql .= " PRIMARY KEY `id` (`id`) ";
                    $sql .= ");";
                         
                    dbDelta( $sql );      

                }

               /*create nu_productcustmeta table for prodmeta data  end*/  
                

               /*create nu_productattrmeta table for prodmeta data  start*/

                $tblname = 'custom_prodattrmeta';
                $wp_attr_table = $table_prefix . "$tblname";

                if ( $wpdb->get_var( "show tables like '$wp_attr_table'" ) != $wp_attr_table ) {

                    $sql = "CREATE TABLE `".$wp_attr_table."`(";
                    $sql .= "  `id`  int(12) NOT NULL auto_increment, ";
                    $sql .= "  `product_id`  int NOT NULL, ";

                    if ( count( $fields_attr_name ) ) {

                      foreach ( $fields_attr_name as $key => $value ) { 

                          if ( $value ) {

                             $sql .= "  `$value`  text NOT NULL, ";

                          }
                            
                      }

                    } 

                    $sql .= "  `status`  varchar(20) NOT NULL, ";
                    $sql .= "  `update_date`  DATE, ";
                    $sql .= " PRIMARY KEY `id` (`id`) ";
                    $sql .= "); ";


                    dbDelta( $sql );      

                }

               /*create nu_productattrmeta table for prodmeta data  end*/ 


            } else {

                if( count( $fields_name ) ) {

                  foreach( $fields_name as $key => $value ) {

                    $product_data[ $value ] = $data[ $key ];

                  }

                } 


                $sku = '';  
                $sku .= ($product_data['prod_sku']) ? $product_data['prod_sku'] : $product_data['prod_sku_old'];

                if( $product_data['prod_name'] && $sku)
                {

                 global $wpdb;

                 $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

                  if($product_id)
                    {

                       $product_data['product_id_old'] = $product_id;

                    }
                   
                    insert_update_product( $product_data, $fields_meta_name, $fields_attr_name );

                }

          }

        $row++;

      }

    fclose( $handle );

  }

?>



 

<style type="text/css">
#csv {border: 1px solid gainsboro;}
#importCsvFile{
background-color:white;
width: 100%;
height: 300px;
text-align: center;
border: 1px solid grey;
}
#importCsvFile h2{margin-bottom: 40px;margin-top: 40px;}

.bgimg {width: 100px ! important;display: inline ! important;margin-top: 0px ! important;}
</style>

 

<section id="promo"><div class="contentpane">
<article>
<?php if($row>1) echo $row. "products have been imported"; ?>
<div id="importCsvFile">
<form action="" method="post" enctype="multipart/form-data" name="form" id="form1">
<h2>Import Product csv file</h2>
<input accept="csv" name="csv" type="file" id="csv" />
<input type="submit" name="Submit" class="bgimg"/><br />

</form>
</div>

</article>

 
 

</div>
</section>

<?php

function insert_update_product ($product_data,$fields_meta_name,$fields_attr_name)  
{
  
  
  if($product_data['product_id_old']){

      $product_id = $product_data['product_id_old'];


      if (!$product_id) // If there is no post id something has gone wrong so don't proceed
      {
          return false;
      }

      $time = current_time('mysql');

      $post = array( 
          'ID'            => $product_id,  
          'post_author'   => 1,
          'post_content'  => $product_data['prod_long_desc'],
          "post_excerpt"  => $product_data['prod_short_desc'],
          'post_status'   => 'publish',
          'post_title'    => $product_data['prod_name'],
          'post_date'     => $time,
          'post_date_gmt' => get_gmt_from_date( $time ),        
      );

      wp_update_post($post); // Insert the post returning the new post id
      $product = new WC_Product_Variable($product_id);
      $product->save();

     

  } 
  else 
  {

    $post = array( 

        'post_author'  => 1,
        'post_content' => $product_data['prod_long_desc'],
        "post_excerpt" => $product_data['prod_short_desc'],
        'post_status'  => 'publish',
        'post_title'   => $product_data['prod_name'],
        'post_parent'  => '',
        'post_type'    => 'product',
    );


    $product_id = wp_insert_post($post); // Insert the post returning the new post id
    $product = new WC_Product_Variable($product_id);
    $product->save();


    if (!$product_id) // If there is no post id something has gone wrong so don't proceed
    {

        return false;

    }


  }  
    


    update_post_meta( $product_id, "_stock_status", "instock");

    $sku = '';

    if( $product_data['prod_sku'] )
    {

      $sku = $product_data['prod_sku'];

    }
    else
    {

      $sku = $product_data['prod_sku_old'];

    }

    if($product_id && $product_data['prodmeta_meta_title'])
    {

       $description = ($product_data['prodmeta_meta_desc']) ? $product_data['prodmeta_meta_desc'] : '';
       yoastSeoUpdates($product_id, $product_data['prodmeta_meta_title'], $description);

    }
   

    update_post_meta( $product_id, "_sku", $sku);
    update_post_meta( $product_id, "_tax_status", "taxable" );
    update_post_meta( $product_id, "_manage_stock", "yes" );
    update_post_meta( $product_id, "_stock", 10000 );
    update_post_meta( $product_id, "_stock_status", 'instock' );
    

    /* Store the prodmeta data in other table nu_productcustmeta start*/
   
    if(count( $fields_meta_name ))
    {

      $postCustMetaArr = array();
      $postCustMetaArr['product_id'] = $product_id;

      foreach ($fields_meta_name as $key=>$value)
      {


        if(!$product_data['product_id_old'])
        {

            if($product_data[$value])
            {

              $postCustMetaArr[$value] = esc_sql($product_data[$value]); 

            }

        } 
        else
        {

            $postCustMetaArr[$value] = esc_sql($product_data[$value]); 

        }
                          
             
      }



       global $table_prefix, $wpdb;
       $table_name = $wpdb->prefix . "custom_prodmeta";
       $current_date = date('Y-m-d');
       $postCustMetaArr['status'] = 'active';  
       $postCustMetaArr['update_date'] = $current_date; 
     
       if($product_data['product_id_old'])
       {

        
         $wpdb->update( $table_name, $postCustMetaArr, array( 'product_id' => $product_id )  );

       }
       else
       { 

         $wpdb->insert($table_name, $postCustMetaArr);

       } 
      
     

    } 

   /* Store the prodmeta data in other table nu_productcustmeta end*/


    /* Store the attr data in other table nu_productattrmeta start*/
   
    if(count($fields_attr_name)){

      $postCustAttrArr = array();
      $postCustAttrArr['product_id'] = $product_id;
      foreach ($fields_attr_name as $key=>$value)
      {        
          
          if(!$product_data['product_id_old'])
          {

              if($product_data[$value])
              {

                $postCustAttrArr[$value] = esc_sql($product_data[$value]);

              }

          } 
          else
          {

             $postCustAttrArr[$value] = esc_sql($product_data[$value]);

          }
              
      }

       global $table_prefix, $wpdb;
       $table_name = $wpdb->prefix . "custom_prodattrmeta";
       $current_date = date('Y-m-d');
       $postCustAttrArr['status'] = 'active';  
       $postCustAttrArr['update_date'] = $current_date; 


       if($product_data['product_id_old'])
       {

        $wpdb->update($table_name, $postCustAttrArr, array( 'product_id' => $product_id ) );

       }
       else
       {

         $wpdb->insert($table_name, $postCustAttrArr);

       } 
     
      
     
    } 
     
   /* Store the attr data in other table nu_productattrmeta end*/

  
    if($product_data['prod_type'])
        create_category($product_id, $product_data);


   
    

    
    wp_set_object_terms($product_id, 'variable', 'product_type'); // Set it to a variable product type



    $available_attributes = array( "eo_metal_attr");
    $variations = array();
    $attr_val = '';
    $attr_common ='';
   

  
     //$attr_arr = array('attr_14k', 'attr_18k','attr_20k', 'attr_22k', 'platinum');
     $attr_arr = array('attr_14k');
     $metal_available_attr = array();
     $ta = 0;
      foreach ($attr_arr as $val)
       {

          $metal_available_name = $val.'_metal_available';
          
          $attr_name = str_replace('attr_', '', $val);  
         
          if($product_data[$metal_available_name]){

              $meta_available_arr = explode(',', $product_data[$metal_available_name]);                

              foreach ($meta_available_arr as $value)
               {
                
                  $attr_val = $attr_name.'-'.strtolower(str_replace(' ', '-', trim($value)));

                  $metal_available_attr[$val.'__'.$ta++] = str_replace('--', '-', $attr_val);

              }

          }

       }

       
       
      
    //  $attr_arr = array('attr_14k', 'attr_18k', 'platinum');
       if( count( $metal_available_attr ) ) 
       {

         $attr_name =  '';
         $count = 1; 
        $metal_available_attr =  array_unique($metal_available_attr);


        foreach ($metal_available_attr as $key => $val)
         {

          $attr_key_arr = explode('__', $key);

          $attr_name = str_replace('attr_', '', $val);
          $variation_regular = $attr_key_arr[0].'_regular';
          $variation_sale = $attr_key_arr[0].'_sale';

          if( $product_data[$variation_regular] || $attr_name )
          {

             $regular_price  = $product_data[$variation_regular];           
             $sale_price  = ($product_data[$variation_sale])? $product_data[$variation_sale]: '';          
             $variations[] = array("attributes" => array(
                      "eo_metal_attr"  => $attr_name,                   
                  ),
                  "regular_price" => $regular_price,
                  "sale_price"    => $sale_price,
                  
              ); 


              // Set default vaiation 
             if( $count==1 )
             {

                $new_defaults = array('pa_eo_metal_attr'=>'18k-white-gold'); 
                update_post_meta($product_id, '_default_attributes', $new_defaults);
                $count++;
             }


              if($product_data['product_id_old'])
              {

                $product = wc_get_product( $product_id );
               
                $child_variations = $product->get_children();
                
                // check if variation exists then delete it
              
                if(!empty($child_variations))
                 { 

                  foreach ($child_variations as $val)
                   {
                    
                    wp_trash_post( $val );                  

                   }

                }

              }

            

            } 

          }

          insert_product_attributes($product_id, $available_attributes,$variations); // Add attributes passing the new post id, attributes & variations
          insert_product_variations($product, $product_id, $variations); // Insert variations passing the new 

        }
     
}


function insert_product_attributes ($product_id, $available_attributes, $variations)  
{

  
    if(!empty( $available_attributes ))
    {

      foreach ($available_attributes as $attribute) // Go through each attribute
      { 

          $values = array(); 

          if(!empty( $variations ))
          {
            foreach ( $variations as $variation ) 

            {
                $attribute_keys = array_keys($variation['attributes']); 

                foreach ( $attribute_keys as $key ) 
                {

                    if ($key === $attribute) 
                    {

                        $values[] = $variation['attributes'][$key];

                    }

                }

            }

          }         

          $values = array_unique($values); // Filter out duplicate values

          // Store the values to the attribute on the new post, for example without variables:
          // wp_set_object_terms(23, array('small', 'medium', 'large'), 'pa_size');
          wp_set_object_terms($product_id, $values, 'pa_' . $attribute);
      }

    }

    $product_attributes_data = array(); // Setup array to hold our product attributes data


    if(!empty($available_attributes))
    {

       foreach ($available_attributes as $attribute) // Loop round each attribute
        {
            $product_attributes_data['pa_'.$attribute] = array( // Set this attributes array to a key to using the prefix 'pa'

                'name'         => 'pa_'.$attribute,
                'value'        => '',
                'is_visible'   => '1',
                'is_variation' => '1',
                'is_taxonomy'  => '1'

            );
        }

    }
   

    update_post_meta($product_id, '_product_attributes', $product_attributes_data); // Attach the above array to the new posts meta data key '_product_attributes'
}


function insert_product_variations ( $product,$product_id, $variations)  
{

  
    if(!empty($variations))
    {

      foreach ($variations as $index => $variation)
      {

          $variation_post = array( // Setup the post data for the variation

              'post_title'  => 'Variation #'.$index.' of '.count($variations).' for product#'. $product_id,
              'post_name'   => 'product-'.$product_id.'-variation-'.$index,
              'post_status' => 'publish',
              'post_parent' => $product_id,
              'post_type'   => 'product_variation',
              'guid'        => home_url() . '/?product_variation=product-' . $product_id . '-variation-' . $index
          );

          $variation_product_id = wp_insert_post($variation_post); // Insert the variation


          foreach ($variation['attributes'] as $attribute => $value) // Loop through the variations attributes
          {   

              $attribute_term = get_term_by('slug', $value, 'pa_'.$attribute); // We need to insert the slug not the name into the variation post meta

              update_post_meta($variation_product_id, 'attribute_pa_'.$attribute, $attribute_term->slug);
            // Again without variables: update_post_meta(25, 'attribute_pa_size', 'small')

          }


         
          $price = ($variation['sale_price']) ? $variation['sale_price'] : $variation['regular_price'];
          add_post_meta($product_id, 'price_'.$attribute_term->slug, $price);
          add_post_meta($product_id, '_price', $price);           
          update_post_meta($variation_product_id, '_price', $variation['regular_price']);               
          update_post_meta($variation_product_id, '_regular_price', $variation['regular_price']);
          update_post_meta($variation_product_id, '_sale_price', $variation['sale_price']);

      }

    }  

   
    

}





       
  function getImage($product, $postId,$thumb_url,$imageDescription){
        // add these to work add image function


        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $tmp = download_url($thumb_url);
        preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
        $file_array['name'] = basename($matches[0]);
        $file_array['tmp_name'] = $tmp;
        // If error storing temporarily, unlink
        $logtxt = '';
        if (is_wp_error($tmp)) {
        @unlink($file_array['tmp_name']);
        $file_array['tmp_name'] = '';
        return;
        }else{
        $logtxt .= "download_url: $tmp\n";
        }

        //use media_handle_sideload to upload img:
        $thumbid = media_handle_sideload( $file_array, $postId, $imageName ); //'gallery desc'


        // If error storing permanently, unlink
        if (is_wp_error($thumbid)) {
        @unlink($file_array['tmp_name']);
        $thumbid = (string)$thumbid;
        $logtxt .= "Error: media_handle_sideload error - $thumbid\n";
        }else{
        $logtxt .= "ThumbID: $thumbid\n";
        }
        set_post_thumbnail($postId, $thumbid);
        update_post_meta($postId,'variation_image_gallery', $thumbid);
        $gallery = array($thumbid);
        $product->set_gallery_image_ids($gallery);
}


function create_category($product_id, $product_data){
    
  
      $categoryID = array(); 

      $parent_cat_name = '';
      if($product_data['prod_type'])
      {

          $cat_val = $product_data['prod_type'];
          // replace non letter or digits by -
          $parent_cat_name = preg_replace('~[^\pL\d]+~u', '-', $cat_val);

          // transliterate
          $parent_cat_name = iconv('utf-8', 'us-ascii//TRANSLIT', $parent_cat_name);

          // remove unwanted characters
          $parent_cat_name = preg_replace('~[^-\w]+~', '', $parent_cat_name);

          // trim
          $parent_cat_name = trim($parent_cat_name, '-');

           // remove space
          $parent_cat_name = str_replace(' ', '-', $parent_cat_name);

          // remove duplicate -
          $parent_cat_name = preg_replace('~-+~', '-', $parent_cat_name);

          // lowercase
          $parent_cat_name = strtolower($parent_cat_name);

          $term = term_exists( $cat_val, 'product_cat' );

          if ( $term !== 0 && $term !== null )
          {
              $term = get_term_by('slug', $parent_cat_name, 'product_cat');
              $categoryID[] = $term->term_id;
              $parent_cat_id = $term->term_id;
          }

      }

      if($product_data['prodmeta_styles'])
      {
        
        $cat_styles = $product_data['prodmeta_styles']; 
        $category_arr = explode(',',$cat_styles);

        foreach( $category_arr as $value )
        {

             
            $cat_val = $value;
            // replace non letter or digits by -
            $cat_name = preg_replace('~[^\pL\d]+~u', '-', $cat_val);

            // transliterate
            $cat_name = iconv('utf-8', 'us-ascii//TRANSLIT', $cat_name);

            // remove unwanted characters
            $cat_name = preg_replace('~[^-\w]+~', '', $cat_name);

            // trim
            $cat_name = trim($cat_name, '-');

             // remove space
            $cat_name = str_replace(' ', '-', $cat_name);

            // remove duplicate -
            $cat_name = preg_replace('~-+~', '-', $cat_name);

            // lowercase
            $cat_name = strtolower($cat_name);

            $child_cat = $cat_name.'-'.$parent_cat_name; 
            $term =  get_term_by('slug', $child_cat, 'product_cat');

            if ( $term->term_id )
            {

                if($parent_cat_name)
                {

                                   
                  $term = get_term_by('slug', $child_cat, 'product_cat'); 

                } 
                else
                {

                  $term = get_term_by('slug', $cat_name, 'product_cat');

                }

                $categoryID[] = $term->term_id;  

                
            }
            else
            {

              if($parent_cat_name)
                {

                  $child_cat = $cat_name.'-'.$parent_cat_name;                 
                  $term = wp_insert_term(
                        $value, // category name
                        'product_cat', // taxonomy
                        array(                                
                            'slug' => $child_cat, // optional
                            'parent' => $parent_cat_id, // set it as a sub-category
                        )
                    );

                } 
                else
                {

                  $term = wp_insert_term(
                        $value, // category name
                        'product_cat', // taxonomy
                        array(                                
                            'slug' => $cat_name, // optional                            
                        )
                    );

                }

                $categoryID[] = $term['term_id'];  
               
            }            

        }
        

      }   

      wp_set_object_terms($product_id,  $categoryID, 'product_cat'); // Set up its categories
   
  }  

function yoastSeoUpdates($product_post_id,$product_title,$description){

  global $wpdb;
  if(function_exists('is_plugin_active') )
  {

    if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) )
     {

        update_post_meta( $product_post_id, '_yoast_wpseo_title', wp_slash( $product_title ) );
        update_post_meta( $product_post_id, '_yoast_wpseo_metadesc', wp_slash( $description ) );
        update_post_meta( $product_post_id, '_yoast_wpseo_focuskw', wp_slash( $product_title ) );

    }
  }
}
function getyoastseovalue($new_product_id,$product_title,$description,$seovalues){
  if(function_exists('is_plugin_active') ){
    if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) {
      $seo_post_id      = $new_product_id; 
      $meta_key_title   = '_yoast_wpseo_title'; 
      $meta_value_title = $product_title; 
      $seovalues    .= "('$seo_post_id', '$meta_key_title', '$meta_value_title'),";
      $meta_key_desc    = '_yoast_wpseo_metadesc'; 
      $meta_value_desc  = $description; 
      $seovalues    .= "('$seo_post_id', '$meta_key_desc', '$meta_value_desc'),";
      $meta_key_fkw     = '_yoast_wpseo_focuskw'; 
      $meta_value_fkw   = $product_title; 
      $seovalues    .= "('$seo_post_id', '$meta_key_fkw', '$meta_value_fkw'),";
      return $seovalues;
    }
  }
      
}
?>

<?php get_footer(); ?>