
<?php
/**
** ForM@Ter child theme of aeris-wordpress-theme
**/





add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
 	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

if(!is_admin()  ){
	//bug with media manager in backend
	add_action( 'pre_get_posts', 'wpdf_mod_status', 1 );
}

//add private page in query for authenticated usergit
function wpdf_mod_status( $query ) {
	if(current_user_can('read_private_posts') ){
		
		if($query->get('post_status') == "publish" ||
				(is_array($query->get('post_status')) && in_array( 'publish', $query->get('post_status')))){
			$query->set('post_status', array('publish', 'private'));
		}
	}
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

