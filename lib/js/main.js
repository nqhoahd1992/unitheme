jQuery(document).ready(function(){

    /* Quantity Product
     ---------------------------------------------------------------*/
    jQuery('body').on('click', 'a.shopping-cart-icon-container', function(){
        jQuery('.shopping-cart-wrapper').toggleClass('open');
    });
    jQuery('body').on('click', 'a.menu-cart-close', function(){
        jQuery('.shopping-cart-wrapper').toggleClass('open');
    });

    if ( ! String.prototype.getDecimals ) {
        String.prototype.getDecimals = function() {
            var num = this,
                match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            if ( ! match ) {
                return 0;
            }
            return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
        }
    }
 
    function wcqi_refresh_quantity_increments(){
        jQuery( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );
    }
 
    jQuery( document ).on( 'updated_wc_div', function() {
        wcqi_refresh_quantity_increments();
    } );
 
    jQuery( document ).on( 'click', '.plus, .minus', function() {
        // Get values
        var $qty        = jQuery( this ).closest( '.quantity' ).find( '.qty'),
            currentVal  = parseFloat( $qty.val() ),
            max         = parseFloat( $qty.attr( 'max' ) ),
            min         = parseFloat( $qty.attr( 'min' ) ),
            step        = $qty.attr( 'step' );
 
        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;
 
        // Change the value
        if ( jQuery( this ).is( '.plus' ) ) {
            if ( max && ( currentVal >= max ) ) {
                $qty.val( max );
            } else {
                $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
            }
        } else {
            if ( min && ( currentVal <= min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
            }
        }
 
        // Trigger change event
        $qty.trigger( 'change' );
    });
    wcqi_refresh_quantity_increments();
 
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

    /* Owl Carousel
     ---------------------------------------------------------------*/
    if ( jQuery().owlCarousel ) {
        var owl = jQuery(".owl-carousel");
        owl.each(function(){
            var items    = jQuery(this).data('item'),
                margin   = jQuery(this).data('margin'),
                items_md = jQuery(this).data('md'),
                items_sm = jQuery(this).data('sm'),
                items_xs = jQuery(this).data('xs'),
                dots     = jQuery(this).data('dots'),
                nav      = jQuery(this).data('nav');
            jQuery(this).owlCarousel({
                items: items,
                margin: margin,
                loop: true,
                autoplay: true,
                autoplaySpeed: 2000,
                // autoplayHoverPause: false,
                nav: nav,
                navText: [
                    '<div><i class="fa fa-angle-left"></i></div>',
                    '<div><i class="fa fa-angle-right"></i></div>'
                ],
                dots: dots,
                lazyLoad: true,
                lazyContent: true,
                responsive: {
                    320: {
                        items: items_xs
                    },
                    480: {
                        items: items_xs
                    },
                    768: {
                        items: items_sm
                    },
                    992: {
                        items: items_md
                    },
                    1200: {
                        items: items
                    }
                },
            });
        });
    }

    /* Mobile Menu
     ---------------------------------------------------------------*/
    jQuery('#showmenu').click(function(){
        jQuery('#mobilenav').toggleClass('opened');
        jQuery('.panel-overlay').toggleClass('active');
        jQuery('.hamburger',this).toggleClass('is-active');
    });

    jQuery('.panel-overlay').click(function(){
        jQuery('#mobilenav').toggleClass('opened');
        jQuery(this).removeClass('active');
        jQuery('#showmenu .hamburger').removeClass('is-active');
    });

    jQuery("#mobilenav ul.sub-menu").before('<span class="arrow"></span>');

    jQuery("body").on('click','#mobilenav .arrow', function(){
        jQuery(this).parent('li').toggleClass('open');
        jQuery(this).parent('li').find('ul.sub-menu').slideToggle( "normal" );
    });

});