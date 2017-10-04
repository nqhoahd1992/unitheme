/*  [ Button upload image on admin ]
- - - - - - - - - - - - - - - - - - - - */
jQuery(function($){
    /*
     * Select/Upload image(s) event
     */
    $('body').on('click', '.upload_image_button', function(e){
        e.preventDefault();
        var parent = $(this).parent();
            var button = $(this),
            custom_uploader = wp.media({
            title: 'Insert image',
            library : {
                type : 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false // for multiple image selection set to true
        }).on( 'select', function() { // it also has "open" and "close" events 
            var attachment = custom_uploader.state().get( 'selection' ).first().toJSON();
            $('.upload_image_input', parent ).val( attachment.url );
        })
        .open();
    });
 

 
});