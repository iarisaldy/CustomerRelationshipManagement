/**
 * CUSTOMER RELATIONSHIP MANAGEMENT (CRM) - INTERACTIVE APP ENGINE
 * Developer: Irfan Arisaldy | First Developer Project Revamp Showcase
 */

// --- Application State & Datasets ---
const state = {
  theme: 'dark',
  currentTab: 'dashboard',
  searchQuery: '',
  filters: {
    storeStatus: 'all',
    storeCity: 'all',
    shipStatus: 'all'
  },
  
  // 1. Retail Stores Data (Keaktifan Toko & Distributor)
  customers: [
    { id: 'TKO-101', name: 'Toko Bangunan Jaya Abadi', owner: 'Budi Santoso', city: 'Tuban', type: 'Toko Retail', status: 'Aktif', lastVisit: '2026-07-24', volume: '45.5 Ton' },
    { id: 'TKO-102', name: 'UD Semen Maju Bersama', owner: 'Siti Rahmawati', city: 'Surabaya', type: 'Sub Distributor', status: 'Aktif', lastVisit: '2026-07-26', volume: '120.0 Ton' },
    { id: 'TKO-103', name: 'Toko Material Sentosa', owner: 'Hendra Wijaya', city: 'Gresik', type: 'Toko Retail', status: 'Aktif', lastVisit: '2026-07-20', volume: '30.0 Ton' },
    { id: 'TKO-104', name: 'TB Sumber Makmur', owner: 'Agus Setiawan', city: 'Jakarta', type: 'Toko Retail', status: 'Non-Aktif', lastVisit: '2026-06-15', volume: '0.0 Ton' },
    { id: 'TKO-105', name: 'CV Ciwandan Building Material', owner: 'Deni Kurniawan', city: 'Ciwandan', type: 'Distributor Utama', status: 'Aktif', lastVisit: '2026-07-25', volume: '350.0 Ton' },
    { id: 'TKO-106', name: 'Toko Bangunan Priok Utama', owner: 'Lilik Supriyadi', city: 'Tanjung Priok', type: 'Toko Retail', status: 'Potensial', lastVisit: '2026-07-22', volume: '15.0 Ton' },
    { id: 'TKO-107', name: 'UD Megah Konstruksi', owner: 'Rian Ardianto', city: 'Surabaya', type: 'Sub Distributor', status: 'Aktif', lastVisit: '2026-07-27', volume: '88.0 Ton' },
  ],

  // 2. Shipping & Vessels Data (PMS Shipping - Tanjung Priok, Ciwandan, Tuban)
  vessels: [
    { pkkId: '1000004525', shipName: 'KM TUBAN EXPRESS', callSign: 'YB5421', portLoad: 'TUBAN', portDest: 'PELABUHAN TANJUNG PRIOK', cargo: 'Semen PCC', volume: '5,400 Ton', status: 'Pembongkaran', eta: '27-07-2026 08:30' },
    { pkkId: '1000004526', shipName: 'MV CIWANDAN STAR', callSign: 'PK8901', portLoad: 'TUBAN', portDest: 'PELABUHAN CIWANDAN', cargo: 'Semen PPC', volume: '8,200 Ton', status: 'Sandar', eta: '27-07-2026 14:15' },
    { pkkId: '1000004527', shipName: 'KM SEMEN INDONESIA 01', callSign: 'JZ1102', portLoad: 'TUBAN', portDest: 'PELABUHAN TANJUNG PRIOK', cargo: 'Semen PCC', volume: '6,000 Ton', status: 'Selesai', eta: '26-07-2026 19:00' },
    { pkkId: '1000004528', shipName: 'MV GRESIK MARINER', callSign: 'YB9982', portLoad: 'TUBAN', portDest: 'PELABUHAN TANJUNG PRIOK', cargo: 'Semen PPC', volume: '4,500 Ton', status: 'En Route', eta: '28-07-2026 06:00' },
  ],

  // 3. Sales Pipeline (Kanban Deals)
  deals: [
    { id: 'DEAL-1', title: 'Pengadaan Proyek Perumahan Tuban', client: 'PT Tuban Asri', amount: 'Rp 450.000.000', stage: 'qualification', rep: 'Irfan A.' },
    { id: 'DEAL-2', title: 'Supply Semen Bulk Dermaga Priok', client: 'CV Logistik Nusa', amount: 'Rp 1.200.000.000', stage: 'proposal', rep: 'Budi S.' },
    { id: 'DEAL-3', title: 'Kontrak Tahunan Sub-Distributor Surabaya', client: 'UD Semen Maju', amount: 'Rp 850.000.000', stage: 'negotiation', rep: 'Irfan A.' },
    { id: 'DEAL-4', title: 'Supply Material Tol Ciwandan Phase 2', client: 'PT Banten Karya', amount: 'Rp 2.100.000.000', stage: 'won', rep: 'Deni K.' },
  ],

  // 4. Sales Visit Scheduler
  schedules: [
    { id: 'SCH-1', storeName: 'Toko Bangunan Jaya Abadi', date: '28', month: 'JUL', time: '09:00 WIB', rep: 'Irfan Arisaldy', purpose: 'Kunjungan Rutin & Cek Stok Semen', status: 'Scheduled' },
    { id: 'SCH-2', storeName: 'CV Ciwandan Building Material', date: '29', month: 'JUL', time: '13:30 WIB', rep: 'Deni Kurniawan', purpose: 'Negosiasi Penambahan Kuota Bulk', status: 'Scheduled' },
    { id: 'SCH-3', storeName: 'Toko Material Sentosa', date: '30', month: 'JUL', time: '10:00 WIB', rep: 'Irfan Arisaldy', purpose: 'Audit Keaktifan Toko & Feedback System', status: 'Scheduled' },
  ]
};

// --- DOM Elements Initialization ---
document.addEventListener('DOMContentLoaded', () => {
  initNavigation();
  initThemeToggle();
  initSearchAndFilters();
  initModalForms();
  renderAllViews();
  drawAnalyticsCharts();
});

// --- Navigation Controller ---
function initNavigation() {
  const navButtons = document.querySelectorAll('.nav-item button');
  const tabPanes = document.querySelectorAll('.tab-pane');
  const pageTitle = document.getElementById('page-title');
  const pageSubtitle = document.getElementById('page-subtitle');

  const titles = {
    dashboard: { title: 'Executive Overview', subtitle: 'Real-time sales performance, vessel logistics, and customer activity metrics.' },
    customers: { title: 'Keaktifan Toko & Directory', subtitle: 'Manage retail stores, sub-distributors, and active customer accounts.' },
    logistics: { title: 'PMS Shipping Logistics', subtitle: 'Track vessel schedules, port unloadings, and shipment statuses.' },
    pipeline: { title: 'Sales Pipeline (Kanban)', subtitle: 'Manage deal stages, opportunities, and revenue tracking.' },
    scheduler: { title: 'Visit Scheduler & Operations', subtitle: 'Plan sales representative visits to retail stores and distributors.' },
    vault: { title: 'Memory Vault & Developer Journey', subtitle: 'Showcase of Irfan Arisaldy\'s 1st Developer Project: 2018 CodeIgniter to 2026 Revamp.' }
  };

  navButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const tabName = btn.dataset.tab;
      if (!tabName) return;

      navButtons.forEach(b => b.classList.remove('active'));
      tabPanes.forEach(p => p.classList.remove('active'));

      btn.classList.add('active');
      const targetPane = document.getElementById(`tab-${tabName}`);
      if (targetPane) targetPane.classList.add('active');

      if (titles[tabName]) {
        pageTitle.textContent = titles[tabName].title;
        pageSubtitle.textContent = titles[tabName].subtitle;
      }

      state.currentTab = tabName;
      if (tabName === 'dashboard') {
        setTimeout(drawAnalyticsCharts, 100);
      }
    });
  });
}

// --- Theme Toggle ---
function initThemeToggle() {
  const themeBtn = document.getElementById('theme-toggle-btn');
  themeBtn.addEventListener('click', () => {
    state.theme = state.theme === 'dark' ? 'light' : 'dark';
    document.body.setAttribute('data-theme', state.theme);
    themeBtn.querySelector('svg').style.transform = state.theme === 'light' ? 'rotate(180deg)' : 'rotate(0deg)';
    showToast(`Switched to ${state.theme.toUpperCase()} theme`);
    setTimeout(drawAnalyticsCharts, 100);
  });
}

// --- Search & Filters ---
function initSearchAndFilters() {
  const globalSearch = document.getElementById('global-search');
  if (globalSearch) {
    globalSearch.addEventListener('input', (e) => {
      state.searchQuery = e.target.value.toLowerCase();
      renderCustomerTable();
      renderVesselTable();
    });
  }

  const statusFilter = document.getElementById('filter-store-status');
  if (statusFilter) {
    statusFilter.addEventListener('change', (e) => {
      state.filters.storeStatus = e.target.value;
      renderCustomerTable();
    });
  }

  const cityFilter = document.getElementById('filter-store-city');
  if (cityFilter) {
    cityFilter.addEventListener('change', (e) => {
      state.filters.storeCity = e.target.value;
      renderCustomerTable();
    });
  }
}

// --- Modal & Form Logic ---
function initModalForms() {
  const modalOverlay = document.getElementById('modal-overlay');
  const openBtn = document.getElementById('btn-add-customer');
  const closeBtn = document.getElementById('modal-close-btn');
  const form = document.getElementById('add-customer-form');

  if (openBtn) {
    openBtn.addEventListener('click', () => {
      modalOverlay.classList.add('active');
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      modalOverlay.classList.remove('active');
    });
  }

  if (modalOverlay) {
    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) modalOverlay.classList.remove('active');
    });
  }

  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const newCustomer = {
        id: `TKO-${Math.floor(100 + Math.random() * 900)}`,
        name: document.getElementById('input-store-name').value,
        owner: document.getElementById('input-owner-name').value,
        city: document.getElementById('input-store-city').value,
        type: document.getElementById('input-store-type').value,
        status: 'Aktif',
        lastVisit: new Date().toISOString().split('T')[0],
        volume: '0.0 Ton'
      };

      state.customers.unshift(newCustomer);
      renderAllViews();
      modalOverlay.classList.remove('active');
      form.reset();
      showToast(`Toko "${newCustomer.name}" berhasil ditambahkan!`);
    });
  }

  // About Project Modal Logic
  const aboutOverlay = document.getElementById('about-modal-overlay');
  const btnHeaderAbout = document.getElementById('btn-header-about');
  const btnSidebarAbout = document.getElementById('btn-sidebar-about');
  const aboutCloseBtn = document.getElementById('about-modal-close-btn');

  const openAboutModal = () => {
    if (aboutOverlay) aboutOverlay.classList.add('active');
  };

  if (btnHeaderAbout) btnHeaderAbout.addEventListener('click', openAboutModal);
  if (btnSidebarAbout) btnSidebarAbout.addEventListener('click', openAboutModal);
  if (aboutCloseBtn) {
    aboutCloseBtn.addEventListener('click', () => {
      if (aboutOverlay) aboutOverlay.classList.remove('active');
    });
  }
  if (aboutOverlay) {
    aboutOverlay.addEventListener('click', (e) => {
      if (e.target === aboutOverlay) aboutOverlay.classList.remove('active');
    });
  }
}


// --- Render All Views ---
function renderAllViews() {
  renderCustomerTable();
  renderVesselTable();
  renderKanbanBoard();
  renderScheduler();
  updateMetricsCounters();
}

// --- Render Metrics Counters ---
function updateMetricsCounters() {
  const activeStoresCount = state.customers.filter(c => c.status === 'Aktif').length;
  const activeVesselsCount = state.vessels.filter(v => v.status !== 'Selesai').length;

  const activeStoreElem = document.getElementById('metric-active-stores');
  const activeVesselElem = document.getElementById('metric-active-vessels');

  if (activeStoreElem) activeStoreElem.textContent = activeStoresCount;
  if (activeVesselElem) activeVesselElem.textContent = activeVesselsCount;
}

// --- Render Customer Table ---
function renderCustomerTable() {
  const tbody = document.getElementById('customer-table-body');
  if (!tbody) return;

  const filtered = state.customers.filter(c => {
    const matchesSearch = c.name.toLowerCase().includes(state.searchQuery) ||
                          c.owner.toLowerCase().includes(state.searchQuery) ||
                          c.id.toLowerCase().includes(state.searchQuery);
    const matchesStatus = state.filters.storeStatus === 'all' || c.status === state.filters.storeStatus;
    const matchesCity = state.filters.storeCity === 'all' || c.city === state.filters.storeCity;
    return matchesSearch && matchesStatus && matchesCity;
  });

  if (filtered.length === 0) {
    tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">Tidak ada data toko yang cocok.</td></tr>`;
    return;
  }

  tbody.innerHTML = filtered.map(c => {
    const statusClass = c.status === 'Aktif' ? 'active' : c.status === 'Non-Aktif' ? 'inactive' : 'potential';
    return `
      <tr>
        <td><strong>${c.id}</strong></td>
        <td>
          <div style="font-weight: 600;">${c.name}</div>
          <div style="font-size: 0.75rem; color: var(--text-muted);">${c.type}</div>
        </td>
        <td>${c.owner}</td>
        <td><span style="padding: 2px 8px; background: rgba(255,255,255,0.06); border-radius: 4px; font-size: 0.8rem;">${c.city}</span></td>
        <td><span class="status-badge ${statusClass}">${c.status}</span></td>
        <td>${c.lastVisit}</td>
        <td><strong>${c.volume}</strong></td>
      </tr>
    `;
  }).join('');
}

// --- Render Shipping Vessel Table ---
function renderVesselTable() {
  const tbody = document.getElementById('vessel-table-body');
  if (!tbody) return;

  const filtered = state.vessels.filter(v => {
    return v.shipName.toLowerCase().includes(state.searchQuery) ||
           v.portDest.toLowerCase().includes(state.searchQuery) ||
           v.cargo.toLowerCase().includes(state.searchQuery);
  });

  tbody.innerHTML = filtered.map(v => {
    const statusClass = v.status === 'Selesai' ? 'selesai' : v.status === 'Sandar' ? 'sandar' : 'proses';
    return `
      <tr>
        <td><strong>${v.pkkId}</strong></td>
        <td>
          <div style="font-weight: 700; color: var(--accent-secondary);">${v.shipName}</div>
          <div style="font-size: 0.72rem; color: var(--text-muted);">Callsign: ${v.callSign}</div>
        </td>
        <td>${v.portLoad} &rarr; <strong>${v.portDest}</strong></td>
        <td>${v.cargo} (${v.volume})</td>
        <td><span class="status-badge ${statusClass}">${v.status}</span></td>
        <td>${v.eta}</td>
      </tr>
    `;
  }).join('');
}

// --- Render Kanban Sales Board ---
function renderKanbanBoard() {
  const stages = ['qualification', 'proposal', 'negotiation', 'won'];
  stages.forEach(stage => {
    const container = document.getElementById(`kanban-${stage}`);
    const countElem = document.getElementById(`count-${stage}`);
    if (!container) return;

    const stageDeals = state.deals.filter(d => d.stage === stage);
    if (countElem) countElem.textContent = stageDeals.length;

    container.innerHTML = stageDeals.map(d => `
      <div class="kanban-card">
        <h4>${d.title}</h4>
        <p>${d.client}</p>
        <div class="kanban-card-footer">
          <span>${d.amount}</span>
          <span style="font-size: 0.72rem; color: var(--text-muted);">${d.rep}</span>
        </div>
      </div>
    `).join('');
  });
}

// --- Render Scheduler ---
function renderScheduler() {
  const container = document.getElementById('scheduler-list-container');
  if (!container) return;

  container.innerHTML = state.schedules.map(s => `
    <div class="schedule-card">
      <div class="schedule-info">
        <div class="date-box">
          <span class="day">${s.date}</span>
          <span class="month">${s.month}</span>
        </div>
        <div>
          <h4 style="font-weight: 700;">${s.storeName}</h4>
          <p style="font-size: 0.8rem; color: var(--text-muted);">${s.purpose}</p>
          <div style="font-size: 0.75rem; color: var(--accent-primary); margin-top: 4px;">
            ⏰ ${s.time} | Sales Rep: <strong>${s.rep}</strong>
          </div>
        </div>
      </div>
      <div>
        <span class="status-badge active">${s.status}</span>
      </div>
    </div>
  `).join('');
}

// --- Interactive Canvas Analytics Charts ---
function drawAnalyticsCharts() {
  drawSalesTrendChart();
  drawStoreDistributionChart();
}

function drawSalesTrendChart() {
  const canvas = document.getElementById('salesTrendChart');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  const dpr = window.devicePixelRatio || 1;
  canvas.width = canvas.parentElement.clientWidth * dpr;
  canvas.height = canvas.parentElement.clientHeight * dpr;
  ctx.scale(dpr, dpr);

  const width = canvas.parentElement.clientWidth;
  const height = canvas.parentElement.clientHeight;

  ctx.clearRect(0, 0, width, height);

  // Gradient background area
  const gradient = ctx.createLinearGradient(0, 0, 0, height);
  const isDark = state.theme === 'dark';
  gradient.addColorStop(0, isDark ? 'rgba(99, 102, 241, 0.4)' : 'rgba(79, 70, 229, 0.3)');
  gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

  const dataPoints = [25, 38, 42, 60, 52, 78, 95];
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'];

  const padding = 40;
  const chartWidth = width - padding * 2;
  const chartHeight = height - padding * 2;

  // Draw Gridlines
  ctx.strokeStyle = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
  ctx.lineWidth = 1;
  for (let i = 0; i <= 4; i++) {
    const y = padding + (chartHeight / 4) * i;
    ctx.beginPath();
    ctx.moveTo(padding, y);
    ctx.lineTo(width - padding, y);
    ctx.stroke();
  }

  // Calculate points
  const points = dataPoints.map((val, index) => {
    const x = padding + (chartWidth / (dataPoints.length - 1)) * index;
    const y = height - padding - (val / 100) * chartHeight;
    return { x, y, label: months[index], value: val };
  });

  // Draw fill
  ctx.beginPath();
  ctx.moveTo(points[0].x, height - padding);
  points.forEach(p => ctx.lineTo(p.x, p.y));
  ctx.lineTo(points[points.length - 1].x, height - padding);
  ctx.closePath();
  ctx.fillStyle = gradient;
  ctx.fill();

  // Draw Line
  ctx.beginPath();
  ctx.strokeStyle = isDark ? '#6366f1' : '#4f46e5';
  ctx.lineWidth = 3;
  points.forEach((p, i) => {
    if (i === 0) ctx.moveTo(p.x, p.y);
    else ctx.lineTo(p.x, p.y);
  });
  ctx.stroke();

  // Draw Points & Labels
  points.forEach(p => {
    ctx.beginPath();
    ctx.arc(p.x, p.y, 5, 0, Math.PI * 2);
    ctx.fillStyle = '#06b6d4';
    ctx.fill();
    ctx.strokeStyle = isDark ? '#0f172a' : '#ffffff';
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.fillStyle = isDark ? '#94a3b8' : '#475569';
    ctx.font = '11px Plus Jakarta Sans';
    ctx.textAlign = 'center';
    ctx.fillText(p.label, p.x, height - padding + 20);
  });
}

function drawStoreDistributionChart() {
  const canvas = document.getElementById('storeDistributionChart');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  const dpr = window.devicePixelRatio || 1;
  canvas.width = canvas.parentElement.clientWidth * dpr;
  canvas.height = canvas.parentElement.clientHeight * dpr;
  ctx.scale(dpr, dpr);

  const width = canvas.parentElement.clientWidth;
  const height = canvas.parentElement.clientHeight;

  ctx.clearRect(0, 0, width, height);

  const centerX = width / 2;
  const centerY = height / 2 - 10;
  const radius = Math.min(width, height) / 3;

  const data = [
    { label: 'Tuban', value: 35, color: '#6366f1' },
    { label: 'Surabaya', value: 30, color: '#06b6d4' },
    { label: 'Ciwandan', value: 20, color: '#10b981' },
    { label: 'Tanjung Priok', value: 15, color: '#f59e0b' }
  ];

  let startAngle = 0;
  data.forEach(slice => {
    const sliceAngle = (slice.value / 100) * Math.PI * 2;
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, startAngle, startAngle + sliceAngle);
    ctx.arc(centerX, centerY, radius * 0.55, startAngle + sliceAngle, startAngle, true);
    ctx.closePath();
    ctx.fillStyle = slice.color;
    ctx.fill();
    startAngle += sliceAngle;
  });

  // Legend
  const isDark = state.theme === 'dark';
  ctx.font = '10px Plus Jakarta Sans';
  ctx.textAlign = 'left';
  data.forEach((slice, i) => {
    const lx = 20 + (i % 2) * 120;
    const ly = height - 25 + Math.floor(i / 2) * 15;
    ctx.fillStyle = slice.color;
    ctx.fillRect(lx, ly - 8, 10, 10);
    ctx.fillStyle = isDark ? '#94a3b8' : '#475569';
    ctx.fillText(`${slice.label} (${slice.value}%)`, lx + 15, ly);
  });
}

// --- Toast Notification helper ---
function showToast(message) {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.innerHTML = `
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
    <span>${message}</span>
  `;

  container.appendChild(toast);
  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(100%)';
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}
