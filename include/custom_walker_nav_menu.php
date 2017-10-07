<?php 
/**
* @author epointal
*
*/
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    // $output correspond à la variable retournée en fin de walker
    // $item correspond aux information sur l'item en cours
    // $depth correspond à la profondeur du niveau
    // $arg aux variable supplémentaires

  	//on n'ajoute rien si l'utilisateur n'est pas autorisée à lire les pages privées 
  	//et que le lien est vers une page privée
 
  	if(!current_user_can('read_private_posts') && (in_array( "private", $item->classes) || get_post_status($item->object_id)=== "private")){
  		return;
  	}
  	parent::start_el($output, $item, $depth , $args , $id);
  
  }
  public function end_el( &$output, $item, $depth = 0, $args = array()  ) {
    // $output correspond à la variable retournée en fin de walker
    // $depth correspond à la profondeur du niveau
    // $arg aux variable supplémentaires
 
    //on n'ajoute rien si l'utilisateur n'est pas autorisée à lire les pages privées
  	//et que le lien est vers une page privée
  	if(!current_user_can('read_private_posts') && (get_post_status($item->object_id)=== "private")){
  		return;
  	}
  	
  	parent::end_el($output, $item, $depth , $args );
  }
}