
<?php
/**
** ForM@Ter child theme of aeris-wordpress-theme
**/


$_formater_count = 0;


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
 

}
add_action( 'wp_enqueue_scripts', 'formater_register_script' );
function formater_register_script(){
	wp_register_script('pdf_vjs', "http://localhost/poleter/dist/formater-pdf-viewer-vjs_0.1.0.js", Array(), null, true);
}

// Add svg and xml as a supported upload type to Media Gallery
add_filter( 'upload_mimes', 'svg_upload_mimes');
// Manage svg file : filter for svg in media gallery...

// Take over xml and svg type in media gallery
function svg_upload_mimes($existing_mimes = array())
{
	if(!isset($existing_mimes['xml'])){
		$existing_mimes['xml'] = 'application/xml';
	}
	if(!isset($existing_mimes['svg'])){
		$existing_mimes['svg'] = 'image/svg+xml';
	}
	return $existing_mimes;
}

// Embed  svg shortcode instead of link
add_filter( 'media_send_to_editor',  'svg_media_send_to_editor' , 20, 3 );

function svg_media_send_to_editor($html, $id, $attachment)
{
	
	if (isset($attachment['url']) && preg_match( "/\.svg$/i", $attachment['url'])) {
		
		$filter = '[include-svg src=' . $attachment['url'] .' ]';
		return apply_filters('svg_override_send_to_editor',  $filter , $html, $id, $attachment);
	}else{
		return $html;
	}
}

// Embed  pdf shortcode instead of link
add_filter( 'media_send_to_editor',  'pdf_media_send_to_editor' , 21, 3 );

function pdf_media_send_to_editor($html, $id, $attachment)
{
	
	if (isset($attachment['url']) && preg_match( "/\.pdf$/i", $attachment['url'])) {
		
		$filter = '[embed-pdf src=' . $attachment['url'] .' ]';
		return apply_filters('pdf_override_send_to_editor',  $filter , $html, $id, $attachment);
	}else{
		return $html;
	}
}

// include content  for svg file
add_shortcode("include-svg", "include_file_svg");

function include_file_svg( $attrs, $html='' ){
	$url = $attrs["src"];
	$svg = file_get_contents($url);
	if( $svg === false){
		return "";
	}else{
		return $svg;
	}
	
	
}

add_shortcode("embed-pdf", "embed_pdf");

function embed_pdf( $attrs, $html='' ){
	global $_formater_count;
	if( $_formater_count == 0){
		wp_enqueue_script('pdf_vjs');
		$_formater_count++;
	}
	$url = $attrs["src"];
	echo '<formater-pdf-viewer src="' .$url. '"></formater-pdf-viewer>';
	
}