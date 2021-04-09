<?php 
$vendorArr = import_angel;
$srdFolderpath = $vendorArr['csv_file_path'];
if(isset($_FILES['GRDcsv']['name']) && $_FILES['GRDcsv']['name'] != ''){
    $csvname    =   $_FILES['GRDcsv']['name'];
}
else{
    $csvFiles = glob($srdFolderpath . "*.csv", GLOB_NOSORT);
    usort($csvFiles, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
    $latestCsvFile = $csvFiles[0];
    $csvname = str_replace($srdFolderpath,'',$latestCsvFile);
}
$vendor_code = $vendorArr['vendor_code'];
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE vendor_code IN ('".$vendor_code."')";
$getVendorIds=$wpdb->get_results($getVendorIds);
$getVendorIds = json_decode(json_encode($getVendorIds), true);
$vendor_id = $getVendorIds[0]['id'];
$filters = Filters;
$allowed    =   array('csv','CSV');
$extension  =   pathinfo($csvname, PATHINFO_EXTENSION);
if(!in_array($extension,$allowed)){
    echo 'Please Upload CSV Format.';
}else{  
    $AScheckArr=custom_get_vendor_diamonds($vendor_id);
    $upGRDArr= [];
    $newGRDArr= [];

    if(isset($_FILES['GRDcsv']['name']) && $_FILES['GRDcsv']['name'] != ''){
        $csv_tmpname= $_FILES['GRDcsv']['tmp_name'];
        $csvfile    = $srdFolderpath.$csvname;
        $move_uploaded_file = move_uploaded_file($csv_tmpname, $csvfile);
    }else{
        $csvFiles = glob($srdFolderpath . "*.csv", GLOB_NOSORT);
        $csvfile = $csvFiles[0];
        $csvname = str_replace($srdFolderpath,'',$latestCsvFile);
    }
    if(file_exists($csvfile)) {
        $file_handle = fopen("$csvfile","r");
        $i=0;
        while(! feof($file_handle)) {
            $Columnsdata = fgetcsv($file_handle, 1024);
            /*print_r($Columnsdata);
            die;*/
            if(!empty($Columnsdata)){
                if($i>0 ) {
                    $RefNo                  =   $Columnsdata[0];                    // Lot#
                    $shape_cat              =   GetShapeValue($Columnsdata[2]);     // Shape
                    $Color                  =   $Columnsdata[4];                    // Color
                    $Clarity                =   $Columnsdata[5];                    // Clarity
                    $SizeCt                 =   $Columnsdata[3];                    // Weight
                    $CertType               =   GetCertTypeValue($Columnsdata[12]); // Lab
                    $Cut                    =   GetQualityValue($Columnsdata[6]);  // Cut Grade
                    $PolishName             =   GetQualityValue($Columnsdata[7]);  // Polish
                    $SymName                =   GetQualityValue($Columnsdata[8]);  // Symmetry
                    $FLName                 =   GetFluorescenceValue((!empty($Columnsdata[9])?ucfirst(strtolower($Columnsdata[9])):'None')); // Flouressence
                    $Style_certificate_num  =   str_replace('\'', '', $Columnsdata[13]) ;                   // CertificateNo

                    $DepthPer               =   number_format($Columnsdata[23],1);                  // Depth%
                    $TablePer               =   number_format($Columnsdata[24],1);                  // Table%
                    $Girdle  = 'None';
                    if(!empty($Columnsdata[25]) && !empty($Columnsdata[26])){
                        $Girdle                 =   $Columnsdata[25].' TO '.$Columnsdata[26];
                    }
                      // Girdle
                    /*$Culet                  =   (!empty($Columnsdata[30])?ucfirst(strtolower($Columnsdata[30])):'None');    // Culet*/
                    if($Columnsdata[29]!='PO')
                    {
                    $Culet              =   GetCuletValue($Columnsdata[29]).' '.$Columnsdata[30];
                    }else{
                        $Culet          =   $Columnsdata[30];
                    }
                    if($Culet==''){
                        $Culet='None';
                    }
                    $PriceCt                =   $Columnsdata[17];                    // PricePerCt
                    $CertLink               =   '';         // Certificate URL
                    $ImagePath              =   $Columnsdata[45];                   // Image
                    $VideoPath              =   $Columnsdata[46];                  // Video Link
                    if(strpos($VideoPath,"&zoomslide=1")!==FALSE){
                        $VideoPath = str_replace('&zoomslide=1', '', $VideoPath);
                    }
                    
                    // Measurements 
                    $Measurements = $Columnsdata[11];   
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
                    // Culet
                    $Culet = GetCuletValue($Culet);
                    // Price 
                    $diamond_price = $Columnsdata[15];
                    if($SizeCt < 1){
                        $admin_margin = ($diamond_price)*($vendorArr['onect_below_margin_price']/100);
                    }
                    elseif($SizeCt >= 1){
                        $admin_margin = ($diamond_price)*($vendorArr['onect_above_margin_price']/100);
                    }
                    $Cut = changeCutGrade($Cut,$PolishName,$SymName,$shape_cat,$CertType);
                    $product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
                    $product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
                    $product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num);
                    $description=make_diamond_description($SizeCt,$Color,$Clarity,$Cut,$shape_cat,$Style_certificate_num,$CertType,$vendorArr['type']);
                    $repexten=end(explode('.',$ImagePath));
                    //$imageExten=array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF');
                    $imageExten = imageExtension;
                    //Filter Validation
                    if(!in_array($repexten,$imageExten))
                    {
                        $ImagePath ='' ;
                    }
                    $isFilterValidate = filterValidation($CertType,$shape_cat,$Color,$Clarity,$Cut,$SizeCt,$PolishName,$SymName,$diamond_price,$ImagePath,$VideoPath,trim($PriceCt),trim($Style_certificate_num),$FLName,$CertLink,$filters);
                    if(!$isFilterValidate){
                        continue;
                    }
                    $terms = getTermTaxonomy();
                    if(in_array($Style_certificate_num, $AScheckArr)){
                        $upGRDArr[]=$Style_certificate_num;
                        $getpostid="SELECT posts_id FROM ".$wpdb->prefix."custom_kdmdiamonds WHERE Style='".$Style_certificate_num."'";
                        $qgresults=$wpdb->get_results($getpostid);
                        $diamond_post_id=$qgresults[0]->posts_id;
                        update_posts_table($product_title,$description,$product_name,$diamond_post_id);
                        wp_set_object_terms($diamond_post_id, $terms['term_id'], $terms['taxonomy']);
                        //stock Number update
                        $stockNumberupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET stockNumber='".$stockNumber."' WHERE Style='".$Style_certificate_num."' AND stockNumber=''";
                        $wpdb->query($stockNumberupdate);
                        //Custom Table Update
                        $GRDdiamondupdate="UPDATE ".$wpdb->prefix."custom_kdmdiamonds SET Sku='".$Sku."', Style='".$Style_certificate_num."', Image='".$ImagePath."', ShapeCode='".$shape_cat."', Color='".$Color."',  Clarity='".$Clarity."', Cut='".$Cut."', SizeCt='".$SizeCt."', SizeMM='".$SizeMM."',  SizeMMChar='".$SizeMMChar."', CertType='".$CertType."', PctOffRap='".$PctOffRap."', PriceCt='".$PriceCt."', PriceEach='".$PriceEach."', Polish='".$PolishName."', Symmetry='".$SymName."',  DepthPct='".$DepthPer."', TablePct='".$TablePer."', Fluorescence='".$FLName."', LWRatio='".$LWRatio."', CertLink='".$CertLink."', Girdle='".$Girdle."', VideoLink='".$VideoPath."', Culet='".$Culet."', WholesalePrice='".$diamond_price."', DiscountWholesalePrice='".$DiscountWholesalePrice."',  RetailPrice='".$RetailPrice."', ColorRegularFancy='".$ColorRegularFancy."', Measurements='".$Measurements."', ImageZoomEnabled='".$ImageZoomEnabled."', ShapeDescription='".$ShapeDescription."', vendor='".$vendor_id."', status='1', other = '' WHERE Style='".$Style_certificate_num."' AND status!='3' AND status!='4'";
                        $wpdb->query($GRDdiamondupdate);
                        $sale_price = '';
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
                        // Postmeta Table Update
                        seo_details_update($diamond_post_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku);
                        yoastSeoUpdate($diamond_post_id,$product_title,$description);
                    }else{
                        $new_diamond_id = insert_posts_table($product_title,$description,$product_name);
                        wp_set_object_terms($new_diamond_id, $terms['term_id'], $terms['taxonomy']);
                        //Custom Table
                        $grddiamonds="INSERT INTO ".$wpdb->prefix."custom_kdmdiamonds(posts_id,Sku, Style, stockNumber, Image, ShapeCode, Color, Clarity, Cut, SizeCt, SizeMM, SizeMMChar, CertType, PctOffRap, PriceCt, PriceEach, Polish, Symmetry, DepthPct, TablePct, Fluorescence, LWRatio, CertLink, Girdle, VideoLink, Culet, WholesalePrice, DiscountWholesalePrice, RetailPrice, ColorRegularFancy, Measurements, ImageZoomEnabled, ShapeDescription,vendor,status,other)VALUES('".$new_diamond_id."','".$Sku."','".$Style_certificate_num."','".$stockNumber."','".$ImagePath."','".$shape_cat."','".$Color."','".$Clarity."','".$Cut."','".$SizeCt."','".$SizeMM."','".$SizeMMChar."','".$CertType."','".$PctOffRap."','".$PriceCt."','".$PriceEach."','".$PolishName."','".$SymName."','".$DepthPer."','".$TablePer."','".$FLName."','".$LWRatio."','".$CertLink."','".$Girdle."','".$VideoPath."','".$Culet."','".$diamond_price."','".$DiscountWholesalePrice."','".$RetailPrice."','".$ColorRegularFancy."','".$Measurements."','".$ImageZoomEnabled."','".$ShapeDescription."','".$vendor_id."', '1', '')";
                        $wpdb->query($grddiamonds);
                        // SEO DETAILS                      
                        $values =  getmetavalues($new_diamond_id,$shape_cat,$diamond_price,$admin_margin,$product_title,$description,$Sku,$values); 
                        $seovalues= getyoastseovalues($new_diamond_id,$product_title,$description,$seovalues);  
                        $newGRDArr[]=$Style_certificate_num;
                    }   
                }
            }       
            $i++; 
        }       
        // Price meta
        insert_seo_values($values,$seovalues,$metaquery,$seometaquery);
        $values='';$seovalues='';
        // GET Delete Products
        $totalGRDArr=array_merge($upGRDArr,$newGRDArr);
        $delGRDArr=array_diff($AScheckArr,$totalGRDArr);
        //updateDiamondStatus($delGRDArr,'0');
        deleteDiamondsNotAvailable($delGRDArr);
        moveToArchives($srdFolderpath,$csvname);
    }
    display_message($startTime,$AScheckArr,$upGRDArr,$newGRDArr,$delGRDArr);

}
?>