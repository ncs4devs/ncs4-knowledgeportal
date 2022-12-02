<?php

require_once plugin_dir_path(__FILE__) . '/entries.php';
require_once plugin_dir_path(__FILE__) . '../includes/kp-getposts-by-folders.php';

function ncs4_knowledgeportal_entires() {
    $posts_available = ncs4_get_knowledgeportal_entires();
    $content = '<ul style="list-style:none;">';

    foreach ($posts_available as $folder_name => $post_array) {

        $content .= '<li>'.$folder_name.'</li>';
        $content .= "=======================";
        foreach ($post_array as $entry_kp) {
            // display event
            $content .=  knowledgeportal_entry_markup($entry_kp->title, $entry_kp->author, $entry_kp->excerpt, $entry_kp->content, $entry_kp->attachment_type, $entry_kp->attachment_link, $entry_kp->posted_date);
        }
    }

    $content .= '</ul>';
    return $content;
}


?>