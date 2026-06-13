<div class="auth-card">
  <div class="auth-header">
    <div class="auth-logo">
      <i class='bx bxs-graduation'></i>
    </div>
    <h1 class="auth-title">PortalLulus</h1>
    <p class="auth-subtitle">Masuk sebagai administrator</p>
  </div>

  <?php if (!empty($error)): ?>
    <div class="auth-error"><?= e($error) ?></div>
  <?php endif; ?>

  <form action="<?= url('/login') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="form-group">
      <label for="username" class="form-label">Nama Pengguna</label>
      <div class="input-wrap">
        <i class='bx bx-user input-icon'></i>
        <input type="text" name="username" id="username" class="form-control"
          placeholder="Masukkan nama pengguna" required autofocus>
      </div>
    </div>
    <div class="form-group" style="margin-bottom: 28px;">
      <label for="password" class="form-label">Kata Sandi</label>
      <div class="input-wrap">
        <i class='bx bx-lock-alt input-icon'></i>
        <input type="password" name="password" id="password" class="form-control"
          placeholder="••••••••" required>
      </div>
    </div>
    <button type="submit" class="btn-login">
      Masuk
    </button>
  </form>

  <div class="auth-footer-link">
    <a href="<?= url('/siswa/login') ?>">
      <i class='bx bx-user-pin'></i> Login sebagai Siswa
    </a>
  </div>
</div>
