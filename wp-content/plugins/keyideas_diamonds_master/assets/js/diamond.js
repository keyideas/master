/*jQuery(document).on('click',"#NUcsvimport",function(){
    jQuery.post(ajaxurl,{action:'nu_import_products'},function(response){

    });
});*/





//jQuery.ajaxSetup({async: false});  
    //jQuery.post();
    jQuery(document).on('click',"#QGimport",function(){
        //jQuery('.QG_response').html('Import In Progress....');
        jQuery.post(ajaxurl,{action:'total_qg_import_products'},function(response){
          /*var r=JSON.parse(response);
          jQuery.each(r, function(key, item){
            jQuery.post(ajaxurl,{action:'qg_import_products',
                Sku:item.Sku,
                Style:item.Style,
                Image:item.Image,
                ShapeCode:item.ShapeCode,
                Color:item.Color,
                Clarity:item.Clarity,
                Cut:item.Cut,
                SizeCt:item.SizeCt,
                SizeMM:item.SizeMM,
                SizeMMChar:item.SizeMMChar,
                CertType:item.CertType,
                PctOffRap:item.PctOffRap,
                PriceCt:item.PriceCt,
                PriceEach:item.PriceEach,
                Polish:item.Polish,
                Symmetry:item.Symmetry,
                DepthPct:item.DepthPct,
                TablePct:item.TablePct,
                Fluorescence:item.Fluorescence,
                LWRation:item.LWRation,
                CertLink:item.CertLink,
                TechType:item.TechType,
                VideoLink:item.VideoLink,
                MSRP:item.MSRP,
                WholesalePrice:item.WholesalePrice,
                DiscountWholesalePrice:item.DiscountWholesalePrice,
                RetailPrice:item.RetailPrice,
                ColorRegularFancy:item.ColorRegularFancy,
                Measurements:item.Measurements,
                ImageZoomEnabled:item.ImageZoomEnabled,
                ShapeDescription:item.ShapeDescription,
            },function(msg){
                console.log(msg);
            });
          });*/
        });
    });


/*jQuery(function() {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // jQuery("#successMessage").hide() function
    setTimeout(function() {
        jQuery(".QG_response").hide('blind', {}, 500)
    }, 5000);

    setTimeout(function() {
        jQuery(".JAS_response").hide('blind', {}, 500)
    }, 5000);

    setTimeout(function() {
      jQuery('.JAS_response').fadeOut('fast');
    }, 30000); // <-- time in milliseconds

    setTimeout(function() {
        jQuery(".UGLD_response").hide('blind', {}, 500)
    }, 5000);

            
});*/