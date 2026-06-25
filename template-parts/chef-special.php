<?php
/**
 * WooCommerce Product Section
 * Replaces Chef's Special with a dynamic product display (image left, text right).
 * Uses the latest published product or a dummy product as fallback.
 */

// Check if WooCommerce is active
$woocommerce_active = class_exists( 'WooCommerce' );

$product = null;

if ( $woocommerce_active ) {
    // Get the most recent published product
    $products = wc_get_products( array(
        'limit'  => 1,
        'status' => 'publish',
    ) );

    if ( ! empty( $products ) ) {
        $product = $products[0];
    }
}

// If we have a real product from WooCommerce, display its data
if ( $product instanceof WC_Product ) {
    $product_id      = $product->get_id();
    $image_url       = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
    if ( ! $image_url ) {
        $image_url = wc_placeholder_img_src( 'full' );
    }
    $title           = $product->get_name();
    $price_html      = $product->get_price_html();
    $short_desc      = $product->get_short_description();
    $product_url     = get_permalink( $product_id );
    $add_to_cart_url = $product->add_to_cart_url();
    ?>
<section class="menu-highlight" id="chefSpecial">
    <div class="menu-highlight__image">
        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
    </div>
    <div class="menu-highlight__text">
        <span class="menu-highlight__kicker">Chef's Special</span>
        <h2 class="menu-highlight__title"><?php echo esc_html( $title ); ?></h2>
        <p class="menu-highlight__subtitle"><?php echo wp_kses_post( $price_html ); ?></p>
        <div class="menu-highlight__body">
            <?php echo wp_kses_post( $short_desc ?: 'A delicious selection from our kitchen – made with fresh ingredients and passion.' ); ?>
            <div class="product-action" style="margin-top: 1rem;">
                <a href="<?php echo esc_url( $add_to_cart_url ); ?>" class="button add_to_cart_button"
                    data-product_id="<?php echo absint( $product_id ); ?>">Order Now →</a>
            </div>
        </div>
    </div>
</section>
<?php
} else {
    // Fallback dummy product (no WooCommerce or no products found)
    ?>
<section class="menu-highlight" id="chefSpecial">
    <div class="menu-highlight__image">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/dummy-product.jpg' ); ?>"
            alt="Dummy Product" loading="lazy">
    </div>
    <div class="menu-highlight__text">
        <span class="menu-highlight__kicker">Chef's Special</span>
        <h2 class="menu-highlight__title">Smoked Brisket Burger</h2>
        <p class="menu-highlight__subtitle"><span class="woocommerce-Price-amount amount"><bdi><span
                        class="woocommerce-Price-currencySymbol">$</span>24.90</bdi></span></p>
        <div class="menu-highlight__body">
            Premium beef patty, slow‑smoked brisket, cheddar, crispy onion rings, and house BBQ sauce. Served with
            seasoned fries.
            <div class="product-action" style="margin-top: 1rem;">
                <a href="#" class="button">Order Now →</a>
            </div>
        </div>
    </div>
</section>
<?php
}
?>