<div class="skl-container">
  <!-- Kop Surat -->
  <div class="kop-surat">
    <table style="width: 100%;">
      <tr>
        <td style="width: 100px; text-align: center;">
          <?php if (!empty($skl['logo'])): ?>
            <img src="<?= asset('uploads/' . $skl['logo']) ?>" style="width: 85px; max-height: 85px; object-fit: contain;">
          <?php endif; ?>
        </td>
        <td style="text-align: center; line-height: 1.2;">
          <p style="margin: 0; font-size: 14pt; letter-spacing: 0.5px;">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA<br>DINAS PENDIDIKAN</p>
          <h2 style="margin: 2px 0; font-size: 13.5pt; text-transform: uppercase; white-space: nowrap; font-weight: bold;">SEKOLAH MENENGAH PERTAMA (SMP) NEGERI 240 JAKARTA</h2>
          <p style="margin: 0; font-size: 10pt;"><?= nl2br(e($skl['alamat_sekolah'] ?? 'Jalan Haji Raya No. 16b Kecamatan Kebayoran Baru, Jakarta Selatan')) ?></p>
          <p style="margin: 0; font-size: 10pt;">Laman: <i>www.smpn240jakarta.sch.id</i> &nbsp; Email: <i>smpnegerijkt240@gmail.com</i></p>
          <div style="position: relative; font-size: 10pt; margin-top: 2px;">
            <span style="display: block; text-align: center; font-weight: bold;">JAKARTA</span>
            <span style="position: absolute; right: 0; top: 0;">Kode Pos : 12140</span>
          </div>
        </td>
      </tr>
    </table>
    <hr style="border: 0; border-top: 4px solid #000; margin: 0; margin-bottom: 2px;">
    <hr style="border: 0; border-top: 1px solid #000; margin: 0; margin-bottom: 10px;">
  </div>

  <div class="content" style="text-align: center;">
    <h3 style="margin-bottom: 2px; font-size: 16px; font-weight: bold; text-decoration: underline; letter-spacing: 1px;">SURAT KETERANGAN LULUS</h3>
    <p style="margin-top: 0; font-size: 13px;">Nomor : <?= e($skl['no_surat'] ?? '') ?></p>
    
    <?php
      $tahunIni = date('Y');
      $tahunLalu = $tahunIni - 1;
      $tahunAjaran = $tahunLalu . '/' . $tahunIni;

      $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      
      function terbilangTgl($angka) {
          $angka = (int) abs($angka);
          $baca = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
          $terbilang = "";
          if ($angka < 12) {
              $terbilang = " " . $baca[$angka];
          } else if ($angka < 20) {
              $terbilang = terbilangTgl($angka - 10) . " belas";
          } else if ($angka < 100) {
              $terbilang = terbilangTgl((int)($angka / 10)) . " puluh" . terbilangTgl($angka % 10);
          }
          return trim($terbilang);
      }
      
      $tglStr = terbilangTgl((int)date('j'));
      $blnStr = $bulanIndo[(int)date('n')];
      $thnStr = date('Y');
      $tglAjar = $tglStr . ' bulan ' . $blnStr . ' tahun ' . $thnStr;
    ?>

    <div style="text-align: justify; margin: 10px 0; font-size: 13px; line-height: 1.4;">
      <p style="text-indent: 0;">Berdasarkan Keputusan Kepala <?= e($skl['nama_sekolah'] ?? 'SMP NEGERI 240 JAKARTA') ?> tentang Penetapan Kelulusan Peserta Didik Tahun Ajaran <?= $tahunAjaran ?> Nomor <?= e($skl['no_surat'] ?? '') ?> tanggal <?= $tglAjar ?>, Kepala Sekolah menerangkan bahwa:</p>
    </div>

    <table style="margin: 10px 0 10px 40px; width: 90%; text-align: left; font-size: 13px; border: none; line-height: 1.4;">
      <tr><td style="width: 250px;">Nama Lengkap</td><td>: <strong><?= strtoupper(e($siswa['nama'])) ?></strong></td></tr>
      <?php
        $tglLahirSiswa = !empty($siswa['tanggal_lahir']) ? strtotime($siswa['tanggal_lahir']) : false;
        $tglLahirText = $tglLahirSiswa ? date('j', $tglLahirSiswa) . ' ' . $bulanIndo[(int)date('n', $tglLahirSiswa)] . ' ' . date('Y', $tglLahirSiswa) : '-';
        $tempatLahir = !empty($siswa['tempat_lahir']) ? ucwords(strtolower(e($siswa['tempat_lahir']))) : '-';
        $ttl = $tempatLahir === '-' && $tglLahirText === '-' ? '-' : ($tempatLahir !== '-' && $tglLahirText !== '-' ? $tempatLahir . ', ' . $tglLahirText : ($tempatLahir !== '-' ? $tempatLahir : $tglLahirText));
      ?>
      <tr><td>Tempat, Tanggal Lahir</td><td>: <?= $ttl ?></td></tr>
      <tr><td>Nomor Induk Siswa Nasional</td><td>: <?= e($siswa['nisn']) ?></td></tr>
      <tr><td>Satuan Pendidikan</td><td>: SMP Negeri 240 Jakarta</td></tr>
      <tr><td>Nomor Pokok Sekolah Nasional</td><td>: <?= e($skl['npsn'] ?? '20102497') ?></td></tr>
      <tr><td>Tanggal Kelulusan</td><td>: <?= date('j') . ' ' . $bulanIndo[(int)date('n')] . ' ' . date('Y') ?></td></tr>
      <tr><td>Dinyatakan</td><td>: <strong style="font-size: 15px; letter-spacing: 1px;"><?= $siswa['status'] === 'lulus' ? 'LULUS' : ($siswa['status'] === 'tidak_lulus' ? 'TIDAK LULUS' : 'BELUM DITENTUKAN') ?></strong></td></tr>
    </table>
    
    <div style="text-align: left; margin: 10px 0 8px 0; font-size: 13px;">
      <p>dengan transkrip nilai sebagai berikut:</p>
    </div>

    <!-- Tabel Nilai -->
    <table class="tabel-nilai" border="1" style="width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 13px;">
      <thead>
        <tr>
          <th style="padding: 4px; width: 60px; text-align: center;">No</th>
          <th style="padding: 4px; text-align: center;">Mata Pelajaran</th>
          <th style="padding: 4px; width: 150px; text-align: center;">Nilai</th>
        </tr>
      </thead>
      <tbody>
        <?php 
           $i = 1; 
           $totalNilai = 0;
           foreach ($nilai as $n): 
             $totalNilai += (float)$n['nilai'];
        ?>
          <tr>
            <td style="text-align: center; padding: 4px;"><?= $i++ ?></td>
            <td style="text-align: left; padding: 4px 15px;"><?= e($n['mapel_nama']) ?></td>
            <td style="text-align: center; padding: 4px;"><?= e(format_nilai($n['nilai'])) ?></td>
          </tr>
        <?php endforeach; ?>
        <?php $rataRata = count($nilai) > 0 ? $totalNilai / count($nilai) : 0; ?>
        <tr style="font-weight: bold;">
           <td colspan="2" style="text-align: center; padding: 4px; letter-spacing: 1px;">Rata-rata</td>
           <td style="text-align: center; padding: 4px;"><?= e(format_nilai($rataRata)) ?></td>
        </tr>
      </tbody>
    </table>

    <div style="text-align: justify; font-size: 12px; margin-bottom: 15px;">
      <p>Surat keterangan Lulus ini bersifat sementara sampai diterbitkan Ijazah dan Transkrip Nilai peserta didik.</p>
    </div>

    <!-- Tanda Tangan -->
    <div style="float: right; width: 220px; text-align: left; position: relative; font-size: 13px;">
      <p>Jakarta, <?= date('j') . ' ' . $bulanIndo[(int)date('n')] . ' ' . date('Y') ?></p>
      <p style="margin-bottom: 50px;">Kepala Sekolah,</p>
      
      <div style="position: absolute; top: 40px; left: -20px; z-index: -1;">
        <?php if (!empty($skl['stempel'])): ?>
          <img src="<?= asset('uploads/' . $skl['stempel']) ?>" style="height: 100px; opacity: 0.8; mix-blend-mode: multiply;">
        <?php endif; ?>
      </div>
      <div style="position: absolute; top: 45px; left: 10px;">
        <?php if (!empty($skl['ttd'])): ?>
          <img src="<?= asset('uploads/' . $skl['ttd']) ?>" style="height: 70px; mix-blend-mode: multiply;">
        <?php endif; ?>
      </div>

      <p style="margin-bottom: 2px;"><strong><u><?= e($skl['nama_kepsek'] ?: 'Drs. Budiyana, M.Pd') ?></u></strong></p>
      <p style="margin-top: 0;">NIP. <?= e($skl['nip_kepsek'] ?: '196506171995121001') ?></p>
    </div>
    <div style="clear: both;"></div>
  </div>

  <div class="no-print" style="margin-top: 40px; text-align: center; padding-top: 20px; border-top: 1px dashed #ccc;">
    <button onclick="window.print()" style="padding: 12px 24px; cursor: pointer; background: #4f46e5; color: white; border: none; border-radius: 8px; font-weight: bold; margin-right: 10px; box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);">🖨️ Cetak / Simpan PDF</button>
    <button onclick="window.history.back()" style="padding: 12px 24px; cursor: pointer; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: bold;">Kembali</button>
  </div>
</div>

<style>
  .skl-container { 
    max-width: 800px; 
    margin: 20px auto; 
    background: white; 
    padding: 40px; 
    font-family: 'Times New Roman', Times, serif;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
  }
  h2, h3, p, td, th { 
    color: #000; 
    font-family: 'Times New Roman', Times, serif; 
  }
  
  .tabel-nilai th {
    background-color: #f8fafc;
    border: 1px solid #111;
  }
  .tabel-nilai td {
    border: 1px solid #111;
  }

  @media print {
    @page {
      size: A4;
      margin: 1cm 1.5cm;
    }
    body { background: white; }
    .skl-container { 
      padding: 0; 
      margin: 0; 
      width: 100%; 
      max-width: none; 
      box-shadow: none; 
    }
    .no-print { display: none !important; }
  }
</style>
