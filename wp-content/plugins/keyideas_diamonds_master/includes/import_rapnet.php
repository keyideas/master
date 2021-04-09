<?php 

$vendorArr = import_rapnet;
$vendor_code = $vendorArr['vendor_code'];
$vendor_id = 'RAP';
$getVendorIds="SELECT id,name,vendor_code FROM ".$wpdb->prefix."custom_kdmvendors WHERE source IN ('RAP-API')";
$getVendorIds=$wpdb->get_results($getVendorIds,ARRAY_A);
$vendorIds = array_column($getVendorIds, 'id');
$vendorCheckArr=custom_get_vdb_diamonds($vendorIds);


//$QGcheckArr=custom_get_vendor_diamonds($vendor_id);
$diamonds_api = importRapnetDiamonds($vendorArr);
sleep(5); 
$csvFolderpath = WP_CONTENT_DIR.'/diamond_uploads/rapnet/';
$csvFiles = glob($csvFolderpath . "*.csv", GLOB_NOSORT);
usort($csvFiles, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
$csvfile = $csvFiles[0];
$csvname = str_replace($csvFolderpath,'',$csvfile);
$upVendorArr= [];
$newVendorArr= [];
$allowed    =   array('csv','CSV');
$extension  =   pathinfo($csvname, PATHINFO_EXTENSION);
if(!in_array($extension,$allowed)){
    echo 'Please Upload CSV Format.';
}else{
    if(file_exists($csvfile)) {
        $checkvendors = "SELECT * FROM ".$wpdb->prefix."custom_kdmvendors";
        $vdsrows        = $wpdb->get_results($checkvendors, ARRAY_A);
        $allVendors = array_column($vdsrows, 'id');
        $table_vendors = $wpdb->prefix . 'custom_kdmvendors';
        $file_handle = fopen("$csvfile","r");
        if ($file_handle) {
        } else {
            exit();
        }

        $i=0;        
        $header = fgetcsv($file_handle);
        /*print_r($header);
            die;*/
        while(! feof($file_handle)) {
            $row = fgetcsv($file_handle, 1024);
            $diamond = array_combine($header, $row);            
            if(count($diamond)>0){
                $vendor_code = trim(strrev($diamond['Name Code']));
                if($diamond['Country']=='USA'){
                    $shipdays='3';
                }else{
                    $shipdays='7';
                } 
                if(!in_array($diamond['RapNet Account ID'], $allVendors)){                              
                    $arr = array(
                        'id'=>$diamond['RapNet Account ID'],
                        'name' => $diamond['Seller Name'],
                        'vendor_code' => $vendor_code,
                        'abbreviation' => strrev($vendor_code),
                        'shipdays' => $shipdays,
                        'onect_below_price' => '27',
                        'onect_above_price' => '22',
                        'type' => 'M',
                        'source' => 'RAP-API',
                        'status' => 1
                    );
                    $format = array('%d','%s','%s','%s','%d','%s','%s','%s','%s','%d');
                    $wpdb->insert($table_vendors,$arr,$format);
                    $vendor_id = $wpdb->insert_id;
                    /*echo $vendor_id;
                    die;*/
                }else{

                    /*$update="UPDATE ".$table_vendors." SET id='".$diamond['RapNet Account ID']."', name='".$diamond['Seller Name']."',  vendor_code='".$vendor_code."',  abbreviation='".strrev($vendor_code)."',  shipdays='".$shipdays."',  onect_below_price='27',  onect_above_price='22',  type='M',  source='RAP-API',  status='1' WHERE vendor_code='".$vendor_code."' AND status='1'";
                    $wpdb->query($update);*/ 
                    $getVendor = array_filter($vdsrows, function ($var) use ($diamond){
                        
                        return ($var['id'] == $diamond['RapNet Account ID']);
                    });

                    

                    foreach ($getVendor as $key => $value) {
                       $vendor_id = $value['id'];
                       if($value['status']!=1){
                        continue;
                       }
                    }

                }
                
                $RefNo                  =   $diamond['Stock Number'];                   // Lot#
                $shape_cat              =   GetShapeValue($diamond['Shape']);       // Shape
                $Color                  =   $diamond['Color'];                  // Color
                $Clarity                =   $diamond['Clarity'];                    // Clarity
                $SizeCt                 =   $diamond['Weight'];                 // Weight
                $CertType               =   GetCertTypeValue($diamond['Lab']);  // Lab
                $PropCode               =   GetQualityValue($diamond['Cut']);   // Cut Grade
                $PolishName             =   GetQualityValue($diamond['Polish']);    // Polish
                $SymName                =   GetQualityValue($diamond['Symmetry']);  // Symmetry
                $FLName                 =   GetFluorescenceValue((!empty($diamond['Fluorescence Intensity'])?ucfirst(strtolower($diamond['Fluorescence Intensity'])):'None')); // Flouressence
                $Style_certificate_num  =   $diamond['Certificate Number'];                   // CertificateNo
                $Measurements                 =   $diamond['Measurements'];                  // Measurements                
                $DepthPer               =   number_format($diamond['Depth Percent'],1);                    // Depth%
                $TablePer               =   number_format($diamond['Table Percent'],1);                 // Table%

                if(!empty($diamond['Girdle Min']) && !empty($diamond['Girdle Max'])){
                    $Girdle                 =   $diamond['Girdle Min'].' - '.$diamond['Girdle Max'];
                }else if(empty($diamond['Girdle Min']) && empty($diamond['Girdle Max'])){
                    $Girdle  = 'None';
                }else{
                    $Girdle  = $diamond['Girdle Min'].$diamond['Girdle Max'];
                }
                
                $Culet                  =   GetCuletValue($diamond['Culet']); // Culet
                //$Location             =   $diamond[19];                   // Origin
                $PriceCt                =   $diamond['Price Per Carat'];                    // PricePerCt
                $diamond_price = $diamond['Total Price'];
                $CertLink               =   addHttps(getCertificateUrl($diamond['Certificate URL'],$CertType,$Style_certificate_num));   // Certificate URL
                            
                
                $repexten=end(explode('.',$diamond['Image URL']));
                //$imageExten=array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF');
                $imageExten = imageExtension;
                //Filter Validation
                if(!in_array($repexten,$imageExten))
                {
                    $VideoPath  =   $diamond['Image URL'];
                    $ImagePath  =   getSegomaImage(addHttps($diamond['Image URL']),$diamond["Stock Number"],$diamond['Certificate Number']);
                    
                }else{
                    $VideoPath  =  '';
                    $ImagePath = addHttps($diamond['Image URL']);
                }
                $VideoPath = getVideoUrl($VideoPath,$diamond['Stock Number']);
                
                if(!empty($Measurements)){
                    $MeasurementsArr=explode('x', $Measurements);
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
                
                
                
                $PropCode = changeCutGrade($PropCode,$PolishName,$SymName,$shape_cat,$CertType);
                $product_title_raw=make_diamond_name($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
                $product_title=trim(str_replace($Style_certificate_num, '', $product_title_raw));
                $product_name=make_diamond_seo_url($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num);
                $description=make_diamond_description($SizeCt,$Color,$Clarity,$PropCode,$shape_cat,$Style_certificate_num,$CertType,$vendorArr['type']);

                $isFilterValidate = filterValidation($CertType,$shape_cat,$Color,$Clarity,$PropCode,$SizeCt,$PolishName,$SymName,$diamond_price,$ImagePath,$VideoPath,trim($PriceCt),trim($Style_certificate_num),$FLName,$CertLink,$filters);


                if(!$isFilterValidate){
                    echo " $Style_certificate_num $vendor_id <br>";
                    continue;
                }

                if($SizeCt < 1){
                    $admin_margin = ($diamond_price)*($vendorArr['onect_below_margin_price']/100);
                }
                elseif($SizeCt >= 1){
                    $admin_margin = ($diamond_price)*($vendorArr['onect_above_margin_price']/100);
                }
                $terms = getTermTaxonomy();

                if(in_array(trim($Style_certificate_num), $vendorCheckArr)){
                    
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
        moveToArchives($csvFolderpath,$csvname);
    }else{      
        //moveToArchives($csvFolderpath,$csvname);
    }
    display_message($startTime,$vendorCheckArr,$upVendorArr,$newVendorArr,$delVendorArr);
}

?>