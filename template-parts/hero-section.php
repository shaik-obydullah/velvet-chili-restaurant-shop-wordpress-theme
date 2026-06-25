<?php
/**
 * Hero Section (Plugin-aware)
 * Displays dynamic Hero Slides if plugin active & CPT has posts.
 * Otherwise shows a static fallback.
 */

$fallback_image = get_template_directory_uri() . '/assets/images/hero.jpg';

// Check if plugin is active and CPT exists
$has_plugin = defined( 'OBIRC_VERSION' );
$has_cpt    = post_type_exists( 'obirc_hero_slide' );

// Only run query if plugin and CPT are available
if ( $has_plugin && $has_cpt ) {
    $args = [
        'post_type'      => 'obirc_hero_slide',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    ];
    $query = new WP_Query( $args );
    $has_slides = $query->have_posts();
} else {
    $has_slides = false;
}

if ( $has_plugin && $has_cpt && $has_slides ) :
?>

<section class="slider" id="featuredSlider" aria-roledescription="carousel" aria-label="Featured dishes">

    <div class="slider__slides" id="sliderSlides">

        <?php
        $total = $query->post_count;
        $i = 0;
        while ( $query->have_posts() ) : $query->the_post();
            $image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            if ( ! $image ) {
                $image = $fallback_image;
            }
            $active_class = ( $i === 0 ) ? 'slider__slide--active' : '';
        ?>
        <div class="slider__slide <?php echo esc_attr( $active_class ); ?>" role="group" aria-roledescription="slide"
            aria-label="<?php echo esc_attr( ( $i + 1 ) . ' of ' . $total ); ?>">

            <div class="slider__bg" style="background-image: url('<?php echo esc_url( $image ); ?>');"></div>
            <div class="slider__overlay"></div>
            <div class="slider__content">
                <h2 class="slider__title"><?php echo esc_html( get_the_title() ); ?></h2>
                <p class="slider__subtitle">
                    <?php
                        $subtitle = get_post_meta( get_the_ID(), '_vcrc_subtitle', true );
                        echo esc_html( $subtitle );
                    ?>
                </p>
            </div>
        </div>
        <?php $i++; endwhile; ?>
    </div>

    <!-- Arrows -->
    <button class="slider__arrow slider__arrow--left" id="sliderPrev" aria-label="Previous slide">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="slider__arrow slider__arrow--right" id="sliderNext" aria-label="Next slide">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <!-- Dots -->
    <div class="slider__dots" id="sliderDots" aria-hidden="true">
        <?php for ( $d = 0; $d < $total; $d++ ) : ?>
        <button class="slider__dot <?php echo ( $d === 0 ) ? 'slider__dot--active' : ''; ?>"
            data-slide="<?php echo esc_attr( $d ); ?>"
            aria-label="<?php echo esc_attr( sprintf( 'Go to slide %d', $d + 1 ) ); ?>"></button>
        <?php endfor; ?>
    </div>

</section>

<?php
    wp_reset_postdata();
else :
?>

<section class="slider-static" aria-label="Signature dish">
    <div class="slider-static__bg" style="background-image: url('<?php echo esc_url( $fallback_image ); ?>');"></div>
    <div class="slider-static__overlay"></div>
    <div class="slider-static__content">
        <h2 class="slider-static__title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h2>
        <p class="slider-static__subtitle"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
    </div>
</section>

<?php endif; ?>