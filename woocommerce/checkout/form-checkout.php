<?php
/**
 * Checkout Page - Velvet Chili Restaurant Shop
 */

defined( 'ABSPATH' ) || exit;

// Coupon form is rendered inline below (moved from woocommerce_before_checkout_form)
?>

<style>
/* ======================================================
   WooCommerce Checkout Page
====================================================== */

.woo-checkout {
    width: 100%;
    padding: 6rem 1.5rem 4rem;
    background-color: var(--color-warm-white);
}

.woo-checkout__container {
    max-width: var(--container-max);
    margin: 0 auto;
}

.woo-checkout__header {
    text-align: center;
    margin-bottom: 3rem;
}

.woo-checkout__kicker {
    font-family: var(--font-body);
    font-size: 0.85rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--color-chili-red);
    display: block;
    margin-bottom: 0.5rem;
}

.woo-checkout__title {
    font-family: var(--font-heading);
    font-size: clamp(2.2rem, 5vw, 3.2rem);
    font-weight: 700;
    color: var(--color-soft-black);
    margin-bottom: 0.5rem;
}

.woo-checkout__subtitle {
    font-family: var(--font-body);
    font-size: 1rem;
    color: var(--color-text-secondary);
    max-width: 500px;
    margin: 0 auto;
}

/* Notices */
.woocommerce-notices-wrapper {
    max-width: var(--container-max);
    margin: 0 auto 2rem;
    padding: 0 1.5rem;
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
}

.woocommerce-message {
    border-left-color: #2e7d32;
}

.woocommerce-error {
    border-left-color: var(--color-chili-red);
}

.woocommerce-info {
    border-left-color: #2563eb;
}

/* Checkout Grid */
.woo-checkout__grid {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 2.5rem;
    align-items: flex-start;
}

.woo-checkout__col {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    border: 1px solid var(--color-border);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
}

.woo-checkout__section-title {
    font-family: var(--font-heading);
    font-size: 1rem;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    background: var(--color-soft-black);
    margin: -2rem -2rem 1.5rem;
    padding: 1rem 1.5rem;
    border-radius: 16px 16px 0 0;
}

/* Section headings (billing & shipping h3) */
.woo-checkout__col h3 {
    font-family: var(--font-heading);
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--color-soft-black);
    margin-bottom: 1.25rem;
    padding-bottom: 0.6rem;
    border-bottom: 2px solid var(--color-chili-red);
}

/* WooCommerce Shipping Fields */
.woo-checkout .woocommerce-shipping-fields {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid var(--color-border);
}

/* Shipping checkbox section */
.woo-checkout #ship-to-different-address {
    margin-bottom: 0;
    border-bottom: none;
    padding-bottom: 0;
}

.woo-checkout #ship-to-different-address .woocommerce-form__label {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--color-soft-black);
    cursor: pointer;
    font-family: var(--font-body);
    border: none;
    padding: 0;
}

.woo-checkout #ship-to-different-address input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--color-chili-red);
    cursor: pointer;
}

.woo-checkout .shipping_address {
    padding-top: 1rem;
    border-top: 2px solid var(--color-border);
    margin-top: 0.5rem;
}

/* Form Fields */
.woo-checkout .form-row {
    margin-bottom: 1.2rem;
}

.woo-checkout .form-row label {
    font-family: var(--font-body);
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--color-soft-black);
    margin-bottom: 0.35rem;
    display: block;
}

.woo-checkout .form-row .required {
    color: var(--color-chili-red);
}

.woo-checkout .form-row input,
.woo-checkout .form-row select,
.woo-checkout .form-row textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--color-border);
    border-radius: 8px;
    font-family: var(--font-body);
    font-size: 0.95rem;
    background: var(--color-warm-white);
    color: var(--color-text-primary);
    transition: border-color var(--transition-fast);
    box-sizing: border-box;
}

.woo-checkout .form-row input:focus,
.woo-checkout .form-row select:focus,
.woo-checkout .form-row textarea:focus {
    outline: none;
    border-color: var(--color-chili-red);
    box-shadow: 0 0 0 3px rgba(198, 40, 40, 0.1);
}

/* Order Items */
.woo-checkout__order-item {
    display: flex;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--color-border);
}

.woo-checkout__order-item:last-child {
    border-bottom: none;
}

.woo-checkout__order-item-image {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
    border-radius: 6px;
    overflow: hidden;
    background: var(--color-cream);
}

.woo-checkout__order-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.woo-checkout__order-item-details {
    flex: 1;
}

.woo-checkout__order-item-name {
    font-family: var(--font-heading);
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-soft-black);
    margin: 0;
}

.woo-checkout__order-item-meta {
    font-size: 0.85rem;
    color: var(--color-text-secondary);
}

.woo-checkout__order-item-price {
    font-weight: 600;
    color: var(--color-soft-black);
}

/* Totals */
.woo-checkout__totals {
    margin: 1.5rem 0;
    padding-top: 1rem;
    border-top: 2px solid var(--color-border);
}

.woo-checkout__total-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
}

.woo-checkout__total-row--total {
    border-top: 2px solid var(--color-soft-black);
    margin-top: 0.5rem;
    padding-top: 1rem;
    font-weight: 700;
}

.woo-checkout__total-value--total {
    color: var(--color-chili-red);
}

/* Order Review Table */
.woo-checkout .shop_table.woocommerce-checkout-review-order-table {
    border: none;
    border-collapse: collapse;
    width: 100%;
}

.woo-checkout .shop_table.woocommerce-checkout-review-order-table thead th {
    font-family: var(--font-body);
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--color-text-secondary);
    padding: 0 0 0.75rem;
    border-bottom: 2px solid var(--color-border);
    border-top: none;
    border-left: none;
    border-right: none;
    background: none;
}

.woo-checkout .shop_table.woocommerce-checkout-review-order-table tbody td {
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--color-border);
    border-top: none;
    border-left: none;
    border-right: none;
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: var(--color-text-primary);
    background: none;
}

.woo-checkout .shop_table.woocommerce-checkout-review-order-table tfoot th,
.woo-checkout .shop_table.woocommerce-checkout-review-order-table tfoot td {
    padding: 0.5rem 0;
    border: none;
    background: none;
    font-family: var(--font-body);
}

.woo-checkout .shop_table.woocommerce-checkout-review-order-table tfoot th {
    font-weight: 400;
    color: var(--color-text-secondary);
    font-size: 0.9rem;
}

.woo-checkout .shop_table.woocommerce-checkout-review-order-table tfoot td {
    text-align: right;
    font-weight: 600;
    color: var(--color-soft-black);
}

.woo-checkout .shop_table.woocommerce-checkout-review-order-table tfoot tr.order-total th {
    border-top: 2px solid var(--color-soft-black);
    padding-top: 1rem;
    margin-top: 0.5rem;
    font-weight: 700;
    color: var(--color-soft-black);
    font-size: 1rem;
}

.woo-checkout .shop_table.woocommerce-checkout-review-order-table tfoot tr.order-total td {
    border-top: 2px solid var(--color-soft-black);
    padding-top: 1rem;
    margin-top: 0.5rem;
    font-weight: 800;
    color: var(--color-chili-red);
    font-size: 1.2rem;
}

.woo-checkout .shop_table .product-quantity {
    color: var(--color-text-secondary);
    font-size: 0.85rem;
}

/* Place Order Button */
#place_order {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: var(--color-chili-red);
    color: white;
    border: none;
    border-radius: 10px;
    font-family: var(--font-body);
    font-size: 1.1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all var(--transition-fast);
}

#place_order::after {
    content: "→";
    font-size: 1.2rem;
    transition: transform var(--transition-fast);
}

#place_order:hover {
    background: var(--color-soft-black);
    transform: translateY(-2px);
}

#place_order:hover::after {
    transform: translateX(3px);
}

/* Payment Methods */
.woo-checkout .wc_payment_methods {
    padding: 0;
    margin: 1rem 0;
    list-style: none;
}

.woo-checkout .wc_payment_methods li {
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--color-border);
}

.woo-checkout .wc_payment_methods li:last-child {
    border-bottom: none;
}

.woo-checkout .payment_box {
    margin-top: 0.5rem;
    padding: 1rem;
    background: var(--color-warm-white);
    border-radius: 8px;
    font-size: 0.9rem;
    color: var(--color-text-secondary);
    border: 1px solid var(--color-border);
}

/* Create Account Checkbox */
.woo-checkout .create-account {
    margin-top: 1.5rem;
    padding-top: 1.25rem;
    border-top: 2px solid var(--color-border);
}

.woo-checkout .create-account .woocommerce-form__label {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--color-soft-black);
    cursor: pointer;
    font-family: var(--font-body);
    border: none;
    padding: 0;
    margin: 0;
}

.woo-checkout .create-account input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--color-chili-red);
    cursor: pointer;
    margin: 0;
    padding: 0;
}

/* Account password fields (shown when create account is checked) */
.woo-checkout .create-account + .create-account-password-fields {
    margin-top: 1rem;
    padding-left: 1.5rem;
}

/* Responsive */
@media screen and (max-width: 992px) {
    .woo-checkout__grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .woo-checkout__col--order {
        order: -1;
    }
}

@media screen and (max-width: 768px) {
    .woo-checkout {
        padding: 5rem 1rem 3rem;
    }

    .woo-checkout__col {
        padding: 1.5rem;
    }

    .woo-checkout__section-title {
        margin: -1.5rem -1.5rem 1rem;
        padding: 0.85rem 1.25rem;
    }
}
</style>

<section class="woo-checkout" id="checkout">
    <div class="woo-checkout__container">

        <!-- Header -->
        <div class="woo-checkout__header">
            <span
                class="woo-checkout__kicker"><?php esc_html_e( 'Secure Checkout', 'velvet-chili-restaurant-shop' ); ?></span>
            <h1 class="woo-checkout__title">
                <?php esc_html_e( 'Complete Your Order', 'velvet-chili-restaurant-shop' ); ?></h1>
            <?php woocommerce_checkout_coupon_form(); ?>
            <p class="woo-checkout__subtitle">
                <?php esc_html_e( 'Fill in your details and confirm your reservation.', 'velvet-chili-restaurant-shop' ); ?>
            </p>
        </div>

        <?php
        // Display WooCommerce notices
        wc_print_notices();

        $checkout = WC()->checkout();

        // If registration is required and user is not logged in, show notice
        if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
            echo '<p>' . esc_html__( 'You must be logged in to checkout.', 'velvet-chili-restaurant-shop' ) . '</p>';
        } else {
        ?>

        <!-- Checkout Form -->
        <form name="checkout" method="post" class="checkout woocommerce-checkout"
            action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

            <div class="woo-checkout__grid">

                <!-- Billing + Shipping Details -->
                <div class="woo-checkout__col woo-checkout__col--details">
                    <?php if ( $checkout->get_checkout_fields() ) : ?>

                        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                        <div id="customer_details">
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                        </div>

                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                    <?php endif; ?>
                </div>

                <!-- Order Review -->
                <div class="woo-checkout__col woo-checkout__col--order">
                    <h2 class="woo-checkout__section-title">
                        <?php esc_html_e( 'Your Order', 'velvet-chili-restaurant-shop' ); ?>
                    </h2>
                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>
                    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                </div>

            </div>

        </form>

        <?php } ?>

    </div>
</section>

<?php do_action( 'woocommerce_after_checkout_form' ); ?>