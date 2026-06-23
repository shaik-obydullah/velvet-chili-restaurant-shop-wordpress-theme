<?php
/**
 * Template Name: About Page
 * Uses 'obirc_about_page' CPT (single post) for dynamic content.
 * Falls back to static HTML when plugin inactive or data missing.
 */

get_header();

// -------------------------------------------------------------
// Static fallback HTML (your original about section)
// -------------------------------------------------------------
function obirc_static_about_page() {
    ?>
<section class="about-page" id="about">
    <div class="about-page__container">
        <div class="about-page__header text-center">
            <span class="about-page__kicker"><?php esc_html_e( 'Our Story', 'obydullah-restaurant' ); ?></span>
            <h2 class="about-page__title">
                <?php esc_html_e( 'The Heart of Obydullah Restaurant', 'obydullah-restaurant' ); ?></h2>
        </div>
        <div class="about-page__grid">
            <div class="about-page__text">
                <h3 class="about-page__subtitle">
                    <?php esc_html_e( 'Meet Chef Elena Vasquez', 'obydullah-restaurant' ); ?></h3>
                <p class="about-page__body">
                    <?php esc_html_e( 'With over twenty‑five years of experience, Chef Elena has honed her craft in the bustling markets of Oaxaca and the refined kitchens of Europe. Her passion lies in transforming humble chili peppers into complex, soul‑warming dishes that surprise and delight. Every plate she creates tells a story of fire, patience, and a deep respect for ingredients.', 'obydullah-restaurant' ); ?>
                </p>
                <h3 class="about-page__subtitle"><?php esc_html_e( 'Our Philosophy', 'obydullah-restaurant' ); ?></h3>
                <p class="about-page__body">
                    <?php esc_html_e( 'At Obydullah Restaurant, we believe that great food is about balance – heat and sweetness, tradition and innovation, comfort and elegance. We source our chilies from small family farms, slow‑cook our meats for hours, and treat every guest like family. Dining here is not just a meal; it’s a journey through the rich tapestry of chili culture.', 'obydullah-restaurant' ); ?>
                </p>
            </div>
            <div class="about-page__slider">
                <div class="event-slider" id="eventSlider" aria-roledescription="carousel"
                    aria-label="Restaurant events">
                    <div class="event-slider__slides" id="eventSlides">
                        <div class="event-slider__slide event-slider__slide--active" role="group"
                            aria-roledescription="slide" aria-label="1 of 3">
                            <div class="event-slider__bg"
                                style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-1.jpg' ); ?>');">
                            </div>
                            <div class="event-slider__overlay"></div>
                            <div class="event-slider__content">
                                <h3 class="event-slider__title">
                                    <?php esc_html_e( 'Private Dining', 'obydullah-restaurant' ); ?></h3>
                                <p class="event-slider__subtitle">
                                    <?php esc_html_e( 'Intimate celebrations in our candlelit cellar', 'obydullah-restaurant' ); ?>
                                </p>
                            </div>
                        </div>
                        <div class="event-slider__slide" role="group" aria-roledescription="slide" aria-label="2 of 3">
                            <div class="event-slider__bg"
                                style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-2.jpg' ); ?>');">
                            </div>
                            <div class="event-slider__overlay"></div>
                            <div class="event-slider__content">
                                <h3 class="event-slider__title">
                                    <?php esc_html_e( 'Wine Pairing Nights', 'obydullah-restaurant' ); ?></h3>
                                <p class="event-slider__subtitle">
                                    <?php esc_html_e( 'Every Thursday with our sommelier', 'obydullah-restaurant' ); ?>
                                </p>
                            </div>
                        </div>
                        <div class="event-slider__slide" role="group" aria-roledescription="slide" aria-label="3 of 3">
                            <div class="event-slider__bg"
                                style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-3.jpg' ); ?>');">
                            </div>
                            <div class="event-slider__overlay"></div>
                            <div class="event-slider__content">
                                <h3 class="event-slider__title">
                                    <?php esc_html_e( 'Chili Masterclass', 'obydullah-restaurant' ); ?></h3>
                                <p class="event-slider__subtitle">
                                    <?php esc_html_e( 'Learn the art of smoke & spice', 'obydullah-restaurant' ); ?></p>
                            </div>
                        </div>
                    </div>
                    <button class="event-slider__arrow event-slider__arrow--left" id="eventPrev"
                        aria-label="Previous slide"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="event-slider__arrow event-slider__arrow--right" id="eventNext"
                        aria-label="Next slide"><i class="fa-solid fa-chevron-right"></i></button>
                    <div class="event-slider__dots" id="eventDots" aria-hidden="true">
                        <button class="event-slider__dot event-slider__dot--active" data-slide="0"></button>
                        <button class="event-slider__dot" data-slide="1"></button>
                        <button class="event-slider__dot" data-slide="2"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}

// If plugin not active → static fallback
if ( ! defined( 'OBIRC_VERSION' ) ) {
    obirc_static_about_page();
    get_footer();
    return;
}

// -------------------------------------------------------------
// 1. Get About Page data (from obirc_about_page CPT)
// -------------------------------------------------------------
$about_posts = get_posts( array(
    'post_type'      => 'obirc_about_page',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
) );

if ( empty( $about_posts ) ) {
    obirc_static_about_page();
    get_footer();
    return;
}

$about_id = $about_posts[0]->ID;
$kicker   = get_post_meta( $about_id, 'about_kicker', true );
$title    = get_post_meta( $about_id, 'about_title', true );
$chef     = get_post_meta( $about_id, 'about_chef_story', true );
$phil     = get_post_meta( $about_id, 'about_philosophy', true );
$slides   = get_post_meta( $about_id, 'about_slides', true );

// If any required field is empty → static fallback
if ( empty( $kicker ) || empty( $title ) || empty( $chef ) || empty( $phil ) || empty( $slides ) ) {
    obirc_static_about_page();
    get_footer();
    return;
}
?>

<section class="about-page" id="about">
    <div class="about-page__container">
        <div class="about-page__header text-center">
            <span class="about-page__kicker"><?php echo esc_html( $kicker ); ?></span>
            <h2 class="about-page__title"><?php echo esc_html( $title ); ?></h2>
        </div>

        <div class="about-page__grid">
            <!-- Left column: text (dynamic) -->
            <div class="about-page__text">
                <h3 class="about-page__subtitle">
                    <?php esc_html_e( 'Meet Chef Elena Vasquez', 'obydullah-restaurant' ); ?></h3>
                <p class="about-page__body"><?php echo nl2br( esc_html( $chef ) ); ?></p>

                <h3 class="about-page__subtitle"><?php esc_html_e( 'Our Philosophy', 'obydullah-restaurant' ); ?></h3>
                <p class="about-page__body"><?php echo nl2br( esc_html( $phil ) ); ?></p>
            </div>

            <!-- Right column: slider (dynamic) -->
            <div class="about-page__slider">
                <div class="event-slider" id="eventSlider" aria-roledescription="carousel"
                    aria-label="Restaurant events">
                    <div class="event-slider__slides" id="eventSlides">
                        <?php $i = 0; foreach ( $slides as $slide ) : ?>
                        <div class="event-slider__slide <?php echo $i === 0 ? 'event-slider__slide--active' : ''; ?>"
                            role="group" aria-roledescription="slide"
                            aria-label="<?php echo esc_attr( ( $i + 1 ) . ' of ' . count( $slides ) ); ?>">
                            <div class="event-slider__bg"
                                style="background-image: url('<?php echo esc_url( $slide['image'] ); ?>');"></div>
                            <div class="event-slider__overlay"></div>
                            <div class="event-slider__content">
                                <h3 class="event-slider__title"><?php echo esc_html( $slide['title'] ); ?></h3>
                                <p class="event-slider__subtitle"><?php echo esc_html( $slide['subtitle'] ); ?></p>
                            </div>
                        </div>
                        <?php $i++; endforeach; ?>
                    </div>

                    <button class="event-slider__arrow event-slider__arrow--left" id="eventPrev"
                        aria-label="Previous slide"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="event-slider__arrow event-slider__arrow--right" id="eventNext"
                        aria-label="Next slide"><i class="fa-solid fa-chevron-right"></i></button>

                    <div class="event-slider__dots" id="eventDots" aria-hidden="true">
                        <?php for ( $j = 0; $j < count( $slides ); $j++ ) : ?>
                        <button class="event-slider__dot <?php echo $j === 0 ? 'event-slider__dot--active' : ''; ?>"
                            data-slide="<?php echo esc_attr( $j ); ?>"></button>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>