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
        // add the attachment link as a custom field
        update_post_meta($post_id, '_attachment_link', sanitize_text_field($_POST['_attachment_link']));

        // add the attachment type as a custom field
        update_post_meta($post_id, '_attachment_type', sanitize_text_field($_POST['_attachment_type']));

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
        wp_safe_redirect($redirect_url);
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
        <input type="textarea" name="excerpt" id="excerpt" required>
    </p>

    <!-- attachment type dropdown -->
    <p>
        <label for="_attachment_type">Attachment Type:</label>
        <select name="_attachment_type" id="_attachment_type" required>
            <option value="">Select an attachment type</option>
            <option value="Link">Link</option>
            <option value="PDF">PDF</option>
            <option value="Video">Video</option>
            <option value="Image">Image</option>
            <option value="Document">Document</option>
            <option value="Other">Other</option>
        </select>
    </p>

   <!-- attachment link field -->
   <p>
        <label for="_attachment_link">Attachment Link:</label>
        <input type="text" name="_attachment_link" id="_attachment_link" required>
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
        <input type="submit" name="submit" value="Submit">
    </p>
</form>
