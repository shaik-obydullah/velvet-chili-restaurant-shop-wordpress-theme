<?php
/**
 * Empty cart page
 *
 * Overrides /woocommerce/templates/cart/cart-empty.php.
 */

defined( 'ABSPATH' ) || exit;

wc_print_notices();

?>
<section class="woo-cart" id="cart">
    <div class="woo-cart__container">

        <div class="woo-cart__header text-center">
            <span class="woo-cart__kicker"><?php esc_html_e( 'Your Order', 'velvet-chili-restaurant-shop' ); ?></span>
            <h1 class="woo-cart__title"><?php esc_html_e( 'Shopping Cart', 'velvet-chili-restaurant-shop' ); ?></h1>
            <p class="woo-cart__subtitle">
                <?php esc_html_e( 'Review your items before proceeding to checkout.', 'velvet-chili-restaurant-shop' ); ?>
            </p>
        </div>

        <div class="woo-cart__empty text-center">
            <div class="woo-cart__empty-icon">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <h2 class="woo-cart__empty-title">
                <?php esc_html_e( 'Your cart is empty', 'velvet-chili-restaurant-shop' ); ?>
            </h2>
            <p class="woo-cart__empty-text">
                <?php esc_html_e( 'Looks like you haven\'t added anything to your cart yet. Explore our menu and find your favorite dish!', 'velvet-chili-restaurant-shop' ); ?>
            </p>
            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn--primary">
                <?php esc_html_e( 'Browse Menu →', 'velvet-chili-restaurant-shop' ); ?>
            </a>
        </div>

    </div>
</section>
<?php do_action( 'woocommerce_after_cart' ); ?>
