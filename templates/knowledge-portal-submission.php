<!-- template for a form that allows users to submit 'kp-entry' -->
<?php
// get the current user's data
$current_user = wp_get_current_user();

if (isset($_POST['submit']) && isset($_POST['form_submission_nonce']) && wp_verify_nonce($_POST['form_submission_nonce'], 'form_submission')) {
    // process the form submission
    // create the post data
    $post_data = array(
        'post_title'    => sanitize_text_field($_POST['title']),
        'post_excerpt'  => sanitize_text_field($_POST['excerpt']),
        'post_author'   => $current_user->ID,
        'post_status'   => 'pending', // set the post status to pending
        'post_type'     => 'kp_entry',
        'post_content'  => sanitize_text_field($_POST['content']),
    );

    // insert the post into the database
    $post_id = wp_insert_post($post_data);

    // check if the post was inserted successfully
    if ($post_id) {
        // check if the user submitted a link or an attachment file
        if (!empty($_FILES['_attachment_file']['name'])) {
            // handle the attachment file upload
            $uploaded_file = wp_handle_upload($_FILES['_attachment_file'], array('test_form' => false));
            if (isset($uploaded_file['file'])) {
                $attachment_link = $uploaded_file['url'];
                update_post_meta($post_id, '_attachment_link', 'hello I am here');
                $file_type = wp_check_filetype($uploaded_file['file']);
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
        } elseif ($_POST['_attachment_link'] !='') {
            // add the attachment link as a custom field
            update_post_meta($post_id, '_attachment_link', sanitize_text_field($_POST['_attachment_link']));
            update_post_meta($post_id, '_attachment_type', 'Link');
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
        $to = array('aayush.gautam@usm.edu', 'l65.fread@gmail.com');
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
<form method="post" action="">
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
        
        <label for="_attachment_file">Submit Attachment:</label>
        <input type="file" id="_attachment_file">
        <!-- attachment link field -->
        <label for="_attachment_link">Link to Attachment:</label>
        <input type="text" name="_attachment_link" id="_attachment_link" placeholder="Link Instead of File">
        
        <span id="file_size_error" style="display:none;color:red;">File can't be more than 10MB. You can submit a link instead.</span>
    </p>    

    <!-- content field -->
    <p>
        <label for="content">Content:</label>
        <?php
        $content = ''; // the initial content of the editor
        $editor_id = 'content'; // the unique ID of the editor
        $settings = array(
            'textarea_name' => 'content', // the name of the textarea that will be created
            'media_buttons' => false, // show the insert media button
            'tinymce' => true, // enable the rich text editor
            'quicktags' => true, // enable the quicktags (HTML tags) button
        );
        wp_editor( $content, $editor_id, $settings );
        ?>
    </p>

    <!-- submit button -->
    <p>
        <input type="submit" name="submit" id="submit" value="Submit">
    </p>
</form>
