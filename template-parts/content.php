<?php
/**
 * Template part for displaying posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
    <div class="blog-card__image">
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( 'medium' ); ?>
        </a>
    </div>
    <?php endif; ?>

    <div class="blog-card__content">
        <header class="blog-card__header">
            <?php
            $categories = get_the_category();
            if ( $categories ) :
                ?>
            <span class="blog-card__category"><?php echo esc_html( $categories[0]->name ); ?></span>
            <?php endif; ?>
            <h2 class="blog-card__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="blog-card__meta">
                <span class="blog-card__date"><?php echo get_the_date(); ?></span>
            </div>
        </header>

        <div class="blog-card__excerpt">
            <?php the_excerpt(); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="blog-card__btn">
            <?php esc_html_e( 'Read More', 'velvet-chili-restaurant-shop' ); ?>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</article>
