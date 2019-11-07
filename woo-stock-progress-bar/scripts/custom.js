var wbpsSale = jQuery('#wpbs_total_sale').attr('total-sale');
var wbpsStock = jQuery('#wpbs_total_sale').attr('total-stock');
jQuery(document).ready(function(){
  jQuery('#jqmeter-container').jQMeter({
    goal:wbpsStock,
    raised:wbpsSale,
    meterOrientation:'horizontal',
    width:'300px',
    height:'5px'
  });
});
