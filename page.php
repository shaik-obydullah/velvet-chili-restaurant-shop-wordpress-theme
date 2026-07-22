<?php get_header(); ?>

<main class="site-main page-default">

    <div class="page-default__container">

        <div class="page-default__content-area">

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <article id="page-<?php the_ID(); ?>" <?php post_class('page-default__article'); ?>>

                <header class="page-default__header">
                    <h1 class="page-default__title"><?php the_title(); ?></h1>
                </header>

                <div class="page-default__content">

                    <?php the_content(); ?>

                    <?php
                    wp_link_pages([
                        'before' => '<div class="page-links">',
                        'after'  => '</div>',
                    ]);
                    ?>

                </div>

            </article>

            <?php endwhile; else : ?>

            <p class="page-default__empty">
                <?php esc_html_e('No content found.', 'velvet-chili-restaurant-shop'); ?>
            </p>

            <?php endif; ?>

        </div>

        <aside class="page-default__sidebar">

            <?php if ( is_active_sidebar('sidebar-1') ) : ?>
            <?php dynamic_sidebar('sidebar-1'); ?>
            <?php endif; ?>

        </aside>

    </div>

</main>

<?php get_footer(); ?>