<?php

/**
 * Create a Custom Post Type 
 * Post Name : KP Entry
 * Fields: 
 *      - Title
 *      - Excerpt (Description)
 *      - Attachment Link (Custom Field)
 *      - Attachment Type (Custom Field)
 *      - Author
 */
function ncs4_knowledgeportal_register_post_type() {
    register_post_type('kp_entry',
        array(
            'labels'      => array(
                'name'          => __('KP Entries', 'ncs4'),
                'singular_name' => __('KP Entry', 'ncs4'),
                'add_new' => __( 'New Entry' , 'ncs4' ),
                'add_new_item' => __( 'Add New Entry' , 'ncs4' ),
                'edit_item' => __( 'Edit Entry' , 'ncs4' ),
                'new_item' => __( 'New Entry' , 'ncs4' ),
                'view_item' => __( 'View Entry' , 'ncs4' ),
                'search_items' => __( 'Search Entries' , 'ncs4' ),
                'not_found' =>  __( 'No Entries Found' , 'ncs4' ),
                'not_found_in_trash' => __( 'No Entries found in Trash' , 'ncs4' ),
            ),
                'description' => "Custom Post Type created for entries in the Knowledge Portal",
                'public'      => true,
                'show_ui'     => true,
                'has_archive' => true,
                'show_in_rest'=> true,
                'show_in_menu'=> true,
                'can_export'  => true,
                'hierarchical'=> false,
                'publicly_queryable' => true,
                'menu_icon'   => 'dashicons-welcome-learn-more',
                'supports'    => array(
                    'title',
                    'author',
                    'editor',
                    'excerpt',
                    'custom-fields',
                ),
                'taxonomies'  => array(
                    'ncs4_knowledgeportal_folders',
                    'post_tag',
                ),
        )
    );
}

/**
 * Create a Custom Taxonomy For KP Entry, Didn't use the inbuilt Category taxonomy to avoid conflict
 * Taxonomy Name : Folders (ncs4_knowledgeportal_folders)
 */
function ncs4_knowledgeportal_register_taxonomy() {    
      
    $labels = array(
        'name' => __( 'Folders' , 'ncs4' ),
        'singular_name' => __( 'Folder', 'ncs4' ),
        'search_items' => __( 'Search Folders' , 'ncs4' ),
        'all_items' => __( 'All Folders' , 'ncs4' ),
        'edit_item' => __( 'Edit Folder' , 'ncs4' ),
        'update_item' => __( 'Update Folders' , 'ncs4' ),
        'add_new_item' => __( 'Add New Folder' , 'ncs4' ),
        'new_item_name' => __( 'New Folder Name' , 'ncs4' ),
        'menu_name' => __( 'Folders' , 'ncs4' ),
    );
      
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'rewrite' => array( 'slug' => 'folders' ),
        'show_admin_column' => true,
        'show_in_rest' => true
  
    );
      
    register_taxonomy( 'ncs4_knowledgeportal_folders', array( 'kp_entry' ), $args);
      
}


?>