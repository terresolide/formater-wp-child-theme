<?php
/**
 * Manage svg files
 * @author epointal
 */
// svg count in post/page
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
		$class = "";
		if(isset( $attachment['align'])){
			switch( $attachment['align']){
				case 'left':
				case 'right':
					$class = 'class="fm-' . $attachment['align'].'"';
					break;
			}
		}
		$filter = '[formater-svg src="' . $attachment['url'] .'" ' . $class.' ][/formater-svg]';
		return apply_filters('svg_override_send_to_editor',  $filter , $html, $id, $attachment);
	}else{
		return $html;
	}
}
/** 
 * Best practice wordpress is to register script and style
 * Not to include direct tag script or style 
 * But it's heavy to load a js or css files for only one function 
 * Then I give up this method
 */
// register svg script
// add_action( 'wp_enqueue_scripts', 'formater_register_svg_script' );
//
// function formater_register_svg_script(){
//     wp_register_script('formater_svg', get_stylesheet_directory_uri() .'/js/manage-svg.js', Array(), null, true);
//}
function formater_svg_script(){
	return '<script type="text/javascript">function formater_switch_svg( node, value ){
	    		if( value ){
	    			var classname = "fm-right";
	    			var float = "right";
	    		}else{
	    			var classname = "fm-left";
	    			var float = "left";
	    		}
	    		console.log(node.parentNode);
	    		node.parentNode.style.float = float;
	    		if(node.parentNode.className.indexOf( classname )>=0){
	    			node.parentNode.className = node.parentNode.className.replace(classname, "");
	    		}else{
	    			node.parentNode.className = node.parentNode.className + " " + classname;
	    		}
	    	}</script>';
}

function formater_svg_style(){

	$style = '<style>div.formater-svg svg{width:100%; height:auto;}
div.formater-svg.fm-left{
	width:50%;
	float:left;
	transition: width .3s ease-in-out;
	}
div.formater-svg.fm-right{
    width:50%;
    float:right;
    transition: width .3s ease-in-out;
    }
div.formater-svg{width:100%;position:relative;height:auto;transition: width .3s ease-in-out;}
div.fm-enlarge::before{
	font-family: "FontAwesome";
    content:"\f066";
}
div.formater-svg.fm-right > div.fm-enlarge::before,
div.formater-svg.fm-left > div.fm-enlarge::before{
	font-family: "FontAwesome";
	content:"\f065";
}
div.formater-svg div.fm-enlarge{
	padding:3px;
	position:absolute; 
	top:2px;
    right:5px;
    z-index:2;
    background-color: rgba(0,0,0,.2);
    background-image: linear-gradient(hsla(0,0%,100%,.1),hsla(0,0%,100%,0));
    border-color: rgba(0,0,0,.35) rgba(0,0,0,.4) rgba(0,0,0,.45);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.1), inset 0 0 1px rgba(0,0,0,.2), 0 1px 0 hsla(0,0%,100%,.05);
    transition-property: background-color,border-color,box-shadow;
    transition-duration: 10ms;
    transition-timing-function: linear;
    border-radius:2px;
    cursor:pointer;}
@media screen and (max-width: 640px){
  div.formater-svg.fm-left,
  div.formater-svg.fm-right{
	  width:100%;
  }
  div.formater-svg div.fm-enlarge{
	  display:none;
  }
}</style>';
	return $style;
}
// include content  for svg file
add_shortcode("formater-svg", "include_file_svg");

function include_file_svg( $attrs, $html='' ){
	global $_formater_svg_count;

	$upload_info = wp_upload_dir();
	$upload_dir = $upload_info['basedir'];
	$upload_url = $upload_info['baseurl'];
   
	$url = $attrs["src"];
	// load by path instead url
	$path = realpath(str_replace($upload_url, $upload_dir, $url));
	//$svg = file_get_contents($url);
	if(!file_exists( $path )){
		return "";
	}
	$doc = new DOMDocument();
	$doc->load( $path );
	$svgs = $doc->getElementsByTagName('svg');
	$content ='';

	if( $svgs->length == 0){
		return "";
	}else{
	    if($_formater_svg_count == 0 ){
	    	/**
	    	 * Is not wordpress best practice to include tag script in html
	    	 * but it's heavy to load a script file for only one little function
	    	 * see before
	    	 */
	    	$content .= formater_svg_style();
	    	// wp_enqueue_script('formater_svg');
	    	$content .= formater_svg_script();
	    }
	    $_formater_svg_count++;
	    if( isset( $attrs['class'] ) ){
	        $value = $attrs['class'] == 'fm-right'? 1 : 0;
	        $content .= '<div class="formater-svg '.$attrs['class'].'"  >';
            $content .= '<div class="fm-enlarge fa" onclick="formater_switch_svg( this, '.$value.')"></div>';
	       
	    }else{
	        $content = '<div class="formater-svg">';
	    }
	    $svg = $svgs->item(0);
	    $svg->setAttribute('preserveAspectRatio','xMinYMin meet');
	    $content .= $doc->saveHTML($svg).'</div>';
	    return $content;
	}
	
}
