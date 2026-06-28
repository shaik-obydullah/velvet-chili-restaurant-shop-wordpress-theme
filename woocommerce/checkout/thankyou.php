<?php
/**
 * Order Received / Thank You Page
 * Displays after a successful order.
 */

defined( 'ABSPATH' ) || exit;

$order_id = absint( get_query_var( 'order-received' ) );
$order    = wc_get_order( $order_id );

if ( ! $order ) {
    echo '<p>' . esc_html__( 'Invalid order.', 'velvet-chili-restaurant-shop' ) . '</p>';
    return;
}
?>

<style>
/* ======================================================
   WooCommerce Order Received Page
====================================================== */

.woo-thankyou {
    width: 100%;
    padding: 6rem 1.5rem 4rem;
    background-color: var(--color-warm-white);
}

.woo-thankyou__container {
    max-width: var(--container-max);
    margin: 0 auto;
}

/* Header */
.woo-thankyou__header {
    text-align: center;
    margin-bottom: 3rem;
}

.woo-thankyou__icon {
    font-size: 4rem;
    color: #2e7d32;
    margin-bottom: 1rem;
}

.woo-thankyou__kicker {
    font-family: var(--font-body);
    font-size: 0.85rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--color-chili-red);
    display: block;
    margin-bottom: 0.5rem;
}

.woo-thankyou__title {
    font-family: var(--font-heading);
    font-size: clamp(2.2rem, 5vw, 3.2rem);
    font-weight: 700;
    color: var(--color-soft-black);
    margin-bottom: 0.5rem;
}

.woo-thankyou__subtitle {
    font-family: var(--font-body);
    font-size: 1.1rem;
    color: var(--color-text-secondary);
    max-width: 500px;
    margin: 0 auto;
}

/* Cards */
.woo-thankyou__card {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--color-border);
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    margin-bottom: 2rem;
}

.woo-thankyou__card-title {
    font-family: var(--font-heading);
    font-size: 1rem;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    background: var(--color-soft-black);
    margin: 0;
    padding: 1rem 1.5rem;
}

.woo-thankyou__card-body {
    padding: 1.5rem;
}

/* Order Items */
.woo-thankyou__order-item {
    display: flex;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--color-border);
}

.woo-thankyou__order-item:last-child {
    border-bottom: none;
}

.woo-thankyou__order-item-image {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
    border-radius: 6px;
    overflow: hidden;
    background: var(--color-cream);
}

.woo-thankyou__order-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.woo-thankyou__order-item-details {
    flex: 1;
}

.woo-thankyou__order-item-name {
    font-family: var(--font-heading);
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-soft-black);
    margin: 0;
}

.woo-thankyou__order-item-meta {
    font-size: 0.85rem;
    color: var(--color-text-secondary);
}

.woo-thankyou__order-item-quantity {
    color: var(--color-text-secondary);
    font-size: 0.9rem;
}

.woo-thankyou__order-item-price {
    font-weight: 600;
    color: var(--color-soft-black);
    white-space: nowrap;
}

/* Order Totals */
.woo-thankyou__totals {
    margin-top: 1rem;
    padding: 1rem 0 0;
    border-top: 1px dashed var(--color-border);
}

.woo-thankyou__total-row {
    display: flex;
    justify-content: space-between;
    padding: 0.4rem 0;
    font-size: 0.95rem;
}

.woo-thankyou__total-row--total {
    border-top: 2px solid var(--color-soft-black);
    margin-top: 0.5rem;
    padding-top: 0.75rem;
    font-weight: 800;
    font-size: 1.2rem;
}

.woo-thankyou__total-label {
    color: var(--color-text-secondary);
}

.woo-thankyou__total-label--total {
    color: var(--color-soft-black);
}

.woo-thankyou__total-value {
    font-weight: 600;
    color: var(--color-soft-black);
}

.woo-thankyou__total-value--total {
    color: var(--color-chili-red);
}

/* Customer Details */
.woo-thankyou__customer-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.woo-thankyou__customer-detail {
    margin-bottom: 0.5rem;
}

.woo-thankyou__customer-detail .label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--color-text-secondary);
    display: block;
    margin-bottom: 0.15rem;
}

.woo-thankyou__customer-detail .value {
    font-size: 1rem;
    color: var(--color-soft-black);
}

/* Actions */
.woo-thankyou__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 2rem;
    justify-content: center;
}

.woo-thankyou__actions .btn {
    min-width: 200px;
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Responsive */
@media screen and (max-width: 768px) {
    .woo-thankyou {
        padding: 5rem 1rem 3rem;
    }

    .woo-thankyou__card-body {
        padding: 1.25rem;
    }

    .woo-thankyou__order-info {
        grid-template-columns: 1fr 1fr;
    }

    .woo-thankyou__customer-details {
        grid-template-columns: 1fr;
    }

    .woo-thankyou__order-item {
        flex-wrap: wrap;
    }
}

@media screen and (max-width: 480px) {
    .woo-thankyou__order-info {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="woo-thankyou" id="orderReceived">
    <div class="woo-thankyou__container">

        <!-- Header -->
        <div class="woo-thankyou__header">
            <div class="woo-thankyou__icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <span
                class="woo-thankyou__kicker"><?php esc_html_e( 'Order Confirmed', 'velvet-chili-restaurant-shop' ); ?></span>
            <h1 class="woo-thankyou__title">
                <?php esc_html_e( 'Thank You for Your Order!', 'velvet-chili-restaurant-shop' ); ?></h1>
            <p class="woo-thankyou__subtitle">
                <?php esc_html_e( 'Your order has been received and is being prepared with care. We\'ll notify you when it\'s ready.', 'velvet-chili-restaurant-shop' ); ?>
            </p>
        </div>

        <!-- Order Items -->
        <div class="woo-thankyou__card">
            <h2 class="woo-thankyou__card-title"><?php esc_html_e( 'Items', 'velvet-chili-restaurant-shop' ); ?></h2>
            <div class="woo-thankyou__card-body">
                <?php
                $items = $order->get_items();
                foreach ( $items as $item_id => $item ) :
                    $product = $item->get_product();
                    if ( ! $product ) continue;
                    ?>
                <div class="woo-thankyou__order-item">
                    <div class="woo-thankyou__order-item-image">
                        <?php echo wp_kses_post( $product->get_image( 'thumbnail' ) ); ?>
                    </div>
                    <div class="woo-thankyou__order-item-details">
                        <h4 class="woo-thankyou__order-item-name"><?php echo esc_html( $item->get_name() ); ?></h4>
                        <div class="woo-thankyou__order-item-meta">
                            <?php echo wc_display_item_meta( $item, array( 'before' => '<p>', 'after' => '</p>' ) ); ?>
                            <span class="woo-thankyou__order-item-quantity">×
                                <?php echo esc_html( $item->get_quantity() ); ?></span>
                        </div>
                    </div>
                    <div class="woo-thankyou__order-item-price">
                        <?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Totals -->
                <div class="woo-thankyou__totals">
                    <?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
                    <?php if ( 'order_total' === $key ) : ?>
                    <div class="woo-thankyou__total-row woo-thankyou__total-row--total">
                        <span
                            class="woo-thankyou__total-label woo-thankyou__total-label--total"><?php echo esc_html( $total['label'] ); ?></span>
                        <span
                            class="woo-thankyou__total-value woo-thankyou__total-value--total"><?php echo wp_kses_post( $total['value'] ); ?></span>
                    </div>
                    <?php else : ?>
                    <div class="woo-thankyou__total-row">
                        <span class="woo-thankyou__total-label"><?php echo esc_html( $total['label'] ); ?></span>
                        <span class="woo-thankyou__total-value"><?php echo wp_kses_post( $total['value'] ); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Customer Details -->
        <?php if ( $order->get_billing_email() ) : ?>
        <div class="woo-thankyou__card">
            <h2 class="woo-thankyou__card-title">
                <?php esc_html_e( 'Customer Details', 'velvet-chili-restaurant-shop' ); ?></h2>
            <div class="woo-thankyou__card-body">
                <div class="woo-thankyou__customer-details">
                    <div>
                        <div class="woo-thankyou__customer-detail">
                            <span class="label"><?php esc_html_e( 'Email', 'velvet-chili-restaurant-shop' ); ?></span>
                            <span class="value"><?php echo esc_html( $order->get_billing_email() ); ?></span>
                        </div>
                        <div class="woo-thankyou__customer-detail">
                            <span class="label"><?php esc_html_e( 'Phone', 'velvet-chili-restaurant-shop' ); ?></span>
                            <span class="value"><?php echo esc_html( $order->get_billing_phone() ); ?></span>
                        </div>
                    </div>
                    <div>
                        <div class="woo-thankyou__customer-detail">
                            <span
                                class="label"><?php esc_html_e( 'Billing Address', 'velvet-chili-restaurant-shop' ); ?></span>
                            <span
                                class="value"><?php echo wp_kses_post( $order->get_formatted_billing_address() ); ?></span>
                        </div>
                        <?php if ( $order->get_shipping_address_1() ) : ?>
                        <div class="woo-thankyou__customer-detail">
                            <span
                                class="label"><?php esc_html_e( 'Shipping Address', 'velvet-chili-restaurant-shop' ); ?></span>
                            <span
                                class="value"><?php echo wp_kses_post( $order->get_formatted_shipping_address() ); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Actions -->
        <div class="woo-thankyou__actions">
            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn--primary">
                <?php esc_html_e( 'Continue Shopping →', 'velvet-chili-restaurant-shop' ); ?>
            </a>
            <?php if ( is_user_logged_in() ) : ?>
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="btn btn--outline-dark">
                <?php esc_html_e( 'View Your Orders', 'velvet-chili-restaurant-shop' ); ?>
            </a>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php do_action( 'woocommerce_thankyou', $order_id ); ?>