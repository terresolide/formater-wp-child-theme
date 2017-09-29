<?php
/**
 * Manage svg files
 * @author epointal
 */

$_formater_pdf_count = 0;

/** @todo integration formater-pdf-viewer-vjs webcomponent 
 * trouble with assets url

if(WP_DEBUG){
	$_formater_pdf_viewer_version = '0.1.1';
//$_formater_pdf_plugin_url = "http://localhost/dist/formater-pdf-viewer-vjs_".
			      //           $_formater_pdf_viewer_version.".js";
	$_formater_pdf_plugin_url = "https://rawgit.com/epointal/formater-pdf-viewer-vjs/master/dist/formater-pdf-viewer-vjs_".
		                 $_formater_pdf_viewer_version.".js";
}else{
	$_formater_pdf_viewer_version = '0.1.2';
	$_formater_pdf_plugin_url = "https://cdn.rawgit.com/epointal/formater-pdf-viewer-vjs/".$_formater_pdf_viewer_version;
	$_formater_pdf_plugin_url .= "/dist/formater-pdf-viewer-vjs_". $_formater_pdf_viewer_version.".js";
	
} */
// add_action( 'wp_enqueue_scripts', 'formater_register_script' );

function formater_register_script(){
	global $_formater_pdf_plugin_url;
	wp_register_script('pdf_vjs', $_formater_pdf_plugin_url, Array(), null, true);
	
}

// Embed  pdf shortcode instead of link
add_filter( 'media_send_to_editor',  'pdf_media_send_to_editor' , 21, 3 );

function pdf_media_send_to_editor($html, $id, $attachment)
{
	
	if (isset($attachment['url']) && preg_match( "/\.pdf$/i", $attachment['url'])) {
		$title = $attachment['post_title'];
		
		$filter = '[embed-pdf src=' . $attachment['url'] .' ]'. $title.'[/embed-pdf]';
		//foreach($attachment as $key=>$value){
		//	$filter .= $key.' ='.$value.'<br />';
		//}
		return apply_filters('pdf_override_send_to_editor',  $filter , $html, $id, $attachment);
	}else{
		return $html;
	}
}

add_shortcode("embed-pdf", "embed_pdf");

function embed_pdf( $attrs, $html='' ){
	global $_formater_pdf_count;
	$url = $attrs["src"];
	//var_dump($attrs);

	if( $_formater_pdf_count == 0){
		wp_enqueue_script('pdf_vjs');
		$_formater_pdf_count++;
	}

	return '<p style="text-align: center"><i class="fa fa-file-pdf-o" style="color:red;"></i> <a chref="'. $url.'">'.$html.'</a></p>';

	/// @todo when formater-pdf-viewer integration pk
	// return  '<formater-pdf-viewer src="' .$url. '"></formater-pdf-viewer>';
   
	
}	
