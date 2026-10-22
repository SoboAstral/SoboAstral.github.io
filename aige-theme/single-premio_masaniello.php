<?php
/**
 * Single Template: Premio Masaniello
 *
 * @package AIGE
 */

get_header();

$theme_uri       = get_template_directory_uri();
$edition_number  = get_post_meta(get_the_ID(), '_pm_edition_number', true);
$year            = get_post_meta(get_the_ID(), '_pm_year', true);
$date            = get_post_meta(get_the_ID(), '_pm_date', true) ?: get_the_date('j F Y');
$venue           = get_post_meta(get_the_ID(), '_pm_venue', true);
$theme           = get_post_meta(get_the_ID(), '_pm_theme', true);
$badge           = get_post_meta(get_the_ID(), '_pm_badge', true);
$sculpture_note  = get_post_meta(get_the_ID(), '_pm_sculpture_note', true);
$protagonists_raw= get_post_meta(get_the_ID(), '_pm_protagonists', true);
$protagonists    = aige_parse_protagonists($protagonists_raw);

$image = get_the_post_thumbnail_url(get_the_ID(), 'full');
if (!$image) {
    $image = $theme_uri . '/assets/images/premio_masaniello_award.jpg';
}

$pm_page = get_page_by_path('premio-masaniello');
$pm_url  = $pm_page ? get_permalink($pm_page->ID) : home_url('/premio-masaniello/');
?>

<article <?php post_class('single-premio-article'); ?>>
  <!-- Hero Singola Edizione -->
  <section class="page-hero" style="background-image: url('<?php echo esc_url($image); ?>');">
    <div class="page-hero-overlay"></div>
    <div class="container page-hero-content">
      <a href="<?php echo esc_url($pm_url); ?>" class="back-home-link">
        <span>←</span> <?php _e('Tutte le Edizioni Premio Masaniello', 'aige'); ?>
      </a>
      <span class="flagship-badge" style="background: rgba(212, 175, 55, 0.25); color: var(--gold-light); border: 1px solid var(--gold-border);">
        <?php echo esc_html(!empty($edition_number) ? 'Edizione ' . $edition_number : ($year ? 'Anno ' . $year : 'Premio Masaniello')); ?>
      </span>
      <h1 class="hero-title" style="margin-top: 0.5rem;">
        <?php the_title(); ?>
      </h1>
      <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 1.5rem; color: var(--gold-primary); font-size: 1rem; margin-top: 0.8rem;">
        <span>📅 <?php echo esc_html($date); ?></span>
        <?php if ($venue) : ?>
          <span>📍 <?php echo esc_html($venue); ?></span>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Contenuto Singola Edizione -->
  <section class="section section-dark" style="padding: 4rem 0;">
    <div class="container" style="max-width: 900px;">
      
      <?php if ($theme) : ?>
        <div style="background: rgba(212, 175, 55, 0.1); border-left: 4px solid var(--gold-primary); border-radius: 0 var(--radius-sm) var(--radius-sm) 0; padding: 1.2rem 1.6rem; margin-bottom: 2.5rem;">
          <h4 style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold-light); margin-bottom: 0.3rem;">
            <?php _e('Tema Ufficiale dell\'Edizione', 'aige'); ?>
          </h4>
          <p style="font-size: 1.2rem; color: #fff; font-weight: 600; margin: 0; line-height: 1.4;">
            "<?php echo esc_html($theme); ?>"
          </p>
        </div>
      <?php endif; ?>

      <div class="entry-content" style="font-size: 1.12rem; margin-bottom: 3rem;">
        <?php the_content(); ?>
      </div>

      <!-- Sezione Scultura Masaniello M° Domenico Sepe -->
      <?php if ($sculpture_note) : ?>
        <div style="background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: var(--radius-md); padding: 2rem; margin-bottom: 3rem; display: flex; gap: 1.5rem; align-items: center; flex-wrap: wrap;">
          <div style="flex: 1; min-width: 280px;">
            <h4 style="font-size: 1.05rem; color: var(--gold-light); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.6rem;">
              🗿 <?php _e('La Scultura in Bronzo del M° Domenico Sepe', 'aige'); ?>
            </h4>
            <p style="font-size: 0.96rem; color: #cbd5e1; margin: 0; line-height: 1.65;">
              <?php echo esc_html($sculpture_note); ?>
            </p>
          </div>
          <div style="width: 120px; height: 120px; border-radius: var(--radius-sm); overflow: hidden; border: 1.5px solid var(--gold-primary); flex-shrink: 0;">
            <img src="<?php echo esc_url($theme_uri . '/assets/images/premio_masaniello_award.jpg'); ?>" alt="Trofeo Masaniello Domenico Sepe" style="width: 100%; height: 100%; object-fit: cover;">
          </div>
        </div>
      <?php endif; ?>

      <!-- Albo dei Premiati -->
      <?php if (!empty($protagonists)) : ?>
        <div style="margin-bottom: 3.5rem;">
          <h3 style="font-size: 1.6rem; color: #fff; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 0.8rem;">
            🌟 <?php _e('Albo d\'Oro dei Premiati di questa Edizione', 'aige'); ?>
          </h3>
          <div style="display: flex; flex-direction: column; gap: 1.2rem;">
            <?php foreach ($protagonists as $p) : ?>
              <div style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.4rem 1.6rem; transition: var(--transition);">
                <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.4rem;">
                  <strong style="font-size: 1.25rem; color: #fff;"><?php echo esc_html($p['name']); ?></strong>
                  <span style="font-size: 0.85rem; background: rgba(212, 175, 55, 0.15); color: var(--gold-light); padding: 0.3rem 0.8rem; border-radius: var(--radius-full); font-weight: 600;">
                    <?php echo esc_html($p['field']); ?>
                  </span>
                </div>
                <p style="font-size: 0.98rem; color: var(--text-muted); margin: 0; line-height: 1.6;">
                  <?php echo esc_html($p['reason']); ?>
                </p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-subtle); padding-top: 2rem; flex-wrap: wrap; gap: 1rem;">
        <a href="<?php echo esc_url($pm_url); ?>" class="btn btn-outline">
          ← <?php _e('Torna alla Sezione Premio Masaniello', 'aige'); ?>
        </a>
        <a href="<?php echo esc_url(get_edit_post_link(get_the_ID())); ?>" class="owner-access-link" title="<?php esc_attr_e('Modifica questa edizione in WP Admin', 'aige'); ?>">
          🔐 <?php _e('Modifica Edizione (WP Admin)', 'aige'); ?>
        </a>
      </div>

    </div>
  </section>
</article>

<?php
get_footer();
