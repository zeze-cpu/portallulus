<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class MapelController
{
  public function index(): void
  {
    require_role('admin');
    $pdo   = Database::pdo();
    $mapel = $pdo->query("SELECT * FROM mapel ORDER BY nama ASC")->fetchAll();

    view('admin/mapel', ['title' => 'Mata Pelajaran', 'mapel' => $mapel]);
  }

  public function store(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo        = Database::pdo();
    $nama       = trim($_POST['nama'] ?? '');
    $kkm        = (int)($_POST['kkm'] ?? 70);
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($nama === '') { redirect('/admin/mapel'); return; }

    $pdo->prepare("INSERT INTO mapel (nama, kkm, keterangan) VALUES (?, ?, ?)")
        ->execute([$nama, $kkm, $keterangan]);
    $_SESSION['flash'] = 'Mata pelajaran berhasil ditambahkan.';
    redirect('/admin/mapel');
  }

  public function edit(int $id): void
  {
    require_role('admin');
    $pdo  = Database::pdo();
    $stmt = $pdo->prepare("SELECT * FROM mapel WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();

    view('admin/mapel_edit', ['title' => 'Edit Mata Pelajaran', 'item' => $item]);
  }

  public function update(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo        = Database::pdo();
    $nama       = trim($_POST['nama'] ?? '');
    $kkm        = (int)($_POST['kkm'] ?? 70);
    $keterangan = trim($_POST['keterangan'] ?? '');

    $pdo->prepare("UPDATE mapel SET nama=?, kkm=?, keterangan=? WHERE id=?")
        ->execute([$nama, $kkm, $keterangan, $id]);
    $_SESSION['flash'] = 'Mata pelajaran berhasil diperbarui.';
    redirect('/admin/mapel');
  }

  public function delete(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();
    $pdo->prepare("DELETE FROM mapel WHERE id=?")->execute([$id]);
    $_SESSION['flash'] = 'Mata pelajaran berhasil dihapus.';
    redirect('/admin/mapel');
  }
}
