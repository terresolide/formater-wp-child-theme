<?php
/**
 *  @author epointal
 *  Manage private and public page in menu
 * Add private page in menu builder (appareance -> menu)
 * @see also inc/my-walker.php ( unset private page in menu when user can read private page)
 */

add_filter( 'nav_menu_meta_box_object', 'show_private_pages_menu_selection' );
/**
 * Add query argument for select privates pages to add to menu
 */
function show_private_pages_menu_selection( $args ){
	if( $args->name == 'page' ) {
		$args->_default_query['post_status'] = array('publish','private');
	}
	return $args;
}
/**
 * Custom primary menu ( display private page link only for authorized user)
 */
require get_stylesheet_directory() . '/include/custom_walker_nav_menu.php';

/**
 * add field epo_status in menu builder for page 
 * @todo
 */
// add custom menu fields to menu
//add_filter( 'wp_setup_nav_menu_item', 'epo_add_field_status'  );
function epo_add_field_status( $menu_item ) {
	
	$menu_item->epostatus = get_post_meta( $menu_item->ID, '_menu_item_epostatus', true );
	return $menu_item;
	
}
// update epo_status field in DB
//add_action( 'wp_update_nav_menu_item', 'epo_update_custom_nav_fields');
function epo_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
	// Check if element is properly sent
	if ( is_array( $_REQUEST['menu-item-epostatus']) ) {
		$subtitle_value = $_REQUEST['menu-item-epostatus'][$menu_item_db_id];
		update_post_meta( $menu_item_db_id, '_menu_item_epostatus', $subtitle_value );
	}
	/*foreach( $_POST as $key => $value){
	 echo $key. "<br />";
	 var_dump($value);
	 echo "<br />";
	 }
	 return;
	 // Check if element is properly sent
	 if ( is_array( $_REQUEST['menu-item-epostatus']) ) {
	 var_dump($_REQUEST['menu-item-epostatus'][$menu_id]);
	 $status_value= $_REQUEST['menu-item-epostatus'][$menu_id];
	 var_dump($menu_id);
	 
	 update_post_meta( $menu_id, '_menu_item_epostatus', $status_value );
	 }*/
	
}


// edit menu walker
//add_filter( 'wp_edit_nav_menu_walker', 'epo_edit_nav_menu_walker');

function epo_edit_nav_menu_walker(){
	include_once( get_template_directory() . '/inc/custom_walker_nav_menu_edit.php' );
	return 'Custom_Walker_Nav_Menu_Edit';
}

/*add_filter('nav_menu_css_class' , 'nav_menu_add_post_status_class' , 10 , 2);
 function nav_menu_add_post_status_class($classes, $item){
 $post_status = get_post_status($item->object_id);
 $item->visibility = $post_status;
 var_dump($post_status."<br />");
 $classes["visibility"] = $post_status;
 return $classes;
 }*/