<h1 class="page-title"><?= e($title) ?></h1>

<div class="card" style="max-width: 600px;">
  <form action="<?= url('/admin/jurusan/' . $item['id']) ?>" method="POST">
    <?= csrf_field() ?>
    <div class="form-group">
      <label class="form-label">Kode Jurusan <span style="color: red;">*</span></label>
      <input type="text" name="kode" class="form-control" value="<?= e($item['kode']) ?>" required>
    </div>
    <div class="form-group">
      <label class="form-label">Nama Jurusan <span style="color: red;">*</span></label>
      <input type="text" name="nama" class="form-control" value="<?= e($item['nama']) ?>" required>
    </div>
    
    <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); display: flex; gap: 12px;">
      <button type="submit" class="btn btn-primary">Update Jurusan</button>
      <a href="<?= url('/admin/jurusan') ?>" class="btn btn-secondary">Kembali</a>
    </div>
  </form>
</div>
