/**
 * AIGE Data Store
 * Gestione dello stato e persistenza locale per "QUESTA NAPOLI" e "PREMIO MASANIELLO"
 * Supporta CRUD completo, autenticazione proprietario, esportazione e importazione JSON.
 */

const STORAGE_KEYS = {
  QUESTA_NAPOLI: 'aige_questa_napoli_data',
  PREMIO_MASANIELLO: 'aige_premio_masaniello_data',
  ADMIN_AUTH: 'aige_admin_session',
  ADMIN_PWD: 'aige_admin_password_hash'
};

// Password predefinita: "aige2026"
const DEFAULT_PASSWORD = 'aige2026';

// Dataset iniziale predefinito e curato per QUESTA NAPOLI
const DEFAULT_QUESTA_NAPOLI = [
  {
    id: 'qn-1',
    title: 'Uscita N. 88: "Partenope e il Futuro: Le Nuove Generazioni tra Tradizione e Innovazione"',
    type: 'rivista', // 'rivista' | 'evento' | 'approfondimento'
    date: 'Ottobre 2026',
    category: 'Periodico Stracittadino',
    summary: 'Il nuovo numero monografico di Questa Napoli esplora il legame profondo tra la millenaria memoria napoletana e le aspirazioni dei giovani nel panorama europeo.',
    content: 'All’interno: inchiesta sui talenti emergenti nei quartieri storici, interviste esclusive ai maestri artigiani di San Gregorio Armeno, approfondimento sul restauro dei manoscritti musicali del ‘700 napoletano e la rassegna letteraria cittadina.',
    badge: 'Nuova Uscita',
    image: 'assets/images/questa_napoli_mag.jpg',
    author: 'Redazione Questa Napoli & AIGE',
    externalLink: '#',
    published: true,
    createdAt: '2026-10-10'
  },
  {
    id: 'qn-2',
    title: 'Convegno Culturale: "La Lingua Napoletana nel Terzo Millennio: Identità e Riscatto"',
    type: 'evento',
    date: '12 Novembre 2026 - Ore 17:30',
    category: 'Incontro Culturale',
    summary: 'Tavola rotonda pubblica promossa dal periodico Questa Napoli in collaborazione con docenti universitari, scrittori e giovani ricercatori partenopei.',
    content: 'Presso la Sala Storica di Napoli. Interventi su etimologia viva, letteratura contemporanea in lingua napoletana e strumenti digitali per la tutela dell’idioma riconosciuto dall’UNESCO.',
    badge: 'Evento in Programma',
    image: 'assets/images/naples_music.jpg',
    author: 'Comitato Editoriale',
    externalLink: '#',
    published: true,
    createdAt: '2026-10-05'
  },
  {
    id: 'qn-3',
    title: 'Retrospettiva Storica: "Le Fonti dell\'Orgoglio Cittadino"',
    type: 'approfondimento',
    date: 'Archivio Storico',
    category: 'Storia e Memoria',
    summary: 'Ristampa e digitalizzazione dei saggi storici apparsi sui primi numeri del periodico dedicati alla Repubblica Napoletana e ai grandi pensatori civili.',
    content: 'Un viaggio documentale tra le pagine che hanno raccontato il pensiero di Giambattista Vico, Gaetano Filangieri e la Napoli illuminista che parlava all’intera Europa.',
    badge: 'Archivio Digitale',
    image: 'assets/images/naples_spaccanapoli.jpg',
    author: 'Archivio Storico Questa Napoli',
    externalLink: '#',
    published: true,
    createdAt: '2026-09-20'
  }
];

// Dataset iniziale predefinito e curato per PREMIO MASANIELLO
const DEFAULT_PREMIO_MASANIELLO = [
  {
    id: 'pm-1',
    editionNumber: 'XXI',
    title: 'XXI Edizione Premio Masaniello – "Napoletani Protagonisti"',
    type: 'edizione', // 'edizione' | 'evento' | 'albo'
    year: '2026',
    date: '26 Settembre 2026',
    venue: 'Teatro Sannazaro / Castel Nuovo, Napoli',
    theme: 'Il Genio Partenopeo e la Gioventù nel Cuore dell\'Europa',
    summary: 'La solenne cerimonia annuale di consegna della prestigiosa scultura bronzea di Masaniello, realizzata dal maestro Domenico Sepe, a insigni figli di Napoli distintisi nel mondo.',
    protagonists: [
      { name: 'Prof. Antonio De Rosa', field: 'Ricerca Biomedica & Oncologia', reason: 'Per le innovative terapie cellulari applicate nei centri internazionali.' },
      { name: 'M° Elena Esposito', field: 'Musica Classica & Direzione d\'Orchestra', reason: 'Ambasciatrice dell’arte lirica e sinfonica partenopea nei più celebri teatri europei.' },
      { name: 'Dott. Salvatore Ferrara', field: 'Innovazione Sostenibile & Impresa Giovanile', reason: 'Per aver rilanciato antichi mestieri artigianali con tecnologie ecologiche d\'avanguardia.' },
      { name: 'Associazione Rione Sanità Viva', field: 'Impegno Civile & Coesione Sociale', reason: 'Per l’instancabile opera di accoglienza, riscatto e formazione per i giovani napoletani.' }
    ],
    sculptureNote: 'Ogni premiato riceve il caratteristico mezzobusto in bronzo del capopopolo Tommaso Aniello d’Amalfi (Masaniello), modellato e fuso ad arte dallo scultore Domenico Sepe come simbolo perenne di coraggio, dignità e amore per la libertà.',
    badge: 'Edizione Corrente',
    image: 'assets/images/premio_masaniello_award.jpg',
    published: true,
    createdAt: '2026-09-28'
  },
  {
    id: 'pm-2',
    editionNumber: 'XX',
    title: 'XX Edizione del Ventennale – "Venti Anni di Eccellenza Napoletana"',
    type: 'edizione',
    year: '2025',
    date: 'Ottobre 2025',
    venue: 'Maschio Angioino (Sala dei Baroni), Napoli',
    theme: 'Due Decenni di Valori, Radici e Testimonianze nel Mondo',
    summary: 'La storica ventesima edizione del Premio, con un bilancio delle oltre 150 personalità premiate dal 2005 a oggi sotto l\'egida dell\'AIGE.',
    protagonists: [
      { name: 'Dott.ssa Chiara Monti', field: 'Astrofisica & Esplorazione Spaziale', reason: 'Ricerche internazionali sulla cosmologia e divulgazione scientifica.' },
      { name: 'M° Gennaro Cannavacciuolo (in memoriam)', field: 'Teatro e Tradizione', reason: 'Tributo alla grazia e all’eclettismo dell’anima teatrale napoletana.' }
    ],
    sculptureNote: 'Fusione speciale in bronzo con patina celebrativa del ventennale.',
    badge: 'Edizione Storica',
    image: 'assets/images/premio_masaniello_award.jpg',
    published: true,
    createdAt: '2025-10-15'
  },
  {
    id: 'pm-3',
    editionNumber: 'Bando 2027',
    title: 'Apertura Segnalazioni e Candidature per la XXII Edizione (2027)',
    type: 'evento',
    year: '2027',
    date: 'Scadenza Candidature: 30 Giugno 2027',
    venue: 'Segreteria Comitato Scientifico AIGE',
    theme: 'Menzione Speciale: "Giovani Talenti Partenopei Under 35"',
    summary: 'Il Comitato Promotore dell\'AIGE e la Direzione Artistica aprono formalmente l’invio delle segnalazioni per le candidature della prossima edizione.',
    protagonists: [],
    sculptureNote: 'Premio speciale dedicato a giovani ricercatori, artisti e innovatori napoletani.',
    badge: 'Bando Aperto',
    image: 'assets/images/aige_napoli_hero.jpg',
    published: true,
    createdAt: '2026-10-01'
  }
];

class AigeStore {
  constructor() {
    this.init();
  }

  init() {
    if (!localStorage.getItem(STORAGE_KEYS.QUESTA_NAPOLI)) {
      localStorage.setItem(STORAGE_KEYS.QUESTA_NAPOLI, JSON.stringify(DEFAULT_QUESTA_NAPOLI));
    }
    if (!localStorage.getItem(STORAGE_KEYS.PREMIO_MASANIELLO)) {
      localStorage.setItem(STORAGE_KEYS.PREMIO_MASANIELLO, JSON.stringify(DEFAULT_PREMIO_MASANIELLO));
    }
    if (!localStorage.getItem(STORAGE_KEYS.ADMIN_PWD)) {
      localStorage.setItem(STORAGE_KEYS.ADMIN_PWD, DEFAULT_PASSWORD);
    }
  }

  // --- GESTIONE QUESTA NAPOLI ---
  getQuestaNapoliItems(onlyPublished = false) {
    try {
      const data = JSON.parse(localStorage.getItem(STORAGE_KEYS.QUESTA_NAPOLI)) || [];
      if (onlyPublished) {
        return data.filter(item => item.published !== false);
      }
      return data;
    } catch (e) {
      console.error('Errore lettura Questa Napoli:', e);
      return DEFAULT_QUESTA_NAPOLI;
    }
  }

  getQuestaNapoliItem(id) {
    const items = this.getQuestaNapoliItems();
    return items.find(it => it.id === id) || null;
  }

  saveQuestaNapoliItem(itemData) {
    const items = this.getQuestaNapoliItems();
    if (itemData.id) {
      // Modifica esistente
      const index = items.findIndex(it => it.id === itemData.id);
      if (index !== -1) {
        items[index] = { ...items[index], ...itemData, updatedAt: new Date().toISOString() };
      } else {
        items.unshift({ ...itemData, id: 'qn-' + Date.now(), createdAt: new Date().toISOString() });
      }
    } else {
      // Nuovo elemento
      const newItem = {
        ...itemData,
        id: 'qn-' + Date.now(),
        createdAt: new Date().toISOString()
      };
      items.unshift(newItem);
    }
    localStorage.setItem(STORAGE_KEYS.QUESTA_NAPOLI, JSON.stringify(items));
    return true;
  }

  deleteQuestaNapoliItem(id) {
    let items = this.getQuestaNapoliItems();
    items = items.filter(it => it.id !== id);
    localStorage.setItem(STORAGE_KEYS.QUESTA_NAPOLI, JSON.stringify(items));
    return true;
  }

  // --- GESTIONE PREMIO MASANIELLO ---
  getPremioMasanielloItems(onlyPublished = false) {
    try {
      const data = JSON.parse(localStorage.getItem(STORAGE_KEYS.PREMIO_MASANIELLO)) || [];
      if (onlyPublished) {
        return data.filter(item => item.published !== false);
      }
      return data;
    } catch (e) {
      console.error('Errore lettura Premio Masaniello:', e);
      return DEFAULT_PREMIO_MASANIELLO;
    }
  }

  getPremioMasanielloItem(id) {
    const items = this.getPremioMasanielloItems();
    return items.find(it => it.id === id) || null;
  }

  savePremioMasanielloItem(itemData) {
    const items = this.getPremioMasanielloItems();
    if (itemData.id) {
      // Modifica esistente
      const index = items.findIndex(it => it.id === itemData.id);
      if (index !== -1) {
        items[index] = { ...items[index], ...itemData, updatedAt: new Date().toISOString() };
      } else {
        items.unshift({ ...itemData, id: 'pm-' + Date.now(), createdAt: new Date().toISOString() });
      }
    } else {
      // Nuovo elemento
      const newItem = {
        ...itemData,
        id: 'pm-' + Date.now(),
        createdAt: new Date().toISOString()
      };
      items.unshift(newItem);
    }
    localStorage.setItem(STORAGE_KEYS.PREMIO_MASANIELLO, JSON.stringify(items));
    return true;
  }

  deletePremioMasanielloItem(id) {
    let items = this.getPremioMasanielloItems();
    items = items.filter(it => it.id !== id);
    localStorage.setItem(STORAGE_KEYS.PREMIO_MASANIELLO, JSON.stringify(items));
    return true;
  }

  // --- AUTENTICAZIONE PROPRIETARIO / ADMIN ---
  isAdminLoggedIn() {
    return sessionStorage.getItem(STORAGE_KEYS.ADMIN_AUTH) === 'true';
  }

  login(password) {
    const stored = localStorage.getItem(STORAGE_KEYS.ADMIN_PWD) || DEFAULT_PASSWORD;
    if (password === stored) {
      sessionStorage.setItem(STORAGE_KEYS.ADMIN_AUTH, 'true');
      return true;
    }
    return false;
  }

  logout() {
    sessionStorage.removeItem(STORAGE_KEYS.ADMIN_AUTH);
  }

  changeAdminPassword(newPassword) {
    if (!newPassword || newPassword.length < 4) {
      throw new Error('La password deve contenere almeno 4 caratteri.');
    }
    localStorage.setItem(STORAGE_KEYS.ADMIN_PWD, newPassword);
    return true;
  }

  // --- IMPORT / EXPORT & RESET ---
  exportAllData() {
    const exportObj = {
      version: '1.0',
      exportedAt: new Date().toISOString(),
      questaNapoli: this.getQuestaNapoliItems(),
      premioMasaniello: this.getPremioMasanielloItems()
    };
    return JSON.stringify(exportObj, null, 2);
  }

  importAllData(jsonString) {
    try {
      const parsed = JSON.parse(jsonString);
      if (parsed.questaNapoli && Array.isArray(parsed.questaNapoli)) {
        localStorage.setItem(STORAGE_KEYS.QUESTA_NAPOLI, JSON.stringify(parsed.questaNapoli));
      }
      if (parsed.premioMasaniello && Array.isArray(parsed.premioMasaniello)) {
        localStorage.setItem(STORAGE_KEYS.PREMIO_MASANIELLO, JSON.stringify(parsed.premioMasaniello));
      }
      return true;
    } catch (e) {
      console.error('Errore importazione JSON:', e);
      return false;
    }
  }

  resetToDefaults() {
    localStorage.setItem(STORAGE_KEYS.QUESTA_NAPOLI, JSON.stringify(DEFAULT_QUESTA_NAPOLI));
    localStorage.setItem(STORAGE_KEYS.PREMIO_MASANIELLO, JSON.stringify(DEFAULT_PREMIO_MASANIELLO));
    localStorage.setItem(STORAGE_KEYS.ADMIN_PWD, DEFAULT_PASSWORD);
    return true;
  }
}

// Istanza globale accessibile dai vari moduli
window.aigeStore = new AigeStore();
