<?php
/**
 * Single Post Template (Standard WP Post)
 *
 * @package AIGE
 */

get_header();

$theme_uri = get_template_directory_uri();
$image = get_the_post_thumbnail_url(get_the_ID(), 'full');
if (!$image) {
    $image = $theme_uri . '/assets/images/aige_napoli_hero.jpg';
}
?>

<article <?php post_class('single-standard-post'); ?>>
  <section class="page-hero" style="background-image: url('<?php echo esc_url($image); ?>');">
    <div class="page-hero-overlay"></div>
    <div class="container page-hero-content">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-link">
        <span>←</span> <?php _e('Home AIGE', 'aige'); ?>
      </a>
      <span class="flagship-badge" style="background: rgba(212, 175, 55, 0.25); color: var(--gold-light); border: 1px solid var(--gold-border);">
        <?php echo esc_html(get_the_category_list(', ') ?: 'News & Comunicati'); ?>
      </span>
      <h1 class="hero-title" style="margin-top: 0.5rem;">
        <?php the_title(); ?>
      </h1>
      <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 1.5rem; color: var(--gold-primary); font-size: 1rem; margin-top: 0.8rem;">
        <span>📅 <?php echo get_the_date(); ?></span>
        <span>✍️ <?php echo get_the_author(); ?></span>
      </div>
    </div>
  </section>

  <section class="section section-dark" style="padding: 4rem 0;">
    <div class="container" style="max-width: 860px;">
      
      <div class="entry-content" style="font-size: 1.12rem; margin-bottom: 3rem;">
        <?php the_content(); ?>
      </div>

      <div class="posts-navigation">
        <?php
        the_post_navigation(array(
            'prev_text' => '← %title',
            'next_text' => '%title →',
        ));
        ?>
      </div>

      <?php
      if (comments_open() || get_comments_number()) :
          comments_template();
      endif;
      ?>

    </div>
  </section>
</article>

<?php
get_footer();
