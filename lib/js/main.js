jQuery(document).ready(function(){
 
    /* Backtop
     ---------------------------------------------------------------*/
    jQuery("#back-top").hide();
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('#back-top').fadeIn(100);
        } else {
            jQuery('#back-top').fadeOut(100);
        }
    });
    jQuery('#back-top a').click(function () {
        jQuery('body,html').animate( { scrollTop: 0 }, 800 );
        return false;
    });

});