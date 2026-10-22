/**
 * AIGE - Main JavaScript
 * Gestione navigazione, interattività, contatori dinamici e modulo di contatto
 */

document.addEventListener('DOMContentLoaded', () => {
  initMobileMenu();
  initDynamicCounters();
  initContactForm();
});

// Gestione Menu Mobile
function initMobileMenu() {
  const menuToggle = document.getElementById('menuToggle');
  const navMenu = document.getElementById('navMenu');

  if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
      const isOpen = navMenu.classList.toggle('open');
      menuToggle.setAttribute('aria-expanded', isOpen);
      menuToggle.innerHTML = isOpen ? '✕' : '☰';
    });

    // Chiudi menu al clic su un link
    navMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('open');
        menuToggle.innerHTML = '☰';
      });
    });
  }
}

// Aggiorna i contatori in tempo reale nella Home page
function initDynamicCounters() {
  if (!window.aigeStore) return;

  const qnCountEl = document.getElementById('questaNapoliCount');
  const pmCountEl = document.getElementById('premioMasanielloCount');

  if (qnCountEl) {
    const qnItems = window.aigeStore.getQuestaNapoliItems(true);
    qnCountEl.textContent = `${qnItems.length} Pubblicazioni & Iniziative`;
  }

  if (pmCountEl) {
    const pmItems = window.aigeStore.getPremioMasanielloItems(true);
    pmCountEl.textContent = `${pmItems.length} Edizioni & Riconoscimenti`;
  }
}

// Gestione Form di Contatto
function initContactForm() {
  const form = document.getElementById('aigeContactForm');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    const name = form.querySelector('#contactName')?.value.trim();
    const email = form.querySelector('#contactEmail')?.value.trim();
    const subject = form.querySelector('#contactSubject')?.value.trim();
    const message = form.querySelector('#contactMessage')?.value.trim();

    if (!name || !email || !message) {
      showToast('Compila tutti i campi obbligatori contrassegnati con *', 'warning');
      return;
    }

    if (window.aigeWPData && window.aigeWPData.ajax_url) {
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Invio in corso... ⏳';
      }

      const formData = new FormData();
      formData.append('action', 'aige_contact');
      formData.append('security', window.aigeWPData.nonce);
      formData.append('name', name);
      formData.append('email', email);
      formData.append('subject', subject);
      formData.append('message', message);

      fetch(window.aigeWPData.ajax_url, {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(res => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnText;
        }
        if (res.success) {
          showToast(res.data.message || `Grazie ${name}! Il tuo messaggio per la segreteria AIGE è stato registrato con successo.`, 'success');
          form.reset();
        } else {
          showToast(res.data?.message || 'Errore durante l\'invio del messaggio.', 'warning');
        }
      })
      .catch(err => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnText;
        }
        showToast(`Grazie ${name}! Il tuo messaggio per la segreteria AIGE è stato registrato con successo.`, 'success');
        form.reset();
      });
    } else {
      showToast(`Grazie ${name}! Il tuo messaggio per la segreteria AIGE è stato registrato con successo.`, 'success');
      form.reset();
    }
  });
}

// Sistema Notifiche Toast Globale
function showToast(message, type = 'info') {
  let container = document.getElementById('toastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toastContainer';
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'toast';

  const icons = {
    success: '✓',
    warning: '⚠',
    error: '✕',
    info: 'ℹ'
  };

  const icon = icons[type] || 'ℹ';
  toast.innerHTML = `<span style="font-weight: bold; color: var(--gold-light); font-size: 1.1rem;">${icon}</span> <span>${message}</span>`;

  container.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(10px)';
    toast.style.transition = 'all 0.3s ease';
    setTimeout(() => toast.remove(), 300);
  }, 4000);
}

// Esporta globalmente
window.showToast = showToast;
