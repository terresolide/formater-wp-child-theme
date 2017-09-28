
<?php
/**
** ForM@Ter child theme of aeris-wordpress-theme
**/





add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
 	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

/** 
 * Manage pdf files  
 */
require get_stylesheet_directory(). '/include/manage_pdf.php';

/**
 * Manage svg files
 */
require get_stylesheet_directory(). '/include/manage_svg.php';

/**
 * Private in menu
 */
require get_stylesheet_directory(). '/include/private_item.php';

