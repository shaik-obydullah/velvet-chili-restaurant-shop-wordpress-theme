<?php
/**
 * Footer Section – fully dynamic from footer_settings CPT
 */

// -------------------------------------------------------------
// 1. Define static fallback (if plugin inactive or no data)
// -------------------------------------------------------------
function vcrs_footer_fallback() {
    ?>
<footer class="site-footer" id="siteFooter">
    <div class="site-footer__container">
        <div class="site-footer__grid">
            <!-- Column 1: About -->
            <div class="site-footer__col site-footer__col--about">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo">
                    <span class="site-footer__logo-icon"><i class="fa-solid fa-pepper-hot"></i></span>
                    <span class="site-footer__logo-text">Obydullah<span
                            class="site-footer__logo-accent">Restaurant</span></span>
                </a>
                <p class="site-footer__desc">A modern dining experience built around the soul of the chili pepper.
                    Slow‑cooked, bold, and unforgettable.</p>
                <div class="site-footer__social">
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
            </div>
            <!-- Column 2: Quick Links -->
            <div class="site-footer__col site-footer__col--links">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Quick Links', 'velvet-chili-restaurant-shop' ); ?>
                </h4>
                <ul class="site-footer__links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#menu">Our Menu</a></li>
                    <li><a href="#book">Book A Table</a></li>
                    <li><a href="#testimonials">Reviews</a></li>
                </ul>
            </div>
            <!-- Column 3: Contact -->
            <div class="site-footer__col site-footer__col--contact">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Contact', 'velvet-chili-restaurant-shop' ); ?></h4>
                <ul class="site-footer__contact">
                    <li><i class="fa-solid fa-location-dot"></i><span>427 Spice Avenue,<br />Gastronomy District, NY
                            10012</span></li>
                    <li><i class="fa-solid fa-phone"></i><a href="tel:+15551234567">(555) 123-4567</a></li>
                    <li><i class="fa-regular fa-envelope"></i><a
                            href="mailto:hello@obydullahrestaurant.com">hello@obydullahrestaurant.com</a></li>
                </ul>
            </div>
        </div>
        <!-- Copyright -->
        <div class="site-footer__bottom">
            <div class="site-footer__copyright">
                <p>&copy; <?php echo date( 'Y' ); ?> Obydullah Restaurant Theme — Where Warmth Meets Flavor. All rights
                    reserved.</p>
            </div>
        </div>
    </div>
</footer>
<?php
}

// -------------------------------------------------------------
// 2. Check if plugin is active
// -------------------------------------------------------------
if ( ! defined( 'OBIRSC_VERSION' ) ) {
    vcrs_footer_fallback();
    return;
}

// -------------------------------------------------------------
// 3. Get Footer Settings from CPT
// -------------------------------------------------------------
$footer_posts = get_posts( array(
    'post_type'      => 'obirsc_footer',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
) );

if ( empty( $footer_posts ) ) {
    vcrs_footer_fallback();
    return;
}

$footer_id = $footer_posts[0]->ID;

// Retrieve meta fields (all with correct prefix 'obirsc_footer_')
$logo_text   = get_post_meta( $footer_id, 'obirsc_footer_logo_text', true );
$logo_accent = get_post_meta( $footer_id, 'obirsc_footer_logo_accent', true );
$tagline     = get_post_meta( $footer_id, 'obirsc_footer_tagline', true );
$social      = get_post_meta( $footer_id, 'obirsc_footer_social', true );
$links       = get_post_meta( $footer_id, 'obirsc_footer_links', true );
$address     = get_post_meta( $footer_id, 'obirsc_footer_address', true );
$phone       = get_post_meta( $footer_id, 'obirsc_footer_phone', true );
$email       = get_post_meta( $footer_id, 'obirsc_footer_email', true );
$copyright   = get_post_meta( $footer_id, 'obirsc_footer_copyright', true );

// Fallback values (if empty, use the static fallback defaults)
$logo_text   = $logo_text ?: 'Obydullah';
$logo_accent = $logo_accent ?: 'Restaurant';
$tagline     = $tagline ?: 'A modern dining experience built around the soul of the chili pepper. Slow‑cooked, bold, and unforgettable.';
$copyright   = $copyright ?: '&copy; ' . date('Y') . ' Obydullah Restaurant Theme — Where Warmth Meets Flavor. All rights reserved.';
$social      = is_array( $social ) ? $social : array();
$links       = is_array( $links ) ? $links : array();
?>

<footer class="site-footer" id="siteFooter">
    <div class="site-footer__container">
        <div class="site-footer__grid">
            <!-- Column 1: About & Social -->
            <div class="site-footer__col site-footer__col--about">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo">
                    <span class="site-footer__logo-icon"><i class="fa-solid fa-pepper-hot"></i></span>
                    <span class="site-footer__logo-text">
                        <?php echo esc_html( $logo_text ); ?>
                        <span class="site-footer__logo-accent"><?php echo esc_html( $logo_accent ); ?></span>
                    </span>
                </a>
                <p class="site-footer__desc"><?php echo esc_html( $tagline ); ?></p>
                <div class="site-footer__social">
                    <?php if ( ! empty( $social['instagram'] ) ) : ?>
                    <a href="<?php echo esc_url( $social['instagram'] ); ?>" aria-label="Instagram" target="_blank"><i
                            class="fa-brands fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ( ! empty( $social['facebook'] ) ) : ?>
                    <a href="<?php echo esc_url( $social['facebook'] ); ?>" aria-label="Facebook" target="_blank"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if ( ! empty( $social['x'] ) ) : ?>
                    <a href="<?php echo esc_url( $social['x'] ); ?>" aria-label="X" target="_blank"><i
                            class="fa-brands fa-x-twitter"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="site-footer__col site-footer__col--links">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Quick Links', 'velvet-chili-restaurant-shop' ); ?>
                </h4>
                <?php if ( ! empty( $links ) ) : ?>
                <ul class="site-footer__links">
                    <?php foreach ( $links as $link ) : ?>
                    <li><a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['text'] ); ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>

            <!-- Column 3: Contact -->
            <div class="site-footer__col site-footer__col--contact">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Contact', 'velvet-chili-restaurant-shop' ); ?></h4>
                <ul class="site-footer__contact">
                    <?php if ( ! empty( $address ) ) : ?>
                    <li><i
                            class="fa-solid fa-location-dot"></i><span><?php echo nl2br( esc_html( $address ) ); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if ( ! empty( $phone ) ) : ?>
                    <li><i class="fa-solid fa-phone"></i><a
                            href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                    <?php endif; ?>
                    <?php if ( ! empty( $email ) ) : ?>
                    <li><i class="fa-regular fa-envelope"></i><a
                            href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Copyright row -->
        <div class="site-footer__bottom">
            <div class="site-footer__copyright"><?php echo wp_kses_post( $copyright ); ?></div>
        </div>
    </div>
</footer>

<?php
// No need for wp_reset_postdata() as we used get_posts()
// wp_footer() should be called outside this file, normally in footer.php
?>