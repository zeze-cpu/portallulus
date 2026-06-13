<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class SiswaDashboardController
{
  public function index(): void
  {
    require_role('siswa');
    $pdo   = Database::pdo();
    $siswa = $pdo->prepare("SELECT s.*, k.nama AS kelas_nama FROM siswa s LEFT JOIN kelas k ON k.id = s.kelas_id WHERE s.id = ?");
    $siswa->execute([$_SESSION['user']['id']]);
    $dataSiswa = $siswa->fetch();

    $skl = $pdo->query("SELECT * FROM skl_settings ORDER BY id DESC LIMIT 1")->fetch();

    // Check if announcement time has passed
    $now = new \DateTime();
    $target = new \DateTime($skl['jam_pengumuman'] ?? '9999-12-31');
    $isOpen = $now >= $target;

    $nilai = [];
    if ($isOpen) {
      $stmt = $pdo->prepare("SELECT n.*, m.nama AS mapel_nama, m.kkm FROM nilai n JOIN mapel m ON m.id = n.mapel_id WHERE n.siswa_id = ?");
      $stmt->execute([$_SESSION['user']['id']]);
      $nilai = $stmt->fetchAll();
    }

    view('siswa/dashboard', [
      'title'     => 'Dashboard Siswa',
      'siswa'     => $dataSiswa,
      'skl'       => $skl,
      'isOpen'    => $isOpen,
      'nilai'     => $nilai,
      'target'    => $target->format('Y/m/d H:i:s'),
      'layout'    => 'auth' // Using auth layout for simplicity or create a new one
    ]);
  }

  public function downloadSKL(): void
  {
    require_role('siswa');
    // For now, just a placeholder or simple HTML to PDF if library exists.
    // Since we don't have dompdf/tcpdf installed, we'll show a printable page.
    $pdo   = Database::pdo();
    $siswa = $pdo->prepare("SELECT s.*, k.nama AS kelas_nama FROM siswa s LEFT JOIN kelas k ON k.id = s.kelas_id WHERE s.id = ?");
    $siswa->execute([$_SESSION['user']['id']]);
    $dataSiswa = $siswa->fetch();

    $skl = $pdo->query("SELECT * FROM skl_settings ORDER BY id DESC LIMIT 1")->fetch();

    $now = new \DateTime();
    $target = new \DateTime($skl['jam_pengumuman'] ?? '9999-12-31');
    if ($now < $target) {
        die("Pengumuman belum dibuka.");
    }

    $stmt = $pdo->prepare("SELECT n.*, m.nama AS mapel_nama, m.kkm FROM nilai n JOIN mapel m ON m.id = n.mapel_id WHERE n.siswa_id = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    $nilai = $stmt->fetchAll();

    view('siswa/cetak_skl', [
      'title' => 'Cetak SKL',
      'siswa' => $dataSiswa,
      'skl'   => $skl,
      'nilai' => $nilai,
      'layout'=> 'blank' // No sidebar/nav
    ]);
  }
}
