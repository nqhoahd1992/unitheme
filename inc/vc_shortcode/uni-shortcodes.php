<?php
define('UNI_SHORTCODES_ASSET', dirname(__FILE__) . '/assets/');
define('UNI_SHORTCODES_PATH', dirname(__FILE__) . '/shortcodes/');
define('UNI_SHORTCODES_LIB', dirname(__FILE__) . '/lib/');
define('UNI_SHORTCODES_TEMPLATES', dirname(__FILE__) . '/templates/');
define('UNI_SHORTCODES_WOO_PATH', dirname(__FILE__) . '/woo_shortcodes/');
define('UNI_SHORTCODES_WOO_TEMPLATES', dirname(__FILE__) . '/woo_templates/');

class UNIShortcodesClass {

    // private $shortcodes = array("uni_blog",'uni_blog_slider','uni_carousel_image','uni_infobox','uni_static_block');
    private $shortcodes = array("uni_blog",'uni_blog_slider','uni_carousel_image','uni_infobox');
	private $woo_shortcodes = array("uni_product","uni_product_slider");
    
    function __construct() {

        $this->addShortcodes();
        add_filter('the_content', array($this, 'formatShortcodes'));
        add_filter('widget_text', array($this, 'formatShortcodes'));
        add_action('wp_enqueue_scripts', array($this,'uni_enqueue_script'));

    }

    // Add shortcodes
    function addShortcodes() {
        require_once(UNI_SHORTCODES_LIB . 'functions.php');
        // require_once(UNI_SHORTCODES_LIB . 'wtb-post-type.php');
        foreach ($this->shortcodes as $shortcode) {
            require_once(UNI_SHORTCODES_PATH . $shortcode . '.php');
        }

        if ( class_exists( 'WooCommerce' ) ) {
            foreach ($this->woo_shortcodes as $woo_shortcode) {
                require_once(UNI_SHORTCODES_WOO_PATH . $woo_shortcode . '.php');
            }
        }
    }

    // Format shortcodes content
    function formatShortcodes($content) {
        $block = join("|", $this->shortcodes);
        // opening tag
        $content = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);
        // closing tag
        $content = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)/", "[/$2]", $content);

        return $content;
    }

    function uni_enqueue_script() {   
        wp_enqueue_style('wtb-core-style', UNI_DIR . '/inc/vc_shortcode/assets/css/uni_core.css');  
    }

}

// Finally initialize code
new UNIShortcodesClass();
