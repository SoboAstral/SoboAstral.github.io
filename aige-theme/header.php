<?php
/**
 * Header Template
 *
 * @package AIGE
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏛️</text></svg>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- ==========================================================================
       HEADER & NAVIGAZIONE PRINCIPALE AIGE
       ========================================================================== -->
  <header class="site-header" id="topHeader">
    <div class="container nav-container">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-link" aria-label="<?php bloginfo('name'); ?>">
        <?php if (has_custom_logo()) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
          <div class="brand-emblem">AIGE</div>
          <div class="brand-text">
            <span class="brand-title"><?php bloginfo('name') ?: 'A.I.G.E.'; ?></span>
            <span class="brand-subtitle"><?php bloginfo('description') ?: 'Informazione Giovani Europa • Dal 1988'; ?></span>
          </div>
        <?php endif; ?>
      </a>

      <!-- Menu di Navigazione Desktop e Mobile -->
      <nav aria-label="<?php esc_attr_e('Navigazione principale', 'aige'); ?>">
        <ul class="nav-menu" id="navMenu">
          <li><a href="<?php echo esc_url(home_url('/#chi-siamo')); ?>" class="nav-link"><?php _e('Chi Siamo', 'aige'); ?></a></li>
          <li><a href="<?php echo esc_url(home_url('/#sezioni-aige')); ?>" class="nav-link"><?php _e('Attività & Sezioni', 'aige'); ?></a></li>
          
          <?php 
          $pm_page = get_page_by_path('premio-masaniello');
          $pm_url  = $pm_page ? get_permalink($pm_page->ID) : home_url('/premio-masaniello/');
          $is_pm   = is_page('premio-masaniello') || is_page_template('template-premio-masaniello.php') || is_singular('premio_masaniello');
          ?>
          <li>
            <a href="<?php echo esc_url($pm_url); ?>" class="nav-pill nav-pill-premio <?php echo $is_pm ? 'active' : ''; ?>" title="<?php esc_attr_e('Accedi alla sezione dedicata Premio Masaniello', 'aige'); ?>">
              <span>🏆</span> PREMIO MASANIELLO
            </a>
          </li>

          <?php 
          $qn_page = get_page_by_path('questa-napoli');
          $qn_url  = $qn_page ? get_permalink($qn_page->ID) : home_url('/questa-napoli/');
          $is_qn   = is_page('questa-napoli') || is_page_template('template-questa-napoli.php') || is_singular('questa_napoli');
          ?>
          <li>
            <a href="<?php echo esc_url($qn_url); ?>" class="nav-pill nav-pill-questa <?php echo $is_qn ? 'active' : ''; ?>" title="<?php esc_attr_e('Accedi alla sezione dedicata Questa Napoli', 'aige'); ?>">
              <span>📰</span> QUESTANAPOLI
            </a>
          </li>
          
          <li><a href="<?php echo esc_url(home_url('/#contatti')); ?>" class="nav-link"><?php _e('Sede & Contatti', 'aige'); ?></a></li>
          <li>
            <a href="<?php echo esc_url(admin_url()); ?>" class="btn-admin-header" title="<?php esc_attr_e('Area Riservata al Proprietario nel Pannello WordPress', 'aige'); ?>">
              <span>🔐</span> <?php _e('Area Riservata', 'aige'); ?>
            </a>
          </li>
        </ul>
      </nav>

      <button class="menu-toggle" id="menuToggle" aria-label="<?php esc_attr_e('Apri menu navigazione', 'aige'); ?>">☰</button>
    </div>
  </header>
