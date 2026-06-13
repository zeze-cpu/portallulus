<div class="auth-card">
  <div class="auth-header">
    <div class="auth-logo">
      <i class='bx bxs-graduation'></i>
    </div>
    <h1 class="auth-title">Cek Kelulusan</h1>
    <p class="auth-subtitle">Masukkan data diri untuk melihat hasil kelulusan</p>
  </div>

  <?php if (!empty($error)): ?>
    <div class="auth-error"><?= e($error) ?></div>
  <?php endif; ?>

  <form action="<?= url('/siswa/login') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="form-group" style="margin-bottom: 28px;">
      <label for="nisn" class="form-label">NISN (Nomor Induk Siswa Nasional)</label>
      <div class="input-wrap">
        <i class='bx bx-id-card input-icon'></i>
        <input type="text" name="nisn" id="nisn" class="form-control"
          placeholder="Contoh: 0012345678" required autofocus
          inputmode="numeric" maxlength="10">
      </div>
      <p style="font-size: 12px; color: #94a3b8; margin-top: 6px; font-weight: 500;">
        <i class='bx bx-info-circle' style="vertical-align: middle;"></i>
        Masukkan NISN Anda untuk melihat kelulusan
      </p>
    </div>
    <button type="submit" class="btn-login">
      <i class='bx bx-search-alt-2'></i> Lihat Hasil Kelulusan
    </button>
  </form>

  <div class="auth-footer-link">
    <a href="<?= url('/login') ?>">
      <i class='bx bx-shield-quarter'></i> Masuk sebagai Admin Sekolah
    </a>
  </div>
</div>
