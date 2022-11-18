<?php 

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

