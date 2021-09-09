<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
//include_once KDIPATH . '/filter/pagination.class.php';

/*function diamond_filter_assets_scripts() {
  wp_enqueue_style( 'kd-filter-css' );
  wp_enqueue_script( 'kd-filter', plugins_url('assets/js/kd-filter.js', __FILE__), array( 'jquery' ) );
  wp_enqueue_style('theme-override',plugins_url('assets/css/flexsliders1.css', __FILE__), '0.1.0', 'all');
  wp_enqueue_script( 'tda-flexslider', plugins_url('assets/js/jquery.flexslider-min.js', __FILE__), array( 'jquery' ), '2.6.3' );
  wp_enqueue_style('style-test',plugins_url('assets/css/filter_style.css', __FILE__), '0.1.0', 'all');
}*/

add_action( 'wp_ajax_key_diamon_filter_ajs', 'key_diamon_filter_ajs' );
add_action( 'wp_ajax_nopriv_key_diamon_filter_ajs', 'key_diamon_filter_ajs' );

function key_diamon_filter_ajs() {
  global $wpdb;
  include_once plugin_dir_path( __FILE__ ) . '/pagination.class.php';
  $page = 1;
  if(!empty($_POST["page"])) {
    $page = $_POST["page"];
  }
  $perPage = new PerPage();
  $start = ($page-1)*$perPage->perpage;
  if($start < 0) {$start = 0;} 

  // $start = 0;
  $shape_name = $_POST['shape_name'];
  $color_max_col = $_POST['color_max_col'];
  $cut_max_ct = $_POST['cut_max_ct'];
  $clarity_max_cal = $_POST['clarity_max_cal'];
  $carat_min = $_POST['carat_min'];
  $carat_max = $_POST['carat_max'];
  $price_min = $_POST['price_min'];
  $price_max = $_POST['price_max'];
  $order_by = $_POST['selectedorderdf'];

  if($shape_name!='') {
     $shape_name ="&shape=".$shape_name;
  }
  if($color_max_col!='') {
     $color_max_col = "&color=".$color_max_col;
  }
  if($clarity_max_cal!='') {
     $clarity_max_cal = "&clarity=".$clarity_max_cal;
  }
  if($cut_max_ct!='') {
     $cutss = str_replace(" ","%20",$cut_max_ct);
     $cut_max_ct ="&cut=".$cutss;
  }
  
  if($order_by!='' && $order_by!='publish-date') {
    $filt = explode('-',$order_by);
    $key_value = $filt[0];
    $value_ord = $filt[1];
    $order_by_data = "&".$key_value."=".$value_ord;
  }

  $file = get_site_url()."/wp-json/diamond/v1/list?mincarat=$carat_min&maxcarat=$carat_max&minprice=$price_min&maxprice=$price_max$shape_name$color_max_col$clarity_max_cal$cut_max_ct$order_by_data";
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
  $diamonds = serialize($diamond_data['data']);
  $response = do_shortcode( "[DiamondReaponse data='".$diamonds."'  perpageresult='".$perpageresult."']" );
  $response .=ob_get_clean();
  echo $response."~".$total_diamond; 
  exit();
}

function filter_curl_function(){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => get_site_url()."/wp-json/diamond/v1/filterdata/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 500,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "postman-token: 0845db60-442f-a1c9-5a43-f9ba30590a7c"
    ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  $response = json_decode($response, true);
  return $response;
}

/* Call the list diamond api via curl */
function get_listing_api_data($file){
	$request = WP_REST_Request::from_url($file );
	$request->set_method( 'GET' );
	$response = rest_do_request( $request );
	$server = rest_get_server();
	$data = $server->response_to_data( $response, false );
	$json = wp_json_encode( $data );
	$json = json_decode($json, true);
    return $json;
    /* $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $file,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 500,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache",
          "postman-token: 0845db60-442f-a1c9-5a43-f9ba30590a7c"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl); 
    $response = json_decode($response, true);
    return $response;*/
}


function shape_no_images($shape){
  $shap_name = ucfirst(strtolower($shape));
  if($shap_name=="Asscher"){ $no_images=get_template_directory_uri()."/images/asscher-large.png";}
  if($shap_name=="Cushion"){ $no_images=get_template_directory_uri()."/images/cushion-large.png";}
  if($shap_name=="Emerald"){ $no_images=get_template_directory_uri()."/images/emarald-large.png";}
  if($shap_name=="Heart"){ $no_images=get_template_directory_uri()."/images/heart-large.png"; }
  if($shap_name=="Marquise"){ $no_images=get_template_directory_uri()."/images/marquise-large.png";}
  if($shap_name=="Oval"){ $no_images=get_template_directory_uri()."/images/oval-large.png";}
  if($shap_name=="Pear"){ $no_images=get_template_directory_uri()."/images/pear-large.png";}
  if($shap_name=="Princess"){ $no_images=get_template_directory_uri()."/images/princess-large.png";}
  if($shap_name=="Radiant"){ $no_images=get_template_directory_uri()."/images/radiant-large.png";}
  if($shap_name=="Round"){ $no_images=get_template_directory_uri()."/images/round-large.png";}
  return $no_images;
}
?>