<?php
// template file to display custom post type

// enqueue the JavaScript file
wp_enqueue_script( 'custom-post-script', plugin_dir_url( __FILE__ ) . '/js/script.js' );
wp_enqueue_style( 'custom-post-style', plugin_dir_url( __FILE__ ) . '/css/index.css' );

// get the post object
global $post;

// check if the post exists
if ( $post ) : ?>
    <div class="kp-custom-post">  
        <hr style="border-top: 1.5px solid #ccc; margin:0;">
        <!-- post title -->
        <div class='blue'><?php echo esc_html( $post->post_title ); ?></div>

        <!-- post author -->
        <p>By: <?php the_author(); ?></p>

        <!-- hidden content, only visible when "Load More" button is clicked -->
        <div class="kp-hidden-excerpt" data-post-id="<?php echo $post->ID; ?>">
            <?php echo apply_filters( 'the_content', $post->post_excerpt ); ?>
        </div>

        <?php // get the attachment type and URL
        $attachment_type = get_post_meta( $post->ID, '_attachment_type', true );
        $attachment_url = get_post_meta( $post->ID, '_attachment_link', true );

        // attachment type to Dashicon mapping
        $attachment_type_map = array(
            'Link' => 'admin-links',
            'Video' => 'format-video',
            'PDF' => 'pdf',
            'Document' => 'media-document',
            'Image' => 'format-image',
            'Other' => 'plus',
        );

        // check if the attachment type and URL are set
        if ( ! empty( $attachment_type ) && ! empty( $attachment_url ) ) :
            // get the mapped Dashicon name for the attachment type
            $attachment_type_dashicon = isset( $attachment_type_map[$attachment_type] ) ? $attachment_type_map[$attachment_type] : 'media-default';
        // attachment type with Dashicon and link to attachment URL
        ?>

        <!-- hidden content, only visible when "Load More" button is clicked -->
        <div class="kp-hidden-content" data-post-id="<?php echo $post->ID; ?>">
            <?php echo apply_filters( 'the_content', $post->post_content ); ?>
        </div>

        <!-- "Load More" button, only visible if there is content -->
        <?php if ( ! empty( $post->post_content ) ) : ?>
            <div class="kp-load-more" data-post-id="<?php echo $post->ID; ?>">load more...</div>
        <?php endif; ?>

        <!-- attachment type with Dashicon and link to attachment URL -->
        <p>
            <a href="<?php echo esc_url( $attachment_url ); ?>">
                <span class="kp-dashicons dashicons dashicons-<?php echo esc_attr( $attachment_type_dashicon ); ?>"></span>
            </a>
        </p>
        <?php endif;?>

    </div>
<?php endif; ?>
