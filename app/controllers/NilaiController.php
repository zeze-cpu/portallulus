<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class NilaiController
{
  public function index(): void
  {
    require_role('admin');
    $pdo    = Database::pdo();
    $search = trim($_GET['q'] ?? '');
    $kelas_id = (int)($_GET['kelas'] ?? 0);

    $sql = "
      SELECT n.*, s.nama AS siswa_nama, s.nisn, m.nama AS mapel_nama, m.kkm, k.nama AS kelas_nama
      FROM nilai n
      JOIN siswa s ON s.id = n.siswa_id
      JOIN mapel m ON m.id = n.mapel_id
      LEFT JOIN kelas k ON k.id = s.kelas_id
      WHERE s.is_active = 1
    ";
    
    $params = [];
    if ($kelas_id > 0) {
      $sql .= " AND s.kelas_id = ?";
      $params[] = $kelas_id;
    }
    $sql .= " ORDER BY s.nama, m.nama";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $nilai = $stmt->fetchAll();
    
    $siswa  = $pdo->query("SELECT id, nama, nisn FROM siswa WHERE is_active=1 ORDER BY nama")->fetchAll();
    $mapel  = $pdo->query("SELECT id, nama, kkm FROM mapel ORDER BY nama")->fetchAll();
    $kelas  = $pdo->query("SELECT id, nama FROM kelas ORDER BY nama")->fetchAll();

    view('admin/nilai', [
      'title'    => 'Input Nilai',
      'nilai'    => $nilai,
      'siswa'    => $siswa,
      'mapel'    => $mapel,
      'kelas'    => $kelas,
      'search'   => $search,
      'kelas_id' => $kelas_id,
    ]);
  }

  public function show(int $siswa_id): void
  {
    require_role('admin');
    $pdo = Database::pdo();

    $stmt = $pdo->prepare("
      SELECT s.*, k.nama AS kelas_nama 
      FROM siswa s 
      LEFT JOIN kelas k ON k.id = s.kelas_id 
      WHERE s.id = ? AND s.is_active = 1
    ");
    $stmt->execute([$siswa_id]);
    $siswa = $stmt->fetch();

    if (!$siswa) {
      $_SESSION['flash_error'] = 'Siswa tidak ditemukan.';
      redirect('/admin/nilai');
    }

    $stmt = $pdo->prepare("
      SELECT n.*, m.nama AS mapel_nama, m.kkm 
      FROM nilai n
      JOIN mapel m ON m.id = n.mapel_id
      WHERE n.siswa_id = ?
      ORDER BY m.nama
    ");
    $stmt->execute([$siswa_id]);
    $nilai = $stmt->fetchAll();

    $mapel = $pdo->query("SELECT id, nama, kkm FROM mapel ORDER BY nama")->fetchAll();

    view('admin/nilai_detail', [
      'title' => 'Detail Nilai Siswa',
      'siswa' => $siswa,
      'nilai' => $nilai,
      'mapel' => $mapel,
    ]);
  }

  public function store(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo      = Database::pdo();
    $siswa_id = (int)($_POST['siswa_id'] ?? 0);
    $mapel_id = (int)($_POST['mapel_id'] ?? 0);
    $nilai    = parse_nilai($_POST['nilai'] ?? 0);
    $is_edit  = (bool)($_POST['is_edit'] ?? false);

    // upsert
    $check = $pdo->prepare("SELECT id FROM nilai WHERE siswa_id=? AND mapel_id=?");
    $check->execute([$siswa_id, $mapel_id]);
    $existing = $check->fetch();

    if ($existing) {
      if (!$is_edit) {
        $_SESSION['flash_error'] = 'Nilai mata pelajaran ini sudah ada! Gunakan ikon Pensil untuk mengedit.';
        redirect($_SERVER['HTTP_REFERER'] ?? '/admin/nilai/' . $siswa_id);
      }
      $pdo->prepare("UPDATE nilai SET nilai=? WHERE id=?")->execute([$nilai, $existing['id']]);
      $_SESSION['flash'] = 'Nilai berhasil diubah.';
    } else {
      $pdo->prepare("INSERT INTO nilai (siswa_id, mapel_id, nilai) VALUES (?,?,?)")->execute([$siswa_id, $mapel_id, $nilai]);
      $_SESSION['flash'] = 'Nilai baru berhasil ditambahkan.';
    }

    // Recalculate kelulusan
    SiswaController::updateStatus($siswa_id);
    $referer = $_SERVER['HTTP_REFERER'] ?? '/admin/nilai';
    redirect($referer);
  }

  public function delete(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo  = Database::pdo();
    $stmt = $pdo->prepare("SELECT siswa_id FROM nilai WHERE id=?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    $pdo->prepare("DELETE FROM nilai WHERE id=?")->execute([$id]);
    if ($row) SiswaController::updateStatus((int)$row['siswa_id']);

    $_SESSION['flash'] = 'Nilai berhasil dihapus.';
    $referer = $_SERVER['HTTP_REFERER'] ?? '/admin/nilai';
    redirect($referer);
  }
}
