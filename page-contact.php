<?php
/**
 * Template Name: Contact Page
 * Uses 'obirsc_contact_page' CPT for dynamic content.
 * Falls back to static HTML when plugin inactive or data missing.
 */

get_header();

// -------------------------------------------------------------
// 1. Helper: Get first CF7 shortcode (if CF7 active)
// -------------------------------------------------------------
if ( ! function_exists( 'vcrs_get_first_cf7_shortcode' ) ) {
function vcrs_get_first_cf7_shortcode() {
    if ( ! defined( 'WPCF7_VERSION' ) ) {
        return '';
    }
    $forms = get_posts( array(
        'post_type'      => 'wpcf7_contact_form',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ) );
    if ( empty( $forms ) ) {
        return '';
    }
    return '[contact-form-7 id="' . (int) $forms[0]->ID . '" title="' . esc_attr( $forms[0]->post_title ) . '"]';
}
} // endif function_exists

// -------------------------------------------------------------
// 2. Define static fallback data
// -------------------------------------------------------------
if ( ! function_exists( 'vcrs_static_contact_page' ) ) {
function vcrs_static_contact_page() {
    ?>
<section class="contact-page" id="contact">
    <div class="contact-page__container">
        <div class="contact-page__header text-center">
            <span
                class="contact-page__kicker"><?php esc_html_e( 'Get In Touch', 'velvet-chili-restaurant-shop' ); ?></span>
            <h2 class="contact-page__title"><?php esc_html_e( 'Contact Us', 'velvet-chili-restaurant-shop' ); ?></h2>
            <p class="contact-page__subtitle">
                <?php esc_html_e( 'We\'d love to hear from you. Reach out for reservations, private events, or just to say hello.', 'velvet-chili-restaurant-shop' ); ?>
            </p>
        </div>

        <div class="contact-page__grid">
            <div class="contact-page__form">
                <?php if ( defined( 'WPCF7_VERSION' ) ) : ?>
                <?php
                        $cf7_shortcode = vcrs_get_first_cf7_shortcode();
                        if ( ! empty( $cf7_shortcode ) ) {
                            echo do_shortcode( $cf7_shortcode );
                        } else {
                            ?>
                <div class="cf7-notice">
                    <p><strong><?php esc_html_e( 'No contact form found.', 'velvet-chili-restaurant-shop' ); ?></strong>
                    </p>
                    <p><?php esc_html_e( 'Please create a form in Contact Form 7 → Add New, then publish it.', 'velvet-chili-restaurant-shop' ); ?>
                    </p>
                </div>
                <?php } ?>
                <?php else : ?>
                <div class="cf7-notice">
                    <p><strong><?php esc_html_e( 'Contact Form 7 plugin is not active.', 'velvet-chili-restaurant-shop' ); ?></strong>
                    </p>
                    <p><?php esc_html_e( 'To use this contact form, please install and activate the free Contact Form 7 plugin from the WordPress plugin repository.', 'velvet-chili-restaurant-shop' ); ?>
                    </p>
                    <p><a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=contact+form+7&tab=search&type=term' ) ); ?>"
                            target="_blank"><?php esc_html_e( 'Install Contact Form 7 →', 'velvet-chili-restaurant-shop' ); ?></a>
                    </p>
                </div>
                <?php endif; ?>
            </div>

            <div class="contact-page__info">
                <div class="contact-info">
                    <h3 class="contact-info__title">
                        <?php esc_html_e( 'The Velvet Chili Restaurant', 'velvet-chili-restaurant-shop' ); ?></h3>
                    <ul class="contact-info__list">
                        <li><i class="fa-solid fa-location-dot"></i>
                            <span><?php esc_html_e( '427 Spice Avenue, Gastronomy District, NY 10012', 'velvet-chili-restaurant-shop' ); ?></span>
                        </li>
                        <li><i class="fa-solid fa-phone"></i> <a href="tel:+15551234567">(555) 123-4567</a></li>
                        <li><i class="fa-regular fa-envelope"></i> <a
                                href="mailto:hello@velvetchilirestaurant.com">hello@velvetchilirestaurant.com</a></li>
                    </ul>
                </div>
                <!-- Optional static map -->
                <div class="contact-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a316bb7d0b3%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1644262070686!5m2!1sen!2sus"
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}
} // endif function_exists

// -------------------------------------------------------------// 3. Check if plugin is active
// -------------------------------------------------------------
if ( ! defined( 'OBIRSC_VERSION' ) ) {
    vcrs_static_contact_page();
    get_footer();
    return;
}

// -------------------------------------------------------------
// 4. Get Contact Page data
// -------------------------------------------------------------
$contact_posts = get_posts( array(
    'post_type'      => 'obirsc_contact_page',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
) );

if ( empty( $contact_posts ) ) {
    vcrs_static_contact_page();
    get_footer();
    return;
}

$contact_id = $contact_posts[0]->ID;

// Retrieve meta fields (with correct 'obirsc_' prefix)
$address   = get_post_meta( $contact_id, 'obirsc_contact_address', true );
$phone     = get_post_meta( $contact_id, 'obirsc_contact_phone', true );
$email     = get_post_meta( $contact_id, 'obirsc_contact_email', true );
$map_url   = get_post_meta( $contact_id, 'obirsc_contact_map_embed', true );
$form_shortcode = get_post_meta( $contact_id, 'obirsc_contact_form_shortcode', true );

// Fallback: if contact fields are empty, try to use footer settings
if ( empty( $address ) || empty( $phone ) || empty( $email ) ) {
    $footer_posts = get_posts( array(
        'post_type'      => 'obirsc_footer',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ) );
    if ( ! empty( $footer_posts ) ) {
        $footer_id = $footer_posts[0]->ID;
        $address   = $address ?: get_post_meta( $footer_id, 'obirsc_footer_address', true );
        $phone     = $phone ?: get_post_meta( $footer_id, 'obirsc_footer_phone', true );
        $email     = $email ?: get_post_meta( $footer_id, 'obirsc_footer_email', true );
    }
}

// Final fallback to static text
$address = $address ?: '427 Spice Avenue, Gastronomy District, NY 10012';
$phone   = $phone ?: '(555) 123-4567';
$email   = $email ?: 'hello@velvetchilirestaurant.com';

// Use post title as page title (or fallback)
$title = get_the_title( $contact_id ) ?: __( 'Contact Us', 'velvet-chili-restaurant-shop' );
$kicker = __( 'Get In Touch', 'velvet-chili-restaurant-shop' );
$subtitle = __( 'We\'d love to hear from you. Reach out for reservations, private events, or just to say hello.', 'velvet-chili-restaurant-shop' );

// CF7 shortcode: use stored shortcode or auto-detect first form
if ( ! empty( $form_shortcode ) ) {
    $cf7_shortcode = $form_shortcode;
} else {
    $cf7_shortcode = vcrs_get_first_cf7_shortcode();
}
$cf7_active = defined( 'WPCF7_VERSION' );
?>

<!-- ============================================================
     DYNAMIC CONTACT PAGE
============================================================ -->
<section class="contact-page" id="contact">
    <div class="contact-page__container">
        <div class="contact-page__header text-center">
            <span class="contact-page__kicker"><?php echo esc_html( $kicker ); ?></span>
            <h2 class="contact-page__title"><?php echo esc_html( $title ); ?></h2>
            <p class="contact-page__subtitle"><?php echo esc_html( $subtitle ); ?></p>
        </div>

        <div class="contact-page__grid">
            <!-- Left: Contact Form -->
            <div class="contact-page__form">
                <?php if ( $cf7_active && ! empty( $cf7_shortcode ) ) : ?>
                <?php echo do_shortcode( $cf7_shortcode ); ?>
                <?php elseif ( $cf7_active && empty( $cf7_shortcode ) ) : ?>
                <div class="cf7-notice">
                    <p><strong><?php esc_html_e( 'No contact form found.', 'velvet-chili-restaurant-shop' ); ?></strong>
                    </p>
                    <p><?php esc_html_e( 'Please create a form in Contact Form 7 → Add New, then publish it.', 'velvet-chili-restaurant-shop' ); ?>
                    </p>
                </div>
                <?php else : ?>
                <div class="cf7-notice">
                    <p><strong><?php esc_html_e( 'Contact Form 7 plugin is not active.', 'velvet-chili-restaurant-shop' ); ?></strong>
                    </p>
                    <p><?php esc_html_e( 'To use this contact form, please install and activate the free Contact Form 7 plugin from the WordPress plugin repository.', 'velvet-chili-restaurant-shop' ); ?>
                    </p>
                    <p><a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=contact+form+7&tab=search&type=term' ) ); ?>"
                            target="_blank"><?php esc_html_e( 'Install Contact Form 7 →', 'velvet-chili-restaurant-shop' ); ?></a>
                    </p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right: Contact Info + Map -->
            <div class="contact-page__info">
                <div class="contact-info">
                    <h3 class="contact-info__title">
                        <?php esc_html_e( 'The Velvet Chili Restaurant', 'velvet-chili-restaurant-shop' ); ?></h3>
                    <ul class="contact-info__list">
                        <li><i class="fa-solid fa-location-dot"></i> <span><?php echo esc_html( $address ); ?></span>
                        </li>
                        <li><i class="fa-solid fa-phone"></i> <a
                                href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                        <li><i class="fa-regular fa-envelope"></i> <a
                                href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                        </li>
                    </ul>
                </div>
                <?php if ( ! empty( $map_url ) ) : ?>
                <div class="contact-map">
                    <iframe src="<?php echo esc_url( $map_url ); ?>" width="100%" height="250" style="border:0;"
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>