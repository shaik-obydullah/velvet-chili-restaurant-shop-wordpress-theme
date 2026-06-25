<?php
/**
 * Our Menu Section
 * Displays dynamic menu area (title + subtitle) if plugin active & CPT has posts.
 * Otherwise shows a static fallback.
 */

// ============================================================
// 1. Get Menu Area data (title + subtitle)
// ============================================================
$menu_area_data = array(
    'title'    => __( 'Signature Dishes', 'velvet-chili-restaurant-shop' ),
    'subtitle' => __( 'Every dish is a story of fire, spice, and slow‑crafted comfort.', 'velvet-chili-restaurant-shop' ),
);

$has_plugin = defined( 'OBIRSC_VERSION' );
$has_cpt    = post_type_exists( 'obirsc_menu_area' );

if ( $has_plugin && $has_cpt ) {
    $menu_area_posts = get_posts( array(
        'post_type'      => 'obirsc_menu_area',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ) );

    if ( ! empty( $menu_area_posts ) ) {
        $menu_area_post = $menu_area_posts[0];
        $menu_area_data['title'] = get_the_title( $menu_area_post );

        // Get subtitle meta
        $subtitle = get_post_meta( $menu_area_post->ID, 'obirsc_menu_area_subtitle', true );
        if ( $subtitle ) {
            $menu_area_data['subtitle'] = $subtitle;
        }
    }
}

// ============================================================
// 2. Define dummy items
// ============================================================
$dummy_items = array(
    array(
        'title'       => 'Smoked Ancho Ribeye',
        'price_html'  => '$48',
        'description' => '12‑hour chili‑cocoa rub, roasted bone marrow butter, grilled asparagus.',
        'image_url'   => get_template_directory_uri() . '/assets/images/about-2.jpg',
        'link'        => '#',
        'badge'       => 'Bestseller',
    ),
    array(
        'title'       => 'Velvet Braised Short Rib',
        'price_html'  => '$52',
        'description' => 'Guajillo & pasilla braise, creamy polenta, pickled red onion.',
        'image_url'   => get_template_directory_uri() . '/assets/images/about-3.jpg',
        'link'        => '#',
        'badge'       => 'Chef’s Pick',
    ),
);

// ============================================================
// 3. Get Menu Items data (product grid)
// ============================================================
$has_items = false;
$menu_item_query = null;
$display_items = array();

// Check if plugin is active and CPT exists
$has_plugin_items = defined( 'OBIRSC_VERSION' );
$has_cpt_items    = post_type_exists( 'obirsc_menu_item' );

// Only run query if plugin and CPT are available
if ( $has_plugin_items && $has_cpt_items ) {
    $menu_item_query = new WP_Query( array(
        'post_type'      => 'obirsc_menu_item',
        'posts_per_page' => 4,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ) );
    $has_items = $menu_item_query->have_posts();
}

if ( $has_plugin_items && $has_cpt_items && $has_items ) {
    // Build display items from linked products
    while ( $menu_item_query->have_posts() ) {
        $menu_item_query->the_post();
        $product_id = intval( get_post_meta( get_the_ID(), '_obirsc_woo_product_id', true ) );

        if ( ! $product_id || ! class_exists( 'WooCommerce' ) ) {
            continue;
        }

        $product = wc_get_product( $product_id );
        if ( ! $product ) {
            continue;
        }

        $display_items[] = array(
            'title'       => $product->get_name(),
            'price_html'  => $product->get_price_html(),
            'description' => $product->get_short_description(),
            'image_url'   => wp_get_attachment_image_url( $product->get_image_id(), 'medium' ) ?: wc_placeholder_img_src( 'medium' ),
            'link'        => get_permalink( $product_id ),
            'badge'       => $product->is_on_sale() ? __( 'Sale', 'velvet-chili-restaurant-shop' ) :
                             ( $product->is_featured() ? __( 'Featured', 'velvet-chili-restaurant-shop' ) : '' ),
        );
    }
}

// Determine which items to display
$grid_items = ! empty( $display_items ) ? $display_items : $dummy_items;

// Determine "View Full Menu" link
$menu_link = class_exists( 'WooCommerce' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '/menu';
?>

<!-- ============================================================
     OUR MENU SECTION
============================================================ -->
<section class="woo-products" id="ourMenu">
    <div class="woo-products__container">
        <div class="woo-products__header">
            <span
                class="woo-products__kicker"><?php esc_html_e( 'From Our Kitchen', 'velvet-chili-restaurant-shop' ); ?></span>
            <h2 class="woo-products__title"><?php echo esc_html( $menu_area_data['title'] ); ?></h2>
            <p class="woo-products__subtitle"><?php echo esc_html( $menu_area_data['subtitle'] ); ?></p>
        </div>

        <!-- Product grid -->
        <div class="woo-products__grid">
            <?php foreach ( $grid_items as $item ) : ?>
            <div class="product-card">
                <div class="product-card__image">
                    <?php if ( ! empty( $item['badge'] ) ) : ?>
                    <span class="product-card__badge"><?php echo esc_html( $item['badge'] ); ?></span>
                    <?php endif; ?>
                    <img src="<?php echo esc_url( $item['image_url'] ); ?>"
                        alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy">
                </div>
                <div class="product-card__content">
                    <h3 class="product-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
                    <div class="product-card__price"><?php echo wp_kses_post( $item['price_html'] ); ?></div>
                    <p class="product-card__description"><?php echo wp_kses_post( $item['description'] ); ?></p>
                    <a href="<?php echo esc_url( $item['link'] ); ?>" class="product-card__btn">
                        <?php esc_html_e( 'View Details', 'velvet-chili-restaurant-shop' ); ?>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Call to Action -->
        <div class="woo-products__cta">
            <a href="<?php echo esc_url( $menu_link ); ?>" class="nav__link--cta">
                <?php esc_html_e( 'View Full Menu', 'velvet-chili-restaurant-shop' ); ?>
            </a>
        </div>
    </div>
</section>

<?php
// Clean up
if ( isset( $menu_item_query ) && $menu_item_query instanceof WP_Query ) {
    wp_reset_postdata();
}