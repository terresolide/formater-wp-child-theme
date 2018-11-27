<?php
/**
 * Manage svg files
 * use vuejs webcomponent formater-pdf-viewer-vjs
 * @see https://github.com/terresolide/formater-pdf-viewer-vjs
 * @author epointal
 */
if (! defined ( 'ABSPATH' ))
    exit ();
 
$_formater_pdf_count = 0;

/**
 * Add pdf as a supported upload type to Media Gallery
 */
add_filter ( 'upload_mimes', 'pdf_upload_mimes' );
function pdf_upload_mimes($existing_mimes = array()) {
    if (! isset ( $existing_mimes ['pdf'] )) {
        $existing_mimes ['pdf'] = ' 	application/pdf';
    }
    return $existing_mimes;
}

/**
 * filter for gpx in media gallery
 */
add_filter ( 'post_mime_types', 'pdf_post_mime_types' );
function pdf_post_mime_types($post_mime_types) {
    $post_mime_types ['application/pdf'] = array (
            'PDF',
            'Manage pdfs',
            'PDF <span class="count">(%s)</span>' 
    );
    return $post_mime_types;
}
/**
 * Register script webcomponent formater-pdf-viewer
 */


    // use last tag version
    $_formater_pdf_viewer_version = '0.1.7';
    $_formater_pdf_plugin_url = "https://api.poleterresolide.fr/webcomponents/formater-pdf-viewer-vjs_";
    $_formater_pdf_plugin_url .= $_formater_pdf_viewer_version . ".js";

add_action ( 'wp_enqueue_scripts', 'formater_register_pdf_script' );
function formater_register_pdf_script() {
    global $_formater_pdf_plugin_url;
    wp_register_script ( 'pdf_vjs', $_formater_pdf_plugin_url, Array (), null, true );
}

/**
 * embed-pdf shortcode instead link when insert pdf in post
 */
add_filter ( 'media_send_to_editor', 'pdf_media_send_to_editor', 21, 3 );
function pdf_media_send_to_editor($html, $id, $attachment) {
    if (isset ( $attachment ['url'] ) && preg_match ( "/\.pdf$/i", $attachment ['url'] )) {
        $title = $attachment ['post_title'];
        $rotate = ' rotate=0';
        if (isset ( $attachment ['rotate'] )) {
            $rotate = ' rotate=' . intVal ( $attachment ['rotate'] );
        }
        
        $filter = '[embed-pdf src=' . $attachment ['url'] . $rotate . ' ]' . $title . '[/embed-pdf]';
        // foreach($attachment as $key=>$value){
        // $filter .= $key.' ='.$value.'<br />';
        // }
        return apply_filters ( 'pdf_override_send_to_editor', $filter, $html, $id, $attachment );
    } else {
        return $html;
    }
}

/**
 * Add shortcode to write webcomponent <formater-pdf-viewer> instead [embed-pdf]
 */
add_shortcode ( "embed-pdf", "embed_pdf" );
function embed_pdf($attrs, $html = '') {
    global $_formater_pdf_count;
    $url = $attrs ["src"];
    // var_dump($attrs);
    
    if ($_formater_pdf_count == 0) {
        // load script webcomponent formater-pdf-viewer-vjs
        // only for the first component formater-pdf-viewer
        wp_enqueue_script ( 'pdf_vjs' );
        $_formater_pdf_count ++;
    }
    
    $lang = substr ( get_locale (), 0, 2 );
    $rotate = isset ( $attrs ["rotate"] ) ? intVal ( $attrs ["rotate"] ) : 0;
    return '<div style="clear:both;"></div>
<formater-pdf-viewer src="' . $url . '" fa="true" lang="' . $lang . '" rotate="' . $rotate . '" ></formater-pdf-viewer>
<p style="text-align: center"><i class="fa fa-file-pdf-o" style="color:red;"></i> <a href="' . $url . '">' . $html . '</a></p>';
    
    // / @todo when formater-pdf-viewer integration pk
    // return '<formater-pdf-viewer src="' .$url. '"></formater-pdf-viewer>';
}	
