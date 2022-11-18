<?php
 function knowledgeportal_entry_markup($post_title, $post_author, $post_excerpt, $post_content_this,$post_attachment_type, $post_attachment_link, $post_posted_date){
    $post_content ='';
    $post_content .= '<li>'.$post_title .'</li>'; 
    $post_content .= '<li> Posted by: '. $post_author .'</li>'; 
    $post_content .= '<li>'.$post_content_this.'</li>';
    $post_content .= '<li> <a href="'.$post_attachment_link.'">'.$post_attachment_type.'</a></li>';
    $post_content .= '<li>'.$post_posted_date.'</li>'; 
    $post_content .= '----------------------------------------------------------';
    return $post_content;
 }
?>