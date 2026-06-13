<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <h1 class="page-title" style="margin-bottom: 0;"><?= e($title) ?></h1>
  <div>
    <button onclick="toggleModal('modal-import')" class="btn btn-secondary" style="margin-right: 8px;">
      <i class='bx bx-upload'></i> Import Excel
    </button>
    <button onclick="toggleModal('modal-add')" class="btn btn-primary">
      <i class='bx bx-plus'></i> Tambah Jurusan
    </button>
  </div>
</div>

<div class="table-container">
  <table class="table">
    <thead>
      <tr>
        <th style="width: 80px;">No</th>
        <th style="width: 150px;">Kode</th>
        <th>Nama Jurusan</th>
        <th style="text-align: right;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; foreach ($jurusan as $item): ?>
        <tr>
          <td><span style="color: var(--text-gray); font-weight: 500;"><?= $i++ ?></span></td>
          <td><span class="badge badge-info"><?= e($item['kode']) ?></span></td>
          <td><strong><?= e($item['nama']) ?></strong></td>
          <td style="text-align: right;">
            <a href="<?= url('/admin/jurusan/' . $item['id'] . '/edit') ?>" class="btn-icon text-primary"><i class='bx bx-edit-alt'></i></a>
            <form action="<?= url('/admin/jurusan/' . $item['id'] . '/delete') ?>" method="POST" style="display: inline;" onsubmit="confirmAction(event, 'Hapus jurusan ini?')">
              <?= csrf_field() ?>
              <button type="submit" class="btn-icon text-danger"><i class='bx bx-trash'></i></button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($jurusan)): ?>
        <tr>
          <td colspan="4" style="text-align: center; padding: 60px; color: var(--text-gray);">
            <i class='bx bx-layer' style="font-size: 48px; display: block; margin-bottom: 12px; opacity: 0.2;"></i>
            Belum ada data jurusan.
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Modal Add -->
<div id="modal-add" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Tambah Jurusan Baru</h2>
      <button onclick="toggleModal('modal-add')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/jurusan') ?>" method="POST">
      <div class="modal-body">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Kode Jurusan <span style="color: red;">*</span></label>
          <input type="text" name="kode" class="form-control" placeholder="Contoh: RPL, TKJ, AK" required>
        </div>
        <div class="form-group">
          <label class="form-label">Nama Jurusan <span style="color: red;">*</span></label>
          <input type="text" name="nama" class="form-control" placeholder="Nama lengkap jurusan" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="toggleModal('modal-add')" class="btn btn-secondary">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Jurusan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Import -->
<div id="modal-import" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Import Data Jurusan Cerdas</h2>
      <button onclick="toggleModal('modal-import')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/import/jurusan') ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <?= csrf_field() ?>
        
        <div style="margin-bottom: 16px; padding: 12px; background: #eef2ff; border-radius: 8px; font-size: 14px; color: #4f46e5;">
            <strong>💡 Fitur Cerdas:</strong>
            <ul style="margin-top: 8px; margin-bottom: 0; padding-left: 20px;">
                <li>Otomatis mendeteksi letak kolom <strong>Kode</strong> dan <strong>Nama</strong>.</li>
                <li>Jika kode sudah ada, nama akan otomatis diperbarui.</li>
                <li>Otomatis merapikan spasi, huruf besar pada kode, dan huruf kapital pada nama.</li>
            </ul>
        </div>

        <div class="form-group">
          <label class="form-label">Pilih File Excel (.xlsx / .xls) <span style="color: red;">*</span></label>
          <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
        </div>
        
        <div style="margin-top: 16px;">
            <a href="<?= url('/admin/import/jurusan/template') ?>" class="text-primary" style="text-decoration: none; font-size: 14px;">
                <i class='bx bx-download'></i> Download Template Excel
            </a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="toggleModal('modal-import')" class="btn btn-secondary">Batal</button>
        <button type="submit" class="btn btn-primary">Mulai Import</button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleModal(id) {
    document.getElementById(id).classList.toggle('active');
  }
</script>
