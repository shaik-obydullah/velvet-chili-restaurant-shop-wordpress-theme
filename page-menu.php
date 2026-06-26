<?php
/**
 * Template Name: Our Menu (Shop Page)
 * Description: Dynamic product listing with WooCommerce filters + grid.
 */

get_header();

// Get product categories
$categories = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
) );

// Current filters
$selected_cat  = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : '';
$selected_sort = isset( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'default';
$price_range   = isset( $_GET['price'] ) ? sanitize_text_field( $_GET['price'] ) : '';

// Product query
$query_args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
);

// Category filter
if ( ! empty( $selected_cat ) && 'all' !== $selected_cat ) {
    $query_args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $selected_cat,
        ),
    );
}

// Price filter
if ( ! empty( $price_range ) ) {
    $price_parts = explode( '-', $price_range );
    if ( count( $price_parts ) === 2 ) {
        $query_args['meta_query'] = array(
            array(
                'key'     => '_price',
                'value'   => array( (float) $price_parts[0], (float) $price_parts[1] ),
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
            ),
        );
    } elseif ( false !== strpos( $price_range, '+' ) ) {
        $min = (float) str_replace( '+', '', $price_range );
        $query_args['meta_query'] = array(
            array(
                'key'     => '_price',
                'value'   => $min,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            ),
        );
    }
}

// Sort
switch ( $selected_sort ) {
    case 'price_low':
        $query_args['meta_key'] = '_price';
        $query_args['orderby']  = 'meta_value_num';
        $query_args['order']    = 'ASC';
        break;
    case 'price_high':
        $query_args['meta_key'] = '_price';
        $query_args['orderby']  = 'meta_value_num';
        $query_args['order']    = 'DESC';
        break;
    case 'popularity':
        $query_args['meta_key'] = 'total_sales';
        $query_args['orderby']  = 'meta_value_num';
        $query_args['order']    = 'DESC';
        break;
    default:
        $query_args['orderby'] = 'menu_order';
        $query_args['order']   = 'ASC';
}

$products      = new WP_Query( $query_args );
$total_results = $products->post_count;

// Base URL for filter links (preserves existing params)
$base_url = remove_query_arg( array( 'category', 'sort', 'price' ) );
?>

<main class="our-menu-page">
    <div class="shop-filters">
        <div class="shop-filters__container">
            <div class="filter-categories-wrapper">
                <span class="filter-label"><?php esc_html_e( 'Browse:', 'velvet-chili-restaurant-shop' ); ?></span>
                <div class="filter-categories">
                    <a href="<?php echo esc_url( add_query_arg( 'category', 'all', $base_url ) ); ?>"
                       class="filter-category <?php echo ( empty( $selected_cat ) || 'all' === $selected_cat ) ? 'active' : ''; ?>">
                        <?php esc_html_e( 'All', 'velvet-chili-restaurant-shop' ); ?>
                    </a>
                    <?php foreach ( $categories as $cat ) : ?>
                        <a href="<?php echo esc_url( add_query_arg( 'category', $cat->slug, $base_url ) ); ?>"
                           class="filter-category <?php echo ( $selected_cat === $cat->slug ) ? 'active' : ''; ?>">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <form method="get" class="filter-controls">
                <?php if ( ! empty( $selected_cat ) && 'all' !== $selected_cat ) : ?>
                    <input type="hidden" name="category" value="<?php echo esc_attr( $selected_cat ); ?>">
                <?php endif; ?>
                <div class="filter-select-group">
                    <span class="filter-label"><?php esc_html_e( 'Sort:', 'velvet-chili-restaurant-shop' ); ?></span>
                    <select name="sort" class="filter-select" onchange="this.form.submit()">
                        <option value="default" <?php selected( $selected_sort, 'default' ); ?>><?php esc_html_e( 'Default', 'velvet-chili-restaurant-shop' ); ?></option>
                        <option value="price_low" <?php selected( $selected_sort, 'price_low' ); ?>><?php esc_html_e( 'Price: Low to High', 'velvet-chili-restaurant-shop' ); ?></option>
                        <option value="price_high" <?php selected( $selected_sort, 'price_high' ); ?>><?php esc_html_e( 'Price: High to Low', 'velvet-chili-restaurant-shop' ); ?></option>
                        <option value="popularity" <?php selected( $selected_sort, 'popularity' ); ?>><?php esc_html_e( 'Popularity', 'velvet-chili-restaurant-shop' ); ?></option>
                    </select>
                </div>
                <div class="filter-select-group">
                    <span class="filter-label"><?php esc_html_e( 'Price:', 'velvet-chili-restaurant-shop' ); ?></span>
                    <select name="price" class="filter-select" onchange="this.form.submit()">
                        <option value="" <?php selected( $price_range, '' ); ?>><?php esc_html_e( 'All', 'velvet-chili-restaurant-shop' ); ?></option>
                        <option value="0-25" <?php selected( $price_range, '0-25' ); ?>>$0 – $25</option>
                        <option value="25-50" <?php selected( $price_range, '25-50' ); ?>>$25 – $50</option>
                        <option value="50+" <?php selected( $price_range, '50+' ); ?>>$50+</option>
                    </select>
                </div>
                <div class="results-count">
                    <?php
                    printf(
                        esc_html( _n( 'Showing %d result', 'Showing %d results', $total_results, 'velvet-chili-restaurant-shop' ) ),
                        $total_results
                    );
                    ?>
                </div>
            </form>
        </div>
    </div>

    <section class="woo-products">
        <div class="woo-products__container">
            <div class="woo-products__header">
                <span class="woo-products__kicker"><?php esc_html_e( 'From Our Kitchen', 'velvet-chili-restaurant-shop' ); ?></span>
                <h2 class="woo-products__title"><?php esc_html_e( 'Signature Dishes', 'velvet-chili-restaurant-shop' ); ?></h2>
                <p class="woo-products__subtitle">
                    <?php esc_html_e( 'Every dish is a story of fire, spice, and slow‑crafted comfort.', 'velvet-chili-restaurant-shop' ); ?>
                </p>
            </div>

            <?php if ( $products->have_posts() ) : ?>
                <div class="woo-products__grid">
                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                        <?php
                        global $product;
                        if ( ! $product ) {
                            continue;
                        }

                        // Badge logic
                        $badge = '';
                        $product_tags = wp_get_post_terms( $product->get_id(), 'product_tag' );
                        foreach ( $product_tags as $tag ) {
                            $badge = $tag->name;
                            break;
                        }
                        if ( ! $badge && $product->is_featured() ) {
                            $badge = __( "Chef's Pick", 'velvet-chili-restaurant-shop' );
                        }
                        if ( ! $badge && $product->is_on_sale() ) {
                            $badge = __( 'Special', 'velvet-chili-restaurant-shop' );
                        }

                        $image       = $product->get_image( 'woocommerce_thumbnail' );
                        $price       = $product->get_price_html();
                        $description = $product->get_short_description();
                        $link        = $product->get_permalink();
                        ?>
                        <div class="product-card">
                            <div class="product-card__image">
                                <?php if ( $badge ) : ?>
                                    <span class="product-card__badge"><?php echo esc_html( $badge ); ?></span>
                                <?php endif; ?>
                                <?php echo $image; ?>
                            </div>
                            <div class="product-card__content">
                                <h3 class="product-card__title"><?php echo esc_html( $product->get_name() ); ?></h3>
                                <div class="product-card__price"><?php echo $price; ?></div>
                                <?php if ( $description ) : ?>
                                    <p class="product-card__description"><?php echo esc_html( $description ); ?></p>
                                <?php endif; ?>
                                <a href="<?php echo esc_url( $link ); ?>" class="product-card__btn">
                                    <?php esc_html_e( 'View Details', 'velvet-chili-restaurant-shop' ); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <p class="woo-products__empty">
                    <?php esc_html_e( 'No dishes found. Try a different category.', 'velvet-chili-restaurant-shop' ); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
