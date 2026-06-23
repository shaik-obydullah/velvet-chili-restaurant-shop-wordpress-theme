<?php
/**
 * Template Name: Our Menu (Shop Page)
 * Description: Redesigned product listing with improved filter + grid.
 */

get_header();
?>

<main class="our-menu-page">
    <!-- Redesigned Filter Bar -->
    <div class="shop-filters">
        <div class="shop-filters__container">
            <!-- Categories (left) -->
            <div class="filter-categories-wrapper">
                <span class="filter-label">Browse:</span>
                <div class="filter-categories">
                    <a href="#" class="filter-category active">All</a>
                    <a href="#" class="filter-category">Starters</a>
                    <a href="#" class="filter-category">Mains</a>
                    <a href="#" class="filter-category">Desserts</a>
                    <a href="#" class="filter-category">Drinks</a>
                </div>
            </div>
            <!-- Controls (right) -->
            <div class="filter-controls">
                <div class="filter-select-group">
                    <span class="filter-label">Sort:</span>
                    <select class="filter-select">
                        <option>Default</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Popularity</option>
                    </select>
                </div>
                <div class="filter-select-group">
                    <span class="filter-label">Price:</span>
                    <select class="filter-select">
                        <option>All</option>
                        <option>Under $25</option>
                        <option>$25 – $50</option>
                        <option>$50+</option>
                    </select>
                </div>
                <div class="results-count">
                    Showing 1–8 of 8 results
                </div>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <section class="woo-products">
        <div class="woo-products__container">
            <div class="woo-products__header">
                <span class="woo-products__kicker">From Our Kitchen</span>
                <h2 class="woo-products__title">Signature Dishes</h2>
                <p class="woo-products__subtitle">
                    Every dish is a story of fire, spice, and slow‑crafted comfort.
                </p>
            </div>

            <div class="woo-products__grid">
                <?php
                $products = [
                    [
                        'title'       => 'Smoked Ancho Ribeye',
                        'price'       => '$48',
                        'description' => '12‑hour chili‑cocoa rub, roasted bone marrow butter, grilled asparagus.',
                        'image'       => get_template_directory_uri() . '/assets/images/dish-ribeye.jpg',
                        'badge'       => 'Bestseller',
                        'link'        => '#',
                    ],
                    [
                        'title'       => 'Velvet Braised Short Rib',
                        'price'       => '$52',
                        'description' => 'Guajillo & pasilla braise, creamy polenta, pickled red onion.',
                        'image'       => get_template_directory_uri() . '/assets/images/dish-shortrib.jpg',
                        'badge'       => 'Chef’s Pick',
                        'link'        => '#',
                    ],
                    [
                        'title'       => 'Fire‑Roasted Poblano Relleno',
                        'price'       => '$38',
                        'description' => 'Oaxaca cheese, smoky tomato salsa, cilantro lime crema.',
                        'image'       => get_template_directory_uri() . '/assets/images/dish-relleno.jpg',
                        'badge'       => 'Vegetarian',
                        'link'        => '#',
                    ],
                    [
                        'title'       => 'Chili Chocolate Tart',
                        'price'       => '$18',
                        'description' => 'Dark ganache with ancho heat, candied orange, vanilla bean ice cream.',
                        'image'       => get_template_directory_uri() . '/assets/images/dish-tart.jpg',
                        'badge'       => 'Sweet Heat',
                        'link'        => '#',
                    ],
                    [
                        'title'       => 'Crispy Calamari',
                        'price'       => '$16',
                        'description' => 'Lightly fried, served with chipotle aioli and fresh lime.',
                        'image'       => get_template_directory_uri() . '/assets/images/dish-calamari.jpg',
                        'badge'       => '',
                        'link'        => '#',
                    ],
                    [
                        'title'       => 'Spicy Miso Ramen',
                        'price'       => '$22',
                        'description' => 'Rich pork broth, chili oil, soft egg, and seared chashu.',
                        'image'       => get_template_directory_uri() . '/assets/images/dish-ramen.jpg',
                        'badge'       => 'New',
                        'link'        => '#',
                    ],
                    [
                        'title'       => 'Lamb Kofta',
                        'price'       => '$28',
                        'description' => 'Grilled skewers, herbed yogurt, saffron rice, and pomegranate.',
                        'image'       => get_template_directory_uri() . '/assets/images/dish-kofta.jpg',
                        'badge'       => '',
                        'link'        => '#',
                    ],
                    [
                        'title'       => 'Saffron Panna Cotta',
                        'price'       => '$12',
                        'description' => 'Silky cream, saffron honey, pistachio crumble.',
                        'image'       => get_template_directory_uri() . '/assets/images/dish-panna.jpg',
                        'badge'       => 'Gluten-Free',
                        'link'        => '#',
                    ],
                ];

                foreach ($products as $product) : ?>
                <div class="product-card">
                    <div class="product-card__image">
                        <?php if (!empty($product['badge'])) : ?>
                        <span class="product-card__badge"><?php echo esc_html($product['badge']); ?></span>
                        <?php endif; ?>
                        <img src="<?php echo esc_url($product['image']); ?>"
                            alt="<?php echo esc_attr($product['title']); ?>" loading="lazy">
                    </div>
                    <div class="product-card__content">
                        <h3 class="product-card__title"><?php echo esc_html($product['title']); ?></h3>
                        <div class="product-card__price"><?php echo esc_html($product['price']); ?></div>
                        <p class="product-card__description"><?php echo esc_html($product['description']); ?></p>
                        <a href="<?php echo esc_url($product['link']); ?>" class="product-card__btn">
                            View Details <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="woo-products__cta">
                <a href="#" class="btn">Load More Dishes</a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>