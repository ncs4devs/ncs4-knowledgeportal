<?php
// template file to display posts categorized by ncs4_knowledgeportal_folders taxonomy

// get all terms in the ncs4_knowledgeportal_folders taxonomy
$terms = get_terms( array(
    'taxonomy' => 'ncs4_knowledgeportal_folders',
    'hide_empty' => true,
) );

// create a term for the main category with all the posts
$main_term = new stdClass();
$main_term->term_id = 0;
$main_term->name = 'Main';

// get all posts
$posts = get_posts( array(
    'post_type' => 'kp_entry',
) );


$templates = new KP_Template_Loader;
?>

<div class="kp-folder-columns">
    <div class="kp-folder-names">
        <!-- main category with all the posts -->
        <div class="kp-folder-name-button active" data-term="<?php echo esc_attr( $main_term->term_id ); ?>">
            <?php echo esc_html( $main_term->name ); ?> (<?php echo count( $posts ); ?>)
        </div>

        <!-- other categories -->
        <?php foreach ( $terms as $term ) : ?>
            <!-- get the posts in this term -->
            <?php
            $posts_current_taxonomy = get_posts( array(
                'post_type' => 'kp_entry',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'ncs4_knowledgeportal_folders',
                        'field' => 'term_id',
                        'terms' => $term->term_id,
                    ),
                ),
            ) );
            ?>

            <!-- display the term name as a div element that looks like a button -->
            <div class="kp-folder-name-button" data-term="<?php echo esc_attr( $term->term_id ); ?>">
                <?php echo esc_html( $term->name ); ?> (<?php echo count( $posts_current_taxonomy ); ?>)
            </div>
        <?php endforeach; ?>
    </div>



    <div class='kp-content-side'>
        <div class='kp-before-content'>
            <div class='kp-small-text'>
                Entries
            </div>
            <div class="kp-sort-dropdown kp-small-text">
                <label for="kp-sort-select">Sort by:</label>
                <select id="kp-sort-select">
                    <option value="date-asc">Date Created - Ascending</option>
                    <option value="date-desc">Date Created - Descending</option>
                    <option value="title-asc">Title - Ascending</option>
                    <option value="title-desc">Title - Descending</option>
                    <!-- Add other sorting options here -->
                </select>
            </div>
        </div>
    
        <div class="kp-folder-posts">   

            <div id='kp-folder-posts-date-asc'> 
                <!-- main category with all the posts -->
                <div class="kp-folder-section" data-term="<?php echo esc_attr( $main_term->term_id ); ?>">
                    <?php // get all posts
                        $posts = get_posts( array(
                            'post_type' => 'kp_entry',
                            'meta_key' => '_posted_date',
                            'orderby' => 'meta_value',
                            'order' => 'ASC',
                        ) );?>
                    <?php foreach ( $posts as $post ) : ?>
                        <?php 
                            $templates->get_template_part( 'single-entry' ); ?>
                    <?php endforeach; ?>
                </div>

                <!-- other categories -->
                <?php foreach ( $terms as $term ) : ?>
                    <!-- get the posts in this term -->
                    <?php
                    $posts = get_posts( array(
                        'post_type' => 'kp_entry',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'ncs4_knowledgeportal_folders',
                                'field' => 'term_id',
                                'terms' => $term->term_id,
                            ),
                        ),
                        'meta_key' => '_posted_date',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                    ) );
                    ?>

                    <div class="kp-folder-section" data-term="<?php echo esc_attr( $term->term_id ); ?>">
                        <?php foreach ( $posts as $post ) : ?>
                            <?php 
                                $templates->get_template_part( 'single-entry' ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div id='kp-folder-posts-date-desc'> 
                <!-- main category with all the posts -->
                <div class="kp-folder-section" data-term="<?php echo esc_attr( $main_term->term_id ); ?>">
                    <?php // get all posts
                        $posts = get_posts( array(
                            'post_type' => 'kp_entry',
                            'meta_key' => '_posted_date',
                            'orderby' => 'meta_value',
                            'order' => 'DESC',
                        ) );?>
                    <?php foreach ( $posts as $post ) : ?>
                        <?php 
                            $templates->get_template_part( 'single-entry' ); ?>
                    <?php endforeach; ?>
                </div>

                <!-- other categories -->
                <?php foreach ( $terms as $term ) : ?>
                    <!-- get the posts in this term -->
                    <?php
                    $posts = get_posts( array(
                        'post_type' => 'kp_entry',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'ncs4_knowledgeportal_folders',
                                'field' => 'term_id',
                                'terms' => $term->term_id,
                            ),
                        ),
                        'meta_key' => '_posted_date',
                        'orderby' => 'meta_value',
                        'order' => 'DESC',
                    ) );
                    ?>

                    <div class="kp-folder-section" data-term="<?php echo esc_attr( $term->term_id ); ?>">
                        <?php foreach ( $posts as $post ) : ?>
                            <?php 
                                $templates->get_template_part( 'single-entry' ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            
            <div id='kp-folder-posts-title-asc'> 
                <!-- main category with all the posts -->
                <div class="kp-folder-section" data-term="<?php echo esc_attr( $main_term->term_id ); ?>">
                    <?php // get all posts
                        $posts = get_posts( array(
                            'post_type' => 'kp_entry',
                            'orderby' => 'title',
                            'order' => 'ASC',
                        ) );?>
                    <?php foreach ( $posts as $post ) : ?>
                        <?php 
                            $templates->get_template_part( 'single-entry' ); ?>
                    <?php endforeach; ?>
                </div>

                <!-- other categories -->
                <?php foreach ( $terms as $term ) : ?>
                    <!-- get the posts in this term -->
                    <?php
                    $posts = get_posts( array(
                        'post_type' => 'kp_entry',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'ncs4_knowledgeportal_folders',
                                'field' => 'term_id',
                                'terms' => $term->term_id,
                            ),
                        ),
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ) );
                    ?>

                    <div class="kp-folder-section" data-term="<?php echo esc_attr( $term->term_id ); ?>">
                        <?php foreach ( $posts as $post ) : ?>
                            <?php 
                                $templates->get_template_part( 'single-entry' ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div id='kp-folder-posts-title-desc'> 
                <!-- main category with all the posts -->
                <div class="kp-folder-section" data-term="<?php echo esc_attr( $main_term->term_id ); ?>">
                    <?php // get all posts
                        $posts = get_posts( array(
                            'post_type' => 'kp_entry',
                            'orderby' => 'title',
                            'order' => 'DESC',
                        ) );?>
                    <?php foreach ( $posts as $post ) : ?>
                        <?php 
                            $templates->get_template_part( 'single-entry' ); ?>
                    <?php endforeach; ?>
                </div>

                <!-- other categories -->
                <?php foreach ( $terms as $term ) : ?>
                    <!-- get the posts in this term -->
                    <?php
                    $posts = get_posts( array(
                        'post_type' => 'kp_entry',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'ncs4_knowledgeportal_folders',
                                'field' => 'term_id',
                                'terms' => $term->term_id,
                            ),
                        ),
                        'orderby' => 'title',
                        'order' => 'DESC',
                    ) );
                    ?>

                    <div class="kp-folder-section" data-term="<?php echo esc_attr( $term->term_id ); ?>">
                        <?php foreach ( $posts as $post ) : ?>
                            <?php 
                                $templates->get_template_part( 'single-entry' ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>


</div>

<hr style="border-top: 1.5px solid #ccc; margin:0;">