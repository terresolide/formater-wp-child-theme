<?php
/**
 *  @author epointal
 *  Manage private and public page in menus and page
 *  Add private page in menu builder (appareance -> menu)
 *  @see also inc/my-walker.php ( unset private page in menu when user can read private page)
 */

 /** add private status in query for authenticated user */
 if(!is_admin()  ){
	//bug with media manager in backend
	add_action( 'pre_get_posts', 'fomater_add_private_status', 1 );
}


function fomater_add_private_status( $query ) {
	if(current_user_can('read_private_posts') ){
		
		if($query->get('post_status') == "publish" ||
				(is_array($query->get('post_status')) && in_array( 'publish', $query->get('post_status')))){
			$query->set('post_status', array('publish', 'private'));
		}
	}
}

/**
 * Add query argument for select privates pages/posts/events to add to menu
 */
add_filter( 'nav_menu_meta_box_object', 'show_private_pages_menu_selection' );

function show_private_pages_menu_selection( $args ){
	if( $args->name == 'page' || $args->name == 'post' || $args->name == 'tribe_events') {
		$args->_default_query['post_status'] = array('publish','private');
	}
	return $args;
}
/**
 * Custom primary menu ( display private page link only for authorized user)
 */
require_once get_stylesheet_directory() . '/include/custom_walker_nav_menu.php';

/**
 * Manage private/publish in widget custom menu
 *
 */

require_once get_stylesheet_directory(). '/widget/Formater_Nav_Menu_Widget.php';
function formater_init_menu_widget() {
	register_widget('Formater_Nav_Menu_Widget');
}
add_action('widgets_init', 'formater_init_menu_widget');
