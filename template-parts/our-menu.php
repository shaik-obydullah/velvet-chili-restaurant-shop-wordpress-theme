<?php
/**
 * Template Part: Signature Dishes Grid
 * Pure dummy content – no WooCommerce required.
 */

// Dummy product data – edit freely for design iterations
$products = array(
    array(
        'title'       => 'Smoked Ancho Ribeye',
        'price'       => '$48',
        'description' => '12‑hour chili‑cocoa rub, roasted bone marrow butter, grilled asparagus.',
        'image'       => get_template_directory_uri() . '/assets/images/dish-ribeye.jpg',
        'badge'       => 'Bestseller',
        'link'        => '#',
    ),
    array(
        'title'       => 'Velvet Braised Short Rib',
        'price'       => '$52',
        'description' => 'Guajillo & pasilla braise, creamy polenta, pickled red onion.',
        'image'       => get_template_directory_uri() . '/assets/images/dish-shortrib.jpg',
        'badge'       => 'Chef’s Pick',
        'link'        => '#',
    ),
    array(
        'title'       => 'Fire‑Roasted Poblano Relleno',
        'price'       => '$38',
        'description' => 'Oaxaca cheese, smoky tomato salsa, cilantro lime crema.',
        'image'       => get_template_directory_uri() . '/assets/images/dish-relleno.jpg',
        'badge'       => 'Vegetarian',
        'link'        => '#',
    ),
    array(
        'title'       => 'Chili Chocolate Tart',
        'price'       => '$18',
        'description' => 'Dark ganache with ancho heat, candied orange, vanilla bean ice cream.',
        'image'       => get_template_directory_uri() . '/assets/images/dish-tart.jpg',
        'badge'       => 'Sweet Heat',
        'link'        => '#',
    ),
);
?>

<!-- ========== SIGNATURE DISHES SECTION (PURE DUMMY) ========== -->
<section class="woo-products">
    <div class="woo-products__container">
        <!-- Section header -->
        <div class="woo-products__header">
            <span class="woo-products__kicker">From Our Kitchen</span>
            <h2 class="woo-products__title">Signature Dishes</h2>
            <p class="woo-products__subtitle">
                Every dish is a story of fire, spice, and slow‑crafted comfort.
            </p>
        </div>

        <!-- Product grid -->
        <div class="woo-products__grid">
            <?php foreach ( $products as $product ) : ?>
            <div class="product-card">
                <div class="product-card__image">
                    <?php if ( ! empty( $product['badge'] ) ) : ?>
                    <span class="product-card__badge"><?php echo esc_html( $product['badge'] ); ?></span>
                    <?php endif; ?>
                    <img src="<?php echo esc_url( $product['image'] ); ?>"
                        alt="<?php echo esc_attr( $product['title'] ); ?>" loading="lazy">
                </div>
                <div class="product-card__content">
                    <h3 class="product-card__title"><?php echo esc_html( $product['title'] ); ?></h3>
                    <div class="product-card__price"><?php echo esc_html( $product['price'] ); ?></div>
                    <p class="product-card__description"><?php echo esc_html( $product['description'] ); ?></p>
                    <a href="<?php echo esc_url( $product['link'] ); ?>" class="product-card__btn">
                        View Details
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Call to Action -->
        <div class="woo-products__cta">
            <a href="/menu" class="btn">
                View Full Menu
            </a>
        </div>
    </div>
</section>