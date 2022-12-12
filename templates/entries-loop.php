<?php 
//get all terms in the Folder taxonomy
$terms = get_terms( array(
    'taxonomy' => 'ncs4_knowledgeportal_folders',
    'hide_empty' => false
) );

//loop through each term
foreach ( $terms as $term ) {
    //display term name as button
    echo '<button class="folder-button" data-slug="' . $term->slug . '">' . $term->name . '</button>';

    //get all posts in the term
    $args = array(
        'post_type'     => 'kp_entry',
        'post_status'   => 'publish',
        'post_per_page' => 50,
        'orderby'       =>'meta_value',
        'meta_key'      => array('_attachment_link','_attachment_type', '_posted_date'),
        'order'         =>'ASC'
    );
    $posts = new WP_Query($args);

    //loop through each post and display title and excerpt
    if ( $posts->have_posts() ) {
        echo '<div class="folder-posts" id="' . $term->slug . '">';
        while ( $posts->have_posts() ) {
            $posts->the_post();
            get_the_title();
            the_excerpt();
        }
        echo '</div>';
    }

    //reset post data
    wp_reset_postdata();
}

//jquery to hide/show posts based on clicked button
?>
<script>
jQuery(document).ready(function($){
    //show posts when button is clicked
    $('.folder-button').click(function(){
        var slug = $(this).data('slug');
        $('.folder-posts').hide();
        $('#' + slug).show();
    });
});
</script>