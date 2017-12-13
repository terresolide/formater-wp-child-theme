<?php
/** 
 * ForM@Ter child theme of aeris-wordpress-theme
 * @author epointal
 */



// if ( ! defined( 'ABSPATH' ) ) exit;
add_action ( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style ( 'parent-style', get_template_directory_uri () . '/style.css' );
}

// Add little script in bottom for formater-bottom-up
/*load the js file into the footer*/
function add_script_button_up()
{
   
        ?>
     <script type="text/javascript">
       function formater_button_up(){
    	   var formater_button_up = document.querySelector(".formater-button-up");
           if( formater_button_up){
               if( window.scrollY == 0 ){
               	   formater_button_up.style.opacity = 0;
               }else{
                   formater_button_up.style.opacity = 0.6;
               }
           }
       }
        window.addEventListener("scroll", function(){
        	    formater_button_up();
        });
        formater_button_up();
     </script>
  <?php

 }
  add_action( 'wp_footer', 'add_script_button_up' );

// delete class "tag" to body tag trouble with theme aeris style.css line 1076 ".tag a "directive
add_filter ( 'body_class', function ($classes) {
    $key = array_search ( 'tag', $classes );
    if ($key >= 0) {
        unset ( $classes [$key] );
        $classes [] = 'fm-tag';
    }
    return $classes;
} );

/**
 * Add search form to header menu
 * @param string $items The HTML list content for the menu items.
 * @param stdClass $args an object containing wp_nav_menu arguments
 * @return html|string
 */
function add_last_nav_item($items, $args) {
    // If this isn't the primary menu, do nothing
    if (! ($args->theme_location == 'header-menu'))
        return $items;
    
    return $items . '<li>' . get_search_form ( false ) . '</li>';
    // return $items;
}

add_filter ( 'wp_nav_menu_items', 'add_last_nav_item', 10, 2 );
/**
 * Manage pdf files
 */
if( !class_exists('Fm_pdf_manager')){
    require_once get_stylesheet_directory () . '/include/manage_pdf.php';
}

/**
 * Manage svg files
 */
if( !class_exists('Fm_svg_manager')){
    require_once get_stylesheet_directory () . '/include/manage_svg.php';
}
/**
 * Private in menu
 */
require_once get_stylesheet_directory () . '/include/private_item.php';


