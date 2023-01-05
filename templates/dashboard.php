<?php


function ncs4_knowledgeportal_entires() {

	ob_start();
	$templates = new KP_Template_Loader; 
	$templates->get_template_part('knowledge-portal-main');
    return ob_get_clean();
}


?>