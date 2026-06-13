<div class="page-header" style="margin-bottom: 24px;">
  <h1 class="page-title" style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.5px;">Profil Saya</h1>
</div>

<div class="card" style="margin: 0; padding: 0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
  <div style="display: grid; grid-template-columns: 1fr 1px 1fr; background: #fff;">
    
    <!-- Kolom Kiri: Data Pribadi -->
    <div style="padding: 32px;">
      <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
          <i class='bx bxs-user' style="font-size: 28px; color: var(--primary);"></i>
        </div>
        <div>
          <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 2px 0;">Informasi Dasar</h2>
        </div>
      </div>

      <form action="<?= url('/admin/profil') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="form-group" style="margin-bottom: 20px;">
          <label class="form-label" style="font-size: 13px; font-weight: 600; color: #475569;">Nama Lengkap <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-user' style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px;"></i>
            <input type="text" name="nama" class="form-control" value="<?= e($user['nama'] ?? '') ?>"
              placeholder="Ketik nama lengkap" required style="padding-right:42px; border-radius: 12px; height: 46px; border-color: #cbd5e1; background: #f8fafc;">
          </div>
        </div>
        
        <div class="form-group" style="margin-bottom: 24px;">
          <label class="form-label" style="font-size: 13px; font-weight: 600; color: #475569;">Nama Pengguna <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-at' style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px;"></i>
            <input type="text" name="username" class="form-control" value="<?= e($user['username'] ?? '') ?>"
              placeholder="Username login" required style="padding-right:42px; border-radius: 12px; height: 46px; border-color: #cbd5e1; background: #f8fafc;">
          </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; border-radius: 12px; padding: 12px; font-weight: 600;">
          <i class='bx bx-save'></i> Simpan Perubahan Profil
        </button>
      </form>
    </div>

    <!-- Garis Pembatas Vertikal -->
    <div style="background: #f1f5f9; height: 100%;"></div>

    <!-- Kolom Kanan: Keamanan Akun -->
    <div style="padding: 32px; background: #fafbfc;">
      <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <div style="width: 56px; height: 56px; background: rgba(245, 158, 11, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
          <i class='bx bxs-lock-alt' style="font-size: 28px; color: #d97706;"></i>
        </div>
        <div>
          <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 2px 0;">Keamanan Sandi</h2>
          <p style="font-size: 13px; color: #64748b; margin: 0;">Perbarui kata sandi untuk keamanan akun</p>
        </div>
      </div>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger" style="margin-bottom:20px; font-size:13px; border-radius: 12px; display: flex; align-items: center; gap: 8px;">
          <i class='bx bx-error-circle' style="font-size: 18px;"></i> <?= e($error) ?>
        </div>
      <?php endif; ?>

      <!-- Area Tampil Tombol -->
      <div id="pw-toggle-section">
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; text-align: center; height: 216px; display: flex; flex-direction: column; justify-content: center;">
          <i class='bx bx-shield-quarter' style="font-size: 40px; color: #cbd5e1; margin-bottom: 12px;"></i>
          <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0; line-height: 1.5;">Gunakan kata sandi kombinasi huruf dan angka agar akun Anda tidak mudah diretas.</p>
          <button type="button" onclick="togglePassword()" class="btn btn-secondary" style="border-radius: 12px; font-weight: 600;">
            Ganti Kata Sandi Sekarang
          </button>
        </div>
      </div>

      <!-- Form Ubah Sandi -->
      <form action="<?= url('/admin/ubah-password') ?>" method="POST" id="pw-form" style="display:none;">
        <?= csrf_field() ?>
        
        <div class="form-group" style="margin-bottom: 20px;">
          <label class="form-label" style="font-size: 13px; font-weight: 600;">Kata Sandi Lama <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <input type="password" id="old_password" name="old_password" class="form-control" placeholder="Ketik kata sandi lama" required style="padding-right:42px; border-radius: 12px; height: 46px;">
            <i class='bx bx-hide' onclick="toggleEye('old_password', this)" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px; cursor:pointer; transition: 0.2s;" title="Tampilkan/Sembunyikan"></i>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
          <div class="form-group" style="margin: 0;">
            <label class="form-label" style="font-size: 13px; font-weight: 600;">Kata Sandi Baru <span style="color:var(--danger)">*</span></label>
            <div style="position:relative;">
              <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Baru (min 8)" required style="padding-right:42px; border-radius: 12px; height: 46px;">
              <i class='bx bx-hide' onclick="toggleEye('new_password', this)" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px; cursor:pointer; transition: 0.2s;" title="Tampilkan/Sembunyikan"></i>
            </div>
          </div>
          
          <div class="form-group" style="margin: 0;">
            <label class="form-label" style="font-size: 13px; font-weight: 600;">Konfirmasi <span style="color:var(--danger)">*</span></label>
            <div style="position:relative;">
              <input type="password" id="repeat_password" name="repeat_password" class="form-control" placeholder="Ulangi sandi" required style="padding-right:42px; border-radius: 12px; height: 46px;">
              <i class='bx bx-hide' onclick="toggleEye('repeat_password', this)" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px; cursor:pointer; transition: 0.2s;" title="Tampilkan/Sembunyikan"></i>
            </div>
          </div>
        </div>

        <div style="display:flex; gap: 12px;">
          <button type="button" onclick="togglePassword()" class="btn btn-secondary" style="border-radius: 12px; flex: 1; font-weight: 600;">Batal</button>
          <button type="submit" class="btn" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border-radius: 12px; flex: 1.5; font-weight: 600; border: none; box-shadow: 0 4px 10px rgba(217, 119, 6, 0.2);">
            Perbarui Sandi
          </button>
        </div>
      </form>
    </div>

  </div>
</div>

<style>
  /* Responsive grid untuk layar kecil (HP) agar tetap kebawah jika layarnya sempit */
  @media (max-width: 768px) {
    .card > div { grid-template-columns: 1fr !important; }
    .card > div > div:nth-child(2) { height: 1px; width: 100%; }
  }
</style>

<script>
  function togglePassword() {
    const form   = document.getElementById('pw-form');
    const toggle = document.getElementById('pw-toggle-section');
    const show   = form.style.display === 'none';

    if (show) {
      form.style.display   = 'block';
      toggle.style.display = 'none';
      form.style.opacity   = '0';
      form.style.transform = 'translateY(-10px)';
      form.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
      requestAnimationFrame(() => {
        form.style.opacity   = '1';
        form.style.transform = 'translateY(0)';
      });
    } else {
      form.style.opacity   = '0';
      form.style.transform = 'translateY(-10px)';
      setTimeout(() => {
        form.style.display   = 'none';
        toggle.style.display = 'block';
      }, 300);
    }
  }

  <?php if (!empty($error)): ?>
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('pw-form').style.display = 'block';
    document.getElementById('pw-form').style.opacity = '1';
    document.getElementById('pw-form').style.transform = 'translateY(0)';
    document.getElementById('pw-toggle-section').style.display = 'none';
  });
  <?php endif; ?>

  function toggleEye(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('bx-hide');
      icon.classList.add('bx-show');
      icon.style.color = 'var(--primary)';
    } else {
      input.type = 'password';
      icon.classList.remove('bx-show');
      icon.classList.add('bx-hide');
      icon.style.color = '#94a3b8';
    }
  }
</script>
