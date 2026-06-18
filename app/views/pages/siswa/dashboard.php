<div class="auth-card wide">
  <div class="auth-header">
    <div class="auth-logo">
      <i class='bx bxs-graduation'></i>
    </div>
    <h1 class="auth-title">Portal Kelulusan Siswa</h1>
    <p class="auth-subtitle"><?= e($siswa['nama']) ?> &nbsp;•&nbsp; NISN: <strong><?= e($siswa['nisn']) ?></strong> &nbsp;•&nbsp; Kelas: <strong><?= e($siswa['kelas_nama'] ?: '-') ?></strong></p>
  </div>

  <?php if (!$isOpen): ?>
    <!-- Countdown Timer -->
    <div id="countdown-container" style="text-align: center; padding: 40px 0;">
      <h2 style="margin-bottom: 32px; font-size: 18px; color: #64748b; font-weight: 600;">Pengumuman kelulusan akan dibuka dalam:</h2>
      
      <div id="timer" style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 24px; border-radius: 24px; min-width: 110px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
          <span id="days" style="font-size: 48px; font-weight: 800; color: #4f46e5; line-height: 1; display: block;">00</span>
          <small style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-top: 10px; letter-spacing: 0.1em; display: block;">Hari</small>
        </div>
        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 24px; border-radius: 24px; min-width: 110px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
          <span id="hours" style="font-size: 48px; font-weight: 800; color: #4f46e5; line-height: 1; display: block;">00</span>
          <small style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-top: 10px; letter-spacing: 0.1em; display: block;">Jam</small>
        </div>
        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 24px; border-radius: 24px; min-width: 110px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
          <span id="minutes" style="font-size: 48px; font-weight: 800; color: #4f46e5; line-height: 1; display: block;">00</span>
          <small style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-top: 10px; letter-spacing: 0.1em; display: block;">Menit</small>
        </div>
        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 24px; border-radius: 24px; min-width: 110px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
          <span id="seconds" style="font-size: 48px; font-weight: 800; color: #4f46e5; line-height: 1; display: block;">00</span>
          <small style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-top: 10px; letter-spacing: 0.1em; display: block;">Detik</small>
        </div>
      </div>
    </div>

    <script>
      (function() {
        const targetStr = "<?= str_replace('/', '-', $target) ?>";
        const targetDate = new Date(targetStr).getTime();
        
        let serverTime = <?= time() * 1000 ?>; 
        
        function updateTimer() {
          serverTime += 1000;
          const diff = targetDate - serverTime;
          
          if (diff <= 0) {
            clearInterval(timerInterval);
            setTimeout(() => window.location.reload(), 2000);
            return;
          }
          
          const d = Math.floor(diff / (1000 * 60 * 60 * 24));
          const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
          const s = Math.floor((diff % (1000 * 60)) / 1000);
          
          const elDays = document.getElementById("days");
          const elHours = document.getElementById("hours");
          const elMin = document.getElementById("minutes");
          const elSec = document.getElementById("seconds");

          if(elDays) elDays.innerText = d.toString().padStart(2, '0');
          if(elHours) elHours.innerText = h.toString().padStart(2, '0');
          if(elMin) elMin.innerText = m.toString().padStart(2, '0');
          if(elSec) elSec.innerText = s.toString().padStart(2, '0');
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
      })();
    </script>

  <?php else: ?>
    <!-- Status Kelulusan -->
    <style>
      @keyframes sadPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(0.92) rotate(-3deg); }
      }
      .anim-tidak-lulus {
        display: inline-block;
        animation: sadPulse 3s ease-in-out infinite;
      }

      @keyframes floatSpin {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-8px) rotate(15deg); }
        100% { transform: translateY(0) rotate(0deg); }
      }
      .anim-belum {
        display: inline-block;
        animation: floatSpin 4s ease-in-out infinite;
      }


      @keyframes gradAppear {
        0%, 32% { transform: scale(0); opacity: 0; }
        36% { transform: scale(1.4) rotate(-10deg); opacity: 1; }
        42% { transform: scale(1) rotate(10deg); opacity: 1; }
        48% { transform: scale(1.1) rotate(0deg); opacity: 1; }
        85% { transform: scale(1.1) rotate(0deg); opacity: 1; }
        90% { transform: scale(1.5); opacity: 0; filter: blur(4px); }
        100% { transform: scale(0); opacity: 0; }
      }
      @keyframes confettiShoot1 {
        0%, 32% { transform: translate(0, 0) scale(0); opacity: 0; }
        36% { transform: translate(-70px, -50px) scale(1.5) rotate(-45deg); opacity: 1; }
        60% { transform: translate(-90px, 20px) scale(1) rotate(-90deg); opacity: 0; }
        100% { opacity: 0; }
      }
      @keyframes confettiShoot2 {
        0%, 32% { transform: translate(0, 0) scale(0); opacity: 0; }
        36% { transform: translate(70px, -50px) scale(1.5) rotate(45deg); opacity: 1; }
        60% { transform: translate(90px, 20px) scale(1) rotate(90deg); opacity: 0; }
        100% { opacity: 0; }
      }
      @keyframes confettiShoot3 {
        0%, 32% { transform: translate(0, 0) scale(0); opacity: 0; }
        36% { transform: translate(0px, -80px) scale(1.5) rotate(15deg); opacity: 1; }
        60% { transform: translate(0px, -20px) scale(1) rotate(45deg); opacity: 0; }
        100% { opacity: 0; }
      }


      .anim-grad {
        position: absolute;
        animation: gradAppear 6s cubic-bezier(0.34, 1.56, 0.64, 1) infinite;
        filter: drop-shadow(0 8px 16px rgba(21, 128, 61, 0.3));
      }
      .confetti-1 {
        position: absolute;
        animation: confettiShoot1 6s ease-out infinite;
      }
      .confetti-2 {
        position: absolute;
        animation: confettiShoot2 6s ease-out infinite;
      }
      .confetti-3 {
        position: absolute;
        animation: confettiShoot3 6s ease-out infinite;
      }
    </style>
    
    <div style="margin-bottom: 32px;">
      <?php if ($siswa['status'] === 'lulus'): ?>
        <div style="text-align: center; padding: 60px 30px; border-radius: 32px; background: linear-gradient(145deg, #ffffff, #f0fdf4); border: 1px solid rgba(22, 163, 74, 0.2); box-shadow: 0 20px 40px rgba(22, 163, 74, 0.08), inset 0 2px 10px rgba(255, 255, 255, 0.8); color: #166534; position: relative; overflow: hidden;">
          <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 200px; height: 200px; background: radial-gradient(circle, rgba(34, 197, 94, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
          
          <div style="position: relative; height: 120px; display: flex; justify-content: center; align-items: center; margin-bottom: 24px; width: 100%; overflow: visible;">

            <div class="confetti-1" style="font-size: 36px; z-index: 1;">🎊</div>
            <div class="confetti-2" style="font-size: 36px; z-index: 1;">✨</div>
            <div class="confetti-3" style="font-size: 36px; z-index: 1;">🎉</div>
            <div class="anim-grad" style="font-size: 84px; z-index: 3;">🎓</div>
          </div>
          <h2 style="font-size: 42px; font-weight: 900; margin-bottom: 12px; letter-spacing: -0.02em; background: linear-gradient(135deg, #166534, #15803d); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Selamat!</h2>
          <p style="font-size: 20px; margin-bottom: 8px; color: #166534; font-weight: 500;">Anda dinyatakan <strong style="font-size: 22px; color: #15803d; background: rgba(22, 163, 74, 0.1); padding: 4px 12px; border-radius: 8px;">LULUS</strong> dari <?= e($skl['nama_sekolah'] ?? 'Sekolah') ?>.</p>
          <p style="font-size: 16px; opacity: 0.7; max-width: 500px; margin: 0 auto;">Teruslah melangkah ke jenjang berikutnya dengan penuh semangat dan ukir prestasi yang lebih tinggi.</p>
          
          <div style="margin-top: 40px; display: flex; justify-content: center;">
            <a href="<?= url('/siswa/cetak-skl') ?>" style="background: linear-gradient(135deg, #16a34a, #15803d); color: white; padding: 18px 40px; border-radius: 100px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 12px; font-size: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 10px 25px rgba(22, 163, 74, 0.3), inset 0 2px 4px rgba(255,255,255,0.2);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 35px rgba(22, 163, 74, 0.4), inset 0 2px 4px rgba(255,255,255,0.2)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px rgba(22, 163, 74, 0.3), inset 0 2px 4px rgba(255,255,255,0.2)';">
              <i class='bx bx-printer' style="font-size: 20px;"></i> Unduh SKL
            </a>
          </div>
        </div>

      <?php elseif ($siswa['status'] === 'tidak_lulus'): ?>
        <div style="text-align: center; padding: 60px 30px; border-radius: 32px; background: linear-gradient(145deg, #ffffff, #fef2f2); border: 1px solid rgba(220, 38, 38, 0.2); box-shadow: 0 20px 40px rgba(220, 38, 38, 0.08), inset 0 2px 10px rgba(255, 255, 255, 0.8); color: #991b1b; position: relative; overflow: hidden;">
          <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 200px; height: 200px; background: radial-gradient(circle, rgba(239, 68, 68, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
          
          <div style="font-size: 84px; margin-bottom: 24px; color: #b91c1c; filter: drop-shadow(0 8px 16px rgba(185, 28, 28, 0.2));">
            <i class='bx bx-info-circle anim-tidak-lulus'></i>
          </div>
          <h2 style="font-size: 42px; font-weight: 900; margin-bottom: 12px; letter-spacing: -0.02em; background: linear-gradient(135deg, #991b1b, #b91c1c); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Mohon Maaf</h2>
          <p style="font-size: 20px; margin-bottom: 8px; font-weight: 500;">Anda dinyatakan <strong style="font-size: 22px; color: #b91c1c; background: rgba(220, 38, 38, 0.1); padding: 4px 12px; border-radius: 8px;">TIDAK LULUS</strong> dari <?= e($skl['nama_sekolah'] ?? 'Sekolah') ?>.</p>
          <p style="font-size: 16px; opacity: 0.7; max-width: 500px; margin: 0 auto;">Jangan menyerah, tetap semangat dan jadikan ini sebagai awal baru untuk mencoba kembali dengan lebih baik.</p>
        </div>

      <?php else: ?>
        <div style="text-align: center; padding: 60px 30px; border-radius: 32px; background: linear-gradient(145deg, #ffffff, #fffbeb); border: 1px solid rgba(217, 119, 6, 0.2); box-shadow: 0 20px 40px rgba(217, 119, 6, 0.08), inset 0 2px 10px rgba(255, 255, 255, 0.8); color: #92400e; position: relative; overflow: hidden;">
          <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 200px; height: 200px; background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
          
          <div style="font-size: 84px; margin-bottom: 24px; color: #b45309; filter: drop-shadow(0 8px 16px rgba(180, 83, 9, 0.2));">
            <i class='bx bx-time-five anim-belum'></i>
          </div>
          <h2 style="font-size: 42px; font-weight: 900; margin-bottom: 12px; letter-spacing: -0.02em; background: linear-gradient(135deg, #92400e, #b45309); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Pengumuman Belum Tersedia</h2>
          <p style="font-size: 20px; margin-bottom: 8px; font-weight: 500;">Status kelulusan belum ditentukan.</p>
          <p style="font-size: 16px; opacity: 0.7; max-width: 500px; margin: 0 auto;">Hubungi tata usaha sekolah untuk informasi lebih lanjut.</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Tabel Nilai Siswa -->
    <?php if (!empty($nilai)): ?>
    <div style="margin-bottom: 32px;">
      <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
        <i class='bx bx-book-open' style="color: #4f46e5; font-size: 20px;"></i>
        Rekap Nilai Mata Pelajaran
      </h3>
      <div style="border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
          <thead>
            <tr style="background: #f8fafc;">
              <th style="padding: 14px 20px; text-align: left; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">No</th>
              <th style="padding: 14px 20px; text-align: left; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">Mata Pelajaran</th>
              <th style="padding: 14px 20px; text-align: center; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">KKM</th>
              <th style="padding: 14px 20px; text-align: center; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">Nilai</th>
              <th style="padding: 14px 20px; text-align: center; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;">Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($nilai as $n): ?>
              <?php $lulus = (float)$n['nilai'] >= (float)$n['kkm']; ?>
              <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                <td style="padding: 14px 20px; color: #94a3b8; font-weight: 600;"><?= $no++ ?></td>
                <td style="padding: 14px 20px; font-weight: 600; color: #1e293b;"><?= e($n['mapel_nama']) ?></td>
                <td style="padding: 14px 20px; text-align: center; color: #64748b; font-weight: 500;"><?= e(format_nilai($n['kkm'])) ?></td>
                <td style="padding: 14px 20px; text-align: center;">
                  <span style="font-size: 16px; font-weight: 800; color: <?= $lulus ? '#16a34a' : '#dc2626' ?>;">
                    <?= e(format_nilai($n['nilai'])) ?>
                  </span>
                </td>
                <td style="padding: 14px 20px; text-align: center;">
                  <?php if ($lulus): ?>
                    <span style="background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">✓ Tuntas</span>
                  <?php else: ?>
                    <span style="background: #fee2e2; color: #b91c1c; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">✗ Belum Tuntas</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <!-- Ringkasan -->
          <?php
            $totalNilai = array_sum(array_column($nilai, 'nilai'));
            $rataRata   = count($nilai) > 0 ? round($totalNilai / count($nilai), 2) : 0;
            $jumlahLulus = count(array_filter($nilai, fn($n) => (float)$n['nilai'] >= (float)$n['kkm']));
          ?>
          <tfoot>
            <tr style="background: #f8fafc; border-top: 2px solid #e2e8f0;">
              <td colspan="3" style="padding: 14px 20px; font-weight: 700; color: #475569; font-size: 13px;">
                Rata-rata Nilai &nbsp;|&nbsp; Tuntas: <span style="color: #16a34a;"><?= $jumlahLulus ?></span> / <?= count($nilai) ?> mapel
              </td>
              <td style="padding: 14px 20px; text-align: center;">
                <span style="font-size: 18px; font-weight: 900; color: <?= $rataRata >= 70 ? '#16a34a' : '#dc2626' ?>;">
                  <?= e(format_nilai($rataRata)) ?>
                </span>
              </td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <?php elseif ($isOpen): ?>
    <div style="text-align: center; padding: 32px; background: #f8fafc; border-radius: 16px; border: 1px dashed #cbd5e1; margin-bottom: 32px;">
      <i class='bx bx-book-open' style="font-size: 48px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
      <p style="color: #64748b; font-weight: 500;">Belum ada data nilai.</p>
      <p style="color: #94a3b8; font-size: 13px;">Hubungi tata usaha sekolah jika nilai Anda belum tersedia.</p>
    </div>
    <?php endif; ?>

  <?php endif; ?>

  <!-- Tombol Keluar -->
  <div style="text-align: center; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e2e8f0;">
    <form action="<?= url('/logout') ?>" method="POST" style="display: inline-block;">
      <?= csrf_field() ?>
      <button type="submit" style="background: white; color: #dc2626; border: 2px solid #fee2e2; padding: 12px 32px; border-radius: 14px; font-size: 15px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 6px rgba(220,38,38,0.1); transition: all 0.2s;">
        <i class='bx bx-log-out-circle' style="font-size: 20px;"></i> Keluar
      </button>
    </form>
  </div>
</div>
