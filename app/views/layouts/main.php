<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title ?? 'PortalLulus') ?> — PortalLulus SMP</title>
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="app-container">
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo-icon">
          <i class='bx bxs-graduation'></i>
        </div>
        <div class="logo-text">
          <span class="title">PortalLulus</span>
          <span class="subtitle">Panel Admin</span>
        </div>
      </div>

      <ul class="nav-links" style="padding-top: 12px;">
        <li class="<?= is_active('/admin') ? 'active' : '' ?>">
          <a href="<?= url('/admin') ?>">
            <i class='bx bxs-dashboard'></i>
            <span>Beranda</span>
          </a>
        </li>
        <li class="<?= is_active('/admin/siswa') ? 'active' : '' ?>">
          <a href="<?= url('/admin/siswa') ?>">
            <i class='bx bxs-group'></i>
            <span>Data Siswa</span>
          </a>
        </li>
        <li class="<?= is_active('/admin/nilai') ? 'active' : '' ?>">
          <a href="<?= url('/admin/nilai') ?>">
            <i class='bx bxs-bar-chart-alt-2'></i>
            <span>Nilai Siswa</span>
          </a>
        </li>

        <li class="<?= is_active('/admin/kelas') ? 'active' : '' ?>">
          <a href="<?= url('/admin/kelas') ?>">
            <i class='bx bxs-layer'></i>
            <span>Kelola Kelas</span>
          </a>
        </li>
        <li class="<?= is_active('/admin/mapel') ? 'active' : '' ?>">
          <a href="<?= url('/admin/mapel') ?>">
            <i class='bx bxs-book-alt'></i>
            <span>Mata Pelajaran</span>
          </a>
        </li>
        <li class="<?= is_active('/admin/skl') ? 'active' : '' ?>">
          <a href="<?= url('/admin/skl') ?>">
            <i class='bx bxs-file-doc'></i>
            <span>Pengaturan SKL</span>
          </a>
        </li>
      </ul>

      <div class="sidebar-footer">
        <div class="user-dropdown" id="userDropdown">
          <div class="user-card" onclick="toggleDropdown()">
            <div class="user-avatar">
              <i class='bx bxs-user'></i>
            </div>
            <div class="user-details">
              <span class="user-name"><?= e($_SESSION['user']['nama'] ?? $_SESSION['user']['username'] ?? 'Administrator') ?></span>
              <span class="user-role"><?= ucfirst(e($_SESSION['user']['role'] ?? 'Admin')) ?></span>
            </div>
            <i class='bx bx-chevron-up dropdown-icon'></i>
          </div>
          
          <div class="dropdown-menu" id="dropdownMenu">
            <a href="<?= url('/admin/profil') ?>" class="dropdown-item">
              <i class='bx bx-user-circle'></i>
              <span>Profil Saya</span>
            </a>
            <hr>
            <form action="<?= url('/logout') ?>" method="POST" onsubmit="confirmAction(event, 'Yakin ingin keluar dari sistem?')">
              <?= csrf_field() ?>
              <button type="submit" class="dropdown-item logout">
                <i class='bx bx-log-out'></i>
                <span>Keluar</span>
              </button>
            </form>
          </div>
        </div>
      </div>

      <script>
        function toggleDropdown() {
          const menu = document.getElementById('dropdownMenu');
          const dropdown = document.getElementById('userDropdown');
          menu.classList.toggle('active');
          dropdown.classList.toggle('open');
        }
        window.addEventListener('click', function(e) {
          const el = document.getElementById('userDropdown');
          if (el && !el.contains(e.target)) {
            document.getElementById('dropdownMenu').classList.remove('active');
            el.classList.remove('open');
          }
        });
      </script>
    </aside>

    <main class="main-content">
      <?php 
      $flash = $_SESSION['flash'] ?? null;
      $flash_error = $_SESSION['flash_error'] ?? null;
      unset($_SESSION['flash'], $_SESSION['flash_error']);
      ?>
      <?php require $view_file; ?>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: 'bottom-end',
      showConfirmButton: false,
      timer: 4000,
      timerProgressBar: true,
      customClass: {
        popup: 'elegant-toast'
      },
      showClass: {
        popup: 'toast-slide-in'
      },
      hideClass: {
        popup: 'toast-slide-out'
      },
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });

    <?php if ($flash): ?>
      Toast.fire({
        icon: 'success',
        title: '<?= addslashes(e($flash)) ?>'
      });
    <?php endif; ?>

    <?php if ($flash_error): ?>
      Toast.fire({
        icon: 'error',
        title: '<?= addslashes(e($flash_error)) ?>'
      });
    <?php endif; ?>

    function confirmAction(event, message) {
      event.preventDefault();
      const form = event.target;
      Swal.fire({
        title: 'Konfirmasi Tindakan',
        html: message.replace(/\n/g, '<br>'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#cbd5e1',
        cancelButtonText: '<span style="color:#475569">Batal</span>',
        confirmButtonText: 'Ya, Lanjutkan',
        reverseButtons: true,
        backdrop: `rgba(15, 23, 42, 0.5)`
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    }
  </script>
</body>
</html>
