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
function ncs4_knowledgeportal_post_type() {
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
                    'Sports',
                    'Safety',
                    'Spectator',
                ),
        )
    );
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
        "post_metadata_kp_posted_date", // div id containing rendered fields
        "Posted Date", // section heading displayed as text
        "post_meta_box_knowledgeportal_posteddate", // callback function to render fields
        "kp_entry", // name of post type on which to render fields
        "side", // location on the screen
        "high" // placement priority
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
add_action( 'save_post', 'ncs4_save_post_meta_boxes' );


// callback function to render fields
function post_meta_box_knowledgeportal_attachmenttype(){
    global $post;
    $custom = get_post_custom( $post->ID );
    $advertisingCategory = $custom[ "_attachment_type" ][ 0 ];
    echo "<input type=\"text\" name=\"_attachment_type\" value=\"".$advertisingCategory."\" placeholder=\"Type of Attachment\">";
}

// callback function to render fields
function post_meta_box_knowledgeportal_attachmentlink(){
    global $post;
    $custom = get_post_custom( $post->ID );
    $advertisingCategory = $custom[ "_attachment_link" ][ 0 ];
    echo "<input type=\"url\" name=\"_attachment_link\" value=\"".$advertisingCategory."\" placeholder=\"Attachment Link\">";
}

// callback function to render fields
function post_meta_box_knowledgeportal_posteddate(){
    global $post;
    $custom = get_post_custom( $post->ID );
    $advertisingCategory = $custom[ "_posted_date" ][ 0 ];
    echo "<input type=\"date\" name=\"_posted_date\" value=\"".$advertisingCategory."\" placeholder=\"Posted Date\">";
}














?>

