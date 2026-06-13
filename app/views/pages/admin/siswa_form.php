<div class="page-header">
  <h1 class="page-title-sm"><?= e($title) ?></h1>
  <a href="<?= url('/admin/siswa') ?>" class="btn btn-secondary">
    <i class='bx bx-arrow-back'></i> Kembali ke Data Siswa
  </a>
</div>

<div class="card" style="padding: 0; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.02); max-width: 760px; margin-top: 24px; overflow: hidden; background: #fff;">
  <form action="<?= url('/admin/siswa/' . $item['id']) ?>" method="POST">
    <?= csrf_field() ?>
    
    <div style="padding: 32px; display:flex; flex-direction:column; gap:24px;">
      <!-- Wrapper NISN & Nama -->
      <div style="display:grid; grid-template-columns:1fr 1.5fr; gap:20px;">
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">NISN <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-id-card' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="text" name="nisn" class="form-control" value="<?= e($item['nisn'] ?? '') ?>" placeholder="10 digit angka" required maxlength="10" inputmode="numeric" style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-family:monospace; font-size:15px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
        </div>
        
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Nama Lengkap <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-user' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="text" name="nama" class="form-control" value="<?= e($item['nama'] ?? '') ?>" placeholder="Sesuai ijazah resmi" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
        </div>
      </div>
      
      <!-- Wrapper Kelas & JK -->
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Kelas <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-building-house' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
            <select name="kelas_id" class="form-control" required style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              <option value="">— Pilih Kelas —</option>
              <?php foreach ($kelas as $j): ?>
                <option value="<?= e($j['id']) ?>" <?= (int)$j['id'] === (int)($item['kelas_id'] ?? 0) ? 'selected' : '' ?>>
                  <?= e($j['nama']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
          </div>
        </div>

        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Jenis Kelamin <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-male-female' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
            <select name="jenis_kelamin" class="form-control" required style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              <option value="L" <?= ($item['jenis_kelamin'] ?? 'L') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
              <option value="P" <?= ($item['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
            <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
          </div>
        </div>
      </div>

      <!-- Wrapper Status -->
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Status Kelulusan <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-shield-quarter' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
            <select name="status" class="form-control" style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              <?php $st = $item['status'] ?? 'belum'; ?>
              <option value="belum" <?= $st === 'belum' || $st === '' ? 'selected' : '' ?>>Belum Diproses</option>
              <option value="lulus" <?= $st === 'lulus' ? 'selected' : '' ?>>Lulus</option>
              <option value="tidak_lulus" <?= $st === 'tidak_lulus' ? 'selected' : '' ?>>Tidak Lulus</option>
            </select>
            <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
          </div>
          <p class="form-hint" style="margin-top:8px;"><i class='bx bx-info-circle'></i> Diperbarui otomatis saat "Proses Kelulusan" dijalankan</p>
        </div>
      </div>
    </div>
    
    <div style="border-top:1px solid #f1f5f9; padding:20px 32px; display:flex; justify-content:flex-end; gap:12px; background:#f8fafc;">
      <a href="<?= url('/admin/siswa') ?>" class="btn btn-secondary" style="height:48px; line-height:46px; border-radius:12px; font-weight:600; padding:0 24px; background:#fff; border:1px solid #e2e8f0; font-size:14.5px; color:#64748b; cursor:pointer; transition:all 0.2s; text-decoration:none;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">Batal</a>
      <button type="submit" class="btn btn-primary" style="height:48px; border-radius:12px; font-weight:700; padding:0 28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(79,70,229,0.3); background:linear-gradient(135deg, var(--primary), #6366f1); border:none; color:#fff; font-size:14.5px; cursor:pointer; transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
        <i class='bx bx-save' style="font-size:22px;"></i> Simpan Perubahan
      </button>
    </div>
  </form>
</div>
