
<?php
/** 
 * ForM@Ter child theme of aeris-wordpress-theme
 * @author epointal
 */



add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
 	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}



//delete class "tag" to body tag trouble with theme aeris style.css line 1076 ".tag a "directive 
add_filter( 'body_class', function( $classes ) {
	$key = array_search('tag', $classes);
	if( $key >=0){
		unset( $classes[$key]);
		$classes[] = 'fm-tag';
	}
	return $classes;
} );


function add_last_nav_item($items, $args) {
    // If this isn't the primary menu, do nothing
   // var_dump($args->theme_location);
    if( !($args->theme_location == 'header-menu') )
        return $items;
    
   
        return $items . '<li>' . get_search_form( false ) . '</li>';
   // return $items;
}


add_filter( 'wp_nav_menu_items', 'add_last_nav_item', 10, 2 );
/** 
 * Manage pdf files  
 */
require_once get_stylesheet_directory(). '/include/manage_pdf.php';

/**
 * Manage svg files
 */
require_once get_stylesheet_directory(). '/include/manage_svg.php';

/**
 * Private in menu
 */
require_once get_stylesheet_directory(). '/include/private_item.php';


