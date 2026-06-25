<?php
/**
 * Template Part: Testimonials Section
 * - Section title & background image from 'obirc_testi_area' CPT (single post)
 * - Carousel slides from 'obirc_testimonial' CPT
 * - Falls back to static HTML when no dynamic data available
 */

function obirc_default_testimonials_html() {
    ?>
<section class="testimonials-section" id="testimonials">
    <div class="testimonials-section__bg">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/testimonial.jpg' ); ?>" alt="">
    </div>
    <div class="testimonials-section__overlay"></div>
    <div class="testimonials-section__container">
        <div class="testimonials-section__row">
            <div class="testimonials-section__col">
                <div class="testimonials-box">
                    <div class="testimonials-box__icon">
                        <i class="fa-solid fa-quote-right"></i>
                    </div>
                    <h2 class="testimonials-box__title">
                        <?php esc_html_e( 'What Our Customers Say', 'obydullah-restaurant' ); ?></h2>
                    <div class="testimonial-carousel" id="testimonialCarousel">
                        <div class="testimonial-carousel__slides" id="testimonialSlides">
                            <!-- Slide 1 -->
                            <div class="testimonial-carousel__slide testimonial-carousel__slide--active">
                                <blockquote class="testimonial-carousel__quote">“The ancho ribeye was life‑changing.
                                    Perfect heat, incredible depth – I’ve never tasted anything like it. Obydullah
                                    Restaurant is a gem.”</blockquote>
                                <div class="testimonial-carousel__author"><span class="testimonial-carousel__name">James
                                        Delacroix</span><span class="testimonial-carousel__role">— Food Critic</span>
                                </div>
                            </div>
                            <div class="testimonial-carousel__slide">
                                <blockquote class="testimonial-carousel__quote">“From the smoky pasilla soup to the
                                    chocolate tart, every bite was a masterclass in balance. The atmosphere is as warm
                                    as the spices.”</blockquote>
                                <div class="testimonial-carousel__author"><span class="testimonial-carousel__name">Elena
                                        Rossi</span><span class="testimonial-carousel__role">— Regular Guest</span>
                                </div>
                            </div>
                            <div class="testimonial-carousel__slide">
                                <blockquote class="testimonial-carousel__quote">“Booked the private dining room for a
                                    birthday. The team went above and beyond – the short rib was melt‑in‑your‑mouth
                                    perfection.”</blockquote>
                                <div class="testimonial-carousel__author"><span
                                        class="testimonial-carousel__name">Marcus & Sofia Lee</span><span
                                        class="testimonial-carousel__role">— Celebrated a special occasion</span></div>
                            </div>
                            <div class="testimonial-carousel__slide">
                                <blockquote class="testimonial-carousel__quote">“The best chili‑based menu I’ve ever
                                    encountered. Sophisticated, surprising, and utterly comforting. We’ll be back every
                                    month.”</blockquote>
                                <div class="testimonial-carousel__author"><span
                                        class="testimonial-carousel__name">Claire Thompson</span><span
                                        class="testimonial-carousel__role">— Food Blogger</span></div>
                            </div>
                        </div>
                        <div class="testimonial-carousel__dots" id="testimonialDots">
                            <button class="testimonial-carousel__dot testimonial-carousel__dot--active"
                                data-slide="0"></button>
                            <button class="testimonial-carousel__dot" data-slide="1"></button>
                            <button class="testimonial-carousel__dot" data-slide="2"></button>
                            <button class="testimonial-carousel__dot" data-slide="3"></button>
                        </div>
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
    obirc_default_testimonials_html();
    return;
}

// 1. Get Testimonial Area (single post) for title & background image
$area_posts = get_posts( array(
    'post_type'      => 'obirc_testi_area',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
) );

if ( empty( $area_posts ) ) {
    obirc_default_testimonials_html();
    return;
}

$area_id    = $area_posts[0]->ID;
$area_title = get_the_title( $area_id );
$area_image = get_the_post_thumbnail_url( $area_id, 'full' );

// Fallback values if fields are empty
$area_title = $area_title ?: __( 'What Our Customers Say', 'obydullah-restaurant' );
$area_image = $area_image ?: get_template_directory_uri() . '/assets/images/testimonial.jpg';

// 2. Get individual testimonials (CPT: obirc_testimonial)
$testimonials = new WP_Query( array(
    'post_type'      => 'obirc_testimonial',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );

if ( ! $testimonials->have_posts() ) {
    obirc_default_testimonials_html();
    return;
}

// -------------------------------------------------------------
// Dynamic output: title & image from testimonial_area, carousel from testimonial CPT
// -------------------------------------------------------------
?>
<section class="testimonials-section" id="testimonials">
    <div class="testimonials-section__bg">
        <img src="<?php echo esc_url( $area_image ); ?>" alt="" aria-hidden="true" />
    </div>
    <div class="testimonials-section__overlay"></div>
    <div class="testimonials-section__container">
        <div class="testimonials-section__row">
            <div class="testimonials-section__col">
                <div class="testimonials-box">
                    <div class="testimonials-box__icon">
                        <i class="fa-solid fa-quote-right"></i>
                    </div>
                    <h2 class="testimonials-box__title"><?php echo esc_html( $area_title ); ?></h2>
                    <div class="testimonial-carousel" id="testimonialCarousel">
                        <div class="testimonial-carousel__slides" id="testimonialSlides">
                            <?php $i = 0; while ( $testimonials->have_posts() ) : $testimonials->the_post();
                                $quote = get_post_meta( get_the_ID(), 'obirc_testimonial_quote', true );
                                $role  = get_post_meta( get_the_ID(), 'obirc_testimonial_role', true );
                                $active_class = ( $i === 0 ) ? ' testimonial-carousel__slide--active' : '';
                            ?>
                            <div class="testimonial-carousel__slide<?php echo esc_attr( $active_class ); ?>">
                                <blockquote class="testimonial-carousel__quote"><?php echo esc_html( $quote ); ?>
                                </blockquote>
                                <div class="testimonial-carousel__author">
                                    <span class="testimonial-carousel__name"><?php the_title(); ?></span>
                                    <?php if ( $role ) : ?>
                                    <span class="testimonial-carousel__role">— <?php echo esc_html( $role ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php $i++; endwhile; wp_reset_postdata(); ?>
                        </div>
                        <div class="testimonial-carousel__dots" id="testimonialDots">
                            <?php for ( $j = 0; $j < $i; $j++ ) : ?>
                            <button
                                class="testimonial-carousel__dot <?php echo $j === 0 ? 'testimonial-carousel__dot--active' : ''; ?>"
                                data-slide="<?php echo esc_attr( $j ); ?>"></button>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>