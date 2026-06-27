<?php get_header(); ?>

<main class="site-main blog-index">
    <div class="container">

        <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part('template-parts/content', get_post_type()); ?>

        <?php endwhile; ?>

        <?php
            the_posts_pagination([
                'prev_text' => __('Previous', 'velvet-chili-restaurant-shop'),
                'next_text' => __('Next', 'velvet-chili-restaurant-shop'),
            ]);
            ?>

        <?php else : ?>

        <p><?php esc_html_e('No content found.', 'velvet-chili-restaurant-shop'); ?></p>

        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>