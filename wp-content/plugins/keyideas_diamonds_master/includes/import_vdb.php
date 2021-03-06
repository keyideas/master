<?php 
$vendors = $vdbArr['vendors'];
$vendors = array_filter($vendors, function ($var) {
    return ($var['status'] == 1);
});
$type = $vdbArr['Type'];
$authorization = $vdbArr['Auth'];
$vendorIds = array_column($vendors, 'vendor_code');
$ids = join("','",$vendorIds);
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$ids."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);

foreach ($getVendorIds as $value) {
    foreach ($vendors as $key => $k) {
        if($value['vendor_code'] == $k['vendor_code']){
            $vendors[$key]['id'] = $value['id'];
        }
    }
}
$vendorIds = array_column($vendors, 'id');
$QGcheckArr=custom_get_vdb_diamonds($vendorIds);
//print_r($QGcheckArr);
$curl = curl_init();
$upQGArr= [];
$newQGArr= [];
$terms = getTermTaxonomy();
for ($i = 1; $i <= 20; $i++)
{
    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://apiservices.vdbapp.com//v2/diamonds?type=$type&page_number=$i&page_size=500&shapes[]=Round&shapes[]=Pear&shapes[]=Princess&shapes[]=Marquise&shapes[]=Emerald&shapes[]=Asscher&shapes[]=Oval&shapes[]=Radiant&shapes[]=Heart&shapes[]=Cushion&color_from=D&color_to=K&size_from=0.9&size_to=5&clarity_from=FL&clarity_to=SI1",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER => array(
  "Authorization: $authorization"
),
));
$response = curl_exec($curl);
$jsondata = json_decode($response);
$total_diamonds_found = $jsondata->response->body->total_diamonds_found;
$loopCounts = (int)($total_diamonds_found/100)+1;
if($i>$loopCounts){
    break;
}
    $diamonds_api = $jsondata->response->body->diamonds;
    $k=1;
    $ignoredOnSize = 0;
    foreach($diamonds_api as $diamonds_feed) {
        if($k < 8000){
            $diamonds_feed = json_decode(json_encode($diamonds_feed), true);
            $size = $diamonds_feed['size'];
            $vendor_id ='';
            $onect_below_price = 240;
            $onect_above_price = 240;            
            foreach ($vendors as $key => $value) {
                //echo $value['name'];
                if (strcmp(strtoupper($diamonds_feed['vendor_name']), strtoupper($value['name'])) == 0) {
                    $vendor_id =$value['id'];
                    $onect_below_price = $value['onect_below_margin_price'];
                    $onect_above_price = $value['onect_above_margin_price'];
                    break;
                }
            }
            if($vendor_id ==''){   
                continue;
            }
            if (strpos($diamonds_feed['video_url'], 'http://') !== false) {
              continue;
            }
            if (strpos($diamonds_feed['image_url'], 'http://') !== false) {
              continue;
            }
            $Sku                    = $diamonds_feed['stock_num'];
            $Style_certificate_num  = $diamonds_feed['cert_num'];

            if (strpos($diamonds_feed['image_url'], 'bsweb.s3.amazonaws.com') !== false) {
                if (strpos($diamonds_feed['video_url'], 'Viewer4.0/Vision360.html') !== false)
                {
                    $url_components = parse_url($diamonds_feed['video_url']);   
                    parse_str($url_components['query'], $params); 
                    $param = $params['d'];
                    $diamonds_feed['image_url'] = "https://bsweb.s3-ap-southeast-1.amazonaws.com/Media_Files/SRDSIL/VIDEO/Viewer4.0/imaged/$param/still.jpg";
                }
            }
            if($diamonds_feed['vendor_name'] == 'Eco Star' && $diamonds_feed['lab'] == ''){
				$diamonds_feed['lab'] = 'IGI';
			}
            if(trim($diamonds_feed['image_url']) == "https://www.om-barak.com/barak/Output/StoneImages/"){
                continue;
            }
            if (strpos($diamonds_feed['video_url'], 'drive.google.com') !== false) {
              $diamonds_feed['video_url'] = '';
            }
            if (strpos($diamonds_feed['image_url'], 'drive.google.com') !== false) {
              $diamonds_feed['image_url'] = '';
            }
            $image                  = $diamonds_feed['image_url'];
            if(strpos($image,"NoImage.jpg")!==FALSE){
                $image_Link             = $image ;                
            }else{
                $image_Link             = $image;
            }
            
            $ShapeCode=$shape_cat   = GetShapeValue($diamonds_feed['shape']);
            $Color                  = $diamonds_feed['color'];
            $Clarity                = $diamonds_feed['clarity'];
            $Cut		            = GetQualityValue($diamonds_feed['cut']);
            $SizeCt                 = number_format($diamonds_feed['size'],2);
            $SizeMM                 = '';
            $CertType               = GetCertTypeValue($diamonds_feed['lab']);
            $PriceCt              = $diamonds_feed['price_per_carat'];
            $Polish                 = GetQualityValue($diamonds_feed['polish']);
            $Symmetry               = GetQualityValue($diamonds_feed['symmetry']);
            $DepthPct               = number_format($diamonds_feed['depth_percent'], 1);
            $TablePct               = number_format($diamonds_feed['table_percent'], 1);
            $Fluorescence           = 'None';
            $LWRatio                = $diamonds_feed['meas_ratio'];
            $CertLink               = addHttps(getCertificateUrl($diamonds_feed['cert_url'],$CertType,$Style_certificate_num));
            $VideoLink              = $diamonds_feed['video_url'];

            
            $WholesalePrice         = $diamonds_feed['total_sales_price'];
            $DiscountWholesalePrice = $diamonds_feed['discount_percent'];
            $Measurements           = isset($diamonds_feed['Measurements'])?$diamonds_feed['Measurements']:'';
            $ImageZoomEnabled       = isset($diamonds_feed['ImageZoomEnabled'])?$diamonds_feed['ImageZoomEnabled']:'';
            $ShapeDescription       = $diamonds_feed['shape_long'];
            $Cal_priceCt            = (($diamonds_feed['total_sales_price'])/($SizeCt));
            // Shape Code
            $Length=$diamonds_feed['meas_length'];
            $Width = $diamonds_feed['meas_width'];
            $Depth = $diamonds_feed['meas_depth'];
            $Measurements = trim($Length).'*'.trim($Width).'*'.trim($Depth);
            if($Measurements == '**'){
                $Measurements = '';
				continue;
            }
            $LWRatio = GetLWRatio($Length,$Width,$Depth);
            if($Cut=='N/A'){
                $Cut = '';
            }else{
                $Cut = $Cut;
            }

            if($type == 'Diamond' && $Cut == 'Good'){
                continue;
            }
            
            //Stock Number
            $stockNumber=generateStockNumber($Style_certificate_num,$vdbArr['type']);
            
            // Culet 
            $Culet=GetCuletValue($diamonds_feed['culet_size']);
            // Girdle
            $Girdle=(!empty($diamonds_feed['girdle_min'])?ucwords($diamonds_feed['girdle_min']):'None');
            $diamond_price = $WholesalePrice;
            if($SizeCt<1){
                $admin_margin = ($diamond_price)*($onect_below_price/100);
            }
            if($SizeCt>=1){
                $admin_margin = ($diamond_price)*($onect_above_price/100);
            }
			$Cut = changeCutGrade($Cut,$Polish,$Symmetry,$shape_cat,$CertType);
            $product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$stockNumber);
            $product_title=trim(str_replace($stockNumber, '', $product_title_raw));
            $product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$stockNumber);
            $description=make_diamond_description($SizeCt,$Color,$Clarity,$Cut,$ShapeCode,$stockNumber,$CertType,$vdbArr['type']);
            
            $isFilterValidate = filterValidation($CertType,$ShapeCode,$Color,$Clarity,$Cut,$SizeCt,$Polish,$Symmetry,$WholesalePrice,$image_Link,$VideoLink,trim($PriceCt),trim($Style_certificate_num),$Fluorescence,$CertLink,Filters,$DepthPct,$TablePct);
            if(!$isFilterValidate){
                continue;
            }
            


            if(in_array($Style_certificate_num, $QGcheckArr)){
                $upQGArr[]=$Style_certificate_num;
                $getpostid="SELECT posts_id FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$Style_certificate_num."'";
                $qgresults=$wpdb->get_results($getpostid);
                $diamond_post_id=$qgresults[0]->posts_id;
                update_posts_table($product_title,$description,$product_name,$diamond_post_id);
                wp_set_object_terms($diamond_post_id, $terms['term_id'], $terms['taxonomy']);
                //stock Number update
                $stockNumberupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET stockNumber='".$stockNumber."' WHERE Style='".$Style_certificate_num."' AND stockNumber=''";
                $wpdb->query($stockNumberupdate);
                //Custom Table Update
                $QGdiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$Sku."',  Style='".$Style_certificate_num."',  Image='".$image_Link."',  ShapeCode='".$shape_cat."',  Color='".$Color."',  Clarity='".$Clarity."',  Cut='".$Cut."',  SizeCt='".$SizeCt."',  SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."',  CertType='".$CertType."',  PctOffRap='".$PctOffRap."',  PriceCt='".$PriceCt."',  PriceEach='".$PriceEach."',  Polish='".$Polish."',  Symmetry='".$Symmetry."',  DepthPct='".$DepthPct."',  TablePct='".$TablePct."',  Fluorescence='".$Fluorescence."',  LWRatio='".$LWRatio."',  CertLink='".$CertLink."',  Girdle='".$Girdle."',  VideoLink='".$VideoLink."',  Culet='".$Culet."',  WholesalePrice='".$WholesalePrice."',  DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."',  ColorRegularFancy='".$ColorRegularFancy."',  Measurements='".$Measurements."',  ImageZoomEnabled='".$ImageZoomEnabled."',  ShapeDescription='".$ShapeDescription."', vendor='".$vendor_id."', status='1', other='' WHERE Style='".$Style_certificate_num."' AND vendor='".$vendor_id."' AND status!='3' AND status!='4'";
                $wpdb->query($QGdiamondupdate);
                if($shape_cat=="RD" || $shape_cat=="Round"){
                    $sale_price = round($diamond_price + $admin_margin);
                    $discountArr            =   range(5, 25);
                    shuffle($discountArr);
                    $getdiscount            =   $discountArr[0];
                    $sale_discount          =   ($sale_price)*($getdiscount/100);
                    $regular_price          =   round($sale_price + $sale_discount);
                }else{
                    $regular_price = round($diamond_price + $admin_margin);
                }
                // SEO DETAILS
                seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
                yoastSeoUpdate($diamond_post_id,$product_title,$description);
   
            }else{
                $new_diamond_id = insert_posts_table($product_title,$description,$product_name);
				wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
                // Postmeta Table          
                $values =  getmetavalues($new_diamond_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
                $seovalues= getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues); 
   
                $sqldiamonds2="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id, Sku, Style, stockNumber, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRatio, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription, vendor,status,other)VALUES('".$new_diamond_id."','".$Sku."','".$Style_certificate_num."','".$stockNumber."','".$image_Link."','".$ShapeCode."','".$Color."','".$Clarity."','".$Cut."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$Polish."','".$Symmetry."','".$DepthPct."','".$TablePct."','".$Fluorescence."','".$LWRatio."','".$CertLink."','".$Girdle."','".$VideoLink."','".$Culet."','".$WholesalePrice."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$vendor_id."', '1', '')";
                $wpdb->query($sqldiamonds2);
                $newQGArr[]=$Style_certificate_num;
            }
        }
        $k++;
    }
    //Price meta
    insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
    $values='';$seovalues='';
    
}
$totalQGArr=array_merge($upQGArr,$newQGArr);
$delQGArr=array_diff($QGcheckArr,$totalQGArr);
deleteDiamondsNotAvailable($delQGArr);
curl_close($curl);
   
?>