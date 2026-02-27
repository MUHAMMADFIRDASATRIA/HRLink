<template>
  <div class="page-root">
    <AppSidebar v-model="activeNav" @logout="handleLogout" />

    <div class="main-wrap">
      <AppTopbar username="Admin (HRD)" />

      <div class="content-area">

        <!-- Breadcrumb + Actions -->
        <div class="top-row">
          <div class="breadcrumb">
            <span class="bc-parent">Master Data</span>
            <span class="bc-sep">/</span>
            <span class="bc-current">Data PKWT</span>
          </div>
          <div class="header-actions">
            <button class="btn-primary" @click="openAddModal">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              Tambah PKWT
            </button>
            <button class="btn-outline">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              Export
            </button>
            <button class="btn-outline">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
              Filter
            </button>
          </div>
        </div>

        <!-- Page Title -->
        <h1 class="page-title">Data PKWT</h1>

        <!-- Stat Cards -->
        <div class="stat-grid">
          <div class="stat-card">
            <div class="stat-icon blue">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div class="stat-info">
              <p class="stat-label">Total PKWT</p>
              <h3 class="stat-value">{{ stats.total }}</h3>
            </div>
            <svg class="stat-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
          </div>

          <div class="stat-card">
            <div class="stat-icon green">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            </div>
            <div class="stat-info">
              <p class="stat-label">Aktif</p>
              <h3 class="stat-value green-val">{{ stats.aktif }}</h3>
            </div>
            <svg class="stat-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
          </div>

          <div class="stat-card">
            <div class="stat-icon yellow">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="stat-info">
              <p class="stat-label">Akan Berakhir</p>
              <h3 class="stat-value yellow-val">{{ stats.akanBerakhir }}</h3>
            </div>
            <svg class="stat-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
          </div>

          <div class="stat-card">
            <div class="stat-icon red">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="stat-info">
              <p class="stat-label">Expired</p>
              <h3 class="stat-value red-val">{{ stats.expired }}</h3>
            </div>
            <svg class="stat-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
          </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">

          <!-- Filters -->
          <div class="filter-bar">
            <div class="search-input">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <input v-model="searchQuery" type="text" placeholder="Cari karyawan..." />
            </div>

            <div class="filter-select">
              <select v-model="filterStatus">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Akan Berakhir">Akan Berakhir</option>
                <option value="Expired">Expired</option>
              </select>
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </div>

            <div class="filter-select">
              <select v-model="filterDept">
                <option value="">Semua Departemen</option>
                <option v-for="d in departemenOptions" :key="d" :value="d">{{ d }}</option>
              </select>
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </div>

            <div class="filter-date">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              <input v-model="filterDate" type="date" />
            </div>

            <button class="btn-filter">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
              Filter
            </button>
          </div>

          <!-- Table -->
          <div class="table-wrap">
            <table class="data-table">
              <thead>
                <tr>
                  <th class="col-no">No</th>
                  <th class="col-nama">Nama Karyawan</th>
                  <th class="col-jabatan">Jabatan</th>
                  <th class="col-dept">Departemen</th>
                  <th class="col-tgl">Tgl Mulai</th>
                  <th class="col-tgl">Tgl Berakhir</th>
                  <th class="col-sisa">Sisa Hari</th>
                  <th class="col-status">Status</th>
                  <th class="col-aksi">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in paginatedData" :key="item.id">
                  <td class="col-no td-no">{{ (currentPage - 1) * perPage + index + 1 }}</td>
                  <td class="col-nama">
                    <div class="karyawan-cell">
                      <div class="avatar-placeholder">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#aaa"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                      </div>
                      <span class="nama-text">{{ item.nama }}</span>
                    </div>
                  </td>
                  <td class="col-jabatan">{{ item.jabatan }}</td>
                  <td class="col-dept">{{ item.departemen }}</td>
                  <td class="col-tgl">{{ item.tglMulai }}</td>
                  <td class="col-tgl">{{ item.tglBerakhir }}</td>
                  <td class="col-sisa">
                    <span :class="sisaClass(item.sisaHari)">
                      <strong>{{ item.sisaHari }}</strong> Hari
                    </span>
                  </td>
                  <td class="col-status">
                    <span :class="statusClass(item.status)">
                      <span class="status-dot"></span>
                      {{ item.status }}
                    </span>
                  </td>
                  <td class="col-aksi">
                    <div class="aksi-wrap">
                      <button class="btn-icon" title="Lihat Detail">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      </button>
                      <template v-if="item.status !== 'Akan Berakhir'">
                        <button class="btn-edit-sm" @click="openEditModal(item)">Edit</button>
                        <button class="btn-more">
                          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                        </button>
                      </template>
                    </div>
                  </td>
                </tr>
                <tr v-if="filteredData.length === 0">
                  <td colspan="9" class="empty-row">Tidak ada data ditemukan.</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="pagination-bar">
            <span class="pg-info-left">
              Showing {{ (currentPage - 1) * perPage + 1 }} to {{ Math.min(currentPage * perPage, filteredData.length) }} of <strong>{{ filteredData.length }}</strong> entries
            </span>

            <div class="pg-controls">
              <button class="pg-btn" :disabled="currentPage === 1" @click="currentPage--">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
              </button>

              <template v-for="p in visiblePages" :key="p">
                <span v-if="p === '...'" class="pg-ellipsis">...</span>
                <button v-else class="pg-num" :class="{ active: p === currentPage }" @click="currentPage = p">{{ p }}</button>
              </template>

              <button class="pg-btn" :disabled="currentPage === totalPages" @click="currentPage++">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
              </button>
            </div>

            <div class="pg-per-page">
              <select v-model="perPage" @change="currentPage = 1">
                <option :value="5">5 / page</option>
                <option :value="10">10 / page</option>
                <option :value="25">25 / page</option>
                <option :value="50">50 / page</option>
              </select>
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- MODAL: Tambah / Edit PKWT -->
    <Teleport to="body">
      <div class="modal-overlay" v-if="showModal" @click.self="closeModal">
        <div class="modal">
          <div class="modal-header">
            <h3>{{ isEditing ? 'Edit PKWT' : 'Tambah PKWT' }}</h3>
            <button class="modal-close" @click="closeModal">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group">
                <label>Nama Karyawan</label>
                <input v-model="form.nama" type="text" placeholder="Masukkan nama" />
              </div>
              <div class="form-group">
                <label>Jabatan</label>
                <input v-model="form.jabatan" type="text" placeholder="Masukkan jabatan" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Departemen</label>
                <select v-model="form.departemen">
                  <option value="" disabled>Pilih departemen</option>
                  <option v-for="d in departemenOptions" :key="d" :value="d">{{ d }}</option>
                </select>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select v-model="form.status">
                  <option value="" disabled>Pilih status</option>
                  <option value="Aktif">Aktif</option>
                  <option value="Akan Berakhir">Akan Berakhir</option>
                  <option value="Expired">Expired</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Tanggal Mulai</label>
                <input v-model="form.tglMulaiRaw" type="date" />
              </div>
              <div class="form-group">
                <label>Tanggal Berakhir</label>
                <input v-model="form.tglBerakhirRaw" type="date" />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn-cancel" @click="closeModal">Batal</button>
            <button class="btn-save" @click="saveData">Simpan</button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import AppSidebar from '@/components/AppSidebar.vue'
import AppTopbar from '@/components/AppTopbar.vue'

const activeNav   = ref('pkwt')
const handleLogout = () => console.log('logout')

// ===== HELPERS =====
const formatDate = (raw) => {
  if (!raw) return ''
  const d = new Date(raw)
  const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des']
  return `${String(d.getDate()).padStart(2,'0')} ${months[d.getMonth()]} ${d.getFullYear()}`
}

const calcSisa = (tglBerakhirRaw) => {
  const now  = new Date(); now.setHours(0,0,0,0)
  const end  = new Date(tglBerakhirRaw)
  return Math.round((end - now) / 86400000)
}

// ===== DATA =====
const pkwtList = ref([
  { id:1, nama:'Budi Santoso',  jabatan:'Staff HRD',      departemen:'HRD & GA',  tglMulai:'01 Mar 2025', tglBerakhir:'31 Des 2025', sisaHari:250,  status:'Aktif'         },
  { id:2, nama:'Siti Rahma',    jabatan:'Supervisor IT',   departemen:'IT',         tglMulai:'15 Jan 2025', tglBerakhir:'15 Nov 2025', sisaHari:205,  status:'Aktif'         },
  { id:3, nama:'Ahmad Fauzi',   jabatan:'Staff IT',        departemen:'IT',         tglMulai:'10 Feb 2025', tglBerakhir:'10 Okt 2025', sisaHari:180,  status:'Aktif'         },
  { id:4, nama:'Dewi Lestari',  jabatan:'Operator',        departemen:'Produksi',   tglMulai:'05 Jan 2025', tglBerakhir:'05 Mei 2025', sisaHari:12,   status:'Akan Berakhir' },
  { id:5, nama:'Rizky Ananda',  jabatan:'Accounting',      departemen:'Finance',    tglMulai:'20 Des 2024', tglBerakhir:'20 Apr 2025', sisaHari:-5,   status:'Expired'       },
  { id:6, nama:'Maya Sari',     jabatan:'Staff Admin',     departemen:'HRD & GA',   tglMulai:'01 Mar 2025', tglBerakhir:'01 Sep 2025', sisaHari:150,  status:'Aktif'         },
  { id:7, nama:'Joko Pratama',  jabatan:'Manager Sales',   departemen:'Sales',      tglMulai:'01 Jan 2025', tglBerakhir:'31 Des 2025', sisaHari:300,  status:'Aktif'         },
])

const departemenOptions = ['HRD & GA','IT','Finance','Produksi','Sales','Marketing','GA']

// ===== STATS =====
const stats = computed(() => ({
  total       : pkwtList.value.length,
  aktif       : pkwtList.value.filter(k => k.status === 'Aktif').length,
  akanBerakhir: pkwtList.value.filter(k => k.status === 'Akan Berakhir').length,
  expired     : pkwtList.value.filter(k => k.status === 'Expired').length,
}))

// ===== FILTERS =====
const searchQuery  = ref('')
const filterStatus = ref('')
const filterDept   = ref('')
const filterDate   = ref('')

const filteredData = computed(() => {
  return pkwtList.value.filter(k => {
    const q = searchQuery.value.toLowerCase()
    const matchSearch = !q || k.nama.toLowerCase().includes(q) || k.jabatan.toLowerCase().includes(q)
    const matchStatus = !filterStatus.value || k.status === filterStatus.value
    const matchDept   = !filterDept.value   || k.departemen === filterDept.value
    return matchSearch && matchStatus && matchDept
  })
})

watch([searchQuery, filterStatus, filterDept, filterDate], () => { currentPage.value = 1 })

// ===== PAGINATION =====
const currentPage = ref(1)
const perPage     = ref(10)

const totalPages = computed(() => Math.max(1, Math.ceil(filteredData.value.length / perPage.value)))

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage.value
  return filteredData.value.slice(start, start + perPage.value)
})

const visiblePages = computed(() => {
  const total = totalPages.value
  const cur   = currentPage.value
  if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1)
  const pages = []
  pages.push(1)
  if (cur > 3) pages.push('...')
  for (let i = Math.max(2, cur - 1); i <= Math.min(total - 1, cur + 1); i++) pages.push(i)
  if (cur < total - 2) pages.push('...')
  pages.push(total)
  return pages
})

// ===== STATUS / SISA STYLES =====
const statusClass = (status) => ({
  'badge-aktif'        : status === 'Aktif',
  'badge-akan'         : status === 'Akan Berakhir',
  'badge-expired'      : status === 'Expired',
})

const sisaClass = (sisa) => ({
  'sisa-normal'  : sisa > 30,
  'sisa-warning' : sisa > 0 && sisa <= 30,
  'sisa-expired' : sisa <= 0,
})

// ===== MODAL =====
const showModal  = ref(false)
const isEditing  = ref(false)
const editingId  = ref(null)
const form       = ref({ nama:'', jabatan:'', departemen:'', status:'', tglMulaiRaw:'', tglBerakhirRaw:'' })

const openAddModal = () => {
  isEditing.value = false
  editingId.value = null
  form.value = { nama:'', jabatan:'', departemen:'', status:'', tglMulaiRaw:'', tglBerakhirRaw:'' }
  showModal.value = true
}

const openEditModal = (item) => {
  isEditing.value = true
  editingId.value = item.id
  form.value = { nama: item.nama, jabatan: item.jabatan, departemen: item.departemen, status: item.status, tglMulaiRaw:'', tglBerakhirRaw:'' }
  showModal.value = true
}

const closeModal = () => { showModal.value = false }

const saveData = () => {
  if (!form.value.nama.trim() || !form.value.departemen || !form.value.status) return
  const tglMulai    = form.value.tglMulaiRaw    ? formatDate(form.value.tglMulaiRaw)    : '-'
  const tglBerakhir = form.value.tglBerakhirRaw ? formatDate(form.value.tglBerakhirRaw) : '-'
  const sisaHari    = form.value.tglBerakhirRaw ? calcSisa(form.value.tglBerakhirRaw) : 0

  if (isEditing.value) {
    const idx = pkwtList.value.findIndex(k => k.id === editingId.value)
    if (idx !== -1) pkwtList.value[idx] = { id: editingId.value, ...form.value, tglMulai, tglBerakhir, sisaHari }
  } else {
    const newId = Math.max(...pkwtList.value.map(k => k.id), 0) + 1
    pkwtList.value.push({ id: newId, ...form.value, tglMulai, tglBerakhir, sisaHari })
  }
  closeModal()
}
</script>

<style scoped>
* { box-sizing: border-box; margin: 0; padding: 0; }

.page-root {
  display: flex;
  height: 100vh;
  width: 100%;
  background: #f0f2f5;
  font-family: 'Segoe UI', system-ui, sans-serif;
  overflow: hidden;
}

.main-wrap {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

/* ===== CONTENT ===== */
.content-area {
  flex: 1;
  overflow-y: auto;
  padding: 24px 28px 40px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.content-area::-webkit-scrollbar       { width: 5px; }
.content-area::-webkit-scrollbar-track { background: transparent; }
.content-area::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

/* ===== TOP ROW ===== */
.top-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
}

.bc-parent  { color: #888; }
.bc-sep     { color: #bbb; }
.bc-current { color: #1a2e25; font-weight: 600; }

.header-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}

.btn-primary {
  display: flex;
  align-items: center;
  gap: 7px;
  background: #2e7d5e;
  color: #fff;
  border: none;
  border-radius: 9px;
  padding: 10px 20px;
  font-size: 13.5px;
  font-weight: 600;
  cursor: pointer;
  font-family: inherit;
  transition: background 0.15s, transform 0.1s;
}
.btn-primary:hover { background: #256b50; transform: translateY(-1px); }

.btn-outline {
  display: flex;
  align-items: center;
  gap: 7px;
  background: #fff;
  color: #444;
  border: 1.5px solid #e0e0e0;
  border-radius: 9px;
  padding: 9px 16px;
  font-size: 13.5px;
  font-weight: 500;
  cursor: pointer;
  font-family: inherit;
  transition: all 0.15s;
}
.btn-outline:hover { background: #f5f5f5; }

/* ===== PAGE TITLE ===== */
.page-title {
  font-size: 22px;
  font-weight: 700;
  color: #1a2e25;
  letter-spacing: -0.4px;
  margin-top: -4px;
}

/* ===== STAT CARDS ===== */
.stat-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}

.stat-card {
  background: #fff;
  border-radius: 14px;
  padding: 18px 20px;
  display: flex;
  align-items: center;
  gap: 14px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(0,0,0,0.04);
  cursor: pointer;
  transition: box-shadow 0.15s;
}
.stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.09); }

.stat-icon {
  width: 44px; height: 44px;
  border-radius: 11px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.stat-icon.blue   { background: #e8f0fe; color: #3d6db5; }
.stat-icon.green  { background: #e6f4ef; color: #2e7d5e; }
.stat-icon.yellow { background: #fef9e7; color: #d4a017; }
.stat-icon.red    { background: #fdecea; color: #d05050; }

.stat-info { flex: 1; }
.stat-label { font-size: 12px; color: #888; margin-bottom: 3px; }
.stat-value { font-size: 28px; font-weight: 700; color: #1a2e25; line-height: 1; }
.stat-value.green-val  { color: #2e7d5e; }
.stat-value.yellow-val { color: #d4a017; }
.stat-value.red-val    { color: #d05050; }

.stat-arrow { flex-shrink: 0; }

/* ===== TABLE CARD ===== */
.table-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 16px rgba(0,0,0,0.04);
  overflow: hidden;
}

/* ===== FILTER BAR ===== */
.filter-bar {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px 20px;
  border-bottom: 1px solid #f0f0f0;
  flex-wrap: wrap;
}

.search-input {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f7f7f9;
  border: 1.5px solid #ebebeb;
  border-radius: 9px;
  padding: 8px 14px;
  flex: 0 0 220px;
}
.search-input input {
  border: none; background: none; outline: none;
  font-size: 13px; color: #444; font-family: inherit; width: 100%;
}
.search-input input::placeholder { color: #bbb; }

.filter-select {
  display: flex;
  align-items: center;
  gap: 6px;
  background: #f7f7f9;
  border: 1.5px solid #ebebeb;
  border-radius: 9px;
  padding: 8px 12px;
  cursor: pointer;
  flex: 0 0 170px;
}
.filter-select select {
  border: none; background: none; outline: none;
  font-size: 13px; color: #555; font-family: inherit;
  cursor: pointer; flex: 1; appearance: none;
}

.filter-date {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f7f7f9;
  border: 1.5px solid #ebebeb;
  border-radius: 9px;
  padding: 8px 12px;
  flex: 0 0 160px;
}
.filter-date input {
  border: none; background: none; outline: none;
  font-size: 13px; color: #555; font-family: inherit;
  cursor: pointer; flex: 1;
}

.btn-filter {
  display: flex;
  align-items: center;
  gap: 7px;
  background: #eaf5f0;
  color: #2e7d5e;
  border: 1.5px solid #c0e0d3;
  border-radius: 9px;
  padding: 8px 16px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  font-family: inherit;
  transition: all 0.15s;
  margin-left: auto;
}
.btn-filter:hover { background: #d8eeea; }

/* ===== TABLE ===== */
.table-wrap { overflow-x: auto; }

.data-table {
  width: 100%;
  border-collapse: collapse;
  min-width: 860px;
}

.data-table thead tr {
  background: #fafafa;
  border-bottom: 1px solid #f0f0f0;
}

.data-table th {
  padding: 12px 14px;
  font-size: 12.5px;
  font-weight: 600;
  color: #666;
  text-align: left;
  white-space: nowrap;
}

.data-table tbody tr {
  border-bottom: 1px solid #f5f5f5;
  transition: background 0.1s;
}
.data-table tbody tr:last-child { border-bottom: none; }
.data-table tbody tr:hover      { background: #fafffe; }

.data-table td {
  padding: 13px 14px;
  font-size: 13.5px;
  color: #2a2a2a;
}

.col-no      { width: 48px; }
.col-nama    { min-width: 160px; }
.col-jabatan { min-width: 130px; }
.col-dept    { min-width: 110px; }
.col-tgl     { min-width: 115px; white-space: nowrap; }
.col-sisa    { min-width: 100px; }
.col-status  { min-width: 130px; }
.col-aksi    { min-width: 120px; }

.td-no { color: #999; font-size: 13px; }

.karyawan-cell {
  display: flex;
  align-items: center;
  gap: 10px;
}

.avatar-placeholder {
  width: 32px; height: 32px;
  border-radius: 50%;
  background: #f0f0f0;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}

.nama-text { font-weight: 600; color: #1a1a1a; }

/* ===== SISA HARI ===== */
.sisa-normal  { color: #2e7d5e; }
.sisa-warning { color: #d4a017; }
.sisa-expired { color: #d05050; }

/* ===== STATUS BADGES ===== */
.badge-aktif,
.badge-akan,
.badge-expired {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 12.5px;
  font-weight: 600;
  white-space: nowrap;
}

.badge-aktif   { background: #e6f4ef; color: #2e7d5e; }
.badge-akan    { background: #fef9e7; color: #d4a017; }
.badge-expired { background: #fdecea; color: #d05050; }

.status-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  background: currentColor;
  flex-shrink: 0;
}

/* ===== AKSI ===== */
.aksi-wrap {
  display: flex;
  align-items: center;
  gap: 6px;
}

.btn-icon {
  width: 30px; height: 30px;
  border: 1.5px solid #e0e0e0;
  border-radius: 7px;
  background: #fff;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: #666;
  transition: all 0.15s;
}
.btn-icon:hover { background: #f5f5f5; color: #333; }

.btn-edit-sm {
  background: #fff;
  border: 1.5px solid #2e7d5e;
  color: #2e7d5e;
  border-radius: 7px;
  padding: 5px 12px;
  font-size: 12.5px;
  font-weight: 600;
  cursor: pointer;
  font-family: inherit;
  transition: all 0.15s;
}
.btn-edit-sm:hover { background: #eaf5f0; }

.btn-more {
  width: 30px; height: 30px;
  border: 1.5px solid #e0e0e0;
  border-radius: 7px;
  background: #fff;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: #999;
  transition: all 0.15s;
}
.btn-more:hover { background: #f5f5f5; color: #555; }

.empty-row {
  text-align: center;
  color: #aaa;
  font-size: 13.5px;
  padding: 32px !important;
}

/* ===== PAGINATION ===== */
.pagination-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 20px;
  border-top: 1px solid #f0f0f0;
  gap: 12px;
  flex-wrap: wrap;
}

.pg-info-left {
  font-size: 13px;
  color: #888;
  white-space: nowrap;
}

.pg-info-left strong { color: #333; }

.pg-controls {
  display: flex;
  align-items: center;
  gap: 4px;
}

.pg-btn {
  width: 32px; height: 32px;
  border: 1.5px solid #e0e0e0;
  border-radius: 8px;
  background: #fff;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: #666;
  transition: all 0.15s;
}
.pg-btn:hover:not(:disabled) { background: #f5f5f5; border-color: #ccc; }
.pg-btn:disabled { opacity: 0.35; cursor: not-allowed; }

.pg-num {
  min-width: 32px; height: 32px;
  border: 1.5px solid #e0e0e0;
  border-radius: 8px;
  background: #fff;
  font-size: 13px;
  color: #555;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  padding: 0 6px;
  font-family: inherit;
  transition: all 0.15s;
}
.pg-num:hover  { background: #f5f5f5; }
.pg-num.active { background: #2e7d5e; border-color: #2e7d5e; color: #fff; font-weight: 700; }

.pg-ellipsis {
  font-size: 13px;
  color: #aaa;
  padding: 0 4px;
  line-height: 32px;
}

.pg-per-page {
  display: flex;
  align-items: center;
  gap: 6px;
  background: #f7f7f9;
  border: 1.5px solid #e0e0e0;
  border-radius: 8px;
  padding: 6px 10px;
}
.pg-per-page select {
  border: none; background: none; outline: none;
  font-size: 13px; color: #555; font-family: inherit;
  cursor: pointer; appearance: none;
}

/* ===== MODAL ===== */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.35);
  display: flex; align-items: center; justify-content: center;
  z-index: 1000;
  backdrop-filter: blur(2px);
}

.modal {
  background: #fff;
  border-radius: 16px;
  width: 560px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.15);
  overflow: hidden;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 24px;
  border-bottom: 1px solid #f0f0f0;
}

.modal-header h3 { font-size: 16px; font-weight: 700; color: #1a2e25; }

.modal-close {
  width: 32px; height: 32px;
  border: none; background: #f5f5f5;
  border-radius: 8px; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: #666; transition: all 0.15s;
}
.modal-close:hover { background: #eee; color: #333; }

.modal-body {
  padding: 24px;
  display: flex; flex-direction: column; gap: 16px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

.form-group {
  display: flex; flex-direction: column; gap: 6px;
}

.form-group label { font-size: 13px; font-weight: 600; color: #444; }

.form-group input,
.form-group select {
  border: 1.5px solid #e0e0e0;
  border-radius: 8px;
  padding: 10px 14px;
  font-size: 14px; color: #333;
  font-family: inherit; outline: none;
  transition: border-color 0.15s; background: #fff;
}
.form-group input:focus,
.form-group select:focus    { border-color: #2e7d5e; }
.form-group input::placeholder { color: #bbb; }

.modal-footer {
  display: flex; align-items: center; justify-content: flex-end;
  gap: 10px; padding: 16px 24px;
  border-top: 1px solid #f0f0f0;
}

.btn-cancel {
  padding: 9px 20px;
  border: 1.5px solid #e0e0e0; border-radius: 8px;
  background: #fff; font-size: 13.5px; font-weight: 600;
  color: #666; cursor: pointer; font-family: inherit;
  transition: all 0.15s;
}
.btn-cancel:hover { background: #f5f5f5; }

.btn-save {
  padding: 9px 20px;
  border: none; border-radius: 8px;
  background: #2e7d5e; font-size: 13.5px; font-weight: 600;
  color: #fff; cursor: pointer; font-family: inherit;
  transition: background 0.15s;
}
.btn-save:hover { background: #256b50; }
</style>