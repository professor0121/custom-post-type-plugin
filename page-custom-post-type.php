<?php
/**
 * Template Name: Custom Post Type Page
 */

get_header(); ?>

<div class="custom-post-type-page">
    <h1>All My Custom Posts</h1>
    
    <?php
    // Query for custom post type
    $args = array(
        'post_type' => 'abhi',  // Replace with your custom post type name
        'posts_per_page' => 10,  // Adjust number of posts to show
    );
    $custom_post_query = new WP_Query($args);
    
    if ($custom_post_query->have_posts()) :
        while ($custom_post_query->have_posts()) : $custom_post_query->the_post();
            ?>
            <div class="custom-post-item">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php the_excerpt(); ?></p>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No posts found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
