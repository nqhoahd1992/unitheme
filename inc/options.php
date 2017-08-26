<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "sh_option";


    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'shtheme' ),
        'page_title'           => __( 'Theme Options', 'shtheme' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-admin-generic',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,

        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => 'dashicons-admin-generic',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        'show_options_object'  => false,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );


    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    // $tabs = array(
    //     array(
    //         'id'      => 'redux-help-tab-1',
    //         'title'   => __( 'Theme Information 1', 'shtheme' ),
    //         'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'shtheme' )
    //     ),
    //     array(
    //         'id'      => 'redux-help-tab-2',
    //         'title'   => __( 'Theme Information 2', 'shtheme' ),
    //         'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'shtheme' )
    //     )
    // );
    // Redux::setHelpTab( $opt_name, $tabs );

    // // Set the help sidebar
    // $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'shtheme' );
    // Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Layout Fields
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Thiết lập chung', 'shtheme' ),
        'id'               => 'general',
        // 'desc'             => __( 'These are really basic fields!', 'shtheme' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-dashboard'
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout', 'shtheme' ),
        'id'               => 'general-layout',
        'subsection'       => true,
        // 'desc'             => __( 'For full documentation on this field, visit: ', 'shtheme' ),
        'fields'           => array(
            array(
            	'id'       => 'opt-layout',
			    'type'     => 'image_select',
			    'title'    => __('Main Layout', 'shtheme'), 
			    // 'subtitle' => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'shtheme'),
			    'options'  => array(
			        '1'      => array(
			            'alt'   => '1 Column', 
			            'img'   => ReduxFramework::$_url.'assets/img/1col.png'
			        ),
			        '2'      => array(
			            'alt'   => '2 Column Left', 
			            'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
			        ),
			        '3'      => array(
			            'alt'   => '2 Column Right', 
			            'img'  => ReduxFramework::$_url.'assets/img/2cr.png'
			        ),
			        '4'      => array(
			            'alt'   => '3 Column Middle', 
			            'img'   => ReduxFramework::$_url.'assets/img/3cm.png'
			        ),
			        '5'      => array(
			            'alt'   => '3 Column Left', 
			            'img'   => ReduxFramework::$_url.'assets/img/3cl.png'
			        ),
			        '6'      => array(
			            'alt'  => '3 Column Right', 
			            'img'  => ReduxFramework::$_url.'assets/img/3cr.png'
			        )
			    ),
			    'default' => '2'
            ),
            array(
            	'id'       => 'opt-layout-header',
			    'type'     => 'image_select',
			    'title'    => __('Header Layout', 'shtheme'), 
			    // 'subtitle' => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'shtheme'),
			    'options'  => array(
			        '1'      => array(
			            'alt'   => '1 Column', 
			            'img'   => get_stylesheet_directory_uri().'/lib/images/logo-center.gif'
			        ),
			        '2'      => array(
			            'alt'   => '2 Column Left', 
			            'img'   => get_stylesheet_directory_uri().'/lib/images/logo-left.gif'
			        ),
			    ),
			    'default' => '1'
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Logo, Favicon', 'shtheme' ),
        'id'               => 'general-logo-favicon',
        'subsection'       => true,
        // 'desc'             => __( 'For full documentation on this field, visit: ', 'shtheme' ),
        'fields'           => array(
            array(
                'id'       => 'opt_settings_logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Logo', 'shtheme' ),
                'compiler' => 'true',
                //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                // 'desc'     => __( 'Basic media uploader with disabled URL input field.', 'shtheme' ),
                // 'subtitle' => __( 'Upload any media using the WordPress native uploader', 'shtheme' ),
                'default'  => array( 'url' => 'http://s.wordpress.org/style/images/codeispoetry.png' ),
            ),

            array(
                'id'       => 'opt_settings_favicon',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Favicon', 'shtheme' ),
                'compiler' => 'true',
            ),
        )
    ) );

    // -> Header
    // Redux::setSection( $opt_name, array(
    //     'title'            => __( 'Header', 'shtheme' ),
    //     'id'               => 'header',
    //     'icon'             => 'el el-website',
    // ) );

    // -> Footer
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Footer', 'shtheme' ),
        'id'               => 'footer',
        'icon'             => 'el el-website',
        'fields'           => array(
            array(
                'id'        => 'opt-number-footer',
                'type'      => 'slider',
                'title'     => __('Nhập số cột chân trang', 'shtheme'),
                'default'   => 1,
                'min'       => 1,
                'step'      => 1,
                'max'       => 4,
                'display_value' => 'text'
            ),
        )
    ) );

    // -> Homepage Settings Fields
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Trang chủ', 'shtheme' ),
        'id'               => 'homepage',
        'icon'             => 'el el-home'
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Tin tức', 'shtheme' ),
        'id'               => 'homepage-news',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'opt-multi-select-category',
                'type'     => 'select',
                'multi'    => true,
                'title'    => __( 'Chọn danh mục', 'shtheme' ),
                'data' 	   => 'terms',
				'args' 	   => array(
				    'taxonomies' => array( 'category' ),
				    'hide_empty' => false,
				),
            ),
            array(
			    'id' 		=> 'opt-number-new',
			    'type' 		=> 'slider',
			    'title' 	=> __('Nhập số lượng bài viết', 'shtheme'),
			    'default' 	=> 3,
			    'min' 		=> 0,
			    'step' 		=> 1,
			    'max' 		=> 50,
			    'display_value' => 'text'
			),
			array(
			    'id' 		=> 'opt-number-column',
			    'type' 		=> 'slider',
			    'title' 	=> __('Nhập số cột', 'shtheme'),
			    'default' 	=> 3,
			    'min' 		=> 1,
			    'step' 		=> 1,
			    'max' 		=> 6,
			    'display_value' => 'text'
			),
        )
    ) );

    if ( class_exists( 'WooCommerce' ) ) {
    	Redux::setSection( $opt_name, array(
	        'title'            => __( 'Sản phẩm', 'shtheme' ),
	        'id'               => 'homepage-product',
	        'subsection'       => true,
	        'fields'           => array(
	            array(
	                'id'       => 'opt-multi-select-product-cat',
	                'type'     => 'select',
	                'multi'    => true,
	                'title'    => __( 'Chọn danh mục sản phẩm', 'shtheme' ),
	                'data' => 'terms',
					'args' => array(
					    'taxonomies' => array( 'product_cat' ),
					    'hide_empty' => false,
					),
	            ),
	            array(
				    'id' 		=> 'opt-number-product',
				    'type' 		=> 'slider',
				    'title' 	=> __('Nhập số lượng sản phẩm', 'shtheme'),
				    'default' 	=> 3,
				    'min' 		=> 0,
				    'step' 		=> 1,
				    'max' 		=> 50,
				    'display_value' => 'text'
				),
				array(
				    'id' 		=> 'opt-number-product-column',
				    'type' 		=> 'slider',
				    'title' 	=> __('Nhập số cột', 'shtheme'),
				    'default' 	=> 3,
				    'min' 		=> 1,
				    'step' 		=> 1,
				    'max' 		=> 6,
				    'display_value' => 'text'
				),
	        )
	    ) );

    }




    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'shtheme' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'shtheme' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

