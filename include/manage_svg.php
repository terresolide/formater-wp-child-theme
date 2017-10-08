<?php
/**
 * Manage svg files
 * @author epointal
 */
$_formater_svg_count = 0;
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
		
		$filter = '[formater-svg src="' . $attachment['url'] .'" ][/formater-svg]';
		return apply_filters('svg_override_send_to_editor',  $filter , $html, $id, $attachment);
	}else{
		return $html;
	}
}

add_action( 'wp_enqueue_scripts', 'formater_register_svg_script' );

function formater_register_svg_script(){
    wp_register_script('formater_svg', get_stylesheet_directory_uri() .'/js/manage-svg.js', Array(), null, true);
}
// include content  for svg file
add_shortcode("formater-svg", "include_file_svg");

function include_file_svg( $attrs, $html='' ){
   global $_formater_svg_count;
	$url = $attrs["src"];
	//$svg = file_get_contents($url);
	$doc = new DOMDocument();
	$doc->load($url);
	$svg = $doc->getElementsByTagName('svg');
	$content ='';

	if( $svg->length == 0){
		return "";
	}else{
	    if($_formater_svg_count == 0 ){
	        wp_enqueue_script('formater_svg');
	    }
	    $_formater_svg_count++;
	    if( isset( $attrs['class'] ) ){
	        $value = $attrs['class'] == 'fm-right'? 1 : 0;
	        $content = '<div class="formater-svg '.$attrs['class'].'"  >';
            $content .= '<div class="fm-enlarge fa" onclick="formater_switch_svg( this, '.$value.')"></div>';
	       
	    }else{
	        $content = '<div class="formater-svg">';
	    }
	    $content .= $doc->saveHTML($svg->item(0)).'</div>';
	    return $content;
	}
	
}

//add_action( 'wp_enqueue_scripts', 'formater_register_svg_script' );

function formater_svg_add_script(){
    
    $data = 'var fm-left = 0;alert("coucou"); 
function formater_switch_svg(';
    wp_add_inline_script( 'custom-js', $data , 'before'); 
}