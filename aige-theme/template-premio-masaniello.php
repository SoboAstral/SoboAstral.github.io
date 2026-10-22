<?php
/**
 * Template Name: Premio Masaniello
 *
 * @package AIGE
 */

get_header();

$theme_uri = get_template_directory_uri();
?>

  <!-- ==========================================================================
       HERO DEDICATA: PREMIO MASANIELLO
       ========================================================================== -->
  <section class="page-hero" style="background-image: url('<?php echo esc_url($theme_uri . '/assets/images/premio_masaniello_award.jpg'); ?>');">
    <div class="page-hero-overlay"></div>
    <div class="container page-hero-content">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-link">
        <span>←</span> <?php _e('Home AIGE', 'aige'); ?>
      </a>
      <span class="flagship-badge" style="background: rgba(212, 175, 55, 0.25); color: var(--gold-light); border: 1px solid var(--gold-border);">
        <?php _e('Riconoscimento Istituzionale • Ideato e Organizzato da AIGE', 'aige'); ?>
      </span>
      <h1 class="hero-title" style="margin-top: 0.5rem;">
        <?php _e('PREMIO MASANIELLO', 'aige'); ?>
      </h1>
      <p class="hero-lead" style="margin: 0 auto 1.5rem auto;">
        <?php _e('Ideato e organizzato dall’associazione AIGE, il premio Masaniello è un riconoscimento destinato a personalità distintesi nei campi della cultura, dell’informazione, della ricerca, dell’impresa, dello spettacolo, delle istituzioni e dell’impegno civile.', 'aige'); ?>
      </p>
    </div>
  </section>

  <!-- ==========================================================================
       FOCUS SPECIALE: IL SIMBOLO E LA SCULTURA DI DOMENICO SEPE
       ========================================================================== -->
  <section class="section section-dark" style="padding: 4.5rem 0 2rem 0;">
    <div class="container">
      <div style="background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: var(--radius-md); padding: 2.8rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; align-items: center;">
        
        <div>
          <span class="flagship-badge" style="background: rgba(212, 175, 55, 0.2); color: var(--gold-light); border: 1px solid var(--gold-border);">
            <?php _e('Il Simbolo Iconico', 'aige'); ?>
          </span>
          <h2 style="font-size: 2rem; color: #fff; margin: 0.8rem 0 1rem 0; line-height: 1.25;">
            <?php _e('Il Mezzobusto in Bronzo del Maestro Domenico Sepe', 'aige'); ?>
          </h2>
          <p style="margin-bottom: 1.2rem; line-height: 1.65;">
            <?php _e('Il trofeo assegnato ai vincitori è una preziosa opera d\'arte originale: il mezzobusto in bronzo raffigurante', 'aige'); ?> <strong>Tommaso Aniello d'Amalfi, detto Masaniello</strong>. <?php _e('Modellato con vigore espressivo dal celebre scultore campano', 'aige'); ?> <strong>Domenico Sepe</strong>, <?php _e('simboleggia l\'orgoglio popolare, la difesa della dignità e la fierezza dell\'animo partenopeo.', 'aige'); ?>
          </p>
          <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="<?php echo esc_url(admin_url('edit.php?post_type=premio_masaniello')); ?>" class="btn btn-gold" style="font-size: 0.88rem; padding: 0.65rem 1.2rem;">
              <span>✏️</span> <?php _e('Gestione Edizioni (WP Admin)', 'aige'); ?>
            </a>
            <a href="#edizioni-grid" class="btn btn-outline" style="font-size: 0.88rem; padding: 0.65rem 1.2rem;">
              <?php _e('Consulta l\'Albo d\'Oro ➔', 'aige'); ?>
            </a>
          </div>
        </div>

        <div style="border-radius: var(--radius-md); overflow: hidden; border: 1.5px solid var(--gold-primary); box-shadow: var(--shadow-gold);">
          <img src="<?php echo esc_url($theme_uri . '/assets/images/premio_masaniello_award.jpg'); ?>" alt="<?php esc_attr_e('Scultura Mezzobusto Masaniello Domenico Sepe', 'aige'); ?>" style="width: 100%; height: 320px; object-fit: cover;">
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================================================
       BARRA FILTRI E RICERCA DINAMICA
       ========================================================================== -->
  <section class="section section-dark" id="edizioni-grid" style="padding-top: 1rem;">
    <div class="container">

      <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Barra di Ricerca in Tempo Reale -->
        <div style="position: relative; width: 100%; max-width: 380px;">
          <input type="text" id="searchPremioMasaniello" class="form-control" placeholder="<?php esc_attr_e('🔍 Cerca edizioni, premiati, teatri o temi...', 'aige'); ?>" style="padding-left: 2.5rem;">
          <span style="position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%); color: var(--gold-primary);">🏆</span>
        </div>

        <!-- Bottoni Filtro Categoria -->
        <div class="filter-bar" style="margin: 0;">
          <button class="filter-btn active" data-filter="all"><?php _e('Tutte le Edizioni & Eventi', 'aige'); ?></button>
          <button class="filter-btn" data-filter="edizione"><?php _e('Edizioni Celebrate', 'aige'); ?></button>
          <button class="filter-btn" data-filter="evento"><?php _e('Bandi & Prossimi Eventi', 'aige'); ?></button>
        </div>
      </div>

      <!-- Griglia Dinamica delle Edizioni (Popolata via JavaScript / Live WP Data) -->
      <div class="dynamic-grid" id="premioMasanielloGrid">
        <?php
        // Pre-rendering server-side in PHP per SEO immediato
        $pm_posts = aige_get_premio_masaniello_data();
        if (!empty($pm_posts)) :
          foreach ($pm_posts as $item) :
        ?>
          <article class="dynamic-card">
            <div class="card-media">
              <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
              <?php if (!empty($item['badge'])) : ?>
                <span class="card-badge-floating"><?php echo esc_html($item['badge']); ?></span>
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="card-meta">
                <span>🏆 <?php echo esc_html(!empty($item['editionNumber']) ? 'Edizione ' . $item['editionNumber'] : ($item['year'] ?? 'Edizione Annuale')); ?></span>
                <span>📅 <?php echo esc_html($item['date']); ?></span>
              </div>
              <h3 class="card-title"><?php echo esc_html($item['title']); ?></h3>
              <?php if (!empty($item['venue'])) : ?>
                <p style="font-size: 0.88rem; color: var(--gold-light); margin-bottom: 0.6rem;">📍 <em><?php echo esc_html($item['venue']); ?></em></p>
              <?php endif; ?>
              <?php if (!empty($item['theme'])) : ?>
                <p style="font-size: 0.94rem; color: #fff; font-weight: 600; margin-bottom: 0.8rem;">Tema: "<?php echo esc_html($item['theme']); ?>"</p>
              <?php endif; ?>
              <p class="card-text"><?php echo esc_html($item['summary']); ?></p>

              <?php if (!empty($item['protagonists'])) : ?>
                <div class="protagonists-box">
                  <div class="protagonists-title">
                    <span>🌟 <?php printf(__('Protagonisti Premiati (%d)', 'aige'), count($item['protagonists'])); ?></span>
                  </div>
                  <?php 
                  $featured_prots = array_slice($item['protagonists'], 0, 3);
                  foreach ($featured_prots as $p) : 
                  ?>
                    <div class="protagonist-item">
                      <strong><?php echo esc_html($p['name']); ?></strong> — <span style="color: var(--gold-primary);"><?php echo esc_html($p['field']); ?></span>
                    </div>
                  <?php endforeach; ?>
                  <?php if (count($item['protagonists']) > 3) : ?>
                    <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.4rem;">
                      <?php printf(__('+ altri %d premiati d\'eccellenza...', 'aige'), count($item['protagonists']) - 3); ?>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <div class="card-actions">
                <button class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.88rem;" onclick="openPremioDetailsModal('<?php echo esc_attr($item['id']); ?>')">
                  <?php _e('Scheda Completa & Albo ➔', 'aige'); ?>
                </button>
                <span style="font-size: 0.8rem; color: var(--gold-light);"><?php _e('AIGE & Comitato Promotore', 'aige'); ?></span>
              </div>
            </div>
          </article>
        <?php 
          endforeach; 
        endif; 
        ?>
      </div>

      <!-- Banner per il proprietario per aggiornare la sezione in WordPress -->
      <div style="margin-top: 4.5rem; background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(12, 26, 46, 0.9) 100%); border: 1px dashed var(--gold-border); border-radius: var(--radius-md); padding: 2.2rem; text-align: center;">
        <h4 style="font-size: 1.3rem; color: #fff; margin-bottom: 0.5rem;"><?php _e('Aggiornamento e Gestione del Premio', 'aige'); ?></h4>
        <p style="font-size: 0.95rem; color: var(--text-muted); max-width: 650px; margin: 0 auto 1.2rem auto;">
          <?php _e('Il comitato e il proprietario del sito possono aggiornare in tempo reale le nuove edizioni annuali, inserire i profili dei premiati con le motivazioni ufficiali e pubblicare i bandi di selezione direttamente dal pannello WordPress.', 'aige'); ?>
        </p>
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=premio_masaniello')); ?>" class="btn btn-gold">
          <span>🔐</span> <?php _e('Gestisci "Premio Masaniello" nel Pannello WordPress', 'aige'); ?>
        </a>
      </div>

    </div>
  </section>

  <!-- ==========================================================================
       MODALE DETTAGLI EDIZIONE / ALBO D'ORO
       ========================================================================== -->
  <div class="modal-backdrop" id="premioDetailsModal" role="dialog" aria-modal="true" aria-labelledby="premioModalTitle">
    <div class="modal-window">
      <button class="modal-close-btn" id="premioModalCloseBtn" aria-label="<?php esc_attr_e('Chiudi finestra', 'aige'); ?>">✕</button>
      <div id="premioModalContent">
        <!-- Contenuto iniettato dinamicamente via JS -->
      </div>
    </div>
  </div>

<?php
get_footer();
