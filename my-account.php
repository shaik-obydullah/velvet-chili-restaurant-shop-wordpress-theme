<?php
/**
 * Template Name: My Account Page
 */

get_header(); ?>

<main class="site-main page-default">
    <div class="page-default__container">
        <div class="page-default__content-area">
            <?php
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
