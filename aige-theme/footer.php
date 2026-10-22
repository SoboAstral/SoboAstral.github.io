<?php
/**
 * Footer Template
 *
 * @package AIGE
 */
?>
  <!-- ==========================================================================
       FOOTER ISTITUZIONALE AIGE
       ========================================================================== -->
  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="brand-link">
            <div class="brand-emblem">AIGE</div>
            <div class="brand-text">
              <span class="brand-title"><?php bloginfo('name') ?: 'A.I.G.E.'; ?></span>
              <span class="brand-subtitle"><?php bloginfo('description') ?: 'Informazione Giovani Europa'; ?></span>
            </div>
          </div>
          <p>
            <?php _e('Fondata nel Novembre del 1988 da Luigi Rispoli in via del Carmine 22, Napoli. Storica realtà del centro città dedita alla valorizzazione del patrimonio storico-culturale, artistico e linguistico partenopeo.', 'aige'); ?>
          </p>
        </div>

        <div class="footer-col">
          <h5><?php _e('Le 5 Sezioni', 'aige'); ?></h5>
          <ul class="footer-links">
            <li><a href="<?php echo esc_url(home_url('/#premio-masaniello')); ?>"><?php _e('1. Premio Masaniello', 'aige'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/#questanapoli')); ?>"><?php _e('2. QUESTANAPOLI', 'aige'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/#biblioteca')); ?>"><?php _e('3. Biblioteca della Gioventù', 'aige'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/#eventi')); ?>"><?php _e('4. Eventi (Carnevale)', 'aige'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/#tutela-lingua')); ?>"><?php _e('5. Tutela Lingua Napoletana', 'aige'); ?></a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h5><?php _e('Sezioni Autonome', 'aige'); ?></h5>
          <ul class="footer-links">
            <?php 
            $pm_page = get_page_by_path('premio-masaniello');
            $pm_url  = $pm_page ? get_permalink($pm_page->ID) : home_url('/premio-masaniello/');
            $qn_page = get_page_by_path('questa-napoli');
            $qn_url  = $qn_page ? get_permalink($qn_page->ID) : home_url('/questa-napoli/');
            ?>
            <li><a href="<?php echo esc_url($pm_url); ?>">🏆 <?php _e('Premio Masaniello (Albo d\'Oro)', 'aige'); ?></a></li>
            <li><a href="<?php echo esc_url($qn_url); ?>">📰 <?php _e('QUESTANAPOLI (Rivista & Eventi)', 'aige'); ?></a></li>
            <li><a href="<?php echo esc_url(admin_url()); ?>">🔐 <?php _e('Area Riservata WordPress', 'aige'); ?></a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h5><?php _e('Gestione Proprietario', 'aige'); ?></h5>
          <p style="font-size: 0.88rem; margin-bottom: 1rem;">
            <?php _e('Pannello di amministrazione WordPress per pubblicare edizioni del Premio Masaniello e articoli di QUESTANAPOLI.', 'aige'); ?>
          </p>
          <a href="<?php echo esc_url(admin_url()); ?>" class="owner-access-link" title="<?php esc_attr_e('Accedi a WordPress Admin', 'aige'); ?>">
            <span>🔑</span> <?php _e('Accedi alla Dashboard WordPress', 'aige'); ?>
          </a>
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          © 1988 – <?php echo date('Y'); ?> AIGE — Associazione Informazione Giovani Europa. Sede: Via del Carmine 22, 80142 Napoli.
        </div>
        <div>
          <a href="<?php echo esc_url(admin_url()); ?>" style="color: var(--text-muted); font-size: 0.82rem;">
            <?php _e('Accesso Riservato Proprietario (WP-Admin)', 'aige'); ?>
          </a>
        </div>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
