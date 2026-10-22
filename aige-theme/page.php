<?php
/**
 * Generic Page Template
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

<main <?php post_class('generic-page-main'); ?>>
  <section class="page-hero" style="background-image: url('<?php echo esc_url($image); ?>');">
    <div class="page-hero-overlay"></div>
    <div class="container page-hero-content">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-link">
        <span>←</span> <?php _e('Home AIGE', 'aige'); ?>
      </a>
      <h1 class="hero-title" style="margin-top: 0.5rem;">
        <?php the_title(); ?>
      </h1>
    </div>
  </section>

  <section class="section section-dark" style="padding: 4rem 0;">
    <div class="container" style="max-width: 960px;">
      <div class="entry-content">
        <?php
        while (have_posts()) : the_post();
            the_content();
        endwhile;
        ?>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
