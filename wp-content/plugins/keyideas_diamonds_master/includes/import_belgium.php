<?php 
$vendorArr =  import_belgium;
$vendor_code = $vendorArr['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];
$BDcheckArr=custom_get_vendor_diamonds($vendor_id);
$upQGArr= [];
$newQGArr= [];
$curl = curl_init();
curl_setopt_array($curl, array(
            CURLOPT_URL => "https://belgiumny.com/api/DeveloperAPI?stock=&APIKEY=".$vendorArr['APIKEY'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => array(),
        )
);
$response = curl_exec($curl);
curl_close($curl);
$response=json_decode($response);
    $diamonds_api =  $response->Stock;
    $k=1;
    $ignoredOnSize = 0;
    foreach($diamonds_api as $diamonds_feed) {
        if($k < 8000){
            $diamonds_feed = json_decode(json_encode($diamonds_feed), true);

            $image                  = $diamonds_feed['ImageLink'];
            if(strpos($image,"NoImage.jpg")!==FALSE){
                $image_Link             = $image ;                
            }else{
                $image_Link             = $image;
            }
            $Sku                    = $diamonds_feed['Stock_No'];
            $path                   =   $diamonds_feed['CertificateLink'];
            $Getcert_no             =   basename($path);        
            $Getcert_no             =   basename($path, ".pdf");
            $Style_certificate_num  = $Getcert_no;
            $ShapeCode=$shape_cat   = GetShapeValue($diamonds_feed['Shape']);
            $Color                  = $diamonds_feed['Color'];
            $Clarity                = $diamonds_feed['Clarity'];
            $Cut                    = GetQualityValue($diamonds_feed['Cut_Grade']);
            $SizeCt                 = number_format($diamonds_feed['Weight'],2);
            $SizeMM                 = '';
            $CertType               = GetCertTypeValue($diamonds_feed['Lab']);
            //$PctOffRap                = $diamonds_feed['PctOffRap'];
            //$PriceCt              = $diamonds_feed['PriceCt'];
            $PriceEach              = $diamonds_feed['COD_Buy_Price'];
            $Polish                 = GetQualityValue($diamonds_feed['Polish']);
            $Symmetry               = GetQualityValue($diamonds_feed['Symmetry']);
            $DepthPct               = number_format($diamonds_feed['DEPTH_PER'], 1);
            $TablePct               = number_format($diamonds_feed['TABLE_PER'], 1);
            $Fluorescence           = isset($diamonds_feed['Fluorescence_Intensity'])?GetFluorescenceValue($diamonds_feed['Fluorescence_Intensity']):'None';
            $LWRatio                = isset($diamonds_feed['Ratio'])?$diamonds_feed['Ratio']:'';
            $CertLink               = getCertificateUrl($diamonds_feed['CertificateLink'],$CertType,$Style_certificate_num);
            $VideoLink              = $diamonds_feed['VideoLink'];
            $WholesalePrice         = ($diamonds_feed['Weight'])*($diamonds_feed['COD_Buy_Price']);
            //$WholesalePrice       = round($diamonds_feed['RetailPrice']); // temporary fix 
            $DiscountWholesalePrice = '';
            $Measurements           = isset($diamonds_feed['Measurements'])?$diamonds_feed['Measurements']:'';
            $ImageZoomEnabled       = isset($diamonds_feed['ImageZoomEnabled'])?$diamonds_feed['ImageZoomEnabled']:'';
            $ShapeDescription       = '';
            $Cal_priceCt            = (($WholesalePrice)/($SizeCt));
            $PriceCt                = number_format($Cal_priceCt,2);        // PricePerCt
            // Shape Code
            if(!empty($Measurements)){
                $DiameterArr=explode("X", $Measurements);
                $Length=$DiameterArr[0];
                $Width=$DiameterArr[1];
                $Depth=$DiameterArr[2];
                $Measurements =  trim($Length).'*'.trim($Width).'*'.trim($Depth);
                $LWRatio = GetLWRatio(trim($Length),trim($Width),trim($Depth));
            }else{
                $Measurements='';
                $LWRatio = '';
            }

            
            if($Cut=='N/A'){
                $Cut = '';
            }else{
                $Cut = $Cut;
            }
            //Stock Number
            $stockNumber=generateStockNumber($Style_certificate_num,$vendorArr['type']);
            // Culet 
            $Culet=GetCuletValue($diamonds_feed['Culet_Size']);
            // Girdle
            $Girdle=(!empty($diamonds_feed['Girdle_Condition'])?ucwords($diamonds_feed['Girdle_Condition']):'None');

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
            //Filter Validation
            $isFilterValidate = filterValidation($CertType,$ShapeCode,$Color,$Clarity,$Cut,$SizeCt,$Polish,$Symmetry,$WholesalePrice,$image_Link,$VideoLink,trim($PriceCt),trim($Style_certificate_num),$Fluorescence,$CertLink,$filters);
            if(!$isFilterValidate){
                continue;
            }
            $terms = getTermTaxonomy();
            if(in_array($Style_certificate_num, $BDcheckArr)){
                $upQGArr[]=$Style_certificate_num;
                $getpostid="SELECT posts_id FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$Style_certificate_num."'";
                $qgresults=$wpdb->get_results($getpostid);
                $diamond_post_id=$qgresults[0]->posts_id;
                update_posts_table($product_title,$description,$product_name,$diamond_post_id);
                if(count($terms)>0){
                wp_set_object_terms($diamond_post_id,  $terms['term_id'],  $terms['taxonomy']);
                }
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
                if(count($terms)>0){
                    wp_set_object_terms($new_diamond_id,  $terms['term_id'],  $terms['taxonomy']);
                }
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
    $delQGArr=array_diff($BDcheckArr,$totalQGArr);
    //updateDiamondStatus($delQGArr,'0');
    deleteDiamondsNotAvailable($delQGArr);
 ?>