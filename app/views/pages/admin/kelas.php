<div class="page-header">
  <h1 class="page-title-sm">Kelola Kelas</h1>
  <button onclick="toggleModal('modal-add')" class="btn btn-primary">
    <i class='bx bx-plus'></i> Tambah Kelas
  </button>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; padding-bottom: 40px; align-items: start;">
  <?php foreach ($kelas as $item): ?>
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03), inset 0 2px 4px rgba(255, 255, 255, 0.5); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column; position: relative; overflow: hidden; cursor: pointer;"
         onclick="window.location.href='<?= url('/admin/siswa?kelas=' . $item['id']) ?>'"
         onmouseover="this.style.transform='translateY(-6px) scale(1.01)'; this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.02)'; this.style.borderColor='#818cf8';" 
         onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.03), inset 0 2px 4px rgba(255, 255, 255, 0.5)'; this.style.borderColor='rgba(226, 232, 240, 0.8)';">
         
      <!-- Accent Line -->
      <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(to bottom, #4f46e5, #38bdf8);"></div>
      
      <!-- Glowing Blob Background -->
      <div style="position: absolute; right: -30px; top: -30px; width: 140px; height: 140px; background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, rgba(255,255,255,0) 70%); border-radius: 50%; pointer-events: none; z-index: 0;"></div>
      
      <div style="position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
            <div style="background: rgba(99, 102, 241, 0.1); width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #4f46e5;">
              <i class='bx bxs-door-open' style="font-size: 18px;"></i>
            </div>
            <span style="font-size: 12px; font-weight: 700; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase;">Kelas</span>
          </div>
          <h3 style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 4px 0 0 0; letter-spacing: -0.03em; line-height: 1.1;"><?= e($item['nama']) ?></h3>
        </div>
        
        <div style="width: 40px; height: 40px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; transition: all 0.3s ease;">
           <i class='bx bx-chevron-right' style="font-size: 24px;"></i>
        </div>
      </div>
      
      <div style="position: relative; z-index: 1; margin-top: 24px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; color: #3b82f6; background: rgba(59, 130, 246, 0.08); padding: 6px 14px; border-radius: 20px; border: 1px solid rgba(59, 130, 246, 0.1);">
          <i class='bx bxs-group' style="font-size: 16px;"></i> <?= $item['siswa_count'] ?> Siswa
        </div>
        
        <div style="display: flex; gap: 6px;">
          <button onclick="event.stopPropagation(); window.location.href='<?= url('/admin/kelas/' . $item['id'] . '/edit') ?>'" class="btn-icon" style="background: transparent; color: #64748b; border-radius: 8px; width: 32px; height: 32px; transition: all 0.2s;" onmouseover="this.style.background='#e0f2fe'; this.style.color='#0284c7';" onmouseout="this.style.background='transparent'; this.style.color='#64748b';" title="Edit kelas ini">
            <i class='bx bx-edit-alt' style="font-size: 18px;"></i>
          </button>
          <form action="<?= url('/admin/kelas/' . $item['id'] . '/delete') ?>" method="POST" style="margin: 0;" onsubmit="event.stopPropagation(); confirmAction(event, 'Hapus kelas <?= e(addslashes($item['nama'])) ?>?\\nSemua siswa di kelas ini akan kehilangan kelas mereka.')">
            <?= csrf_field() ?>
            <button type="submit" onclick="event.stopPropagation();" class="btn-icon" style="background: transparent; color: #64748b; border-radius: 8px; width: 32px; height: 32px; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444';" onmouseout="this.style.background='transparent'; this.style.color='#64748b';" title="Hapus kelas ini">
              <i class='bx bx-trash' style="font-size: 18px;"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  
  <?php if (empty($kelas)): ?>
    <div style="grid-column: 1 / -1;">
        <div class="empty-state" style="background: #fff; border-radius: 16px; border: 1px dashed #cbd5e1; padding: 60px 20px; box-shadow: none;">
          <i class='bx bxs-layer'></i>
          <p>Belum ada data kelas.</p>
          <small>Klik "Tambah Kelas" untuk membuat kelas baru (contoh: 9A, 9B, 9C).</small>
        </div>
    </div>
  <?php endif; ?>
</div>

<!-- Modal Tambah Kelas -->
<div id="modal-add" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Tambah Kelas Baru</h2>
      <button onclick="toggleModal('modal-add')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/kelas') ?>" method="POST">
      <div class="modal-body">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Kelas <span style="color:var(--danger)">*</span></label>
          <input type="text" name="nama" class="form-control" placeholder="Contoh: 9A, 9B, 9C" oninput="this.value = this.value.toUpperCase()" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="toggleModal('modal-add')" class="btn btn-secondary">Batal</button>
        <button type="submit" class="btn btn-primary"><i class='bx bx-save'></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleModal(id) {
    const modal = document.getElementById(id);
    modal.classList.toggle('active');
    if (modal.classList.contains('active')) {
      const input = modal.querySelector('input[type="text"]');
      if (input) {
        setTimeout(() => input.focus(), 100);
      }
    }
  }
</script>
