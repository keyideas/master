<?php
global $wpdb;
$page = $_GET["page"];
if($page!=''){ $page_val = $_GET["page"]; }else {$page_val=1;}

/*********shape filter************************/

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (strpos($actual_link,'round') !== false) {
  $shape_name_men='Round';
}elseif(strpos($actual_link,'princess') !== false){
  $shape_name_men='Princess'; 
}elseif(strpos($actual_link,'cushion') !== false){
  $shape_name_men='Cushion';
}elseif(strpos($actual_link,'emerald') !== false){
  $shape_name_men='Emerald';
}elseif(strpos($actual_link,'pear') !== false){
  $shape_name_men='Pear';
}elseif(strpos($actual_link,'oval') !== false){
  $shape_name_men='Oval';
}elseif(strpos($actual_link,'radiant') !== false){
  $shape_name_men='Radiant';
}elseif(strpos($actual_link,'asscher') !== false){
  $shape_name_men='Asscher';
}elseif(strpos($actual_link,'marquise') !== false){
  $shape_name_men='Marquise';
}elseif(strpos($actual_link,'heart') !== false){
  $shape_name_men='Heart';
}else{
  $shape_val=$_GET['shape'];
  if($shape_val!='')
  {
    $shape_name_men=$shape_val;
  }else{
    $shape_name_men='';
  }
}

$shape = array();


$result_val = filter_curl_function();
/* $file_min_data ="http://keyideasglobal.com/qa/thediamondart/wp-json/diamond/v1/filterdata";
$data_min_max = file_get_contents($file_min_data);
$result_val = json_decode($data_min_max, true); */

/*********carat filter************************/

//$quick_ship= $result_val['shipdays'];
$videofilter= $result_val['360view'][0]['available'];
$videofilterg=$_GET['available'];
if($videofilterg!=''){
  $videofilter_val = $_GET['available'];
}else{
  $videofilter_val = $videofilter;
}

$carat_min = $result_val['carat'][0]['mincarat'];
$carat_max = $result_val['carat'][0]['maxcarat'];
$carat_min_g = $_GET['carat_min'];
$carat_max_g = $_GET['carat_max'];
if($carat_min_g!=''){
  $carat_min_val = $_GET['carat_min'];
}else{
  $carat_min_val = $carat_min;
}
if($carat_max_g!=''){
  $carat_max_val = $_GET['carat_max'];
}else{
  $carat_max_val = $carat_max;
}


/*********price filter ************************/
$currency = get_woocommerce_currency_symbol();
$min_price = $result_val['price'][0]['minprice'];
$max_price = $result_val['price'][0]['maxprice'];
$price_min = $_GET['price_min'];
$price_max = $_GET['price_max'];
if($price_min!='')
{
  $price_min_val = $_GET['price_min'];
}else{
  $price_min_val =$min_price;
}
if($price_max!='')
{
  $price_max_val = $_GET['price_max'];
}else{
  $price_max_val = $max_price;  
}
/*********Depth filter ************************/
$min_depth = $result_val['depth'][0]['mindepth'];
$max_depth = $result_val['depth'][0]['maxdepth'];
$depth_min = $_GET['depth_min'];
$depth_max = $_GET['depth_max'];
if($depth_min!='')
{
  $min_depth_val = $_GET['depth_min'];
}else{
  $min_depth_val =$min_depth;
}
if($depth_max!='')
{
  $depth_max_val = $_GET['depth_max'];
}else{
  $depth_max_val = $max_depth;
}

/*********Table filter ************************/
$min_table = $result_val['table'][0]['mintable'];
$max_table = $result_val['table'][0]['maxtable'];
$table_min = $_GET['table_min'];
$table_max = $_GET['table_max'];

if($table_min!='')
{
  $table_min_val = $_GET['table_min'];
}else{
  $table_min_val =$min_table;
}
if($table_max!='')
{
  $table_max_val = $_GET['table_max'];
}else{
  $table_max_val = $max_table;
} 

/*********ratio filter ************************/

$min_ratio = $result_val['lwratio'][0]['minlwratio'];
$max_ratio = $result_val['lwratio'][0]['maxlwratio'];
$ratio_min = $_GET['ratio_min'];
$ratio_max = $_GET['ratio_max'];
if($ratio_min!=''){
  $ratio_min_val = $_GET['ratio_min'];
}else{
  $ratio_min_val = $min_ratio;
}
if($ratio_max!=''){
  $ratio_max_val = $_GET['ratio_max'];
}else{
  $ratio_max_val = $max_ratio;
}

/*********polish,symmetry,lab,fluorescence filter ************************/
$polish_max = $_GET['polish'];
$symmetry_min = $_GET['symmetry'];
$lab_max = $_GET['lab'];
$fluorescence_max = $_GET['fluorescence'];
$wr_style_get = $_GET['switch'];
$color_max_col = $_GET['color'];
$cut = $_GET['cut'];
$clarity_max_cal = $_GET['clarity'];

/*********vendor filter ************************/
$vendor=$_GET['vendor'];
if($vendor!=''){ 
  $vendor_name=$_GET['vendor'] ;
}else{
  $vendor_name='';
}
$order_by = $_GET['orderby'];
$mind_lg = $_GET['diamond_type'];
$fluorescence = $_GET['fluorescence'];
$fluor_count = $_GET['fluor_count'];
if($fluor_count!=''){
  $fluor_counts = explode(",",$fluor_count);
  $flur_1 = $fluor_counts[0];
  $flur_2 = $fluor_counts[1];
}else{
  $flur_1 = 0;
  $flur_2 = 5;
}

$array_vallab =$_GET['lab'];
if($array_vallab!='') {
  $array_vallab = explode(",",$array_vallab);
}

$mind_lgs = $_GET['diamond_type'];
if($mind_lgs!='') {
  $mind_lgs = explode(",",$mind_lgs);
}

/* echo "<pre>";
print_r($result_val);
echo "</pre>"; */

//print_r($result_val['fluorescence']);

if ( wp_is_mobile() ) :
?>
  <!--// Display and echo mobile specific stuff here -->
  <!--// Mobile Filters-->
  <div class="filter-section">
    <div class="filter-top">
      <div class="filterBy">
        <h4>
          Filter By
          <div class="recet_filter_button" style="<?php if(!empty($_GET)){ echo "display:block"; }else{ echo "display:none"; } ?>">
            <button class="button recet_filter_button_value">Clear All</button>
          </div>
        </h4>
      </div>

      <div class="toggle-row">
        <div class="view-avail">
          <p>360 view Availaible <i class="fa fa-info-circle" aria-hidden="true"></i></p>
          <div class="view-toggle-btn">
            <!-- Rounded switch -->
            <label class="switch">
              <input type="checkbox"  name="videofilter" id="videofilter" value="<?php echo $videofilter_val ; ?>">
              <span class="slide round videofilter"></span>
            </label>
          </div>
        </div>
        <div class="view-avail">
          <p>Quick Ship Diamond <i class="fa fa-info-circle" aria-hidden="true"></i></p>
          <div class="view-toggle-btn">
            <!-- Rounded switch -->
            <label class="switch">
              <input type="checkbox" id="Orderbyquickship-asc" name="quick_ship" value="quick_ship">
              <span class="slide round quick_ship" id="Orderbyquickship-asc"></span>
            </label>
          </div>
        </div>
      </div>
      
      <!-- Filter By Shape -->
      <div class="shapes gbl-spacing">
        <div class="filter-heading">Shape <span><i class="fa fa-question-circle" aria-hidden="true"></i></span></div>
        <ul class="diamond_shape_ul">
          <li class="diamond_shape_li nu_round <?php if($shape_name_men=='Round'){ echo "active" ;}?>" for="Round" site_url_val="<?php echo site_url(); ?>">
            <div class="form-group">
              <input type="checkbox" id="Round-m">
              <label for="Round-m">Round</label>
            </div>
            <span class="nu-round-img spirit-img">
            <!-- <img src="images/round.png" alt="round" title="round"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_cushion <?php if($shape_name_men=='Cushion'){ echo "active" ;}?>" for="Cushion">
            <div class="form-group">
              <input type="checkbox" id="Cushion-m">
              <label for="Cushion-m">Cushion</label>
            </div>
            <span class="nu-cushion-img spirit-img">
              <!-- <img src="images/cushion.png" alt="cushion" title="cushion"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_oval <?php if($shape_name_men=='Oval'){ echo "active" ;}?>" for="Oval">
              <div class="form-group">
                <input type="checkbox" id="Oval-m">
                <label for="Oval-m">Oval</label>
              </div>
              <span class="nu-oval-img spirit-img">
                <!-- <img src="images/oval.png" alt="oval" title="oval"> -->
              </span>
            </li>
          <li class="diamond_shape_li nu_radiant <?php if($shape_name_men=='Radiant'){ echo "active" ;}?>" for="Radiant">
            <div class="form-group">
              <input type="checkbox" id="Radiant-m">
              <label for="Radiant-m">Radiant</label>
            </div>
            <span class="nu-radiant-img spirit-img">
              <!-- <img src="images/radiant.png" alt="radiant" title="radiant"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_emerald <?php if($shape_name_men=='Emerald'){ echo "active" ;}?>" for="Emerald">
            <div class="form-group">
              <input type="checkbox" id="Emerald-m">
              <label for="Emerald-m">Emerald</label>
            </div>
            <span class="nu-emerald-img spirit-img">
              <!-- <img src="images/emerald.png" alt="emerald" title="emerald"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_pear <?php if($shape_name_men=='Pear'){ echo "active" ;}?>" for="Pear">
            <div class="form-group">
              <input type="checkbox" id="Pear-m">
              <label for="Pear-m">Pear</label>
            </div>
            <span class="nu-pear-img spirit-img">
              <!-- <img src="images/pear.png" alt="pear" title="pear"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_princess <?php if($shape_name_men=='Princess'){ echo "active" ;}?>" for="Princess">
            <div class="form-group">
              <input type="Princess" id="Princess-m">
              <label for="Princess-m">Princess</label>
            </div>
            <span class="nu-princess-img spirit-img">
              <!-- <img src="images/princess.png" alt="princess" title="princess"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_asscher <?php if($shape_name_men=='Asscher'){ echo "active" ;}?>" for="Asscher">
            <div class="form-group">
              <input type="checkbox" id="Asscher-m">
              <label for="Asscher-m">Asscher</label>
            </div>
            <span class="nu-asscher-img spirit-img">
              <!-- <img src="images/asscher.png" alt="asscher" title="asscher"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_marquise <?php if($shape_name_men=='Marquise'){ echo "active" ;}?>" for="Marquise">
            <div class="form-group">
              <input type="checkbox" id="Marquise-m">
              <label for="Marquise-m">Marquise</label>
            </div>
            <span class="nu-marquise-img spirit-img">
              <!-- <img src="images/marquise.png" alt="marquise" title="marquise"> -->
            </span>
          </li>
         <li class="diamond_shape_li nu_heart <?php if($shape_name_men=='Heart'){ echo "active" ;}?>" for="Heart">
            <div class="form-group">
              <input type="checkbox" id="Heart-m">
              <label for="Heart-m">Heart</label>
            </div>
            <span class="nu-heart-img spirit-img">
              <!-- <img src="images/heart.png" alt="heart" title="heart"> -->
            </span>
          </li>
        </ul>
      </div>

      <!-- Filter By Price -->
      <div class="price gbl-spacing">
        <div class="filter-heading">Price <i class="fa fa-question-circle" aria-hidden="true"></i></div>
        <div class="nu-custom-range-slider">
          <div id="pad_in" class="price-range-mob-tps">
            <div id="amountSlider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
              <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
              <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
            </div>
          </div>
          <div class="range-slider">
            <div class="number-group">
              <p><input class="price_left focuse_selector number-input" id="calcAmount"  value="<?php echo $currency.$price_min_val ; ?>"><span>Min</span></p>
              <p><span> Max</span><input class="price_right focuse_selector number-input" id="calcAmount2" value="<?php echo $currency.$price_max_val ; ?>"></p>
              <div class="clear"></div>
            </div>
          </div>
        </div>
        <!-- // filter level-filter -->
      </div>

      <!-- Filter By Caret -->
      <div class="carat gbl-spacing">
        <div class="filter-heading">Carat <i class="fa fa-question-circle" aria-hidden="true"></i></div>
        <div class="nu-custom-range-slider">
          <div id="pad_in" class="price-range-mob-tps">
            <div id="carat" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
              <a class="ui-slider-handle ui-state-default ui-corner-all " style="left:20% ; "></a>
              <a class="ui-slider-handle ui-state-default ui-corner-all " style="left:20% ; "></a>
            </div>
          </div>
          <div class="range-slider">
            <div class="number-group">
              <p><input class="carat_left focuse_selector_carat number-input" id="calcCarat" value="<?php echo $carat_min_val ; ?>" /><span>Min</span></p>
              <p><span>Max</span> <input class="carat_right focuse_selector_carat number-input" id="calcCarat2" value="<?php echo $carat_max_val ; ?>" />
                <div class="clear"></div>
            </div>
          </div>
        </div> 
      </div>

      <!-- Filter By Cut -->
      <div class="cut gbl-spacing">
        <div class="filter-heading">Cut <i class="fa fa-question-circle" aria-hidden="true"></i></div>
          <div class="nu-custom-range-slider">
            <div class="steps_tick" style="left: 25%;"> </div>
            <div class="steps_tick" style="left: 50%;"> </div>
            <div class="steps_tick" style="left: 75%;"> </div>
            <div class="steps_tick" style="left: 100%;"> </div>
            <div id="pad_in">
              <div id="cut" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
              </div>
            </div>
            <div class="range-slider">
              <div class="number-group">
                <ul id="cut_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">
                  <li class="" value="0" data-id="Good">Good</li>
                  <li class="" value="1" data-id="Very Good">Very Good</li>                
                  <li class="" value="2" data-id="Excellent">Excellent</li>
                  <li class="" value="3" data-id="Ideal">Ideal</li>           
                </ul>
              </div>
            </div>
          </div> 
      </div>

      <!-- Filter By Color -->
      <div class="color gbl-spacing">
        <div class="filter-heading">Color <i class="fa fa-question-circle" aria-hidden="true"></i></div>
          <div class="nu-custom-range-slider">
            <div class="steps_tick" style="left: 11%;"> </div>
            <div class="steps_tick" style="left: 22%;"> </div>
            <div class="steps_tick" style="left: 33%;"> </div>
            <div class="steps_tick" style="left: 44%;"> </div>
            <div class="steps_tick" style="left: 55%;"> </div>
            <div class="steps_tick" style="left: 66%;"> </div>
            <div class="steps_tick" style="left: 77%;"> </div>
            <div class="steps_tick" style="left: 88%;"> </div>
            <div id="pad_in">
              <div id="color" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
              </div>
            </div>
            <div class="range-slider">
              <div class="number-group">
                <!-- <ul class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100"> -->
                <ul class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100" id="color_list">
                  <li class="" value="0" data-id="L">L</li>
                  <li class="" value="1" data-id="K">K</li>
                  <li class="" value="2" data-id="J">J</li>
                  <li class="" value="3" data-id="I">I</li>
                  <li class="" value="4" data-id="H">H</li>
                  <li class="" value="5" data-id="G">G</li>
                  <li class="" value="6" data-id="F">F</li>
                  <li class="" value="7" data-id="E">E</li>
                  <li class="" value="8" data-id="D">D</li>
                </ul>
              </div>
            </div>
          </div> 
      </div>
                
      <!-- Filter By Clarity -->
      <div class="clarity gbl-spacing">
        <div class="filter-heading">Clarity <i class="fa fa-question-circle" aria-hidden="true"></i></div>
          <!-- With number fields -->
          <div class="filter level-filter level-req">
            <div class="nu-custom-range-slider">
              <div class="steps_tick" style="left: 12.5%;"> </div>
              <div class="steps_tick" style="left: 24.5%;"> </div>
              <div class="steps_tick" style="left: 36.5%;"> </div>
              <div class="steps_tick" style="left: 48.5%;"> </div>
              <div class="steps_tick" style="left: 60.5%;"> </div>
              <div class="steps_tick" style="left: 72.5%;"> </div>
              <div class="steps_tick" style="left: 87.5%;"> </div>
              <div id="pad_in">
                <div id="clarity" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                  <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                  <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                </div>
              </div>
              <div class="range-slider">
                <div class="number-group">
                  <ul class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100" id="clarity_list"> 
                    <li class="" value="0" data-id="I1">I1</li>
                    <li class="" value="1" data-id="SI2">SI2</li>
                    <li class="" value="2" data-id="SI1">SI1</li>
                    <li class="" value="3" data-id="VS2">VS2</li> 
                    <li class="" value="4" data-id="VS1">VS1</li>
                    <li class="" value="5" data-id="VVS2">VVS2</li>
                    <li class="" value="6" data-id="VVS1">VVS1</li>
                    <li class="" value="7" data-id="FL,IF">FL/IF</li>
                  </ul>
                </div>
              </div>
            </div><!-- // filter level-filter -->
          </div>
        </div>
      </div>

      <!-- Advance Options -->
      <div class="advanced-filter mt-5 mb-5">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                  Advance Options <span class="pull-right"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
                  <span> </span>
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse show in" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <div class="Polish gbl-spacing">
                  <div class="filter-heading">Polish <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <!-- With number fields -->
                  <div class="filter level-filter level-req">
                    <div class="nu-custom-range-slider">
                      <div class="steps_tick" style="left: 25%;"> </div>
                      <div class="steps_tick" style="left: 50%;"> </div>
                      <div class="steps_tick" style="left: 75%;"> </div>
                      <div id="pad_in">
                        <div id="polish" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        </div>
                      </div>
                      <div class="range-slider">
                        <div class="number-group">
                          <ul id="polish_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">
                            <li class="" value="0" data-id="Good">Good</li>
                            <li class="" value="1" data-id="Very Good">Very Good</li>
                            <li class="" value="2" data-id="Excellent">Excellent</li>
                            <li class="" value="3" data-id="Ideal">Ideal</li>           
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div><!-- // filter level-filter -->
                </div>

                <div class="Polish gbl-spacing">
                  <div class="filter-heading">Symmetry <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <!-- With number fields -->
                  <div class="filter level-filter level-req">
                    <div class="nu-custom-range-slider">
                      <div class="steps_tick" style="left: 25%;"> </div>
                      <div class="steps_tick" style="left: 50%;"> </div>
                      <div class="steps_tick" style="left: 75%;"> </div>
                      <div id="pad_in">
                        <div id="symmetry" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        </div>
                      </div>
                      <div class="range-slider">
                        <div class="number-group">
                          <ul id="symmetry_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">           
                            <li class="" value="0" data-id="Good">Good</li>
                            <li class="" value="1" data-id="Very Good">Very Good</li>    
                            <li class="" value="2" data-id="Excellent">Excellent</li>
                            <li class="" value="3" data-id="Ideal">Ideal</li>           
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div><!-- // filter level-filter -->
                </div>

                <div class="Polish gbl-spacing">
                  <div class="filter-heading">Lab <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <div class="lab_list_tps">
                    <ul id="lab_list" class="lab_filter_class">
                      <?php
                      foreach ($result_val['labs'] as $key=>$get_labs_val)
                      {
                      ?>
                        <li id="<?php echo $get_labs_val ; ?>" class="lab_td">
                          <input type="checkbox" id="lab_val"  <?php if (in_array($get_labs_val, $array_vallab)){ echo "checked" ;} ?> class="vendorname_cls" data-id="<?php echo $get_labs_val ; ?>" name="lab_na" value="<?php echo $get_labs_val ; ?>">
                          <label class="vendorname_label " for="vendorname_label"><?php echo $get_labs_val ; ?></label>
                        </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </div>
                </div>
                <div class="carat gbl-spacing">
                  <div class="filter-heading">L/W <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <!-- With number fields -->
                  <div class="filter level-filter level-req">
                    <div class="nu-custom-range-slider">
                      <div id="pad_in" class="price-range-mob-tps">
                        <div id="length_width" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        </div>
                      </div>
                      <div class="range-slider">
                        <div class="number-group">
                          <p><input class="rw_ratio_left focuse_selector_rw_ratio number-input" id="calc_rw_ratio" value="<?php echo $ratio_min_val ; ?>" /><span>Min</span></p>
                          <p><span>Max</span><input class="rw_ratio_right focuse_selector_rw_ratio number-input" id="calc_rw_ratio2" value="<?php echo $ratio_max_val ; ?>" /></p>
                          <div class="clear"></div>
                        </div>
                      </div>
                    </div>
                  </div><!-- // filter level-filter -->
                </div>

                <div class="carat gbl-spacing">
                  <div class="filter-heading">Depth <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <!-- With number fields -->
                  <div class="filter level-filter level-req">
                    <div class="nu-custom-range-slider">
                      <div class="slider-row clearfix">
                        <div id="pad_in" class="price-range-mob-tps">
                          <div id="depth" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                            <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                            <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          </div>
                        </div>
                        <div class="range-slider">
                          <div class="number-group">
                            <p><input class="depth_left focuse_selector_depth number-input" id="calcDepth" value="<?php echo $min_depth_val ; ?>%" /><span>Min</span></p>
                            <p><span>Max</span><input class="depth_right focuse_selector_depth number-input" id="calcDepth2" value="<?php echo $depth_max_val ; ?>%" /></p>
                            <div class="clear"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="carat gbl-spacing">
                  <div class="filter-heading">Table <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <!-- With number fields -->
                  <div class="filter level-filter level-req">
                    <div class="nu-custom-range-slider">
                      <div class="slider-row clearfix">
                        <div id="pad_in" class="price-range-mob-tps">
                          <div id="table" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                            <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                            <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          </div>
                        </div>

                        <div class="range-slider">
                          <div class="number-group">
                            <p><input class="table_left focuse_selector_table number-input" id="calTable" value="<?php echo $table_min_val ; ?>%" /><span>Min</span></p>
                            <p><span>Max</span><input class="table_right focuse_selector_table number-input" id="calTable2" value="<?php echo $table_max_val ; ?>%" /></p>
                            <div class="clear"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!-- // filter level-filter -->
                </div>

                <!--<div class="Polish gbl-spacing">
                  <div class="filter-heading">Fluorescence <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                    <div class="nu-custom-range-slider">
                      <div class="steps_tick" style="left: 20%;"> </div>
                      <div class="steps_tick" style="left: 40%;"> </div>
                      <div class="steps_tick" style="left: 60%;"> </div>
                      <div class="steps_tick" style="left: 80%;"> </div>
                      <div id="pad_in">
                        <div id="fluorescence" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        </div>
                      </div>
                      <div class="steps_list fluorescence_list_tps">
                        <div class="range-slider">
                          <div class="number-group">
                            <ul id="fluorescence_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">
                              <?php
                              // foreach ($result_val['fluorescence'] as $keys=>$get_fluorescence_val)
                              {
                              ?>
                                <li data-id='<?php // echo $get_fluorescence_val ; ?>' class="" value="<?php // echo $keys ; ?>"><?php // echo $get_fluorescence_val ; ?></li>
                              <?php
                              }
                              ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>-->
                  <?php 
                  $user      = wp_get_current_user();
                  $allowed_roles  = array('administrator');
                  if( array_intersect($allowed_roles, $user->roles ) ) {
                  ?>
                    <div class="Polish gbl-spacing">
                      <div class="filter-heading">Vendor Name <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                      <div class="lab_list_tps">
                        <ul class="vendorname_list">           
                          <?php
                          foreach ($fresult_val['vendor'] as $key=>$get_vendor_name_val)
                          {
                          ?>
                            <li id="<?php echo $get_vendor_name_val['id'] ; ?>" class="vendorname_li" title="<?php echo $get_vendor_name_val['name'] ; ?>">
                                <input type="checkbox" id="vendorname"  title="<?php echo $get_vendor_name_val['name'] ; ?>"  <?php if($get_vendor_name_val['id']==$vendor){ echo "checked" ;} ?> class="vendorname_cls" data-id="<?php echo $get_vendor_name_val['id'] ; ?>" name="vendorname" value="<?php echo $get_vendor_name_val['id'] ; ?>">
                              <label class="vendorname_label " for="vendorname_label"><?php echo $get_vendor_name_val['abbreviation'] ; ?></label>
                            </li>
                          <?php
                          }
                          ?>
                        </ul>
                      </div>
                    </div>
                  <?php 
                  }
                  ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php else : ?>
  <!-- Display and echo desktop stuff here Filter Section Start -->
  <div class="filter-section">
    <div class="filter-top">
      <div class="filterBy">
        <h4>
          Filter By 
          <div class="recet_filter_button" style="<?php if(!empty($_GET)){ echo "display:block"; }else{ echo "display:none"; } ?>">
            <button class="button recet_filter_button_value">Clear All</button>
          </div>
        </h4>
      </div>
      <div class="toggle-row">
        <div class="view-avail">
          <p>360 view Availaible <i class="fa fa-info-circle" aria-hidden="true"></i></p>
          <div class="view-toggle-btn">
            <!-- Rounded switch -->
            <label class="switch">
              <input type="checkbox" name="videofilter" id="videofilter" value="<?php echo $videofilter_val ; ?>">
              <span class="slide round videofilter"></span>
            </label>
          </div>
        </div>
        <div class="view-avail">
          <p>Quick Ship Diamond <i class="fa fa-info-circle" aria-hidden="true"></i></p>
          <div class="view-toggle-btn">
            <!-- Rounded switch -->
            <label class="switch">
              <input type="checkbox" id="Orderbyquickship-asc" name="quick_ship" value="quick_ship">
              <span class="slide round quick_ship" id="Orderbyquickship-asc"></span>
            </label>
          </div>
        </div>
      </div>
      <div class="shapes gbl-spacing">
      <div class="filter-heading">Shape <span><i class="fa fa-question-circle" aria-hidden="true"></i></span></div>
        <ul class="diamond_shape_ul">
          <li class="diamond_shape_li nu_round <?php if($shape_name_men=='Round'){ echo "active" ;}?>" for="Round" site_url_val="<?php echo site_url(); ?>">
            <div class="form-group">
              <input type="checkbox" id="Round">
              <label class="diamond_shape_name" for="diamond_shape_name">Round</label>
            </div>
            <span class="nu-round-img spirit-img">
              <!-- <img src="images/round.png" alt="round" title="round"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_cushion <?php if($shape_name_men=='Cushion'){ echo "active" ;}?>" for="Cushion">
            <div class="form-group">
              <input type="checkbox" id="Cushion">
              <label class="diamond_shape_name" for="diamond_shape_name">Cushion</label>
            </div>
            <span class="nu-cushion-img spirit-img">
              <!-- <img src="images/cushion.png" alt="cushion" title="cushion"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_oval <?php if($shape_name_men=='Oval'){ echo "active" ;}?>" for="Oval">
            <div class="form-group">
              <input type="checkbox" id="Oval">
              <label class="diamond_shape_name" for="diamond_shape_name">Oval</label>
            </div>
            <span class="nu-oval-img spirit-img">
              <!-- <img src="images/oval.png" alt="oval" title="oval"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_radiant <?php if($shape_name_men=='Radiant'){ echo "active" ;}?>" for="Radiant">
            <div class="form-group">
              <input type="checkbox" id="Radiant">
              <label class="diamond_shape_name" for="diamond_shape_name">Radiant</label>
            </div>
            <span class="nu-radiant-img spirit-img">
              <!-- <img src="images/radiant.png" alt="radiant" title="radiant"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_emerald <?php if($shape_name_men=='Emerald'){ echo "active" ;}?>" for="Emerald">
            <div class="form-group">
              <input type="checkbox" id="Emerald">
              <label class="diamond_shape_name" for="diamond_shape_name">Emerald</label>
            </div>
            <span class="nu-emerald-img spirit-img">
              <!-- <img src="images/emerald.png" alt="emerald" title="emerald"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_pear <?php if($shape_name_men=='Pear'){ echo "active" ;}?>" for="Pear">
            <div class="form-group">
              <input type="checkbox" id="Pear">
              <label class="diamond_shape_name" for="diamond_shape_name">Pear</label>
            </div>
            <span class="nu-pear-img spirit-img">
              <!-- <img src="images/pear.png" alt="pear" title="pear"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_princess <?php if($shape_name_men=='Princess'){ echo "active" ;}?>" for="Princess">
            <div class="form-group">
              <input type="checkbox" id="Princess">
              <label class="diamond_shape_name" for="diamond_shape_name">Princess</label>
            </div>
            <span class="nu-princess-img spirit-img">
              <!-- <img src="images/princess.png" alt="princess" title="princess"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_asscher <?php if($shape_name_men=='Asscher'){ echo "active" ;}?>" for="Asscher">
            <div class="form-group">
              <input type="checkbox" id="Asscher">
              <label class="diamond_shape_name" for="diamond_shape_name">Asscher</label>
            </div>
            <span class="nu-asscher-img spirit-img">
              <!-- <img src="images/asscher.png" alt="asscher" title="asscher"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_marquise <?php if($shape_name_men=='Marquise'){ echo "active" ;}?>" for="Marquise">
            <div class="form-group">
              <input type="checkbox" id="Marquise">
              <label class="diamond_shape_name" for="diamond_shape_name">Marquise</label>
            </div>
            <span class="nu-marquise-img spirit-img">
              <!-- <img src="images/marquise.png" alt="marquise" title="marquise"> -->
            </span>
          </li>
          <li class="diamond_shape_li nu_heart <?php if($shape_name_men=='Heart'){ echo "active" ;}?>" for="Heart">
            <div class="form-group">
              <input type="checkbox" id="Heart">
              <label class="diamond_shape_name" for="diamond_shape_name">Heart</label>
            </div>
            <span class="nu-heart-img spirit-img">
              <!-- <img src="images/heart.png" alt="heart" title="heart"> -->
            </span>
          </li>
        </ul>
      </div>
      <div class="price gbl-spacing">
        <div class="filter-heading">Price <i class="fa fa-question-circle" aria-hidden="true"></i></div>
          <div class="nu-custom-range-slider">
            <div id="pad_in" class="price-range-mob-tps">
              <div id="amountSlider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
              </div>
            </div>
            <div class="range-slider">
              <div class="number-group">
                <p><input class="price_left focuse_selector number-input" id="calcAmount"  value="<?php echo $currency.$price_min_val ; ?>"><span>Min</span></p>
                <p><span> Max</span><input class="price_right focuse_selector number-input" id="calcAmount2" value="<?php echo $currency.$price_max_val ; ?>"></p>
                <div class="clear"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="carat gbl-spacing">
          <div class="filter-heading">Carat <i class="fa fa-question-circle" aria-hidden="true"></i></div>
          <div class="nu-custom-range-slider">
            <div id="pad_in" class="price-range-mob-tps">
              <div id="carat" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left:20% ; "></a>
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left:20% ; "></a>
              </div>
            </div>
            <div class="range-slider">
              <div class="number-group">
                <p><input class="carat_left focuse_selector_carat number-input" id="calcCarat" value="<?php echo $carat_min_val ; ?>" /><span>Min</span></p>
                <p><span>Max</span> <input class="carat_right focuse_selector_carat number-input" id="calcCarat2" value="<?php echo $carat_max_val ; ?>" /></p>
                <div class="clear"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="cut gbl-spacing">
          <div class="filter-heading">Cut <i class="fa fa-question-circle" aria-hidden="true"></i></div>
          <div class="nu-custom-range-slider">
            <div class="steps_tick" style="left: 25%;"> </div>
            <div class="steps_tick" style="left: 50%;"> </div>
            <div class="steps_tick" style="left: 75%;"> </div>
            <div class="steps_tick" style="left: 100%;"> </div>
            <div id="pad_in">
              <div id="cut" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
              </div>
            </div>
            <div class="range-slider">
              <div class="number-group">
                <ul id="cut_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">
                  <li class="" value="0" data-id="Good">Good</li>
                  <li class="" value="1" data-id="Very Good">Very Good</li>                
                  <li class="" value="2" data-id="Excellent">Excellent</li>
                  <li class="" value="3" data-id="Ideal">Ideal</li>           
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="color gbl-spacing">
          <div class="filter-heading">Color <i class="fa fa-question-circle" aria-hidden="true"></i></div>
          <div class="nu-custom-range-slider">
            <div class="steps_tick" style="left: 11%;"> </div>
            <div class="steps_tick" style="left: 22%;"> </div>
            <div class="steps_tick" style="left: 33%;"> </div>
            <div class="steps_tick" style="left: 44%;"> </div>
            <div class="steps_tick" style="left: 55%;"> </div>
            <div class="steps_tick" style="left: 66%;"> </div>
            <div class="steps_tick" style="left: 77%;"> </div>
            <div class="steps_tick" style="left: 88%;"> </div>
            <div id="pad_in">
              <div id="color" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
              </div>
            </div>
            <div class="range-slider">
              <div class="number-group">
                <ul class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100" id="color_list">
                  <li class="" value="0" data-id="L">L</li>
                  <li class="" value="1" data-id="K">K</li>
                  <li class="" value="2" data-id="J">J</li>
                  <li class="" value="3" data-id="I">I</li>
                  <li class="" value="4" data-id="H">H</li>
                  <li class="" value="5" data-id="G">G</li>
                  <li class="" value="6" data-id="F">F</li>
                  <li class="" value="7" data-id="E">E</li>
                  <li class="" value="8" data-id="D">D</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="clarity gbl-spacing">
          <div class="filter-heading">Clarity <i class="fa fa-question-circle" aria-hidden="true"></i></div>
            <!-- With number fields -->
              <div class="filter level-filter level-req">
              <div class="nu-custom-range-slider">
              <div class="steps_tick" style="left: 12.5%;"> </div>
              <div class="steps_tick" style="left: 24.5%;"> </div>
              <div class="steps_tick" style="left: 36.5%;"> </div>
              <div class="steps_tick" style="left: 48.5%;"> </div>
              <div class="steps_tick" style="left: 60.5%;"> </div>
              <div class="steps_tick" style="left: 72.5%;"> </div>
              <div class="steps_tick" style="left: 87.5%;"> </div>
              <div id="pad_in">
                <div id="clarity" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                  <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                  <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                </div>
              </div>
              <div class="range-slider">
                <div class="number-group">
                  <ul class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100" id="clarity_list">          
                    <li class="" value="0" data-id="I1">I1</li>
                    <li class="" value="1" data-id="SI2">SI2</li>   
                    <li class="" value="2" data-id="SI1">SI1</li>
                    <li class="" value="3" data-id="VS2">VS2</li> 
                    <li class="" value="4" data-id="VS1">VS1</li>             
                    <li class="" value="5" data-id="VVS2">VVS2</li> 
                    <li class="" value="6" data-id="VVS1">VVS1</li>
                    <li class="" value="7" data-id="FL,IF">FL/IF</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

      <div class="advanced-filter mt-5 mb-5">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Advance Options <span class="pull-right"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
                  <span> </span>
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse show in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="Polish gbl-spacing">
                  <div class="filter-heading">Polish <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <div class="nu-custom-range-slider">
                    <div class="steps_tick" style="left: 25%;"> </div>
                    <div class="steps_tick" style="left: 50%;"> </div>
                    <div class="steps_tick" style="left: 75%;"> </div>
                    <div id="pad_in">
                      <div id="polish" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                        <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                      </div>
                    </div>
                    <div class="range-slider">
                      <div class="number-group">
                        <ul id="polish_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">           
                          <li class="" value="0" data-id="Good">Good</li>
                          <li class="" value="1" data-id="Very Good">Very Good</li>    
                          <li class="" value="2" data-id="Excellent">Excellent</li> 
                          <li class="" value="3" data-id="Ideal">Ideal</li>           
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="Polish gbl-spacing">
                  <div class="filter-heading">Symmetry <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <!-- With number fields -->
                  <div class="filter level-filter level-req">
                    <div class="nu-custom-range-slider">
                      <div class="steps_tick" style="left: 25%;"> </div>
                      <div class="steps_tick" style="left: 50%;"> </div>
                      <div class="steps_tick" style="left: 75%;"> </div>
                      <div id="pad_in">
                        <div id="symmetry" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        </div>
                      </div>
                      <div class="range-slider">
                        <div class="number-group">
                          <ul id="symmetry_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">           
                            <li class="" value="0" data-id="Good">Good</li>
                            <li class="" value="1" data-id="Very Good">Very Good</li>    
                            <li class="" value="2" data-id="Excellent">Excellent</li>
                            <li class="" value="3" data-id="Ideal">Ideal</li>           
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="Polish gbl-spacing">
                  <div class="filter-heading">Lab <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                  <div class="lab_list_tps">
                    <ul id="lab_list" class="lab_filter_class">                  
                      <?php
                      foreach ($result_val['labs'] as $key=>$get_labs_val)
                      {
                      ?>
                        <li id="<?php echo $get_labs_val ; ?>" class="lab_td">
                          <input type="checkbox" id="lab_val"  <?php if (in_array($get_labs_val, $array_vallab)){ echo "checked" ;} ?> class="vendorname_cls" data-id="<?php echo $get_labs_val ; ?>" name="lab_na" value="<?php echo $get_labs_val ; ?>">
                          <label class="vendorname_label " for="vendorname_label"><?php echo $get_labs_val ; ?></label>
                        </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              
              <div class="carat gbl-spacing">
                <div class="filter-heading">L/W <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                <!-- With number fields -->
                <div class="filter level-filter level-req">
                  <div class="nu-custom-range-slider">
                    <div id="pad_in" class="price-range-mob-tps">
                      <div id="length_width" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                        <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                      </div>
                    </div>
                    <div class="range-slider">
                      <div class="number-group">
                        <p><input class="rw_ratio_left focuse_selector_rw_ratio number-input" id="calc_rw_ratio" value="<?php echo $ratio_min_val ; ?>" /><span>Min</span></p>
                        <p><span>Max</span><input class="rw_ratio_right focuse_selector_rw_ratio number-input" id="calc_rw_ratio2" value="<?php echo $ratio_max_val ; ?>" /></p>
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carat gbl-spacing">
                <div class="filter-heading">Depth <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                <!-- With number fields -->
                <div class="filter level-filter level-req">
                  <div class="nu-custom-range-slider">
                    <div class="slider-row clearfix">
                      <div id="pad_in" class="price-range-mob-tps">
                        <div id="depth" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        </div>
                      </div>
                      <div class="range-slider">
                        <div class="number-group">
                          <p><input class="depth_left focuse_selector_depth number-input" id="calcDepth" value="<?php echo $min_depth_val ; ?>%" /><span>Min</span></p>
                          <p><span>Max</span><input class="depth_right focuse_selector_depth number-input" id="calcDepth2" value="<?php echo $depth_max_val ; ?>%" /></p>
                          <div class="clear"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carat gbl-spacing">
                <div class="filter-heading">Table <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                <!-- With number fields -->
                <div class="filter level-filter level-req">
                  <div class="nu-custom-range-slider">
                    <div class="slider-row clearfix">
                      <div id="pad_in" class="price-range-mob-tps">
                        <div id="table" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                          <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                        </div>
                      </div>
                      <div class="range-slider">
                        <div class="number-group">
                          <p><input class="table_left focuse_selector_table number-input" id="calTable" value="<?php echo $table_min_val ; ?>%" /><span>Min</span></p>
                          <p><span>Max</span><input class="table_right focuse_selector_table number-input" id="calTable2" value="<?php echo $table_max_val ; ?>%" /></p>
                          <div class="clear"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!--<div class="Polish gbl-spacing">
                <div class="filter-heading">Fluorescence <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                <div class="nu-custom-range-slider">
                  <div class="steps_tick" style="left: 20%;"> </div>
                  <div class="steps_tick" style="left: 40%;"> </div>
                  <div class="steps_tick" style="left: 60%;"> </div>
                  <div class="steps_tick" style="left: 80%;"> </div>
                  <div id="pad_in">
                    <div id="fluorescence" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                      <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                      <a class="ui-slider-handle ui-state-default ui-corner-all " style="left: 20%; "></a>
                    </div>
                  </div>
                  <div class="steps_list fluorescence_list_tps">
                    <div class="range-slider">
                      <div class="number-group">
                        <ul id="fluorescence_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">  
                          <?php
                          //foreach ($result_val['fluorescence'] as $keys=>$get_fluorescence_val)
                          {
                          ?>
                            <li data-id='<?php // echo $get_fluorescence_val ; ?>' class="" value="<?php // echo $keys ; ?>"><?php //echo $get_fluorescence_val ; ?></li>
                          <?php
                          }
                          ?>
                        </ul>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>-->
                <?php
                $user      = wp_get_current_user();
                $allowed_roles  = array('administrator');
                if( array_intersect($allowed_roles, $user->roles ) ) {
                ?>
                  <div class="Polish gbl-spacing">
                    <div class="filter-heading">Vendor Name <i class="fa fa-question-circle" aria-hidden="true"></i></div>
                    <div class="lab_list_tps">
                      <ul class="vendorname_list">           
                        <?php 
                        foreach ($fresult_val['vendor'] as $key=>$get_vendor_name_val)
                        {
                        ?>
                          <li id="<?php echo $get_vendor_name_val['id'] ; ?>" class="vendorname_li" title="<?php echo $get_vendor_name_val['name'] ; ?>">
                              <input type="checkbox" id="vendorname"  title="<?php echo $get_vendor_name_val['name'] ; ?>"  <?php if($get_vendor_name_val['id']==$vendor){ echo "checked" ;} ?> class="vendorname_cls" data-id="<?php echo $get_vendor_name_val['id'] ; ?>" name="vendorname" value="<?php echo $get_vendor_name_val['id'] ; ?>">
                            <label class="vendorname_label " for="vendorname_label"><?php echo $get_vendor_name_val['abbreviation'] ; ?></label>
                          </li>
                        <?php
                        }
                        ?>
                      </ul>
                    </div>
                  </div>
                <?php 
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
endif;

$colors = $_GET['color'];
$cl_count = $_GET['cl_count'];
if($cl_count!=''){
  $cl_counts = explode(",",$cl_count);
  $co_1 = $cl_counts[0];
  $co_2 = $cl_counts[1];
}else{
  $co_1 = 0;
  $co_2 = 9;
}
$claritys = $_GET['clarity'];
$clt_count = $_GET['clt_count'];
if($clt_count!=''){
  $clt_counts = explode(",",$clt_count);
  $cl_1 = $clt_counts[0];
  $cl_2 = $clt_counts[1];
}else{
  $cl_1 = 0;
  $cl_2 = 8;
}

$symmetrys = $_GET['symmetry'];
$sym_count = $_GET['sym_count'];
if($sym_count!=''){
  $sym_counts = explode(",",$sym_count);
  $sym_1 = $sym_counts[0];
  $stm_2 = $sym_counts[1];
}else{
  $sym_1 = 0;
  $stm_2 = 4;
}
$polishs = $_GET['polish'];
$pol_count = $_GET['pol_count'];
if($pol_count!=''){
  $pol_counts = explode(",",$pol_count);
  $pol_1 = $pol_counts[0];
  $pol_2 = $pol_counts[1];
}else{
  $pol_1 = 0;
  $pol_2 = 4;
}

$labs = $_GET['lab'];
/* $lab_count = $_GET['lab_count'];
if($lab_count!=''){
  $lab_counts = explode(",",$lab_count);
  $lab_1 = $lab_counts[0];
  $lab_2 = $lab_counts[1];
}else{
  $lab_1 = 0;
  $lab_2 = 4;
} */
$cuts = $_GET['cut'];
$cut_count = $_GET['cut_count'];
if($cut_count!=''){
  $cut_counts = explode(",",$cut_count);
  $cut_1 = $cut_counts[0];
  $cut_2 = $cut_counts[1];
}else{
  $cut_1 = 0;
  $cut_2 = 4;
} 
?>
<form id="diamond_filter_data">
  <input type="hidden" id="shape_name" name="shape_name" value="<?php echo $shape_name_men ; ?>">
  <input type="hidden" id="paginationclicklink-url" name="paginationclicklink-url" value="<?php echo $page_val ; ?>">

  <input type="hidden" id="color-min-value" name="minColor" value="<?php echo $co_1 ; ?>">
  <input type="hidden" id="color-max-value" name="maxColor" value="<?php echo $co_2 ; ?>">
  <input type="hidden" id="color-max-value-col" name="maxColors" value="<?php echo $colors ; ?>">

  <input type="hidden" id="cut-min-value" name="minCut" value="<?php echo $cut_1 ; ?>">
  <input type="hidden" id="cut-max-value" name="maxCut" value="<?php echo $cut_2 ; ?>">
  <input type="hidden" id="cut-max-value-ct" name="maxCuts" value="<?php echo $cuts ; ?>">

  <input type="hidden" id="clarity-min-value" name="minClarity" value="<?php echo $cl_1 ; ?>">
  <input type="hidden" id="clarity-max-value" name="maxClarity" value="<?php echo $cl_2 ; ?>">
  <input type="hidden" id="clarity-min-value-clty" name="maxClaritys" value="<?php echo $claritys ; ?>">

  <input type="hidden" reset-val="<?php echo $carat_min ; ?>" id="carat_min" name="minCarat" value="<?php echo $carat_min_val ; ?>">
  <input type="hidden" reset-val="<?php echo $carat_max ; ?>" id="carat_max" name="maxCarat" value="<?php echo $carat_max_val ; ?>">

  <input type="hidden" reset-val="<?php echo $min_price ; ?>" id="pricerange_min" name="minPrice" value="<?php echo $price_min_val ; ?>">
  <input type="hidden" reset-val="<?php echo $max_price ; ?>" id="pricerange_max" name="maxPrice" value="<?php echo $price_max_val ; ?>">
  <input type="hidden" reset-val="<?php echo $currency ; ?>" id="price_symbol" name="price_symbol" value="<?php echo $currency ; ?>">

  <input type="hidden" id="polish-min-value" name="minPolish" value="<?php echo $pol_1 ; ?>">
  <input type="hidden" id="polish-max-value" name="maxPolish" value="<?php echo $pol_2 ; ?>">
  <input type="hidden" id="polish-min-value-pol" name="maxPolishs" value="<?php echo $polishs ; ?>">

  <input type="hidden" id="symmetry-min-value" name="minSymmetry" value="<?php echo $sym_1 ; ?>">
  <input type="hidden" id="symmetry-max-value" name="maxSymmetry" value="<?php echo $stm_2 ; ?>">
  <input type="hidden" id="symmetry-min-value-sym" name="maxSymmetrys" value="<?php echo $symmetrys; ?>">
    
  <input type="hidden" id="lab-min-value-lab" name="minLab" value="<?php echo $labs; ?>">

  <input type="hidden" id="fluorescence-min-value" name="minFluorescence" value="<?php echo $flur_1 ; ?>">
  <input type="hidden" id="fluorescence-max-value" name="maxFluorescence" value="<?php echo $flur_2 ; ?>">
  <input type="hidden" id="fluorescence-min-value-flo" name="minFluorescence" value="<?php echo $fluorescence ; ?>">

  <input type="hidden" reset-val="<?php echo $min_depth ; ?>" id="depth_min" name="minDepth" value="<?php echo $min_depth_val ; ?>">
  <input type="hidden" reset-val="<?php echo $max_depth ; ?>" id="depth_max" name="maxDepth" value="<?php echo $depth_max_val ; ?>">
  <input type="hidden" reset-val="<?php echo $min_table ; ?>" id="table_min" name="minTable" value="<?php echo $table_min_val ; ?>">
  <input type="hidden" reset-val="<?php echo $max_table ; ?>" id="table_max" name="maxTable" value="<?php echo $table_max_val ; ?>">

  <input type="hidden" reset-val="<?php echo $min_ratio ; ?>" id="ratio_min" name="minratio" value="<?php echo $ratio_min_val ; ?>">
  <input type="hidden" reset-val="<?php echo $max_ratio ; ?>" id="ratio_max" name="maxratio" value="<?php echo $ratio_max_val ; ?>">

  <input type="hidden" id="orderby_value" name="orderby_value" value="<?php echo $order_by ; ?>">
  <input type="hidden" id="vendorname_type" name="vendorname_type" value="<?php echo $vendor_name ; ?>">
  <input type="hidden" id="list_grid" name="list_grid" value="<?php if($wr_style_get==''){ echo 'grid' ; }else{ echo $wr_style_get ; }?>">
  <input type="hidden" id="orderby_status" name="orderby_status" value="<?php echo $status ; ?>">

  <input type="hidden" id="quick_ship" name="quick_ship" value="<?php echo $quick_ship ; ?>">

  <input type="hidden" id="videofilterh" name="videofilterh" value="<?php echo $videofilter_val ; ?>">

  <input type="hidden" id="mind_lg" name="mind_lg" value="<?php echo $mind_lg ; ?>">
</form> 
<script type="text/javascript">
jQuery(document).ready(function($) {
  jQuery('.compare_check').click(function () {
    var Ids = jQuery('input[name="compare_check"]:checked').attr("id");
    //alert(Ids);
    jQuery("#ResultTable").empty();
    //var values = new Array();

    jQuery('input[name="compare_check"]:checked').closest('tr').each(function() {
      if (jQuery("#ResultTable tbody").length == 0) {
        jQuery("#ResultTable").append("<thead><tr><th></th><th>Stock No.</th><th>Shape</th><th>Carat</th><th>Color</th><th>Clarity</th><th>Cut</th><th>Lab</th><th>Ship Date</th> <th>Price</th> <th>Compare</th> <th>Actions</th> </tr></thead><tbody></tbody>");
      }
      var cells = jQuery('td', this);
      // var Id = jQuery('id', this);
         
      //var Id = $(this).closest('id').prop('id');
      // var chkid = input.attr('id');
    
      //alert("Number of selected rows: "+cells.length+"\n"+"And, they are: "+cells);
      jQuery('#ResultTable tbody').append('<tr><td class="shapes"><div class="form-group"><input type="checkbox"  name="ResultTable" id="'+Ids+'" class="compare_check"><label for="'+Ids+'" ></label></div></td><td>' + cells.eq(1).text() + '</td><td>' + cells.eq(2).text() + '</td><td>' + cells.eq(3).text() + '</td><td>' + cells.eq(4).text() + '</td><td>' + cells.eq(5).text() + '</td><td>' + cells.eq(6).text() + '</td><td>' + cells.eq(7).text() + '</td><td>' + cells.eq(8).text() + '</td><td>' + cells.eq(9).text() + '</td><td>' + cells.eq(10).text() + '</td><td><a data-toggle="modal" data-target="#myModal-'+Ids+'"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td></tr>');
    });
    const selectedElm = document.getElementById('selected');

    function showChecked(){
      selectedElm.innerHTML = document.querySelectorAll('input[name=compare_check]:checked')
      selectedElm.innerHTML = document.querySelectorAll('input[name=compare_check]:checked').length;
    }

    document.querySelectorAll("input[name=compare_check]").forEach(i=>{
      i.onclick = () => showChecked();
      // var Id = jQuery(this).attr("id");
    });
    var bol = jQuery("input[name=compare_check]:checkbox:checked").length >= 4;
    jQuery("input:checkbox").not(":checked").attr("disabled",bol);
    // alert("No more products allowed");
  });
});
</script>

<script>
jQuery(document).ready(function() {
  jQuery(document).ready(function() {
    function setGetParameter(paramName, paramValue) {
      var url = window.location.href;
      var hash = location.hash;
      url = url.replace(hash, '');
      if (url.indexOf(paramName + "=") >= 0)
      {
        var prefix = url.substring(0, url.indexOf(paramName + "=")); 
        var suffix = url.substring(url.indexOf(paramName + "="));
        suffix = suffix.substring(suffix.indexOf("=") + 1);
        suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
        url = prefix + paramName + "=" + paramValue + suffix;
      }
      else
      {
        if (url.indexOf("?") < 0)
          url += "?" + paramName + "=" + paramValue;
        else
          url += "&" + paramName + "=" + paramValue;
      }
      var obj = { Page: paramName, Url: url };
      history.pushState(obj, obj.paramName, obj.Url);
    }
    jQuery('.recet_filter_button_value').on('click', function(){
    var uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
      //var clean_uri = uri.substring(0, uri.indexOf("?"));
      var clean_uri='http://keyideasglobal.com/qa/nu2020/loose-diamonds/';
      window.history.replaceState({}, document.title, clean_uri);
    }
    jQuery(".vendorname_cls").removeAttr("checked");
    jQuery('.diamond_shape_ul li').removeClass('active');
    jQuery('#shape_name').val('');
    jQuery('#paginationclicklink-url').val('1');
    jQuery('#orderby_value').val();
    jQuery('.fordrop .dropdown-toggle').html('Relevance');
    jQuery('#shape_name').val('');
    jQuery('.vendorname_list li').removeClass('active');
  
    jQuery('#vendorname_type').val('');
    jQuery( "#color-max-value-col" ).val(''); 
    jQuery( "#color-min-value" ).val('0');
    jQuery( "#color-max-value" ).val('9');
    
    jQuery( "#cut-min-value" ).val('0');
    jQuery( "#cut-max-value" ).val('4');
    jQuery( "#cut-max-value-ct" ).val('');
    
    jQuery( "#clarity-min-value-clty" ).val('');
    jQuery( "#clarity-min-value" ).val('0');
    jQuery( "#clarity-max-value" ).val('8');
    
    jQuery( "#fluorescence-min-value" ).val('0');
    jQuery( "#fluorescence-max-value" ).val('5');
    jQuery( "#fluorescence-min-value-flo" ).val('');
    
    var carat_min_r = jQuery('#carat_min').attr('reset-val');
    var carat_max_r = jQuery('#carat_max').attr('reset-val'); 
     
    jQuery('#carat_min').val(carat_min_r);
    jQuery('#carat_max').val(carat_max_r);
    
    jQuery('#calcCarat').val(carat_min_r);
    jQuery('#calcCarat2').val(carat_max_r);


    var pric_min = jQuery('#pricerange_min').attr('reset-val');
    var pric_max = jQuery('#pricerange_max').attr('reset-val'); 
    var price_symbol = jQuery('#price_symbol').attr('reset-val'); 

    jQuery('#pricerange_min').val(pric_min);
    jQuery('#pricerange_max').val(pric_max);  
    jQuery('#calcAmount').val(price_symbol+pric_min);
    jQuery('#calcAmount2').val(price_symbol+pric_max);      
    
    jQuery( "#polish-min-value-pol" ).val('');
    jQuery( "#polish-min-value" ).val('0');
    jQuery( "#polish-max-value" ).val('4');
    
    jQuery( "#symmetry-min-value-sym" ).val('');  
    jQuery( "#symmetry-min-value" ).val('0');
    jQuery( "#symmetry-max-value" ).val('4');
    
    jQuery( "#lab-min-value-lab" ).val('');   
  
    jQuery('#vendorname_type').val('');
    
    var dpt_min = jQuery('#depth_min').attr('reset-val');
    var dpt_max = jQuery('#depth_max').attr('reset-val'); 
    
    jQuery('#calcDepth').val(dpt_min+'%');
    jQuery('#calcDepth2').val(dpt_max+'%');  
    jQuery('#depth_min').val(dpt_min);
    jQuery('#depth_max').val(dpt_max);  
    
    var tbl_min = jQuery('#table_min').attr('reset-val');
    var tbl_max = jQuery('#table_max').attr('reset-val'); 
    
    jQuery('#table_min').val(tbl_min);
    jQuery('#table_max').val(tbl_max);
    jQuery('#calTable').val(tbl_min+'%');
    jQuery('#calTable2').val(tbl_max+'%');
    /* jQuery('#shape_cut_enable').attr('style','display:none'); */
    
    var minsratio =jQuery("#ratio_min").attr('reset-val');
    var maxsratio =jQuery("#ratio_max").attr('reset-val');
    jQuery("#ratio_min").val(minsratio);
    jQuery("#ratio_max").val(maxsratio);
      
     jQuery("#orderby_status").val('1'); 
    
    jQuery('#mind_lg').val('');
    jQuery('.diamond_tabing li').addClass('active');
    jQuery('.diamond_tabing li').find('input[type="checkbox"]').attr('checked', true);
    
    resetcolor();
    resetcut();
    resetclarity();
    
    resetpolish();
    resetsymmetry();
    /* resetlab(); */
    resetfluorescence();
    resetamountSlider();
    resettable();
    resetdepth();
    nu_submitajax();
    resetcarat();
    resetratio();
  });
           
  function resetcolor() {
      var slider = jQuery("#color");
      slider.slider("values", 0, 0);
      slider.slider("values", 1, 9);
  }
  function resetcut() {
     var slider = jQuery("#cut");
    slider.slider("values", 0, 0);
    slider.slider("values", 1, 4);
  }
  function resetclarity() {
   var slider = jQuery("#clarity");
    slider.slider("values", 0, 0);
    slider.slider("values", 1, 8);
  }
  
  function resetpolish() {
     var slider = jQuery("#polish");
      slider.slider("values", 0, 0);
      slider.slider("values", 1, 4);
  }
  function resetsymmetry() {
       var slider = jQuery("#symmetry");
      slider.slider("values", 0, 0);
      slider.slider("values", 1, 4);
  }
  /* function resetlab() {
     var slider = jQuery("#lab");
    slider.slider("values", 0, 0);
    slider.slider("values", 1, 4);
  } */
  
  function resetfluorescence() {
    var slider = jQuery("#fluorescence");
      slider.slider("values", 0, 0);
      slider.slider("values", 1, 5);
  }
  
  
  function resetdepth() {
     var dpt_min = jQuery('#depth_min').attr('reset-val');
    var dpt_max = jQuery('#depth_max').attr('reset-val'); 
      
       var slider = jQuery("#depth");
      slider.slider("values", 0, dpt_min);
      slider.slider("values", 1, dpt_max);
  }
  
  function resettable() {
     var tbl_min = jQuery('#table_min').attr('reset-val');
    var tbl_max = jQuery('#table_max').attr('reset-val');  
    
      var slider = jQuery("#table");
      slider.slider("values", 0, tbl_min);
      slider.slider("values", 1, tbl_max);
  } 
  
  
  var minpricerange_at =jQuery( "#pricerange_min" ).attr('reset-val');
  var maxpricerange_at =jQuery( "#pricerange_max" ).attr('reset-val');
  
  function resetamountSlider() {
      var slider = jQuery("#amountSlider");
      slider.slider("values", 0, minpricerange_at);
      slider.slider("values", 1, maxpricerange_at);
      
  }  
  
  
  function resetcarat() {
    var carat_min_r = jQuery('#carat_min').attr('reset-val');
    var carat_max_r = jQuery('#carat_max').attr('reset-val'); 
    var slider = jQuery("#carat");
    slider.slider("values", 0, carat_min_r);
    slider.slider("values", 1, carat_max_r);
  } 
  
  function resetratio() {
    var minsratio =jQuery( "#ratio_min" ).attr('reset-val');
    var maxsratio =jQuery( "#ratio_max" ).attr('reset-val');
    var slider = jQuery("#length_width");
    slider.slider("values", 0, minsratio);
    slider.slider("values", 1, maxsratio);
  } 
  
  
  
  function ChangeUrl(page,url) {
        if (typeof (history.pushState) != "undefined") {
            var obj = { Page: page, Url: url };
           history.pushState(obj, obj.Page, obj.Url);
        } 
    }
  
  
/*---== Filtration : Pagination ==---*/

  var paginationclicklinks = jQuery('#paginationclicklink-url').val(); 
  jQuery('.paginationclicklink').live('click', function(){
    var paginationclicklink = jQuery(this).attr('data');
    var paginationclicklink = paginationclicklink.replace('?page=',"");
    jQuery('#paginationclicklink-url').val(paginationclicklink);
    jQuery('.paginationclicklink').addClass('disabled');
    //setGetParameter('page',paginationclicklink);
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
  });  
  


/*---== Filtration : Relevance ==---*/ 

  jQuery(".filter_orderby").change(function(){
        var selectedorder = jQuery(this).children("option:selected").val();
    setGetParameter('orderby',selectedorder);
    jQuery('#orderby_value').val(selectedorder);
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
    }); 
  
  
  jQuery('.dropdown a').live('click', function(){
    var relevance = jQuery(this).attr('for');
    var relevance_val = jQuery(this).attr('name_data');
    jQuery('#orderby_value').val(relevance);
    jQuery('.fordrop .dropdown-toggle').html(relevance_val);
    setGetParameter('orderby',relevance);
    //alert(jQuery('#certno').attr("value", ""));
    nu_submitajax();
  }); 


  /*jQuery(".filter_orderby").change(function(){
        var selectedorder = jQuery(this).children("option:selected").val();
    setGetParameter('orderby',selectedorder);
    jQuery('#orderby_value').val(selectedorder);
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
    });*/
  
    

  jQuery('#videofilter').live('click', function(){
   //var videoid = jQuery(this).attr('id');
   // var video_val = jQuery('#videofilter').val();
    //var color_min=jQuery( "#color-min-value" ).val();
    //jQuery('#videofilterh').val(relevance);
    //jQuery('.fordrop .dropdown-toggle').html(relevance_val);
   setGetParameter('360view', 'available');
   // alert(video_val);
    nu_submitajax();
  });
  

jQuery('.quick_ship').live('click', function(){
    var relevance = jQuery(this).attr('id');
    //var relevance_val = jQuery(this).attr('name_data');
    jQuery('#orderby_value').val(relevance);
    //jQuery('.fordrop .dropdown-toggle').html(relevance_val);
    setGetParameter('orderby',relevance);
    //alert(jQuery('#certno').attr("value", ""));
    nu_submitajax();
  });
  //drop_down_order
  /*----======= Filtration : Checkbox Mined/Lab =======----*/
  /* var dtype = [];
  jQuery('.diamond_tabing li.active').each(function(index, elem) {
    dtype.push(jQuery(elem).attr('id'));
  });
  jQuery('#diamondtype').val(dtype); */
  
  jQuery('.diamond_tabing li').live('click', function(){
    if(jQuery(this).hasClass( "active")){
      jQuery(this).removeClass('active');
      jQuery(this).closest('li').find('input[type="checkbox"]').attr('checked', false);
    } else {
      jQuery(this).addClass('active');
      jQuery(this).closest('li').find('input[type="checkbox"]').attr('checked', true);
    }
    jQuery('#certno').val('');
    var dtype = [];
    jQuery('.diamond_tabing li.active').each(function(index, elem) {
      dtype.push(jQuery(elem).attr('id'));
    });
    jQuery('#mind_lg').val(dtype);
    setGetParameter('diamond_type',dtype);
    nu_submitajax();
  });
  
  
  /*----======= Filtration : Diamond shape =======----*/
  var ringCategory = [];
    jQuery('ul.diamond_shape_ul li.active').each(function(index, elem) {
      ringCategory.push(jQuery(elem).attr('for'));
    });
  
  jQuery('#shape_name').val(ringCategory);
  jQuery('.diamond_shape_ul li').live('click', function(){
    var fu = jQuery(this).attr('for');
    
    jQuery('.diamond_shape_ul li').removeClass('active');
    jQuery(this).addClass('active');
    var ringCategory = [];
    jQuery('ul.diamond_shape_ul li.active').each(function(index, elem) {
      ringCategory.push(jQuery(elem).attr('for'));
    });
    jQuery('#shape_name').val(ringCategory);
    jQuery('#paginationclicklink-url').val('');
    setGetParameter('shape',ringCategory);
    /*ChangeUrl('http://localhost/wp_numined2020/diamond/', ringCategory);
    ChangeUrl('/Page1/', ringCategory); */
    /* jQuery('#shape_cut_enable').attr('style','display:block'); */
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
  });
  
  
/*----======= Filtration : Color / Fancy =======----*/
  
  var color_min=jQuery( "#color-min-value" ).val();
  var color_max=jQuery( "#color-max-value" ).val();
  /* jQuery( "#color-max-value-col" ).val(''); */
  
  jQuery( "#color" ).slider({
    range: true,
    values: [ color_min, color_max], 
    min: 0,
    max: 9,
    step: 1, 
    slide: function( event, ui ) { 

      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#color_list li:nth-child('+ui.values[0]+')').addClass('focus');
      jQuery('ul#color_list li:nth-child('+ui.values[0]+')').removeClass('focus_col_value');
      jQuery('ul#color_list li:nth-child('+(ui.values[1]+1)+')').addClass('focus');
      jQuery('ul#color_list li:nth-child('+(ui.values[1]+1)+')').removeClass('focus_col_value');
      
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++){
        jQuery('ul#color_list li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#color_list li:nth-child('+ i +')').addClass('focus_col_value'); 
      } 
      var texts_col = []; 
      jQuery( "#color-max-value-col" ).val('');
      jQuery('li.focus_col_value').each(function(){
        texts_col.push(jQuery(this).attr('data-id'));
      });
      jQuery( "#color-max-value-col" ).val(texts_col);  
      jQuery( "#color-min-value" ).val(ui.values[0]);
      jQuery( "#color-max-value" ).val(ui.values[1]);
      jQuery('.recet_filter_button').attr('style','display:block');
      setGetParameter('color',texts_col);
      setGetParameter('cl_count',ui.values[0]+','+ui.values[1]);
      
      
    },
    change: function(event, ui) {
      nu_submitajax();
    }
    
    
  });
  
  /*----======= Filtration : Diamond Cut =======----*/
  
  var mincut =jQuery( "#cut-min-value" ).val();
  var maxcut =jQuery( "#cut-max-value" ).val();
  jQuery('ul#cut_list li').removeClass('focus_ct_value');
  jQuery( "#cut" ).slider({
    range: true,
    values: [ mincut, maxcut],
    min: 0,
    max: 4,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#cut_list li:nth-child('+ui.values[0]+')').addClass('focus');
      jQuery('ul#cut_list li:nth-child('+ui.values[0]+')').removeClass('focus_ct_value');
      jQuery('ul#cut_list li:nth-child('+(ui.values[1]+1)+')').addClass('focus');
      jQuery('ul#cut_list li:nth-child('+(ui.values[1]+1)+')').removeClass('focus_ct_value');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {
        jQuery('ul#cut_list li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#cut_list li:nth-child('+ i +')').addClass('focus_ct_value');
      }  
      var texts = []; 
      jQuery( "#cut-max-value-ct" ).val('');
      jQuery('li.focus_ct_value').each(function(){
        texts.push(jQuery(this).attr('data-id'));
      });
      
      jQuery( "#cut-min-value" ).val(ui.values[0]);
      jQuery( "#cut-max-value" ).val(ui.values[1]);
      
      jQuery( "#cut-max-value-ct" ).val(texts);
      setGetParameter('cut',texts);
      setGetParameter('cut_count',ui.values[0]+','+ui.values[1]);
      jQuery('.recet_filter_button').attr('style','display:block');
      
    },
    change: function( event, ui ) { 
      
      nu_submitajax();
      
    }
  });
  
  /*----======= Filtration : Clarity =======----*/
  var minclarity =jQuery( "#clarity-min-value" ).val();
  var maxclarity =jQuery( "#clarity-max-value" ).val();
  /* jQuery( "#clarity-min-value-clty" ).val(''); */
  jQuery( "#clarity" ).slider({
    range: true,
    values: [ minclarity, maxclarity],
    min: 0,
    max: 8,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#clarity_list li:nth-child('+ui.values[0]+')').addClass('focus');
      jQuery('ul#clarity_list li:nth-child('+ui.values[0]+')').removeClass('focus_clarity');
      jQuery('ul#clarity_list li:nth-child('+(ui.values[1]+1)+')').addClass('focus');
      jQuery('ul#clarity_list li:nth-child('+(ui.values[1]+1)+')').removeClass('focus_clarity');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {
        jQuery('ul#clarity_list li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#clarity_list li:nth-child('+ i +')').addClass('focus_clarity');
      } 
      
      var texts_cl = [];  
      jQuery( "#clarity-min-value-clty" ).val('');
      jQuery('li.focus_clarity').each(function(){
        texts_cl.push(jQuery(this).attr('data-id'));
      });
      jQuery( "#clarity-min-value-clty" ).val(texts_cl);
      jQuery( "#clarity-min-value" ).val(ui.values[0]);
      jQuery( "#clarity-max-value" ).val(ui.values[1]);
      setGetParameter('clarity',texts_cl);
      setGetParameter('clt_count',ui.values[0]+','+ui.values[1]); 
      jQuery('.recet_filter_button').attr('style','display:block');
    },
    change: function( event, ui ) { 
      
      nu_submitajax();
    }
  });
  
  /*----======= Filtration : Carat =======----*/
  
  jQuery(".focuse_selector_carat").focusout(function(){
    var carat_val_min = jQuery('#calcCarat').val();
    var carat_val_max = jQuery('#calcCarat2').val();
    var carat_val_min = carat_val_min.replace('ct','');
    var carat_val_max = carat_val_max.replace('ct','');
    jQuery('#carat_min').val(carat_val_min);
    jQuery('#carat_max').val(carat_val_max); 
    setGetParameter('carat_min',carat_val_min);
    setGetParameter('carat_max',carat_val_max); 
    var slider = jQuery("#carat");
    slider.slider("values", 0, carat_val_min);
    slider.slider("values", 1, carat_val_max);    
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
    
  });
  
  var mincarat =jQuery( "#carat_min" ).val();
  var maxcarat =jQuery( "#carat_max" ).val();
  var mincarat_at =jQuery( "#carat_min" ).attr('reset-val');
  var maxcarat_at =jQuery( "#carat_max" ).attr('reset-val');
  
  jQuery("#carat").slider({
    range: true,
    min:<?=$carat_min; ?>,
    max:<?=$carat_max; ?>,
    values: [ mincarat, maxcarat ],
    step: 0.01, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) { 
        return false; 
      }

      jQuery('#calcCarat').val(ui.values[0]);
      jQuery('#calcCarat2').val(ui.values[1]);

      jQuery('#carat_min').val(ui.values[0]);
      jQuery('#carat_max').val(ui.values[1]);  
      
      setGetParameter('carat_min',ui.values[0]);
      setGetParameter('carat_max',ui.values[1]);
      
      jQuery('.recet_filter_button').attr('style','display:block');
    },
    change: function(event, ui) { 
      
      nu_submitajax(); 
    }

  }); 
  
  /*----======= Filtration : Price =======----*/
  
  jQuery(".focuse_selector").focusout(function(){
    
    var price_val_min = jQuery('#calcAmount').val();
    var price_val_max = jQuery('#calcAmount2').val();
    
    var price_val_min = price_val_min.replace('$','');
    var price_val_max = price_val_max.replace('$','');
    
    jQuery('#pricerange_min').val(price_val_min);
    jQuery('#pricerange_max').val(price_val_max);  
    setGetParameter('price_min',price_val_min);
    setGetParameter('price_max',price_val_max);
     var slider = jQuery("#amountSlider");
      slider.slider("values", 0, price_val_min);
      slider.slider("values", 1, price_val_max);
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
    
  });
  
  var minpricerange =jQuery( "#pricerange_min" ).val();
  var maxpricerange =jQuery( "#pricerange_max" ).val();
  
  var price_symbol =jQuery( "#price_symbol" ).val();
  
  var minpricerange_at =jQuery( "#pricerange_min" ).attr('reset-val');
  var maxpricerange_at =jQuery( "#pricerange_max" ).attr('reset-val');
  
  
  jQuery("#amountSlider").slider({
    range: true,
    min:<?=$min_price; ?>,
    max:<?=$max_price; ?>,
    values: [ minpricerange, maxpricerange ],
    step:0.1,
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) { 
        return false; 
      }

      jQuery('#calcAmount').val(price_symbol+parseInt(ui.values[0]));
      jQuery('#calcAmount2').val(price_symbol+parseInt(ui.values[1]));

      jQuery('#pricerange_min').val(parseInt(ui.values[0]));
      jQuery('#pricerange_max').val(parseInt(ui.values[1]));  
      
      setGetParameter('price_min',parseInt(ui.values[0]));
      setGetParameter('price_max',parseInt(ui.values[1]));
      
      jQuery('.recet_filter_button').attr('style','display:block');
    },
    change: function(event, ui) { 
      
      nu_submitajax();
    }
  }); 
  
  /*----======= Filtration : Polish =======----*/
  var minpolish =jQuery( "#polish-min-value" ).val();
  var maxpolish =jQuery( "#polish-max-value" ).val();
  /* jQuery( "#polish-min-value-pol" ).val(''); */
  jQuery( "#polish" ).slider({
    range: true,
    values: [ minpolish, maxpolish],
    min: 0,
    max: 4,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#polish_list li:nth-child('+ui.values[0]+')').addClass('focus');
      jQuery('ul#polish_list li:nth-child('+ui.values[0]+')').removeClass('focus_pol');
      jQuery('ul#polish_list li:nth-child('+(ui.values[1]+1)+')').addClass('focus');
      jQuery('ul#polish_list li:nth-child('+(ui.values[1]+1)+')').removeClass('focus_pol');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {
        jQuery('ul#polish_list li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#polish_list li:nth-child('+ i +')').addClass('focus_pol'); 
      } 
      
      var texts_pol = []; 
      jQuery( "#polish-min-value-pol" ).val('');
      jQuery('li.focus_pol').each(function(){
        texts_pol.push(jQuery(this).attr('data-id'));
      }); 
      jQuery( "#polish-min-value-pol" ).val(texts_pol);
      jQuery( "#polish-min-value" ).val(ui.values[0]);
      jQuery( "#polish-max-value" ).val(ui.values[1]);
      setGetParameter('polish',texts_pol);
      setGetParameter('pol_count',ui.values[0]+','+ui.values[1]);
    jQuery('.recet_filter_button').attr('style','display:block');
      
    },
    change: function( event, ui ) { 
      
      nu_submitajax();
      
    } 
  });
  
  /*----======= Filtration : Symmetry =======----*/
  var minsymmetry =jQuery( "#symmetry-min-value" ).val();
  var maxsymmetry =jQuery( "#symmetry-max-value" ).val();
  /* jQuery( "#symmetry-min-value-sym" ).val('');  */
  jQuery( "#symmetry" ).slider({
    range: true,
    values: [ minsymmetry, maxsymmetry], 
    min: 0,
    max: 4,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#symmetry_list li:nth-child('+ui.values[0]+')').addClass('focus');
      jQuery('ul#symmetry_list li:nth-child('+ui.values[0]+')').removeClass('focus_smtry');
      jQuery('ul#symmetry_list li:nth-child('+(ui.values[1]+1)+')').addClass('focus');
      jQuery('ul#symmetry_list li:nth-child('+(ui.values[1]+1)+')').removeClass('focus_smtry');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {
        jQuery('ul#symmetry_list li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#symmetry_list li:nth-child('+ i +')').addClass('focus_smtry');  
      }
      var texts_sym = []; 
      jQuery( "#symmetry-min-value-sym" ).val('');
      jQuery('li.focus_smtry').each(function(){
        texts_sym.push(jQuery(this).attr('data-id'));
      }); 
      jQuery( "#symmetry-min-value-sym" ).val(texts_sym); 
      jQuery( "#symmetry-min-value" ).val(ui.values[0]);
      jQuery( "#symmetry-max-value" ).val(ui.values[1]);
      setGetParameter('symmetry',texts_sym);
      setGetParameter('sym_count',ui.values[0]+','+ui.values[1]);
      jQuery('.recet_filter_button').attr('style','display:block');
      
    },
    change: function( event, ui ) { 
    
      nu_submitajax();
      
    } 
  });
  
  /*----======= Filtration : Lab =======----*/
  /* var minlab =jQuery( "#lab-min-value" ).val();
  var maxlab =jQuery( "#lab-max-value" ).val();
  jQuery( "#lab" ).slider({
    range: true,
    values: [ minlab, maxlab],
    min: 0,
    max: 4,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#lab_list li:nth-child('+ui.values[0]+')').addClass('focus');
      jQuery('ul#lab_list li:nth-child('+ui.values[0]+')').removeClass('focus_lab');
      jQuery('ul#lab_list li:nth-child('+(ui.values[1]+1)+')').addClass('focus');
      jQuery('ul#lab_list li:nth-child('+(ui.values[1]+1)+')').removeClass('focus_lab');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {
        jQuery('ul#lab_list li:nth-child('+ i +')').removeClass('focus'); 
        jQuery('ul#lab_list li:nth-child('+ i +')').addClass('focus_lab');        
      }

      var texts_lab = []; 
      jQuery( "#lab-min-value-lab" ).val('');
      jQuery('li.focus_lab').each(function(){
        texts_lab.push(jQuery(this).attr('data-id'));
      }); 
      jQuery( "#lab-min-value-lab" ).val(texts_lab);
      setGetParameter('lab',texts_lab); 
      jQuery( "#lab-min-value" ).val(ui.values[0]);
      jQuery( "#lab-max-value" ).val(ui.values[1]);
      setGetParameter('lab_count',ui.values[0]+','+ui.values[1]);
      jQuery('.recet_filter_button').attr('style','display:block');
      
    },
    change: function( event, ui ) { 
      
      nu_submitajax();
      
    } 
  });
   */
   
  var dtype_lab = jQuery('#lab-min-value-lab').val();
  jQuery('.lab_filter_class li').live('click', function(){
    if(jQuery(this).hasClass( "active")){
      jQuery(this).removeClass('active');
      jQuery(this).closest('li').find('input[type="checkbox"]').attr('checked', false);
    } else {
      jQuery(this).addClass('active');
      jQuery(this).closest('li').find('input[type="checkbox"]').attr('checked', true);
    }
    var dtype_lab = [];
    jQuery('.lab_filter_class li.active').each(function(index, elem) {
      dtype_lab.push(jQuery(elem).attr('id'));
    });
    jQuery('#lab-min-value-lab').val(dtype_lab);
    setGetParameter('lab',dtype_lab);
    nu_submitajax();
  });
  /*----====== Filtration : Depth =======----*/
  
  
  jQuery(".focuse_selector_depth").focusout(function(){
    
      var depth_val_min = jQuery('#calcDepth').val();
      var depth_val_max = jQuery('#calcDepth2').val();
      var depth_val_min = depth_val_min.replace('%','');
      var depth_val_max = depth_val_max.replace('%','');
      jQuery('#depth_min').val(depth_val_min);
      jQuery('#depth_max').val(depth_val_max);  
      setGetParameter('depth_min',depth_val_min);
      setGetParameter('depth_max',depth_val_max);
      var slider = jQuery("#depth");
      slider.slider("values", 0, depth_val_min);
      slider.slider("values", 1, depth_val_max);
      
      jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
    
  });
  
  
  var mindepth =jQuery( "#depth_min" ).val();
  var maxdepth =jQuery( "#depth_max" ).val();
  var mins =jQuery( "#depth_min" ).attr('reset-val');
  var maxs =jQuery( "#depth_max" ).attr('reset-val');
  
  
  jQuery("#depth").slider({
    range: true,
    min:<?=$min_depth; ?>,
    max:<?=$max_depth; ?>,
    values: [ mindepth, maxdepth ],
    step:0.1,
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) { 
        return false; 
      }

      jQuery('#calcDepth').val(ui.values[0]+'%');
      jQuery('#calcDepth2').val(ui.values[1]+'%');

      jQuery('#depth_min').val(ui.values[0]);
      jQuery('#depth_max').val(ui.values[1]); 
      setGetParameter('depth_min',ui.values[0]);
      setGetParameter('depth_max',ui.values[1]);
      jQuery('.recet_filter_button').attr('style','display:block');
    },
    change: function(event, ui) { 
      
      nu_submitajax();  
    }
    
  });
  
  /*----======= Filtration : Table =======----*/
  
  jQuery(".focuse_selector_table").focusout(function(){
    
      var table_val_min = jQuery('#calTable').val();
      var table_val_max = jQuery('#calTable2').val();
      var table_val_min = table_val_min.replace('%','');
      var table_val_max = table_val_max.replace('%','');
      jQuery('#table_min').val(table_val_min);
      jQuery('#table_max').val(table_val_max);
      setGetParameter('table_min',table_val_min);
      setGetParameter('table_max',table_val_max);
      var slider = jQuery("#table");
      slider.slider("values", 0, table_val_min);
      slider.slider("values", 1, table_val_max);
      jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
    
  });
  
  var mintable =jQuery("#table_min").val();
  var maxtable =jQuery("#table_max").val();
  var minstab =jQuery("#table_min").attr('reset-val');
  var maxstab =jQuery("#table_max").attr('reset-val');
  jQuery("#table").slider({
    range: true,
    min:<?=$min_table; ?>,
    max:<?=$max_table; ?>,
    values: [ mintable, maxtable ],
    step:0.1,
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) { 
        return false; 
      }

      jQuery('#calTable').val(ui.values[0]+'%');
      jQuery('#calTable2').val(ui.values[1]+'%');

      jQuery('#table_min').val(ui.values[0]);
      jQuery('#table_max').val(ui.values[1]);
      setGetParameter('table_min',ui.values[0]);
      setGetParameter('table_max',ui.values[1]);
      jQuery('.recet_filter_button').attr('style','display:block');
    },
    change: function(event, ui) { 
      
      nu_submitajax(); 
    }
      
  });
  
  /*----======= Filtration : R/W ratio =======----*/
  
  jQuery(".focuse_selector_rw_ratio").focusout(function(){
    
      var ratio_val_min = jQuery('#calc_rw_ratio').val();
      var ratio_val_max = jQuery('#calc_rw_ratio2').val();
      jQuery('#ratio_min').val(ratio_val_min);
      jQuery('#ratio_max').val(ratio_val_max);
      setGetParameter('ratio_min',ratio_val_min);
      setGetParameter('ratio_max',ratio_val_max);
      var slider = jQuery("#length_width");
      slider.slider("values", 0, ratio_val_min);
      slider.slider("values", 1, ratio_val_max);
      jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
    
  });
  
  var minratio =jQuery("#ratio_min").val();
  var maxratio =jQuery("#ratio_max").val();
  var minsratio =jQuery("#ratio_min").attr('reset-val');
  var maxsratio =jQuery("#ratio_max").attr('reset-val');
  
  jQuery("#length_width").slider({
    range: true,
    min:<?=$min_ratio; ?>,
    max:<?=$max_ratio; ?>,
    values: [ minratio, maxratio ],
    step: 0.01, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) { 
        return false; 
      }

      jQuery('#calc_rw_ratio').val(ui.values[0]);
      jQuery('#calc_rw_ratio2').val(ui.values[1]);

      jQuery('#ratio_min').val(ui.values[0]);
      jQuery('#ratio_max').val(ui.values[1]);  
      
      setGetParameter('ratio_min',ui.values[0]);
      setGetParameter('ratio_max',ui.values[1]);
      
      jQuery('.recet_filter_button').attr('style','display:block');
    },
    change: function(event, ui) { 
      
      nu_submitajax(); 
    }

  }); 
  
  
  /*----======= Filtration : Fluorescence =======----*/
  var minfluorescence =jQuery( "#fluorescence-min-value" ).val();
  var maxfluorescence =jQuery( "#fluorescence-max-value" ).val();
  jQuery( "#fluorescence" ).slider({
    range: true,
    values: [ minfluorescence, maxfluorescence],
    min: 0,
    max: 5,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      
      jQuery('ul#fluorescence_list li:nth-child('+ui.values[0]+')').addClass('focus');
      jQuery('ul#fluorescence_list li:nth-child('+ui.values[0]+')').removeClass('focus_flur');
      jQuery('ul#fluorescence_list li:nth-child('+(ui.values[1]+1)+')').addClass('focus');
      jQuery('ul#fluorescence_list li:nth-child('+(ui.values[1]+1)+')').removeClass('focus_flur');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {

        jQuery('ul#fluorescence_list li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#fluorescence_list li:nth-child('+ i +')').addClass('focus_flur');    
      }    
      var texts_sym = []; 
      jQuery( "#fluorescence-min-value-flo" ).val('');
      jQuery('li.focus_flur').each(function(){
        texts_sym.push(jQuery(this).attr('data-id'));
      }); 
      jQuery( "#fluorescence-min-value-flo" ).val(texts_sym); 
      jQuery( "#fluorescence-min-value" ).val(ui.values[0]);
      jQuery( "#fluorescence-max-value" ).val(ui.values[1]);
      setGetParameter('fluorescence',texts_sym);
      setGetParameter('fluor_count',ui.values[0]+','+ui.values[1]);
      jQuery('.recet_filter_button').attr('style','display:block');
      
    },
    change: function( event, ui ) { 
      nu_submitajax();
    } 
  });
  
  /*----======= Filtration : vendor type =======----*/

  var dtype = jQuery('#vendorname_type').val();
  jQuery('.vendorname_list li').live('click', function(){
    if(jQuery(this).hasClass( "active")){
      jQuery(this).removeClass('active');
      jQuery(this).closest('li').find('input[type="checkbox"]').attr('checked', false);
    } else {
      jQuery(this).addClass('active');
      jQuery(this).closest('li').find('input[type="checkbox"]').attr('checked', true);
    }
    var dtype = [];
    jQuery('.vendorname_list li.active').each(function(index, elem) {
      dtype.push(jQuery(elem).attr('id'));
    });
    jQuery('#vendorname_type').val(dtype);
    setGetParameter('vendor',dtype);
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
  });
  
  jQuery("#grid_list_view a").live('click',function(){
    var view_data = jQuery("#grid_list_view a.active").attr('data-layout');
    jQuery('#list_grid').val(view_data);
    nu_submitajax();
  }); 
  
  
    var list_grid =jQuery( "#list_grid" ).val();
    
  jQuery('#grid_list_view a').live('click', function(){
    jQuery('#grid_list_view a').removeClass('active');
    jQuery(this).addClass('active');
    var view_data = jQuery("#grid_list_view a.active").attr('data-layout');
    jQuery('#list_grid').val(view_data);
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
  });
  
  function nu_submitajax(){
    
    var shape_name = jQuery("#shape_name").val();
    var color_max_col = jQuery("#color-max-value-col").val();
    var cut_max_ct = jQuery("#cut-max-value-ct").val();
    var clarity_max_cal = jQuery("#clarity-min-value-clty").val();
    var polish_max = jQuery("#polish-min-value-pol").val();
    var symmetry_min = jQuery("#symmetry-min-value-sym").val();
    var lab_max = jQuery("#lab-min-value-lab").val();
    var fluorescence_max = jQuery("#fluorescence-min-value-flo").val();
    var vendor_name = jQuery('#vendorname_type').val();
    var paginationclicklinks = jQuery('#paginationclicklink-url').val(); 
    var carat_min = jQuery("#carat_min").val();
    var carat_max = jQuery("#carat_max").val();
    var price_min = jQuery("#pricerange_min").val();
    var price_max = jQuery("#pricerange_max").val();
    var price_symbol = jQuery("#price_symbol").val();
    var depth_min = jQuery("#depth_min").val();
    var depth_max = jQuery("#depth_max").val();
    var table_min = jQuery("#table_min").val();
    var table_max = jQuery("#table_max").val();
    var selectedorderdf = jQuery('#orderby_value').val();
    var list_grid = jQuery("#list_grid").val();
    var minratio = jQuery("#ratio_min").val();
    var maxratio = jQuery("#ratio_max").val();
    var pro_status = jQuery("#orderby_status").val();
    var diamond_type_val = jQuery('#mind_lg').val();
    var quick_ship=jQuery('#quick_ship').val();
    var videofilterh=jQuery('#videofilterh').val();
    jQuery("#overlay").show();
    var data = jQuery("#diamond_filter_data").serialize();

    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
    console.log("==>" + ajaxurl);
    
    jQuery.post(
      ajaxurl, 
      {
        'action': 'key_diamon_filter_ajs',
        'shape_name': shape_name,
        'carat_min':carat_min,
        'carat_max':carat_max,
        'price_min':price_min,
        'price_max':price_max,
        'price_symbol':price_symbol,
        'polish_max':polish_max,
        'symmetry_min':symmetry_min,
        'lab_max':lab_max,
        'depth_min':depth_min,
        'depth_max':depth_max,
        'table_min':table_min,
        'table_max':table_max,
        'fluorescence_max':fluorescence_max,
        'color_max_col':color_max_col,
        'cut_max_ct':cut_max_ct,
        'clarity_max_cal':clarity_max_cal,
        'selectedorderdf':selectedorderdf,
        'page':paginationclicklinks,
        'vendor_name':vendor_name,
        'list_grid':list_grid,
        'minratio':minratio,
        'maxratio':maxratio,
        'pro_status':pro_status,
        'diamond_type_val':diamond_type_val,
        'quick_ship':quick_ship,
        'videofilterh':videofilterh

      }, 
      function(response){
        jQuery("#overlay").hide();  
        jQuery('.ajax_result_data').html(response);
        
      }
    );
  
  }
  

})
});
</script>