<div class="edit-form-layout">
  <div class="page-header">
    <h1 class="page-title-sm"><?= e($title) ?></h1>
    <a href="<?= url('/admin/kelas') ?>" class="btn btn-secondary">
      <i class='bx bx-arrow-back'></i> Kembali
    </a>
  </div>

  <div class="card">
  <form action="<?= url('/admin/kelas/' . $item['id']) ?>" method="POST">
    <?= csrf_field() ?>
    <div class="form-group" style="margin-bottom:32px;">
      <label class="form-label">Kelas <span style="color:var(--danger)">*</span></label>
      <input type="text" name="nama" class="form-control" value="<?= e($item['nama'] ?? '') ?>" placeholder="Contoh: 9A, 9B, 9C" oninput="this.value = this.value.toUpperCase()" required autofocus>
    </div>
    <hr class="divider">
    <div style="display:flex; gap:10px;">
      <button type="submit" class="btn btn-primary"><i class='bx bx-save'></i> Simpan Perubahan</button>
      <a href="<?= url('/admin/kelas') ?>" class="btn btn-secondary">Batal</a>
    </div>
  </form>
  </div>
</div>
