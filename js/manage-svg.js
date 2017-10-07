/**
 * 
 */
function formater_switch_svg( node, value ){
    if( value ){
        var classname = "fm-right";
    }else{
        var classname = "fm-left"
    }
    console.log(node.parentNode);
    if(node.parentNode.className.indexOf( classname )>=0){
        node.parentNode.className = node.parentNode.className.replace(classname, "");
    }else{
        node.parentNode.className = node.parentNode.className + " " + classname;
    }
}