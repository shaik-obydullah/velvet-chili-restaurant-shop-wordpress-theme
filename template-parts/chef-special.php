<?php
/**
 * Chef's Special Section
 * Displays dynamic Chef's Special if plugin active & CPT has posts.
 * Otherwise shows a static fallback.
 */

$fallback_image = get_template_directory_uri() . '/assets/images/chef-special.jpg';

// Check if plugin is active and CPT exists
$has_plugin = defined( 'OBIRSC_VERSION' );
$has_cpt    = post_type_exists( 'obirsc_chef_special' );

// Only run query if plugin and CPT are available
if ( $has_plugin && $has_cpt ) {
    $chef_posts = get_posts( [
        'post_type'      => 'obirsc_chef_special',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ] );
    $has_chef = ! empty( $chef_posts );
} else {
    $has_chef = false;
}

if ( $has_plugin && $has_cpt && $has_chef ) :
    $chef_post = $chef_posts[0];
    $chef_id   = $chef_post->ID;

    // Get meta data
    $subtitle   = get_post_meta( $chef_id, 'obirsc_subtitle', true );
    $body       = get_post_meta( $chef_id, 'obirsc_body', true );
    $product_id = intval( get_post_meta( $chef_id, '_obirsc_woo_product_id', true ) );
    $title      = get_the_title( $chef_id );

    // Image: fallback to dummy if no product image
    $image_url = $fallback_image;

    // Prepare product data if WooCommerce is active and product is linked
    $product_data = null;
    $product_permalink = '#';

    if ( $product_id && class_exists( 'WooCommerce' ) ) {
        $product = wc_get_product( $product_id );
        if ( $product ) {
            $product_image = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
            if ( $product_image ) {
                $image_url = $product_image;
            }

            $product_permalink = get_permalink( $product_id );

            $product_data = [
                'name'            => $product->get_name(),
                'price_html'      => $product->get_price_html(),
                'permalink'       => $product_permalink,
                'is_purchasable'  => $product->is_purchasable(),
            ];
        }
    }
?>

<section class="menu-highlight" id="chefSpecial">
    <div class="menu-highlight__image">
        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
    </div>
    <div class="menu-highlight__text">
        <span class="menu-highlight__kicker">
            <?php esc_html_e( 'Chef\'s Special', 'velvet-chili-restaurant-shop' ); ?>
        </span>

        <h2 class="menu-highlight__title">
            <?php echo esc_html( $title ); ?>
        </h2>

        <?php if ( $subtitle ) : ?>
        <p class="menu-highlight__subtitle">
            <?php echo esc_html( $subtitle ); ?>
        </p>
        <?php endif; ?>

        <?php if ( $product_data && $product_data['price_html'] ) : ?>
        <p class="menu-highlight__price">
            <?php echo wp_kses_post( $product_data['price_html'] ); ?>
        </p>
        <?php endif; ?>

        <div class="menu-highlight__body">
            <?php if ( $body ) : ?>
            <?php echo wp_kses_post( $body ); ?>
            <?php else : ?>
            <?php echo wp_kses_post( $product_data['name'] ?? '' ); ?>
            <?php endif; ?>

            <div class="product-action">
                <?php if ( $product_data && $product_permalink !== '#' ) : ?>
                <a href="<?php echo esc_url( $product_permalink ); ?>" class="nav__link--cta">
                    <?php esc_html_e( 'View Product', 'velvet-chili-restaurant-shop' ); ?>
                </a>
                <?php else : ?>
                <a href="#" class="button nav__link--cta">
                    <?php esc_html_e( 'Coming Soon', 'velvet-chili-restaurant-shop' ); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
    wp_reset_postdata();
else :
?>

<!-- Static Fallback -->
<section class="menu-highlight" id="chefSpecial">
    <div class="menu-highlight__image">
        <img src="<?php echo esc_url( $fallback_image ); ?>"
            alt="<?php esc_attr_e( 'Chef\'s Special', 'velvet-chili-restaurant-shop' ); ?>" loading="lazy">
    </div>
    <div class="menu-highlight__text">
        <span class="menu-highlight__kicker">
            <?php esc_html_e( 'Chef\'s Special', 'velvet-chili-restaurant-shop' ); ?>
        </span>

        <h2 class="menu-highlight__title">
            <?php esc_html_e( 'Smoked Brisket Burger', 'velvet-chili-restaurant-shop' ); ?>
        </h2>

        <p class="menu-highlight__subtitle">
            <?php esc_html_e( 'Chef\'s Signature', 'velvet-chili-restaurant-shop' ); ?>
        </p>

        <p class="menu-highlight__price">
            <span class="woocommerce-Price-amount amount">
                <bdi><span class="woocommerce-Price-currencySymbol">$</span>24.90</bdi>
            </span>
        </p>

        <div class="menu-highlight__body">
            <?php esc_html_e( 'Premium beef patty, slow‑smoked brisket, cheddar, crispy onion rings, and house BBQ sauce. Served with seasoned fries.', 'velvet-chili-restaurant-shop' ); ?>
            <div class="product-action">
                <a href="#" class="button nav__link--cta">
                    <?php esc_html_e( 'Coming Soon', 'velvet-chili-restaurant-shop' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>