<?php
/**
 * Checkout Page - Velvet Chili Restaurant Shop
 */

defined( 'ABSPATH' ) || exit;

// Coupon form is rendered inline below (moved from woocommerce_before_checkout_form)
?>



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