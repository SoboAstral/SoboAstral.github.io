# 🏛️ Guida Ufficiale: Tema WordPress per A.I.G.E. Napoli

Questa guida illustra come installare, configurare e gestire il sito **A.I.G.E. (Associazione Informazione Giovani Europa)** all'interno di **WordPress**.

---

## 📦 Struttura dei File Generati

All'interno della cartella di lavoro troverai:

1. **`aige-theme.zip`**: Pacchetto di installazione compresso, pronto per essere caricato direttamente dal pannello di WordPress (`Aspetto > Temi > Aggiungi nuovo > Carica tema`).
2. **`aige-theme/`**: Cartella sorgente completa del tema WordPress, pronta per essere utilizzata in locale o via FTP/SFTP (`wp-content/themes/aige-theme/`).
3. **I file HTML/CSS/JS statici originali** (`index.html`, `questa-napoli.html`, `premio-masaniello.html`, `admin.html`, `server.js`): rimangono pienamente funzionanti e indipendenti per qualsiasi test locale rapido.

---

## 🚀 1. Come Installare il Tema in WordPress

### Metodo A: Caricamento Rapido da Bacheca WordPress (Consigliato)
1. Accedi al tuo pannello WordPress (`https://tuosito.it/wp-admin/`).
2. Nel menu laterale, vai su **Aspetto > Temi**.
3. Clicca sul pulsante **Aggiungi nuovo tema** in alto, quindi su **Carica tema**.
4. Clicca su **Scegli file** e seleziona il file `aige-theme.zip`.
5. Clicca su **Installa ora**.
6. Al termine del caricamento, clicca su **Attiva**.

### Metodo B: Copia Manuale o via FTP
1. Copia l'intera cartella `aige-theme/` all'interno della directory `wp-content/themes/` della tua installazione WordPress:
   ```text
   wp-content/themes/aige-theme/
   ```
2. Accedi alla bacheca di WordPress in **Aspetto > Temi** e clicca su **Attiva** sotto il tema **A.I.G.E. Napoli**.

---

## ⚡ 2. Configurazione Automatica (Auto-Installer al Primo Avvio)

Non appena attivi il tema, WordPress esegue automaticamente la configurazione iniziale "chiavi in mano":
- **Crea e imposta la Homepage Statica** (pagina "Home" assegnata a Front Page).
- **Crea le Pagine Separate**:
  - `Premio Masaniello` (con modello `template-premio-masaniello.php`).
  - `Questa Napoli` (con modello `template-questa-napoli.php`).
- **Popola i contenuti predefiniti d'esempio**:
  - Le 3 edizioni ufficiali di **Premio Masaniello** (XXI Edizione 2026, XX Edizione del Ventennale 2025, Bando 2027) con albo d'oro dei premiati e nota sulla scultura di Domenico Sepe.
  - Le 3 uscite di **Questa Napoli** (Uscita N. 88, Convegno sulla Lingua Napoletana, Retrospettiva Storica).
- **Crea e assegna il Menu Principale** con i link alle sezioni e i pulsanti pillola in evidenza.

---

## 🏆 3. Gestione "Premio Masaniello" da WordPress

Nel menu laterale della bacheca troverai la voce dedicata **Premio Masaniello** (icona trofeo):

1. **Aggiungere o Modificare un'Edizione**:
   - Vai su **Premio Masaniello > Aggiungi Edizione**.
   - **Titolo**: Inserisci il titolo (es. *XXI Edizione Premio Masaniello – "Napoletani Protagonisti"*).
   - **Testo principale**: Descrizione estesa dell'edizione o della cerimonia.
   - **Immagine in evidenza**: Foto della premiazione o della scultura.
   - **Box Dettagli Edizione & Albo d'Oro**:
     - *Numero Edizione*: es. `XXI`, `XX`, `Bando 2027`.
     - *Anno*: es. `2026`.
     - *Data Cerimonia / Scadenza*: es. `26 Settembre 2026`.
     - *Tipologia*: Edizione Ufficiale, Evento / Bando, oppure Albo d'Oro.
     - *Luogo / Sede*: es. `Teatro Sannazaro / Castel Nuovo, Napoli`.
     - *Tema dell'Edizione*: es. *"Il Genio Partenopeo e la Gioventù nel Cuore dell'Europa"*.
     - *Distintivo / Badge*: es. `Edizione Corrente`, `Edizione Storica`, `Bando Aperto`.
     - *Nota sulla Scultura del M° Domenico Sepe*: Descrizione dell'opera bronzea.
     - *Protagonisti Premiati*: Inserisci i premiati nel formato:
       ```text
       Prof. Antonio De Rosa | Ricerca Biomedica & Oncologia | Per le innovative terapie cellulari applicate nei centri internazionali.
       M° Elena Esposito | Musica Classica | Ambasciatrice dell’arte lirica partenopea nei celebri teatri.
       ```
2. Clicca su **Pubblica** o **Aggiorna**. La pagina pubblica si aggiornerà istantaneamente sia nella visualizzazione schede che nella modale interattiva!

---

## 📰 4. Gestione "Questa Napoli" da WordPress

Nel menu laterale della bacheca troverai la voce **Questa Napoli** (icona libro):

1. **Aggiungere o Modificare un Articolo / Numero della Rivista**:
   - Vai su **Questa Napoli > Aggiungi Uscita / Evento**.
   - **Titolo**: es. *Uscita N. 88: "Partenope e il Futuro: Le Nuove Generazioni tra Tradizione e Innovazione"*.
   - **Testo**: Testo integrale dell'articolo o approfondimento.
   - **Immagine in evidenza**: Copertina della rivista o immagine dell'evento.
   - **Box Dettagli Pubblicazione**:
     - *Data di Uscita o Evento*: es. `Ottobre 2026` o `12 Novembre 2026 - Ore 17:30`.
     - *Tipologia Contenuto*: Uscita Periodico, Incontro Culturale, o Approfondimento / Archivio.
     - *Etichetta Categoria*: es. `Periodico Stracittadino`, `Incontro Culturale`, `Storia e Memoria`.
     - *Badge*: es. `Nuova Uscita`, `Evento in Programma`, `Archivio Digitale`.
     - *Autore*: es. `Redazione Questa Napoli & AIGE`.
     - *Link Esterno / Download PDF*: URL per scaricare la copia digitale.
2. Clicca su **Pubblica**.

---

## ✉️ 5. Modulo di Contatto Rapido (AJAX & Email)

Il form di contatto presente nella Home page (`#contatti`) è integrato direttamente con il motore di WordPress:
- L'invio avviene in **AJAX** senza ricaricare la pagina, con notifica toast istantanea.
- I messaggi vengono inoltrati automaticamente all'indirizzo email dell'amministratore impostato in **Impostazioni > Generali** (*Indirizzo email di amministrazione*).

---

## 🎨 6. Personalizzazione e Menu

- **Logo del Sito**: Puoi impostare il logo ufficiale dell'associazione andando in **Aspetto > Personalizza > Denominazione del sito > Logo**.
- **Menu di Navigazione**: Puoi riordinare le voci o aggiungere nuove pagine in **Aspetto > Menu**.
- **Pulsante "Area Riservata"**: Il pulsante lucchetto 🔐 nella testata e nel footer punta nativamente a `/wp-admin/`, garantendo al proprietario accesso diretto e sicuro alla gestione.

---

## 📂 Dettaglio dei File del Tema (`aige-theme/`)

| File | Funzione |
| :--- | :--- |
| `style.css` | Header del tema WordPress + Design System completo (Notte Napoletana, Oro Regale, Corallo Vesuviano) |
| `functions.php` | CPT `premio_masaniello`, CPT `questa_napoli`, Meta Boxes native, AJAX handler, Auto-Installer e serializzazione dati |
| `header.php` | Testata HTML5, navigazione responsive, logo personalizzato e link admin |
| `footer.php` | Footer a 4 colonne, link istituzionali, copyright e `wp_footer()` |
| `front-page.php` | Homepage istituzionale con contatori dinamici, Chi Siamo, 5 sezioni cardinali e form contatti |
| `template-premio-masaniello.php` | Modello pagina Premio Masaniello con filtri dinamici, ricerca in tempo reale e modale albo d'oro |
| `template-questa-napoli.php` | Modello pagina Questa Napoli con filtri per tipologia, archivio uscite e modale articoli |
| `single-premio_masaniello.php` | Scheda dedicata per la singola edizione del Premio Masaniello (ottimizzata SEO e condivisibile) |
| `single-questa_napoli.php` | Scheda dedicata per il singolo articolo o numero monografico di Questa Napoli |
| `single.php` / `page.php` | Modelli standard per post e pagine generiche WordPress |
| `index.php` / `archive.php` | Template di archivio e fallback con paginazione nativa |
| `404.php` | Pagina errore 404 personalizzata con estetica AIGE |
| `screenshot.png` | Anteprima grafica per la schermata Temi di WordPress (1200x900px) |
| `assets/` | Cartella contenente CSS, immagini (`.jpg`) e JavaScript funzionali sincronizzati con WordPress |
