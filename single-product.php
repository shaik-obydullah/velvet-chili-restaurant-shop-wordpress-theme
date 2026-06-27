<?php
/**
 * Single Product Page
 *
 * @package Velvet_Chili_Restaurant_Shop
 * @since   1.0.0
 */

get_header();

while ( have_posts() ) {
	the_post();

	global $product;
	if ( ! $product ) {
		$product = wc_get_product( get_the_ID() );
	}

	do_action( 'woocommerce_before_single_product' );

	if ( post_password_required() ) {
		echo get_the_password_form();
		continue;
	}
	?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

    <section class="product-detail">
        <div class="product-detail__container">

            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="product-detail__back">
                <i class="fa-solid fa-arrow-left"></i>
                <?php esc_html_e( 'Back to Menu', 'velvet-chili-restaurant-shop' ); ?>
            </a>

            <div class="product-detail__grid">

                <!-- Product Image -->
                <div class="product-detail__image">
                    <?php woocommerce_show_product_images(); ?>
                </div>

                <!-- Product Info -->
                <div class="product-detail__info">

                    <?php
						$cats = wc_get_product_category_list( $product->get_id() );
						if ( $cats ) :
							?>
                    <span class="product-detail__kicker"><?php echo wp_kses_post( $cats ); ?></span>
                    <?php endif; ?>

                    <h1 class="product-detail__name"><?php the_title(); ?></h1>

                    <div class="product-detail__price">
                        <?php woocommerce_template_single_price(); ?>
                    </div>

                    <?php if ( $product->is_in_stock() ) : ?>
                    <span
                        class="stock-status in-stock"><?php esc_html_e( 'In Stock', 'velvet-chili-restaurant-shop' ); ?></span>
                    <?php else : ?>
                    <span
                        class="stock-status out-of-stock"><?php esc_html_e( 'Out of Stock', 'velvet-chili-restaurant-shop' ); ?></span>
                    <?php endif; ?>

                    <div class="product-detail__description">
                        <?php woocommerce_template_single_excerpt(); ?>
                    </div>

                    <?php
						$tags = get_the_terms( $product->get_id(), 'product_tag' );
						if ( $tags && ! is_wp_error( $tags ) ) :
							?>
                    <div class="product-detail__tags">
                        <?php foreach ( $tags as $tag ) : ?>
                        <span class="tag"><?php echo esc_html( $tag->name ); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="product-detail__add-to-cart">
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    </div>

                    <?php
						$chef_note = get_post_meta( $product->get_id(), 'chef_note', true );
						if ( $chef_note ) :
							?>
                    <div class="product-detail__chef-note">
                        <h3><?php esc_html_e( 'Chef\'s Note', 'velvet-chili-restaurant-shop' ); ?></h3>
                        <p><?php echo esc_html( $chef_note ); ?></p>
                    </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>
    </section>

    <!-- Product Tabs -->
    <section class="product-tabs">
        <div class="product-tabs__container">
            <?php woocommerce_output_product_data_tabs(); ?>
        </div>
    </section>

    <!-- Upsells & Related -->
    <?php
		woocommerce_upsell_display();
		woocommerce_output_related_products();


		?>

</div>

<?php
	do_action( 'woocommerce_after_single_product' );
}

get_footer();