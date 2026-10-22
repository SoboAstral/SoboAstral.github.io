/**
 * AIGE - Admin Dashboard Logic
 * Interfaccia esclusiva per il proprietario per gestire e aggiornare
 * le sezioni "QUESTA NAPOLI" e "PREMIO MASANIELLO".
 */

document.addEventListener('DOMContentLoaded', () => {
  initAuth();
  initTabs();
  initModals();
  initBackupTools();
});

// --- AUTENTICAZIONE PROPRIETARIO ---
function initAuth() {
  const loginScreen = document.getElementById('loginScreen');
  const adminContent = document.getElementById('adminDashboard');
  const loginForm = document.getElementById('adminLoginForm');
  const logoutBtn = document.getElementById('adminLogoutBtn');
  const changePwdBtn = document.getElementById('changePwdBtn');

  const checkState = () => {
    if (window.aigeStore.isAdminLoggedIn()) {
      loginScreen.style.display = 'none';
      adminContent.style.display = 'block';
      refreshAllData();
    } else {
      loginScreen.style.display = 'flex';
      adminContent.style.display = 'none';
    }
  };

  if (loginForm) {
    loginForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const pwd = document.getElementById('adminPasswordInput').value;
      if (window.aigeStore.login(pwd)) {
        showToast('Accesso effettuato con successo. Benvenuto nell\'Area Riservata AIGE.', 'success');
        document.getElementById('adminPasswordInput').value = '';
        checkState();
      } else {
        showToast('Password errata. Riprova con la password predefinita "aige2026"', 'error');
      }
    });
  }

  if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
      window.aigeStore.logout();
      showToast('Disconnessione effettuata.', 'info');
      checkState();
    });
  }

  if (changePwdBtn) {
    changePwdBtn.addEventListener('click', () => {
      const newPwd = prompt('Inserisci la nuova password per l\'Area Riservata (minimo 4 caratteri):');
      if (newPwd) {
        try {
          window.aigeStore.changeAdminPassword(newPwd);
          showToast('Password aggiornata con successo! Conservala con cura.', 'success');
        } catch (err) {
          showToast(err.message, 'error');
        }
      }
    });
  }

  checkState();
}

// --- GESTIONE SCHEDE (TABS) ---
function initTabs() {
  const tabBtns = document.querySelectorAll('.tab-btn[data-tab]');
  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      tabBtns.forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

      btn.classList.add('active');
      const targetPane = document.getElementById(btn.dataset.tab);
      if (targetPane) targetPane.classList.add('active');
    });
  });
}

// --- AGGIORNAMENTO DATI & STATISTICHE ---
function refreshAllData() {
  renderAdminQuestaNapoli();
  renderAdminPremioMasaniello();
  updateStats();
}

function updateStats() {
  const qnItems = window.aigeStore.getQuestaNapoliItems();
  const pmItems = window.aigeStore.getPremioMasanielloItems();

  const qnTotalEl = document.getElementById('statQnTotal');
  const pmTotalEl = document.getElementById('statPmTotal');
  const totalProtagonistsEl = document.getElementById('statProtagonistsTotal');

  if (qnTotalEl) qnTotalEl.textContent = qnItems.length;
  if (pmTotalEl) pmTotalEl.textContent = pmItems.length;

  if (totalProtagonistsEl) {
    const totalProtagonists = pmItems.reduce((acc, curr) => acc + (curr.protagonists ? curr.protagonists.length : 0), 0);
    totalProtagonistsEl.textContent = totalProtagonists;
  }
}

// ==========================================================================
// SEZIONE 1: GESTIONE "QUESTA NAPOLI"
// ==========================================================================
function renderAdminQuestaNapoli() {
  const tableBody = document.getElementById('qnTableBody');
  if (!tableBody) return;

  const items = window.aigeStore.getQuestaNapoliItems();

  if (items.length === 0) {
    tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">Nessun elemento presente per Questa Napoli. Inizia aggiungendone uno!</td></tr>`;
    return;
  }

  tableBody.innerHTML = items.map(item => `
    <tr>
      <td>
        <img src="${item.image || 'assets/images/questa_napoli_mag.jpg'}" class="table-thumb" alt="Anteprima">
      </td>
      <td>
        <strong style="color: #fff; font-size: 0.98rem;">${item.title}</strong>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">${item.summary ? item.summary.substring(0, 70) + '...' : ''}</div>
      </td>
      <td><span style="color: var(--gold-primary);">${item.category || 'Generale'}</span></td>
      <td>${item.date || '-'}</td>
      <td>
        <span class="badge-status ${item.published !== false ? 'status-published' : 'status-draft'}">
          ${item.published !== false ? 'Pubblicato' : 'Bozza'}
        </span>
      </td>
      <td>
        <div class="action-buttons">
          <button class="btn-icon" title="Modifica" onclick="openEditQnModal('${item.id}')">✏️</button>
          <button class="btn-icon btn-delete" title="Elimina" onclick="deleteQnItem('${item.id}')">🗑️</button>
        </div>
      </td>
    </tr>
  `).join('');
}

function openEditQnModal(id = null) {
  const modal = document.getElementById('qnEditModal');
  const form = document.getElementById('qnForm');
  const titleEl = document.getElementById('qnModalTitle');

  form.reset();
  document.getElementById('qnId').value = '';

  if (id) {
    const item = window.aigeStore.getQuestaNapoliItem(id);
    if (!item) return;

    titleEl.textContent = 'Modifica Voce — Questa Napoli';
    document.getElementById('qnId').value = item.id;
    document.getElementById('qnTitle').value = item.title || '';
    document.getElementById('qnCategory').value = item.category || 'Periodico Stracittadino';
    document.getElementById('qnType').value = item.type || 'rivista';
    document.getElementById('qnDate').value = item.date || '';
    document.getElementById('qnBadge').value = item.badge || '';
    document.getElementById('qnSummary').value = item.summary || '';
    document.getElementById('qnContent').value = item.content || '';
    document.getElementById('qnImage').value = item.image || 'assets/images/questa_napoli_mag.jpg';
    document.getElementById('qnAuthor').value = item.author || 'Redazione Questa Napoli';
    document.getElementById('qnPublished').checked = item.published !== false;
  } else {
    titleEl.textContent = 'Aggiungi Nuova Voce — Questa Napoli';
    document.getElementById('qnImage').value = 'assets/images/questa_napoli_mag.jpg';
    document.getElementById('qnPublished').checked = true;
  }

  modal.classList.add('active');
}

function deleteQnItem(id) {
  if (confirm('Sei sicuro di voler eliminare questa voce da "Questa Napoli"? L\'azione è irreversibile.')) {
    window.aigeStore.deleteQuestaNapoliItem(id);
    showToast('Elemento eliminato con successo.', 'info');
    refreshAllData();
  }
}

// ==========================================================================
// SEZIONE 2: GESTIONE "PREMIO MASANIELLO"
// ==========================================================================
function renderAdminPremioMasaniello() {
  const tableBody = document.getElementById('pmTableBody');
  if (!tableBody) return;

  const items = window.aigeStore.getPremioMasanielloItems();

  if (items.length === 0) {
    tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">Nessuna edizione o evento registrato per il Premio Masaniello.</td></tr>`;
    return;
  }

  tableBody.innerHTML = items.map(item => `
    <tr>
      <td>
        <img src="${item.image || 'assets/images/premio_masaniello_award.jpg'}" class="table-thumb" alt="Anteprima">
      </td>
      <td>
        <strong style="color: #fff; font-size: 0.98rem;">${item.title}</strong>
        ${item.editionNumber ? `<span style="font-size: 0.8rem; color: var(--gold-light); margin-left: 6px;">[${item.editionNumber}]</span>` : ''}
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">${item.theme ? 'Tema: ' + item.theme : ''}</div>
      </td>
      <td>${item.year || item.date || '-'}</td>
      <td>
        <span style="font-size: 0.85rem; color: var(--gold-light); font-weight: 600;">
          🌟 ${item.protagonists ? item.protagonists.length : 0} Premiati
        </span>
      </td>
      <td>
        <span class="badge-status ${item.published !== false ? 'status-published' : 'status-draft'}">
          ${item.published !== false ? 'Pubblicato' : 'Bozza'}
        </span>
      </td>
      <td>
        <div class="action-buttons">
          <button class="btn-icon" title="Modifica" onclick="openEditPmModal('${item.id}')">✏️</button>
          <button class="btn-icon btn-delete" title="Elimina" onclick="deletePmItem('${item.id}')">🗑️</button>
        </div>
      </td>
    </tr>
  `).join('');
}

let activeProtagonists = [];

function renderProtagonistsInputs() {
  const container = document.getElementById('pmProtagonistsList');
  if (!container) return;

  if (activeProtagonists.length === 0) {
    container.innerHTML = `<p style="font-size: 0.86rem; color: var(--text-muted); font-style: italic;">Nessun premiato aggiunto finora. Clicca su "+ Aggiungi Premiato".</p>`;
    return;
  }

  container.innerHTML = activeProtagonists.map((p, idx) => `
    <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.8rem; margin-bottom: 0.6rem; display: flex; flex-direction: column; gap: 0.4rem;">
      <div style="display: flex; gap: 0.8rem;">
        <input type="text" class="form-control" placeholder="Nome e Titolo Premiato *" value="${p.name || ''}" onchange="updateProtagonist(${idx}, 'name', this.value)" style="flex: 1.2;">
        <input type="text" class="form-control" placeholder="Settore d'Eccellenza *" value="${p.field || ''}" onchange="updateProtagonist(${idx}, 'field', this.value)" style="flex: 1;">
        <button type="button" class="btn-icon btn-delete" title="Rimuovi" onclick="removeProtagonist(${idx})">✕</button>
      </div>
      <input type="text" class="form-control" placeholder="Motivazione sintetica del riconoscimento" value="${p.reason || ''}" onchange="updateProtagonist(${idx}, 'reason', this.value)">
    </div>
  `).join('');
}

function addProtagonist() {
  activeProtagonists.push({ name: '', field: '', reason: '' });
  renderProtagonistsInputs();
}

function updateProtagonist(index, field, value) {
  if (activeProtagonists[index]) {
    activeProtagonists[index][field] = value.trim();
  }
}

function removeProtagonist(index) {
  activeProtagonists.splice(index, 1);
  renderProtagonistsInputs();
}

function openEditPmModal(id = null) {
  const modal = document.getElementById('pmEditModal');
  const form = document.getElementById('pmForm');
  const titleEl = document.getElementById('pmModalTitle');

  form.reset();
  document.getElementById('pmId').value = '';
  activeProtagonists = [];

  if (id) {
    const item = window.aigeStore.getPremioMasanielloItem(id);
    if (!item) return;

    titleEl.textContent = 'Modifica Edizione / Evento — Premio Masaniello';
    document.getElementById('pmId').value = item.id;
    document.getElementById('pmTitle').value = item.title || '';
    document.getElementById('pmEditionNumber').value = item.editionNumber || '';
    document.getElementById('pmType').value = item.type || 'edizione';
    document.getElementById('pmYear').value = item.year || '';
    document.getElementById('pmDate').value = item.date || '';
    document.getElementById('pmVenue').value = item.venue || '';
    document.getElementById('pmTheme').value = item.theme || '';
    document.getElementById('pmSummary').value = item.summary || '';
    document.getElementById('pmSculptureNote').value = item.sculptureNote || '';
    document.getElementById('pmBadge').value = item.badge || '';
    document.getElementById('pmImage').value = item.image || 'assets/images/premio_masaniello_award.jpg';
    document.getElementById('pmPublished').checked = item.published !== false;

    activeProtagonists = item.protagonists ? JSON.parse(JSON.stringify(item.protagonists)) : [];
  } else {
    titleEl.textContent = 'Aggiungi Nuova Edizione / Evento — Premio Masaniello';
    document.getElementById('pmImage').value = 'assets/images/premio_masaniello_award.jpg';
    document.getElementById('pmPublished').checked = true;
    document.getElementById('pmSculptureNote').value = 'Scultura in bronzo di Masaniello realizzata dal Maestro Domenico Sepe.';
    activeProtagonists = [];
  }

  renderProtagonistsInputs();
  modal.classList.add('active');
}

function deletePmItem(id) {
  if (confirm('Sei sicuro di voler eliminare questa edizione del "Premio Masaniello"? L\'azione è irreversibile.')) {
    window.aigeStore.deletePremioMasanielloItem(id);
    showToast('Edizione eliminata con successo.', 'info');
    refreshAllData();
  }
}

// --- GESTIONE FORM SOTTOMISSIONE ---
function initModals() {
  // Modal Questa Napoli
  const qnModal = document.getElementById('qnEditModal');
  const qnForm = document.getElementById('qnForm');
  const qnClose = document.getElementById('qnModalClose');

  if (qnClose) qnClose.addEventListener('click', () => qnModal.classList.remove('active'));
  if (qnForm) {
    qnForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const id = document.getElementById('qnId').value;
      const title = document.getElementById('qnTitle').value.trim();
      if (!title) {
        showToast('Il titolo è obbligatorio.', 'warning');
        return;
      }

      const itemData = {
        id: id || undefined,
        title: title,
        category: document.getElementById('qnCategory').value.trim(),
        type: document.getElementById('qnType').value,
        date: document.getElementById('qnDate').value.trim(),
        badge: document.getElementById('qnBadge').value.trim(),
        summary: document.getElementById('qnSummary').value.trim(),
        content: document.getElementById('qnContent').value.trim(),
        image: document.getElementById('qnImage').value.trim(),
        author: document.getElementById('qnAuthor').value.trim(),
        published: document.getElementById('qnPublished').checked
      };

      window.aigeStore.saveQuestaNapoliItem(itemData);
      qnModal.classList.remove('active');
      showToast('Sezione "Questa Napoli" aggiornata con successo!', 'success');
      refreshAllData();
    });
  }

  // Modal Premio Masaniello
  const pmModal = document.getElementById('pmEditModal');
  const pmForm = document.getElementById('pmForm');
  const pmClose = document.getElementById('pmModalClose');

  if (pmClose) pmClose.addEventListener('click', () => pmModal.classList.remove('active'));
  if (pmForm) {
    pmForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const id = document.getElementById('pmId').value;
      const title = document.getElementById('pmTitle').value.trim();
      if (!title) {
        showToast('Il titolo dell\'edizione è obbligatorio.', 'warning');
        return;
      }

      // Filtra protagonisti non vuoti
      const validProtagonists = activeProtagonists.filter(p => p.name && p.name.trim() !== '');

      const itemData = {
        id: id || undefined,
        title: title,
        editionNumber: document.getElementById('pmEditionNumber').value.trim(),
        type: document.getElementById('pmType').value,
        year: document.getElementById('pmYear').value.trim(),
        date: document.getElementById('pmDate').value.trim(),
        venue: document.getElementById('pmVenue').value.trim(),
        theme: document.getElementById('pmTheme').value.trim(),
        summary: document.getElementById('pmSummary').value.trim(),
        sculptureNote: document.getElementById('pmSculptureNote').value.trim(),
        badge: document.getElementById('pmBadge').value.trim(),
        image: document.getElementById('pmImage').value.trim(),
        published: document.getElementById('pmPublished').checked,
        protagonists: validProtagonists
      };

      window.aigeStore.savePremioMasanielloItem(itemData);
      pmModal.classList.remove('active');
      showToast('Sezione "Premio Masaniello" aggiornata con successo!', 'success');
      refreshAllData();
    });
  }
}

// --- STRUMENTI, BACKUP JSON & RIPRISTINO ---
function initBackupTools() {
  const exportBtn = document.getElementById('btnExportJson');
  const importFile = document.getElementById('importJsonFile');
  const resetBtn = document.getElementById('btnResetDefaults');

  if (exportBtn) {
    exportBtn.addEventListener('click', () => {
      const dataStr = window.aigeStore.exportAllData();
      const blob = new Blob([dataStr], { type: 'application/json' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      const dateStr = new Date().toISOString().split('T')[0];
      a.href = url;
      a.download = `aige_archivio_backup_${dateStr}.json`;
      a.click();
      URL.revokeObjectURL(url);
      showToast('Archivio JSON scaricato con successo sul tuo computer.', 'success');
    });
  }

  if (importFile) {
    importFile.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = (event) => {
        const content = event.target.result;
        if (window.aigeStore.importAllData(content)) {
          showToast('Dati importati e sincronizzati con successo!', 'success');
          refreshAllData();
        } else {
          showToast('Errore nel formato del file JSON.', 'error');
        }
      };
      reader.readAsText(file);
    });
  }

  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      if (confirm('Attenzione: Ripristinare i dati predefiniti cancellerà le modifiche correnti e ricaricherà il set iniziale. Procedere?')) {
        window.aigeStore.resetToDefaults();
        showToast('Dati predefiniti ripristinati correttamente.', 'info');
        refreshAllData();
      }
    });
  }
}

// Preset immagini helper
function selectImagePreset(targetInputId, imgUrl) {
  const input = document.getElementById(targetInputId);
  if (input) input.value = imgUrl;
  showToast('Immagine di copertina selezionata!', 'info');
}

// Esportazione funzioni globali per richiamo da HTML inline
window.openEditQnModal = openEditQnModal;
window.deleteQnItem = deleteQnItem;
window.openEditPmModal = openEditPmModal;
window.deletePmItem = deletePmItem;
window.addProtagonist = addProtagonist;
window.updateProtagonist = updateProtagonist;
window.removeProtagonist = removeProtagonist;
window.selectImagePreset = selectImagePreset;
