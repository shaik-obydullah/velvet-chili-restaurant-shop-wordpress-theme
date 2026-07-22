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