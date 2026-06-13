<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class AdminController
{
  /* ── DASHBOARD ── */
  public function dashboard(): void
  {
    require_role('admin');
    $pdo = Database::pdo();

    $totalSiswa      = (int)$pdo->query("SELECT COUNT(*) FROM siswa WHERE is_active = 1")->fetchColumn();
    $totalLulus      = (int)$pdo->query("SELECT COUNT(*) FROM siswa WHERE status = 'lulus' AND is_active = 1")->fetchColumn();
    $totalTidakLulus = (int)$pdo->query("SELECT COUNT(*) FROM siswa WHERE status = 'tidak_lulus' AND is_active = 1")->fetchColumn();
    $belumDitentukan = (int)$pdo->query("SELECT COUNT(*) FROM siswa WHERE (status IS NULL OR status = 'belum') AND is_active = 1")->fetchColumn();

    view('admin/dashboard', [
      'title' => 'Dashboard Statistik',
      'stats' => [
        'total'       => $totalSiswa,
        'lulus'       => $totalLulus,
        'tidak_lulus' => $totalTidakLulus,
        'belum'       => $belumDitentukan,
      ]
    ]);
  }

  public function processGraduation(): void
  {
    require_role('admin');
    $pdo = Database::pdo();
    
    // Get all students
    $siswa = $pdo->query("SELECT id FROM siswa WHERE is_active = 1")->fetchAll();
    
    $processed = 0;
    foreach ($siswa as $s) {
      $siswaId = $s['id'];
      
      // Get all grades and their corresponding KKM
      $stmt = $pdo->prepare("
        SELECT n.nilai, m.kkm 
        FROM nilai n 
        JOIN mapel m ON m.id = n.mapel_id 
        WHERE n.siswa_id = ?
      ");
      $stmt->execute([$siswaId]);
      $grades = $stmt->fetchAll();
      
      if (empty($grades)) {
        // No grades yet, skip or keep as 'belum'
        $pdo->prepare("UPDATE siswa SET status = 'belum' WHERE id = ?")->execute([$siswaId]);
        continue;
      }
      
      $isLulus = true;
      foreach ($grades as $g) {
        if ((float)$g['nilai'] < (float)$g['kkm']) {
          $isLulus = false;
          break;
        }
      }
      
      $status = $isLulus ? 'lulus' : 'tidak_lulus';
      $pdo->prepare("UPDATE siswa SET status = ? WHERE id = ?")->execute([$status, $siswaId]);
      $processed++;
    }
    
    $_SESSION['flash'] = "Berhasil memproses kelulusan untuk $processed siswa.";
    redirect('/admin');
  }
}
