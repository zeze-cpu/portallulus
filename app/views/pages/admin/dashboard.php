<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
  <div>
    <h1 class="page-title">Beranda</h1>
  </div>
  <form action="<?= url('/admin/proses-kelulusan') ?>" method="POST"
    onsubmit="confirmAction(event, 'Hitung ulang kelulusan semua siswa berdasarkan nilai dan KKM? Tindakan ini akan mengubah status kelulusan yang sudah ada.')">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 12px rgba(245,158,11,0.3);">
      <i class='bx bx-analyse'></i> Proses Kelulusan
    </button>
  </form>
</div>

<!-- Stat Cards -->
<div class="dashboard-cards" style="margin-bottom: 32px;">
  <a href="<?= url('/admin/siswa') ?>" class="stat-card blue">
    <div class="stat-label">Siswa Terdaftar</div>
    <div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div>
    <div class="stat-sub">Total siswa aktif</div>
    <i class='bx bxs-group' style="position:absolute; right:18px; bottom:14px; font-size:52px; opacity:0.18;"></i>
  </a>

  <a href="<?= url('/admin/siswa?status=lulus') ?>" class="stat-card green">
    <div class="stat-label">Lulus</div>
    <div class="stat-value"><?= number_format($stats['lulus'] ?? 0) ?></div>
    <div class="stat-sub">
      <?php if (($stats['total'] ?? 0) > 0): ?>
        <?= round(($stats['lulus'] / $stats['total']) * 100) ?>% dari total
      <?php else: ?>
        Belum ada data
      <?php endif; ?>
    </div>
    <i class='bx bxs-check-circle' style="position:absolute; right:18px; bottom:14px; font-size:52px; opacity:0.18;"></i>
  </a>

  <a href="<?= url('/admin/siswa?status=tidak_lulus') ?>" class="stat-card red">
    <div class="stat-label">Tidak lulus</div>
    <div class="stat-value"><?= number_format($stats['tidak_lulus'] ?? 0) ?></div>
    <div class="stat-sub">
      <?php if (($stats['total'] ?? 0) > 0): ?>
        <?= round(($stats['tidak_lulus'] / $stats['total']) * 100) ?>% dari total
      <?php else: ?>
        Belum ada data
      <?php endif; ?>
    </div>
    <i class='bx bxs-x-circle' style="position:absolute; right:18px; bottom:14px; font-size:52px; opacity:0.18;"></i>
  </a>

  <a href="<?= url('/admin/siswa?status=belum') ?>" class="stat-card orange">
    <div class="stat-label">Belum diproses</div>
    <div class="stat-value"><?= number_format($stats['belum'] ?? 0) ?></div>
    <div class="stat-sub">Menunggu penentuan status</div>
    <i class='bx bxs-time' style="position:absolute; right:18px; bottom:14px; font-size:52px; opacity:0.18;"></i>
  </a>
</div>

<!-- Welcome Banner -->
<div class="welcome-banner">
  <div class="welcome-content">
    <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.7; margin-bottom: 8px;">
      Selamat Datang
    </p>
    <h2 style="margin-bottom: 10px; font-size: 26px; font-weight: 800; letter-spacing: -0.02em;">
      <?= e($_SESSION['user']['nama'] ?? $_SESSION['user']['username'] ?? 'Admin') ?> 👋
    </h2>
    <p style="opacity: 0.85; margin-bottom: 28px; max-width: 560px; font-size: 14px; line-height: 1.6;">
      Kelola data siswa, input nilai, dan atur pengumuman kelulusan. Pastikan semua data nilai dan KKM telah lengkap sebelum memproses kelulusan.
    </p>
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
      <a href="<?= url('/admin/siswa') ?>" class="btn-banner">
        <i class='bx bxs-group'></i> Kelola Siswa
      </a>
      <a href="<?= url('/admin/nilai') ?>" class="btn-banner-outline">
        <i class='bx bxs-bar-chart-alt-2'></i> Input Nilai
      </a>
      <a href="<?= url('/admin/skl') ?>" class="btn-banner-outline">
        <i class='bx bxs-cog'></i> Atur SKL
      </a>
    </div>
  </div>
  <i class='bx bxs-graduation banner-bg-icon'></i>
</div>

<style>
  .stat-card {
    position: relative;
    overflow: hidden;
    text-decoration: none;
  }
  .stat-card:hover { opacity: 0.93; }

  .welcome-banner {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 60%, #a855f7 100%);
    color: white;
    padding: 40px 44px;
    border-radius: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 40px -8px rgba(79, 70, 229, 0.4);
  }
  .welcome-content { position: relative; z-index: 2; }
  .banner-bg-icon {
    position: absolute;
    right: -24px;
    bottom: -36px;
    font-size: 260px;
    opacity: 0.08;
    transform: rotate(-15deg);
    z-index: 1;
  }

  .btn-banner {
    background: rgba(255,255,255,0.95);
    color: #4f46e5;
    padding: 11px 22px;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 13.5px;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
  }
  .btn-banner:hover { background: white; transform: translateY(-2px); }

  .btn-banner-outline {
    background: rgba(255,255,255,0.12);
    color: white;
    padding: 11px 22px;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 13.5px;
    border: 1.5px solid rgba(255,255,255,0.25);
    transition: all 0.2s;
  }
  .btn-banner-outline:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); }
</style>
