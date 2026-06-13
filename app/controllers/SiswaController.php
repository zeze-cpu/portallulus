<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class SiswaController
{
  public function index(): void
  {
    require_role('admin');
    $pdo    = Database::pdo();
    $search = trim($_GET['q'] ?? '');
    $status = trim($_GET['status'] ?? '');

    $where = ["s.is_active = 1"];
    $params = [];

    $kelas_id = (int)($_GET['kelas'] ?? 0);
    if ($kelas_id > 0) {
      $where[] = "s.kelas_id = ?";
      $params[] = $kelas_id;
    }

    if ($status !== '') {
      if ($status === 'belum') {
        $where[] = "(s.status IS NULL OR s.status = 'belum')";
      } else {
        $where[] = "s.status = ?";
        $params[] = $status;
      }
    }

    $whereClause = implode(" AND ", $where);
    $stmt = $pdo->prepare("
      SELECT s.*, k.nama AS kelas_nama
      FROM siswa s
      LEFT JOIN kelas k ON k.id = s.kelas_id
      WHERE $whereClause
      ORDER BY s.nama ASC
    ");
    $stmt->execute($params);

    $siswa  = $stmt->fetchAll();
    $kelas  = $pdo->query("SELECT * FROM kelas ORDER BY nama ASC")->fetchAll();

    view('admin/siswa', [
      'title'    => 'Data Siswa',
      'siswa'    => $siswa,
      'kelas'    => $kelas,
      'search'   => $search,
      'status'   => $status,
      'kelas_id' => $kelas_id,
    ]);
  }

  public function store(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();

    $nama          = trim($_POST['nama'] ?? '');
    $nisn          = trim($_POST['nisn'] ?? '');
    $kelas_id      = (int)($_POST['kelas_id'] ?? 0) ?: null;
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? 'L';
    $tempat_lahir  = trim($_POST['tempat_lahir'] ?? '') ?: null;
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '') ?: null;

    $pdo->prepare("
      INSERT INTO siswa (nama, nisn, kelas_id, jenis_kelamin, tempat_lahir, tanggal_lahir, status, is_active)
      VALUES (?, ?, ?, ?, ?, ?, 'belum', 1)
    ")->execute([$nama, $nisn, $kelas_id, $jenis_kelamin, $tempat_lahir, $tanggal_lahir]);

    $_SESSION['flash'] = 'Siswa berhasil ditambahkan.';
    redirect('/admin/siswa');
  }

  public function edit(int $id): void
  {
    require_role('admin');
    $pdo  = Database::pdo();
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if (!$item) {
      $_SESSION['flash_error'] = 'Data siswa tidak ditemukan.';
      redirect('/admin/siswa');
    }
    $kelas = $pdo->query("SELECT * FROM kelas ORDER BY nama ASC")->fetchAll();

    view('admin/siswa_form', ['title' => 'Edit Siswa', 'item' => $item, 'kelas' => $kelas]);
  }

  public function update(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();

    $nama          = trim($_POST['nama'] ?? '');
    $nisn          = trim($_POST['nisn'] ?? '');
    $kelas_id      = (int)($_POST['kelas_id'] ?? 0) ?: null;
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? 'L';
    $tempat_lahir  = trim($_POST['tempat_lahir'] ?? '') ?: null;
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '') ?: null;
    $status        = $_POST['status'] ?? 'belum';

    try {
      $pdo->prepare("
        UPDATE siswa SET nama=?, nisn=?, kelas_id=?, jenis_kelamin=?, tempat_lahir=?, tanggal_lahir=?, status=?
        WHERE id=?
      ")->execute([$nama, $nisn, $kelas_id, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $status, $id]);
    } catch (\PDOException $e) {
      $_SESSION['flash_error'] = 'Gagal menyimpan data siswa. Periksa NISN (tidak boleh duplikat) dan kelas yang dipilih.';
      redirect('/admin/siswa');
      return;
    }

    $_SESSION['flash'] = 'Data siswa berhasil diperbarui.';
    redirect('/admin/siswa');
  }

  public function delete(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();
    $pdo->prepare("UPDATE siswa SET is_active = 0 WHERE id=?")->execute([$id]);
    $_SESSION['flash'] = 'Siswa berhasil dihapus.';
    redirect('/admin/siswa');
  }

  public static function updateStatus(int $siswaId): void
  {
    $pdo = Database::pdo();
    
    // Get all grades and KKM
    $stmt = $pdo->prepare("
      SELECT n.nilai, m.kkm 
      FROM nilai n 
      JOIN mapel m ON m.id = n.mapel_id 
      WHERE n.siswa_id = ?
    ");
    $stmt->execute([$siswaId]);
    $grades = $stmt->fetchAll();
    
    if (empty($grades)) {
      $pdo->prepare("UPDATE siswa SET status = 'belum' WHERE id = ?")->execute([$siswaId]);
      return;
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
  }
}
