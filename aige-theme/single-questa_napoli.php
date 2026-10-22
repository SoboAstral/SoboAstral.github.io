<?php
/**
 * Single Template: Questa Napoli
 *
 * @package AIGE
 */

get_header();

$theme_uri     = get_template_directory_uri();
$date          = get_post_meta(get_the_ID(), '_qn_date', true) ?: get_the_date('F Y');
$type          = get_post_meta(get_the_ID(), '_qn_type', true) ?: 'rivista';
$category      = get_post_meta(get_the_ID(), '_qn_category', true);
$badge         = get_post_meta(get_the_ID(), '_qn_badge', true);
$author        = get_post_meta(get_the_ID(), '_qn_author', true) ?: 'Redazione Questa Napoli & AIGE';
$external_link = get_post_meta(get_the_ID(), '_qn_external_link', true);

$image = get_the_post_thumbnail_url(get_the_ID(), 'full');
if (!$image) {
    $image = $theme_uri . '/assets/images/questa_napoli_mag.jpg';
}

$qn_page = get_page_by_path('questa-napoli');
$qn_url  = $qn_page ? get_permalink($qn_page->ID) : home_url('/questa-napoli/');
?>

<article <?php post_class('single-questa-article'); ?>>
  <!-- Hero Singola Uscita / Articolo -->
  <section class="page-hero" style="background-image: url('<?php echo esc_url($image); ?>');">
    <div class="page-hero-overlay"></div>
    <div class="container page-hero-content">
      <a href="<?php echo esc_url($qn_url); ?>" class="back-home-link">
        <span>←</span> <?php _e('Tutte le Uscite di Questa Napoli', 'aige'); ?>
      </a>
      <span class="flagship-badge" style="background: rgba(200, 90, 50, 0.25); color: #ffab91; border: 1px solid rgba(200, 90, 50, 0.5);">
        <?php echo esc_html($category ?: 'Periodico Stracittadino'); ?>
      </span>
      <h1 class="hero-title" style="margin-top: 0.5rem;">
        <?php the_title(); ?>
      </h1>
      <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 1.5rem; color: var(--gold-primary); font-size: 1rem; margin-top: 0.8rem;">
        <span>📅 <?php echo esc_html($date); ?></span>
        <span>✍️ <?php echo esc_html($author); ?></span>
      </div>
    </div>
  </section>

  <!-- Contenuto Singolo Articolo -->
  <section class="section section-dark" style="padding: 4rem 0;">
    <div class="container" style="max-width: 860px;">
      
      <?php if (has_excerpt()) : ?>
        <div style="background: rgba(200, 90, 50, 0.1); border-left: 4px solid var(--accent-terra); border-radius: 0 var(--radius-sm) var(--radius-sm) 0; padding: 1.4rem 1.8rem; margin-bottom: 2.5rem;">
          <p style="font-size: 1.15rem; color: #fff; font-weight: 500; margin: 0; line-height: 1.6;">
            <?php echo get_the_excerpt(); ?>
          </p>
        </div>
      <?php endif; ?>

      <?php if ($image) : ?>
        <div style="border-radius: var(--radius-md); overflow: hidden; margin-bottom: 2.5rem; border: 1px solid var(--border-subtle); max-height: 480px;">
          <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      <?php endif; ?>

      <div class="entry-content" style="font-size: 1.12rem; margin-bottom: 3.5rem;">
        <?php the_content(); ?>
      </div>

      <?php if ($external_link && $external_link !== '#') : ?>
        <div style="background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: var(--radius-md); padding: 1.8rem 2rem; margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
          <div>
            <h4 style="color: #fff; margin-bottom: 0.3rem;">📄 <?php _e('Documento / Pubblicazione Ufficiale', 'aige'); ?></h4>
            <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0;"><?php _e('Scarica o consulta il materiale monografico completo.', 'aige'); ?></p>
          </div>
          <a href="<?php echo esc_url($external_link); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-gold">
            <?php _e('Scarica / Consulta Online ↗', 'aige'); ?>
          </a>
        </div>
      <?php endif; ?>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-subtle); padding-top: 2rem; flex-wrap: wrap; gap: 1rem;">
        <a href="<?php echo esc_url($qn_url); ?>" class="btn btn-outline">
          ← <?php _e('Torna alla Sezione Questa Napoli', 'aige'); ?>
        </a>
        <a href="<?php echo esc_url(get_edit_post_link(get_the_ID())); ?>" class="owner-access-link" title="<?php esc_attr_e('Modifica questa voce in WP Admin', 'aige'); ?>">
          🔐 <?php _e('Modifica Articolo (WP Admin)', 'aige'); ?>
        </a>
      </div>

    </div>
  </section>
</article>

<?php
get_footer();
