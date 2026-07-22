<?php get_header(); ?>

<main class="site-main page-default">
  <div class="page-default__container">
    <div class="page-default__content-area">
      <article class="page-default__article">
        <header class="page-default__header">
          <h1 class="page-default__title">Page Not Found</h1>
        </header>
        <div class="page-default__content" style="text-align:center;">
          <p>Sorry, the page you are looking for does not exist.</p>
          <p><a href="<?php echo esc_url(home_url('/')); ?>" class="btn" style="display:inline-flex;align-items:center;gap:0.5rem;background:var(--color-chili-red);color:white;padding:0.75rem 2rem;border-radius:50px;text-decoration:none;font-weight:600;">Back to Home</a></p>
        </div>
      </article>
    </div>
    <aside class="page-default__sidebar">
      <?php if (is_active_sidebar('sidebar-1')) : ?>
      <?php dynamic_sidebar('sidebar-1'); ?>
      <?php endif; ?>
    </aside>
  </div>
</main>

<?php get_footer(); ?>
