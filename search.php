<?php get_header(); ?>

<main class="site-main page-default">
  <div class="page-default__container">
    <div class="page-default__content-area">
      <header class="page-default__header">
        <h1 class="page-default__title">
          <?php printf(esc_html__('Search Results for: %s', 'velvet-chili-restaurant-shop'), get_search_query()); ?>
        </h1>
      </header>

      <?php if (have_posts()) : ?>
        <div class="page-default__content">
          <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-default__article'); ?>>
              <h2 class="page-default__title" style="font-size:1.3rem;">
                <a href="<?php the_permalink(); ?>" style="color:var(--color-soft-black);text-decoration:none;">
                  <?php the_title(); ?>
                </a>
              </h2>
              <div class="page-default__content" style="padding:0;border:none;">
                <?php the_excerpt(); ?>
              </div>
            </article>
          <?php endwhile; ?>
          <div class="pagination" style="margin-top:2rem;">
            <?php the_posts_pagination(); ?>
          </div>
        </div>
      <?php else : ?>
        <div class="page-default__content" style="text-align:center;">
          <p>Sorry, no results were found for your search.</p>
          <?php get_search_form(); ?>
        </div>
      <?php endif; ?>
    </div>
    <aside class="page-default__sidebar">
      <?php if (is_active_sidebar('sidebar-1')) : ?>
      <?php dynamic_sidebar('sidebar-1'); ?>
      <?php endif; ?>
    </aside>
  </div>
</main>

<?php get_footer(); ?>
