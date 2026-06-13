<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class KelasController
{
  public function index(): void
  {
    require_role('admin');
    $pdo   = Database::pdo();
    $kelas = $pdo->query("
      SELECT k.*, 
             (SELECT COUNT(id) FROM siswa s WHERE s.kelas_id = k.id AND s.is_active = 1) AS siswa_count 
      FROM kelas k 
      ORDER BY k.nama ASC
    ")->fetchAll();

    view('admin/kelas', ['title' => 'Kelola Kelas', 'kelas' => $kelas]);
  }

  public function store(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo  = Database::pdo();
    $nama = trim($_POST['nama'] ?? '');

    if ($nama === '') { redirect('/admin/kelas'); return; }

    $stmt = $pdo->prepare("SELECT id FROM kelas WHERE nama = ?");
    $stmt->execute([$nama]);
    if ($stmt->fetch()) {
      $_SESSION['flash_error'] = 'Kelas sudah ada.';
      redirect('/admin/kelas');
    }

    $pdo->prepare("INSERT INTO kelas (nama, kode) VALUES (?, ?)")->execute([$nama, $nama]);
    $_SESSION['flash'] = 'Kelas berhasil ditambahkan.';
    redirect('/admin/kelas');
  }

  public function edit(int $id): void
  {
    require_role('admin');
    $pdo  = Database::pdo();
    $item = $pdo->prepare("SELECT * FROM kelas WHERE id = ?");
    $item->execute([$id]);
    $item = $item->fetch();

    view('admin/kelas_edit', ['title' => 'Edit Kelas', 'item' => $item]);
  }

  public function update(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo  = Database::pdo();
    $nama = trim($_POST['nama'] ?? '');

    if ($nama === '') {
      $_SESSION['flash_error'] = 'Nama kelas wajib diisi.';
      redirect('/admin/kelas/' . $id . '/edit');
    }

    $stmt = $pdo->prepare("SELECT id FROM kelas WHERE nama = ? AND id != ?");
    $stmt->execute([$nama, $id]);
    if ($stmt->fetch()) {
      $_SESSION['flash_error'] = 'Kelas sudah ada.';
      redirect('/admin/kelas/' . $id . '/edit');
    }

    $pdo->prepare("UPDATE kelas SET nama=?, kode=? WHERE id=?")->execute([$nama, $nama, $id]);
    $_SESSION['flash'] = 'Kelas berhasil diperbarui.';
    redirect('/admin/kelas');
  }

  public function delete(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();
    $pdo->prepare("DELETE FROM kelas WHERE id=?")->execute([$id]);
    $_SESSION['flash'] = 'Kelas berhasil dihapus.';
    redirect('/admin/kelas');
  }
}
