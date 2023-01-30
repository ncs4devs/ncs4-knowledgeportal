
<?php
// get the current user's data
$current_user = wp_get_current_user();
wp_enqueue_style( 'custom-post-style', plugin_dir_url( __FILE__ ) . '/css/index.css' );

if (isset($_POST['submit']) && isset($_POST['form_submission_nonce']) && wp_verify_nonce($_POST['form_submission_nonce'], 'form_submission')) {
    // process the form submission
    // create the post data
    $post_data = array(
        'post_title'    => sanitize_text_field($_POST['title']),
        'post_excerpt'  => sanitize_text_field($_POST['excerpt']),
        'post_author'   => $current_user->ID,
        'post_status'   => 'pending', // set the post status to pending
        'post_type'     => 'kp_entry',
        'post_content'  => sanitize_textarea_field($_POST['content']),
    );

    // insert the post into the database
    $post_id = wp_insert_post($post_data);

    // check if the post was inserted successfully
    if ($post_id) {
        if (isset($_FILES['_attachment_file']) && !empty($_FILES['_attachment_file']['name'])) {
            // check if the file meets the requirements (e.g. file type, size)
            $file = $_FILES['_attachment_file'];
            $file_type = wp_check_filetype($file['name']);
            $allowed_file_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'mp4', 'm4a', 'mp3', 'ogg', 'wav');
        
            if (in_array($file_type['ext'], $allowed_file_types) && $file['size'] <= 10485760) {
                // the file is valid, so you can proceed with uploading it
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                $attachment_id = media_handle_upload('_attachment_file', $post_id);
                if (is_wp_error($attachment_id)) {
                    // there was an error uploading the file
                    // you can handle the error here
                } else {
                    // the file was uploaded successfully
                    // you can use the $attachment_id to get the attachment URL, etc.
                    update_post_meta($post_id, '_attachment_link', wp_get_attachment_url($attachment_id));
                    switch ($file_type['ext']) {
                        case 'pdf':
                            update_post_meta($post_id, '_attachment_type', 'PDF');
                            break;
                        case 'jpeg':
                        case 'jpg':
                        case 'png':
                            update_post_meta($post_id, '_attachment_type', 'Image');
                            break;
                        case 'doc':
                        case 'docx':
                        case 'ppt':
                        case 'pptx':
                        case 'xls':
                        case 'xlsx':
                            update_post_meta($post_id, '_attachment_type', 'Document');
                            break;
                        case 'mp4':
                        case 'wmv':
                        case 'mkv':
                        case 'flv':
                            update_post_meta($post_id, '_attachment_type', 'Video');
                            break;
                        default:
                            update_post_meta($post_id, '_attachment_type', 'Other');
                            break;
                    }
                }
            } else {
                // the file is invalid
                // you can handle the error here
            }
        } elseif(isset($_POST['_attachment_link']) && !empty($_POST['_attachment_link'])) {
            update_post_meta($post_id, '_attachmentlink', $_POST['_attachment_link']);
        } else {
        // neither file nor link were provided
        // you can handle the error here
        }
        
        // if you want to check the file after upload
        $attachment_url = get_post_meta($post_id, '_attachment_link', true);
        if(empty($attachment_url)) {
        // handle the error here
        }
        
        // check if there was an error with the file submission
        if (isset($error_message)) {
            // show the error message
            echo '<p>' . $error_message . '</p>';
        } else {
            // add the attachment type as a custom field
        
            // add the current date as a custom field
        $date_format = 'Y-m-d'; // this is the same format as in the meta box
        $current_date = date( $date_format );
        update_post_meta($post_id, '_posted_date', $current_date);

        // send an email to the specified email address
        $to = array('l65.fread@gmail.com');
        $subject = 'NCS4 Connect : New Knowledge Portal Submission';
        $review_link = get_edit_post_link( $post_id );
        $message = 'A new submission has been made on the knowledge portal by '.$current_user->display_name.' and is pending your review. Click the following link to review and publish it: '. $review_link;
        wp_mail( $to, $subject, $message );

        // redirect to a different page
        $redirect_url = home_url('/connect/knowledge'); // change this to the URL of the page you want to redirect to
        wp_safe_redirect($redirect_url);}
    }
} else {
    // form submission is invalid
}
?>

<!-- display the form -->
<form method="post" action="" enctype="multipart/form-data">
    <?php wp_nonce_field( 'form_submission', 'form_submission_nonce' ); ?>
    <!-- title field -->
    <p>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
    </p>
    <!-- excerpt field -->
    <p>
        <label for="excerpt">Excerpt:</label>
        <input type="text" name="excerpt" id="excerpt" required>
    </p>

    <p>
        <!-- attachment field -->
        
        You may submit an attachment (up to 10mb) or a link. <br>
        <label for="_attachment_file">Attachment:</label>
        <input type="file" id="_attachment_file" name="_attachment_file">
        <!-- attachment link field -->
        <label for="_attachment_link">Link:</label>
        <input type="text" name="_attachment_link" id="_attachment_link" placeholder="Link to the File">
        
        <span id="file_size_error" style="display:none;color:red;">File can't be more than 10MB. You can submit a link instead.</span>
    </p>    

    <!-- content field -->
    <p>
    <label for="content">Content:</label>
    <textarea name="content" id="content" rows="10" cols="50"></textarea>
</p>

<!-- submit button -->
<p>
        Please note: All submissions to the Knowledge Portal are reviewed and approved by NCS⁴.</p>
<p>
        <input type="submit" name="submit" id="submit" value="Submit" class="kp-submission-submit-button">
    </p>
</form>
