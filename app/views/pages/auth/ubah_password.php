<div class="page-header">
  <h1 class="page-title-sm">Ubah Kata Sandi</h1>
</div>

<div class="card" style="max-width:480px;">
  <form action="<?= url('/admin/ubah-password') ?>" method="POST">
    <?= csrf_field() ?>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger" style="margin-bottom:24px;">
        <?= e($error) ?>
      </div>
    <?php endif; ?>

    <div class="form-group">
      <label class="form-label">Kata sandi saat ini <span style="color:var(--danger)">*</span></label>
      <div style="position:relative;">
        <input type="password" name="old_password" class="form-control" placeholder="Masukkan kata sandi lama" required style="padding-right:40px;">
        <i class='bx bx-lock-alt' style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--text-light); font-size:18px;"></i>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Kata sandi baru <span style="color:var(--danger)">*</span></label>
      <div style="position:relative;">
        <input type="password" name="new_password" class="form-control" placeholder="Minimal 8 karakter" required style="padding-right:40px;">
        <i class='bx bx-key' style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--text-light); font-size:18px;"></i>
      </div>
      <p class="form-hint">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka</p>
    </div>

    <div class="form-group" style="margin-bottom:32px;">
      <label class="form-label">Konfirmasi kata sandi baru <span style="color:var(--danger)">*</span></label>
      <div style="position:relative;">
        <input type="password" name="repeat_password" class="form-control" placeholder="Ketik ulang kata sandi baru" required style="padding-right:40px;">
        <i class='bx bx-shield-check' style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--text-light); font-size:18px;"></i>
      </div>
    </div>

    <hr class="divider">
    <div style="display:flex; gap:10px;">
      <button type="submit" class="btn btn-primary" style="flex:1;">
        <i class='bx bx-lock'></i> Perbarui Kata Sandi
      </button>
      <a href="<?= url('/admin') ?>" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
