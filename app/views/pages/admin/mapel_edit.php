<div class="edit-form-layout" style="max-width: 600px; margin: 0 auto;">
  <div class="page-header" style="margin-bottom: 24px;">
    <h1 class="page-title-sm" style="display: flex; align-items: center; gap: 12px; font-size: 24px; font-weight: 800; color: #1e293b;">
      <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(79,70,229,0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
        <i class='bx bx-edit-alt' style="font-size: 22px;"></i>
      </div>
      <?= e($title) ?>
    </h1>
  </div>

  <div class="card" style="padding: 0; overflow: hidden; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
    <form action="<?= url('/admin/mapel/' . $item['id']) ?>" method="POST">
      <?= csrf_field() ?>
      <div style="padding: 28px; display: flex; flex-direction: column; gap: 24px;">
        
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Nama Mata Pelajaran <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-book' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="text" name="nama" class="form-control" value="<?= e($item['nama'] ?? '') ?>" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:15px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
        </div>

        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">KKM (Kriteria Ketuntasan Minimal) <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-target-lock' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="number" name="kkm" class="form-control" value="<?= e($item['kkm'] ?? '') ?>" min="0" max="100" step="0.01" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:700; font-size:16px; font-family:monospace; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
          <p class="form-hint" style="margin-top:8px;"><i class='bx bx-info-circle'></i> Nilai minimum yang harus dicapai siswa (0–100)</p>
        </div>

      </div>
      
      <div style="border-top:1px solid #f1f5f9; padding:20px 28px; display:flex; justify-content:flex-end; gap:12px; background:#f8fafc;">
        <a href="<?= url('/admin/mapel') ?>" class="btn btn-secondary" style="height:48px; border-radius:12px; font-weight:600; padding:0 24px; background:#fff; border:1px solid #e2e8f0; font-size:14.5px; color:#64748b; display:inline-flex; align-items:center; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">Batal</a>
        <button type="submit" class="btn btn-primary" style="height:48px; border-radius:12px; font-weight:700; padding:0 28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(79,70,229,0.3); background:linear-gradient(135deg, var(--primary), #6366f1); border:none; color:#fff; font-size:14.5px; transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
          <i class='bx bx-save' style="font-size:22px;"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
