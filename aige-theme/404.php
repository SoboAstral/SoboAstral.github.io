<?php
/**
 * 404 Error Page Template
 *
 * @package AIGE
 */

get_header();

$theme_uri = get_template_directory_uri();
?>

<main class="error-404-main">
  <section class="page-hero" style="background-image: url('<?php echo esc_url($theme_uri . '/assets/images/aige_napoli_hero.jpg'); ?>'); min-height: 70vh; display: flex; align-items: center;">
    <div class="page-hero-overlay"></div>
    <div class="container page-hero-content" style="text-align: center;">
      <div style="font-size: 5rem; font-family: var(--font-display); color: var(--gold-primary); font-weight: 700; line-height: 1;">
        404
      </div>
      <h1 class="hero-title" style="margin-top: 1rem;">
        <?php _e('Pagina Non Trovata', 'aige'); ?>
      </h1>
      <p class="hero-lead" style="max-width: 600px; margin: 0 auto 2rem auto;">
        <?php _e('La pagina o il contenuto che stai cercando non è disponibile o è stato spostato nell\'archivio storico dell\'associazione.', 'aige'); ?>
      </p>
      <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-gold">
          🏛️ <?php _e('Ritorna alla Home AIGE', 'aige'); ?>
        </a>
        <?php 
        $pm_page = get_page_by_path('premio-masaniello');
        $pm_url  = $pm_page ? get_permalink($pm_page->ID) : home_url('/premio-masaniello/');
        $qn_page = get_page_by_path('questa-napoli');
        $qn_url  = $qn_page ? get_permalink($qn_page->ID) : home_url('/questa-napoli/');
        ?>
        <a href="<?php echo esc_url($pm_url); ?>" class="btn btn-outline">
          🏆 <?php _e('Premio Masaniello', 'aige'); ?>
        </a>
        <a href="<?php echo esc_url($qn_url); ?>" class="btn btn-outline">
          📰 <?php _e('Questa Napoli', 'aige'); ?>
        </a>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
