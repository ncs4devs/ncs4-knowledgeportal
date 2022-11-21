<?php

require_once plugin_dir_path(__FILE__) . '/model-entries.php';

/**
 * Filters through the posts, ordres them in accoriding to the folders and 
 * adds them to a new associative array with folder name as key.
 * "main" key has all the available posts
 * 
 * @return arrray filetered array of all the available entries. 
 */
function ncs4_get_knowledgeportal_entires() {
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
    
    $categories = get_categories(array('taxonomy'=> 'ncs4_knowledgeportal_folders'));
    $categories_and_post_array = [];
    $ncs4_knowledgeportal_debounce = true;

    foreach ($categories as $category) {
        $all_the_available_posts = [];
        $current_category_array = [];
        if($query->have_posts()):
            while($query->have_posts()): 
                $query->the_post();
                
                $title =  get_the_title();
                $author = get_the_author();
                $excerpt = get_the_excerpt();
                $content = (get_the_content()=="") ? "ncs4-knowledgeportal-message-no-content-provided" : get_the_content();
                $attachment_type = get_post_meta($post->ID, '_attachment_type', true);
                $attachment_link = get_post_meta($post->ID, '_attachment_link', true);
                $posted_date = get_post_meta($post->ID, '_posted_date', true) ? get_post_meta($post->ID, '_posted_date', true) : get_the_date(__('Y-m-d'));

                $post_object = new KPEntry($title, $author, $excerpt, $content, $attachment_type, $attachment_link, $posted_date);
                if ( ncs4_knowledgeportal_check_for_cateogry_in_array($category->name, get_the_terms($post, 'ncs4_knowledgeportal_folders')) ) {
                    array_push($current_category_array, $post_object);
                }
                if ($ncs4_knowledgeportal_debounce) {
                    array_push($all_the_available_posts, $post_object);
                }
            endwhile;
        endif;
        if ($ncs4_knowledgeportal_debounce) {
            $categories_and_post_array['main'] = $all_the_available_posts;
            $ncs4_knowledgeportal_debounce = false;
        }
        $categories_and_post_array[$category->name] = $current_category_array;
    }

    return $categories_and_post_array;
}

/**
 * Helper function to check if a given category name is in the given array of categories
 * Checks the name. so objects passed in the array should have a name property
 * 
 * @return boolean true if exists, false if doesn't 
 */
function ncs4_knowledgeportal_check_for_cateogry_in_array($category_to_check, $array_to_check_in) {
    foreach($array_to_check_in as $loop_category) {
        if ($loop_category->name == $category_to_check) {
            return true;
        }
    }
    return false;
}

?>