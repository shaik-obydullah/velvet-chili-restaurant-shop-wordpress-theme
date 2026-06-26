<?php
/**
 * WooCommerce Cart Page
 * Designed to match the Velvet Chili Restaurant Shop theme.
 */

defined( 'ABSPATH' ) || exit;

?>

<style>
/* ======================================================
   WooCommerce Cart Page
====================================================== */

/* WooCommerce Notices - Toast Style */
.woocommerce-notices-wrapper {
    margin-bottom: 1rem;
}

.woocommerce-message,
.woocommerce-error,
.woocommerce-info {
    list-style: none;
    padding: 1rem 1.5rem;
    margin: 0 0 0.75rem;
    background: white;
    border-radius: 12px;
    border: 1px solid var(--color-border);
    border-left: 5px solid;
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: var(--color-text-primary);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    animation: slideIn 0.4s ease;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-12px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.woocommerce-message {
    border: none;
    border-radius: 8px;
    background: #e8f5e9;
    color: #2e7d32;
}

.woocommerce-message::before {
    content: "✓ ";
    font-weight: 700;
    font-size: 1.1rem;
}

.woocommerce-error {
    border-left-color: var(--color-chili-red);
}

.woocommerce-error::before {
    content: "✕ ";
    color: var(--color-chili-red);
    font-weight: 700;
    font-size: 1.1rem;
}

.woocommerce-info {
    border-left-color: #2563eb;
}

.woocommerce-info::before {
    content: "ℹ ";
    color: #2563eb;
    font-weight: 700;
    font-size: 1.1rem;
}

.woocommerce-message li,
.woocommerce-error li,
.woocommerce-info li {
    list-style: none;
    flex: 1;
}

.woocommerce-message a,
.woocommerce-error a,
.woocommerce-info a {
    color: var(--color-chili-red);
    font-weight: 600;
    transition: color var(--transition-fast);
}

.woocommerce-message a:hover,
.woocommerce-error a:hover,
.woocommerce-info a:hover {
    color: var(--color-soft-black);
}

.woocommerce-message .button,
.woocommerce-error .button,
.woocommerce-info .button {
    background: var(--color-soft-black);
    color: white;
    border: none;
    padding: 0.4rem 1.2rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background var(--transition-fast);
    flex-shrink: 0;
}

.woocommerce-message .button:hover,
.woocommerce-error .button:hover,
.woocommerce-info .button:hover {
    background: var(--color-chili-red);
}

/* Notice close button */
.woo-notice-close {
    background: none;
    border: none;
    color: var(--color-text-secondary);
    font-size: 1.1rem;
    cursor: pointer;
    padding: 0 0.25rem;
    transition: color var(--transition-fast);
    flex-shrink: 0;
    line-height: 1;
}

.woo-notice-close:hover {
    color: var(--color-soft-black);
}

.woo-cart {
    width: 100%;
    padding: 4rem 1.5rem 4rem;
    background-color: var(--color-warm-white);
}

.woo-cart__container {
    max-width: var(--container-max);
    margin: 0 auto;
}

.woo-cart__header {
    margin-bottom: 3rem;
}

.woo-cart__kicker {
    font-family: var(--font-body);
    font-size: 0.85rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--color-chili-red);
    display: block;
    margin-bottom: 0.5rem;
}

.woo-cart__title {
    font-family: var(--font-heading);
    font-size: clamp(2.2rem, 5vw, 3.2rem);
    font-weight: 700;
    color: var(--color-soft-black);
    margin-bottom: 0.5rem;
}

.woo-cart__subtitle {
    font-family: var(--font-body);
    font-size: 1rem;
    color: var(--color-text-secondary);
    max-width: 500px;
    margin: 0 auto;
}

/* Empty Cart */
.woo-cart__empty {
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    border: 1px solid var(--color-border);
}

.woo-cart__empty-icon {
    font-size: 4rem;
    color: var(--color-light-taupe);
    margin-bottom: 1rem;
}

.woo-cart__empty-title {
    font-family: var(--font-heading);
    font-size: 1.8rem;
    color: var(--color-soft-black);
    margin-bottom: 0.5rem;
}

.woo-cart__empty-text {
    font-family: var(--font-body);
    color: var(--color-text-secondary);
    max-width: 400px;
    margin: 0 auto 2rem;
}

/* Cart Items */
.woo-cart__items {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.cart-item {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    border: 1px solid var(--color-border);
    transition: box-shadow var(--transition-smooth);
}

.cart-item:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
}

.cart-item__image {
    flex-shrink: 0;
    width: 120px;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    border-radius: 8px;
    background: var(--color-cream);
}

.cart-item__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item__details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.cart-item__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
}

.cart-item__title {
    font-family: var(--font-heading);
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--color-soft-black);
    margin: 0;
}

.cart-item__title a {
    color: inherit;
    text-decoration: none;
    transition: color var(--transition-fast);
}

.cart-item__title a:hover {
    color: var(--color-chili-red);
}

.cart-item__remove {
    color: var(--color-text-secondary);
    font-size: 1rem;
    transition: color var(--transition-fast);
    text-decoration: none;
    line-height: 1;
    padding: 0.25rem;
}

.cart-item__remove:hover {
    color: var(--color-chili-red);
}

.cart-item__remove i {
    font-size: 1.1rem;
}

.cart-item__sku {
    font-size: 0.85rem;
    color: var(--color-text-secondary);
    margin: 0;
}

.cart-item__controls {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.5rem;
    margin-top: auto;
}

.cart-item__quantity {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid var(--color-border);
    border-radius: 6px;
    overflow: hidden;
    background: white;
}

.quantity-control__btn {
    background: none;
    border: none;
    padding: 0.4rem 0.8rem;
    cursor: pointer;
    color: var(--color-text-secondary);
    font-size: 0.8rem;
    transition: color var(--transition-fast);
}

.quantity-control__btn:hover {
    color: var(--color-chili-red);
}

.quantity-control__input {
    width: 50px;
    text-align: center;
    border: none;
    padding: 0.4rem 0;
    font-family: var(--font-body);
    font-size: 0.95rem;
    background: transparent;
}

.quantity-control__input:focus {
    outline: none;
}

/* Hide number input arrows */
.quantity-control__input::-webkit-outer-spin-button,
.quantity-control__input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-control__input[type="number"] {
    -moz-appearance: textfield;
}

.cart-item__price {
    font-weight: 600;
    color: var(--color-soft-black);
}

.cart-item__subtotal {
    margin-left: auto;
    font-weight: 600;
    color: var(--color-soft-black);
}

.cart-item__subtotal-label {
    font-weight: 400;
    color: var(--color-text-secondary);
    margin-right: 0.5rem;
}

/* Cart Actions (Coupon + Update) */
.woo-cart__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    border: 1px solid var(--color-border);
    margin-bottom: 2rem;
    align-items: center;
}

.woo-cart__coupon {
    display: flex;
    gap: 0.75rem;
    flex: 1;
}

.woo-cart__coupon-input {
    flex: 1;
    padding: 0.6rem 1rem;
    border: 1px solid var(--color-border);
    border-radius: 6px;
    font-family: var(--font-body);
    font-size: 0.95rem;
    transition: border-color var(--transition-fast);
    background: var(--color-warm-white);
}

.woo-cart__coupon-input:focus {
    outline: none;
    border-color: var(--color-chili-red);
}

.woo-cart__coupon-btn {
    padding: 0.6rem 1.5rem;
    background: var(--color-soft-black);
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: background var(--transition-fast);
}

.woo-cart__coupon-btn:hover {
    background: var(--color-chili-red);
}

.woo-cart__update {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn--outline-dark {
    background: transparent;
    border: 2px solid var(--color-soft-black);
    color: var(--color-soft-black);
    padding: 0.6rem 1.5rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.btn--outline-dark:hover {
    background: var(--color-soft-black);
    color: white;
}

/* Two-column layout */
.woo-cart__form {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
    align-items: start;
}

.woo-cart__column--main {
    min-width: 0;
}

.woo-cart__column--side {
    position: sticky;
    top: calc(var(--header-height) + 2rem);
}

/* Cart Totals */
.woo-cart__totals {
    margin-bottom: 2rem;
}

.cart-totals {
    background: white;
    border-radius: 12px;
    border: 1px solid var(--color-border);
    padding: 2rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
}

.cart_totals>h2 {
    font-family: var(--font-heading);
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--color-soft-black);
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--color-border);
}

.cart_totals table.shop_table {
    width: 100%;
    border-collapse: collapse;
}

.cart_totals table.shop_table tr {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--color-border);
}

.cart_totals table.shop_table tr:last-of-type {
    border-bottom: none;
}

.cart_totals table.shop_table tr.order-total {
    padding: 1rem 0;
    margin-top: 0.5rem;
    border-top: 2px solid var(--color-soft-black);
    border-bottom: none;
}

.cart_totals table.shop_table th {
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 400;
    color: var(--color-text-secondary);
}

.cart_totals table.shop_table td {
    font-weight: 600;
    color: var(--color-soft-black);
    text-align: right;
}

.cart_totals table.shop_table tr.order-total th {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--color-soft-black);
}

.cart_totals table.shop_table tr.order-total td {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--color-chili-red);
}

.cart_totals .wc-proceed-to-checkout {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--color-border);
}

.cart_totals .wc-proceed-to-checkout .checkout-button {
    display: block;
    width: 100%;
    text-align: center;
    padding: 1rem;
    background: var(--color-chili-red);
    color: white;
    border: none;
    border-radius: 8px;
    font-family: var(--font-body);
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: background var(--transition-fast);
    box-sizing: border-box;
}

.cart_totals .wc-proceed-to-checkout .checkout-button:hover {
    background: var(--color-soft-black);
}

.woocommerce-shipping-calculator {
    margin: 0.75rem 0 0;
}

.woocommerce-shipping-calculator .button {
    background: var(--color-soft-black);
    color: white;
    border: none;
    padding: 0.4rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    font-family: var(--font-body);
    font-size: 0.85rem;
    transition: background var(--transition-fast);
}

.woocommerce-shipping-calculator .button:hover {
    background: var(--color-chili-red);
}

.woocommerce-shipping-calculator .shipping-calculator-form {
    margin-top: 0.75rem;
}

.woocommerce-shipping-calculator .shipping-calculator-form input,
.woocommerce-shipping-calculator .shipping-calculator-form select {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--color-border);
    border-radius: 6px;
    font-family: var(--font-body);
    font-size: 0.9rem;
    background: var(--color-warm-white);
    margin-bottom: 0.5rem;
    box-sizing: border-box;
}

.woocommerce-shipping-calculator .shipping-calculator-form input:focus,
.woocommerce-shipping-calculator .shipping-calculator-form select:focus {
    outline: none;
    border-color: var(--color-chili-red);
}

.cart_totals a.remove-coupon {
    color: var(--color-text-secondary);
    font-size: 0.9rem;
    transition: color var(--transition-fast);
}

.cart_totals a.remove-coupon:hover {
    color: var(--color-chili-red);
}

/* Cross-Sells */
.woo-cart__cross-sells {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 2px solid var(--color-border);
}

.woo-cart__cross-sells-title {
    font-family: var(--font-heading);
    font-size: 1.6rem;
    font-weight: 600;
    color: var(--color-soft-black);
    text-align: center;
    margin-bottom: 2rem;
}

.woo-cart__cross-sells-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
}

/* Responsive */
@media screen and (max-width: 1024px) {
    .woo-cart__form {
        grid-template-columns: 1fr 320px;
    }
}

@media screen and (max-width: 768px) {
    .woo-cart {
        padding: 5rem 1rem 3rem;
    }

    .woo-cart__form {
        grid-template-columns: 1fr;
    }

    .woo-cart__column--side {
        position: static;
    }

    .cart-item {
        flex-direction: column;
        padding: 1rem;
    }

    .cart-item__image {
        width: 100%;
        max-width: 200px;
        aspect-ratio: 4 / 3;
    }

    .cart-item__controls {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .cart-item__subtotal {
        margin-left: 0;
    }

    .woo-cart__actions {
        flex-direction: column;
    }

    .woo-cart__coupon {
        width: 100%;
        flex-wrap: wrap;
    }

    .woo-cart__coupon-input {
        flex: 1 1 100%;
    }

    .woo-cart__update {
        width: 100%;
        justify-content: center;
    }

    .cart-totals {
        padding: 1.5rem;
    }

    .woo-cart__column--main {
        margin-bottom: 0;
    }

    .woo-cart__cross-sells-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1rem;
    }
}

@media screen and (max-width: 480px) {
    .woo-cart__cross-sells-grid {
        grid-template-columns: 1fr 1fr;
    }
}
</style>

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
                                    <i class="fa-regular fa-trash-can"></i>
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
                            <i class="fa-regular fa-rotate-right"></i>
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