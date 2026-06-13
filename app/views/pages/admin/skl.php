<?php
$jamPengumuman = '';
if (!empty($skl['jam_pengumuman'])) {
  $jamPengumuman = str_replace(' ', 'T', substr((string)$skl['jam_pengumuman'], 0, 16));
}
?>

<style>
.skl-tabs {
  display: flex;
  gap: 8px;
  margin-bottom: 24px;
  background: #f1f5f9;
  padding: 6px;
  border-radius: 16px;
}
.tab-btn {
  flex: 1;
  padding: 10px 20px;
  border-radius: 12px;
  border: none;
  background: transparent;
  color: #64748b;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}
.tab-btn:hover:not(.active) {
  background: rgba(255,255,255,0.5);
  color: #475569;
}
.tab-btn.active {
  background: #fff;
  color: var(--primary);
  box-shadow: 0 4px 14px rgba(0,0,0,0.05);
}
.tab-pane {
  display: none;
  animation: fadeIn 0.4s ease forwards;
}
.tab-pane.active {
  display: block;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.premium-input-wrap {
  position: relative;
}
.premium-input-wrap i {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 20px;
  pointer-events: none;
}
.premium-input {
  width: 100%;
  padding-left: 42px;
  height: 42px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 14px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  transition: all 0.3s ease;
  outline: none;
  color: #1e293b;
}
.premium-input:focus {
  background: #fff;
  border-color: #818cf8;
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}
.premium-label {
  font-weight: 600;
  color: #334155;
  margin-bottom: 6px;
  display: block;
}
.premium-card {
  background: #fff;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  padding: 24px;
}
</style>

<div style="width: 100%;">
  <div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <h1 class="page-title-sm" style="display: flex; align-items: center; gap: 12px; font-size: 24px; font-weight: 800; color: #1e293b; margin: 0;">
      <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(79,70,229,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
        <i class='bx bx-cog' style="font-size: 22px;"></i>
      </div>
      Pengaturan SKL
    </h1>
    
    <button type="submit" form="form-skl" class="btn btn-primary" style="height: 44px; border-radius: 12px; font-weight: 700; padding: 0 24px; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(79,70,229,0.3); background: linear-gradient(135deg, var(--primary), #6366f1); border: none; color: #fff; font-size: 14.5px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
      <i class='bx bx-save' style="font-size: 20px;"></i> Simpan Pengaturan
    </button>
  </div>

  <div class="skl-tabs">
    <button type="button" class="tab-btn active" onclick="openTab('tab-profil')">
      <i class='bx bx-buildings'></i> Profil Sekolah
    </button>
    <button type="button" class="tab-btn" onclick="openTab('tab-kelulusan')">
      <i class='bx bx-calendar-star'></i> Kelulusan & Narasi
    </button>
    <button type="button" class="tab-btn" onclick="openTab('tab-berkas')">
      <i class='bx bx-image-add'></i> Logo & Stempel
    </button>
  </div>

  <form id="form-skl" class="premium-card" action="<?= url('/admin/skl' . ($skl ? '/' . $skl['id'] : '')) ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- TAB 1: PROFIL SEKOLAH -->
    <div id="tab-profil" class="tab-pane active">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
        <div class="form-group" style="margin:0;">
          <label class="premium-label">Nama Sekolah <span style="color:var(--danger)">*</span></label>
          <div class="premium-input-wrap">
            <i class='bx bx-building'></i>
            <input type="text" name="nama_sekolah" class="premium-input" value="<?= e($skl['nama_sekolah'] ?? '') ?>" placeholder="Contoh: SMP Negeri 240 Jakarta" required>
          </div>
        </div>
        <div class="form-group" style="margin:0;">
          <label class="premium-label">Tahun Ajaran <span style="color:var(--danger)">*</span></label>
          <div class="premium-input-wrap">
            <i class='bx bx-calendar'></i>
            <input type="text" name="tahun_ajaran" class="premium-input" value="<?= e($skl['tahun_ajaran'] ?? '') ?>" placeholder="2025/2026" required>
          </div>
        </div>
      </div>
      
      <div class="form-group" style="margin-bottom:24px;">
        <label class="premium-label">Alamat Kop Surat</label>
        <div class="premium-input-wrap">
          <i class='bx bx-map' style="top: 24px;"></i>
          <textarea name="alamat_sekolah" class="premium-input" rows="2" style="height:auto; padding-top:12px; padding-bottom:12px;" placeholder="Contoh: Jl. ..., Kota ..."><?= e($skl['alamat_sekolah'] ?? '') ?></textarea>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <div class="form-group" style="margin:0;">
          <label class="premium-label">Kepala Sekolah <span style="color:var(--danger)">*</span></label>
          <div class="premium-input-wrap">
            <i class='bx bx-user'></i>
            <input type="text" name="nama_kepsek" class="premium-input" value="<?= e($skl['nama_kepsek'] ?? '') ?>" placeholder="Nama lengkap beserta gelar akademik" required>
          </div>
        </div>
        <div class="form-group" style="margin:0;">
          <label class="premium-label">NIP Kepala Sekolah</label>
          <div class="premium-input-wrap">
            <i class='bx bx-id-card'></i>
            <input type="text" name="nip_kepsek" class="premium-input" value="<?= e($skl['nip_kepsek'] ?? '') ?>" placeholder="Masukkan NIP jika ada">
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 2: PENGUMUMAN & KELULUSAN -->
    <div id="tab-kelulusan" class="tab-pane">
      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 24px; margin-bottom: 20px;">
        <div class="form-group" style="margin:0;">
          <label class="premium-label">Nomor Surat SKL</label>
          <div class="premium-input-wrap">
            <i class='bx bx-file'></i>
            <input type="text" name="no_surat" class="premium-input" value="<?= e($skl['no_surat'] ?? '421.3 / ... / 2026') ?>" placeholder="Misal: 421.3 / ... / 2026">
          </div>
        </div>
        <div class="form-group" style="margin:0;">
          <label class="premium-label">Tanggal Kelulusan <span style="color:var(--danger)">*</span></label>
          <div class="premium-input-wrap">
            <input type="date" name="tgl_kelulusan" class="premium-input" style="padding-left:16px;" value="<?= e($skl['tgl_kelulusan'] ?? '') ?>" required>
          </div>
        </div>
        <div class="form-group" style="margin:0;">
          <label class="premium-label">Tanggal Cetak <span style="color:var(--danger)">*</span></label>
          <div class="premium-input-wrap">
            <input type="date" name="tgl_cetak" class="premium-input" style="padding-left:16px;" value="<?= e($skl['tgl_cetak'] ?? '') ?>" required>
          </div>
        </div>
        <div class="form-group" style="margin:0;">
          <label class="premium-label">Nilai KKM <span style="color:var(--danger)">*</span></label>
          <div class="premium-input-wrap">
            <i class='bx bx-target-lock'></i>
            <input type="number" step="0.01" min="0" max="100" name="nilai_minimum" class="premium-input" value="<?= e($skl['nilai_minimum'] ?? '60') ?>" required>
          </div>
        </div>
      </div>

      <div class="form-group" style="margin-bottom:20px;">
        <label class="premium-label">Buka Pengumuman <span style="color:var(--danger)">*</span></label>
        <div class="premium-input-wrap">
          <input type="datetime-local" name="jam_pengumuman" class="premium-input" style="padding-left:16px;" value="<?= e($jamPengumuman) ?>" required>
        </div>
      </div>

      <div class="form-group" style="margin:0;">
        <label class="premium-label">Narasi Pembuka</label>
        <div class="premium-input-wrap">
          <i class='bx bx-text' style="top:24px;"></i>
          <textarea name="narasi" class="premium-input" rows="3" style="height:auto; padding-top:12px; padding-bottom:12px;" placeholder="Yang bertanda tangan di bawah ini..."><?= e($skl['narasi'] ?? '') ?></textarea>
        </div>
      </div>
    </div>

    <!-- TAB 3: BERKAS & LOGO -->
    <div id="tab-berkas" class="tab-pane">
      <div class="skl-upload-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:24px;">
        <div class="skl-upload-card" style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:16px; text-align:center;">
          <label class="premium-label">Logo Sekolah</label>
          <div class="skl-upload-preview" style="height:90px; margin:12px 0; background:#fff; border-radius:8px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
            <?php if (!empty($skl['logo'])): ?>
              <img src="<?= asset('uploads/' . $skl['logo']) ?>" style="max-height:100%;" alt="Logo sekolah">
            <?php else: ?>
              <span style="color:#cbd5e1; display:flex; flex-direction:column; align-items:center;"><i class='bx bx-image' style="font-size:32px;"></i></span>
            <?php endif; ?>
          </div>
          <input type="file" name="logo" class="form-control" style="font-size:13px;" accept="image/*">
        </div>

        <div class="skl-upload-card" style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:16px; text-align:center;">
          <label class="premium-label">Stempel Sekolah</label>
          <div class="skl-upload-preview" style="height:90px; margin:12px 0; background:#fff; border-radius:8px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
            <?php if (!empty($skl['stempel'])): ?>
              <img src="<?= asset('uploads/' . $skl['stempel']) ?>" style="max-height:100%;" alt="Stempel sekolah">
            <?php else: ?>
              <span style="color:#cbd5e1; display:flex; flex-direction:column; align-items:center;"><i class='bx bx-stamp' style="font-size:32px;"></i></span>
            <?php endif; ?>
          </div>
          <input type="file" name="stempel" class="form-control" style="font-size:13px;" accept="image/*">
        </div>

        <div class="skl-upload-card" style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:16px; text-align:center;">
          <label class="premium-label">Ttd Kepsek</label>
          <div class="skl-upload-preview" style="height:90px; margin:12px 0; background:#fff; border-radius:8px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
            <?php if (!empty($skl['ttd'])): ?>
              <img src="<?= asset('uploads/' . $skl['ttd']) ?>" style="max-height:100%;" alt="Tanda tangan">
            <?php else: ?>
              <span style="color:#cbd5e1; display:flex; flex-direction:column; align-items:center;"><i class='bx bx-pen' style="font-size:32px;"></i></span>
            <?php endif; ?>
          </div>
          <input type="file" name="ttd" class="form-control" style="font-size:13px;" accept="image/*">
        </div>
      </div>
    </div>

  </form>
</div>

<script>
function openTab(tabId) {
  document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
  
  document.getElementById(tabId).classList.add('active');
  event.currentTarget.classList.add('active');
}
</script>

