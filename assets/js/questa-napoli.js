/**
 * QUESTA NAPOLI - Dynamic Controller
 * Gestione del caricamento dinamico, filtraggio e visualizzazione dettagli
 */

document.addEventListener('DOMContentLoaded', () => {
  renderQuestaNapoliItems();
  initFilters();
  initSearch();
  initModal();
});

let currentFilter = 'all';
let currentSearch = '';

function renderQuestaNapoliItems() {
  const grid = document.getElementById('questaNapoliGrid');
  if (!grid || !window.aigeStore) return;

  const items = window.aigeStore.getQuestaNapoliItems(true);

  // Applicazione filtri
  const filtered = items.filter(item => {
    const matchesFilter = (currentFilter === 'all') || (item.type === currentFilter) || (item.category && item.category.toLowerCase().includes(currentFilter.toLowerCase()));
    const query = currentSearch.toLowerCase();
    const matchesSearch = !query || 
      item.title.toLowerCase().includes(query) || 
      (item.summary && item.summary.toLowerCase().includes(query)) ||
      (item.content && item.content.toLowerCase().includes(query));
    
    return matchesFilter && matchesSearch;
  });

  if (filtered.length === 0) {
    grid.innerHTML = `
      <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; background: var(--bg-card); border-radius: var(--radius-md); border: 1px dashed var(--border-subtle);">
        <p style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 1rem;">Nessun articolo o evento trovato con questi filtri.</p>
        <button class="btn btn-outline" onclick="resetFilters()">Reimposta Filtri</button>
      </div>
    `;
    return;
  }

  grid.innerHTML = filtered.map(item => `
    <article class="dynamic-card">
      <div class="card-media">
        <img src="${item.image || (window.resolveAigeAssetUrl ? window.resolveAigeAssetUrl('assets/images/questa_napoli_mag.jpg') : 'assets/images/questa_napoli_mag.jpg')}" alt="${item.title}" loading="lazy">
        ${item.badge ? `<span class="card-badge-floating">${item.badge}</span>` : ''}
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span>📅 ${item.date || 'Data in definizione'}</span>
          <span>🏛️ ${item.category || 'Cultura'}</span>
        </div>
        <h3 class="card-title">${item.title}</h3>
        <p class="card-text">${item.summary || (item.content ? item.content.substring(0, 140) + '...' : '')}</p>
        <div class="card-actions">
          <button class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.88rem;" onclick="openDetailsModal('${item.id}')">
            Approfondisci ➔
          </button>
          <span style="font-size: 0.8rem; color: var(--gold-light);">✍️ ${item.author || 'Redazione'}</span>
        </div>
      </div>
    </article>
  `).join('');
}

function initFilters() {
  const filterBtns = document.querySelectorAll('.filter-btn[data-filter]');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentFilter = btn.dataset.filter;
      renderQuestaNapoliItems();
    });
  });
}

function initSearch() {
  const searchInput = document.getElementById('searchQuestaNapoli');
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      currentSearch = e.target.value.trim();
      renderQuestaNapoliItems();
    });
  }
}

function resetFilters() {
  currentFilter = 'all';
  currentSearch = '';
  const searchInput = document.getElementById('searchQuestaNapoli');
  if (searchInput) searchInput.value = '';
  document.querySelectorAll('.filter-btn').forEach(b => {
    if (b.dataset.filter === 'all') b.classList.add('active');
    else b.classList.remove('active');
  });
  renderQuestaNapoliItems();
}

function initModal() {
  const modal = document.getElementById('detailsModal');
  const closeBtn = document.getElementById('modalCloseBtn');
  if (modal && closeBtn) {
    closeBtn.addEventListener('click', () => modal.classList.remove('active'));
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.remove('active');
    });
  }
}

function openDetailsModal(id) {
  const item = window.aigeStore.getQuestaNapoliItem(id);
  if (!item) return;

  const modal = document.getElementById('detailsModal');
  const modalBody = document.getElementById('modalContent');
  if (!modal || !modalBody) return;

  modalBody.innerHTML = `
    <div style="margin-bottom: 1.5rem;">
      <span class="flagship-badge" style="background: rgba(200, 90, 50, 0.2); color: #ffab91; border: 1px solid rgba(200, 90, 50, 0.4);">
        ${item.category || 'Periodico Stracittadino'}
      </span>
      <h2 style="font-size: 1.8rem; color: #fff; margin: 0.8rem 0 0.5rem 0; line-height: 1.3;">${item.title}</h2>
      <div style="display: flex; gap: 1.5rem; color: var(--gold-primary); font-size: 0.9rem; margin-bottom: 1.2rem;">
        <span>📅 ${item.date}</span>
        <span>✍️ ${item.author || 'Redazione Questa Napoli'}</span>
      </div>
    </div>

    ${item.image ? `
      <div style="border-radius: var(--radius-sm); overflow: hidden; margin-bottom: 1.5rem; max-height: 320px;">
        <img src="${item.image}" alt="${item.title}" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
    ` : ''}

    <div style="font-size: 1.05rem; line-height: 1.7; color: #e2e8f0; margin-bottom: 2rem;">
      ${item.summary ? `<p style="font-weight: 600; color: #fff; margin-bottom: 1rem;">${item.summary}</p>` : ''}
      <p style="white-space: pre-line;">${item.content || 'Nessun dettaglio aggiuntivo disponibile.'}</p>
    </div>

    <div style="border-top: 1px solid var(--border-subtle); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
      <a href="admin.html" class="owner-access-link" title="Area Riservata">🔐 Modifica questa voce</a>
      <button class="btn btn-outline" onclick="document.getElementById('detailsModal').classList.remove('active')">Chiudi</button>
    </div>
  `;

  modal.classList.add('active');
}

window.openDetailsModal = openDetailsModal;
window.resetFilters = resetFilters;
