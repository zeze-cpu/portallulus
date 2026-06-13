<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class JurusanController
{
  public function index(): void
  {
    require_role('admin');
    $pdo     = Database::pdo();
    $jurusan = $pdo->query("SELECT * FROM jurusan ORDER BY id ASC")->fetchAll();

    view('admin/jurusan', ['title' => 'Kelola Jurusan', 'jurusan' => $jurusan]);
  }

  public function store(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo  = Database::pdo();
    $nama = trim($_POST['nama'] ?? '');
    $kode = strtoupper(trim($_POST['kode'] ?? ''));

    if ($nama === '') { redirect('/admin/jurusan'); return; }

    $pdo->prepare("INSERT INTO jurusan (nama, kode) VALUES (?, ?)")->execute([$nama, $kode]);
    $_SESSION['flash'] = 'Jurusan berhasil ditambahkan.';
    redirect('/admin/jurusan');
  }

  public function edit(int $id): void
  {
    require_role('admin');
    $pdo  = Database::pdo();
    $item = $pdo->prepare("SELECT * FROM jurusan WHERE id = ?");
    $item->execute([$id]);
    $item = $item->fetch();

    view('admin/jurusan_edit', ['title' => 'Edit Jurusan', 'item' => $item]);
  }

  public function update(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo  = Database::pdo();
    $nama = trim($_POST['nama'] ?? '');
    $kode = strtoupper(trim($_POST['kode'] ?? ''));

    $pdo->prepare("UPDATE jurusan SET nama=?, kode=? WHERE id=?")->execute([$nama, $kode, $id]);
    $_SESSION['flash'] = 'Jurusan berhasil diperbarui.';
    redirect('/admin/jurusan');
  }

  public function delete(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();
    $pdo->prepare("DELETE FROM jurusan WHERE id=?")->execute([$id]);
    $_SESSION['flash'] = 'Jurusan berhasil dihapus.';
    redirect('/admin/jurusan');
  }
}
