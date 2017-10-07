
<?php
/** 
 * ForM@Ter child theme of aeris-wordpress-theme
 * @author epointal
 */


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
 	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

if(!is_admin()  ){
	//bug with media manager in backend
	add_action( 'pre_get_posts', 'wpdf_mod_status', 1 );
}

//add private page in query for authenticated user
function wpdf_mod_status( $query ) {
	if(current_user_can('read_private_posts') ){
		
		if($query->get('post_status') == "publish" ||
				(is_array($query->get('post_status')) && in_array( 'publish', $query->get('post_status')))){
			$query->set('post_status', array('publish', 'private'));
		}
	}
}

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

/**
 * Manage private/publish in widget custom menu
 *
 */

require_once get_stylesheet_directory(). '/widget/Formater_Nav_Menu_Widget.php';
function formater_init_menu_widget() {
	register_widget('Formater_Nav_Menu_Widget');
}
add_action('widgets_init', 'formater_init_menu_widget');
