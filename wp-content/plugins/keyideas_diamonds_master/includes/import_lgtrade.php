<?php 
$vendors = import_lgtrade['vendors'];
$vendors = array_filter($vendors, function ($var) {
    return ($var['status'] == 1);
});
$vendorIds = array_column($vendors, 'vendor_code');
$ids = join("','",$vendorIds);
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$ids."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
foreach ($getVendorIds as $key => $value) {
    foreach ($vendors as $key => $k) {
        if($value['vendor_code'] == $k['vendor_code']){
           $vendors[$key]['id'] = $value['id'];
        }
    }
}
$vendorIds = array_column($vendors, 'id');
$QGcheckArr=custom_get_vdb_diamonds($vendorIds);
$upQGArr= [];
$newQGArr= [];
    $diamonds_api =  importLgdVendorDiamonds(import_lgtrade);
    $k=1;
    $ignoredOnSize = 0;
    foreach($diamonds_api as $diamonds_feed) {
        if($k < 8000){
            $diamonds_feed = json_decode(json_encode($diamonds_feed), true);
            $vendor_id ='';
            $onect_below_price = '';
            $onect_above_price = '';            
            foreach ($vendors as $key => $value) {
                if (strpos(strtoupper($diamonds_feed['Seller']), strtoupper($value['name'])) !== false) {
                    echo $value['name'];
                    $vendor_id =$value['id'];
                    $onect_below_price = $value['onect_below_margin_price'];
                    $onect_above_price = $value['onect_above_margin_price'];
                    break;
                }
            }
            if($vendor_id ==''){
                continue;
            }
            $Sku                    = $diamonds_feed['Stock_No'];
            $Style_certificate_num  = $diamonds_feed['Certificate_Number'];
            if (strpos($diamonds_feed['Video_Url'], 'https://v360.in/diamondview.aspx') !== false)
            {
                $url_components = parse_url($diamonds_feed['Video_Url']);   
                parse_str($url_components['query'], $params); 
                $param = $params['d'];
                $diamonds_feed['Image_Url'] = "https://s4.v360.in/images/company/239/imaged/$param/still.jpg";
            }
            if (strpos($diamonds_feed['Video_Url'], 'view.gem360.in/gem360') !== false)
            {
                $pos = strpos($diamonds_feed['Video_Url'],"gem360-");
                $param = substr($diamonds_feed['Video_Url'],($pos+7));
                $param = str_replace(".html", "", $param);
                $diamonds_feed['Image_Url'] = "https://view.gem360.in/gem360/$param/thumb.jpg";
            }
            $image                  = $diamonds_feed['Image_Url'];
            if(strpos($image,"NoImage.jpg")!==FALSE){
                $image_Link             = $image ;                
            }else{
                $image_Link             = $image;
            }
            $ShapeCode=$shape_cat   = GetShapeValue($diamonds_feed['Shape']);
            $Color                  = $diamonds_feed['Color'];
            $Clarity                = $diamonds_feed['Clarity'];
            $Cut                    = GetQualityValue($diamonds_feed['Cut']);
            $SizeCt                 = number_format($diamonds_feed['Weight'],2);
            $SizeMM                 = '';
            $CertType               = GetCertTypeValue($diamonds_feed['Lab']);
            //$PctOffRap                = $diamonds_feed['PctOffRap'];
            //$PriceCt              = $diamonds_feed['PriceCt'];
            $PriceEach              = $diamonds_feed['Price_Per_Carat'];
            $Polish                 = GetQualityValue($diamonds_feed['Polish']);
            $Symmetry               = GetQualityValue($diamonds_feed['Symmetry']);
            $DepthPct               = number_format($diamonds_feed['Depth_Percentage'], 1);
            $TablePct               = number_format($diamonds_feed['Table_Percentage'], 1);
            $Fluorescence           = isset($diamonds_feed['Fluorescence'])?GetFluorescenceValue($diamonds_feed['Fluorescence']):'None';
            $LWRatio                = $diamonds_feed['Ratio'];
            $CertLink               = getCertificateUrl($diamonds_feed['Certificate_Url'],$CertType,$Style_certificate_num);
            $VideoLink              = $diamonds_feed['Video_Url'];
            $WholesalePrice         = $diamonds_feed['Final_Amount'];
            //$WholesalePrice       = round($diamonds_feed['RetailPrice']); // temporary fix 
            $DiscountWholesalePrice = '';
            $Measurements           = isset($diamonds_feed['Measurement'])?$diamonds_feed['Measurement']:'';
            $ImageZoomEnabled       = isset($diamonds_feed['ImageZoomEnabled'])?$diamonds_feed['ImageZoomEnabled']:'';
            $ShapeDescription       = '';
            $Cal_priceCt            = (($diamonds_feed['Final_Amount'])/($SizeCt));
            $PriceCt                = number_format($Cal_priceCt,2);        // PricePerCt
            // Shape Code
            if(!empty($Measurements))
            {   
                if(strpos($Measurements,'-')!== false){
                    $MeasurementsArr=explode('-', $Measurements);
                    $Length=$MeasurementsArr[0];
                    $MeasurementsArr1 = explode('x', $MeasurementsArr[1]);
                    $Width = $MeasurementsArr1[0];
                    $Depth = $MeasurementsArr1[1];
                    $Measurements = trim($Length).'*'.trim($Width).'*'.trim($Depth);
                    $LWRatio = GetLWRatio($Length,$Width,$Depth);
                }else{
                    $MeasurementsArr=explode('*', $Measurements);
                    $Length=$MeasurementsArr[0];
                    $Width=$MeasurementsArr[1];
                    $Depth=$MeasurementsArr[2];
                    $Measurements = trim($Length).'*'.trim($Width).'*'.trim($Depth);
                    $LWRatio = GetLWRatio($Length,$Width,$Depth);
                }
            }else{
                $Measurements = '';
                $LWRatio = '';
            }
            if($Cut=='N/A'){
                $Cut = '';
            }else{
                $Cut = $Cut;
            }
            //Stock Number
            $stockNumber=generateStockNumber($Style_certificate_num,import_lgtrade['type']);
            // Culet 
            $Culet=GetCuletValue($diamonds_feed['Culet']);
            // Girdle
            $Girdle=(!empty($diamonds_feed['Girdle_Percentage'])?ucwords($diamonds_feed['Girdle_Percentage']):'None');
            $diamond_price = $WholesalePrice;
            if($SizeCt<1){
                $admin_margin = ($diamond_price)*($onect_below_price/100);
            }
            if($SizeCt>=1){
                $admin_margin = ($diamond_price)*($onect_above_price/100);
            }
            $Cut = changeCutGrade($Cut,$Polish,$Symmetry,$shape_cat,$CertType);
            $product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
            $product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
            $product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
            $description=make_diamond_description($SizeCt,$Color,$Clarity,$Cut,$ShapeCode,$Style_certificate_num,$CertType,import_lgtrade['type']);
            //Filter Validation
            $isFilterValidate = filterValidation($CertType,$ShapeCode,$Color,$Clarity,$Cut,$SizeCt,$Polish,$Symmetry,$WholesalePrice,$image_Link,$VideoLink,trim($PriceCt),trim($Style_certificate_num),$Fluorescence,$CertLink,Filters);
            if(!$isFilterValidate){
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
                $QGdiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$Sku."',  Style='".$Style_certificate_num."',  Image='".$image_Link."',  ShapeCode='".$shape_cat."',  Color='".$Color."',  Clarity='".$Clarity."',  Cut='".$Cut."',  SizeCt='".$SizeCt."',  SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."',  CertType='".$CertType."',  PctOffRap='".$PctOffRap."',  PriceCt='".$PriceCt."',  PriceEach='".$PriceEach."',  Polish='".$Polish."',  Symmetry='".$Symmetry."',  DepthPct='".$DepthPct."',  TablePct='".$TablePct."',  Fluorescence='".$Fluorescence."',  LWRatio='".$LWRatio."',  CertLink='".$CertLink."',  Girdle='".$Girdle."',  VideoLink='".$VideoLink."',  Culet='".$Culet."',  WholesalePrice='".$WholesalePrice."',  DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."',  ColorRegularFancy='".$ColorRegularFancy."',  Measurements='".$Measurements."',  ImageZoomEnabled='".$ImageZoomEnabled."',  ShapeDescription='".$ShapeDescription."', vendor='".$vendor_id."', status='1', other='' WHERE Style='".$Style_certificate_num."' AND status!='3' AND status!='4'";
                $wpdb->query($QGdiamondupdate);
                // SEO DETAILS
                seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
                yoastSeoUpdate($diamond_post_id,$product_title,$description);
            }else{
                $new_diamond_id = insert_posts_table($product_title,$description,$product_name);
                wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
                // SEO DETAILS
               $values =  getmetavalues($new_diamond_id,$ShapeCode,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
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
    deleteDiamondsNotAvailable($delQGArr);
 ?>