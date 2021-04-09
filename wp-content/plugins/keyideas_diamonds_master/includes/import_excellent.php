<?php 

$vendorArr = import_excellent;
$vendor_code = $vendorArr['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];

$QGcheckArr=custom_get_vendor_diamonds($vendor_id);

$upQGArr= [];
$newQGArr= [];

$diamonds_api = importExcellentDiamonds($vendorArr);

$k=1;
foreach($diamonds_api as $diamonds_feed) {
    $diamonds_feed = json_decode(json_encode($diamonds_feed), true);

    if($k < 10000){
    $Sku                    = $diamonds_feed['Stone_No'];
    $Style_certificate_num  = $diamonds_feed['Certificate_No'];
    

    /*if(strpos($Style_certificate_num, 'LG') == false && $Style_certificate_num!=''){
        $Style_certificate_num='LG'.$Style_certificate_num;
    }*/
    /*echo $Style_certificate_num;
    die;*/
    //$image                  = $diamonds_feed['Image'];
    $ShapeCode=$shape_cat   = GetShapeValue($diamonds_feed['Shape']);

    $Color                  = $diamonds_feed['Color'];
    $Clarity                = $diamonds_feed['Clarity'];
    $Cut                    = GetQualityValue($diamonds_feed['Cut']);
    $SizeCt                 = number_format($diamonds_feed['Cts'],2);
    $SizeMM                 = '';
    
    $CertType               = GetCertTypeValue($diamonds_feed['Lab']);
    //$PriceCt              = $diamonds_feed['PriceCt'];
    //$PctOffRap              = $diamonds_feed['PctOffRap'];
    //$PriceEach              = $diamonds_feed['PriceEach'];
    $Polish                 = GetQualityValue($diamonds_feed['Polish']);
    $Symmetry               = GetQualityValue($diamonds_feed['Symmetry']);
    $DepthPct               = number_format($diamonds_feed['Depth_Per'],1);
    $TablePct               = number_format($diamonds_feed['Table_per'],1);
    $Fluorescence           = GetFluorescenceValue($diamonds_feed['Fluorescence']);
    //$LWRatio                = $diamonds_feed['LWRation'];
    $CertLink               = $diamonds_feed['Certi'];
    $VideoLink              = $diamonds_feed['B2B360Video'];
    $VideoLink = str_replace("&v=2&sv=0,1,2,3,4&z=1&btn=1,2,3,5?s=10", "", $VideoLink);
    $image_Link              = $diamonds_feed['B2BImage'];

    $WholesalePrice         = $diamonds_feed['Sell_Amount'];
    
    /*print_r($VideoLink);
    print_r($WholesalePrice);
    die;*/
    //$WholesalePrice       = round($diamonds_feed['RetailPrice']); // temporary fix
    $Measurements           =   $diamonds_feed['Measurement'];
    $ImageZoomEnabled       = $diamonds_feed['ImageZoomEnabled'];
    $ShapeDescription       = $diamonds_feed['ShapeDescription'];
    $Cal_priceCt            = (($WholesalePrice)/($SizeCt));
    $PriceCt                = $diamonds_feed['Sell_Rate'];        // PricePerCt


    // Measurements
    if(!empty($Measurements)){
        $MeasurementsArr=explode('x', $Measurements);
        $Length=$MeasurementsArr[0];
        $Width = $MeasurementsArr[1];
        $Depth = $MeasurementsArr[2];
        $Measurements = trim($Length).'*'.trim($Width).'*'.trim($Depth);
        $LWRatio = GetLWRatio($Length,$Width,$Depth);
    }else{
        $Measurements = '';
        $LWRatio = '';
    }
    // $Cut
    if($Cut=='N/A'){
        $Cut = '';
    }else{
        $Cut = $Cut;
    }
    //Stock Number
    $stockNumber=generateStockNumber($Style_certificate_num,$vendorArr['type']);

    // Culet 
    $Culet=$diamonds_feed['Culet'];
    // Girdle
    $Girdle=(!empty($diamonds_feed['Girdle'])?$diamonds_feed['Girdle']:'None');

    $diamond_price = $WholesalePrice;
    if($SizeCt<1){
        $admin_margin = ($diamond_price)*($vendorArr['onect_below_margin_price']/100);
    }
    if($SizeCt>=1){
        $admin_margin = ($diamond_price)*($vendorArr['onect_above_margin_price']/100);
    }
    $Cut = changeCutGrade($Cut,$Polish,$Symmetry,$shape_cat,$CertType);
    $product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
    $product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
    $product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
    $description=make_diamond_description($SizeCt,$Color,$Clarity,$Cut,$ShapeCode,$Style_certificate_num,$CertType,$vendorArr['type']);
    $isFilterValidate = filterValidation($CertType,$shape_cat,$Color,$Clarity,$Cut,$SizeCt,$Polish,$Symmetry,$WholesalePrice,$image_Link,$VideoLink,trim($PriceCt),trim($Style_certificate_num),$Fluorescence,$CertLink,Filters);
    if(!$isFilterValidate){
        $i++;
        continue;
    }
    $terms = getTermTaxonomy();
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
        // SEO DETAILS
        seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
        yoastSeoUpdate($diamond_post_id,$product_title,$description);
    }else{
        $new_diamond_id = insert_posts_table($product_title,$description,$product_name);
        wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
        // SEO DETAILS
        $values =  getmetavalues($new_diamond_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
        $seovalues= getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues); 

        $sqldiamonds2="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id, Sku, Style, stockNumber, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRatio, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$Sku."','".$Style_certificate_num."','".$stockNumber."','".$image_Link."','".$ShapeCode."','".$Color."','".$Clarity."','".$Cut."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$Polish."','".$Symmetry."','".$DepthPct."','".$TablePct."','".$Fluorescence."','".$LWRatio."','".$CertLink."','".$Girdle."','".$VideoLink."','".$Culet."','".$WholesalePrice."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$vendor_id."', '1', '')";
        $wpdb->query($sqldiamonds2);
        $newQGArr[]=$Style_certificate_num;
    }
    }
    $k++;
}
    // Price meta
    insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
    $values='';$seovalues='';
    // GET Delete Products
    $totalQGArr=array_merge($upQGArr,$newQGArr);
    $delQGArr=array_diff($QGcheckArr,$totalQGArr);
    //updateDiamondStatus($delQGArr,'0');
    deleteDiamondsNotAvailable($delQGArr);

?>