<?php
/**
 * Manage svg files
 * @author epointal
 */

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
		
		$filter = '[include-svg src=' . $attachment['url'] .' ][/include-svg]';
		return apply_filters('svg_override_send_to_editor',  $filter , $html, $id, $attachment);
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
