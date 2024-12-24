
	
jQuery(function($) {
    "use strict";
    /*=======================================
	General
	=======================================*/
    var xv_ww = $(window).width();
    
    /*=======================================
	Parallax
	=======================================*/
	if(xv_ww>=768){
		$.stellar({
			horizontalScrolling: false,
			verticalOffset: 0,
			responsive: true,
		});
	} 
    
    
});/*end ready*//*end require*/