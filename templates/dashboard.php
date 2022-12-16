<?php


function ncs4_knowledgeportal_entires() {

	ob_start();
	$templates = new KP_Template_Loader;
	$templates->get_template_part( 'entries-loop' );
    return ob_get_clean();
}


?>