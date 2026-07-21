<?php
/*
 * =================================================================
 * Theme Name: Velvet Chili Restaurant Shop
 * Version: 1.0.0
 * Author: Shaik Obydullah
 * Author URI: https://obydullah.com
 * Purpose: Velvet Chili Restaurant Shop Theme Functions
 * =================================================================
 */

/**
 * INDEX
 * 1. Assets
 * 2. Theme Setup
 * 3. Menus
 * 4. Fallback Menus
 * 5. WooCommerce: Remove default single-product hooks
 * 6. Cart
 * 7. Customizer Settings
 * 8. Admin Notice
 */

/* ======================================================
   1. Assets
====================================================== */

function vcrs_assets() {
    wp_enqueue_style(
        'font-awesome',
        get_template_directory_uri() . '/assets/vendor/fontawesome/css/all.min.css',
        [],
        '7.2.0'
    );

    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'vcrs-base',
        get_template_directory_uri() . '/assets/css/base.css',
        [],
        '1.0'
    );

    wp_enqueue_style(
        'vcrs-theme',
        get_template_directory_uri() . '/assets/css/theme.css',
        ['vcrs-base'],
        '1.1'
    );

    wp_enqueue_script(
        'vcrs-js',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'vcrs_assets');

add_action( 'wp_enqueue_scripts', function() {
	if ( class_exists( 'WooCommerce' ) && is_product() && wp_script_is( 'wc-add-to-cart', 'enqueued' ) ) {
		wp_add_inline_script( 'wc-add-to-cart', '
jQuery(function($) {
  $("form.cart").on("submit", function(e) {
    var $btn = $(this).find(".single_add_to_cart_button.ajax_add_to_cart");
    if (!$btn.length) return;
    e.preventDefault();
    var data = {
      product_id: $btn.data("product_id"),
      quantity:   $(this).find("input[name=\"quantity\"]").val() || 1
    };
    $btn.removeClass("added").addClass("loading");
    $.post(wc_add_to_cart_params.wc_ajax_url.toString().replace("%%endpoint%%","add_to_cart"), data)
      .done(function(r) {
        $btn.removeClass("loading");
        if (r.error && r.product_url) { window.location = r.product_url; return; }
        $(document.body).trigger("added_to_cart", [r.fragments, r.cart_hash, $btn]);
      });
  });
});
' );
	}
} );

function vcrs_enqueue_booking_assets() {
    wp_enqueue_script(
        'vcrs-booking',                        
        get_template_directory_uri() . '/assets/js/booking.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );

    wp_localize_script( 'vcrs-booking', 'obirsc_booking_nonce', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'vcrs_enqueue_booking_assets' );


/* ======================================================
   2. Theme Setup
====================================================== */
function vcrs_setup() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'velvet-chili-restaurant-shop' ),
    ) );
}
add_action( 'after_setup_theme', 'vcrs_setup' );


/**
 * Prevent WooCommerce default order details table from appearing
 * after the custom thank you template.
 */
add_action( 'init', function() {
    if ( class_exists( 'WooCommerce' ) ) {
        remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
    }
} );

/* ======================================================
 *  3. Menus
 * ====================================================== */

/**
 * Retrieve menu items for a given location.
 *
 * @param string $location Theme menu location (e.g., 'primary').
 * @return array|false Array of menu items or false on failure.
 */
function vcrs_get_nav_menu_items( $location ) {
    $menu_locations = get_nav_menu_locations();
    if ( empty( $menu_locations[ $location ] ) ) {
        return false;
    }

    $menu = wp_get_nav_menu_object( $menu_locations[ $location ] );
    if ( ! $menu ) {
        return false;
    }

    $items = wp_get_nav_menu_items( $menu->term_id );
    return $items ? $items : false;
}

/**
 * Check if a menu item should be marked as active.
 *
 * @param object $item Menu item object.
 * @return bool
 */
function vcrs_is_menu_item_active( $item ) {
    // Get current URL without query args for comparison
    $current_url = untrailingslashit( home_url( add_query_arg( array(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) );
    $item_url    = untrailingslashit( $item->url );

    // If it's the front page
    if ( $item_url === home_url() && is_front_page() ) {
        return true;
    }

    // For internal links, compare the full URL
    return $item_url === $current_url;
}

/**
 * Render menu items as list items with appropriate classes.
 *
 * @param string $location      Menu location.
 * @param string $class_prefix  CSS class prefix (e.g. 'nav', 'mobile-nav').
 * @return bool True if menu was rendered, false otherwise.
 */
function vcrs_render_menu_items( $location, $class_prefix ) {
    $items = vcrs_get_nav_menu_items( $location );
    if ( ! $items ) {
        return false;
    }

    foreach ( $items as $item ) {
        $is_active = vcrs_is_menu_item_active( $item ) ? ' ' . $class_prefix . '__link--active' : '';
        printf(
            '<li class="%s__item"><a href="%s" class="%s__link%s">%s</a></li>',
            esc_attr( $class_prefix ),
            esc_url( $item->url ),
            esc_attr( $class_prefix ),
            esc_attr( $is_active ),
            esc_html( $item->title )
        );
    }

    return true;
}

/**
 * Main function to be used in the template – renders either the WordPress menu
 * or the fallback.
 *
 * @param string $location      Menu location.
 * @param string $class_prefix  CSS prefix.
 * @param string $fallback      Name of the fallback function.
 */
function vcrs_render_nav_menu( $location, $class_prefix, $fallback ) {
    $rendered = vcrs_render_menu_items( $location, $class_prefix );
    if ( ! $rendered && function_exists( $fallback ) ) {
        call_user_func( $fallback );
    }
}

/* ======================================================
 *  4. Fallback Menus
 * ====================================================== */

/**
 * Fallback for desktop primary menu (used when no menu is assigned).
 */
function vcrs_primary_menu_fallback() {
    $home = home_url( '/' );
    $links = [
        'Home'         => $home,
        'Chef Special' => $home . '#chefSpecial',
        'Our Menu'     => $home . '#ourMenu',
        'Testimonials' => $home . '#testimonials',
        'Book A Table' => $home . '#book',
    ];
    ?>
<?php foreach ( $links as $label => $url ) : ?>
<li class="nav__item">
    <a href="<?php echo esc_url( $url ); ?>"
        class="nav__link<?php echo ( $url === home_url( '/' ) && is_front_page() ) ? ' nav__link--active' : ''; ?>">
        <?php echo esc_html( $label ); ?>
    </a>
</li>
<?php endforeach; ?>
<?php
}

/**
 * Fallback for mobile menu (used when no menu is assigned).
 */
function vcrs_mobile_menu_fallback() {
    $home = home_url( '/' );
    $links = [
        'Home'         => $home,
        'Chef Special' => $home . '#chefSpecial',
        'Our Menu'     => $home . '#ourMenu',
        'Testimonials' => $home . '#testimonials',
        'Book A Table' => $home . '#book',
    ];
    ?>
<?php foreach ( $links as $label => $url ) : ?>
<li class="mobile-nav__item">
    <a href="<?php echo esc_url( $url ); ?>"
        class="mobile-nav__link<?php echo ( $url === home_url( '/' ) && is_front_page() ) ? ' mobile-nav__link--active' : ''; ?>">
        <?php echo esc_html( $label ); ?>
    </a>
</li>
<?php endforeach; ?>
<?php
}

/* ======================================================
 *  5. Cart
 * ====================================================== */

/**
 * Create Cart page on theme switch if it doesn't exist.
 */
function vcrs_create_cart_page() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }
    
    $cart_page_id = wc_get_page_id( 'cart' );
    
    if ( ! $cart_page_id || get_post_status( $cart_page_id ) !== 'publish' ) {
        $cart_page = array(
            'post_title'   => __( 'Cart', 'velvet-chili-restaurant-shop' ),
            'post_content' => '[woocommerce_cart]',
            'post_status'  => 'publish',
            'post_type'    => 'page',
        );
        
        $new_page_id = wp_insert_post( $cart_page );
        
        if ( $new_page_id && ! is_wp_error( $new_page_id ) ) {
            update_option( 'woocommerce_cart_page_id', $new_page_id );
        }
    }
}
add_action( 'after_switch_theme', 'vcrs_create_cart_page' );

/**
 * Render cart icon with count and total.
 */
function vcrs_render_cart() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        ?>
<div class="header-cart">
    <a href="#" class="cart-link" aria-label="Shopping cart" style="opacity:0.4; pointer-events:none;">
        <i class="fa-solid fa-bag-shopping cart-icon"></i>
        <span class="cart-count">0</span>
        <span class="cart-total">$0.00</span>
    </a>
</div>
<?php
        return;
    }
    ?>
<div class="header-cart">
    <?php 
        $cart_url   = wc_get_cart_url();
        $cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
        $cart_total = WC()->cart ? WC()->cart->get_cart_subtotal() : '$0.00';
        ?>
    <a href="<?php echo esc_url( $cart_url ); ?>" class="cart-link" aria-label="Shopping cart">
        <i class="fa-solid fa-bag-shopping cart-icon"></i>
        <span class="cart-count"><?php echo esc_html( $cart_count ); ?></span>
        <span class="cart-total"><?php echo wp_kses_post( $cart_total ); ?></span>
    </a>
</div>
<?php
}

/**
 * AJAX cart fragments for real-time updates.
 */
if ( class_exists( 'WooCommerce' ) ) {
    add_filter( 'woocommerce_add_to_cart_fragments', 'vcrs_cart_fragments' );
    add_filter( 'woocommerce_product_tabs', 'vcrs_product_tabs' );
}

function vcrs_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}

function vcrs_cart_fragments( $fragments ) {
    if ( class_exists( 'WooCommerce' ) && WC()->cart ) {
        $fragments['.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
        $fragments['.cart-total'] = '<span class="cart-total">' . WC()->cart->get_cart_subtotal() . '</span>';
    } else {
        $fragments['.cart-count'] = '<span class="cart-count">0</span>';
        $fragments['.cart-total'] = '<span class="cart-total">$0.00</span>';
    }
    return $fragments;
}

/**
 * Redirect /shop to /menu so the default WooCommerce shop
 * archive is never accessed directly.
 */
add_action( 'template_redirect', function() {
    if ( class_exists( 'WooCommerce' ) && is_shop() ) {
        wp_redirect( home_url( '/menu/' ), 301 );
        exit;
    }
} );

/* ======================================================
 *  6. Customizer Settings
 * ====================================================== */

function vcrs_customize_register($wp_customize) {

    $wp_customize->add_section('vcrs_contact_info', [
        'title'    => __('Contact Info', 'velvet-chili-restaurant-shop'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('vcrs_phone', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('vcrs_phone', [
        'label'   => __('Phone Number', 'velvet-chili-restaurant-shop'),
        'section' => 'vcrs_contact_info',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('vcrs_hours', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('vcrs_hours', [
        'label'   => __('Opening Hours', 'velvet-chili-restaurant-shop'),
        'section' => 'vcrs_contact_info',
        'type'    => 'text',
    ]);
}
add_action('customize_register', 'vcrs_customize_register');


/* ======================================================
 *  7. Admin Notice
 * ====================================================== */
function vcrs_admin_notice() {
    if ( ! function_exists( 'get_current_screen' ) ) {
        return;
    }

    $screen = get_current_screen();

    if ( ! $screen || $screen->base !== 'themes' ) {
        return;
    }

    $core_active = defined( 'OBIRSC_VERSION' );
    $cf7_active  = defined( 'WPCF7_VERSION' );

    if ( $core_active && $cf7_active ) {
        return;
    }
    ?>
<div class="notice notice-info is-dismissible">
    <p><strong><?php esc_html_e( 'Obydullah Restaurant Theme', 'velvet-chili-restaurant-shop' ); ?></strong> —
        <?php esc_html_e( 'Install recommended plugins:', 'velvet-chili-restaurant-shop' ); ?></p>
    <ul style="list-style: disc; margin-left: 1.5em;">
        <?php if ( ! $core_active ) : ?>
        <li>
            <strong>
                <a href="<?php echo esc_url( 'https://wordpress.org/plugins/obydullah-restaurant-shop-core/' ); ?>"
                    target="_blank" rel="noopener noreferrer">
                    Obydullah Restaurant Shop Core
                </a>
            </strong>
            –
            <?php esc_html_e( 'menu & testimonials system', 'velvet-chili-restaurant-shop' ); ?>
        </li>
        <?php endif; ?>
        <?php if ( ! $cf7_active ) : ?>
        <li><strong>Contact Form 7</strong> –
            <?php esc_html_e( 'contact form support', 'velvet-chili-restaurant-shop' ); ?></li>
        <?php endif; ?>
    </ul>
    <p>
        <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=obydullah+restaurant+core&tab=search&type=term' ) ); ?>"
            class="button button-primary">
            <?php esc_html_e( 'Install Plugins', 'velvet-chili-restaurant-shop' ); ?>
        </a>
    </p>
</div>
<?php
}
add_action( 'admin_notices', 'vcrs_admin_notice' );