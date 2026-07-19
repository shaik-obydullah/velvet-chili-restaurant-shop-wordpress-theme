<?php get_header(); ?>

<main class="site-main page-default">

    <div class="page-default__container">

        <div class="page-default__content-area">

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('page-default__article'); ?>>

                <header class="page-default__header">
                    <h1 class="page-default__title"><?php the_title(); ?></h1>
                </header>

                <div class="page-default__content">

                    <?php the_content(); ?>

                    <?php
                    wp_link_pages([
                        'before' => '<div class="page-links">' . __('Pages:', 'velvet-chili-restaurant-shop'),
                        'after'  => '</div>',
                    ]);
                    ?>

                    <?php
                    $tags = get_the_tag_list('<div class="post-tags">Tags: ', ', ', '</div>');
                    if ($tags) {
                        echo wp_kses_post( $tags );
                    }
                    ?>

                </div>

                <nav class="post-navigation">
                    <?php the_post_navigation([
                        'prev_text' => '← %title',
                        'next_text' => '%title →',
                    ]); ?>
                </nav>

                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>

            </article>

            <?php endwhile; endif; ?>

        </div>

        <aside class="page-default__sidebar">

            <?php if ( is_active_sidebar('sidebar-1') ) : ?>
            <?php dynamic_sidebar('sidebar-1'); ?>
            <?php else : ?>
            <p><?php esc_html_e( 'No widgets added yet.', 'velvet-chili-restaurant-shop' ); ?></p>
            <?php endif; ?>

        </aside>

    </div>

</main>

<?php get_footer(); ?>