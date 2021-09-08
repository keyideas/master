<?php
global $wpdb;

if(!empty($_GET["page"])) { $page_val = $_GET["page"]; } else { $page_val=1; }
$shape_name = $color_max_col = $clarity_max_cal = $carat_min = $carat_max = $price_min = $price_max = $cut_max_ct = $vendor_name = $order_by_data = $order_by = $vendor_name = $cut = '';
/*********shape filter************************/
/* $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
  if (!empty($_GET['shape'])) {
    $shape_name=$_GET['shape'];
  } else {
    $shape_name='';
  }
} */
$result_val = filter_curl_function();

/*********carat filter************************/
$carat_min = $result_val['carat'][0]['mincarat'];
$carat_max = $result_val['carat'][0]['maxcarat'];

if (!empty($_GET['carat_min'])) {
  $carat_min_val = $_GET['carat_min'];
}else{
  $carat_min_val = $carat_min;
}
if (!empty($_GET['carat_max'])) {
  $carat_max_val = $_GET['carat_max'];
}else{
  $carat_max_val = $carat_max;
}

/*********price filter ************************/
$currency = get_woocommerce_currency_symbol();
$min_price = $result_val['price'][0]['minprice'];
$max_price = $result_val['price'][0]['maxprice'];

if (!empty($_GET['price_min'])) {
  $price_min_val = $_GET['price_min'];
}else{
  $price_min_val =$min_price;
}
if (!empty($_GET['price_max'])) {
  $price_max_val = $_GET['price_max'];
}else{
  $price_max_val = $max_price;  
}

 


if (isset($_GET['shape'])) {
    $shape_name=$_GET['shape'];
  } 
if(isset($_GET['color'])) {
  $color_max_col = $_GET['color'];
} 

if(isset($_GET['cut'])) {
  $cut = $_GET['cut'];
} 

if(isset($_GET['clarity'])) {
  $clarity_max_cal = $_GET['clarity'];
} 

if(isset($_GET['orderby'])) {
  $order_by = $_GET['orderby'];
} 
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
  $cl_2 = 9;
}

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
$shapes = Filters['shapes'];
$color_arr = Filters['colors'];
$clarity_arr = Filters['clarity'];
$cutArr = array("Good","Very Good","Excellent","Ideal");
?>
<!-- Desktop Filter HTML -->
<div class="filter-section-wrapper d-block d-sm-block d-md-block filter_section_wrapper">
  <div class="container">
    <div class="row">
      <div class="w-1001">
        <p class="d-md-none mb-0"> 
          <a class="btn filter-btn text-left" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            Filter <span><i class="fa fa-angle-down" aria-hidden="true"></i> </span>
          </a>
        </p>
        <div class="collapse d-md-block" id="collapseExample">
          <div class="filter-row-inner w-100 d-flex flex-wrap mt-4 mt-md-0">
            <?php
            if(AllowFilter['shape'] == true) {
              if(count($shapes) > 0) {
            ?>
              <div class="shape-certificate-row w-100 filter_section_div">
                <div class="shape-left">
                  <div class="filter-heading">Shapes</div>
                    <div class="d-block">
                      <div id="list_shape" class="diff-diamond-images pt-0 w-100 d-flex justify-content-between">
                        <?php
                        $a=0;
                        foreach ($shapes as $shapes_name) {
                          $keys = strtolower($shapes_name);
                          if($shape_name == $shapes_name) { $active="active"; } else { $active="";}
                            $a++;
                        ?>
                          <div id="shape<?php echo $a;?>" title="<?php echo $shapes_name;?>" class="<?php echo $keys;?> diamond-spirit-img1 <?php echo $active;?>">
                            <img src="<?php echo get_template_directory_uri();?>/images/<?php echo $keys;?>.png" class="img-fluid" alt="<?php echo $keys;?>" title="<?php echo $shapes_name;?>">
                            <div class="hoverDiv">
                                <div class="tooltip">
                                    <div class="prdName"><?php echo $shapes_name;?></div>
                                    <div class="arrow">&nbsp;</div>
                                </div>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                </div>
              </div>
            <?php } } if(AllowFilter['price'] == true) { ?>
              <div class="price gbl-spacing filter_section_div">
                <div class="filter-heading">Price</div>
                <div class="nu-custom-range-slider">
                  <div id="slider-range1"></div>
                  <div class="range-slider">
                    <div class="number-group d-flex justify-content-between">
                      <p><input class="number-input focuse_selector" id="calcAmount" value="<?php echo $currency.$price_min_val ; ?>"/></p>
                      <p><input class="number-input focuse_selector" id="calcAmount2" value="<?php echo $currency.$price_max_val;?>"/></p>
                    </div>
                  </div>
                </div>
              </div>
            <?php } if(AllowFilter['caret'] == true) { ?>
              <div class="carat gbl-spacing filter_section_div">
                <div class="filter-heading">Carat</div>
                <div class="nu-custom-range-slider">
                  <div id="slider-range2"></div>
                  <div class="range-slider">
                    <div class="number-group d-flex justify-content-between">
                      <p><input class="number-input focuse_selector_carat" id="calcCarat" value="<?php echo $carat_min_val;?>"/></p>
                      <p><input class="number-input focuse_selector_carat" id="calcCarat2" value="<?php echo $carat_max_val;?>"/></p>
                    </div>
                  </div>
                </div>
              </div>
            <?php } if(AllowFilter['cut'] == true) { ?>
              <div class="cut gbl-spacing mb-5 filter_section_div">
                <div class="filter-heading">Cut</div>
                <div class="nu-custom-range-slider">
                  <div id="slider-range3"></div>
                  <div class="range-slider">
                    <div class="number-group">
                      <ul id="cut_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">
                        <?php
                        for($ca=0;$ca<count($cutArr);$ca++) {
                          if($ca<$cut_1 || $ca>=$cut_2) {
                            $nofocus = "focus";
                          } else {
                            $nofocus = "focus_ct_value";
                          }
                        ?>
                          <li class="<?php echo $nofocus;?>" value="<?php echo $ca;?>" data-id="<?php echo $cutArr[$ca];?>"><?php echo $cutArr[$ca];?></li>
                        <?php
                        }
                        ?>
                      </ul>
                    </div>
                  </div>
                </div> 
              </div>
            <?php
            }
            if(AllowFilter['color'] == true) {
              if(count($color_arr) > 0) {
            ?>
                <div class="color gbl-spacing mb-5 filter_section_div">
                  <div class="filter-heading">Color</div>
                  <div class="nu-custom-range-slider">
                    <div id="slider-range4"></div>
                    <div class="range-slider">
                      <div class="number-group">
                        <ul id="color_list" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">
                          <?php
                          $a=0;
                          foreach ($color_arr as $color) {
                            if($co_1>$a || $co_2<=$a) {
                              $nofocus = "focus";
                            } else {
                              $nofocus = "focus_col_value";
                            }
                          ?>
                            <li class="<?php echo $nofocus;?>" value="<?php echo $a;?>" data-id="<?php echo $color;?>"><?php echo $color;?></li>
                          <?php
                            $a++;
                          }
                          ?>
                        </ul>
                      </div>
                    </div>
                  </div> 
                </div>
            <?php
              }
            }
            if(AllowFilter['clarity'] == true) {
              if(count($clarity_arr)>0) {
            ?>
                <div class="clarity gbl-spacing mb-5 filter_section_div">
                  <div class="filter-heading">Clarity</div>
                  <div class="nu-custom-range-slider">
                    <div id="slider-range5"></div>
                    <div class="range-slider">
                      <div class="number-group">
                        <ul id="clarity_list1" class="rangebar-custom-label d-flex justify-content-between mt-2 mb-0 p-0 w-100">
                          <?php
                          $totalClarity = count($clarity_arr)-1;
                          for($cx=0; $cx<$totalClarity; $cx++) {
                            if($cl_1>$cx || $cl_2<=$cx) {
                              $nofocus = "focus";
                            } else {
                              $nofocus = "focus_clarity";
                            }
                            if($cx == $totalClarity-1) {
                              $key = $clarity_arr[$cx].",".$clarity_arr[$cx+1];
                              $clarity = $clarity_arr[$cx]."/".$clarity_arr[$cx+1];
                            } else {
                              $key = $clarity_arr[$cx];
                              $clarity = $clarity_arr[$cx];
                            }
                          ?>
                            <li class="<?php echo $nofocus;?>" value="<?php echo $cx;?>" data-id="<?php echo $key;?>"><?php echo $clarity;?></li>
                          <?php
                          }
                          ?>
                        </ul>
                      </div>
                    </div>
                  </div> 
                </div>
              <?php
              }
            }
            ?>
            <div class="w-100 text-center mb-4">
              <div class="recet_filter_button" style="cursor: pointer;">X Clear Filter</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Desktop Filter HTML //-->

<!-- Mobile Filter HTML //-->
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
  <input type="hidden" id="orderby_status" name="orderby_status" value="<?php echo $status ; ?>">
  <input type="hidden" id="orderby_value" name="orderby_value" value="<?php echo $order_by ; ?>">
  <input type="hidden" id="reset_filter" name="reset_filter" value="0">

</form>

<script>
jQuery(document).ready(function() {
  function setGetParameter(paramName, paramValue) {
    var url = window.location.href;
    var hash = location.hash;
    url = url.replace(hash, '');
    if (url.indexOf(paramName + "=") >= 0) {
      var prefix = url.substring(0, url.indexOf(paramName + "=")); 
      var suffix = url.substring(url.indexOf(paramName + "="));
      suffix = suffix.substring(suffix.indexOf("=") + 1);
      suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
      url = prefix + paramName + "=" + paramValue + suffix;
    } else {
      if (url.indexOf("?") < 0)
        url += "?" + paramName + "=" + paramValue;
      else
        url += "&" + paramName + "=" + paramValue;
    }
    var obj = { Page: paramName, Url: url };
    history.pushState(obj, obj.paramName, obj.Url);
  }

  jQuery('.recet_filter_button').on('click', function(){
    var uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
      var clean_uri= '<?php echo get_site_url();?>/diamonds/';
      window.history.replaceState({}, document.title, clean_uri);
    }
    jQuery('#reset_filter').val('1');

    jQuery('#list_shape div').removeClass('active');
    jQuery('#list_shape1 div').removeClass('active');
    jQuery('#shape_name').val('');

    jQuery('#paginationclicklink-url').val('1');
    jQuery('#orderby_value').val('');

    jQuery( "#color-max-value-col" ).val(''); 
    jQuery( "#color-min-value" ).val('0');
    jQuery( "#color-max-value" ).val('9');

    jQuery( "#cut-min-value" ).val('0');
    jQuery( "#cut-max-value" ).val('4');
    jQuery( "#cut-max-value-ct" ).val('');

    jQuery( "#clarity-min-value-clty" ).val('');
    jQuery( "#clarity-min-value" ).val('0');
    jQuery( "#clarity-max-value" ).val('9');
    
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

    resetcolor();
    resetcut();
    resetclarity();    
    resetamountSlider();
    resetcarat();
    nu_submitajax();
    jQuery(".recet_filter_button").attr('style','display:none');
    jQuery("#reset_filter").val('0');
  });

  function resetcolor() {
    /* for desktop filter */
    var slider4 = jQuery("#slider-range4");
    slider4.slider("values", 0, 0);
    slider4.slider("values", 1, 9);
    /* for mobile filter */
    var slider41 = jQuery("#slider-range41");
    slider41.slider("values", 0, 0);
    slider41.slider("values", 1, 9);
  }
  function resetcut() {
    /* for desktop filter */
    var slider3 = jQuery("#slider-range3");
    slider3.slider("values", 0, 0);
    slider3.slider("values", 1, 4);
    /* for mobile filter */
    var slider31 = jQuery("#slider-range31");
    slider31.slider("values", 0, 0);
    slider31.slider("values", 1, 4);
  }
  function resetclarity() {
    /* for desktop filter */
    var slider5 = jQuery("#slider-range5");
    slider5.slider("values", 0, 0);
    slider5.slider("values", 1, 9);
    /* for mobile filter */
    var slider51 = jQuery("#slider-range51");
    slider51.slider("values", 0, 0);
    slider51.slider("values", 1, 9);
  }

  function resetamountSlider() {
    /*var minpricerange = jQuery("#calcAmount").val();
    var maxpricerange = jQuery("#calcAmount2").val();*/

    var minpricerange = '<?php echo $min_price; ?>';
    var maxpricerange = '<?php echo $max_price; ?>';

    /* for desktop filter */
    var slider1 = jQuery("#slider-range1");
    slider1.slider("values", 0, minpricerange);
    slider1.slider("values", 1, maxpricerange);
    /* for mobile filter */
    var slider11 = jQuery("#slider-range11");
    slider11.slider("values", 0, minpricerange);
    slider11.slider("values", 1, maxpricerange);
  }

  function resetcarat() {
    /*var carat_min_r = jQuery('#carat_min').attr('reset-val');
    var carat_max_r = jQuery('#carat_max').attr('reset-val');*/

    var carat_min_r = '<?php echo $carat_min; ?>';
    var carat_max_r = '<?php echo $carat_max; ?>';

    /* for desktop filter */
    var slider2 = jQuery("#slider-range2");
    slider2.slider("values", 0, carat_min_r);
    slider2.slider("values", 1, carat_max_r);
    /* for desktop filter */
    var slider21 = jQuery("#slider-range21");
    slider21.slider("values", 0, carat_min_r);
    slider21.slider("values", 1, carat_max_r);
  }

  /*----======= SortBy : Price =======----*/
  jQuery("#sortByPrice").on("click", function(){
	   jQuery("#example thead tr th").removeClass("sorting_icon");
    var orderby = jQuery("#orderby_value").val();
    if(orderby == "Orderbyprice-desc") {
		jQuery("#sortByPrice").addClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbyprice-asc");
      setGetParameter('orderby', 'Orderbyprice-asc');
    } else {
		jQuery("#sortByPrice").removeClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbyprice-desc");
      setGetParameter('orderby', 'Orderbyprice-desc');
    }
    nu_submitajax();
  });
  /*----======= SortBy : Cut =======----*/
  jQuery("#sortByCut").on("click", function(){
	   jQuery("#example thead tr th").removeClass("sorting_icon");
    var orderby = jQuery("#orderby_value").val();
    if(orderby == "Orderbycut-desc") {
		jQuery("#sortByCut").addClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbycut-asc");
      setGetParameter('orderby', 'Orderbycut-asc');
    } else {
		jQuery("#sortByCut").removeClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbycut-desc");
      setGetParameter('orderby', 'Orderbycut-desc');
    }
    nu_submitajax();
  });
  /*----======= SortBy : Clarity =======----*/
  jQuery("#sortByClarity").on("click", function(){
	   jQuery("#example thead tr th").removeClass("sorting_icon");
    var orderby = jQuery("#orderby_value").val();
    if(orderby == "Orderbyclarity-desc") {
		jQuery("#sortByClarity").addClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbyclarity-asc");
      setGetParameter('orderby', 'Orderbyclarity-asc');
    } else {
		jQuery("#sortByClarity").removeClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbyclarity-desc");
      setGetParameter('orderby', 'Orderbyclarity-desc');
    }
    nu_submitajax();
  });
  /*----======= SortBy : Color =======----*/
  jQuery("#sortByColor").on("click", function(){
	   jQuery("#example thead tr th").removeClass("sorting_icon");
    var orderby = jQuery("#orderby_value").val();
    if(orderby == "Orderbycolor-desc") {
		jQuery("#sortByColor").addClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbycolor-asc");
      setGetParameter('orderby', 'Orderbycolor-asc');
    } else {
		jQuery("#sortByColor").removeClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbycolor-desc");
      setGetParameter('orderby', 'Orderbycolor-desc');
    }
    nu_submitajax();
  });
  /*----======= SortBy : Carat =======----*/
  jQuery("#sortByCarat").on("click", function(){
	  jQuery("#example thead tr th").removeClass("sorting_icon");
    var orderby = jQuery("#orderby_value").val();
    if(orderby == "Orderbycarat-desc") {
      jQuery("#sortByCarat").addClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbycarat-asc");
      setGetParameter('orderby', 'Orderbycarat-asc');
    } else {
	  jQuery("#sortByCarat").removeClass("sorting_icon");
      jQuery("#orderby_value").val("Orderbycarat-desc");
      setGetParameter('orderby', 'Orderbycarat-desc');
    }
    nu_submitajax();
  });

  /*----======= Filtration : Diamond shape =======----*/
  /* for desktop filter */
  jQuery("#list_shape div.diamond-spirit-img1").click(function() {
    var shape = jQuery(this).attr('title');
    jQuery('#shape_name').val(shape);
    setGetParameter('shape',shape);
    jQuery('.recet_filter_button').attr('style','display:block');
    jQuery("#list_shape div").removeClass('active');
    jQuery(this).addClass('active');
    nu_submitajax();
  });
  /* for mobile filter */
  jQuery("#list_shape1 div").click(function() {
    var shape = jQuery(this).attr('title');
    jQuery('#shape_name').val(shape);
    setGetParameter('shape',shape);
    jQuery('.recet_filter_button').attr('style','display:block');
    jQuery("#list_shape1 div").removeClass('active');
    jQuery(this).addClass('active');
    nu_submitajax();
  });

  /*----======= Filtration : Color / Fancy =======----*/
  var color_min=jQuery( "#color-min-value" ).val();
  var color_max=jQuery( "#color-max-value" ).val();

  /* for desktop filter */
  jQuery( "#slider-range4" ).slider({
    range: true,
    values: [ color_min, color_max], 
    min: 0,
    max: 9,
    step: 1, 
    slide: function( event, ui ) {
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#color_list li').addClass('focus');
      jQuery('ul#color_list li').removeClass('focus_col_value');
      
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
      var reset_filter =jQuery( "#reset_filter" ).val();
      if (reset_filter==1) {
        jQuery('ul#color_list li').removeClass('focus'); 
        return false;
      } else {
        nu_submitajax();
      }
    }
  });
  /* for mobile filter */
  jQuery( "#slider-range41" ).slider({
    range: true,
    values: [ color_min, color_max], 
    min: 0,
    max: 9,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#color_list41 li').addClass('focus');
      jQuery('ul#color_list41 li').removeClass('focus_col_value');
      
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++){
        jQuery('ul#color_list41 li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#color_list41 li:nth-child('+ i +')').addClass('focus_col_value'); 
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
      var reset_filter =jQuery( "#reset_filter" ).val();
      if (reset_filter==1) {
        jQuery('ul#color_list41 li').removeClass('focus');
        return false;
      } else {
        nu_submitajax();
      }
    }
  });
  
  /*----======= Filtration : Diamond Cut =======----*/
  var mincut =jQuery( "#cut-min-value" ).val();
  var maxcut =jQuery( "#cut-max-value" ).val();
  /* for desktop filter */
  jQuery('ul#cut_list li').removeClass('focus_ct_value');
  jQuery( "#slider-range3" ).slider({
    range: true,
    values: [ mincut, maxcut],
    min: 0,
    max: 4,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#cut_list li').addClass('focus');
      jQuery('ul#cut_list li').removeClass('focus_ct_value');
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
      var reset_filter =jQuery( "#reset_filter" ).val();
      if (reset_filter==1) {
        jQuery('ul#cut_list li').removeClass('focus');
        return false;
      } else {
        nu_submitajax();
      }
    }
  });
  /* for mobile filter */
  jQuery('ul#cut_list31 li').removeClass('focus_ct_value');
  jQuery( "#slider-range31" ).slider({
    range: true,
    values: [ mincut, maxcut],
    min: 0,
    max: 4,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#cut_list31 li').addClass('focus');
      jQuery('ul#cut_list31 li').removeClass('focus_ct_value');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {
        jQuery('ul#cut_list31 li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#cut_list31 li:nth-child('+ i +')').addClass('focus_ct_value');
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
      var reset_filter =jQuery( "#reset_filter" ).val();
      if (reset_filter==1) {
        jQuery('ul#cut_list31 li').removeClass('focus');
        return false;
      } else {
        nu_submitajax();
      }
    }
  });
  
  /*----======= Filtration : Clarity =======----*/
  var minclarity =jQuery( "#clarity-min-value" ).val();
  var maxclarity =jQuery( "#clarity-max-value" ).val();
  /* for desktop filter */
  jQuery( "#slider-range5" ).slider({
    range: true,
    values: [ minclarity, maxclarity],
    min: 0,
    max: 9,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#clarity_list1 li').addClass('focus');
      jQuery('ul#clarity_list1 li').removeClass('focus_clarity');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {
        jQuery('ul#clarity_list1 li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#clarity_list1 li:nth-child('+ i +')').addClass('focus_clarity');
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
      var reset_filter =jQuery( "#reset_filter" ).val();
      if (reset_filter==1) {
        jQuery('ul#clarity_list1 li').removeClass('focus');
        return false;
      } else {
        nu_submitajax();
      }
    }
  });
  /* for mobile filter */
  jQuery( "#slider-range51" ).slider({
    range: true,
    values: [ minclarity, maxclarity],
    min: 0,
    max: 9,
    step: 1, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) {
        return false;
      }
      jQuery('ul#clarity_list11 li').addClass('focus');
      jQuery('ul#clarity_list11 li').removeClass('focus_clarity');
      for(var i=(ui.values[0]+1);i<(ui.values[1]+1);i++)
      {
        jQuery('ul#clarity_list11 li:nth-child('+ i +')').removeClass('focus');  
        jQuery('ul#clarity_list11 li:nth-child('+ i +')').addClass('focus_clarity');
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
      var reset_filter =jQuery( "#reset_filter" ).val();
      if (reset_filter==1) {
        jQuery('ul#clarity_list11 li').removeClass('focus');
        return false;
      } else {
        nu_submitajax();
      }
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
    /* for desktop filter */
    var slider = jQuery("#slider-range2");
    slider.slider("values", 0, carat_val_min);
    slider.slider("values", 1, carat_val_max);
    /* for mobile filter */
    var slider21 = jQuery("#slider-range21");
    slider21.slider("values", 0, carat_val_min);
    slider21.slider("values", 1, carat_val_max);
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
  });
  var mincarat =jQuery( "#carat_min" ).val();
  var maxcarat =jQuery( "#carat_max" ).val();
  var mincarat_at =jQuery( "#carat_min" ).attr('reset-val');
  var maxcarat_at =jQuery( "#carat_max" ).attr('reset-val');
  
  /* for desktop filter */
  jQuery("#slider-range2").slider({
    range: true,
    min:<?php echo $carat_min; ?>,
    max:<?php echo $carat_max; ?>,
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
      var reset_filter =jQuery( "#reset_filter" ).val();
      if (reset_filter==1) {
        return false;
      } else {
        nu_submitajax();
      }
    }
  });
  /* for mobile filter */
  jQuery("#slider-range21").slider({
    range: true,
    min:<?php echo $carat_min; ?>,
    max:<?php echo $carat_max; ?>,
    values: [ mincarat, maxcarat ],
    step: 0.01, 
    slide: function( event, ui ) { 
      if ((ui.values[0]) >= (ui.values[1])) { 
        return false; 
      }
      jQuery('#calcCarat21').val(ui.values[0]);
      jQuery('#calcCarat22').val(ui.values[1]);
      jQuery('#carat_min').val(ui.values[0]);
      jQuery('#carat_max').val(ui.values[1]);  
      setGetParameter('carat_min',ui.values[0]);
      setGetParameter('carat_max',ui.values[1]);
      jQuery('.recet_filter_button').attr('style','display:block');
    },
    change: function(event, ui) { 
      var reset_filter =jQuery( "#reset_filter" ).val();
      if (reset_filter==1) {
        return false;
      } else {
        nu_submitajax();
      }
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
    /* for desktop filter */
    var slider = jQuery("#slider-range1");
    slider.slider("values", 0, price_val_min);
    slider.slider("values", 1, price_val_max);
    /* for mobile filter */
    var slider1 = jQuery("#slider-range11");
    slider1.slider("values", 0, price_val_min);
    slider1.slider("values", 1, price_val_max);
    jQuery('.recet_filter_button').attr('style','display:block');
    nu_submitajax();
  });
  var minpricerange =jQuery( "#pricerange_min" ).val();
  var maxpricerange =jQuery( "#pricerange_max" ).val();
  var price_symbol =jQuery( "#price_symbol" ).val();
  var minpricerange_at =jQuery( "#pricerange_min" ).attr('reset-val');
  var maxpricerange_at =jQuery( "#pricerange_max" ).attr('reset-val');

  jQuery( function() {
    /* for desktop filter */
    jQuery( "#slider-range1" ).slider({
      range: true,
      min: <?php echo $min_price; ?>,
      max: <?php echo $max_price; ?>,
      values: [ minpricerange, maxpricerange ],
      slide: function( event, ui ) {
        jQuery( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
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
        var reset_filter =jQuery( "#reset_filter" ).val();
        if (reset_filter==1) {
          return false;
        } else {
          nu_submitajax();
        }
      }
    });
    /* for mobile filter */
    jQuery( "#slider-range11" ).slider({
      range: true,
      min: <?php echo $min_price; ?>,
      max: <?php echo $max_price; ?>,
      values: [ minpricerange, maxpricerange ],
      slide: function( event, ui ) {
        jQuery( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        if ((ui.values[0]) >= (ui.values[1])) { 
          return false; 
        }
        jQuery('#calcAmount11').val(price_symbol+parseInt(ui.values[0]));
        jQuery('#calcAmount12').val(price_symbol+parseInt(ui.values[1]));
        jQuery('#pricerange_min').val(parseInt(ui.values[0]));
        jQuery('#pricerange_max').val(parseInt(ui.values[1]));  
        setGetParameter('price_min',parseInt(ui.values[0]));
        setGetParameter('price_max',parseInt(ui.values[1]));
        jQuery('.recet_filter_button').attr('style','display:block');
      },
      change: function(event, ui) { 
        var reset_filter =jQuery( "#reset_filter" ).val();
        if (reset_filter==1) {
          return false;
        } else {
          nu_submitajax();
        }
      }
    });
  });

  function nu_submitajax(){
    var shape_name = jQuery("#shape_name").val();
    var color_max_col = jQuery("#color-max-value-col").val();
    var cut_max_ct = jQuery("#cut-max-value-ct").val();
    var clarity_max_cal = jQuery("#clarity-min-value-clty").val();
    // var paginationclicklinks = jQuery('#paginationclicklink-url').val();
    var carat_min = jQuery("#carat_min").val();
    var carat_max = jQuery("#carat_max").val();
    var price_min = jQuery("#pricerange_min").val();
    var price_max = jQuery("#pricerange_max").val();
    var price_symbol = jQuery("#price_symbol").val();
    var selectedorderdf = jQuery('#orderby_value').val();
    var pro_status = jQuery("#orderby_status").val();
    jQuery("#overlay").show();
    var data = jQuery("#diamond_filter_data").serialize();
    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
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
        'color_max_col':color_max_col,
        'cut_max_ct':cut_max_ct,
        'clarity_max_cal':clarity_max_cal,
        'selectedorderdf':selectedorderdf
      }, 
      function(response){
        var result = response.split("~");
        jQuery("#overlay").hide();
        jQuery("#diamondInfo").css("display","none");
        jQuery("#defaultInfo").css("display","block");
        jQuery('#ajax_result_data').html(result[0]);
        jQuery('#totalDiamond').html(result[1]);
      }
    );
  }
});
</script>