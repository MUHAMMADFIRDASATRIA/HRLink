<template>
	<div class="page-root">
		<AppSidebar v-model="activeNav" @logout="handleLogout" />

		<div class="main-wrap">
			<AppTopbar username="Admin (HRD)" />

			<div class="content-area">
				<div class="breadcrumb-row">
					<div class="breadcrumb">
						<span class="bc-parent">Master Data</span>
						<span class="bc-sep">/</span>
						<span class="bc-parent">Data PKWT</span>
						<span class="bc-sep">/</span>
						<span class="bc-current">Tambah PKWT</span>
					</div>
				</div>

				<div class="page-head">
					<h1 class="page-title">Tambah PKWT</h1>
					<p class="page-subtitle">Lengkapi informasi untuk menambahkan Perjanjian Kerja Waktu Tertentu (PKWT) untuk karyawan.</p>
				</div>

				<div class="wizard-card">
					<div class="wizard-steps">
						<div
							v-for="(title, index) in stepTitles"
							:key="title"
							class="wizard-step"
							:class="{
								'wizard-step--active': currentStep === index + 1,
								'wizard-step--done': currentStep > index + 1,
							}"
						>
							<div class="wizard-step__circle">
								<svg v-if="currentStep > index + 1" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
									<polyline points="20 6 9 17 4 12" />
								</svg>
								<span v-else>{{ index + 1 }}</span>
							</div>
							<span class="wizard-step__label">{{ title }}</span>
							<div v-if="index < stepTitles.length - 1" class="wizard-step__line"></div>
						</div>
					</div>

					<div class="wizard-body">
						<div class="section-header">
							<h2 class="section-title">{{ stepTitles[currentStep - 1] }}</h2>
							<p class="section-subtitle">{{ stepDescription }}</p>
						</div>

						<div v-if="currentStep === 1" class="panel-card">
							<div class="panel-card__header">
								<div class="panel-icon panel-icon--green">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
								</div>
								<span>Informasi Karyawan</span>
							</div>

							<div class="panel-card__body">
								<div class="field-group field-group--wide">
									<label class="field-label">Nama Karyawan <span class="required">*</span></label>
									<div class="select-wrap">
										<select v-model="form.employee_id" class="field-select" :class="{ 'field-select--error': errors.employee_id }" :disabled="isLoading || isSaving">
											<option :value="null">Pilih karyawan</option>
											<option v-for="employee in employeeOptions" :key="employee.value" :value="employee.value">{{ employee.label }}</option>
										</select>
										<svg class="select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2"><polyline points="6 9 12 15 18 9" /></svg>
									</div>
									<p v-if="errors.employee_id" class="field-error">{{ errors.employee_id }}</p>
								</div>

								<div class="two-col-grid">
									<div class="field-group">
										<label class="field-label">Departemen</label>
										<input :value="autoDepartment" class="field-input field-input--readonly" type="text" readonly placeholder="Otomatis dari data karyawan" />
									</div>

									<div class="field-group">
										<label class="field-label">Jabatan</label>
										<input :value="autoJabatan" class="field-input field-input--readonly" type="text" readonly placeholder="Otomatis dari data karyawan" />
									</div>
								</div>
							</div>

							<div class="panel-card__footer">
								<button class="btn-secondary" type="button" @click="handleCancel">Batal</button>
								<button class="btn-primary" type="button" @click="nextStep">Lanjut</button>
							</div>
						</div>

						<div v-else-if="currentStep === 2" class="panel-card">
							<div class="panel-card__header">
								<div class="panel-icon panel-icon--slate">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
								</div>
								<span>Detail Kontrak</span>
							</div>

							<div class="panel-card__body">
								<div class="two-col-grid">
									<div class="field-group">
										<label class="field-label">Tanggal Mulai <span class="required">*</span></label>
										<input v-model="form.tglMulaiRaw" class="field-input" :class="{ 'field-input--error': errors.tglMulaiRaw }" type="date" />
										<p v-if="errors.tglMulaiRaw" class="field-error">{{ errors.tglMulaiRaw }}</p>
									</div>

									<div class="field-group">
										<label class="field-label">Tanggal Berakhir <span class="required">*</span></label>
										<input v-model="form.tglBerakhirRaw" class="field-input" :class="{ 'field-input--error': errors.tglBerakhirRaw }" type="date" />
										<p v-if="errors.tglBerakhirRaw" class="field-error">{{ errors.tglBerakhirRaw }}</p>
									</div>
								</div>

								<div class="two-col-grid">
									<div class="field-group">
										<label class="field-label">Jenis Kontrak <span class="required">*</span></label>
										<div class="select-wrap">
											<select v-model="form.contract_type" class="field-select" :class="{ 'field-select--error': errors.contract_type }">
												<option v-for="option in contractTypes" :key="option" :value="option">{{ option }}</option>
											</select>
											<svg class="select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2"><polyline points="6 9 12 15 18 9" /></svg>
										</div>
										<p v-if="errors.contract_type" class="field-error">{{ errors.contract_type }}</p>
									</div>

									<div class="field-group">
										<label class="field-label">Tipe Kerja <span class="required">*</span></label>
										<div class="select-wrap">
											<select v-model="form.work_type" class="field-select" :class="{ 'field-select--error': errors.work_type }">
												<option v-for="option in workTypes" :key="option" :value="option">{{ option }}</option>
											</select>
											<svg class="select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2"><polyline points="6 9 12 15 18 9" /></svg>
										</div>
										<p v-if="errors.work_type" class="field-error">{{ errors.work_type }}</p>
									</div>
								</div>

								<div class="two-col-grid two-col-grid--salary">
									<div class="field-group">
										<label class="field-label">Gaji Pokok <span class="required">*</span></label>
										<div class="currency-wrap" :class="{ 'currency-wrap--error': errors.base_salary }">
											<span class="currency-prefix">Rp</span>
											<input v-model="form.base_salary" class="field-input field-input--currency" type="text" inputmode="numeric" placeholder="7500000" />
											<span class="currency-suffix">{{ baseSalaryLabel }}</span>
										</div>
										<p v-if="errors.base_salary" class="field-error">{{ errors.base_salary }}</p>
									</div>

									<div class="field-group">
										<label class="field-label field-label--inline">Tunjangan <span class="field-note">Auto hitung</span></label>
										<div class="currency-wrap">
											<span class="currency-prefix">Rp</span>
											<input v-model="form.allowance" class="field-input field-input--currency" type="text" inputmode="numeric" placeholder="1500000" />
											<span class="currency-suffix">{{ allowanceLabel }}</span>
										</div>
									</div>
								</div>

								<div class="salary-total">
									<span class="salary-total__label">Total Gaji</span>
									<strong class="salary-total__value">{{ totalSalaryLabel }}</strong>
								</div>
							</div>

							<div class="panel-card__footer panel-card__footer--between">
								<button class="btn-secondary" type="button" @click="prevStep">Kembali</button>
								<button class="btn-primary" type="button" @click="nextStep">Lanjut</button>
							</div>
						</div>

						<div v-else class="panel-card">
							<div class="panel-card__header">
								<div class="panel-icon panel-icon--slate">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
								</div>
								<span>Administrasi</span>
							</div>

							<div class="panel-card__body">
								<div class="two-col-grid">
									<div class="field-group">
										<label class="field-label">Penanggung Jawab <span class="required">*</span></label>
										<div class="select-wrap">
											<select v-model="form.responsible_name" class="field-select" :class="{ 'field-select--error': errors.responsible_name }">
												<option v-for="option in responsibleOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
											</select>
											<svg class="select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2"><polyline points="6 9 12 15 18 9" /></svg>
										</div>
										<p v-if="errors.responsible_name" class="field-error">{{ errors.responsible_name }}</p>
									</div>

									<div class="field-group">
										<label class="field-label">Tanggal TTD <span class="required">*</span></label>
										<input v-model="form.signed_date" class="field-input" :class="{ 'field-input--error': errors.signed_date }" type="date" />
										<p v-if="errors.signed_date" class="field-error">{{ errors.signed_date }}</p>
									</div>
								</div>

								<div class="two-col-grid">
									<div class="field-group">
										<label class="field-label">Nomor Kontrak <span class="required">*</span></label>
										<input v-model="form.contract_number" class="field-input" :class="{ 'field-input--error': errors.contract_number }" type="text" placeholder="Masukkan nomor kontrak" />
										<p v-if="errors.contract_number" class="field-error">{{ errors.contract_number }}</p>
									</div>

									<div class="field-group">
										<label class="field-label">Lokasi Kerja <span class="required">*</span></label>
										<input v-model="form.work_location" class="field-input" :class="{ 'field-input--error': errors.work_location }" type="text" placeholder="Masukkan lokasi kerja" />
										<p v-if="errors.work_location" class="field-error">{{ errors.work_location }}</p>
									</div>
								</div>

								<div class="field-group field-group--wide">
									<label class="field-label">Catatan</label>
									<textarea v-model="form.notes" class="field-textarea" rows="4" placeholder="Masukkan catatan tambahan..."></textarea>
								</div>

								<div class="field-group field-group--wide">
									<label class="field-label">Upload Surat PKWT Bertandatangan</label>
									<label class="upload-box">
										<input class="upload-box__input" type="file" accept=".pdf,.jpg,.jpeg,.png" @change="handleSignedContractChange" />
										<div class="upload-box__content">
											<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
											<span>{{ signedContractFileName || 'Klik untuk unggah surat PKWT yang sudah ditandatangani' }}</span>
										</div>
									</label>
								</div>
							</div>

							<div class="panel-card__footer panel-card__footer--between">
								<button class="btn-ghost" type="button" @click="triggerGenerateLetter">Generate Surat PKWT</button>
								<div class="action-group">
									<button class="btn-secondary" type="button" @click="prevStep">Kembali</button>
									<button class="btn-primary" type="button" :disabled="isSaving" @click="handleSubmit">
										<span v-if="isSaving" class="btn-spinner"></span>
										{{ isSaving ? 'Menyimpan...' : 'Simpan' }}
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<Teleport to="body">
					<div class="toast-container">
						<TransitionGroup name="toast">
							<div v-for="toast in toasts" :key="toast.id" class="toast" :class="`toast--${toast.type}`">
								<div class="toast-icon">
									<svg v-if="toast.type === 'success'" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
									<svg v-else width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
								</div>
								<span class="toast-msg">{{ toast.message }}</span>
								<button class="toast-close" @click="removeToast(toast.id)">
									<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
								</button>
							</div>
						</TransitionGroup>
					</div>
				</Teleport>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue'
import AppTopbar from '@/components/AppTopbar.vue'
import { useCreatePkwt } from '@/composables/useCreate'

const {
	activeNav,
	currentStep,
	isLoading,
	isSaving,
	form,
	errors,
	toasts,
	removeToast,
	stepTitles,
	stepDescription,
	employeeOptions,
	responsibleOptions,
	contractTypes,
	workTypes,
	autoDepartment,
	autoJabatan,
	totalSalaryLabel,
	baseSalaryLabel,
	allowanceLabel,
	signedContractFileName,
	nextStep,
	prevStep,
	handleCancel,
	handleSubmit,
	handleLogout,
	handleSignedContractChange,
	triggerGenerateLetter,
} = useCreatePkwt()
</script>

<style scoped>
* { box-sizing: border-box; margin: 0; padding: 0; }

.page-root {
	display: flex;
	height: 100vh;
	width: 100%;
	background: #f0f2f8;
	font-family: 'Segoe UI', system-ui, sans-serif;
	color: #24313f;
	overflow: hidden;
}

.main-wrap {
	flex: 1;
	display: flex;
	flex-direction: column;
	min-width: 0;
	overflow: hidden;
}

.content-area {
	flex: 1;
	overflow-y: auto;
	padding: 24px 28px 40px;
	display: flex;
	flex-direction: column;
	gap: 16px;
	min-height: 0;
}

.content-area::-webkit-scrollbar { width: 5px; }
.content-area::-webkit-scrollbar-track { background: transparent; }
.content-area::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

.breadcrumb-row { margin-bottom: 0; }

.breadcrumb {
	display: flex;
	align-items: center;
	gap: 6px;
	font-size: 13px;
}


.bc-parent { color: #888; }
.bc-sep { color: #bbb; }
.bc-current { color: #1a2e25; font-weight: 600; }

.page-head { margin-bottom: 0; }
.page-title { font-size: 22px; font-weight: 800; color: #1a2e25; letter-spacing: -0.4px; margin-bottom: 8px; }
.page-subtitle { color: #6b7687; font-size: 13.5px; line-height: 1.6; }

.wizard-card {
	background: #fff;
	border-radius: 18px;
	box-shadow: 0 2px 16px rgba(0,0,0,0.06);
	overflow: hidden;
}

.wizard-steps {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 18px;
	padding: 22px 28px 18px;
	border-bottom: 1px solid #f0f2f6;
}

.wizard-step {
	display: flex;
	align-items: center;
	gap: 10px;
	color: #8a94a6;
}

.wizard-step__circle {
	width: 34px;
	height: 34px;
	border-radius: 50%;
	border: 2px solid #e0e4ea;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-shrink: 0;
	font-size: 13px;
	font-weight: 700;
	background: #fff;
	color: #bbb;
	transition: all 0.25s;
}

.wizard-step__label { font-size: 13px; font-weight: 600; white-space: nowrap; transition: color 0.25s; }

.wizard-step__line {
	height: 2px;
	flex: 1;
	background: #e8ecf0;
	margin-left: 4px;
	border-radius: 2px;
	transition: background 0.25s;
}

.wizard-step--active .wizard-step__label { color: #1a2e25; }
.wizard-step--done .wizard-step__label { color: #4db89e; }

.wizard-step--active .wizard-step__circle,
.wizard-step--done .wizard-step__circle {
	background: #2e7d55;
	border-color: #2e7d55;
	color: #fff;
}

.wizard-step--active .wizard-step__circle {
	box-shadow: 0 4px 12px rgba(46,125,85,0.25);
}

.wizard-step--done .wizard-step__circle {
	background: #4db89e;
	border-color: #4db89e;
}

.wizard-step--done .wizard-step__line,
.wizard-step--active .wizard-step__line { background: #4db89e; }

.wizard-body { padding: 24px 28px 4px; }

.section-header { padding: 0 0 18px; }
.section-title { font-size: 18px; font-weight: 800; color: #24313f; margin-bottom: 6px; letter-spacing: -0.2px; }
.section-subtitle { font-size: 13.5px; color: #768093; }

.panel-card {
	background: #fff;
	border: 1px solid #edf1f6;
	border-radius: 18px;
	overflow: hidden;
}

.panel-card__header {
	display: flex;
	align-items: center;
	gap: 10px;
	padding: 16px 28px;
	border-bottom: 1px solid #f0f2f6;
	font-size: 14px;
	font-weight: 800;
}

.panel-icon {
	width: 26px;
	height: 26px;
	border-radius: 8px;
	display: flex;
	align-items: center;
	justify-content: center;
}

.panel-icon--green { background: #e7f6ef; color: #2d7a61; }
.panel-icon--slate { background: #eef2f8; color: #60708c; }

.panel-card__body { padding: 24px 28px 20px; display: flex; flex-direction: column; gap: 16px; }

.panel-card__footer {
	display: flex;
	justify-content: flex-end;
	gap: 12px;
	padding: 16px 28px 22px;
	border-top: 1px solid #f0f2f6;
}

.panel-card__footer--between { justify-content: space-between; }

.field-group { display: flex; flex-direction: column; gap: 5px; }
.field-group--wide { max-width: none; width: 100%; }

.field-row,
.two-col-grid {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 14px;
}

.field-row--triple { grid-template-columns: 1fr 1fr 1fr; }
.two-col-grid--salary { align-items: end; }

.field-label {
	font-size: 12.5px;
	font-weight: 600;
	color: #4a5568;
}

.field-label--inline {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 10px;
}

.field-note {
	font-size: 11.5px;
	font-weight: 600;
	color: #91a0b5;
}

.required { color: #d35b5b; }

.field-input,
.field-select,
.field-textarea {
	width: 100%;
	border: 1.5px solid #e4e8ef;
	border-radius: 10px;
	background: #fafbfd;
	font-family: inherit;
	font-size: 13.5px;
	color: #333;
	outline: none;
	transition: border-color 0.15s, box-shadow 0.15s;
}

.field-input,
.field-select { height: 42px; padding: 0 14px; appearance: none; -webkit-appearance: none; }

.field-textarea { padding: 12px 14px; resize: vertical; min-height: 96px; }

.field-input:focus,
.field-select:focus,
.field-textarea:focus {
	border-color: #4db89e;
	box-shadow: 0 0 0 3px rgba(77,184,158,0.12);
	background: #fff;
}

.field-input--readonly {
	background: #f6f8fb;
	color: #8a94a6;
}

.field-input--error,
.field-select--error,
.currency-wrap--error {
	border-color: #dd5c5c !important;
}

.field-error {
	font-size: 11.5px;
	color: #e05050;
	font-weight: 500;
}

.select-wrap { position: relative; }
.select-arrow {
	position: absolute;
	right: 12px;
	top: 50%;
	transform: translateY(-50%);
	pointer-events: none;
}

.currency-wrap {
	display: grid;
	grid-template-columns: auto 1fr auto;
	align-items: center;
	gap: 10px;
	border: 1.5px solid #e4e8ef;
	border-radius: 10px;
	padding: 0 14px;
	background: #fafbfd;
	height: 42px;
}

.currency-prefix,
.currency-suffix {
	font-size: 13.5px;
	font-weight: 600;
	color: #2d7a61;
}

.field-input--currency {
	border: none;
	box-shadow: none;
	padding: 0;
}

.field-input--currency:focus {
	box-shadow: none;
}

.salary-total {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 14px 16px;
	border: 1px solid #e8ecf4;
	border-radius: 12px;
	background: #f7f9fc;
}

.salary-total__label {
	font-size: 12px;
	font-weight: 600;
	color: #9aa5b4;
}

.salary-total__value {
	font-size: 13.5px;
	font-weight: 700;
	color: #2a3548;
}

.upload-box {
	border: 1.5px dashed #d0dde6;
	border-radius: 12px;
	background: #f7fafb;
	cursor: pointer;
	transition: border-color 0.2s, background 0.2s;
}

.upload-box:hover { border-color: #4db89e; background: #f0faf6; }

.upload-box__input { display: none; }

.upload-box__content {
	display: flex;
	align-items: center;
	gap: 12px;
	padding: 14px 16px;
	font-size: 13.5px;
	color: #60708c;
}

.btn-primary,
.btn-secondary,
.btn-ghost {
	height: 42px;
	border-radius: 11px;
	font-family: inherit;
	font-size: 13.5px;
	font-weight: 700;
	padding: 0 22px;
	cursor: pointer;
	transition: transform 0.12s, opacity 0.15s, background 0.15s;
}

.btn-primary {
	border: none;
	background: #2e7d55;
	color: #fff;
	box-shadow: 0 4px 14px rgba(46,125,85,0.22);
}

.btn-secondary {
	border: 1.5px solid #d8e8de;
	background: #fff;
	color: #2e7d55;
}

.btn-ghost {
	border: 1.5px solid #e0e4ea;
	background: #fff;
	color: #215f4d;
}

.btn-primary:hover,
.btn-secondary:hover,
.btn-ghost:hover { transform: translateY(-1px); }

.btn-primary:hover { background: #256647; transform: translateY(-1px); }

.btn-secondary:hover { background: #f0f8f4; }

.btn-ghost:hover { background: #f7fafb; border-color: #d0dde6; }

.btn-primary:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

.action-group { display: flex; gap: 12px; }

.btn-spinner {
	width: 14px;
	height: 14px;
	border: 2px solid rgba(255,255,255,0.32);
	border-top-color: #fff;
	border-radius: 50%;
	display: inline-block;
	animation: spin 0.7s linear infinite;
	margin-right: 8px;
}

.toast-container {
	position: fixed;
	top: 20px;
	right: 20px;
	z-index: 9999;
	display: flex;
	flex-direction: column;
	gap: 10px;
}

.toast {
	display: flex;
	align-items: center;
	gap: 10px;
	min-width: 260px;
	max-width: 360px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #fff;
	box-shadow: 0 12px 30px rgba(15, 23, 42, 0.14);
	border-left: 4px solid transparent;
}

.toast--success { border-left-color: #2d7a61; color: #1f2937; }
.toast--error { border-left-color: #dd5c5c; color: #5b2323; }
.toast-msg { flex: 1; font-size: 13px; font-weight: 600; }
.toast-close { border: none; background: none; cursor: pointer; color: #94a3b8; }

.toast-enter-from,
.toast-leave-to { opacity: 0; transform: translateX(20px); }
.toast-enter-active,
.toast-leave-active { transition: all 0.22s ease; }

@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 1024px) {
	.wizard-steps,
	.field-row--triple,
	.two-col-grid,
	.two-col-grid--salary {
		grid-template-columns: 1fr;
	}

	.panel-card__footer--between {
		flex-direction: column;
		align-items: stretch;
	}

	.action-group {
		width: 100%;
		justify-content: stretch;
	}

	.action-group > button,
	.panel-card__footer > button,
	.btn-primary,
	.btn-secondary,
	.btn-ghost {
		width: 100%;
	}
}

@media (max-width: 768px) {
	.content-area { padding: 18px 16px 28px; }
	.wizard-steps { padding: 16px; gap: 12px; }
	.wizard-step__label { font-size: 12px; }
	.wizard-body { padding: 18px 16px 12px; }
	.panel-card__header,
	.panel-card__body,
	.panel-card__footer { padding-left: 16px; padding-right: 16px; }
}
</style>
