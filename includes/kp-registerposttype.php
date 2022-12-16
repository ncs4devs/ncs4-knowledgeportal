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

// add event date field to events post type
function ncs4_add_post_meta_boxes() {
    add_meta_box(
        "post_metadata_kp_attachment_type", 
        "Attachment Type", 
        "post_meta_box_knowledgeportal_attachmenttype", 
        "kp_entry", 
        "normal",
        "high" 
    );
    add_meta_box(
        "post_metadata_kp_attachment_link", 
        "Attachment Link", 
        "post_meta_box_knowledgeportal_attachmentlink", 
        "kp_entry", 
        "normal",
        "high" 
    );
    add_meta_box(
        "post_metadata_kp_posted_date", 
        "Posted Date", 
        "post_meta_box_knowledgeportal_posteddate", 
        "kp_entry", 
        "side", 
        "high"
    );
}

// save the data from meta boxes to the database
function ncs4_save_post_meta_boxes(){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    update_post_meta( $post->ID, "_attachment_link", sanitize_url( $_POST[ "_attachment_link" ] ) );
    update_post_meta( $post->ID, "_attachment_type", sanitize_text_field( $_POST[ "_attachment_type" ] ) );
    update_post_meta( $post->ID, "_posted_date", sanitize_text_field( $_POST[ "_posted_date" ] ) );
}


//callback function to render fields
function post_meta_box_knowledgeportal_attachmenttype(){
    global $post;
    $custom = get_post_custom( $post->ID );
    $attachment_type = $custom[ "_attachment_type" ][ 0 ];
    ?>
    <select name="_attachment_type">
        <option value="Link" <?php selected( $attachment_type, 'Link' ); ?>>Link</option>
        <option value="PDF" <?php selected( $attachment_type, 'PDF' ); ?>>PDF</option>
        <option value="Video" <?php selected( $attachment_type, 'Video' ); ?>>Video</option>
        <option value="Image" <?php selected( $attachment_type, 'Image' ); ?>>Image</option>
        <option value="Document" <?php selected( $attachment_type, 'Document' ); ?>>Document</option>
        <option value="Other" <?php selected( $attachment_type, 'Other' ); ?>>Other</option>
    </select>
    <?php
}

function post_meta_box_knowledgeportal_attachmentlink(){
    global $post;
    $custom = get_post_custom( $post->ID );
    $attachment_link = $custom[ "_attachment_link" ][ 0 ];
    ?>
    <input type="url" name="_attachment_link" value="<?php echo esc_url( $attachment_link ); ?>" placeholder="Attachment Link">
    <?php
}

function post_meta_box_knowledgeportal_posteddate(){
    global $post;
    $custom = get_post_custom( $post->ID );
    $posted_date = $custom[ "_posted_date" ][ 0 ];
    ?>
    <input type="date" name="_posted_date" value="<?php echo esc_attr( $posted_date ); ?>" placeholder="Posted Date">
    <?php
}


?>