<?php

require_once plugin_dir_path(__FILE__) . '/entries.php';

function ncs4_knowledgeportal_entires() {
    global $post;
    $args = array(
        'post_type'     => 'kp_entry',
        'post_status'   => 'publish',
        'post_per_page' => 50,
        'orderby'       =>'meta_value',
        'meta_key'      => array('_attachment_link','_attachment_type', '_posted_date'),
        'order'         =>'ASC'
    );
    $query = new WP_Query($args);

    $content = '<ul style="list-style:none;">';
    if($query->have_posts()):
		while($query->have_posts()): 
            $query->the_post();

            $title =  get_the_title();
            $author = get_the_author();
            $excerpt = get_the_excerpt();
            $content_this = get_the_content();
            $attachment_type = get_post_meta($post->ID, '_attachment_type', true);
            $attachment_link = get_post_meta($post->ID, '_attachment_link', true);

            $posted_date = get_post_meta($post->ID, '_posted_date', true) ? get_post_meta($post->ID, '_posted_date', true) : get_the_date(__('Y-m-d'));

            // display event
            $content .= knowledgeportal_entry_markup($title, $author, $excerpt, $content_this, $attachment_type, $attachment_link, $posted_date);
        
        endwhile;
    endif;
    $content .= '</ul>';

    return $content;
}
?>