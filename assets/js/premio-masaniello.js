/**
 * PREMIO MASANIELLO - Dynamic Controller
 * Gestione del caricamento dinamico, edizioni, albo d'oro e premiati
 */

document.addEventListener('DOMContentLoaded', () => {
  renderPremioMasanielloItems();
  initFilters();
  initSearch();
  initModal();
});

let currentFilter = 'all';
let currentSearch = '';

function renderPremioMasanielloItems() {
  const grid = document.getElementById('premioMasanielloGrid');
  if (!grid || !window.aigeStore) return;

  const items = window.aigeStore.getPremioMasanielloItems(true);

  // Applicazione filtri
  const filtered = items.filter(item => {
    const matchesFilter = (currentFilter === 'all') || 
                          (item.type === currentFilter) || 
                          (currentFilter === 'edizione' && item.type === 'edizione') ||
                          (currentFilter === 'evento' && item.type === 'evento');
    
    const query = currentSearch.toLowerCase();
    const matchesSearch = !query || 
      item.title.toLowerCase().includes(query) || 
      (item.theme && item.theme.toLowerCase().includes(query)) ||
      (item.summary && item.summary.toLowerCase().includes(query)) ||
      (item.venue && item.venue.toLowerCase().includes(query)) ||
      (item.protagonists && item.protagonists.some(p => p.name.toLowerCase().includes(query) || p.field.toLowerCase().includes(query)));
    
    return matchesFilter && matchesSearch;
  });

  if (filtered.length === 0) {
    grid.innerHTML = `
      <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; background: var(--bg-card); border-radius: var(--radius-md); border: 1px dashed var(--border-subtle);">
        <p style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 1rem;">Nessuna edizione o evento trovato con questi filtri.</p>
        <button class="btn btn-outline" onclick="resetFilters()">Reimposta Filtri</button>
      </div>
    `;
    return;
  }

  grid.innerHTML = filtered.map(item => `
    <article class="dynamic-card">
      <div class="card-media">
        <img src="${item.image || (window.resolveAigeAssetUrl ? window.resolveAigeAssetUrl('assets/images/premio_masaniello_award.jpg') : 'assets/images/premio_masaniello_award.jpg')}" alt="${item.title}" loading="lazy">
        ${item.badge ? `<span class="card-badge-floating">${item.badge}</span>` : ''}
      </div>
      <div class="card-body">
        <div class="card-meta">
          <span>🏆 ${item.editionNumber ? 'Edizione ' + item.editionNumber : (item.year || 'Edizione Annuale')}</span>
          <span>📅 ${item.date || item.year}</span>
        </div>
        <h3 class="card-title">${item.title}</h3>
        ${item.venue ? `<p style="font-size: 0.88rem; color: var(--gold-light); margin-bottom: 0.6rem;">📍 <em>${item.venue}</em></p>` : ''}
        ${item.theme ? `<p style="font-size: 0.94rem; color: #fff; font-weight: 600; margin-bottom: 0.8rem;">Tema: "${item.theme}"</p>` : ''}
        <p class="card-text">${item.summary || ''}</p>

        ${item.protagonists && item.protagonists.length > 0 ? `
          <div class="protagonists-box">
            <div class="protagonists-title">
              <span>🌟 Protagonisti Premiati (${item.protagonists.length})</span>
            </div>
            ${item.protagonists.slice(0, 3).map(p => `
              <div class="protagonist-item">
                <strong>${p.name}</strong> — <span style="color: var(--gold-primary);">${p.field}</span>
              </div>
            `).join('')}
            ${item.protagonists.length > 3 ? `
              <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.4rem;">
                + altri ${item.protagonists.length - 3} premiati d'eccellenza...
              </div>
            ` : ''}
          </div>
        ` : ''}

        <div class="card-actions">
          <button class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.88rem;" onclick="openPremioDetailsModal('${item.id}')">
            Scheda Completa & Albo ➔
          </button>
          <span style="font-size: 0.8rem; color: var(--gold-light);">AIGE & Comitato Promotore</span>
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
      renderPremioMasanielloItems();
    });
  });
}

function initSearch() {
  const searchInput = document.getElementById('searchPremioMasaniello');
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      currentSearch = e.target.value.trim();
      renderPremioMasanielloItems();
    });
  }
}

function resetFilters() {
  currentFilter = 'all';
  currentSearch = '';
  const searchInput = document.getElementById('searchPremioMasaniello');
  if (searchInput) searchInput.value = '';
  document.querySelectorAll('.filter-btn').forEach(b => {
    if (b.dataset.filter === 'all') b.classList.add('active');
    else b.classList.remove('active');
  });
  renderPremioMasanielloItems();
}

function initModal() {
  const modal = document.getElementById('premioDetailsModal');
  const closeBtn = document.getElementById('premioModalCloseBtn');
  if (modal && closeBtn) {
    closeBtn.addEventListener('click', () => modal.classList.remove('active'));
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.remove('active');
    });
  }
}

function openPremioDetailsModal(id) {
  const item = window.aigeStore.getPremioMasanielloItem(id);
  if (!item) return;

  const modal = document.getElementById('premioDetailsModal');
  const modalBody = document.getElementById('premioModalContent');
  if (!modal || !modalBody) return;

  modalBody.innerHTML = `
    <div style="margin-bottom: 1.5rem;">
      <span class="flagship-badge" style="background: rgba(212, 175, 55, 0.2); color: var(--gold-light); border: 1px solid var(--gold-border);">
        ${item.editionNumber ? 'Edizione ' + item.editionNumber : 'Premio Masaniello'}
      </span>
      <h2 style="font-size: 1.8rem; color: #fff; margin: 0.8rem 0 0.5rem 0; line-height: 1.3;">${item.title}</h2>
      <div style="display: flex; flex-wrap: wrap; gap: 1.2rem; color: var(--gold-primary); font-size: 0.9rem; margin-bottom: 1.2rem;">
        <span>📅 ${item.date || item.year}</span>
        ${item.venue ? `<span>📍 ${item.venue}</span>` : ''}
      </div>
      ${item.theme ? `<p style="font-size: 1.05rem; color: #fff; font-weight: 600; padding: 0.6rem 1rem; background: rgba(212, 175, 55, 0.1); border-left: 3px solid var(--gold-primary); border-radius: 4px;">Tema Ufficiale: ${item.theme}</p>` : ''}
    </div>

    ${item.image ? `
      <div style="border-radius: var(--radius-sm); overflow: hidden; margin-bottom: 1.5rem; max-height: 320px;">
        <img src="${item.image}" alt="${item.title}" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
    ` : ''}

    <div style="font-size: 1.05rem; line-height: 1.7; color: #e2e8f0; margin-bottom: 2rem;">
      <p style="margin-bottom: 1.2rem;">${item.summary || ''}</p>
      
      ${item.sculptureNote ? `
        <div style="background: rgba(8, 19, 36, 0.85); border: 1px solid var(--border-gold); border-radius: var(--radius-sm); padding: 1.2rem; margin-bottom: 1.5rem;">
          <h4 style="font-size: 0.95rem; color: var(--gold-light); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.4rem;">
            🗿 Il Mezzobusto in Bronzo di Domenico Sepe
          </h4>
          <p style="font-size: 0.92rem; color: var(--text-muted);">${item.sculptureNote}</p>
        </div>
      ` : ''}

      ${item.protagonists && item.protagonists.length > 0 ? `
        <h3 style="font-size: 1.3rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 0.5rem;">
          Albo d'Oro dei Premiati di questa Edizione:
        </h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
          ${item.protagonists.map(p => `
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 1rem 1.2rem;">
              <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.3rem;">
                <strong style="font-size: 1.1rem; color: #fff;">${p.name}</strong>
                <span style="font-size: 0.82rem; background: rgba(212, 175, 55, 0.15); color: var(--gold-light); padding: 0.2rem 0.6rem; border-radius: var(--radius-full);">
                  ${p.field}
                </span>
              </div>
              <p style="font-size: 0.92rem; color: var(--text-muted); margin: 0;">${p.reason}</p>
            </div>
          `).join('')}
        </div>
      ` : ''}
    </div>

    <div style="border-top: 1px solid var(--border-subtle); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
      <a href="admin.html" class="owner-access-link" title="Area Riservata">🔐 Modifica questa edizione</a>
      <button class="btn btn-outline" onclick="document.getElementById('premioDetailsModal').classList.remove('active')">Chiudi</button>
    </div>
  `;

  modal.classList.add('active');
}

window.openPremioDetailsModal = openPremioDetailsModal;
window.resetFilters = resetFilters;
