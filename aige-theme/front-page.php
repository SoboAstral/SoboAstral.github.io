<?php
/**
 * Front Page Template (Homepage)
 *
 * @package AIGE
 */

get_header();

$theme_uri = get_template_directory_uri();
$pm_page   = get_page_by_path('premio-masaniello');
$pm_url    = $pm_page ? get_permalink($pm_page->ID) : home_url('/premio-masaniello/');
$qn_page   = get_page_by_path('questa-napoli');
$qn_url    = $qn_page ? get_permalink($qn_page->ID) : home_url('/questa-napoli/');

$pm_items = aige_get_premio_masaniello_data();
$qn_items = aige_get_questa_napoli_data();
$pm_count = count($pm_items);
$qn_count = count($qn_items);
?>

  <!-- ==========================================================================
       HERO SECTION ISTITUZIONALE
       ========================================================================== -->
  <section class="hero-section" style="background-image: url('<?php echo esc_url($theme_uri . '/assets/images/aige_napoli_hero.jpg'); ?>');">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
      <div class="hero-badge">
        <span>🏛️</span> <?php _e('Storica realtà del centro di Napoli • Fondata nel 1988', 'aige'); ?>
      </div>
      <h1 class="hero-title">
        A.I.G.E. <br>
        <span class="gold-text"><?php _e('Associazione Informazione Giovani Europa', 'aige'); ?></span>
      </h1>
      <p class="hero-lead">
        <?php _e('Fondata nel Novembre del 1988 da Luigi Rispoli e situata in via del Carmine 22, l’Associazione Informazione Giovani Europa (AIGE) è una storica realtà del centro città che ha come fine la promozione e la valorizzazione del patrimonio storico-culturale, artistico e linguistico di Napoli.', 'aige'); ?>
      </p>
      <div class="hero-actions">
        <a href="#sezioni-aige" class="btn btn-gold"><?php _e('Esplora le 5 Sezioni dell\'Associazione ➔', 'aige'); ?></a>
        <a href="#contatti" class="btn btn-outline"><?php _e('Vieni a Trovarci in Sede', 'aige'); ?></a>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       BANNER PILASTRI RAPIDI IN EVIDENZA (Hyperlinks alle sezioni separate)
       ========================================================================== -->
  <section class="section section-dark" style="padding-top: 1rem; padding-bottom: 3rem;">
    <div class="container">
      <div class="flagship-cards-grid">
        
        <!-- Pilastro 1: Premio Masaniello -->
        <article class="flagship-card card-premio">
          <span class="flagship-badge"><?php _e('Sezione Separata Ufficiale', 'aige'); ?></span>
          <h3><?php _e('1. PREMIO MASANIELLO', 'aige'); ?></h3>
          <p>
            <?php _e('Ideato e organizzato dall’associazione, il premio Masaniello è un riconoscimento destinato a personalità distintesi nei campi della cultura, dell’informazione, della ricerca, dell’impresa, dello spettacolo, delle istituzioni e dell’impegno civile.', 'aige'); ?>
          </p>
          <div class="flagship-footer">
            <span class="dynamic-count-pill" id="premioMasanielloCount"><?php echo esc_html($pm_count . ' ' . __('Edizioni & Riconoscimenti', 'aige')); ?></span>
            <a href="<?php echo esc_url($pm_url); ?>" class="btn btn-gold" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">
              <?php _e('Apri Sezione "Premio Masaniello" ➔', 'aige'); ?>
            </a>
          </div>
        </article>

        <!-- Pilastro 2: QUESTANAPOLI -->
        <article class="flagship-card card-questa">
          <span class="flagship-badge"><?php _e('Sezione Separata Ufficiale', 'aige'); ?></span>
          <h3><?php _e('2. QUESTANAPOLI', 'aige'); ?></h3>
          <p>
            <?php _e('L’attività editoriale dell’associazione ruota intorno alla pubblicazione del periodico QUESTANAPOLI, una rivista dedicata alla storia di Napoli, alla sua identità e lingua, alle tradizioni popolari e alla cultura del Mezzogiorno.', 'aige'); ?>
          </p>
          <div class="flagship-footer">
            <span class="dynamic-count-pill" id="questaNapoliCount"><?php echo esc_html($qn_count . ' ' . __('Pubblicazioni & Iniziative', 'aige')); ?></span>
            <a href="<?php echo esc_url($qn_url); ?>" class="btn btn-terra" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">
              <?php _e('Apri Sezione "QUESTANAPOLI" ➔', 'aige'); ?>
            </a>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- ==========================================================================
       SEZIONE: CHI SIAMO & STORIA DELL'ASSOCIAZIONE
       ========================================================================== -->
  <section class="section section-alt" id="chi-siamo">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">🏛️ <?php _e('Chi Siamo', 'aige'); ?></span>
        <h2 class="section-title"><?php _e('L\'Associazione A.I.G.E.', 'aige'); ?></h2>
        <p class="section-subtitle">
          <?php _e('Una presenza attiva e radicata nel cuore antico della città fin dal 1988 al servizio dei giovani e del patrimonio partenopeo.', 'aige'); ?>
        </p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3.5rem; align-items: center;">
        <div>
          <div style="background: rgba(212, 175, 55, 0.1); border-left: 4px solid var(--gold-primary); padding: 1.2rem 1.5rem; border-radius: 0 var(--radius-sm) var(--radius-sm) 0; margin-bottom: 1.5rem;">
            <p style="color: #fff; font-size: 1.15rem; line-height: 1.7; margin: 0; font-weight: 500;">
              <?php _e('Fondata nel Novembre del 1988 da Luigi Rispoli e situata in via del Carmine 22, l’Associazione Informazione Giovani Europa (AIGE), è una storica realtà del centro città che ha come fine la promozione e la valorizzazione del patrimonio storico-culturale, artistico e linguistico di Napoli.', 'aige'); ?>
            </p>
          </div>

          <p style="font-size: 1.08rem; color: #cbd5e1; line-height: 1.75; margin-bottom: 1.8rem;">
            <?php _e('Attraverso l’impegno pluridecennale per la partecipazione attiva e consapevole dei giovani napoletani, offre numerose opportunità per la crescita civile e l’inclusione sociale di questi. Dalle rassegne di risonanza nazionale come il Premio Masaniello, al periodico QUESTANAPOLI, fino alla presenza quotidiana sul territorio con la Biblioteca della Gioventù nel quartiere Pendino.', 'aige'); ?>
          </p>

          <div style="display: flex; gap: 1.8rem; flex-wrap: wrap;">
            <div style="border-left: 3px solid var(--gold-primary); padding-left: 1rem;">
              <strong style="font-size: 1.7rem; color: #fff; font-family: var(--font-serif);"><?php _e('Nov. 1988', 'aige'); ?></strong>
              <p style="font-size: 0.85rem; margin: 0;"><?php _e('Anno di Fondazione', 'aige'); ?></p>
            </div>
            <div style="border-left: 3px solid var(--accent-terra); padding-left: 1rem;">
              <strong style="font-size: 1.7rem; color: #fff; font-family: var(--font-serif);"><?php _e('Via del Carmine 22', 'aige'); ?></strong>
              <p style="font-size: 0.85rem; margin: 0;"><?php _e('Sede nel quartiere Pendino', 'aige'); ?></p>
            </div>
            <div style="border-left: 3px solid var(--gold-primary); padding-left: 1rem;">
              <strong style="font-size: 1.7rem; color: #fff; font-family: var(--font-serif);"><?php _e('Luigi Rispoli', 'aige'); ?></strong>
              <p style="font-size: 0.85rem; margin: 0;"><?php _e('Fondatore e Presidente', 'aige'); ?></p>
            </div>
          </div>
        </div>

        <div style="border-radius: var(--radius-md); overflow: hidden; border: 1.5px solid var(--border-gold); box-shadow: var(--shadow-lg);">
          <img src="<?php echo esc_url($theme_uri . '/assets/images/naples_spaccanapoli.jpg'); ?>" alt="<?php esc_attr_e('Centro Storico di Napoli', 'aige'); ?>" style="width: 100%; height: 400px; object-fit: cover;">
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       LE 5 SEZIONI CARDINALI DELL'ASSOCIAZIONE AIGE
       ========================================================================== -->
  <section class="section section-dark" id="sezioni-aige">
    <div class="container">
      
      <div class="section-header">
        <span class="section-tag">✨ <?php _e('Il Nostro Impegno Sul Territorio', 'aige'); ?></span>
        <h2 class="section-title"><?php _e('Le Sezioni & Attività di A.I.G.E.', 'aige'); ?></h2>
        <p class="section-subtitle">
          <?php _e('Cinque direttrici d\'azione per valorizzare la memoria, sostenere la formazione e costruire aggregazione civile.', 'aige'); ?>
        </p>

        <!-- Barra di salto rapido tra le 5 sezioni -->
        <nav class="quick-jump-nav" aria-label="<?php esc_attr_e('Indice rapido delle sezioni', 'aige'); ?>">
          <a href="#premio-masaniello" class="quick-jump-chip">
            <span class="chip-num">1</span> <?php _e('Premio Masaniello', 'aige'); ?>
          </a>
          <a href="#questanapoli" class="quick-jump-chip">
            <span class="chip-num">2</span> <?php _e('QUESTANAPOLI', 'aige'); ?>
          </a>
          <a href="#biblioteca" class="quick-jump-chip">
            <span class="chip-num">3</span> <?php _e('Biblioteca della Gioventù', 'aige'); ?>
          </a>
          <a href="#eventi" class="quick-jump-chip">
            <span class="chip-num">4</span> <?php _e('Eventi (Carnevale)', 'aige'); ?>
          </a>
          <a href="#tutela-lingua" class="quick-jump-chip">
            <span class="chip-num">5</span> <?php _e('Tutela Lingua Napoletana', 'aige'); ?>
          </a>
        </nav>
      </div>

      <div class="pillars-showcase">

        <!-- SEZIONE 1: PREMIO MASANIELLO -->
        <article class="pillar-block" id="premio-masaniello">
          <div class="pillar-body">
            <div class="pillar-header-meta">
              <div class="pillar-number">01</div>
              <span class="pillar-badge badge-masaniello"><?php _e('Riconoscimento Nazionale • AIGE', 'aige'); ?></span>
            </div>
            <h3 class="pillar-title"><?php _e('1. Premio Masaniello', 'aige'); ?></h3>
            <p class="pillar-description">
              <?php _e('Ideato e organizzato dall’associazione, il premio Masaniello è un riconoscimento destinato a personalità distintesi nei campi della cultura, dell’informazione, della ricerca, dell’impresa, dello spettacolo, delle istituzioni e dell’impegno civile.', 'aige'); ?>
            </p>
            <ul class="pillar-points">
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Simbolo d\'eccellenza:', 'aige'); ?></strong> <?php _e('consegna dell\'originale mezzobusto in bronzo del capopopolo Masaniello, realizzato dallo scultore Domenico Sepe.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Istituito dall\'AIGE:', 'aige'); ?></strong> <?php _e('cerimonia annuale presso i più illustri teatri e monumenti partenopei (Teatro Sannazaro, Castel Nuovo, Maschio Angioino).', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Albo dei premiati:', 'aige'); ?></strong> <?php _e('oltre 150 illustri personalità della scienza, dell\'arte e della società premiate per aver onorato Napoli nel mondo.', 'aige'); ?></span>
              </li>
            </ul>
            <div class="pillar-actions">
              <a href="<?php echo esc_url($pm_url); ?>" class="btn btn-gold">
                <?php _e('Accedi alla Sezione Dedicata "Premio Masaniello" ➔', 'aige'); ?>
              </a>
              <span style="font-size: 0.84rem; color: var(--gold-light);">🔗 <?php _e('Sezione autonoma & aggiornabile', 'aige'); ?></span>
            </div>
          </div>
          <div class="pillar-media">
            <img src="<?php echo esc_url($theme_uri . '/assets/images/premio_masaniello_award.jpg'); ?>" alt="<?php esc_attr_e('Scultura Mezzobusto Premio Masaniello di Domenico Sepe', 'aige'); ?>" loading="lazy">
            <div class="pillar-media-overlay"></div>
            <div class="pillar-floating-tag">🏆 <?php _e('Trofeo Ufficiale Scultura M° Domenico Sepe', 'aige'); ?></div>
          </div>
        </article>

        <!-- SEZIONE 2: QUESTANAPOLI -->
        <article class="pillar-block pillar-reverse" id="questanapoli">
          <div class="pillar-body">
            <div class="pillar-header-meta">
              <div class="pillar-number">02</div>
              <span class="pillar-badge badge-questanapoli"><?php _e('Attività Editoriale & Rivista', 'aige'); ?></span>
            </div>
            <h3 class="pillar-title"><?php _e('2. QUESTANAPOLI', 'aige'); ?></h3>
            <p class="pillar-description">
              <?php _e('L’attività editoriale dell’associazione ruota intorno alla pubblicazione del periodico QUESTANAPOLI, una rivista dedicata alla storia di Napoli, alla sua identità e lingua, alle tradizioni popolari e alla cultura del Mezzogiorno. Rappresenta uno strumento di divulgazione molto apprezzato anche negli ambienti accademici ed associativi.', 'aige'); ?>
            </p>
            <ul class="pillar-points">
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Periodico stracittadino:', 'aige'); ?></strong> <?php _e('inchieste, monografie e saggi storici dedicati alla napoletanità e alle radici del Mezzogiorno.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Riferimento accademico:', 'aige'); ?></strong> <?php _e('testi adottati e consultati da ricercatori, docenti e comitati culturali cittadini.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Archivio e dibattiti:', 'aige'); ?></strong> <?php _e('promotore di convegni e tavole rotonde per dare voce a storici e giovani scrittori.', 'aige'); ?></span>
              </li>
            </ul>
            <div class="pillar-actions">
              <a href="<?php echo esc_url($qn_url); ?>" class="btn btn-terra">
                <?php _e('Accedi alla Sezione Dedicata "QUESTANAPOLI" ➔', 'aige'); ?>
              </a>
              <span style="font-size: 0.84rem; color: #ffab91;">🔗 <?php _e('Sezione autonoma & aggiornabile', 'aige'); ?></span>
            </div>
          </div>
          <div class="pillar-media">
            <img src="<?php echo esc_url($theme_uri . '/assets/images/questa_napoli_mag.jpg'); ?>" alt="<?php esc_attr_e('Periodico Questanapoli rivista di cultura e storia', 'aige'); ?>" loading="lazy">
            <div class="pillar-media-overlay"></div>
            <div class="pillar-floating-tag">📰 <?php _e('Periodico Stracittadino della Napoletanità', 'aige'); ?></div>
          </div>
        </article>

        <!-- SEZIONE 3: BIBLIOTECA DELLA GIOVENTÙ -->
        <article class="pillar-block" id="biblioteca">
          <div class="pillar-body">
            <div class="pillar-header-meta">
              <div class="pillar-number">03</div>
              <span class="pillar-badge badge-biblioteca"><?php _e('Presidio Culturale & Studio', 'aige'); ?></span>
            </div>
            <h3 class="pillar-title"><?php _e('3. Biblioteca della Gioventù', 'aige'); ?></h3>
            <p class="pillar-description">
              <?php _e('Si tratta di un presidio culturale situato proprio nella sede di AIGE, nel cuore del quartiere Pendino che garantisce un accesso gratuito ai libri e all’attività della lettura ed è un fondamentale strumento di sostegno allo studio per tutti coloro che vivono la realtà locale.', 'aige'); ?>
            </p>
            <ul class="pillar-points">
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Accesso gratuito:', 'aige'); ?></strong> <?php _e('consultazione libera di testi storici, letterari, scientifici e narrativa per ragazzi e studenti.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Presidio nel quartiere Pendino:', 'aige'); ?></strong> <?php _e('situata direttamente presso la sede dell\'AIGE in via del Carmine 22.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Sostegno allo studio:', 'aige'); ?></strong> <?php _e('spazi dedicati alla concentrazione, al doposcuola e alla crescita dei giovani del territorio.', 'aige'); ?></span>
              </li>
            </ul>
            <div class="pillar-actions">
              <a href="#contatti" class="btn btn-outline">
                📍 <?php _e('Vieni a trovarci in via del Carmine 22', 'aige'); ?>
              </a>
            </div>
          </div>
          <div class="pillar-media">
            <img src="<?php echo esc_url($theme_uri . '/assets/images/biblioteca_gioventu.jpg'); ?>" alt="<?php esc_attr_e('Biblioteca della Gioventù presso la sede AIGE in quartiere Pendino', 'aige'); ?>" loading="lazy">
            <div class="pillar-media-overlay"></div>
            <div class="pillar-floating-tag">📚 <?php _e('Presidio Culturale in Sede AIGE • Quartiere Pendino', 'aige'); ?></div>
          </div>
        </article>

        <!-- SEZIONE 4: EVENTI (IL CARNEVALE DEI BAMBINI) -->
        <article class="pillar-block pillar-reverse" id="eventi">
          <div class="pillar-body">
            <div class="pillar-header-meta">
              <div class="pillar-number">04</div>
              <span class="pillar-badge badge-eventi"><?php _e('Aggregazione & Comunità Locale', 'aige'); ?></span>
            </div>
            <h3 class="pillar-title"><?php _e('4. Eventi — Il Carnevale dei Bambini', 'aige'); ?></h3>
            <p class="pillar-description">
              <?php _e('Il carnevale dei bambini rappresenta per i quartieri Mercato e Pendino un momento associativo e di integrazione attraverso attività ludiche, spettacoli e laboratori. Arrivato alla sua quarta edizione si svolge nella Piazza del Carmine e coinvolge numerose realtà quali famiglie e scuole, associazioni, artisti, volontari ed istituzioni locali.', 'aige'); ?>
            </p>
            <ul class="pillar-points">
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Integrazione e riscatto:', 'aige'); ?></strong> <?php _e('una festa corale per i quartieri storici di Mercato e Pendino all\'insegna della creatività.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Giunto alla 4ª Edizione:', 'aige'); ?></strong> <?php _e('appuntamento consolidato nella suggestiva cornice di Piazza del Carmine.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Rete civica estesa:', 'aige'); ?></strong> <?php _e('sinergia reale tra famiglie, istituti scolastici, compagnie di artisti e volontari.', 'aige'); ?></span>
              </li>
            </ul>
            <div class="pillar-actions">
              <a href="#contatti" class="btn btn-outline">
                🤝 <?php _e('Unisciti come Volontario o Partner', 'aige'); ?>
              </a>
            </div>
          </div>
          <div class="pillar-media">
            <img src="<?php echo esc_url($theme_uri . '/assets/images/carnevale_carmine.jpg'); ?>" alt="<?php esc_attr_e('Il Carnevale dei Bambini organizzato da AIGE in Piazza del Carmine a Napoli', 'aige'); ?>" loading="lazy">
            <div class="pillar-media-overlay"></div>
            <div class="pillar-floating-tag">🎭 <?php _e('Piazza del Carmine • Mercato & Pendino', 'aige'); ?></div>
          </div>
        </article>

        <!-- SEZIONE 5: TUTELA DELLA LINGUA NAPOLETANA -->
        <article class="pillar-block" id="tutela-lingua">
          <div class="pillar-body">
            <div class="pillar-header-meta">
              <div class="pillar-number">05</div>
              <span class="pillar-badge badge-lingua"><?php _e('Impegno Civico & Riconoscimento', 'aige'); ?></span>
            </div>
            <h3 class="pillar-title"><?php _e('5. Tutela della lingua napoletana', 'aige'); ?></h3>
            <p class="pillar-description">
              <?php _e('L’associazione è in prima linea nella promozione di convegni ed incontri scientifici e culturali per l’approvazione di una legge regionale per la tutela e la valorizzazione della lingua napoletana con il sostegno di linguisti, docenti e studiosi, amministratori pubblici, rappresentanti delle istituzioni e associazioni culturali.', 'aige'); ?>
            </p>
            <ul class="pillar-points">
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Proposta legislativa:', 'aige'); ?></strong> <?php _e('campagna attiva per una legge regionale organica a tutela dell\'idioma partenopeo.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Comitato scientifico di rilievo:', 'aige'); ?></strong> <?php _e('collaborazione stretta con eminenti linguisti, docenti universitari e ricercatori.', 'aige'); ?></span>
              </li>
              <li class="pillar-point-item">
                <span class="icon">✓</span>
                <span><strong><?php _e('Valore UNESCO:', 'aige'); ?></strong> <?php _e('salvaguardia della lingua come patrimonio immateriale vivo dell\'umanità e identità dei giovani.', 'aige'); ?></span>
              </li>
            </ul>
            <div class="pillar-actions">
              <a href="<?php echo esc_url($qn_url); ?>" class="btn btn-gold">
                <?php _e('Leggi gli Approfondimenti Linguistici su QUESTANAPOLI ➔', 'aige'); ?>
              </a>
            </div>
          </div>
          <div class="pillar-media">
            <img src="<?php echo esc_url($theme_uri . '/assets/images/naples_music.jpg'); ?>" alt="<?php esc_attr_e('Tutela della lingua napoletana e patrimonio musicale e linguistico partenopeo', 'aige'); ?>" loading="lazy">
            <div class="pillar-media-overlay"></div>
            <div class="pillar-floating-tag">📜 <?php _e('Battaglia Civica per la Legge Regionale', 'aige'); ?></div>
          </div>
        </article>

      </div>

    </div>
  </section>

  <!-- ==========================================================================
       SEZIONE: SEDE & CONTATTI
       ========================================================================== -->
  <section class="section section-alt" id="contatti">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">📫 <?php _e('Vieni a Trovarci', 'aige'); ?></span>
        <h2 class="section-title"><?php _e('Sede & Contatti A.I.G.E.', 'aige'); ?></h2>
        <p class="section-subtitle">
          <?php _e('Presidio culturale attivo in via del Carmine 22, nel centro storico di Napoli. Siamo a disposizione per informazioni, adesioni, consultazione della biblioteca e progetti sul territorio.', 'aige'); ?>
        </p>
      </div>

      <div class="contact-wrapper">
        <!-- Informazioni e Dati Istituzionali -->
        <div class="contact-info">
          <div class="contact-item">
            <div class="contact-icon">📍</div>
            <div class="contact-details">
              <h5><?php _e('Sede Operativa & Legale AIGE', 'aige'); ?></h5>
              <p>
                <strong>Via del Carmine, 22</strong><br>
                80142 Napoli (NA) — Quartiere Pendino / Mercato<br>
                <em style="color: var(--gold-primary);"><?php _e('A pochi passi da Piazza del Carmine', 'aige'); ?></em>
              </p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon">🏛️</div>
            <div class="contact-details">
              <h5><?php _e('Biblioteca della Gioventù', 'aige'); ?></h5>
              <p>
                <?php _e('Situata presso la sede AIGE al piano terra.', 'aige'); ?><br>
                <?php _e('Apertura per lettura e studio: Lunedì – Venerdì, 10:00 – 18:30.', 'aige'); ?><br>
                <span style="color: var(--gold-light);"><?php _e('Accesso gratuito per tutti i residenti e studenti.', 'aige'); ?></span>
              </p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon">✉️</div>
            <div class="contact-details">
              <h5><?php _e('Contatti Telematici', 'aige'); ?></h5>
              <p>
                Email Ufficiale: <a href="mailto:info@aigenapoli.it">info@aigenapoli.it</a><br>
                Presidenza: <a href="mailto:presidenza@aigenapoli.it">presidenza@aigenapoli.it</a><br>
                Premio Masaniello: <a href="mailto:segreteria@premiomasaniello.it">segreteria@premiomasaniello.it</a>
              </p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon">📞</div>
            <div class="contact-details">
              <h5><?php _e('Presidenza & Segreteria', 'aige'); ?></h5>
              <p>
                Presidente: <strong>Luigi Rispoli</strong> (Fondatore)<br>
                Recapito telefonico segreteria: +39 081 551 2345
              </p>
            </div>
          </div>
        </div>

        <!-- Form di Contatto Rapido (AJAX Powered) -->
        <div>
          <form class="contact-form" id="aigeContactForm">
            <div class="form-group">
              <label for="contactName"><?php _e('Nome e Cognome *', 'aige'); ?></label>
              <input type="text" id="contactName" name="name" class="form-control" placeholder="<?php esc_attr_e('Inserisci il tuo nome completo', 'aige'); ?>" required>
            </div>

            <div class="form-group">
              <label for="contactEmail"><?php _e('Indirizzo Email *', 'aige'); ?></label>
              <input type="email" id="contactEmail" name="email" class="form-control" placeholder="nome@esempio.it" required>
            </div>

            <div class="form-group">
              <label for="contactSubject"><?php _e('Area di Interesse', 'aige'); ?></label>
              <select id="contactSubject" name="subject" class="form-control">
                <option value="Informazioni Generali AIGE"><?php _e('Informazioni Generali AIGE', 'aige'); ?></option>
                <option value="Premio Masaniello - Segnalazioni"><?php _e('Premio Masaniello - Segnalazioni', 'aige'); ?></option>
                <option value="Periodico QUESTANAPOLI"><?php _e('Periodico QUESTANAPOLI', 'aige'); ?></option>
                <option value="Biblioteca della Gioventù - Studio & Libri"><?php _e('Biblioteca della Gioventù - Studio & Libri', 'aige'); ?></option>
                <option value="Eventi & Carnevale dei Bambini"><?php _e('Eventi & Carnevale dei Bambini', 'aige'); ?></option>
                <option value="Tutela della lingua napoletana"><?php _e('Tutela della lingua napoletana', 'aige'); ?></option>
              </select>
            </div>

            <div class="form-group">
              <label for="contactMessage"><?php _e('Messaggio per la Segreteria *', 'aige'); ?></label>
              <textarea id="contactMessage" name="message" class="form-control" placeholder="<?php esc_attr_e('Scrivi qui la tua richiesta, proposta di collaborazione o messaggio per l\'associazione...', 'aige'); ?>" required></textarea>
            </div>

            <button type="submit" class="btn btn-gold" style="width: 100%; margin-top: 0.5rem;">
              <?php _e('Invia Messaggio ad A.I.G.E. ➔', 'aige'); ?>
            </button>
          </form>
        </div>
      </div>

    </div>
  </section>

<?php
get_footer();
