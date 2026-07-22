<?php
/**
 * WooCommerce Cart Page
 * Designed to match the Velvet Chili Restaurant Shop theme.
 */

defined( 'ABSPATH' ) || exit;

?>


<section class="woo-cart" id="cart">
    <div class="woo-cart__container">

        <!-- Header -->
        <div class="woo-cart__header text-center">
            <span class="woo-cart__kicker"><?php esc_html_e( 'Your Order', 'velvet-chili-restaurant-shop' ); ?></span>
            <h1 class="woo-cart__title"><?php esc_html_e( 'Shopping Cart', 'velvet-chili-restaurant-shop' ); ?></h1>
            <?php wc_print_notices(); ?>
            <p class="woo-cart__subtitle">
                <?php esc_html_e( 'Review your items before proceeding to checkout.', 'velvet-chili-restaurant-shop' ); ?>
            </p>
        </div>

        <?php if ( WC()->cart->is_empty() ) : ?>

        <!-- Empty Cart -->
        <div class="woo-cart__empty text-center">
            <div class="woo-cart__empty-icon">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <h2 class="woo-cart__empty-title">
                <?php esc_html_e( 'Your cart is empty', 'velvet-chili-restaurant-shop' ); ?></h2>
            <p class="woo-cart__empty-text">
                <?php esc_html_e( 'Looks like you haven\'t added anything to your cart yet. Explore our menu and find your favorite dish!', 'velvet-chili-restaurant-shop' ); ?>
            </p>
            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn--primary">
                <?php esc_html_e( 'Browse Menu →', 'velvet-chili-restaurant-shop' ); ?>
            </a>
        </div>

        <?php else : ?>

        <!-- Cart Form -->
        <form class="woo-cart__form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

            <div class="woo-cart__column woo-cart__column--main">

                <!-- Cart Items Grid -->
                <div class="woo-cart__items">
                    <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                        ?>
                    <div
                        class="cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart-item', $cart_item, $cart_item_key ) ); ?>">
                        <!-- Image -->
                        <div class="cart-item__image">
                            <?php
                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key );
                        if ( $product_permalink ) {
                            echo '<a href="' . esc_url( $product_permalink ) . '">' . $thumbnail . '</a>';
                        } else {
                            echo $thumbnail;
                        }
                        ?>
                        </div>

                        <!-- Details -->
                        <div class="cart-item__details">
                            <div class="cart-item__header">
                                <h3 class="cart-item__title">
                                    <?php
                                if ( $product_permalink ) {
                                    echo '<a href="' . esc_url( $product_permalink ) . '">' . wp_kses_post( $_product->get_name() ) . '</a>';
                                } else {
                                    echo wp_kses_post( $_product->get_name() );
                                }
                                ?>
                                </h3>
                                <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>"
                                    class="cart-item__remove"
                                    aria-label="<?php esc_attr_e( 'Remove item', 'velvet-chili-restaurant-shop' ); ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>

                            <?php if ( $_product->is_visible() && $_product->get_sku() ) : ?>
                            <p class="cart-item__sku">
                                <?php echo esc_html__( 'SKU:', 'velvet-chili-restaurant-shop' ) . ' ' . esc_html( $_product->get_sku() ); ?>
                            </p>
                            <?php endif; ?>

                            <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

                            <!-- Quantity & Price Row -->
                            <div class="cart-item__controls">
                                <div class="cart-item__quantity">
                                    <label for="quantity-<?php echo esc_attr( $cart_item_key ); ?>" class="sr-only">
                                        <?php esc_html_e( 'Quantity', 'velvet-chili-restaurant-shop' ); ?>
                                    </label>
                                    <div class="quantity-control" data-key="<?php echo esc_attr( $cart_item_key ); ?>">
                                        <button type="button" class="quantity-control__btn quantity-control__btn--minus"
                                            aria-label="<?php esc_attr_e( 'Decrease quantity', 'velvet-chili-restaurant-shop' ); ?>">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input type="number" id="quantity-<?php echo esc_attr( $cart_item_key ); ?>"
                                            class="quantity-control__input"
                                            name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
                                            value="<?php echo esc_attr( $cart_item['quantity'] ); ?>" min="0"
                                            max="<?php echo $_product->get_max_purchase_quantity() > 0 ? esc_attr( $_product->get_max_purchase_quantity() ) : '9999'; ?>"
                                            step="1" inputmode="numeric" autocomplete="off">
                                        <button type="button" class="quantity-control__btn quantity-control__btn--plus"
                                            aria-label="<?php esc_attr_e( 'Increase quantity', 'velvet-chili-restaurant-shop' ); ?>">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="cart-item__price">
                                    <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                </div>

                                <div class="cart-item__subtotal">
                                    <span
                                        class="cart-item__subtotal-label"><?php esc_html_e( 'Subtotal:', 'velvet-chili-restaurant-shop' ); ?></span>
                                    <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                }
                ?>
                </div>

                <!-- Coupon & Update -->
                <div class="woo-cart__actions">
                    <?php if ( wc_coupons_enabled() ) : ?>
                    <div class="woo-cart__coupon">
                        <label for="coupon_code"
                            class="sr-only"><?php esc_html_e( 'Coupon code', 'velvet-chili-restaurant-shop' ); ?></label>
                        <input type="text" name="coupon_code" id="coupon_code" class="woo-cart__coupon-input"
                            placeholder="<?php esc_attr_e( 'Coupon code', 'velvet-chili-restaurant-shop' ); ?>" />
                        <button type="submit" class="btn woo-cart__coupon-btn" name="apply_coupon"
                            value="<?php esc_attr_e( 'Apply coupon', 'velvet-chili-restaurant-shop' ); ?>">
                            <?php esc_html_e( 'Apply', 'velvet-chili-restaurant-shop' ); ?>
                        </button>
                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                    <?php endif; ?>

                    <div class="woo-cart__update">
                        <button type="submit" class="btn btn--outline-dark" name="update_cart"
                            value="<?php esc_attr_e( 'Update cart', 'velvet-chili-restaurant-shop' ); ?>">
                            <i class="fa-solid fa-rotate-right"></i>
                            <?php esc_html_e( 'Update Cart', 'velvet-chili-restaurant-shop' ); ?>
                        </button>
                        <?php do_action( 'woocommerce_cart_actions' ); ?>
                        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                    </div>
                </div>

            </div>

            <!-- Cart Totals -->
            <div class="woo-cart__column woo-cart__column--side">
                <div class="woo-cart__totals">
                    <?php woocommerce_cart_totals(); ?>
                </div>
            </div>

        </form>

        <!-- Cross‑Sell Products -->
        <?php if ( ! empty( WC()->cart->get_cross_sells() ) ) : ?>
        <div class="woo-cart__cross-sells">
            <?php woocommerce_cross_sell_display(); ?>
        </div>
        <?php endif; ?>

        <?php endif; ?>

    </div>
</section>

<!-- JavaScript for Quantity Controls + Auto-Dismiss Notices -->
<script>
jQuery(document).ready(function($) {

    // --- Quantity Controls ---
    $('.quantity-control').each(function() {
        var $control = $(this);
        var $input = $control.find('.quantity-control__input');
        var $minus = $control.find('.quantity-control__btn--minus');
        var $plus = $control.find('.quantity-control__btn--plus');
        var $form = $control.closest('form');

        if (!$input.length || !$minus.length || !$plus.length || !$form.length) {
            return;
        }

        function submitCartUpdate() {
            // Ensure update_cart is sent
            if (!$form.find('input[name="update_cart"]').length) {
                $form.append('<input type="hidden" name="update_cart" value="1">');
            }
            $form.submit();
        }

        $minus.on('click', function(e) {
            e.preventDefault();
            var val = parseInt($input.val()) || 0;
            if (val > 0) {
                $input.val(val - 1).trigger('change');
                setTimeout(submitCartUpdate, 150);
            }
        });

        $plus.on('click', function(e) {
            e.preventDefault();
            var val = parseInt($input.val()) || 0;
            var max = parseInt($input.attr('max')) || 9999;
            if (val < max) {
                $input.val(val + 1).trigger('change');
                setTimeout(submitCartUpdate, 150);
            }
        });
    });

    // --- Auto-dismiss notices after 6 seconds ---
    var $notices = $('.woocommerce-message, .woocommerce-error, .woocommerce-info');

    $notices.each(function() {
        var $notice = $(this);

        // Add close button
        $notice.append('<button class="woo-notice-close" aria-label="Dismiss notice">&times;</button>');

        // Close on button click
        $notice.find('.woo-notice-close').on('click', function() {
            $notice.fadeOut(300, function() {
                $(this).remove();
            });
        });
    });

    // Auto-dismiss after 6 seconds
    setTimeout(function() {
        $notices.fadeOut(500, function() {
            $(this).remove();
        });
    }, 6000);
});
</script>

<?php do_action( 'woocommerce_after_cart' ); ?>