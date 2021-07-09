<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
include_once ABSPATH. 'config.php';
if ( ! function_exists( 'vendors_operations' ) ) {
	function vendors_operations($arr){
		global $wpdb;
		$checkvd="SELECT * FROM ".$wpdb->prefix."custom_kdmvendors WHERE abbreviation='".$arr['abbreviation']."'";
		$vdfound=$wpdb->query($checkvd);
		if($vdfound==0){
			$sqlvd="INSERT INTO ".$wpdb->prefix."custom_kdmvendors(name, description, abbreviation, shipdays, onect_below_price, onect_above_price, status, added)VALUES('".$arr['name']."','".$arr['description']."','".$arr['abbreviation']."','".$arr['shipdays']."','".$arr['onect_below_margin_price']."','".$arr['onect_above_margin_price']."','".$arr['status']."','".time()."')";
			$wpdb->query($sqlvd);
			return '1';
		}else{
			$sqlupvd="UPDATE ".$wpdb->prefix."custom_kdmvendors SET abbreviation='".$arr['abbreviation']."', shipdays='".$arr['shipdays']."', onect_below_price='".$arr['onect_below_margin_price']."', onect_above_price='".$arr['onect_above_margin_price']."', status='".$arr['status']."', updated='".time()."' WHERE abbreviation = '".$arr['abbreviation']."'";
			$wpdb->query($sqlupvd);
			return '2';

		}
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
// Import Product js function
function my_action_javascript() {
	if($_GET['page']=='api_settings' || $_GET['page']=='keyideas-diamonds-importer'){
		wp_enqueue_script( 'diamond-js', KDIPATH. '/assets/js/diamond.js', array('diamondjs'), '1.0.0', true );
	}
}
function make_diamond_name($diamond_carat,$diamond_color,$diamond_clarity,$diamond_cut,$diamond_shape,$diamond_certno){
	global $wpdb;
	
	if(!empty($diamond_shape) && !empty($diamond_cut)){
		$combinetitle=$diamond_cut." ".$diamond_shape;
	}else if(!empty($diamond_shape)){
		$combinetitle=$diamond_shape;
	}
	$diamond_name = $diamond_carat." Carat ".$diamond_color."-".$diamond_clarity." ".$combinetitle." Diamond ".$diamond_certno;
	if(!empty($diamond_name)){
		return $diamond_name;
	}
}
function make_diamond_seo_url($diamond_carat,$diamond_color,$diamond_clarity,$diamond_cut,$diamond_shape,$diamond_certno){
	global $wpdb;
	
	if($diamond_shape == 'Round'){
		$combinetitle=$diamond_cut."-cut ";
	}else if($diamond_shape != 'Round'){
		$combinetitle='';
	}
	$diamond_name = $diamond_carat." Carat ".$diamond_color."-color-".$diamond_clarity."-clarity-".$combinetitle.$diamond_certno;
	if(!empty($diamond_name)){
		return $diamond_name;
	}
}
function make_diamond_description($diamond_carat, $diamond_color, $diamond_clarity, $diamond_cut, $diamond_shape, $diamond_certificateNo,$cert_type,$type){
	global $wpdb;
    $description = "This " . $diamond_carat . " cts, " . $diamond_color . " color " . $diamond_clarity . " clarity " . $diamond_cut . " quality " . $diamond_shape . "  diamond is accompanied by the original " . $diamond_certificateNo;
    if($type == 'LG'){
        $type='Lab Grown';
    }else{
        $type='Natural';
    }
    $description = "$diamond_carat Carat - $diamond_color Color - $diamond_clarity Clarity - $diamond_cut Cut - $diamond_shape $type Diamond with $cert_type $diamond_certificateNo certificate.";
     if(!empty($description)){
     	return $description;	
     }
 }
 function make_diamond_metatitle($diamond_title){
 	global $wpdb;
 	if(!empty($diamond_title)){
 		return $diamond_title;
 	}
 }
 function make_diamond_metakeyword($diamond_title){
 	global $wpdb;
 	if(!empty($diamond_title)){
 		return $diamond_title;
 	}
 }
 function make_diamond_metadescription($diamond_descr){
 	global $wpdb;
 	if(!empty($diamond_descr)){
 		return $diamond_descr;
 	}
 }
 function apply_round_diamond_discount($post_id,$saleprice){
 	global $wpdb;
 	$discountArr 			= 	range(5, 25);
 	shuffle($discountArr);
 	$getdiscount			=	$discountArr[0];
 	$regular_margin_val 	= round(($saleprice)*($getdiscount/100));
 	$regular_price 			= round($saleprice + $regular_margin_val);

 	$discountArr=array('_sale_price'=>$saleprice,'_price'=>$saleprice,'_regular_price'=>$regular_price,);
 	foreach ($discountArr as $key => $discprice) {
 		$sqlmeta4="INSERT INTO ".$wpdb->prefix."postmeta(post_id,meta_key,meta_value)VALUES('".$post_id."','".$key."','".$discprice."')";
 		$wpdb->query($sqlmeta4);
 	}
 	//update_post_meta( $post_id, '_sale_price', $saleprice);
 	//update_post_meta( $post_id, '_price', $saleprice );
 	//update_post_meta( $post_id, '_regular_price', $regular_price);
 }
 function check_url_status($checkurl){
 	global $wpdb;
 	$headers = get_headers($checkurl, 1);
 	if ($headers[0] == 'HTTP/1.1 200 OK') {
 		return 1;
 	}else{
 		return 0;
 	}
 }
 function insert_get_image_id($imgurl, $CertName){
 	global $wpdb;
 	//$isvalid=check_url_status($imgurl);
 	//if($isvalid==1){
         //$data = getimagesize($imgurl);
         //$width = $data[0];
         //$height = $data[1];
         //$mime_type = $data['mime'];
         $filename = wp_basename( $imgurl );
         //$attachment = array('guid'=>$imgurl,'post_mime_type'=>$mime_type,'post_title'=>preg_replace( '/\.[^.]+$/', '', $filename));
         $attachment = array('guid'=>$imgurl,'post_mime_type'=>$mime_type,'post_title'=>$CertName);
         $attachment_metadata=array('width'=>'300','height'=>'300','file'=>$filename);
         $attachment_metadata['sizes']=array('full'=> $attachment_metadata);
         $sqlimg="INSERT INTO ".$wpdb->prefix."posts(post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count) VALUES ('1','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','','".$post_title."','".$post_excerpt."','inherit','open','closed','".$post_password."','".$post_name."','".$to_ping."','".$pinged."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','','0','".$imgurl."','0','attachment','image/jpeg','0')";
 		$wpdb->query($sqlimg);
 		$attachment_id = $wpdb->insert_id;
 		$sqlmeta6="INSERT INTO ".$wpdb->prefix."postmeta(post_id,meta_key,meta_value)VALUES('".$attachment_id."','_wp_attachment_metadata', '".maybe_serialize($attachment_metadata)."')";
 			$wpdb->query($sqlmeta6);
 		//wp_update_attachment_metadata($attachment_id, $attachment_metadata);
         //$attachment_id=wp_insert_attachment( $attachment );
 		//wp_update_attachment_metadata($attachment_id, $attachment_metadata);
 		return $attachment_id;
 	//}
  }
 function check_first_time_import($meta_key){
 	global $wpdb;
 	$checkvndor="SELECT count(post_id) as foundqg FROM ".$wpdb->prefix."postmeta WHERE meta_key='".$meta_key."'";
 	$resultqg=$wpdb->get_results($checkvndor);
 	return $resultqg[0]->foundqg;
 }
 function check_digital_signature($post_id,$new_digital_signature){
 	global $wpdb;
 	$old_digital_signature=get_post_meta($post_id, 'qg_signature', true);
 	if($old_digital_signature === $new_digital_signature){
 		return 0;
 	}else{
 		return 1;
 	}
 }
 function custom_get_vendor_diamonds($vendor){
 	global $wpdb;
 	$getdiamonds="SELECT Style FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE vendor='".$vendor."'";
 	$diamondsresults=$wpdb->get_results($getdiamonds);
 	foreach ($diamondsresults as $key => $diamondresult) {
 		$vendorArr[]=$diamondresult->Style;
 	}
 	if(!empty($vendorArr)){
 		return $vendorArr;
 	}else{
 		return [];
 	}
 }
 function custom_get_vdb_diamonds($ids){
	global $wpdb;
	$ids = join("','",$ids);

	$getdiamonds="SELECT Style FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE vendor IN ('".$ids."')";
	$diamondsresults=$wpdb->get_results($getdiamonds);
	foreach ($diamondsresults as $key => $diamondresult) {
		$vendorArr[]=$diamondresult->Style;
	}
	if(!empty($vendorArr)){
		return $vendorArr;
	}else{
		return [];
	}
}

function cutDepthTableValidation($ShapeCode,$depth,$table){
	$validation = 0;
	switch (trim(strtoupper($ShapeCode))) {
        case "ROUND":
            if($depth >= 59 && $depth <= 63 && $table >= 54 && $table <= 61 )
				$validation = 1;
			break;
        case "PEAR":
            if($depth >= 58 && $depth <= 65 && $table >= 54 && $table <= 63 )
				$validation = 1;
            break;
        case "PRINCESS":
            if($depth >= 64 && $depth <= 76 && $table >= 62 && $table <= 73 )
				$validation = 1;
            break;
        case "OVAL":
            if($depth >= 57 && $depth <= 64 && $table >= 53 && $table <= 64 )
				$validation = 1;
            break;
        case "RADIANT":
            if($depth >= 61 && $depth <= 70 && $table >= 61 && $table <= 70 )
				$validation = 1;
            break;
        case "EMERALD":
            if($depth >= 60 && $depth <= 68 && $table >= 60 && $table <= 69 )
				$validation = 1;
            break;
        case "ASSCHER":
            if($depth >= 60 && $depth <= 69 && $table >= 55 && $table <= 66 )
				$validation = 1;
            break;
        case "HEART":
            if($depth >= 55 && $depth <= 64 && $table >= 53 && $table <= 64 )
				$validation = 1;
            break;
        case "CUSHION":
            if($depth >= 61 && $depth <= 69 && $table >= 55 && $table <= 66 )
				$validation = 1;
            break;
        case "MARQUISE":
            if($depth >= 58 && $depth <= 64 && $table >= 53 && $table <= 64 )
				$validation = 1;
            break;
        }
        return $validation;
}

 function filterValidation($CertType,$ShapeCode,$Color,$Clarity,$Cut,$SizeCt,$Polish,$Symmetry,$WholesalePrice,$Image_Url,$Video_Url,$PriceCt,$Style_certificate_num,$Fluorescence,$CertLink,$filters,$depth,$table){
 	if (!in_array($ShapeCode, $filters['shapes'])){
 		echo 'ShapeCode'.$ShapeCode.'\n';
 		return 0;
     }
     if($WholesalePrice == '' || round((int)$WholesalePrice) < 99){
 		echo "WholesalePrice:".$WholesalePrice.'\n';
 		return 0;
 	}
 	if($ShapeCode != '' && $ShapeCode == 'Round'){
 		if($Cut == ''){
 			echo "Cut:".$Cut.'\n';
 			return 0;
 		}
 	}
 	if($SizeCt  == '' &&  round((int)$SizeCt)  == ''){
 		echo "SizeCt:".$SizeCt.'\n';
 		return 0;
 	}
 	if($PriceCt == '' || round((int)$PriceCt) == 0){
 		echo "PriceCt:".$PriceCt.'\n';
 		return 0;
 	}
 	if($Style_certificate_num == ''){
 		echo "Style_certificate_num:".$Style_certificate_num.'\n';
 		return 0;
 	}
     if (!in_array($Color, $filters['colors'])){
     	echo 'Color'.$Color.'\n';
         return 0;
     }
     if (!in_array($Clarity, $filters['clarity'])){
         echo 'Clarity'.$Clarity.'\n';
         return 0;
     }
     if (!in_array($Cut, $filters['cut'])){
         echo 'Cut'.$Cut.'\n';
         return 0;
     }
     //$size = $diamonds_feed['Weight'];
     if($SizeCt < $filters['carat_min'] || $SizeCt > $filters['carat_max']){
         echo 'SizeCt'.$SizeCt.'\n';
         return 0;
     }
    /* if($Image_Url =='' && $Video_Url =='' && $CertLink==''){
        echo 'Image&VideoBlank'.'\n';
        return 0;
    } */
    
 	if (strpos($Image_Url, 'http://') !== false) {
 		echo '$Image_Url'.'\n';
 		return 0;
     }
     if (strpos($Video_Url, 'http://') !== false) {
     	echo 'Video_Url'.'\n';
 		return 0;
     }
     if($WholesalePrice>$filters['price_min'] && $WholesalePrice<$filters['price_max']){
     }else{
     	echo 'WholesalePrice'.$WholesalePrice.'\n';
     	return 0;
     }
     //Advanced filters check
     if (!in_array($CertType, $filters['labs'])){
         echo 'CertType'.$CertType.'\n';
         return 0;
     }
     if (!in_array($Polish, $filters['polish'])){
         echo 'Polish'.$Polish.'\n';
         return 0;
     }
     if (!in_array($Symmetry, $filters['symmetry'])){
         echo 'Symmetry'.$Symmetry.'\n';
         return 0;
     }
	 if($depth == '' || round((int)$depth) < 1){
 		echo "depth:".$depth.'\n';
 		return 0;
 	}
	if($table == '' || round((int)$table) < 1){
 		echo "table:".$table.'\n';
 		return 0;
 	}
     /*if (!in_array($Fluorescence, $filters['fluorescence'])){
         return 0;
     }*/
	 
	 /* $cutDepthTableValidation = cutDepthTableValidation($ShapeCode,$depth,$table);
     if (!$cutDepthTableValidation){
         return 0;
     } */

     return 1;
 }
 if ( ! function_exists( 'custom_vendors_apifeeds_cron' ) ) {
 	function custom_vendors_apifeeds_cron(){
 		//ini_set('display_errors', 1);
 		//ini_set('max_execution_time', 0);
 		global $wpdb;
 		// QG API FEEDS FOR 7 DAYS OLDER DELETE
 		$qgdir = KDIPATH.'assets/apifeeds/qg/';
 		$qgfilecount = 0;
 		$qgfiles = glob($qgdir . "*");
 		if ($qgfiles){
 			$qgfilecount = count($qgfiles);
 		}
 		$qgapi_feeds=nu_importQualityGoldVendorDiamonds();
 		$qgapi_data=json_encode( $qgapi_feeds);
 		if($qgfilecount>=7){
 			$qgfiles = glob($qgdir.'/*');  
 			foreach($qgfiles as $qgfile) { 
 			    if(is_file($qgfile))  
 			        unlink($qgfile);  
 			} 
 		}
 		$filenameqg=time().".txt";
 		$makeqgfile = fopen(KDIPATH.'assets/apifeeds/qg/'.$filenameqg, "a+") or die("Unable to open file!");
 		fwrite($makeqgfile, $qgapi_data);
 		fclose($makeqgfile);
 		// PD API FEEDS FOR 7 DAYS OLDER DELETE
 		$pddir = KDIPATH.'assets/apifeeds/pd/';
 		$pdfilecount = 0;
 		$pdfiles = glob($pddir . "*");
 		if ($pdfiles){
 			$pdfilecount = count($pdfiles);
 		}
 		$url = "https://parishidiamond.com/aspxpages/StkDwnl.aspx?uname=thediamondart&pwd=thediamondart@19";
 		$xmlobj = simplexml_load_file($url);
 		$xmlArr = (array)$xmlobj;
 		$pdapi_feeds=json_encode( $xmlArr);
 		$pdapi_data=json_encode( $pdapi_feeds);
 		if($pdfilecount>=7){
 			$pdfiles = glob($pddir.'/*');  
 			foreach($pdfiles as $pdfile) { 
 			    if(is_file($pdfile))  
 			        unlink($pdfile);  
 			} 
 		}
 		$filenamepd=time().".txt";
 		$makepdfile = fopen(KDIPATH.'assets/apifeeds/pd/'.$filenamepd, "a+") or die("Unable to open file!");
 		fwrite($makepdfile, $pdapi_data);
 		fclose($makepdfile);
 		// ULGD API FEEDS FOR 7 DAYS OLDER DELETE
 		$ulgddir = KDIPATH.'assets/apifeeds/ulgd/';
 		$ulgdfilecount = 0;
 		$ulgdfiles = glob($ulgddir . "*");
 		if ($ulgdfiles){
 			$ulgdfilecount = count($ulgdfiles);
 		}
 		$ulgdapi_feeds=ulgd_api_diamond_feeds();
 		$ulgdapi_data=json_encode( $ulgdapi_feeds);
 		if($ulgdfilecount>=7){
 			$ulgdfiles = glob($ulgddir.'/*');  
 			foreach($ulgdfiles as $ulgdfile) { 
 			    if(is_file($ulgdfile))  
 			        unlink($ulgdfile);  
 			} 
 		}
 		$filename=time().".txt";
 		$makeulgdfile = fopen(KDIPATH.'assets/apifeeds/ulgd/'.$filename, "a+") or die("Unable to open file!");
 		fwrite($makeulgdfile, $ulgdapi_data);
 		fclose($makeulgdfile);
 		die('DONE');
 	}
 }
 if ( ! function_exists( 'make_diamond_image' ) ) {
 	function make_diamond_image($url = '') {
 		$image_url = '';
 		if($url != ''){
 			$vendor_array = ['jas'=>1367,'SCAASI'=>349, 'uniq'=>239, 'KJC'=>1373, 'jase'=>216];
 			$url_components = parse_url($url); 
 			parse_str($url_components['query'], $params);
 			$vendor_name = $params['cid'];
 			$diamond_id = $params['d'];
			if((strpos($url, "fileonsky.in/") !== FALSE)){
				$diamond_id = $params['StoneID'];
				$image_url = 'https://www.fileonsky.in/UPLOAD/'.$diamond_id.'_2.jpg';
			}
			elseif((strpos($url, "v3601300.v360.in/vision360.html?") !== FALSE)){
				$image_url = 'https://v3601300.v360.in/imaged/'.$diamond_id.'/still.jpg';
			}else{
				$imagefristpart = 'https://s6.v360.in/images/company/';
				if(empty($vendor_name) && ((strpos($url, "/1367/") !== FALSE) || (strpos($url, "%2f1367%2f") !== FALSE))){
					$vendor_name = 'jas';
				}elseif(empty($vendor_name) && ((strpos($url, "/349/") !== FALSE) || (strpos($url, "%2f349%2f") !== FALSE))){
					$vendor_name = 'SCAASI';
				}elseif(empty($vendor_name) && ((strpos($url, "/239/") !== FALSE) || (strpos($url, "%2f239%2f") !== FALSE))){
					$vendor_name = 'uniq';
				}elseif(empty($vendor_name) && ((strpos($url, "/1373/") !== FALSE) || (strpos($url, "%2f1373%2f") !== FALSE))){
					$vendor_name = 'KJC';
				}elseif(empty($vendor_name) && ((strpos($url, "/216/") !== FALSE) || (strpos($url, "%2f216%2f") !== FALSE))){
					$imagefristpart = 'https://s4.v360.in/images/company/';
					$vendor_name = 'jase'; 
				}
				if(empty($diamond_id) && (strpos($url, "https://v360.in/v360-viewer/1367/") !== FALSE)){
					$diamond_id = str_replace("https://v360.in/v360-viewer/1367/", '', $url);
				}
				$image_url = $imagefristpart.$vendor_array[$vendor_name].'/imaged/'.$diamond_id.'/still.jpg'; 
			}
 		}
         return $image_url;
 	}
 }


 function getSegomaImage($url='',$stockNumber='',$certificate='')
{
    $imageUrl = '';

   if ($url!='' && ((($pos = strpos($url, "v360.in/diamondview.aspx?cid=IPMDE&d=")) !== FALSE))) { 
        $pos = strpos($url, "IPMDE&d=");
        $imageUrl = 'https://s4.v360.in/images/company/289/imaged/'.substr($url, $pos+8).'/still.jpg'; 
    }elseif ((strpos($url, "raplab.com/reportcheck/viewer/V360.aspx?d=") !== FALSE) || (strpos($url, "raplab.com/reportcheck/Viewer/V360.aspx?d=") !== FALSE)) {
        $url_components = parse_url($url); 
        parse_str($url_components['query'], $params);
        $imageUrl = 'https://v360.in/V360Images.aspx?d='.$params['d'].'&surl=https://s3.amazonaws.com/rap.lab/V360/v360';
    }elseif ($url!='' && (($pos = strpos($url, "https://v360.in/DiamondView.aspx?d=")) !== FALSE) && (($posend = strpos($url, "&cid=forever")) !== FALSE)) {
        $pos = strpos($url, "aspx?d=");
        $imageUrl = 'https://s4.v360.in/images/company/59/imaged/'.substr($url, $pos+7, -12).'/still.jpg';
    }elseif ($url!='' && (($pos = strpos($url, "https://v360.in/forever/vision360.html?d=")) !== FALSE) && ((strpos($url, "&sv=0&z=1")) == FALSE)) {
        $pos = strpos($url, "html?d=");
        $url = str_replace('&sv=0&z=1','', $url);
        $imageUrl = 'https://s4.v360.in/images/company/59/imaged/'.substr($url, $pos+7, -12).'/still.jpg';
    }elseif ($url!='' && (($pos = strpos($url, "ddpl.com")) !== FALSE)) {
        $imageUrl = 'https://assets.ddpl.com/image/'.$stockNumber.'?dimg.jpg';
    }elseif ($url!='' && (($pos = strpos($url, "https://v360.in/movie/1367_")) !== FALSE)) {
        $imageUrl = 'https://s6.v360.in/images/company/1367/imaged/'.substr($url, $pos+27).'/still.jpg';
    }elseif ($url!='' && (($pos = strpos($url, "https://v360.in/diamondview.aspx?cid=jas&d=")) !== FALSE)) {
        $imageUrl = 'https://s6.v360.in/images/company/1367/imaged/'.substr($url, $pos+43).'/still.jpg';
    }elseif ($url!='' && ((strpos($url, "https://s4.v360.in/images/company/279/") !== FALSE) || (strpos($url, "v360gnd") !== FALSE))) {
        $imageUrl = 'https://s6.v360.in/images/company/279/imaged/'.$stockNumber.'/still.jpg';
    }elseif ($url!='' && (strpos($url, "&cid=Diamond360") !== FALSE || strpos($url, "&cid=diamond360") !== FALSE)) {
        $stockno = str_replace(array('Ã','Â','‚',' ','https://v360.in/DiamondView.aspx?d=','&cid=Diamond360','&cid=diamond360','ï','¿','½'),'',$url);
        $imageUrl = 'https://s6.v360.in/images/company/44/imaged/'.$stockno.'/still.jpg';
    }elseif ((strpos($url, "v360.in/movie") !== FALSE) || (strpos($url, "api1.v360.in/viewer/") !== FALSE)) {
        $data_name = explode('_',str_replace(array('https://v360.in/movie/','Â','‚',' ','http://api1.v360.in/viewer/','https://api1.v360.in/viewer/'),'',$url));
        if($data_name[0] == 59)
            $imageUrl = "https://s4.v360.in/images/company/59/imaged/".$data_name[1]."/still.jpg";
        elseif($data_name[0] == 219)
            $imageUrl = "https://s4.v360.in/images/company/219/imaged/".$data_name[1]."/still.jpg";
        elseif($data_name[0] == 315)
            $imageUrl = "https://s4.v360.in/images/company/315/imaged/".$data_name[1]."/still.jpg";
        elseif($data_name[0] == 234)
            $imageUrl = "https://s4.v360.in/images/company/234/imaged/".$data_name[1]."/still.jpg";
        elseif($data_name[0] == 240)
            $imageUrl = "https://s4.v360.in/images/company/240/imaged/".$data_name[1]."/still.jpg";
        elseif($data_name[0] == 298)
            $imageUrl = "https://s4.v360.in/images/company/298/imaged/".$data_name[1]."/still.jpg";
        elseif($data_name[0] == 335)
            $imageUrl = "https://s4.v360.in/images/company/335/imaged/".$data_name[1]."/still.jpg";
		elseif($data_name[0] == 1446)
            $imageUrl = "https://s6.v360.in/images/company/1446/imaged/".$data_name[1]."/still.jpg";
		elseif($data_name[0] == 99)
            $imageUrl = "https://s7.v360.in/images/company/99/imaged/".$data_name[1]."/still.jpg";
		elseif($data_name[0] == 1396)
            $imageUrl = "https://v3601396.v360.in/imaged/".$data_name[1]."/still.jpg";
                
    }
    elseif ($url!='' && (strpos($url, "diamonddna.co.in") !== FALSE)) {
        $imageUrl = "https://diamonddna.co.in/RealImages/".$stockNumber.".jpg";
    }elseif (strpos($url, "https://honeyexport.in/DiamondDetails.aspx?dmstockid=") !== FALSE) {
        $imageUrl = "https://1210295089.rsc.cdn77.org/viewer3/RealImages/".$stockNumber.".jpg";
    }
    elseif ($url!='' && strpos($url, "v360.in/diamondview.aspx?cid=APShaps") !== FALSE) { 
        $stock = str_replace("https://v360.in/diamondview.aspx?cid=APShaps&d=",'',$url);
        $imageUrl = 'https://s4.v360.in/images/company/99/imaged/'.$stock.'/still.jpg'; 
    }elseif ((strpos($url, "https://v360.in/DiamondView.aspx?") !== FALSE) || (strpos($url, "https://v360.in/diamondView.aspx?") !== FALSE) || (strpos($url, "https://v360.in/diamondview.aspx?cid=APShaps") !== FALSE)) {
        $url = str_replace(array('Ã','Â','‚',' ','ï','¿','½'),'',$url);
        $vendor_array = ['lg2'=>55, 'lg4'=>103, 'diamond360'=>44, 'Diamond360'=>44, 'APShaps'=>99, 'forever'=>59, 'IPMDE'=>289, 'uniglo'=>1417, 'anika'=>335, 'v360studio'=>1446];
        $server_array = ['lg2'=>'s4', 'lg4'=>'s4', 'diamond360'=>'s6', 'Diamond360'=>'s6', 'APShaps'=>'s4', 'forever'=>'s4', 'IPMDE'=>'s4', 'uniglo'=>'v3601417', 'anika'=>'s4', 'v360studio'=>'s6'];
        $url_components = parse_url($url); 
        parse_str($url_components['query'], $params);
        if(isset($params['cid']) && isset($params['d']))
        {
			$vendor_name = $params['cid'];
			$diamond_id = $params['d'];
			$server_name = $server_array[$params['cid']];
			if($params['cid'] == 'uniglo'){
				$imageUrl = "https://".$server_name.".v360.in/imaged/".$diamond_id."/still.jpg";
			}else{
				
				$imageUrl = "https://".$server_name.".v360.in/images/company/".$vendor_array[$vendor_name]."/imaged/".$diamond_id."/still.jpg";
			}
        }
    }
    elseif ((strpos($url, "https://v360.in/LG4/vision360.html") !== FALSE) || (strpos($url, "https://v360.in/LG3/vision360.html") !== FALSE) || (strpos($url, "https://v360.in/LG2/vision360.html") !== FALSE) || (strpos($url, "https://v360.in/LG1/vision360.html") !== FALSE) || (strpos($url, "https://v360.in/v360studio/vision360.html") !== FALSE)) {
        $vendorName = 'lg3';
		$server = 's4';
        if(strpos($url, "https://v360.in/LG1/vision360.html") !== FALSE){
            $vendorName = 'lg1';
        }elseif(strpos($url, "https://v360.in/LG2/vision360.html") !== FALSE){
            $vendorName = 'lg2';
        }elseif(strpos($url, "https://v360.in/LG3/vision360.html") !== FALSE){
            $vendorName = 'lg3';
        }elseif(strpos($url, "https://v360.in/LG4/vision360.html") !== FALSE){
            $vendorName = 'lg4';
        }elseif(strpos($url, "https://v360.in/v360studio/vision360.html") !== FALSE){
            $vendorName = 'v360studio';
			$server = 's6';
        }
        $vendor_array = ['lg2'=>55, 'lg4'=>103, 'lg3'=>107, 'lg1'=>57, 'v360studio'=>1446];
        $url_components = parse_url($url); 
        parse_str($url_components['query'], $params);
        if( isset($params['d']))
        {
            $imageUrl = "https://".$server.".v360.in/images/company/".$vendor_array[$vendorName]."/imaged/".$params['d']."/still.jpg";
        }
    }elseif ((strpos($url, "https://certimage.s3-accelerate.amazonaws.com/V360_viewers/v4.0/Vision360.html?surl=https://certimage.s3-accelerate.amazonaws.com/") !== FALSE)) {
        $imageUrl = "https://certimage.s3-accelerate.amazonaws.com/V360_B2C/_v4.0/imaged/".$stockNumber."/still.jpg";
    }elseif ((strpos($url, "https://panch.co.in/Home/dna?ReportNo=") !== FALSE)) {
        $certi = str_replace(array('https://panch.co.in/Home/dna?ReportNo='),'',$url);
        $imageUrl = "https://s3.ap-south-1.amazonaws.com/mediadiam/VideoNew/imaged/".$certi."/still.jpg";
    }elseif ((strpos($url, "https://narolagems.com/DiamondDetail.aspx?StoneId=") !== FALSE)) {
        $imageUrl = "https://pcknstg.blob.core.windows.net/hdfile/DimImg/".$stockNumber.".JPG";
    }elseif ((strpos($url, "https://shyamcorporation.net/StoneDetail/Index?stoneid=") !== FALSE)) {
        $imageUrl = "https://s6.v360.in/images/company/1383/imaged/".$stockNumber."/still.jpg";
    }elseif ((strpos($url, "https://vd-v360.s3.ap-south-1.amazonaws.com/index.html?d=") !== FALSE)) {
        $imageUrl = "https://vd-v360.s3.ap-south-1.amazonaws.com/imaged/".$stockNumber."/still.jpg";
    }elseif ((strpos($url, "sagarenterprise.in/aspxpages/ShowImageWithDiffZooming.aspx?refNo=") !== FALSE)) {
        $imageUrl = "";
    }elseif ((strpos($url, "sanghvisons.com/worldproductdetails/index/") !== FALSE) || (strpos($url, "sanghvisons.com/productdetails/index/") !== FALSE)) {
        $imageUrl = "https://video.sanghvisons.com/".$stockNumber."/still.jpg";
    }elseif ((strpos($url, "sunrisediamonds.com.hk/ViewDna.aspx?Loc") !== FALSE)) {
        $url_components = parse_url($url); 
        parse_str($url_components['query'], $params);
        if($params['Image'] == 'True')
        {
            $imageUrl = "https://cdn2.brainwaves.co.in/img/".$certificate."/PR.jpg";
        }else{
            $imageUrl='';
        }
    }elseif ((strpos($url, "https://v360.in/viewer4.0/vision360.html?d=") !== FALSE)) {
        $imageUrl = "https://s4.v360.in/images/company/298/imaged/".$stockNumber."/still.jpg";
    }elseif ((strpos($url, "sunrisediamonds.com.hk/ViewDna.aspx?Loc") !== FALSE)) {
        $url_components = parse_url($url); 
        parse_str($url_components['query'], $params);
        if($params['Image'] == 'True')
        {
            $imageUrl = "https://cdn2.brainwaves.co.in/img/".$certificate."/PR.jpg";
        }else{
            $imageUrl='';
        }
    }elseif ((strpos($url, "https://v360.in/viewer4.0/vision360.html?d=") !== FALSE)) {
        $imageUrl = "https://s4.v360.in/images/company/298/imaged/".$stockNumber."/still.jpg";
    }elseif((strpos($url, "mydiamondsearch.com/images.php?lot=") !== FALSE)){
        $imageUrl = "https://mydiamondsearch.com/ampvd/v1/diamond_images/".strtolower($stockNumber).".jpg";
    }elseif((strpos($url, "dna.dnalink.in/d") !== FALSE)){
        $imageUrl = "https://dnalink.in/Imaged/".$stockNumber."/still.jpg";
    }elseif((strpos($url, "v360.in/detail/1422_") !== FALSE)){
        $data_name = str_replace('https://v360.in/detail/1422_','',$url);
        $imageUrl = 'https://v3601422.v360.in/imaged/'.$data_name.'/still.jpg';
    }elseif((strpos($url, "v360.in/diamondview.aspx?cid=APShaps") !== FALSE)){
        $data_name = str_replace('https://v360.in/diamondview.aspx?cid=APShaps&d=','',$url);
        $imageUrl = 'https://s4.v360.in/images/company/99/imaged/'.$data_name.'/still.jpg';
    }elseif((strpos($url, "bg.prolanceit.in/stone-detail/") !== FALSE)){
        $imageUrl = 'https://bg.prolanceit.in/media/imaged/'.$stockNumber.'/still.jpg';
    }elseif((strpos($url, "moviee.hd.diamonds/StoneDetail.aspx?stoneid=") !== FALSE)){
        $imageUrl = 'https://moviee.hd.diamonds/HDView/imaged/'.$stockNumber.'/'.$stockNumber.'.jpg';
    }
    return $imageUrl;    
}

if ( ! function_exists( 'getVideoUrl' ) ) {
    function getVideoUrl($videoUrl='',$stockNumber='')
    {
        if($videoUrl!=''){
            if ((strpos($videoUrl, "v360.in/movie") !== FALSE) || (strpos($videoUrl, "api1.v360.in/viewer/") !== FALSE)) {
                $videoUrl = addHttps($videoUrl);
                $data_name = explode('_',str_replace(array('https://v360.in/movie/','Â','‚',' ','http://api1.v360.in/viewer/','https://api1.v360.in/viewer/'),'',$videoUrl));
                if($data_name[0] == 59)
                    $videoUrl = "https://v360.in/forever/Vision360.html?d=".$data_name[1]."&surl=https://s4.v360.in/images/company/59/";
                elseif($data_name[0] == 219)
                    $videoUrl = "https://v360.in/AlKamal/Vision360.html?d=".$data_name[1]."&surl=https://s4.v360.in/images/company/219/";
                elseif($data_name[0] == 315)
                    $videoUrl = "https://v360.in/viewer4.0/vision360.html?d=".$data_name[1]."&surl=https://s4.v360.in/images/company/315/";
                elseif($data_name[0] == 234)
                    $videoUrl = "https://v360.in/viewer4.0/vision360.html?d=".$data_name[1]."&surl=https://s4.v360.in/images/company/234/";
                elseif($data_name[0] == 240)
                    $videoUrl = "https://v360.in/viewer4.0/vision360.html?d=".$data_name[1]."&surl=https://s4.v360.in/images/company/240/";
                elseif($data_name[0] == 298)
                    $videoUrl = "https://v360.in/viewer4.0/vision360.html?d=".$data_name[1]."&surl=https://s4.v360.in/images/company/298/";
                elseif($data_name[0] == 335)
                    $videoUrl = "https://v360.in/viewer4.0/vision360.html?d=".$data_name[1]."&surl=https://s4.v360.in/images/company/335/";
				elseif($data_name[0] == 99)
                    $videoUrl = "https://v360.in/APShaps/vision360.html?d=".$data_name[1]."&surl=https://s7.v360.in/images/company/99/";
				elseif($data_name[0] == 1446)
                    $videoUrl = "https://v360.in/v360studio/vision360.html?d=".$data_name[1]."&surl=https://s6.v360.in/images/company/1446/";
                elseif($data_name[0] == 1396)
                    $videoUrl = "https://v3601396.v360.in/vision360.html?d=".$data_name[1]."&surl=https://v3601396.v360.in/";
                
            }elseif ((strpos($videoUrl, "panch.co.in/Home/dna?ReportNo=") !== FALSE)) {
            $url_components = parse_url($videoUrl);   
            parse_str($url_components['query'], $params); 
            $param = $params['ReportNo'];
            $videoUrl = "https://s3.ap-south-1.amazonaws.com/mediadiam/VideoNew/Vision360.html?d=".$param;
            }elseif ($videoUrl!='' && (strpos($videoUrl, "diamonddna.co.in") !== FALSE)) {
                $videoUrl = "https://diamonddna.co.in/viewer3/Vision360.html?d=".$stockNumber."&v=2&sv=0&z=0&btn=0?s=100";
            }elseif ((strpos($videoUrl, "sagarenterprise.in/aspxpages/ShowImageWithDiffZooming.aspx?refNo=") !== FALSE) || (strpos($videoUrl,'parishidiamond.com/pages/stonedna')!==false)) {
                $videoUrl = "";
            }elseif ((strpos($videoUrl, "sanghvisons.com/worldproductdetails/index/") !== FALSE) || (strpos($videoUrl, "sanghvisons.com/productdetails/index/") !== FALSE)) {
                $videoUrl = "https://video.sanghvisons.com/".$stockNumber."/".$stockNumber.".html?";
            }elseif ((strpos($videoUrl, "shyamcorporation.net/StoneDetail/Index?stoneid=") !== FALSE)) {
                $videoUrl = "https://v360.in/sc/vision360.html?d=".$stockNumber;
            }elseif((strpos($videoUrl, "1803229786.rsc.cdn77.org/Videos/") !== FALSE)){
                $videoUrl = $videoUrl.'?';
            }elseif((strpos($videoUrl, "mydiamondsearch.com/images.php?lot=") !== FALSE)){
                $videoUrl = '';
            }elseif((strpos($videoUrl, "diacam360.com") !== FALSE) || (strpos($videoUrl, "diamondvid.com/stocks/") !== FALSE) || (strpos($videoUrl, "sanghvisons.com/productdetails/index") !== FALSE) || (strpos($videoUrl, "trs.ntech.us/dashboard/Videos") !== FALSE)){
                $videoUrl = '';
            }elseif((strpos($videoUrl, "dna.dnalink.in/d") !== FALSE)){
                $videoUrl = 'https://dnalink.in/Vision360.html?d='.$stockNumber;
            }elseif((strpos($videoUrl, "v360.in/detail/1422_") !== FALSE)){
                $data_name = str_replace('https://v360.in/detail/1422_','',$videoUrl);
                $videoUrl = 'https://v3601422.v360.in/vision360.html?d='.$data_name;
            }elseif ((strpos($videoUrl, "raplab.com/reportcheck/viewer/V360.aspx?d=") !== FALSE) || (strpos($videoUrl, "raplab.com/reportcheck/Viewer/V360.aspx?d=") !== FALSE)) {
                $url_components = parse_url($videoUrl); 
                parse_str($url_components['query'], $params);
                $videoUrl = "https://v360.in/viewer3.0/vision360.html?d=".$params['d']."&surl=https://s3.amazonaws.com/rap.lab/V360/v360";
            }
			elseif ((strpos($videoUrl, "https://v360.in/DiamondView.aspx?") !== FALSE) || (strpos($videoUrl, "https://v360.in/diamondView.aspx?") !== FALSE) || (strpos($videoUrl, "https://v360.in/diamondview.aspx?cid=APShaps") !== FALSE)) {
				$videoUrl = str_replace(array('Ã','Â','‚',' ','ï','¿','½'),'',$videoUrl);
				$vendor_array = ['lg2'=>55, 'lg4'=>103, 'diamond360'=>44, 'Diamond360'=>44, 'APShaps'=>99, 'forever'=>59, 'IPMDE'=>289, 'uniglo'=>1417];
				$server_array = ['lg2'=>'s4', 'lg4'=>'s4', 'diamond360'=>'s6', 'Diamond360'=>'s6', 'APShaps'=>'s4', 'forever'=>'s4', 'IPMDE'=>'s4', 'uniglo'=>'v3601417'];
				$url_components = parse_url($videoUrl); 
				parse_str($url_components['query'], $params);
				if(isset($params['cid']) && isset($params['d']))
				{
					$vendor_name = $params['cid'];
					$diamond_id = $params['d'];
					$server_name = $server_array[$params['cid']];
					if($params['cid'] == 'uniglo'){
						$videoUrl = "https://".$server_name.".v360.in/vision360.html?d=".$diamond_id."&surl=https://".$server_name.".v360.in/";
					}
				}
			}
			elseif (strpos($videoUrl, "https://honeyexport.in/DiamondDetails.aspx?dmstockid=") !== FALSE) {
				$videoUrl = "https://1210295089.rsc.cdn77.org/viewer3/Vision360.html??d=".$stockNumber;
			}
			elseif (strpos($videoUrl, "bg.prolanceit.in/stone-detail/") !== FALSE) {
				$videoUrl = "https://bg.prolanceit.in/media/vision360.html?d=".$stockNumber;
			}
			elseif (strpos($videoUrl, "moviee.hd.diamonds/StoneDetail.aspx?stoneid=") !== FALSE) {
				$videoUrl = "https://moviee.hd.diamonds/HDView/Vision360.html?d=".$stockNumber;
			}
        }
        return $videoUrl;
    }
}
 if ( ! function_exists( 'GetCertTypeValue' ) ) {
 	function GetCertTypeValue($val)
 	{
 		switch (trim(strtoupper($val))) {
 		case "GIA":
        case "GIA GEMOLOGIST":
 		case "G":
 			$GetCertTypeValue = "GIA";
 			break;
 		case "AGS":
 		case "A":
 			$GetCertTypeValue = "AGS";
 			break;
 		case "IGI":
 		case "I":
 			$GetCertTypeValue = "IGI";
 			break;
 		case "GCAL":
 			$GetCertTypeValue = "GCAL";
 			break;
 		default:
 			$GetCertTypeValue = trim($val);
 			break;
 		}
 		return $GetCertTypeValue;
 	}
 }
 if ( ! function_exists( 'GetLWRatio' ) ) {	
 	function GetLWRatio($lengthValue, $widthValue, $heightValue)
 	{
 		$widthValue = (($widthValue == 0 || $widthValue == '') ? 1 : $widthValue);
 		$lengthValue = (($lengthValue == 0 || $lengthValue == '') ? 1 : $lengthValue);
 		$heightValue = (($heightValue == 0 || $heightValue == '') ? 1 : $heightValue);
 		$dimensn=[$lengthValue,$widthValue,$heightValue];
 		rsort($dimensn);
		
 		$ratio = $dimensn[0]/$dimensn[1];
 		$retVal = round($ratio,2);
 		return $retVal;
 	}
 }
 if ( ! function_exists( 'GetQualityValue' ) ) {	
 	function GetQualityValue($val)
 	{
 		$val = trim(strtoupper($val));
 		switch ($val) {
 			case "IDEAL":
 			case "ID":
 			case "I":
            case "EX+":
 				$GetQualityValue = "Ideal";
 				break;
 			case "EXCELLENT":
 			case "X":
 			case "EX":
 			case "EXC NR":
 				$GetQualityValue = "Excellent";
 				break;
 			case "VERY GOOD":
 			case "VG":
 				$GetQualityValue = "Very Good";
 				break;
 			case "GOOD":
 			case "G":
 			case "GD":
 				$GetQualityValue = "Good";
 				break;
 			case "FAIR TO GOOD":
 			case "F-G":
 				$GetQualityValue = "Fair to Good";
 				break;
 			case "FAIR":
 			case "F":
 			case "FR":
 				$GetQualityValue = "Fair";
 				break;
 			case "POOR":
 			case "P":
 				$GetQualityValue = "Poor";
 				break;
 			default:
 				$GetQualityValue = $val;
 				break;
 		}
 		return $GetQualityValue;
 	}
 }
 if ( ! function_exists( 'GetShapeValue' ) ) {
 	function GetShapeValue($val)
 	{
 		switch (trim(strtoupper($val))) {
 		case "B":
 		case "BR":
 		case "RB":
 		case "ROUND":
 		case "RD":
 		case "RBC":
        case "RN":
        case "BRILLIANT ROUND":
 			$GetShapeValue = "Round";
 			break;
 		case "P":
 		case "PS":
        case "PE":
 		case "PEAR":
 			$GetShapeValue = "Pear";
 			break;
 		case "E":
 		case "EM":
 		case "EMERALD":
 		case "EC":
 		case "SQEM":
        case "AC":
 			$GetShapeValue = "Emerald";
 			break;
 		case "M":
 		case "MQ":
 		case "MARQUISE":
 			$GetShapeValue = "Marquise";
 			break;
 		case "O":
 		case "OV":
 		case "OVAL":
        case "OVAL ROSE":
 			$GetShapeValue = "Oval";
 			break;
 		case "R":
 		case "RAD":
 		case "RA":
 		case "RC":
        case "LR":
 		case "RADIANT":
 			$GetShapeValue = "Radiant";
 			break;
 		case "PRN":
 		case "PR":
 		case "PRIN":
 		case "PRINCESS":
 		case "PN":
 		case "PC":
 			$GetShapeValue = "Princess";
 			break;
 		case "T":
 		case "TR":
 		case "TRIL":
 		case "TRILL":
 		case "TRILLIANT":
 		case "TRIB":
 		case "TRL":
 			$GetShapeValue = "Trilliant";
 			break;
 		case "H":
 		case "HS":
        case "HE":
 		case "HEART":
 			$GetShapeValue = "Heart";
 			break;
 		case "EU":
 		case "EUROPEAN CUT":
 			$GetShapeValue = "European Cut";
 			break;
 		case "OM":
 		case "OLD MINER":
 			$GetShapeValue = "Old Miner";
 			break;
 		case "FL":
 		case "FLANDERS":
 		case "FC":
 			$GetShapeValue = "Flanders";
 			break;
 		case "C":
 		case "CUS":
 		case "CUSHION":
        case "CUSHION BRILLIANT":
 		case "CU":
 		case "CB":
 		case "CMB":
 		case "CUSB":
 		case "BAGUETTE":
 			$GetShapeValue = "Cushion";
 			break;
 		case "CUSHION MODIFIED":
 			$GetShapeValue = "Cushion";
 			break;
 		case "AS":
 		case "ASS":
 		case "ASSCHER":
 		case "A":
 			$GetShapeValue = "Asscher";
 			break;
 		case "BAG":
 		case "BAGUETTE":
 		case "BG":
 			$GetShapeValue = "Baguette";
 			break;
 		case "K":
 		case "KITE":
 		case "KT":
 			$GetShapeValue = "Kite";
 			break;
 		case "S":
 		case "STAR":
 		case "ST":
 			$GetShapeValue = "Star";
 			break;
 		case "HM":
 		case "HMB":
 		case "HALF MOON":
 			$GetShapeValue = "Half Moon";
 			break;
 		case "TP":
 		case "TRAP":
 		case "TRAPB":
 		case "TZ":
 		case "TRAPEZOID":
 			$GetShapeValue = "Trapezoid";
 			break;
 		case "BU":
 		case "BULLETS":
 			$GetShapeValue = "Bullets";
 			break;
 		case "OT":
 		case "X":
 		case "OTHER":
 			$GetShapeValue = trim($val);
 			break;
 		default:
 			$GetShapeValue = trim($val);
 			break;
 		}
 		return $GetShapeValue;
 	}
 }
 if ( ! function_exists( 'GetFluorescenceValue' ) ) {	
 	function GetFluorescenceValue($val)
 	{
 		$val = trim(strtoupper($val));
 		switch ($val) {
 			case "FAINT":
 			case "FNT":
 			case "F":
 				$GetFluorValue = "Faint";
 				break;
 			case "MEDIUM":
 			case "MED":
 			case "M":
 				$GetFluorValue = "Medium";
 				break;
 			case "NONE":
 			case "N":
 				$GetFluorValue = "None";
 				break;
 			case "STRONG":
 			case "STR":
 			case "S":
 				$GetFluorValue = "Strong";
 				break;
            case "VS":
            case "VSL":
 			case "VSL":
 			case "SL":
 			case "V.STR":
 			case "VERY STRONG":
 				$GetFluorValue = "Very Strong";
 				break;
 			case "MEDIUM STRONG":
 				$GetFluorValue = "Medium Strong";
 				break;
 			case "SLIGHT":
 				$GetFluorValue = "Slight";
 				break;
 			case "VERY SLIGHT":
 				$GetFluorValue = "Very Slight";
 				break;
 			default:
 				$GetFluorValue = trim($val);
 				break;
 		}
        if($val == ''){
            $GetFluorValue = "None";
        }
 		return $GetFluorValue;
 	}
 }
 if ( ! function_exists( 'GetCuletValue' ) ) {	
 	function GetCuletValue($val)
 	{
 		$val = trim(strtoupper($val));
 		switch ($val) {
 			case "POINTED":
 			case "P":
            case "PO":
 				$GetCuletValue = "Pointed";
 				break;
            case "NON":
 			case "NONE":
 			case "N":
 				$GetCuletValue = "None";
 				break;
 			case "MEDIUM":
 			case "M":
 				$GetCuletValue = "Medium";
 				break;
 			case "VERY SMALL":
 			case "VS":
            case "VSM":
 				$GetCuletValue = "Very small";
 				break;
 			case "SMALL":
 			case "S":
            case "SML":
 				$GetCuletValue = "Small";
 				break;
 			case "LARGE":
 			case "L":
 				$GetCuletValue = "Large";
 				break;
 			case "NONE POINTED":
 				$GetCuletValue = "None Pointed";
 				break;
 			default:
 				$GetCuletValue = trim($val);
 				break;
 		}
        if($val == ''){
            $GetCuletValue = "None";
        }
 		return $GetCuletValue;
 	}
 }
 if ( ! function_exists( 'addHttps' ) ) {
 	function addHttps($url='')
     {
        if($url!=''){
            if((strpos($url,'http://naroladiamond.com/stock')!==false )|| (strpos($url,'http://dtol-cert-images.s3-website-us-east-1.amazonaws.com')!==false) || (strpos($url,'http://www.dnrexports.com/DiaImages/Images')!==false) || (strpos($url,'diacam360.com')!==false) || (strpos($url, "diamondvid.com/stocks/") !== FALSE) || (strpos($url, "sanghvisons.com/productdetails/index") !== FALSE) || (strpos($url, "trs.ntech.us/dashboard/Videos") !== FALSE)){
                $url = '';

            }
        }
        if($url!='' && strpos($url,'https')===false)
        {
            if(strpos($url,'http')!==false && strpos($url,'www')!==false)
            {
               $url=str_replace('http','https',$url);  
            }elseif(strpos($url,'http')!==false && strpos($url,'www')===false)
            {
                $url=str_replace('http','https',$url);  
            }elseif(strpos($url,'www')!==false){
                $url='https://'.$url;   
            }
        }
        if((strpos($url,'parishidiamond.com/pages/stonedna')!==false)){
            $url = '';
        }
      return $url;    
    }
}
if ( ! function_exists( 'defaultVideoFormat' ) ) {
	function defaultVideoFormat($url='')
    {
		$videoImageUrl = [];
		if(strpos($url, "https://v360.in/v360-viewer/1367/") !== FALSE){
			$vendorCertificateId= str_replace("https://v360.in/v360-viewer/1367/","",$url);
            $videoImageUrl['videoUrl'] = "https://v360.in/viewer4.0/vision360.html?d=".$vendorCertificateId."&surl=https://s7.v360.in/images/company/1367/";
            $videoImageUrl['imageUrl'] = make_diamond_image($url);
        }
		elseif(strpos($url, "https://api1.v360.in/") !== FALSE){
			$vendorCertificateId= str_replace("https://api1.v360.in/viewer/","",$url);
			$detailsArray = explode('_',$vendorCertificateId);
			$vendor_id = $detailsArray[0];
			$diamond_id = $detailsArray[1];
			$videoImageUrl['videoUrl'] = "https://v360.in/viewer4.0/vision360.html?d=".$detailsArray[1]."&surl=https://s6.v360.in/images/company/".$detailsArray[0]."/";
			$videoImageUrl['imageUrl'] = "https://s6.v360.in/images/company/".$detailsArray[0]."/imaged/".$detailsArray[1]."/still.jpg";
		}
		elseif(strpos($url, "https://v360.in/movie/") !== FALSE){
			$vendorCertificateId= str_replace("https://v360.in/movie/","",$url);
			$detailsArray = explode('_',$vendorCertificateId);
			$vendor_id = $detailsArray[0];
			$diamond_id = $detailsArray[1];
			$videoImageUrl['videoUrl'] = "https://v360.in/viewer4.0/vision360.html?d=".$detailsArray[1]."&surl=https://s4.v360.in/images/company/".$detailsArray[0]."/";
			$videoImageUrl['imageUrl'] = "https://s4.v360.in/images/company/".$detailsArray[0]."/imaged/".$detailsArray[1]."/still.jpg";
		}elseif(strpos($url, "www.blgd.in/ManageV360/preview?SinglePieceStockId=") !== FALSE){
			$url_components = parse_url($url);   
            parse_str($url_components['query'], $params); 
            $param = $params['SinglePieceStockId'];
			$videoImageUrl['videoUrl'] = 'https://www.blgd.in/V360Files/'.$param.'/'.$param.'.html';
            $videoImageUrl['imageUrl'] = make_diamond_image($url);
		}
		else{
			$videoImageUrl['videoUrl'] = $url;
			$videoImageUrl['imageUrl'] = make_diamond_image($url);
		}
        return $videoImageUrl;
    }
}
if ( ! function_exists( 'getCertificateUrl' ) ) {
	function getCertificateUrl($url='', $CertType ='',$CertNo='')
    {
		$certiUrl = $url;
		if($CertType !='' && $CertNo != ''){
			if(strpos($url, 'dtol-cert-images.s3-website-us-east-1.amazonaws.com/') !== false && $CertType=='IGI'){
				$certiUrl = "https://www.igi.org/viewpdf.php?r=".str_replace('LG', '', $CertNo);
			}elseif(strpos($url, 'dtol-cert-images.s3.amazonaws.com/') !== false && $CertType=='IGI'){
                $certiUrl = "https://www.igi.org/viewpdf.php?r=".str_replace('LG', '', $CertNo);
            }
			elseif(((strpos($url, 'https://igionline.com/viewpdf.htm?itemno=') !== false) && (strpos($url, 'LG1') === false)) || (strpos($url, 'https://www.igi.org/viewpdf.php?r=') !== false) || (strpos($url, 'https://www.igi.org/reports/verify-your-report?r=') !== false) ||(strpos($url, 'https://www.igi.org/reports/verify_your_report?r=') !== false)|| (strpos($url, 'https://igi.org/verify.php?r=') !== false)){
				$certiUrl = "https://www.igi.org/viewpdf.php?r=".$CertNo;
			}
			elseif((strpos($url, '.pdf') !== false) && ($CertType=='IGI')){
				$certiUrl = "https://igionline.com/viewpdf.htm?itemno=LG".str_replace('LG', '', $CertNo);
			}elseif (strpos($url, 'app.lgdtrade.//assets/uploads/Media_Certificate') !== false && $CertType=='IGI') {
				$certiUrl = "https://www.igi.org/viewpdf.php?r=".str_replace('LG', '', $CertNo);
			}elseif ($CertType=='IGI' && $url=='') {
                $certiUrl = "https://www.igi.org/viewpdf.php?r=LG".str_replace('LG', '', $CertNo);
            }elseif((strpos($url, 'igiworldwide.com') !== false) && ($CertType=='IGI')){
                $certiUrl = "https://www.igi.org/viewpdf.php?r=".$CertNo;
                
            }
		}
		return $certiUrl;
	}
}
function createFolder($path)
{
	$folderPath = $path.'archives';
	if (is_dir($folderPath) === false) {
		mkdir($folderPath);
	}
}
if ( ! function_exists( 'moveToArchives' ) ) {
	function moveToArchives($folderpath,$csvName)
	{
		$srcPath = $folderpath.$csvName; 
		$ak = $folderpath.'archives/'.str_replace('.csv', '', $csvName).'-'.time().'.csv';
		createFolder($folderpath);
		if (!@copy($srcPath,$ak)) {
			$errors= error_get_last();
			echo "COPY ERROR: ".$errors['type'];
			echo "<br />\n".$errors['message'];
		}else{
			//unlink($srcPath);
            $files = glob($folderpath . "*.csv", GLOB_NOSORT);
            foreach($files as $file) {   
                if(is_file($file)){
                    // Delete the given file 
                    unlink($file);
                }
            } 
			deleteSevenDaysOldFiles($folderpath);
		}
	}
}
if ( ! function_exists( 'deleteSevenDaysOldFiles' ) ) {
	function deleteSevenDaysOldFiles($folderpath)
	{
		$days = 7;  
        $path = $folderpath.'archives/';  
        // Open the directory  
        if ($handle = opendir($path))  
        {  
            // Loop through the directory  
            while (false !== ($file = readdir($handle)))  
            {  
                // Check the file we're doing is actually a file  
                if (is_file($path.$file))  
                {  
                    // Check if the file is older than X days old  
                    if (filemtime($path.$file) < ( time() - ( $days * 24 * 60 * 60 ) ) )  
                    {  
                        // Do the deletion  
                        unlink($path.$file);  
                    }  
                }  
            }  
        }
	}
}
if ( ! function_exists( 'checkUrlValidation' ) ) {
	function checkUrlValidation($url="")
	{
		$returnUrl = '';
		if($url != ''){
			$headers = @get_headers($url);   
			// Use condition to check the existence of URL 
			if($headers && strpos( $headers[0], '200')) { 
				$returnUrl = $url; 
			} 
			else { 
				$returnUrl = ''; 
			} 
		}
		return $returnUrl;
	}
}
if ( ! function_exists( 'generateSku' ) ) {
	function generateSku($type ='')
	{
		global $wpdb;
        $string = '0123456789'.time();
        if($type=='LG'){
            $sku='LG'.mt_rand_str(7, $string);  
        }else{
        $sku=mt_rand_str(7, $string);  
        }	
        return $sku;
	}
}

if ( ! function_exists( 'checkCertificateNum' ) ) {
    function checkCertificateNum($cert, $certType)
    {
        $certificate_num = ($certType == 'GCAL') ? (str_replace("LG","",$cert)) : $cert;
        return $certificate_num;
    }
}
if ( ! function_exists( 'generateStockNumber' ) ) {
    function generateStockNumber($certNum,$type='')
    {
        global $wpdb;
        $rowid = $wpdb->get_results("SELECT id,stockNumber FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$certNum."'");
        if($rowid){
            $lastorder=$rowid[0]->id;
            $stockNumber=$rowid[0]->stockNumber;
            if($stockNumber) {
                return $stockNumber;
            }
        }else{
            $product_lastorder = "SELECT id FROM ".$wpdb->prefix."custom_kdmdiamonds ORDER BY id DESC LIMIT 0,1";
            $item_lastorder=$wpdb->get_results($product_lastorder);
            $lastorder=$item_lastorder[0]->id+1;
        }
        if($type == 'LG')
        {
            $stock_number='LG'.mt_rand_str(3, '0123456789').$lastorder;
        }else{
            $stock_number=mt_rand_str(3, '0123456789').$lastorder;
        }
        return $stock_number;
    }
}
if ( ! function_exists( 'mt_rand_str' ) ) {
	function mt_rand_str($l, $c = 'abcdefghijklmnopqrstuvwxyz1234567890') {
		for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
		return $s;
	}
}
if ( ! function_exists( 'getStatisticsDiamonds' ) ) {
	function getStatisticsDiamonds() {
		global $wpdb;
		$query = $wpdb->get_results("SELECT COUNT(*) as total, T1.vendor, T2.name,T2.source,
		(SELECT  COUNT(*) FROM ".$wpdb->prefix."custom_kdmdiamonds T3 WHERE T3.Image!='' AND T3.vendor=T1.vendor AND T3.status='1') as image_count,
		(SELECT  COUNT(*) FROM ".$wpdb->prefix."custom_kdmdiamonds T4 WHERE T4.VideoLink!='' AND T4.vendor=T1.vendor AND T4.status='1') as video_count, 
		(SELECT  COUNT(*) FROM ".$wpdb->prefix."custom_kdmdiamonds T5 WHERE T5.CertLink!='' AND T5.vendor=T1.vendor AND T5.status='1') as certi_count 
		FROM ".$wpdb->prefix."custom_kdmdiamonds T1
		INNER JOIN ".$wpdb->prefix."custom_kdmvendors T2 ON T1.vendor = T2.id
		WHERE T1.status='1'
		GROUP BY T1.vendor");
		return $query;
	}
}
if ( ! function_exists( 'updateDiamondStatus' ) ) {
	function updateDiamondStatus($delMGDArr,$statusCode) {
		global $wpdb;
		$ids = join("','",$delMGDArr);
		$wpdb->query("UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET status='".$statusCode."' WHERE Style IN ('".$ids."')  AND status!='3' AND status!='4'");

	}
}
if ( ! function_exists( 'deleteDiamondsNotAvailable' ) ) {
	function deleteDiamondsNotAvailable($delMGDArr) {
		global $wpdb;
		$ids = join("','",$delMGDArr);
		$wpdb->query("DELETE T1, T2, T3 FROM `".$wpdb->prefix."custom_kdmdiamonds` T1 INNER JOIN ".$wpdb->prefix."postmeta T2 ON T1.posts_id = T2.post_id INNER JOIN ".$wpdb->prefix."posts T3 ON T1.posts_id = T3.ID WHERE T1.Style IN ('".$ids."')  AND T1.status!='3' AND T1.status!='4'");

	}
}
if ( ! function_exists( 'readCSV' ) ) {
	function readCSV($csvFile)
    {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 20480); //maximum 10mb
        }
        fclose($file_handle);
        return $line_of_text;
    }
}
if ( ! function_exists( 'changeCutGrade' ) ) {
	function changeCutGrade($cut='',$polish='',$symmetry='',$shape='',$CertType='') {
		if(strtoupper($shape) != 'ROUND' && $cut != ''){
			if(($cut == 'preferred')){
				$cut	=	'ideal';
			}else if(($cut == 'above average') || ($cut == 'average') || ($cut == 'olp')){
			  $cut	= 'very good';
			}
		}
		if($cut == '' || $cut == '-')
		{
			$cut    =   'Ideal';
            if(($polish == 'Good') || ($symmetry == 'Good')){
                $cut    =   'Excellent';
            }
            
			
		}
		return $cut;
	}
}
function importQualityGoldVendorDiamonds($QGArr){
	$auth_token = getTokenQualityGold($QGArr);

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://jewelers.services/ProductCore/api/StoneFinder/GetStones",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
    "authorization: Bearer ".$auth_token."",
    "cache-control: no-cache",
    "postman-token: 029ad5a9-ac59-427f-e4ff-ed62c0ba9a5e",
    "referer: ".$QGArr['Referer'].""
    ),
    ));

    $response = curl_exec($curl);
    $json_data = json_decode($response);
    curl_close($curl);
    return $json_data->Stones;
}
function getTokenQualityGold($QGArr){
	$url ='https://jewelers.services/core/token'; 
	//$request_body = array();
	$request_body = "grant_type=password&password=".$QGArr['Password']."@&username=".$QGArr['Username']."";
	$request_headers = array();
	$request_headers[] = "Referer: ".$QGArr['Referer']."";
	$request_headers[] = 'Content-Typ: application/x-www-form-urlencoded';
	$request_headers[] = "AccountId:".$QGArr['AccountId']."";
	//open connection     
	$ch = curl_init();
	//set the url, number of POST vars, POST data    
	curl_setopt($ch,CURLOPT_URL, $url);        
	curl_setopt($ch,CURLOPT_HTTPHEADER, $request_headers);    
	curl_setopt($ch,CURLOPT_POST, true);    
	curl_setopt($ch,CURLOPT_POSTFIELDS, $request_body);    
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);//execute post   
	$result = json_decode(curl_exec($ch), TRUE);//close connection    
	curl_close($ch);  
	return $result['access_token'];
}
//DiamondFoundry
function importDiamondFoundryDiamonds($arr){
    $access_token = getTokenDiamondFoundry($arr);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://rest.diamondfoundry.com/api/v2/diamonds",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: $access_token"
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response);
    return $response;
}
function getTokenDiamondFoundry($arr){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://rest.diamondfoundry.com/login?email=".$arr['email']."&password=".$arr['password'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HEADER=>1,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
    ));
    $response = curl_exec($curl);
    $header_size  =  curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $headers = substr($response, 0, $header_size);
      $body = substr($response, $header_size);      
    curl_close($curl);
    $arr = explode(":", $body);
    return str_replace('X-Request-Id', '', $arr[2]);
}
//Rapnet
function importRapnetDiamonds($arr){
    $tmppath = WP_CONTENT_DIR.'/diamond_uploads/rapnet/';
    if (is_dir($tmppath) === false) {
        mkdir($tmppath);
    }
    $filename = 'latest_diamonds_sells.csv';
    $dealerfile = $tmppath . $filename;
    $access_token = getTokenRapnet($arr);
    $feed_url = "http://technet.rapaport.com/HTTP/DLS/GetFile.aspx";
    $feed_url .= "?ticket=" . $access_token; //add authentication ticket:
    // prepare to save response as file.
    $fp = fopen($dealerfile, 'wb');
    if ($fp == FALSE) {
        echo "ERROR: File not opened<br/>";
        exit;
    }
    $request = curl_init($feed_url); // initiate curl object
    curl_setopt($request, CURLOPT_FILE, $fp); //Ask cURL to write the contents to a file
    curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
    curl_setopt($request, CURLOPT_TIMEOUT, (60 * 60)); //set timeout to 1hr
    $response = curl_exec($request); // execute curl post
    $error = curl_error($request);
    curl_close($request); // close curl object
    fclose($fp); //close file;
    if ($response === false) {
        echo "ERROR: download from TechNet failed: $error<br/>";
        return false;
    }
    //copy($dealerfile,$tmppath.'archives/'.date('Y-m-d H:i:s').'-'.$filename);
}
function getTokenRapnet($arr){
   $auth_url = "https://technet.rapaport.com/HTTP/Authenticate.aspx";
    $post_string = "username=35773&password=" . urlencode('5caa5165');
    $request = curl_init($auth_url); // initiate curl object
    curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
    $auth_ticket = curl_exec($request); // execute curl post and store results in $auth_ticket
    $error = curl_error($request);
    curl_close($request);

    return $auth_ticket;
}

function importDharmaDiamonds($arr){
   $curl = curl_init(); 
    curl_setopt_array($curl, 
    array(   
    //CURLOPT_PORT =>"52789",   
    CURLOPT_URL =>"http://www.dharamhk.com/dharamwebapi/api/StockDispApi/getDiamondData",   
    CURLOPT_RETURNTRANSFER => true,   
    CURLOPT_ENCODING =>"",   
    CURLOPT_MAXREDIRS => 10,   
    CURLOPT_TIMEOUT => 3000,   
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,   
    CURLOPT_CUSTOMREQUEST =>"POST",   
    
    CURLOPT_POSTFIELDS =>"{\n    \n    uniqID : '627',\n    company : 'Dimend Scaasi Ltd',\n    actCode:'IsDi#@123Er',\n    selectAll : '',\n    StartIndex : '1',\n    count : '10000',\n    columns: '',\n    finder : 'Size >= 0.70',\n    sort : ''\n}",   CURLOPT_HTTPHEADER => array( "content-type: application/json"   ), )
    );
    
    $response = curl_exec($curl); 
    $err = curl_error($curl); 
    curl_close($curl); 
    $jsondata = json_decode($response);
    $result = json_decode(json_encode($jsondata->DataList), true);

    return $result;
}
function importExcellentDiamonds($arr){

    /*print_r($arr);
    die;*/
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://webapi.excellentdiamonds.com.hk/DeveloperAPI.svc/Full_Stock_List?username=manage@dscaasi.com&password=Dscaasi65",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response);
    //print_r($response);
    return $response->List;
}
function importEtherealDiamonds($arr){

   $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://etherealdiamond.com/webServices/inventory_API.svc/GetInventory?username=".$arr['username']."&password=".$arr['password']."&action_type=all",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: ASP.NET_SessionId=mi5fgroq10ytz0qzmkoffi45"
      ),
    ));

        $response = curl_exec($curl);
        
    
    $response = json_decode($response);
    $response = json_decode($response->d);

    return $response->RESULT;
}

function importPurestonesDiamonds($apiUrl){

   $curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $apiUrl,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"authorization: Basic SXNhYWNAZHNjYWFzaS5jb206QFY+NmstckdoN183L2RoJg==",
		"cache-control: no-cache",
		"postman-token: fef942c1-1124-12f7-3434-b17c1cbfacef"
	  ),
	));

    $response = curl_exec($curl);
        
    
    curl_close($curl);
	$response = json_decode($response);

    return $response->data;
}

function importNeoDiamonds($arr){
	$token = $arr['api_token'];
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "4000",
	  CURLOPT_URL => "https://api.neolabdiamonds.com:4000/product/GetDiamonds",
	  //CURLOPT_URL => "https://api.neolabdiamonds.com:4000/product/GetTwinDiamonds",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
		"authorization: $token",
		"cache-control: no-cache",
		"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
		"postman-token: d55d9405-a3a5-c445-c6bd-003012556569"
	  ),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$responses = json_decode($response);
	return $responses->data;
}

function importLgdVendorDiamonds($lgdArr){
	// Create a stream
	$access_token = getTokenLgd($lgdArr);
    $auth_url = "https://api.lgdtrade.com/NnV7dV5qC2hlBgFYaXLh/download_diamond";
    $post_string = "access_token=" . $access_token . "";
    $request = curl_init($auth_url);
    curl_setopt($request, CURLOPT_HEADER , 0);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
    $json_data = curl_exec ($request);
    $json_data = json_decode($json_data);
    curl_close($request);
    return $json_data->data;
}
function getTokenLgd(){
	$email =  $lgdArr['Username'] ;
	$password = $lgdArr['Passsword'];
	$auth_url = "https://api.lgdtrade.com/NnV7dV5qC2hlBgFYaXLh/login";
	$post_string = "email=" . $email . "&password=" . $password . "";
	$request = curl_init($auth_url);
	curl_setopt($request, CURLOPT_HEADER , 0);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
	$auth_token = curl_exec ($request);
	$auth_token = json_decode($auth_token);
	curl_close($request);
	return $auth_token->access_token;
}
if ( ! function_exists( 'ulgd_api_diamond_feeds' ) ) {
	function ulgd_api_diamond_feeds(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
						CURLOPT_URL => "http://diamonderp.in/ulgd/PortalAPI/GetStock",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "GET",
						CURLOPT_POSTFIELDS => array(
						'PortalKey' => '563369a5-b225-45a1-a94f-52f1f519e907',
							//'PortalKey' => '8b68eaab-1cc7-4009-a324-386b92daf2f6',
							'FromCarat' => '0',
							'ToCarat' => '50',
							'Shape' => 'Round,Cushion,Emerald,Princess,Asscher,Oval,Radiant,Pear,Marquise,Heart',
							'Color' => 'D,E,F,G,H,I,L',
							'Clarity' => 'I1,SI1,SI2,SI3,VS1,VS2,VVS1,VVS2,FL/IF',
							'Cut' => '',
							'Polish' => '',
							'Symmetry' => '',
							'Fluo' => '',
							'FancyColorIntensity' => '',
							'FancyColorOvertone' => '',
							'FancyColor' => ''
						),
					)
		);
		$response = curl_exec($curl);
		curl_close($curl);
		$Returnobj=json_decode($response); 
		return $Returnobj;
	}
}

function seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku){
	global $wpdb;
	if($shape_cat=="Round"){
        $sale_price = round($diamond_price + $admin_margin);
        $discountArr            =   range(5, 25);
        shuffle($discountArr);
        $getdiscount            =   $discountArr[0];
        $sale_discount          =   ($sale_price)*($getdiscount/100);
        $regular_price          =   round($sale_price + $sale_discount);
    }else{
        $regular_price = round($diamond_price + $admin_margin);
    }
	$post_id   		= $diamond_post_id; 
	if(isset($sale_price)){
	$meta_key1  	= '_regular_price'; 
	$meta_value1	= $regular_price; 
	$meta_key2  	= '_sale_price'; 
	$meta_value2	= $sale_price; 
	$meta_key3  	= '_price'; 
	$meta_value3	= $sale_price; 
    $meta_key4      = '_sku'; 
    $meta_value4    = $Sku;
	/*$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value1' WHERE post_id='$post_id' AND meta_key='$meta_key1'");
	$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value2' WHERE post_id='$post_id' AND meta_key='$meta_key2'");
	$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value3' WHERE post_id='$post_id' AND meta_key='$meta_key3'");
    $wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value4' WHERE post_id='$post_id' AND meta_key='$meta_key4'");*/
    $wpdb->query("UPDATE ".$wpdb->prefix."postmeta
      SET `meta_value` = CASE `meta_key`
        WHEN '$meta_key1' THEN '$meta_value1'
        WHEN '$meta_key2' THEN '$meta_value2'
        WHEN '$meta_key3' THEN '$meta_value3'
        WHEN '$meta_key4' THEN '$meta_value4'
      END
    WHERE `post_id`='$post_id'");

	}else{
		$meta_key1  	= '_regular_price'; 
		$meta_value1	= $regular_price;
		$meta_key3  	= '_price'; 
		$meta_value3	= $regular_price; 
        $meta_key4      = '_sku'; 
        $meta_value4    = $Sku;
		/*$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value1' WHERE post_id='$post_id' AND meta_key='$meta_key1'");
		$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value3' WHERE post_id='$post_id' AND meta_key='$meta_key3'");        
        $wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='$meta_value4' WHERE post_id='$post_id' AND meta_key='$meta_key4'");*/
        $wpdb->query("UPDATE ".$wpdb->prefix."postmeta
          SET `meta_value` = CASE `meta_key`
            WHEN '$meta_key1' THEN '$meta_value1'
            WHEN '$meta_key3' THEN '$meta_value3'
            WHEN '$meta_key4' THEN '$meta_value4'
          END
        WHERE `post_id`='$post_id'");

	}
    
}

function getmetavalues($new_diamond_id,$ShapeCode,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values){
	if($ShapeCode=="Round"){
        $sale_price = round($diamond_price + $admin_margin);
        $discountArr            =   range(5, 25);
        shuffle($discountArr);
        $getdiscount            =   $discountArr[0];
        $sale_discount          =   ($sale_price)*($getdiscount/100);
        $regular_price          =   round($sale_price + $sale_discount);
    }else{
        $regular_price = round($diamond_price + $admin_margin);
    }
	$post_id   		= $new_diamond_id; 
	$meta_key1  	= '_regular_price'; 
	$meta_value1	= $regular_price; 
	$values .= "('$post_id', '$meta_key1', '$meta_value1'),";
	if(!isset($sale_price)){
		$meta_key3  	= '_price'; 
		$meta_value3	= $regular_price; 
		$values .= "('$post_id', '$meta_key3', '$meta_value3'),";
	}else{
		$meta_key2  	= '_sale_price'; 
		$meta_value2	= $sale_price; 
		$values .= "('$post_id', '$meta_key2', '$meta_value2'),";
		$meta_key3  	= '_price'; 
		$meta_value3	= $sale_price; 
		$values .= "('$post_id', '$meta_key3', '$meta_value3'),";
	}

    $meta_key4      = '_sku'; 
    $meta_value4    = $Sku; 
    $values .= "('$post_id', '$meta_key4', '$meta_value4'),";
	return $values;
}



function insert_seo_values($values,$seovalues,$metaquery,$seometaquery){

	global $wpdb;

	$values = substr($values, 0, strlen($values) - 1);

    $insert_query = $metaquery . $values;

    $wpdb->query($insert_query);

    $values='';

    $seovalues = substr($seovalues, 0, strlen($seovalues) - 1);

    $insert_meta_query = $seometaquery . $seovalues;

    $wpdb->query($insert_meta_query);

    $seovalues='';

}
function getTermTaxonomy(){

	global $wpdb;

	$term_id="SELECT t1.term_id,t2.taxonomy FROM ".$wpdb->prefix."terms t1 INNER JOIN ".$wpdb->prefix."term_taxonomy t2 on t1.term_id=t2.term_id WHERE t1.slug = 'diamond'";

		$terms=$wpdb->get_results($term_id,ARRAY_A);
		/*$terms = get_term_by('name', 'Diamond', 'product_cat');
		print_r($terms);
		die;*/
		$terms['term_id']=(int)$terms[0]['term_id'];
		$terms['taxonomy']=$terms[0]['taxonomy'];
		return $terms;

}



function update_posts_table($product_title,$description,$product_name,$diamond_post_id){

	global $wpdb;

	$QGpostsupdate="UPDATE ".$wpdb->prefix."posts SET post_author='1', post_content='".$description."', post_title='".$product_title."', post_excerpt='".$description."', post_name='".sanitize_title($product_name)."', post_modified='".date("Y-m-d H:i:s")."', post_modified_gmt='".date("Y-m-d H:i:s")."', guid='', menu_order='0', post_type='product' WHERE ID='".$diamond_post_id."'";

    $wpdb->query($QGpostsupdate);

}



function insert_posts_table($product_title,$description,$product_name){

	global $wpdb;

	$proinsert="INSERT INTO ".$wpdb->prefix."posts(post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count) VALUES ('1','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$description."','".$product_title."','".$description."','publish','open','closed','','".sanitize_title($product_name)."','','','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','','0','','0','product','','0')";

    $wpdb->query($proinsert);

    return $wpdb->insert_id;

}
remove_filter('sanitize_title', 'sanitize_title_with_dashes');
function sanitize_title_with_dots_and_dashes($title) {
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
        $title = remove_accents($title);
        if (seems_utf8($title)) {
                if (function_exists('mb_strtolower')) {
                        $title = mb_strtolower($title, 'UTF-8');
                }
                $title = utf8_uri_encode($title);
        }
        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = preg_replace('/[^%a-z0-9 ._-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');
        $title = str_replace('-.-', '.', $title);
        $title = str_replace('-.', '.', $title);
        $title = str_replace('.-', '.', $title);
        $title = preg_replace('|([^.])\.$|', '$1', $title);
        $title = trim($title, '-'); // yes, again
        return $title;
}
add_filter('sanitize_title', 'sanitize_title_with_dots_and_dashes'); 

?>