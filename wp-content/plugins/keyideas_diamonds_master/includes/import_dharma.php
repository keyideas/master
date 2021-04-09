<?php 

$vendorArr = import_dharma;
$vendor_code = $vendorArr['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];
/*print_r($vendor_id);
die;*/
$vendorCheckArr=custom_get_vendor_diamonds($vendor_id);


/*print_r($vendorCheckArr);
die;*/
//$QGcheckArr=custom_get_vendor_diamonds($vendor_id);
$diamonds_api = importDharmaDiamonds($vendorArr);
$upVendorArr= [];
$newVendorArr= [];
/*echo '<pre>';
print_r($diamonds_api);
die;*/
$i=1;
foreach($diamonds_api as $diamond) {          
    if($i < 8000){        
        $RefNo                  =   $diamond['Ref'];                   // Lot#
        $shape_cat              =   GetShapeValue($diamond['Shape']);       // Shape
        $Color                  =   $diamond['Color'];                  // Color
        $Clarity                =   $diamond['Clarity'];                    // Clarity
        $SizeCt                 =   $diamond['Size'];                 // Weight
        $CertType               =   GetCertTypeValue($diamond['Cert']);  // Lab
        $PropCode               =   GetQualityValue($diamond['Cut']);   // Cut Grade
        $PolishName             =   GetQualityValue($diamond['Polish']);    // Polish
        $SymName                =   GetQualityValue($diamond['Sym']);  // Symmetry
        $FLName                 =   GetFluorescenceValue((!empty($diamond['Flour'])?ucfirst(strtolower($diamond['Flour'])):'None')); // Flouressence
        $Style_certificate_num  =   $diamond['ReportNo'];                   // CertificateNo
        $Measurements                 =   $diamond['M1'].'*'.$diamond['M2'].'*'.$diamond['M3'];                  // Measurements                
        $DepthPer               =   number_format($diamond['Depth'],1);                    // Depth%
        $TablePer               =   number_format($diamond['Table'],1);                 // Table%

        
        $Girdle  = $diamond['Girdle'];
         // Culet
        $Culet = GetCuletValue($Culet);
        //$Location             =   $diamond[19];                   // Origin
        $PriceCt                =   $diamond['Price/Carat'];                    // PricePerCt
        $diamond_price = $PriceCt*$SizeCt ;
        $CertLink               =   addHttps($diamond['CertPDFURL']);   // Certificate URL
                    // Video Link
       /* $VideoPath              =   $diamond['Image URL'];
        $ImagePath = '';*/
        
        $repexten=end(explode('.',$diamond['Image URL']));
        //$imageExten=array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF');
        $imageExten = imageExtension;
        //Filter Validation
        $ImagePath  =   addHttps($diamond['ImageURL']);
        $VideoPath  =   addHttps($diamond['VideoURL']);
        $play_icon = '';
		if((strpos($VideoPath,'?')===false) && ($VideoPath != '')){
			$play_icon = '?play=1';
		}
		elseif($VideoPath != ''){
			$play_icon = 'play=1';
		}else{
			$play_icon = '';
		}
        $VideoPath.=$play_icon;
        if(!empty($Measurements)){
            $MeasurementsArr=explode('*', $Measurements);
            $Length=$MeasurementsArr[0];
            $Width = $MeasurementsArr[1];
            $Depth = $MeasurementsArr[2];
            $Measurements = trim($Length).'*'.trim($Width).'*'.trim($Depth);
            $LWRatio = GetLWRatio($Length,$Width,$Depth);
        }else{
            $Measurements       =   '';
            $LWRatio = '';
        }
        
        // SKU
        if(!empty($RefNo)){
            $Sku=$RefNo;
        }else{
            $Sku=generateSku($vendorArr['type']);
        }
        //Stock Number
        
        $stockNumber=generateStockNumber($Style_certificate_num,$vendorArr['type']);
       
        // Price 
        
        if($SizeCt < 1){
            $admin_margin = ($diamond_price)*($vendorArr['onect_below_margin_price']/100);
        }
        elseif($SizeCt >= 1){
            $admin_margin = ($diamond_price)*($vendorArr['onect_above_margin_price']/100);
        }
        
        $PropCode = changeCutGrade($PropCode,$PolishName,$SymName,$shape_cat,$CertType);
        $product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
        $product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
        $product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
        $description=make_diamond_description($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num,$CertType,$vendorArr['type']);

        $isFilterValidate = filterValidation($CertType,$shape_cat,$Color,$Clarity,$PropCode,$SizeCt,$PolishName,$SymName,$diamond_price,$ImagePath,$VideoPath,trim($PriceCt),trim($Style_certificate_num),$FLName,$CertLink,$filters);
        if(!$isFilterValidate){
            echo "<br>";
            //$i++;
            continue;
        }
        $terms = getTermTaxonomy();

        if(in_array($Style_certificate_num, $vendorCheckArr)){
            
            $upVendorArr[]=$Style_certificate_num;
            $getpostid="SELECT posts_id FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$Style_certificate_num."'";
            $qgresults=$wpdb->get_results($getpostid);
            $diamond_post_id=$qgresults[0]->posts_id;
            update_posts_table($product_title,$description,$product_name,$diamond_post_id);
            wp_set_object_terms($diamond_post_id, $terms['term_id'], $terms['taxonomy']);
            //stock Number update
            $stockNumberupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET stockNumber='".$stockNumber."' WHERE Style='".$Style_certificate_num."' AND stockNumber=''";
            $wpdb->query($stockNumberupdate);
            //Custom Table Update
            $Vendordiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$Sku."', Style='".$Style_certificate_num."', Image='".$ImagePath."', ShapeCode='".$shape_cat."', Color='".$Color."',  Clarity='".$Clarity."', Cut='".$PropCode."', SizeCt='".$SizeCt."', SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."', CertType='".$CertType."', PctOffRap='".$PctOffRap."', PriceCt='".$PriceCt."', PriceEach='".$PriceEach."', Polish='".$PolishName."', Symmetry='".$SymName."',  DepthPct='".$DepthPer."', TablePct='".$TablePer."', Fluorescence='".$FLName."', LWRatio='".$LWRatio."', CertLink='".$CertLink."', Girdle='".$Girdle."', VideoLink='".$VideoPath."', Culet='".$Culet."', WholesalePrice='".$diamond_price."', DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."', ColorRegularFancy='".$ColorRegularFancy."', Measurements='".$Measurements."', ImageZoomEnabled='".$ImageZoomEnabled."', ShapeDescription='".$ShapeDescription."', vendor='".$vendor_id."', status='1', other = '' WHERE Style='".$Style_certificate_num."' AND vendor='".$vendor_id."' AND status!='3' AND status!='4'";

            

            $wpdb->query($Vendordiamondupdate);
            // Postmeta Table 
            seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
            yoastSeoUpdate($diamond_post_id,$product_title,$description);

            
        }else{
            $new_diamond_id = insert_posts_table($product_title,$description,$product_name);
            wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
            //Custom Table
            $jasdiamonds="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id,Sku, Style, stockNumber, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRatio, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$Sku."','".$Style_certificate_num."','".$stockNumber."','".$ImagePath."','".$shape_cat."','".$Color."','".$Clarity."','".$PropCode."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$PolishName."','".$SymName."','".$DepthPer."','".$TablePer."','".$FLName."','".$LWRatio."','".$CertLink."','".$Girdle."','".$VideoPath."','".$Culet."','".$diamond_price."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$vendor_id."', '1', '')";
            $wpdb->query($jasdiamonds); 
            
            $values =  getmetavalues($new_diamond_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
            $seovalues= getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues);
            $newVendorArr[]=$Style_certificate_num;
        }          
    }       
    $i++; 
}
// Price meta
insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
$values='';$seovalues='';
// GET Delete Products  
$totalVendorArr=array_merge($upVendorArr,$newVendorArr);
$delVendorArr=array_diff($vendorCheckArr,$totalVendorArr);
deleteDiamondsNotAvailable($delVendorArr);
    

?>