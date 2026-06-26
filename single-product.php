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

<style>
/* ======================================================
	   Single Product Page
	====================================================== */

.product-detail {
    width: 100%;
    padding: 6rem 1.5rem 4rem;
    background-color: var(--color-warm-white);
}

.product-detail__container {
    max-width: var(--container-max);
    margin: 0 auto;
}

.product-detail__back {
    display: inline-block;
    font-family: var(--font-body);
    font-size: 0.9rem;
    color: var(--color-text-secondary);
    margin-bottom: 2rem;
    transition: color var(--transition-fast);
}

.product-detail__back:hover {
    color: var(--color-chili-red);
}

.product-detail__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: flex-start;
}

/* Image Gallery */
.product-detail__image {
    background: white;
    border-radius: 12px;
    border: 1px solid var(--color-border);
    padding: 1rem;
    overflow: hidden;
}

.product-detail__image .woocommerce-product-gallery {
    position: relative;
}

.product-detail__image .woocommerce-product-gallery__trigger {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 10;
    background: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: background var(--transition-fast);
}

.product-detail__image .woocommerce-product-gallery__trigger:hover {
    background: var(--color-chili-red);
    color: white;
}

.product-detail__image .woocommerce-product-gallery__wrapper {
    border-radius: 8px;
    overflow: hidden;
}

.product-detail__image .flex-control-nav {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
    justify-content: center;
}

.product-detail__image .flex-control-nav li {
    list-style: none;
}

.product-detail__image .flex-control-nav img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: border-color var(--transition-fast);
}

.product-detail__image .flex-control-nav img:hover,
.product-detail__image .flex-control-nav img.flex-active {
    border-color: var(--color-chili-red);
}

/* Product Info */
.product-detail__info {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.product-detail__kicker {
    font-family: var(--font-body);
    font-size: 0.8rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--color-chili-red);
}

.product-detail__name {
    font-family: var(--font-heading);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: var(--color-soft-black);
    margin: 0;
    line-height: 1.2;
}

.product-detail__price {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--color-chili-red);
}

.product-detail__price .woocommerce-Price-amount {
    font-weight: 700;
}

.product-detail__description {
    font-family: var(--font-body);
    font-size: 1rem;
    line-height: 1.8;
    color: var(--color-text-secondary);
}

.product-detail__tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin: 0.5rem 0;
}

.product-detail__tags .tag {
    background: var(--color-cream);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--color-text-secondary);
}

/* Add to Cart */
.product-detail__add-to-cart .cart {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
}

.product-detail__add-to-cart .quantity {
    display: flex;
    align-items: center;
    border: 1px solid var(--color-border);
    border-radius: 6px;
    overflow: hidden;
    background: white;
}

.product-detail__add-to-cart .quantity .qty {
    width: 60px;
    text-align: center;
    border: none;
    padding: 0.6rem 0;
    font-family: var(--font-body);
    font-size: 1rem;
    background: transparent;
}

.product-detail__add-to-cart .quantity .qty:focus {
    outline: none;
}

.product-detail__add-to-cart .single_add_to_cart_button {
    padding: 0.8rem 2.5rem;
    background: var(--color-chili-red);
    color: white;
    border: none;
    border-radius: 6px;
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.product-detail__add-to-cart .single_add_to_cart_button:hover {
    background: var(--color-obydullah_restaurant-burgundy);
    transform: translateY(-2px);
}

.product-detail__add-to-cart .single_add_to_cart_button.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* Stock Status */
.stock-status {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.stock-status.in-stock {
    background: #e8f5e9;
    color: #2e7d32;
}

.stock-status.out-of-stock {
    background: #fce4ec;
    color: #c62828;
}

/* Chef's Note */
.product-detail__chef-note {
    background: var(--color-cream);
    padding: 1.25rem;
    border-radius: 8px;
    margin-top: 0.5rem;
}

.product-detail__chef-note h3 {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--color-soft-black);
    margin: 0 0 0.3rem;
}

.product-detail__chef-note p {
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: var(--color-text-secondary);
    margin: 0;
}

/* Product Tabs */
.product-tabs {
    width: 100%;
    padding: 0 1.5rem 4rem;
    background-color: var(--color-warm-white);
}

.product-tabs__container {
    max-width: var(--container-max);
    margin: 0 auto;
}

.product-tabs .wc-tabs {
    display: flex;
    border-bottom: 2px solid var(--color-border);
    padding: 0;
    margin: 0 0 2rem;
    list-style: none;
}

.product-tabs .wc-tabs li {
    margin: 0 1.5rem 0 0;
}

.product-tabs .wc-tabs li a {
    display: block;
    padding: 0.75rem 0;
    font-family: var(--font-body);
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-text-secondary);
    border-bottom: 2px solid transparent;
    transition: all var(--transition-fast);
    text-decoration: none;
}

.product-tabs .wc-tabs li.active a {
    color: var(--color-soft-black);
    border-bottom-color: var(--color-chili-red);
}

.product-tabs .wc-tabs li a:hover {
    color: var(--color-chili-red);
}

.product-tabs .panel {
    font-family: var(--font-body);
    font-size: 1rem;
    color: var(--color-text-secondary);
    line-height: 1.8;
}

/* Upsells & Related */
.upsells,
.related {
    padding: 3rem 1.5rem 4rem;
    background: var(--color-warm-white);
}

.upsells__container,
.related__container {
    max-width: var(--container-max);
    margin: 0 auto;
}

.upsells h2,
.related h2 {
    font-family: var(--font-heading);
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
    color: var(--color-soft-black);
    margin-bottom: 2rem;
}

.upsells .products,
.related .products {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 2rem;
}

/* Responsive */
@media screen and (max-width: 992px) {
    .product-detail__grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media screen and (max-width: 768px) {
    .product-detail {
        padding: 5rem 1rem 3rem;
    }

    .product-tabs {
        padding: 0 1rem 3rem;
    }

    .product-tabs .wc-tabs {
        flex-wrap: wrap;
    }

    .product-tabs .wc-tabs li {
        margin: 0 1rem 0 0;
    }

    .product-detail__add-to-cart .cart {
        flex-direction: column;
        align-items: stretch;
    }

    .product-detail__add-to-cart .single_add_to_cart_button {
        width: 100%;
    }
}

@media screen and (max-width: 480px) {

    .upsells .products,
    .related .products {
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
}
</style>

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