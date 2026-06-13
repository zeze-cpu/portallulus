<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

final class ImportController
{
  public function siswa(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();

    if (empty($_FILES['file']['tmp_name'])) {
      $_SESSION['flash'] = 'Pilih file Excel/CSV terlebih dahulu.';
      redirect('/admin/siswa');
    }

    try {
      $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
      $count = 0;
      $processed_sheets = 0;
      
      foreach ($spreadsheet->getAllSheets() as $sheet) {
        $rows = $sheet->toArray();
        if (empty($rows)) continue;

        $c_nama = -1; $c_nisn = -1; $c_jk = -1; $c_tmpt = -1; $c_tgl = -1; $c_kelas = -1;
        $headerRowIndex = -1;
        
        $global_kelas = '';
        $sheetName = trim($sheet->getTitle());
        if (preg_match('/^(kelas\s*)?([a-z0-9\.\-\s]+)$/i', $sheetName, $m)) {
            if (!preg_match('/^sheet\s*\d+$/i', $sheetName)) {
                $global_kelas = trim($m[2]);
            }
        }
        
        foreach ($rows as $rowIndex => $row) {
          // 1. Cek apakah ada deklarasi "Kelas : 9A" di baris ini
          $rowString = strtolower(implode(' ', array_map(fn($c) => (string)$c, $row)));
          if (preg_match('/kelas\s*:\s*([a-z0-9\.\-\s]+)/i', $rowString, $m)) {
              $global_kelas = trim($m[1]);
          }

          // 2. Deteksi apakah baris ini adalah Header (Judul Kolom)
          $temp_nama = -1; $temp_nisn = -1; $temp_jk = -1; $temp_tmpt = -1; $temp_tgl = -1; $temp_kelas = -1;
          $header = array_map(fn($col) => strtolower(preg_replace('/[^a-z0-9]/i', '', (string)$col)), $row);
          
          $found_nisn = false;
          foreach ($header as $i => $h) {
            if ($h === '') continue;
            if (str_contains($h, 'nama') || str_contains($h, 'name')) { $temp_nama = $i; }
            elseif (str_contains($h, 'nisn')) { $temp_nisn = $i; $found_nisn = true; }
            elseif (str_contains($h, 'nis') && !$found_nisn) { $temp_nisn = $i; }
            elseif (str_contains($h, 'jk') || str_contains($h, 'kelamin') || str_contains($h, 'gender') || $h === 'lp') { $temp_jk = $i; }
            elseif (str_contains($h, 'tempat') || str_contains($h, 'tmp')) { $temp_tmpt = $i; }
            elseif ((str_contains($h, 'tanggal') || str_contains($h, 'tgl') || str_contains($h, 'lahir')) && !str_contains($h, 'tempat')) { $temp_tgl = $i; }
            elseif (str_contains($h, 'kelas') || str_contains($h, 'rombel') || str_contains($h, 'ruang')) { $temp_kelas = $i; }
          }

          // Jika baris ini adalah header, perbarui mapping kolom dan lewati proses insert
          if ($temp_nama !== -1 && $temp_nisn !== -1) {
              $c_nama = $temp_nama; $c_nisn = $temp_nisn; $c_jk = $temp_jk;
              $c_tmpt = $temp_tmpt; $c_tgl = $temp_tgl; $c_kelas = $temp_kelas;
              $headerRowIndex = $rowIndex; // Tandai bahwa kita menemukan minimal 1 header di sheet ini
              continue;
          }

          // 3. Jika belum menemukan header sama sekali, lewati baris ini
          if ($c_nama === -1 || $c_nisn === -1) {
              continue;
          }
          
          // 4. Proses Ekstraksi Data Siswa
          $raw_nama = $row[$c_nama] ?? '';
          $raw_nisn = $row[$c_nisn] ?? '';
          
          if (empty(trim((string)$raw_nama)) || empty(trim((string)$raw_nisn))) continue;
          
          // Filter ekstra untuk mencegah baris judul yang terulang di tengah data dianggap sebagai data
          if (strtolower(preg_replace('/[^a-z0-9]/i', '', (string)$raw_nama)) === 'nama') continue;
          if (str_contains(strtolower(preg_replace('/[^a-z0-9]/i', '', (string)$raw_nisn)), 'nis')) continue;

          // Auto-tidy fields
          $nama    = ucwords(strtolower(trim((string)$raw_nama)));
          $nisn    = preg_replace('/[^0-9]/', '', (string)$raw_nisn);
          if (empty($nisn)) continue;
          
          $jk_raw  = strtoupper(trim((string)($c_jk !== -1 ? ($row[$c_jk] ?? 'L') : 'L')));
          $jk      = (str_starts_with($jk_raw, 'P') || str_starts_with($jk_raw, 'W')) ? 'P' : 'L';
          
          $tmpt    = ucwords(strtolower(trim((string)($c_tmpt !== -1 ? ($row[$c_tmpt] ?? '') : ''))));
          
          $tgl_raw = trim((string)($c_tgl !== -1 ? ($row[$c_tgl] ?? '') : ''));
          $tgl     = null;
          if ($tgl_raw !== '') {
              if (is_numeric($tgl_raw)) {
                  $tgl = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tgl_raw)->format('Y-m-d');
              } else {
                  $time = strtotime(str_replace('/', '-', $tgl_raw));
                  $tgl = $time ? date('Y-m-d', $time) : $tgl_raw;
              }
          }
          
          $kelas_val = $c_kelas !== -1 ? (string)($row[$c_kelas] ?? '') : '';
          if (empty(trim($kelas_val))) $kelas_val = $global_kelas;
          
          $kelas = strtoupper(trim($kelas_val));
          $kelas = preg_replace('/\bVII\b/i', '7', $kelas);
          $kelas = preg_replace('/\bVIII\b/i', '8', $kelas);
          $kelas = preg_replace('/\bIX\b/i', '9', $kelas);
          $kelas = str_replace('.', '', $kelas);
          
          // Bersihkan kata-kata yang sering nyasar ke nama kelas
          $kelas = str_ireplace(['MAPEL', 'MATA PELAJARAN', 'NILAI', 'DAFTAR', 'SISWA', 'ABSENSI', 'REKAP', 'KELAS'], '', $kelas);
          
          // Rapatkan spasi antara angka dan huruf tunggal (misal "9 A" menjadi "9A", "9 G" menjadi "9G")
          $kelas = preg_replace('/^(\d+)\s+([A-Z])\b/i', '$1$2', trim($kelas));
          
          $kelas = preg_replace('/\s+/', ' ', trim($kelas));
          
          $kelas_id = null;
          if ($kelas !== '') {
            $sj = $pdo->prepare("SELECT id FROM kelas WHERE nama = ? LIMIT 1");
            $sj->execute([$kelas]);
            $j_data = $sj->fetch();
            if ($j_data) {
                $kelas_id = $j_data['id'];
            } else {
                $ins = $pdo->prepare("INSERT INTO kelas (nama) VALUES (?)");
                $ins->execute([$kelas]);
                $kelas_id = $pdo->lastInsertId();
            }
          }

          $stmt = $pdo->prepare("INSERT INTO siswa (nama, nisn, jenis_kelamin, tempat_lahir, tanggal_lahir, kelas_id, status, is_active) 
                                VALUES (?, ?, ?, ?, ?, ?, 'belum', 1) 
                                ON DUPLICATE KEY UPDATE 
                                  nama = VALUES(nama), 
                                  kelas_id = VALUES(kelas_id),
                                  jenis_kelamin = VALUES(jenis_kelamin),
                                  tempat_lahir = COALESCE(NULLIF(VALUES(tempat_lahir), ''), tempat_lahir),
                                  tanggal_lahir = COALESCE(NULLIF(VALUES(tanggal_lahir), ''), tanggal_lahir)");
          $stmt->execute([$nama, $nisn, $jk, $tmpt, $tgl, $kelas_id]);
          if ($stmt->rowCount() > 0) $count++;
        }
        
        if ($headerRowIndex !== -1) {
            $processed_sheets++;
        }
      }

      if ($processed_sheets === 0) {
          $_SESSION['flash_error'] = 'Gagal mendeteksi kolom. Pastikan ada sheet dengan kolom "Nama" dan "NIS" / "NISN".';
      } else {
          $_SESSION['flash'] = "Berhasil mengimport $count data siswa dari $processed_sheets sheet Excel.";
      }
    } catch (\Exception $e) {
      $_SESSION['flash'] = "Error: " . $e->getMessage();
    }

    redirect('/admin/siswa');
  }

  public function nilai(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();

    if (empty($_FILES['file']['tmp_name'])) {
      $_SESSION['flash'] = 'Pilih file Excel/CSV terlebih dahulu.';
      redirect('/admin/nilai');
      return;
    }

    try {
      $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
      $count = 0;
      $processed_sheets = 0;
      $affectedSiswa = [];

      foreach ($spreadsheet->getAllSheets() as $sheet) {
        $rows = $sheet->toArray();
        if (empty($rows)) continue;

        $c_nisn = -1;
        $c_mapel = -1; 
        $c_nilai = -1;
        
        $subject_columns = [];
        $is_horizontal = false;
        $headerRowIndex = -1;

        foreach ($rows as $rowIndex => $row) {
          
          // Cek apakah ini berpotensi baris data (berisi NISN valid)
          $raw_nisn = $c_nisn !== -1 ? ($row[$c_nisn] ?? '') : '';
          $nisn  = preg_replace('/[^0-9]/', '', (string)$raw_nisn);
          $is_data_row = ($c_nisn !== -1 && strlen($nisn) >= 4);

          // Jika BUKAN baris data, lakukan scan/update posisi kolom
          if (!$is_data_row) {
              // 1. Cari NISN, Mapel, Nilai (Vertikal Format) & Update c_nisn
              $header = array_map(fn($col) => strtolower(preg_replace('/[^a-z0-9]/i', '', (string)$col)), $row);
              $found_nisn = false;
              $temp_mapel = -1; $temp_nilai = -1;
              foreach ($header as $i => $h) {
                if ($h === '') continue;
                if (str_contains($h, 'nisn')) { $c_nisn = $i; $found_nisn = true; }
                elseif (str_contains($h, 'nis') && !$found_nisn) { $c_nisn = $i; }
                elseif (str_contains($h, 'mapel') || str_contains($h, 'matapelajaran') || str_contains($h, 'pelajaran')) { $temp_mapel = $i; }
                elseif (str_contains($h, 'nilai') || str_contains($h, 'score') || str_contains($h, 'angka') || str_contains($h, 'akhir')) { $temp_nilai = $i; }
              }
              if ($temp_mapel !== -1 && $temp_nilai !== -1 && $c_nisn !== -1) {
                  $c_mapel = $temp_mapel; $c_nilai = $temp_nilai;
                  $is_horizontal = false;
                  $headerRowIndex = $rowIndex;
              }

              // 2. Cari Subject Columns (Horizontal/Leger Format)
              $current_subject = '';
              $temp_subjects = [];
              $start_col = -1;
              foreach ($row as $i => $raw_h) {
                  $h = strtolower(preg_replace('/[^a-z0-9]/i', '', (string)$raw_h));
                  if ($h !== '') {
                      // Abaikan angka, KKM, dan demografi
                      if (!preg_match('/^[0-9]+$/', $h) && !in_array($h, ['no','nisn','nis','nama','namasiswa','kelas','jk','l','p','gender', 'kkm', 'kktp', 'asli', 'leger', 'sekolah'])) {
                          if ($current_subject !== '') {
                              $temp_subjects[$i - 1] = $current_subject;
                          }
                          $current_subject = trim((string)$raw_h);
                          $start_col = $i;
                      } else {
                          // Terputus oleh sesuatu yang bukan mapel (misalnya demografi)
                          if ($current_subject !== '') {
                              $temp_subjects[$i - 1] = $current_subject;
                              $current_subject = '';
                          }
                      }
                  }
              }
              if ($current_subject !== '') {
                  $end_col = count($row) - 1;
                  // Cari kolom terakhir yang tidak kosong untuk blok subject ini
                  for ($j = count($row) - 1; $j >= $start_col; $j--) {
                      if (trim((string)($row[$j] ?? '')) !== '' || trim((string)($rows[$rowIndex+1][$j] ?? '')) !== '') {
                          $end_col = $j;
                          break;
                      }
                  }
                  $temp_subjects[$end_col] = $current_subject;
              }

              if (count($temp_subjects) > 0) {
                  $subject_columns = $temp_subjects;
                  $is_horizontal = true;
                  $headerRowIndex = $rowIndex;
              }
          } else {
              // INI ADALAH BARIS DATA - Lakukan Insert!
              
              // Cari Siswa di database
              $s = $pdo->prepare("SELECT id FROM siswa WHERE nisn = ? LIMIT 1");
              $s->execute([$nisn]);
              $siswa = $s->fetch();
              
              if (!$siswa) continue; 

              if (!$is_horizontal && $c_mapel !== -1 && $c_nilai !== -1) {
                  $raw_mapel = $row[$c_mapel] ?? '';
                  $raw_nilai = $row[$c_nilai] ?? '';
                  if (empty(trim((string)$raw_mapel)) || trim((string)$raw_nilai) === '') continue;

                  $mapel = ucwords(strtolower(trim((string)$raw_mapel)));
                  $score = parse_nilai($raw_nilai);
                  $this->importSingleNilai($pdo, $siswa['id'], $mapel, $score, $affectedSiswa, $count);
              } elseif ($is_horizontal) {
                  foreach ($subject_columns as $colIndex => $mapelName) {
                      $raw_nilai = $row[$colIndex] ?? '';
                      if (trim((string)$raw_nilai) === '') continue; // Skip kosong

                      // Jika kolomnya berisi coretan / huruf bukan angka, abaikan
                      if (preg_match('/[a-zA-Z]/', (string)$raw_nilai)) continue;

                      $mapel = ucwords(strtolower(trim((string)$mapelName)));
                      $score = parse_nilai($raw_nilai);
                      $this->importSingleNilai($pdo, $siswa['id'], $mapel, $score, $affectedSiswa, $count);
                  }
              }
          }
        }
        
        if ($headerRowIndex !== -1) {
            $processed_sheets++;
        }
      }

      // Final pass: Update status untuk siswa yang terpengaruh
      $affectedSiswa = array_unique($affectedSiswa);
      foreach ($affectedSiswa as $sid) {
        SiswaController::updateStatus((int)$sid);
      }

      if ($processed_sheets === 0) {
          $_SESSION['flash_error'] = 'Gagal mendeteksi format Excel. Pastikan ada kolom "NIS/NISN" di sheet Anda.';
      } else {
          $_SESSION['flash'] = "Berhasil mengimport $count data nilai dari $processed_sheets sheet Excel!";
      }
    } catch (\Exception $e) {
      $_SESSION['flash'] = "Error: " . $e->getMessage();
    }

    redirect('/admin/nilai');
  }

  private function importSingleNilai($pdo, $siswa_id, $mapel, $score, &$affectedSiswa, &$count): void {
      // Smart Mapel Alias (Menyatukan nama-nama singkatan)
      $mapel = preg_replace('/\s+/', ' ', trim($mapel));
      $ml = strtolower($mapel);
      
      if (preg_match('/\b(pend.*agama|p\s*agama|agama|pai)\b/i', $ml)) {
          $mapel = 'Pendidikan Agama dan Budi Pekerti';
      } elseif (preg_match('/\b(pend.*pancasila|pancasila|ppkn|pkn|p\s*p)\b/i', $ml)) {
          $mapel = 'Pendidikan Pancasila';
      } elseif (preg_match('/\b(bahasa indonesia|b\.?\s*indo|b\.?\s*indonesia|bind|b\.ind)\b/i', $ml)) {
          $mapel = 'Bahasa Indonesia';
      } elseif (preg_match('/\b(matematika|mtk|mat)\b/i', $ml)) {
          $mapel = 'Matematika';
      } elseif (preg_match('/\b(bahasa inggris|inggris|b\.?\s*ing|b\.?\s*inggris)\b/i', $ml)) {
          $mapel = 'Bahasa Inggris';
      } elseif (preg_match('/\b(ilmu pengetahuan alam|ipa)\b/i', $ml)) {
          $mapel = 'Ilmu Pengetahuan Alam';
      } elseif (preg_match('/\b(ilmu pengetahuan sosial|ips)\b/i', $ml)) {
          $mapel = 'Ilmu Pengetahuan Sosial';
      } elseif (preg_match('/\b(pend.*jasmani|pjok|penjas|olahraga|penjaskes)\b/i', $ml)) {
          $mapel = 'Pendidikan Jasmani Olahraga dan Kesehatan';
      } elseif (preg_match('/\b(seni budaya|sbd|sbdp)\b/i', $ml)) {
          $mapel = 'Seni Budaya dan Prakarya';
      } elseif (preg_match('/\b(informatika|tik)\b/i', $ml)) {
          $mapel = 'Informatika';
      } elseif (preg_match('/\b(muatan lokal|mulok|bahasa daerah)\b/i', $ml)) {
          $mapel = 'Muatan Lokal';
      } else {
          $mapel = ucwords($ml);
      }

      // Cari / Buat Mapel
      $m = $pdo->prepare("SELECT id FROM mapel WHERE nama = ? LIMIT 1");
      $m->execute([$mapel]);
      $mapel_data = $m->fetch();
      
      $mapel_id = null;
      if ($mapel_data) {
         $mapel_id = $mapel_data['id'];
      } else {
         $ins = $pdo->prepare("INSERT INTO mapel (nama, kkm) VALUES (?, 75)");
         $ins->execute([$mapel]);
         $mapel_id = $pdo->lastInsertId();
      }

      // Upsert
      $stmt = $pdo->prepare("INSERT INTO nilai (siswa_id, mapel_id, nilai) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)");
      $stmt->execute([$siswa_id, $mapel_id, $score]);
      $count++;
      $affectedSiswa[] = $siswa_id;
  }
  public function templateSiswa(): void
  {
    require_role('admin');
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set Header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'NISN');
    $sheet->setCellValue('C1', 'Nama Lengkap');
    $sheet->setCellValue('D1', 'L/P');
    $sheet->setCellValue('E1', 'Kelas');
    $sheet->setCellValue('F1', 'Status Kelulusan');
    $sheet->setCellValue('G1', 'Aksi');
    
    // Set Example Data
    $sheet->setCellValue('A2', '1');
    $sheet->setCellValue('B2', '0012345678');
    $sheet->setCellValue('C2', 'Ahmad Dahlan');
    $sheet->setCellValue('D2', 'L');
    $sheet->setCellValue('E2', '9A');
    $sheet->setCellValue('F2', '');
    $sheet->setCellValue('G2', '');

    // Styling
    foreach (range('A', 'F') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
      $sheet->getStyle($col.'1')->getFont()->setBold(true);
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="template_siswa.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
  }

  public function templateNilaiPrefilled(): void
  {
    require_role('admin');
    $pdo = Database::pdo();
    $siswa = $pdo->query("SELECT nama, nisn FROM siswa WHERE is_active = 1 ORDER BY nama ASC")->fetchAll();
    $mapel = $pdo->query("SELECT nama FROM mapel ORDER BY nama ASC")->fetchAll();
    $mapelNames = array_column($mapel, 'nama');

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set Header
    $sheet->setCellValue('A1', 'NISN');
    $sheet->setCellValue('B1', 'Nama Siswa (Hanya Referensi)');
    $sheet->setCellValue('C1', 'Nama Mata Pelajaran');
    $sheet->setCellValue('D1', 'Nilai (Angka)');
    
    // Fill Student Data
    $rowNum = 2;
    foreach ($siswa as $s) {
      $sheet->setCellValue('A' . $rowNum, $s['nisn']);
      $sheet->setCellValue('B' . $rowNum, $s['nama']);
      
      // Add Dropdown for Mapel
      if (!empty($mapelNames)) {
        $validation = $sheet->getCell('C' . $rowNum)->getDataValidation();
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input error');
        $validation->setError('Mata pelajaran tidak ada dalam daftar.');
        $validation->setPromptTitle('Pilih Mapel');
        $validation->setPrompt('Pilih mata pelajaran dari daftar.');
        $validation->setFormula1('"' . implode(',', $mapelNames) . '"');
      }

      $rowNum++;
    }

    // Styling
    foreach (range('A', 'D') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
      $sheet->getStyle($col.'1')->getFont()->setBold(true);
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="template_nilai_otomatis.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
  }

  public function jurusan(): void
  {
    require_role('admin');
    csrf_verify();
    $pdo = Database::pdo();

    if (empty($_FILES['file']['tmp_name'])) {
      $_SESSION['flash'] = 'Pilih file Excel/CSV terlebih dahulu.';
      redirect('/admin/jurusan');
      return;
    }

    try {
      $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
      $sheet = $spreadsheet->getActiveSheet();
      $rows = $sheet->toArray();
      
      if (empty($rows)) {
        $_SESSION['flash_error'] = 'File kosong.';
        redirect('/admin/jurusan');
        return;
      }

      $headerRowIndex = -1;
      $c_kode = -1; $c_nama = -1;
      
      // Mendeteksi Header Secara Dinamis
      foreach ($rows as $rowIndex => $row) {
        $temp_kode = -1; $temp_nama = -1;
        $header = array_map(fn($col) => strtolower(preg_replace('/[^a-z0-9]/i', '', (string)$col)), $row);
        
        foreach ($header as $i => $h) {
          if ($h === '') continue;
          if (str_contains($h, 'kode') || str_contains($h, 'singkatan') || $h === 'kd') { $temp_kode = $i; }
          elseif (str_contains($h, 'nama') || str_contains($h, 'jurusan') || str_contains($h, 'kompetensi')) { $temp_nama = $i; }
        }

        // Header valid jika menemukan kolom kode dan nama
        if ($temp_kode !== -1 && $temp_nama !== -1) {
            $headerRowIndex = $rowIndex;
            $c_kode = $temp_kode; $c_nama = $temp_nama;
            break;
        }
      }

      if ($headerRowIndex === -1) {
          $_SESSION['flash_error'] = 'Gagal mendeteksi kolom. Pastikan ada judul kolom yang mengandung kata "Kode" dan "Nama".';
          redirect('/admin/jurusan');
          return;
      }
      
      $count = 0;
      foreach ($rows as $index => $row) {
        if ($index <= $headerRowIndex) continue; // Lewati header
        
        $raw_kode = $row[$c_kode] ?? '';
        $raw_nama = $row[$c_nama] ?? '';
        
        // Skip baris kosong
        if (empty(trim((string)$raw_kode)) || empty(trim((string)$raw_nama))) continue;

        // Auto-Tidy / Normalisasi string
        $kode = strtoupper(trim((string)$raw_kode));
        $nama = ucwords(strtolower(trim((string)$raw_nama)));
        
        // Upsert logic (Insert jika belum ada, Update jika kode sudah ada)
        // Kita butuh primary/unique constraint di kode, atau kita cek manual:
        $cek = $pdo->prepare("SELECT id FROM jurusan WHERE kode = ? LIMIT 1");
        $cek->execute([$kode]);
        $existing = $cek->fetch();

        if ($existing) {
            $stmt = $pdo->prepare("UPDATE jurusan SET nama = ? WHERE id = ?");
            $stmt->execute([$nama, $existing['id']]);
            $count++;
        } else {
            $stmt = $pdo->prepare("INSERT INTO jurusan (kode, nama) VALUES (?, ?)");
            $stmt->execute([$kode, $nama]);
            $count++;
        }
      }

      $_SESSION['flash'] = "Berhasil memproses $count data jurusan dengan cerdas!";
    } catch (\Exception $e) {
      $_SESSION['flash'] = "Error: " . $e->getMessage();
    }

    redirect('/admin/jurusan');
  }

  public function templateJurusan(): void
  {
    require_role('admin');
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set Header
    $sheet->setCellValue('A1', 'Kode Jurusan');
    $sheet->setCellValue('B1', 'Nama Jurusan');
    
    // Set Example Data
    $sheet->setCellValue('A2', 'RPL');
    $sheet->setCellValue('B2', 'Rekayasa Perangkat Lunak');
    $sheet->setCellValue('A3', 'TKJ');
    $sheet->setCellValue('B3', 'Teknik Komputer dan Jaringan');

    // Styling
    foreach (range('A', 'B') as $col) {
      $sheet->getColumnDimension($col)->setAutoSize(true);
      $sheet->getStyle($col.'1')->getFont()->setBold(true);
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="template_jurusan.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
  }
}
