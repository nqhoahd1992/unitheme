<?php
/**
 *
 * @author Quang Hoa
 *
 * @link 
 *
 * @package Uni_Theme
 */

function uni_create_menu_mobile(){
    ?>
    <nav id="mobilenav">
        <div class="mobilenav__inner">
            <div class="toplg">
                <h3><?php _e( 'MENU', 'shtheme' )?></h3>
            </div>
            <?php 
            if ( has_nav_menu( 'menu-1' ) ) {
                wp_nav_menu( array(
                    'theme_location'    => 'menu-1', 
                    'menu_id'           => 'menu-main', 
                    'menu_class'        => 'mobile-menu',
                ) );
            }
            ?>
            <a class="menu_close"></a>
        </div>
    </nav>
    <?php
}
add_action( 'before_header','uni_create_menu_mobile' );

function create_overlay_body(){
    echo '<div class="panel-overlay"></div>';
}
add_action( 'after_footer','create_overlay_body' );