<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header" id="siteHeader">
        <div class="header__container">
            <!-- Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo"
                aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                <span class="logo__icon"><i class="fa-solid fa-pepper-hot"></i></span>
                <span class="logo__text">
                    <span class="logo__text--accent"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="nav nav--desktop" id="desktopNav" aria-label="Main navigation">
                <ul class="nav__list">
                    <?php vcrs_render_nav_menu( 'primary', 'nav', 'vcrs_primary_menu_fallback' ); ?>
                </ul>
            </nav>

            <!-- Right actions: Cart + Hamburger -->
            <div class="header-actions">
                <!-- Shopping Cart -->
                <?php vcrs_render_cart(); ?>

                <!-- Hamburger Toggle Button (Mobile) -->
                <button class="hamburger" id="hamburgerBtn" aria-label="Toggle navigation menu" aria-expanded="false"
                    type="button">
                    <span class="hamburger__line"></span>
                    <span class="hamburger__line"></span>
                    <span class="hamburger__line"></span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Overlay -->
        <div class="mobile-nav" id="mobileNav" aria-hidden="true">
            <div class="mobile-nav__backdrop"></div>
            <nav class="mobile-nav__panel" aria-label="Mobile navigation">
                <ul class="mobile-nav__list">
                    <?php vcrs_render_nav_menu( 'primary', 'mobile-nav', 'vcrs_mobile_menu_fallback' ); ?>
                </ul>

                <div class="mobile-nav__info">
                    <p class="mobile-nav__phone">
                        <i class="fa-solid fa-phone"></i>
                        <?php echo esc_html( get_theme_mod( 'vcrs_phone', '(555) 123-4567' ) ); ?>
                    </p>
                    <p class="mobile-nav__hours">
                        <i class="fa-regular fa-clock"></i>
                        <?php echo esc_html( get_theme_mod( 'vcrs_hours', 'Tue–Sun 5pm–11pm' ) ); ?>
                    </p>
                </div>
            </nav>
        </div>
    </header>