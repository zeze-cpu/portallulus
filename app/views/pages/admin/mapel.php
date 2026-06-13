<div class="page-header" style="margin-bottom: 24px;">
  <h1 class="page-title-sm">Mata Pelajaran</h1>
  <button onclick="toggleModal('modal-add'); setTimeout(() => document.getElementById('add-mapel-nama').focus(), 100);" class="btn btn-primary" style="height: 44px; font-size: 14px; border-radius: 12px; box-shadow: 0 4px 12px rgba(79,70,229,0.25); background: linear-gradient(135deg, var(--primary), #6366f1); border: none; color: #fff; transition: all 0.3s ease; font-weight: 600;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(79,70,229,0.25)'; this.style.transform='translateY(0)';">
    <i class='bx bx-book-add' style="font-size: 18px;"></i> Tambah Mata Pelajaran
  </button>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; padding-bottom: 40px; align-items: stretch;">
  <?php foreach ($mapel as $item): ?>
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03), inset 0 2px 4px rgba(255, 255, 255, 0.5); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column; position: relative; overflow: hidden;"
         onmouseover="this.style.transform='translateY(-6px) scale(1.01)'; this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.02)'; this.style.borderColor='#fcd34d';" 
         onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.03), inset 0 2px 4px rgba(255, 255, 255, 0.5)'; this.style.borderColor='rgba(226, 232, 240, 0.8)';">
         
      <!-- Accent Line -->
      <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(to bottom, #fbbf24, #f59e0b);"></div>
      
      <!-- Glowing Blob Background -->
      <div style="position: absolute; right: -30px; top: -30px; width: 140px; height: 140px; background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, rgba(255,255,255,0) 70%); border-radius: 50%; pointer-events: none; z-index: 0;"></div>
      
      <div style="position: relative; z-index: 1;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
          <div style="background: rgba(245, 158, 11, 0.1); width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #d97706;">
            <i class='bx bxs-book-bookmark' style="font-size: 18px;"></i>
          </div>
          <span style="font-size: 12px; font-weight: 700; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase;">Mata Pelajaran</span>
        </div>
        <h3 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0 0 16px 0; letter-spacing: -0.02em; line-height: 1.2;"><?= e($item['nama']) ?></h3>
        
        <?php if ($item['keterangan']): ?>
          <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0; line-height: 1.5; font-style: italic; border-left: 2px solid #e2e8f0; padding-left: 10px;">
            "<?= e($item['keterangan']) ?>"
          </p>
        <?php endif; ?>
      </div>
      
      <div style="position: relative; z-index: 1; margin-top: auto; padding-top: 20px; border-top: 1px dashed #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: inline-flex; flex-direction: column;">
          <span style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Target KKM</span>
          <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 18px; font-weight: 800; color: #d97706; background: rgba(251, 191, 36, 0.15); padding: 4px 12px; border-radius: 8px; border: 1px solid rgba(251, 191, 36, 0.2);">
            <i class='bx bx-target-lock' style="font-size: 18px;"></i> <?= e($item['kkm']) ?>
          </div>
        </div>
        
        <div style="display: flex; gap: 6px;">
          <button onclick="openEditMapelModal(<?= $item['id'] ?>, '<?= e(addslashes($item['nama'])) ?>', <?= $item['kkm'] ?>)" class="btn-icon" style="background: transparent; color: #64748b; border-radius: 8px; width: 36px; height: 36px; transition: all 0.2s;" onmouseover="this.style.background='#e0f2fe'; this.style.color='#0284c7';" onmouseout="this.style.background='transparent'; this.style.color='#64748b';" title="Edit mapel ini">
            <i class='bx bx-edit-alt' style="font-size: 18px;"></i>
          </button>
          <form action="<?= url('/admin/mapel/' . $item['id'] . '/delete') ?>" method="POST" style="margin: 0;" onsubmit="confirmAction(event, 'Hapus mata pelajaran <?= e(addslashes($item['nama'])) ?>?\\nSemua nilai terkait mata pelajaran ini juga akan dihapus.')">
            <?= csrf_field() ?>
            <button type="submit" class="btn-icon" style="background: transparent; color: #64748b; border-radius: 8px; width: 36px; height: 36px; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444';" onmouseout="this.style.background='transparent'; this.style.color='#64748b';" title="Hapus mapel ini">
              <i class='bx bx-trash' style="font-size: 18px;"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  
  <?php if (empty($mapel)): ?>
    <div style="grid-column: 1 / -1;">
        <div class="empty-state" style="background: #fff; border-radius: 16px; border: 1px dashed #cbd5e1; padding: 60px 20px; box-shadow: none;">
          <i class='bx bxs-book-alt'></i>
          <p>Belum ada data mata pelajaran.</p>
          <small>Klik "Tambah Mata Pelajaran" untuk menambahkan (contoh: Matematika, Bahasa Indonesia).</small>
        </div>
    </div>
  <?php endif; ?>
</div>

<!-- Modal Tambah Mapel -->
<div id="modal-add" class="modal">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h2 class="modal-title" style="display: flex; align-items: center; gap: 8px;"><i class='bx bx-book-add' style="color: var(--primary);"></i> Tambah Mata Pelajaran</h2>
      <button type="button" onclick="toggleModal('modal-add')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/mapel') ?>" method="POST">
      <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 24px;">
        <?= csrf_field() ?>
        
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Nama Mata Pelajaran <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-book' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="text" id="add-mapel-nama" name="nama" class="form-control" placeholder="Contoh: Matematika, Bahasa Inggris" autofocus required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:15px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
        </div>

        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">KKM (Kriteria Ketuntasan Minimal) <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-target-lock' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="number" name="kkm" class="form-control" value="75" min="0" max="100" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:700; font-size:16px; font-family:monospace; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
          <p class="form-hint" style="margin-top:8px;"><i class='bx bx-info-circle'></i> Nilai minimum yang harus dicapai siswa untuk dinyatakan tuntas</p>
        </div>

      </div>
      <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:20px 24px; display:flex; justify-content:flex-end; gap:12px; background:#f8fafc; border-bottom-left-radius:16px; border-bottom-right-radius:16px;">
        <button type="button" onclick="toggleModal('modal-add')" class="btn btn-secondary" style="height:48px; border-radius:12px; font-weight:600; padding:0 24px; background:#fff; border:1px solid #e2e8f0; font-size:14.5px; color:#64748b; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">Batal</button>
        <button type="submit" class="btn btn-primary" style="height:48px; border-radius:12px; font-weight:700; padding:0 28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(79,70,229,0.3); background:linear-gradient(135deg, var(--primary), #6366f1); border:none; color:#fff; font-size:14.5px; cursor:pointer; transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
          <i class='bx bx-plus-circle' style="font-size:22px;"></i> Tambah Mapel
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Mapel -->
<div id="modal-edit" class="modal">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h2 class="modal-title" style="display: flex; align-items: center; gap: 8px;"><i class='bx bx-edit-alt' style="color: var(--info);"></i> Edit Mata Pelajaran</h2>
      <button type="button" onclick="toggleModal('modal-edit')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form id="form-edit-mapel" action="" method="POST">
      <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 24px;">
        <?= csrf_field() ?>
        
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Nama Mata Pelajaran <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-book' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="text" id="edit-mapel-nama" name="nama" class="form-control" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:15px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
        </div>

        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">KKM (Kriteria Ketuntasan Minimal) <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-target-lock' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="number" id="edit-mapel-kkm" name="kkm" class="form-control" min="0" max="100" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:700; font-size:16px; font-family:monospace; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
          <p class="form-hint" style="margin-top:8px;"><i class='bx bx-info-circle'></i> Nilai minimum yang harus dicapai siswa untuk dinyatakan tuntas</p>
        </div>

      </div>
      <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:20px 24px; display:flex; justify-content:flex-end; gap:12px; background:#f8fafc; border-bottom-left-radius:16px; border-bottom-right-radius:16px;">
        <button type="button" onclick="toggleModal('modal-edit')" class="btn btn-secondary" style="height:48px; border-radius:12px; font-weight:600; padding:0 24px; background:#fff; border:1px solid #e2e8f0; font-size:14.5px; color:#64748b; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">Batal</button>
        <button type="submit" class="btn btn-primary" style="height:48px; border-radius:12px; font-weight:700; padding:0 28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(79,70,229,0.3); background:linear-gradient(135deg, var(--primary), #6366f1); border:none; color:#fff; font-size:14.5px; cursor:pointer; transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
          <i class='bx bx-save' style="font-size:22px;"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleModal(id) {
    document.getElementById(id).classList.toggle('active');
  }

  function openEditMapelModal(id, nama, kkm) {
    document.getElementById('form-edit-mapel').action = '<?= url('/admin/mapel/') ?>' + id;
    document.getElementById('edit-mapel-nama').value = nama;
    document.getElementById('edit-mapel-kkm').value = kkm;
    toggleModal('modal-edit');
  }
</script>
