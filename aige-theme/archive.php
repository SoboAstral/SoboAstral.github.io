<?php
/**
 * Archive Template
 *
 * @package AIGE
 */

get_header();

$theme_uri = get_template_directory_uri();
?>

<main class="archive-main">
  <section class="page-hero" style="background-image: url('<?php echo esc_url($theme_uri . '/assets/images/aige_napoli_hero.jpg'); ?>');">
    <div class="page-hero-overlay"></div>
    <div class="container page-hero-content">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-link">
        <span>←</span> <?php _e('Home AIGE', 'aige'); ?>
      </a>
      <h1 class="hero-title" style="margin-top: 0.5rem;">
        <?php the_archive_title(); ?>
      </h1>
      <?php if (get_the_archive_description()) : ?>
        <p class="hero-lead">
          <?php the_archive_description(); ?>
        </p>
      <?php endif; ?>
    </div>
  </section>

  <section class="section section-dark" style="padding: 4rem 0;">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="dynamic-grid">
          <?php while (have_posts()) : the_post(); ?>
            <article class="dynamic-card">
              <?php if (has_post_thumbnail()) : ?>
                <div class="card-media">
                  <?php the_post_thumbnail('aige-card', array('loading' => 'lazy')); ?>
                </div>
              <?php endif; ?>
              <div class="card-body">
                <div class="card-meta">
                  <span>📅 <?php echo get_the_date(); ?></span>
                  <span>🏛️ <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?></span>
                </div>
                <h3 class="card-title">
                  <a href="<?php the_permalink(); ?>" style="color: #fff; text-decoration: none;">
                    <?php the_title(); ?>
                  </a>
                </h3>
                <p class="card-text">
                  <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                </p>
                <div class="card-actions">
                  <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.88rem;">
                    <?php _e('Leggi Scheda ➔', 'aige'); ?>
                  </a>
                </div>
              </div>
            </article>
          <?php endwhile; ?>
        </div>

        <div class="pagination">
          <?php
          the_posts_pagination(array(
              'mid_size'  => 2,
              'prev_text' => '← ' . __('Precedente', 'aige'),
              'next_text' => __('Successivo', 'aige') . ' →',
          ));
          ?>
        </div>
      <?php else : ?>
        <div style="text-align: center; padding: 4rem 1rem; background: var(--bg-card); border-radius: var(--radius-md); border: 1px dashed var(--border-subtle);">
          <p style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 1rem;">
            <?php _e('Nessun elemento presente in questo archivio.', 'aige'); ?>
          </p>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-gold">
            <?php _e('Torna alla Home AIGE', 'aige'); ?>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php
get_footer();
