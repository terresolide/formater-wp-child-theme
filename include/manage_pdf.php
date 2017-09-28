<?php
/**
 * Manage svg files
 * @author epointal
 */

$_formater_pdf_count = 0;

add_action( 'wp_enqueue_scripts', 'formater_register_script' );

function formater_register_script(){
	wp_register_script('pdf_vjs', "https://cdn.rawgit.com/epointal/formater-pdf-viewer-vjs/26490fc7/dist/formater-pdf-viewer-vjs_0.1.1.js", Array(), null, true);
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

add_shortcode("embed-pdf", "embed_pdf");

function embed_pdf( $attrs, $html='' ){
	global $_formater_pdf_count;
	$url = $attrs["src"];
	
	if( $_formater_pdf_count == 0){
		wp_enqueue_script('pdf_vjs');
		$_formater_pdf_count++;
	}
	
	return  '<formater-pdf-viewer src="' .$url. '"></formater-pdf-viewer>';
	
}	