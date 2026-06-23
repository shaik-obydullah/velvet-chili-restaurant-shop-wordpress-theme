<?php get_header(); ?>

<main class="site-main blog-index">
    <div class="container">

        <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part('template-parts/content', get_post_type()); ?>

        <?php endwhile; ?>

        <?php
            the_posts_pagination([
                'prev_text' => __('Previous', 'obydullah-restaurant'),
                'next_text' => __('Next', 'obydullah-restaurant'),
            ]);
            ?>

        <?php else : ?>

        <p><?php esc_html_e('No content found.', 'obydullah-restaurant'); ?></p>

        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>