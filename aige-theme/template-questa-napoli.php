<?php
/**
 * Template Name: Questa Napoli
 *
 * @package AIGE
 */

get_header();

$theme_uri = get_template_directory_uri();
?>

  <!-- ==========================================================================
       HERO DEDICATA: QUESTA NAPOLI
       ========================================================================== -->
  <section class="page-hero" style="background-image: url('<?php echo esc_url($theme_uri . '/assets/images/questa_napoli_mag.jpg'); ?>');">
    <div class="page-hero-overlay"></div>
    <div class="container page-hero-content">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-link">
        <span>←</span> <?php _e('Home AIGE', 'aige'); ?>
      </a>
      <span class="flagship-badge" style="background: rgba(200, 90, 50, 0.25); color: #ffab91; border: 1px solid rgba(200, 90, 50, 0.5);">
        <?php _e('Periodico Stracittadino della Napoletanità • AIGE', 'aige'); ?>
      </span>
      <h1 class="hero-title" style="margin-top: 0.5rem;">
        <?php _e('QUESTANAPOLI', 'aige'); ?>
      </h1>
      <p class="hero-lead" style="margin: 0 auto 1.5rem auto;">
        <?php _e('L’attività editoriale dell’associazione ruota intorno alla pubblicazione del periodico QUESTANAPOLI, una rivista dedicata alla storia di Napoli, alla sua identità e lingua, alle tradizioni popolari e alla cultura del Mezzogiorno. Rappresenta uno strumento di divulgazione molto apprezzato anche negli ambienti accademici ed associativi.', 'aige'); ?>
      </p>
    </div>
  </section>

  <!-- ==========================================================================
       INTRODUZIONE E IDENTITÀ EDITORIALE
       ========================================================================== -->
  <section class="section section-dark" style="padding: 4rem 0 2rem 0;">
    <div class="container">
      <div style="background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: var(--radius-md); padding: 2.5rem; display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; justify-content: space-between;">
        <div style="max-width: 750px;">
          <h3 style="font-size: 1.5rem; color: #fff; margin-bottom: 0.6rem;"><?php _e('Una Voce Indipendente al Servizio della Cultura Partenopea', 'aige'); ?></h3>
          <p style="font-size: 0.98rem; color: #cbd5e1; margin: 0;">
            <?php _e('Fondato per dare respiro al pensiero libero napoletano e collaboratore storico dell\'AIGE nella valorizzazione delle eccellenze cittadine,', 'aige'); ?> <em>Questa Napoli</em> <?php _e('raccoglie firme autorevoli e giovani penne. Troverai qui le ultime uscite monografiche, gli atti degli incontri e gli eventi organizzati nella città.', 'aige'); ?>
          </p>
        </div>
        <div>
          <a href="<?php echo esc_url(admin_url('edit.php?post_type=questa_napoli')); ?>" class="btn btn-terra" style="font-size: 0.88rem; padding: 0.65rem 1.2rem;">
            <span>✍️</span> <?php _e('Gestione Pubblicazioni (WP Admin)', 'aige'); ?>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       BARRA FILTRI E RICERCA DINAMICA
       ========================================================================== -->
  <section class="section section-dark" id="uscite-grid" style="padding-top: 1rem;">
    <div class="container">

      <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Barra di Ricerca in Tempo Reale -->
        <div style="position: relative; width: 100%; max-width: 380px;">
          <input type="text" id="searchQuestaNapoli" class="form-control" placeholder="<?php esc_attr_e('🔍 Cerca uscite, convegni o temi...', 'aige'); ?>" style="padding-left: 2.5rem;">
          <span style="position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%); color: var(--gold-primary);">📖</span>
        </div>

        <!-- Bottoni Filtro Categoria -->
        <div class="filter-bar" style="margin: 0;">
          <button class="filter-btn active" data-filter="all"><?php _e('Tutti i Contenuti', 'aige'); ?></button>
          <button class="filter-btn" data-filter="rivista"><?php _e('Uscite Periodico', 'aige'); ?></button>
          <button class="filter-btn" data-filter="evento"><?php _e('Eventi & Incontri', 'aige'); ?></button>
          <button class="filter-btn" data-filter="approfondimento"><?php _e('Archivio & Saggi', 'aige'); ?></button>
        </div>
      </div>

      <!-- Griglia Dinamica (Popolata via JavaScript / Live WP Data) -->
      <div class="dynamic-grid" id="questaNapoliGrid">
        <?php
        // Pre-rendering server-side in PHP per SEO immediato
        $qn_posts = aige_get_questa_napoli_data();
        if (!empty($qn_posts)) :
          foreach ($qn_posts as $item) :
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
                <span>📅 <?php echo esc_html($item['date']); ?></span>
                <span>🏛️ <?php echo esc_html($item['category']); ?></span>
              </div>
              <h3 class="card-title"><?php echo esc_html($item['title']); ?></h3>
              <p class="card-text"><?php echo esc_html($item['summary']); ?></p>
              <div class="card-actions">
                <button class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.88rem;" onclick="openDetailsModal('<?php echo esc_attr($item['id']); ?>')">
                  <?php _e('Approfondisci ➔', 'aige'); ?>
                </button>
                <span style="font-size: 0.8rem; color: var(--gold-light);">✍️ <?php echo esc_html($item['author']); ?></span>
              </div>
            </div>
          </article>
        <?php 
          endforeach;
        endif;
        ?>
      </div>

      <!-- Banner per il proprietario per aggiornare la sezione in WordPress -->
      <div style="margin-top: 4.5rem; background: linear-gradient(135deg, rgba(200, 90, 50, 0.15) 0%, rgba(12, 26, 46, 0.9) 100%); border: 1px dashed rgba(200, 90, 50, 0.4); border-radius: var(--radius-md); padding: 2.2rem; text-align: center;">
        <h4 style="font-size: 1.3rem; color: #fff; margin-bottom: 0.5rem;"><?php _e('Aggiornamento e Pubblicazione Contenuti', 'aige'); ?></h4>
        <p style="font-size: 0.95rem; color: var(--text-muted); max-width: 650px; margin: 0 auto 1.2rem auto;">
          <?php _e('Questa sezione è dinamica e aggiornabile in qualsiasi momento. Il comitato redazionale può aggiungere nuovi numeri del periodico, avvisi di convegni e rassegne storiche attraverso la bacheca WordPress.', 'aige'); ?>
        </p>
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=questa_napoli')); ?>" class="btn btn-outline">
          <span>🔐</span> <?php _e('Gestisci "Questa Napoli" nel Pannello WordPress', 'aige'); ?>
        </a>
      </div>

    </div>
  </section>

  <!-- ==========================================================================
       MODALE DETTAGLI ARTICOLO / EVENTO
       ========================================================================== -->
  <div class="modal-backdrop" id="detailsModal" role="dialog" aria-modal="true" aria-labelledby="modalDetailTitle">
    <div class="modal-window">
      <button class="modal-close-btn" id="modalCloseBtn" aria-label="<?php esc_attr_e('Chiudi finestra', 'aige'); ?>">✕</button>
      <div id="modalContent">
        <!-- Contenuto iniettato dinamicamente via JS -->
      </div>
    </div>
  </div>

<?php
get_footer();
