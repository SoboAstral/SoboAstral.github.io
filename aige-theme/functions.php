<?php
/**
 * A.I.G.E. Napoli Theme Functions
 * Associazione Informazione Giovani Europa
 *
 * @package AIGE
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * ============================================================================
 * 1. THEME SETUP & SUPPORTS
 * ============================================================================
 */
function aige_theme_setup() {
    // Carica textdomain per traduzioni
    load_theme_textdomain('aige', get_template_directory() . '/languages');

    // Supporto per il tag <title> gestito da WordPress
    add_theme_support('title-tag');

    // Supporto per immagini in evidenza
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 800, true);
    add_image_size('aige-card', 600, 400, true);
    add_image_size('aige-hero', 1920, 1080, true);

    // Supporto Logo Personalizzato
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Supporto HTML5 semantico
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    // Supporto Gutenberg editor
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');

    // Registrazione Menu
    register_nav_menus(array(
        'primary' => __('Menu Principale Testata', 'aige'),
        'footer'  => __('Menu Navigazione Footer', 'aige')
    ));
}
add_action('after_setup_theme', 'aige_theme_setup');

/**
 * ============================================================================
 * 2. ENQUEUE STYLES & SCRIPTS
 * ============================================================================
 */
function aige_enqueue_scripts() {
    // Google Fonts: Cinzel, Playfair Display, Plus Jakarta Sans
    wp_enqueue_style(
        'aige-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Foglio di stile principale del tema
    wp_enqueue_style('aige-style', get_stylesheet_uri(), array('aige-google-fonts'), '1.0.0');

    // JavaScript Core Store
    wp_enqueue_script(
        'aige-store',
        get_template_directory_uri() . '/assets/js/store.js',
        array(),
        '1.0.0',
        true
    );

    // Passaggio dati dinamici da WordPress a JavaScript (Localize Script)
    $pm_data = aige_get_premio_masaniello_data();
    $qn_data = aige_get_questa_napoli_data();

    wp_localize_script('aige-store', 'aigeWPData', array(
        'ajax_url'             => admin_url('admin-ajax.php'),
        'nonce'                => wp_create_nonce('aige_nonce'),
        'theme_uri'            => get_template_directory_uri(),
        'home_url'             => home_url('/'),
        'premioMasanielloItems'=> $pm_data,
        'questaNapoliItems'    => $qn_data,
        'isWordPress'          => true,
        'stats'                => array(
            'premioCount'      => count($pm_data),
            'questaNapoliCount'=> count($qn_data)
        )
    ));

    // JavaScript Main (Menu Mobile, Contatori, Toast)
    wp_enqueue_script(
        'aige-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('aige-store'),
        '1.0.0',
        true
    );

    // Script dedicato Premio Masaniello
    if (is_front_page() || is_page_template('template-premio-masaniello.php') || is_singular('premio_masaniello')) {
        wp_enqueue_script(
            'aige-premio-masaniello',
            get_template_directory_uri() . '/assets/js/premio-masaniello.js',
            array('aige-store', 'aige-main'),
            '1.0.0',
            true
        );
    }

    // Script dedicato Questa Napoli
    if (is_front_page() || is_page_template('template-questa-napoli.php') || is_singular('questa_napoli')) {
        wp_enqueue_script(
            'aige-questa-napoli',
            get_template_directory_uri() . '/assets/js/questa-napoli.js',
            array('aige-store', 'aige-main'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'aige_enqueue_scripts');

/**
 * ============================================================================
 * 3. CUSTOM POST TYPES & TAXONOMIES
 * ============================================================================
 */
function aige_register_custom_post_types() {
    // ------------------------------------------------------------------------
    // CPT 1: PREMIO MASANIELLO
    // ------------------------------------------------------------------------
    $pm_labels = array(
        'name'               => __('Premio Masaniello', 'aige'),
        'singular_name'      => __('Edizione Premio Masaniello', 'aige'),
        'menu_name'          => __('Premio Masaniello', 'aige'),
        'name_admin_bar'     => __('Premio Masaniello', 'aige'),
        'add_new'            => __('Aggiungi Edizione', 'aige'),
        'add_new_item'       => __('Aggiungi Nuova Edizione Premio Masaniello', 'aige'),
        'new_item'           => __('Nuova Edizione', 'aige'),
        'edit_item'          => __('Modifica Edizione', 'aige'),
        'view_item'          => __('Visualizza Edizione', 'aige'),
        'all_items'          => __('Tutte le Edizioni', 'aige'),
        'search_items'       => __('Cerca Edizioni', 'aige'),
        'not_found'          => __('Nessuna edizione trovata.', 'aige'),
        'not_found_in_trash' => __('Nessuna edizione trovata nel cestino.', 'aige')
    );

    $pm_args = array(
        'labels'             => $pm_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'premio-masaniello-albo'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-awards',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );
    register_post_type('premio_masaniello', $pm_args);

    // ------------------------------------------------------------------------
    // CPT 2: QUESTANAPOLI
    // ------------------------------------------------------------------------
    $qn_labels = array(
        'name'               => __('Questa Napoli', 'aige'),
        'singular_name'      => __('Uscita / Articolo Questa Napoli', 'aige'),
        'menu_name'          => __('Questa Napoli', 'aige'),
        'name_admin_bar'     => __('Questa Napoli', 'aige'),
        'add_new'            => __('Aggiungi Uscita / Evento', 'aige'),
        'add_new_item'       => __('Aggiungi Nuova Voce Questa Napoli', 'aige'),
        'new_item'           => __('Nuova Voce', 'aige'),
        'edit_item'          => __('Modifica Voce', 'aige'),
        'view_item'          => __('Visualizza Voce', 'aige'),
        'all_items'          => __('Tutte le Uscite & Eventi', 'aige'),
        'search_items'       => __('Cerca in Questa Napoli', 'aige'),
        'not_found'          => __('Nessun articolo o evento trovato.', 'aige'),
        'not_found_in_trash' => __('Nessun articolo trovato nel cestino.', 'aige')
    );

    $qn_args = array(
        'labels'             => $qn_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'questa-napoli-archivio'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );
    register_post_type('questa_napoli', $qn_args);

    // Tassonomia Categorie per Questa Napoli
    register_taxonomy('categoria_questa_napoli', array('questa_napoli'), array(
        'hierarchical'      => true,
        'labels'            => array(
            'name'          => __('Categorie Questa Napoli', 'aige'),
            'singular_name' => __('Categoria Questa Napoli', 'aige'),
            'search_items'  => __('Cerca Categoria', 'aige'),
            'all_items'     => __('Tutte le Categorie', 'aige'),
            'edit_item'     => __('Modifica Categoria', 'aige'),
            'add_new_item'  => __('Aggiungi Nuova Categoria', 'aige'),
        ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categoria-questa-napoli'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'aige_register_custom_post_types');

/**
 * ============================================================================
 * 4. CUSTOM META BOXES (NATIVE WORDPRESS ADMIN UI)
 * ============================================================================
 */

// Aggiunta Meta Boxes
function aige_add_custom_meta_boxes() {
    // Meta box Premio Masaniello
    add_meta_box(
        'aige_pm_meta_box',
        __('Dettagli Edizione & Albo d\'Oro (Premio Masaniello)', 'aige'),
        'aige_pm_meta_box_render',
        'premio_masaniello',
        'normal',
        'high'
    );

    // Meta box Questa Napoli
    add_meta_box(
        'aige_qn_meta_box',
        __('Dettagli Pubblicazione & Tipologia (Questa Napoli)', 'aige'),
        'aige_qn_meta_box_render',
        'questa_napoli',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'aige_add_custom_meta_boxes');

// Rendering Meta Box: Premio Masaniello
function aige_pm_meta_box_render($post) {
    wp_nonce_field('aige_pm_meta_nonce_action', 'aige_pm_meta_nonce');

    $edition_number = get_post_meta($post->ID, '_pm_edition_number', true);
    $year           = get_post_meta($post->ID, '_pm_year', true);
    $date           = get_post_meta($post->ID, '_pm_date', true);
    $venue          = get_post_meta($post->ID, '_pm_venue', true);
    $theme          = get_post_meta($post->ID, '_pm_theme', true);
    $type           = get_post_meta($post->ID, '_pm_type', true) ?: 'edizione';
    $badge          = get_post_meta($post->ID, '_pm_badge', true);
    $sculpture_note = get_post_meta($post->ID, '_pm_sculpture_note', true);
    $protagonists_raw = get_post_meta($post->ID, '_pm_protagonists', true);

    // Default per nota scultura se vuoto
    if (!$sculpture_note) {
        $sculpture_note = 'Ogni premiato riceve il caratteristico mezzobusto in bronzo del capopopolo Tommaso Aniello d’Amalfi (Masaniello), modellato e fuso ad arte dallo scultore Domenico Sepe come simbolo perenne di coraggio, dignità e amore per la libertà.';
    }
    ?>
    <style>
        .aige-admin-row { margin-bottom: 15px; }
        .aige-admin-row label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e293b; }
        .aige-admin-row input[type="text"], .aige-admin-row select, .aige-admin-row textarea {
            width: 100%; max-width: 800px; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 4px;
        }
        .aige-admin-hint { font-size: 12px; color: #64748b; margin-top: 4px; }
        .aige-admin-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; max-width: 800px; }
    </style>

    <div class="aige-admin-grid-2">
        <div class="aige-admin-row">
            <label for="pm_edition_number"><?php _e('Numero Edizione (es. XXI, XX, Bando 2027)', 'aige'); ?></label>
            <input type="text" id="pm_edition_number" name="pm_edition_number" value="<?php echo esc_attr($edition_number); ?>">
        </div>
        <div class="aige-admin-row">
            <label for="pm_year"><?php _e('Anno di Riferimento (es. 2026)', 'aige'); ?></label>
            <input type="text" id="pm_year" name="pm_year" value="<?php echo esc_attr($year); ?>">
        </div>
    </div>

    <div class="aige-admin-grid-2">
        <div class="aige-admin-row">
            <label for="pm_date"><?php _e('Data Cerimonia / Scadenza (es. 26 Settembre 2026)', 'aige'); ?></label>
            <input type="text" id="pm_date" name="pm_date" value="<?php echo esc_attr($date); ?>">
        </div>
        <div class="aige-admin-row">
            <label for="pm_type"><?php _e('Tipologia', 'aige'); ?></label>
            <select id="pm_type" name="pm_type">
                <option value="edizione" <?php selected($type, 'edizione'); ?>><?php _e('Edizione Ufficiale', 'aige'); ?></option>
                <option value="evento" <?php selected($type, 'evento'); ?>><?php _e('Evento / Bando di Selezione', 'aige'); ?></option>
                <option value="albo" <?php selected($type, 'albo'); ?>><?php _e('Albo Storico d\'Oro', 'aige'); ?></option>
            </select>
        </div>
    </div>

    <div class="aige-admin-row">
        <label for="pm_venue"><?php _e('Luogo / Sede Solenne (es. Teatro Sannazaro / Castel Nuovo, Napoli)', 'aige'); ?></label>
        <input type="text" id="pm_venue" name="pm_venue" value="<?php echo esc_attr($venue); ?>">
    </div>

    <div class="aige-admin-row">
        <label for="pm_theme"><?php _e('Tema dell\'Edizione (es. "Il Genio Partenopeo e la Gioventù nel Cuore dell\'Europa")', 'aige'); ?></label>
        <input type="text" id="pm_theme" name="pm_theme" value="<?php echo esc_attr($theme); ?>">
    </div>

    <div class="aige-admin-row">
        <label for="pm_badge"><?php _e('Distintivo / Badge in Evidenza (es. Edizione Corrente, Edizione Storica, Bando Aperto)', 'aige'); ?></label>
        <input type="text" id="pm_badge" name="pm_badge" value="<?php echo esc_attr($badge); ?>">
    </div>

    <div class="aige-admin-row">
        <label for="pm_sculpture_note"><?php _e('Nota sulla Scultura in Bronzo del M° Domenico Sepe', 'aige'); ?></label>
        <textarea id="pm_sculpture_note" name="pm_sculpture_note" rows="3"><?php echo esc_textarea($sculpture_note); ?></textarea>
    </div>

    <div class="aige-admin-row">
        <label for="pm_protagonists"><?php _e('Protagonisti Premiati (Uno per riga: Nome | Ambito | Motivazione)', 'aige'); ?></label>
        <textarea id="pm_protagonists" name="pm_protagonists" rows="6" placeholder="Prof. Antonio De Rosa | Ricerca Biomedica & Oncologia | Per le innovative terapie cellulari...&#10;M° Elena Esposito | Musica Classica | Ambasciatrice dell’arte lirica partenopea..."><?php echo esc_textarea($protagonists_raw); ?></textarea>
        <p class="aige-admin-hint">
            <?php _e('Formato consigliato: <strong>Nome | Settore / Campo | Motivazione</strong> (separati dal carattere barra verticale <code>|</code>, uno per riga). In alternativa puoi inserire un array JSON valido.', 'aige'); ?>
        </p>
    </div>
    <?php
}

// Rendering Meta Box: Questa Napoli
function aige_qn_meta_box_render($post) {
    wp_nonce_field('aige_qn_meta_nonce_action', 'aige_qn_meta_nonce');

    $date          = get_post_meta($post->ID, '_qn_date', true);
    $type          = get_post_meta($post->ID, '_qn_type', true) ?: 'rivista';
    $category      = get_post_meta($post->ID, '_qn_category', true);
    $badge         = get_post_meta($post->ID, '_qn_badge', true);
    $author        = get_post_meta($post->ID, '_qn_author', true);
    $external_link = get_post_meta($post->ID, '_qn_external_link', true);
    ?>
    <div class="aige-admin-grid-2">
        <div class="aige-admin-row">
            <label for="qn_date"><?php _e('Data di Uscita o Data Evento (es. Ottobre 2026, 12 Novembre 2026)', 'aige'); ?></label>
            <input type="text" id="qn_date" name="qn_date" value="<?php echo esc_attr($date); ?>">
        </div>
        <div class="aige-admin-row">
            <label for="qn_type"><?php _e('Tipologia Contenuto', 'aige'); ?></label>
            <select id="qn_type" name="qn_type">
                <option value="rivista" <?php selected($type, 'rivista'); ?>><?php _e('Uscita Monografica / Rivista', 'aige'); ?></option>
                <option value="evento" <?php selected($type, 'evento'); ?>><?php _e('Incontro Culturale / Convegno', 'aige'); ?></option>
                <option value="approfondimento" <?php selected($type, 'approfondimento'); ?>><?php _e('Approfondimento / Archivio Storico', 'aige'); ?></option>
            </select>
        </div>
    </div>

    <div class="aige-admin-grid-2">
        <div class="aige-admin-row">
            <label for="qn_category"><?php _e('Etichetta Categoria (es. Periodico Stracittadino, Incontro Culturale, Storia e Memoria)', 'aige'); ?></label>
            <input type="text" id="qn_category" name="qn_category" value="<?php echo esc_attr($category); ?>">
        </div>
        <div class="aige-admin-row">
            <label for="qn_badge"><?php _e('Badge in Evidenza (es. Nuova Uscita, Evento in Programma, Archivio Digitale)', 'aige'); ?></label>
            <input type="text" id="qn_badge" name="qn_badge" value="<?php echo esc_attr($badge); ?>">
        </div>
    </div>

    <div class="aige-admin-grid-2">
        <div class="aige-admin-row">
            <label for="qn_author"><?php _e('Autore / Comitato Redazionale (es. Redazione Questa Napoli & AIGE)', 'aige'); ?></label>
            <input type="text" id="qn_author" name="qn_author" value="<?php echo esc_attr($author); ?>">
        </div>
        <div class="aige-admin-row">
            <label for="qn_external_link"><?php _e('Link Esterno / Download PDF (Opzionale)', 'aige'); ?></label>
            <input type="text" id="qn_external_link" name="qn_external_link" value="<?php echo esc_attr($external_link); ?>">
        </div>
    </div>
    <?php
}

// Salvataggio Meta Box Premio Masaniello
function aige_save_pm_meta($post_id) {
    if (!isset($_POST['aige_pm_meta_nonce']) || !wp_verify_nonce($_POST['aige_pm_meta_nonce'], 'aige_pm_meta_nonce_action')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array(
        'pm_edition_number' => '_pm_edition_number',
        'pm_year'           => '_pm_year',
        'pm_date'           => '_pm_date',
        'pm_venue'          => '_pm_venue',
        'pm_theme'          => '_pm_theme',
        'pm_type'           => '_pm_type',
        'pm_badge'          => '_pm_badge',
        'pm_sculpture_note' => '_pm_sculpture_note',
        'pm_protagonists'   => '_pm_protagonists'
    );

    foreach ($fields as $post_key => $meta_key) {
        if (isset($_POST[$post_key])) {
            if ($post_key === 'pm_sculpture_note' || $post_key === 'pm_protagonists') {
                update_post_meta($post_id, $meta_key, sanitize_textarea_field($_POST[$post_key]));
            } else {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$post_key]));
            }
        }
    }
}
add_action('save_post_premio_masaniello', 'aige_save_pm_meta');

// Salvataggio Meta Box Questa Napoli
function aige_save_qn_meta($post_id) {
    if (!isset($_POST['aige_qn_meta_nonce']) || !wp_verify_nonce($_POST['aige_qn_meta_nonce'], 'aige_qn_meta_nonce_action')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array(
        'qn_date'          => '_qn_date',
        'qn_type'          => '_qn_type',
        'qn_category'      => '_qn_category',
        'qn_badge'         => '_qn_badge',
        'qn_author'        => '_qn_author',
        'qn_external_link' => '_qn_external_link'
    );

    foreach ($fields as $post_key => $meta_key) {
        if (isset($_POST[$post_key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$post_key]));
        }
    }
}
add_action('save_post_questa_napoli', 'aige_save_qn_meta');

/**
 * ============================================================================
 * 5. HELPER DATA SERIALIZATION FOR JAVASCRIPT & FRONTEND
 * ============================================================================
 */

function aige_parse_protagonists($raw) {
    if (empty($raw)) return array();

    // Se è già un JSON valido
    $json = json_decode($raw, true);
    if (is_array($json)) return $json;

    // Parsing formato "Nome | Ambito | Motivazione" per riga
    $list = array();
    $lines = explode("\n", str_replace("\r", "", $raw));
    foreach ($lines as $line) {
        $line = trim($line);
        if (!$line) continue;
        $parts = explode("|", $line);
        $name   = isset($parts[0]) ? trim($parts[0]) : '';
        $field  = isset($parts[1]) ? trim($parts[1]) : '';
        $reason = isset($parts[2]) ? trim($parts[2]) : '';

        if ($name) {
            $list[] = array(
                'name'   => $name,
                'field'  => $field,
                'reason' => $reason
            );
        }
    }
    return $list;
}

function aige_get_premio_masaniello_data() {
    $args = array(
        'post_type'      => 'premio_masaniello',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    $query = new WP_Query($args);
    $items = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();

            $image = get_the_post_thumbnail_url($id, 'large');
            if (!$image) {
                $image = get_template_directory_uri() . '/assets/images/premio_masaniello_award.jpg';
            }

            $raw_protagonists = get_post_meta($id, '_pm_protagonists', true);

            $items[] = array(
                'id'            => 'pm-' . $id,
                'wpId'          => $id,
                'permalink'     => get_permalink($id),
                'title'         => get_the_title(),
                'editionNumber' => get_post_meta($id, '_pm_edition_number', true),
                'year'          => get_post_meta($id, '_pm_year', true),
                'date'          => get_post_meta($id, '_pm_date', true) ?: get_the_date('j F Y'),
                'venue'         => get_post_meta($id, '_pm_venue', true),
                'theme'         => get_post_meta($id, '_pm_theme', true),
                'type'          => get_post_meta($id, '_pm_type', true) ?: 'edizione',
                'badge'         => get_post_meta($id, '_pm_badge', true),
                'summary'       => get_the_excerpt() ?: wp_trim_words(get_the_content(), 35),
                'content'       => get_the_content(),
                'sculptureNote' => get_post_meta($id, '_pm_sculpture_note', true),
                'protagonists'  => aige_parse_protagonists($raw_protagonists),
                'image'         => $image,
                'published'     => true,
            );
        }
        wp_reset_postdata();
    }

    return $items;
}

function aige_get_questa_napoli_data() {
    $args = array(
        'post_type'      => 'questa_napoli',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    $query = new WP_Query($args);
    $items = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();

            $image = get_the_post_thumbnail_url($id, 'large');
            if (!$image) {
                $image = get_template_directory_uri() . '/assets/images/questa_napoli_mag.jpg';
            }

            $category = get_post_meta($id, '_qn_category', true);
            if (!$category) {
                $terms = get_the_terms($id, 'categoria_questa_napoli');
                if ($terms && !is_wp_error($terms)) {
                    $category = $terms[0]->name;
                } else {
                    $category = 'Periodico Stracittadino';
                }
            }

            $items[] = array(
                'id'           => 'qn-' . $id,
                'wpId'         => $id,
                'permalink'    => get_permalink($id),
                'title'        => get_the_title(),
                'date'         => get_post_meta($id, '_qn_date', true) ?: get_the_date('F Y'),
                'type'         => get_post_meta($id, '_qn_type', true) ?: 'rivista',
                'category'     => $category,
                'badge'        => get_post_meta($id, '_qn_badge', true),
                'author'       => get_post_meta($id, '_qn_author', true) ?: 'Redazione Questa Napoli & AIGE',
                'summary'      => get_the_excerpt() ?: wp_trim_words(get_the_content(), 30),
                'content'      => get_the_content(),
                'externalLink' => get_post_meta($id, '_qn_external_link', true) ?: '#',
                'image'        => $image,
                'published'    => true,
            );
        }
        wp_reset_postdata();
    }

    return $items;
}

/**
 * ============================================================================
 * 6. AJAX CONTACT FORM HANDLER
 * ============================================================================
 */
function aige_ajax_contact_handler() {
    check_ajax_referer('aige_nonce', 'security');

    $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email   = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : 'Richiesta Contatto AIGE';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => __('Compila tutti i campi obbligatori contrassegnati con *', 'aige')));
    }

    $to = get_option('admin_email');
    $email_subject = "[AIGE Napoli] " . $subject;
    $body = "Nuovo messaggio inviato dal sito web AIGE:\n\n";
    $body .= "Nome: " . $name . "\n";
    $body .= "Email: " . $email . "\n";
    $body .= "Area di Interesse: " . $subject . "\n\n";
    $body .= "Messaggio:\n" . $message . "\n\n";
    $body .= "---\nInviato da: " . home_url();

    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>', 'Reply-To: ' . $email);

    wp_mail($to, $email_subject, $body, $headers);

    wp_send_json_success(array(
        'message' => sprintf(__('Grazie %s! Il tuo messaggio è stato registrato con successo e inoltrato alla segreteria A.I.G.E.', 'aige'), esc_html($name))
    ));
}
add_action('wp_ajax_aige_contact', 'aige_ajax_contact_handler');
add_action('wp_ajax_nopriv_aige_contact', 'aige_ajax_contact_handler');

/**
 * ============================================================================
 * 7. TURNKEY DEMO CONTENT & PAGES INSTALLER (ON THEME ACTIVATION)
 * ============================================================================
 */
function aige_theme_activate_setup() {
    if (get_option('aige_demo_installed_v1')) {
        return; // Già configurato in precedenza
    }

    // 1. Crea la pagina Home
    $home_page_id = wp_insert_post(array(
        'post_title'     => 'Home',
        'post_name'      => 'home',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'comment_status' => 'closed'
    ));

    // 2. Crea la pagina Premio Masaniello
    $premio_page_id = wp_insert_post(array(
        'post_title'     => 'Premio Masaniello',
        'post_name'      => 'premio-masaniello',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'comment_status' => 'closed',
        'page_template'  => 'template-premio-masaniello.php'
    ));
    if ($premio_page_id) {
        update_post_meta($premio_page_id, '_wp_page_template', 'template-premio-masaniello.php');
    }

    // 3. Crea la pagina Questa Napoli
    $questa_page_id = wp_insert_post(array(
        'post_title'     => 'Questa Napoli',
        'post_name'      => 'questa-napoli',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'comment_status' => 'closed',
        'page_template'  => 'template-questa-napoli.php'
    ));
    if ($questa_page_id) {
        update_post_meta($questa_page_id, '_wp_page_template', 'template-questa-napoli.php');
    }

    // Imposta la pagina Home come Front Page statica
    if ($home_page_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page_id);
    }

    // 4. Inserimento Edizioni di Default per Premio Masaniello
    $pm_sample_1 = wp_insert_post(array(
        'post_title'   => 'XXI Edizione Premio Masaniello – "Napoletani Protagonisti"',
        'post_content' => 'La solenne cerimonia annuale di consegna della prestigiosa scultura bronzea di Masaniello, realizzata dal maestro Domenico Sepe, a insigni figli di Napoli distintisi nel mondo.',
        'post_excerpt' => 'La solenne cerimonia annuale di consegna della prestigiosa scultura bronzea di Masaniello a insigni figli di Napoli distintisi nel mondo.',
        'post_status'  => 'publish',
        'post_type'    => 'premio_masaniello'
    ));
    if ($pm_sample_1) {
        update_post_meta($pm_sample_1, '_pm_edition_number', 'XXI');
        update_post_meta($pm_sample_1, '_pm_year', '2026');
        update_post_meta($pm_sample_1, '_pm_date', '26 Settembre 2026');
        update_post_meta($pm_sample_1, '_pm_venue', 'Teatro Sannazaro / Castel Nuovo, Napoli');
        update_post_meta($pm_sample_1, '_pm_theme', 'Il Genio Partenopeo e la Gioventù nel Cuore dell\'Europa');
        update_post_meta($pm_sample_1, '_pm_type', 'edizione');
        update_post_meta($pm_sample_1, '_pm_badge', 'Edizione Corrente');
        update_post_meta($pm_sample_1, '_pm_sculpture_note', 'Ogni premiato riceve il caratteristico mezzobusto in bronzo del capopopolo Tommaso Aniello d’Amalfi (Masaniello), modellato e fuso ad arte dallo scultore Domenico Sepe come simbolo perenne di coraggio, dignità e amore per la libertà.');
        $protagonists_1 = "Prof. Antonio De Rosa | Ricerca Biomedica & Oncologia | Per le innovative terapie cellulari applicate nei centri internazionali.\nM° Elena Esposito | Musica Classica & Direzione d'Orchestra | Ambasciatrice dell’arte lirica e sinfonica partenopea nei più celebri teatri europei.\nDott. Salvatore Ferrara | Innovazione Sostenibile & Impresa Giovanile | Per aver rilanciato antichi mestieri artigianali con tecnologie ecologiche d'avanguardia.\nAssociazione Rione Sanità Viva | Impegno Civile & Coesione Sociale | Per l’instancabile opera di accoglienza, riscatto e formazione per i giovani napoletani.";
        update_post_meta($pm_sample_1, '_pm_protagonists', $protagonists_1);
    }

    $pm_sample_2 = wp_insert_post(array(
        'post_title'   => 'XX Edizione del Ventennale – "Venti Anni di Eccellenza Napoletana"',
        'post_content' => 'La storica ventesima edizione del Premio, con un bilancio delle oltre 150 personalità premiate dal 2005 a oggi sotto l\'egida dell\'AIGE.',
        'post_excerpt' => 'La storica ventesima edizione del Premio, con un bilancio delle oltre 150 personalità premiate dal 2005 a oggi sotto l\'egida dell\'AIGE.',
        'post_status'  => 'publish',
        'post_type'    => 'premio_masaniello'
    ));
    if ($pm_sample_2) {
        update_post_meta($pm_sample_2, '_pm_edition_number', 'XX');
        update_post_meta($pm_sample_2, '_pm_year', '2025');
        update_post_meta($pm_sample_2, '_pm_date', 'Ottobre 2025');
        update_post_meta($pm_sample_2, '_pm_venue', 'Maschio Angioino (Sala dei Baroni), Napoli');
        update_post_meta($pm_sample_2, '_pm_theme', 'Due Decenni di Valori, Radici e Testimonianze nel Mondo');
        update_post_meta($pm_sample_2, '_pm_type', 'edizione');
        update_post_meta($pm_sample_2, '_pm_badge', 'Edizione Storica');
        update_post_meta($pm_sample_2, '_pm_sculpture_note', 'Fusione speciale in bronzo con patina celebrativa del ventennale.');
        $protagonists_2 = "Dott.ssa Chiara Monti | Astrofisica & Esplorazione Spaziale | Ricerche internazionali sulla cosmologia e divulgazione scientifica.\nM° Gennaro Cannavacciuolo (in memoriam) | Teatro e Tradizione | Tributo alla grazia e all’eclettismo dell’anima teatrale napoletana.";
        update_post_meta($pm_sample_2, '_pm_protagonists', $protagonists_2);
    }

    $pm_sample_3 = wp_insert_post(array(
        'post_title'   => 'Apertura Segnalazioni e Candidature per la XXII Edizione (2027)',
        'post_content' => 'Il Comitato Promotore dell\'AIGE e la Direzione Artistica aprono formalmente l’invio delle segnalazioni per le candidature della prossima edizione.',
        'post_excerpt' => 'Il Comitato Promotore dell\'AIGE e la Direzione Artistica aprono formalmente l’invio delle segnalazioni per le candidature della prossima edizione.',
        'post_status'  => 'publish',
        'post_type'    => 'premio_masaniello'
    ));
    if ($pm_sample_3) {
        update_post_meta($pm_sample_3, '_pm_edition_number', 'Bando 2027');
        update_post_meta($pm_sample_3, '_pm_year', '2027');
        update_post_meta($pm_sample_3, '_pm_date', 'Scadenza Candidature: 30 Giugno 2027');
        update_post_meta($pm_sample_3, '_pm_venue', 'Segreteria Comitato Scientifico AIGE');
        update_post_meta($pm_sample_3, '_pm_theme', 'Menzione Speciale: "Giovani Talenti Partenopei Under 35"');
        update_post_meta($pm_sample_3, '_pm_type', 'evento');
        update_post_meta($pm_sample_3, '_pm_badge', 'Bando Aperto');
        update_post_meta($pm_sample_3, '_pm_sculpture_note', 'Premio speciale dedicato a giovani ricercatori, artisti e innovatori napoletani.');
    }

    // 5. Inserimento Voci di Default per Questa Napoli
    $qn_sample_1 = wp_insert_post(array(
        'post_title'   => 'Uscita N. 88: "Partenope e il Futuro: Le Nuove Generazioni tra Tradizione e Innovazione"',
        'post_content' => 'All’interno: inchiesta sui talenti emergenti nei quartieri storici, interviste esclusive ai maestri artigiani di San Gregorio Armeno, approfondimento sul restauro dei manoscritti musicali del ‘700 napoletano e la rassegna letteraria cittadina.',
        'post_excerpt' => 'Il nuovo numero monografico di Questa Napoli esplora il legame profondo tra la millenaria memoria napoletana e le aspirazioni dei giovani nel panorama europeo.',
        'post_status'  => 'publish',
        'post_type'    => 'questa_napoli'
    ));
    if ($qn_sample_1) {
        update_post_meta($qn_sample_1, '_qn_date', 'Ottobre 2026');
        update_post_meta($qn_sample_1, '_qn_type', 'rivista');
        update_post_meta($qn_sample_1, '_qn_category', 'Periodico Stracittadino');
        update_post_meta($qn_sample_1, '_qn_badge', 'Nuova Uscita');
        update_post_meta($qn_sample_1, '_qn_author', 'Redazione Questa Napoli & AIGE');
    }

    $qn_sample_2 = wp_insert_post(array(
        'post_title'   => 'Convegno Culturale: "La Lingua Napoletana nel Terzo Millennio: Identità e Riscatto"',
        'post_content' => 'Presso la Sala Storica di Napoli. Interventi su etimologia viva, letteratura contemporanea in lingua napoletana e strumenti digitali per la tutela dell’idioma riconosciuto dall’UNESCO.',
        'post_excerpt' => 'Tavola rotonda pubblica promossa dal periodico Questa Napoli in collaborazione con docenti universitari, scrittori e giovani ricercatori partenopei.',
        'post_status'  => 'publish',
        'post_type'    => 'questa_napoli'
    ));
    if ($qn_sample_2) {
        update_post_meta($qn_sample_2, '_qn_date', '12 Novembre 2026 - Ore 17:30');
        update_post_meta($qn_sample_2, '_qn_type', 'evento');
        update_post_meta($qn_sample_2, '_qn_category', 'Incontro Culturale');
        update_post_meta($qn_sample_2, '_qn_badge', 'Evento in Programma');
        update_post_meta($qn_sample_2, '_qn_author', 'Comitato Editoriale');
    }

    $qn_sample_3 = wp_insert_post(array(
        'post_title'   => 'Retrospettiva Storica: "Le Fonti dell\'Orgoglio Cittadino"',
        'post_content' => 'Un viaggio documentale tra le pagine che hanno raccontato il pensiero di Giambattista Vico, Gaetano Filangieri e la Napoli illuminista che parlava all’intera Europa.',
        'post_excerpt' => 'Ristampa e digitalizzazione dei saggi storici apparsi sui primi numeri del periodico dedicati alla Repubblica Napoletana e ai grandi pensatori civili.',
        'post_status'  => 'publish',
        'post_type'    => 'questa_napoli'
    ));
    if ($qn_sample_3) {
        update_post_meta($qn_sample_3, '_qn_date', 'Archivio Storico');
        update_post_meta($qn_sample_3, '_qn_type', 'approfondimento');
        update_post_meta($qn_sample_3, '_qn_category', 'Storia e Memoria');
        update_post_meta($qn_sample_3, '_qn_badge', 'Archivio Digitale');
        update_post_meta($qn_sample_3, '_qn_author', 'Archivio Storico Questa Napoli');
    }

    // 6. Crea il Menu Primario
    $menu_name = 'Menu Principale AIGE';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        // Aggiungi voci di menu
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'  => __('Chi Siamo', 'aige'),
            'menu-item-url'    => home_url('/#chi-siamo'),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'  => __('Attività & Sezioni', 'aige'),
            'menu-item-url'    => home_url('/#sezioni-aige'),
            'menu-item-status' => 'publish'
        ));

        if ($premio_page_id) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'     => __('🏆 PREMIO MASANIELLO', 'aige'),
                'menu-item-object-id' => $premio_page_id,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-classes'   => 'nav-pill-premio-item'
            ));
        }

        if ($questa_page_id) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'     => __('📰 QUESTANAPOLI', 'aige'),
                'menu-item-object-id' => $questa_page_id,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-classes'   => 'nav-pill-questa-item'
            ));
        }

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'  => __('Sede & Contatti', 'aige'),
            'menu-item-url'    => home_url('/#contatti'),
            'menu-item-status' => 'publish'
        ));

        // Assegna la posizione del menu
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    update_option('aige_demo_installed_v1', 1);
}
add_action('after_switch_theme', 'aige_theme_activate_setup');
