<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class SKLController
{
  public function index(): void
  {
    require_role('admin');
    $pdo  = Database::pdo();
    $skl  = $pdo->query("SELECT * FROM skl_settings ORDER BY id DESC LIMIT 1")->fetch();

    view('admin/skl', ['title' => 'Pengaturan SKL', 'skl' => $skl]);
  }

  public function store(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();

    $data = $this->capturePostData();
    $sql  = "INSERT INTO skl_settings (
                tahun_ajaran, nilai_minimum, keterangan, nama_sekolah, alamat_sekolah, 
                narasi, logo, stempel, ttd, nama_kepsek, nip_kepsek, 
                tgl_kelulusan, tgl_cetak, jam_pengumuman, no_surat
             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $pdo->prepare($sql)->execute(array_values($data));

    $_SESSION['flash'] = 'Pengaturan SKL berhasil disimpan.';
    redirect('/admin/skl');
  }

  public function update(int $id): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();

    $data = $this->capturePostData($id);
    $sql  = "UPDATE skl_settings SET 
                tahun_ajaran=?, nilai_minimum=?, keterangan=?, nama_sekolah=?, alamat_sekolah=?, 
                narasi=?, logo=?, stempel=?, ttd=?, nama_kepsek=?, nip_kepsek=?, 
                tgl_kelulusan=?, tgl_cetak=?, jam_pengumuman=?, no_surat=?
             WHERE id=?";
    
    $params = array_values($data);
    $params[] = $id;
    
    $pdo->prepare($sql)->execute($params);

    $_SESSION['flash'] = 'Pengaturan SKL berhasil diperbarui.';
    redirect('/admin/skl');
  }

  private function capturePostData(?int $id = null): array
  {
    $pdo = Database::pdo();
    $old = [];
    if ($id) {
      $stmt = $pdo->prepare("SELECT * FROM skl_settings WHERE id = ?");
      $stmt->execute([$id]);
      $old = $stmt->fetch() ?: [];
    }

    return [
      'tahun_ajaran'   => trim($_POST['tahun_ajaran'] ?? ''),
      'nilai_minimum'  => (float)($_POST['nilai_minimum'] ?? 60),
      'keterangan'     => trim($_POST['keterangan'] ?? ''),
      'nama_sekolah'   => trim($_POST['nama_sekolah'] ?? ''),
      'alamat_sekolah' => trim($_POST['alamat_sekolah'] ?? ''),
      'narasi'         => trim($_POST['narasi'] ?? ''),
      'logo'           => $this->handleUpload('logo', $old['logo'] ?? null),
      'stempel'        => $this->handleUpload('stempel', $old['stempel'] ?? null),
      'ttd'            => $this->handleUpload('ttd', $old['ttd'] ?? null),
      'nama_kepsek'    => trim($_POST['nama_kepsek'] ?? ''),
      'nip_kepsek'     => trim($_POST['nip_kepsek'] ?? ''),
      'tgl_kelulusan'  => $_POST['tgl_kelulusan'] ?: null,
      'tgl_cetak'      => $_POST['tgl_cetak'] ?: null,
      'jam_pengumuman' => $_POST['jam_pengumuman'] ? str_replace('T', ' ', $_POST['jam_pengumuman']) : null,
      'no_surat'       => trim($_POST['no_surat'] ?? ''),
    ];
  }

  private function handleUpload(string $field, ?string $oldFile): ?string
  {
    if (empty($_FILES[$field]['name'])) return $oldFile;

    $file     = $_FILES[$field];
    $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $field . '_' . time() . '.' . $ext;
    $target   = __DIR__ . '/../../public/uploads/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
      if ($oldFile && file_exists(__DIR__ . '/../../public/uploads/' . $oldFile)) {
        unlink(__DIR__ . '/../../public/uploads/' . $oldFile);
      }
      return $filename;
    }

    return $oldFile;
  }
}
