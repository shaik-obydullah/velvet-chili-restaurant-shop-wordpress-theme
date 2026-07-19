<?php
/**
 * Template Name: Our Menu (Shop Page)
 * Description: Dynamic product listing with category filters, AJAX add-to-cart, and pagination.
 */

get_header();

if ( ! class_exists( 'WooCommerce' ) ) {
    echo '<div class="menu-page" style="padding:6rem 1.5rem 3rem;text-align:center;">';
    echo '<h2>' . esc_html__( 'This page requires WooCommerce.', 'velvet-chili-restaurant-shop' ) . '</h2>';
    echo '<p>' . esc_html__( 'Please install and activate the WooCommerce plugin to view the menu.', 'velvet-chili-restaurant-shop' ) . '</p>';
    echo '</div>';
    get_footer();
    return;
}

// Get product categories (only those with products)
$categories = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
) );

// Current filters
$selected_cat  = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : 'all';
$selected_sort = isset( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'default';

// Pagination
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

// Product query
$query_args = array(
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'paged'          => $paged,
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
    default:
        $query_args['orderby'] = 'menu_order';
        $query_args['order']   = 'ASC';
}

$products = new WP_Query( $query_args );

// Base URL for filter links
$base_url = remove_query_arg( array( 'category', 'sort', 'paged' ) );
?>

<section class="menu-page">
  <div class="menu-page__container">

    <!-- Header -->
    <div class="menu-page__header text-center">
      <span class="menu-page__kicker">From Our Kitchen</span>
      <h2 class="menu-page__title">The Velvet Chili Menu</h2>
      <p class="menu-page__subtitle">
        Every dish celebrates the chili in all its forms – smoked, dried, fresh, and roasted.
      </p>
    </div>

    <!-- Filter Buttons -->
    <div class="filter-bar" id="menuFilter">
      <a href="<?php echo esc_url( add_query_arg( array( 'category' => 'all', 'paged' => 1 ), $base_url ) ); ?>"
         class="filter-btn <?php echo ( 'all' === $selected_cat ) ? 'filter-btn--active' : ''; ?>"
         data-filter="all">All</a>
      <?php foreach ( $categories as $cat ) : ?>
        <a href="<?php echo esc_url( add_query_arg( array( 'category' => $cat->slug, 'paged' => 1 ), $base_url ) ); ?>"
           class="filter-btn <?php echo ( $selected_cat === $cat->slug ) ? 'filter-btn--active' : ''; ?>"
           data-filter="<?php echo esc_attr( $cat->slug ); ?>">
          <?php echo esc_html( $cat->name ); ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Sort Controls -->
    <form method="get" class="menu-page__sort">
      <?php if ( ! empty( $selected_cat ) && 'all' !== $selected_cat ) : ?>
        <input type="hidden" name="category" value="<?php echo esc_attr( $selected_cat ); ?>">
      <?php endif; ?>
      <label for="sortSelect" class="menu-page__sort-label">Sort:</label>
      <select name="sort" id="sortSelect" class="menu-page__sort-select" onchange="this.form.submit()">
        <option value="default" <?php selected( $selected_sort, 'default' ); ?>>Default</option>
        <option value="price_low" <?php selected( $selected_sort, 'price_low' ); ?>>Price: Low to High</option>
        <option value="price_high" <?php selected( $selected_sort, 'price_high' ); ?>>Price: High to Low</option>
      </select>
      <span class="menu-page__results">
        <?php
        printf(
          esc_html( _n( 'Showing %d result', 'Showing %d results', $products->found_posts, 'velvet-chili-restaurant-shop' ) ),
          $products->found_posts
        );
        ?>
      </span>
    </form>

    <!-- Products Grid -->
    <div class="products-grid" id="menuGrid">
      <?php if ( $products->have_posts() ) : ?>
        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
          <?php
          global $product;
          if ( ! $product ) continue;

          $badge = '';
          if ( $product->is_on_sale() ) {
            $badge = __( 'Sale', 'velvet-chili-restaurant-shop' );
          } elseif ( $product->is_featured() ) {
            $badge = __( 'Featured', 'velvet-chili-restaurant-shop' );
          }
          ?>
          <div class="product-card">
            <div class="product-card__image">
              <?php if ( $badge ) : ?>
                <span class="product-card__badge"><?php echo esc_html( $badge ); ?></span>
              <?php endif; ?>
              <a href="<?php the_permalink(); ?>">
                <?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
              </a>
            </div>
            <div class="product-card__info">
              <h3 class="product-card__name">
                <a href="<?php the_permalink(); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
              </h3>
              <span class="product-card__price"><?php echo $product->get_price_html(); ?></span>
              <a href="?add-to-cart=<?php echo $product->get_id(); ?>"
                 data-quantity="1"
                 class="button product_type_simple add_to_cart_button ajax_add_to_cart product-card__add-to-cart"
                 data-product_id="<?php echo $product->get_id(); ?>"
                 aria-label="Add to cart"
                 rel="nofollow"
                 data-success_message="Added to cart">
                Add to Cart
                <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <p class="menu-page__empty">No products found.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ( $products->max_num_pages > 1 ) : ?>
      <div class="menu-page__pagination">
        <?php
        $pagination_args = array(
          'total'     => $products->max_num_pages,
          'current'   => $paged,
          'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
          'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
          'type'      => 'list',
          'add_args'  => array_filter( array(
            'category' => ( 'all' !== $selected_cat ) ? $selected_cat : false,
            'sort'     => ( 'default' !== $selected_sort ) ? $selected_sort : false,
          ) ),
        );
        echo paginate_links( $pagination_args );
        ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var filterBtns = document.querySelectorAll('.filter-btn');
  filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      filterBtns.forEach(function(b) { b.classList.remove('filter-btn--active'); });
      this.classList.add('filter-btn--active');
    });
  });
});
</script>

<?php get_footer(); ?>
