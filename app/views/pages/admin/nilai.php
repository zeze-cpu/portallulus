<div class="table-container" style="background: #fff; border-radius: 0; border: none; height: 100vh; display: flex; flex-direction: column; overflow: hidden; margin: -32px -36px;">
  <!-- Toolbar -->
  <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fff; flex-shrink: 0; gap: 16px; flex-wrap: wrap;">
    
    <h1 style="font-size: 20px; font-weight: 800; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
      <i class='bx bx-bar-chart-alt-2' style="color: var(--primary); font-size: 24px;"></i> Nilai Siswa
    </h1>

    <div style="display: flex; gap: 12px; flex: 1; min-width: 250px;">
      <div style="position:relative; width: 100%; max-width: 320px;">
        <i class='bx bx-search' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px;"></i>
        <input type="search" id="nilai-search" class="form-control" style="padding-left:44px; border-radius: 12px; height: 44px; font-size: 14px; background: #f8fafc; border: 1px solid transparent; transition: all 0.3s ease; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);"
          placeholder="Ketik nama atau NISN siswa..." value="<?= e($search) ?>"
          autocomplete="off" spellcheck="false"
          onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'"
          onblur="this.style.background='#f8fafc'; this.style.borderColor='transparent'; this.style.boxShadow='inset 0 2px 4px rgba(0,0,0,0.02)'">
      </div>
      
      <form action="<?= url('/admin/nilai') ?>" method="GET" style="margin: 0; position:relative;">
        <select name="kelas" onchange="this.form.submit()" class="form-control" style="border-radius: 12px; height: 44px; font-size: 14px; background: #f8fafc; border: 1px solid #e2e8f0; padding-right: 36px; padding-left: 16px; cursor: pointer; color: #475569; font-weight: 500; appearance: none; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02); transition: all 0.3s ease;">
          <option value="">Semua Kelas</option>
          <?php foreach ($kelas as $k): ?>
            <option value="<?= $k['id'] ?>" <?= isset($kelas_id) && $k['id'] == $kelas_id ? 'selected' : '' ?>><?= e($k['nama']) ?></option>
          <?php endforeach; ?>
        </select>
        <i class='bx bx-chevron-down' style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; font-size: 20px;"></i>
      </form>
    </div>

    <div style="display: flex; gap: 12px; flex-shrink: 0; align-items: center; flex-wrap: wrap;">
      <button type="button" id="nilai-search-reset" onclick="window.location.href='<?= url('/admin/nilai') ?>'" class="btn btn-secondary" style="<?= (isset($kelas_id) && $kelas_id > 0) ? 'display:inline-flex;' : 'display:none;' ?> height: 44px; font-size: 13.5px; border-radius: 12px; align-items: center;">
         <i class='bx bx-reset'></i> Reset
      </button>
      <div style="width: 1px; height: 24px; background: #e2e8f0; margin: 0 4px;"></div>
      <button onclick="toggleModal('modal-import')" class="btn btn-secondary" style="height: 44px; font-size: 13.5px; border-radius: 12px; background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <i class='bx bx-upload'></i> Impor Data
      </button>
      <button onclick="toggleModal('modal-add')" class="btn btn-primary" style="height: 44px; font-size: 13.5px; border-radius: 12px; box-shadow: 0 4px 12px rgba(79,70,229,0.25); background: linear-gradient(135deg, var(--primary), #6366f1); border: none; color: #fff; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(79,70,229,0.25)'; this.style.transform='translateY(0)';">
        <i class='bx bx-edit-alt' style="font-size: 16px;"></i> Input Nilai
      </button>
    </div>
  </div>
  <div style="flex: 1; overflow-y: auto; overflow-x: auto; background: #fff;">
    <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
      <thead style="position: sticky; top: 0; z-index: 10;">
        <tr>
          <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; width: 50px; text-align: center;">No</th>
          <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">Siswa</th>
          <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align:center;">Mata Pelajaran</th>
          <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align:center;">Status Kelulusan</th>
          <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align:right;">Aksi</th>
        </tr>
      </thead>
    <tbody>
      <?php 
      $grouped = [];
      foreach ($nilai as $item) {
        $sid = $item['siswa_id'];
        if (!isset($grouped[$sid])) {
           $grouped[$sid] = [
             'siswa_id' => $sid,
             'siswa_nama' => $item['siswa_nama'],
             'nisn' => $item['nisn'],
             'kelas_nama' => $item['kelas_nama'],
             'semua_lulus' => true,
             'grades' => []
           ];
        }
        $lulus = (float)$item['nilai'] >= (float)($item['kkm'] ?? 60);
        if (!$lulus) $grouped[$sid]['semua_lulus'] = false;
        $item['lulus'] = $lulus;
        $grouped[$sid]['grades'][] = $item;
      }
      ?>
      <?php $no = 1; foreach ($grouped as $sid => $group): ?>
        <tr class="nilai-row" data-nama="<?= e(strtolower($group['siswa_nama'] ?? '')) ?>" data-nisn="<?= e(strtolower($group['nisn'] ?? '')) ?>" data-sid="<?= $sid ?>" style="cursor: pointer; transition: all 0.2s ease;" onclick="window.location.href='<?= url('/admin/nilai/' . $sid) ?>'" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
          <td style="padding: 12px 20px; text-align: center; color: #64748b; font-weight: 600; font-size: 13px;">
            <?= $no++ ?>
          </td>
          <td style="padding: 12px 20px;">
            <div style="display:flex; align-items:center; gap:12px;">
              <div>
                <div style="font-weight:700; color:#1e293b; font-size:13.5px;"><?= e($group['siswa_nama'] ?: 'Tanpa Nama') ?></div>
                <div style="font-size:12px; color:#64748b; margin-top:2px;">
                  NISN: <?= e($group['nisn'] ?: '—') ?>
                  <?php if ($group['kelas_nama']): ?>
                    &nbsp;·&nbsp; <span class="badge badge-info" style="font-size:10px; padding: 2px 6px; border-radius: 4px; letter-spacing: 0; gap:0; display:inline;"><?= e($group['kelas_nama']) ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </td>
          <td style="text-align:center; padding: 12px 20px;">
            <span class="badge badge-gray" style="font-size:11px;"><?= count($group['grades']) ?> Mapel Diinput</span>
          </td>
          <td style="text-align:center; padding: 12px 20px;">
            <?php if ($group['semua_lulus']): ?>
              <span class="badge badge-success"><i class='bx bx-check'></i> Lulus Semua</span>
            <?php else: ?>
              <span class="badge badge-danger"><i class='bx bx-x'></i> Ada Remedial</span>
            <?php endif; ?>
          </td>
          <td style="text-align:right; padding: 12px 20px;" onclick="event.stopPropagation();">
            <a href="<?= url('/admin/nilai/' . $sid) ?>" title="Buka Detail"
               style="background: rgba(99, 102, 241, 0.1); color: #4f46e5; border: none; width: 34px; height: 34px; border-radius: 10px; display: inline-flex; justify-content: center; align-items: center; text-decoration: none; transition: all 0.2s ease;"
               onmouseover="this.style.background='rgba(99, 102, 241, 0.2)'; this.style.transform='scale(1.05)';"
               onmouseout="this.style.background='rgba(99, 102, 241, 0.1)'; this.style.transform='scale(1)';">
              <i class='bx bx-chevron-right' style="font-size: 20px;"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
      <tr id="nilai-no-match" style="display:none;">
        <td colspan="4">
          <div class="empty-state">
            <i class='bx bx-search-alt'></i>
            <p>Tidak ada data siswa yang cocok.</p>
            <small>Coba ketik huruf atau angka awal nama / NISN.</small>
          </div>
        </td>
      </tr>
      <?php if (empty($grouped)): ?>
        <tr id="nilai-empty-db">
          <td colspan="4">
            <div class="empty-state">
              <i class='bx bxs-bar-chart-alt-2'></i>
              <p>Belum ada data nilai yang diinput.</p>
              <small>Klik "Input Nilai" untuk menambahkan nilai siswa.</small>
            </div>
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  </div>
</div>

<!-- Modal Input Nilai -->
<div id="modal-add" class="modal">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h2 class="modal-title" style="display: flex; align-items: center; gap: 8px;"><i class='bx bx-edit-alt' style="color: var(--primary);"></i> Input Nilai Siswa</h2>
      <button type="button" onclick="toggleModal('modal-add')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/nilai') ?>" method="POST">
      <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 20px;">
        <?= csrf_field() ?>
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Pilih Siswa <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-user' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
            <select name="siswa_id" class="form-control" required style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              <option value="">— Pilih Siswa —</option>
              <?php foreach ($siswa as $s): ?>
                <option value="<?= e($s['id']) ?>"><?= e($s['nama'] ?: 'Tanpa Nama') ?> (<?= e($s['nisn'] ?: '—') ?>)</option>
              <?php endforeach; ?>
            </select>
            <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
          </div>
        </div>
        
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Mata Pelajaran <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-book-open' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
            <select name="mapel_id" class="form-control" required style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              <option value="">— Pilih Mata Pelajaran —</option>
              <?php foreach ($mapel as $m): ?>
                <option value="<?= e($m['id']) ?>"><?= e($m['nama']) ?> (KKM: <?= e($m['kkm']) ?>)</option>
              <?php endforeach; ?>
            </select>
            <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
          </div>
        </div>
        
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Nilai Akhir <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-edit' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="text" name="nilai" class="form-control nilai-decimal" inputmode="decimal" placeholder="00.00" autocomplete="off" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:15px; font-family:monospace; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
          <p class="form-hint" style="margin-top:8px;"><i class='bx bx-info-circle'></i> Format otomatis 00.00 (contoh: 85 → 85.00)</p>
        </div>
      </div>
      <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:20px 24px; display:flex; justify-content:flex-end; gap:12px; background:#f8fafc; border-bottom-left-radius:16px; border-bottom-right-radius:16px;">
        <button type="button" onclick="toggleModal('modal-add')" class="btn btn-secondary" style="height:48px; border-radius:12px; font-weight:600; padding:0 24px; background:#fff; border:1px solid #e2e8f0; font-size:14.5px; color:#64748b; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">Batal</button>
        <button type="submit" class="btn btn-primary" style="height:48px; border-radius:12px; font-weight:700; padding:0 28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(79,70,229,0.3); background:linear-gradient(135deg, var(--primary), #6366f1); border:none; color:#fff; font-size:14.5px; cursor:pointer; transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
          <i class='bx bx-save' style="font-size:22px;"></i> Simpan Nilai
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Impor Nilai -->
<div id="modal-import" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title" style="display: flex; align-items: center; gap: 8px;"><i class='bx bx-upload' style="color: var(--primary);"></i> Impor Data Nilai</h2>
      <button type="button" onclick="toggleModal('modal-import')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/import/nilai') ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 20px;">
        <?= csrf_field() ?>
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Pilih File Excel atau CSV <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <input type="file" name="file" class="form-control" accept=".csv,.xlsx,.xls" required style="width:100%; padding:10px 16px; border-radius:12px; font-weight:600; font-size:14px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
        </div>
        <div style="background:#f8fafc; padding:16px 20px; border-radius:12px; border:1px dashed #cbd5e1;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <p style="font-size:12.5px; font-weight:700; color:#334155; margin:0;">Format Kolom (Berdasarkan Template):</p>
            <a href="<?= url('/admin/import/nilai/template') ?>"
              style="font-size:12.5px; color:#4f46e5; text-decoration:none; font-weight:700; display:flex; align-items:center; gap:4px; padding:4px 10px; background:rgba(79,70,229,0.1); border-radius:8px; transition:all 0.2s;" onmouseover="this.style.background='rgba(79,70,229,0.2)'" onmouseout="this.style.background='rgba(79,70,229,0.1)'">
              <i class='bx bx-download'></i> Unduh Daftar Siswa
            </a>
          </div>
          <p style="font-size:12px; color:#64748b; font-family:monospace; background:#fff; padding:8px 12px; border-radius:6px; border:1px solid #e2e8f0; margin-top:8px;">NISN, Nama Siswa, Nama Mata Pelajaran, Nilai</p>
          <p style="font-size:11px; color:#64748b; margin-top:10px;"><i class='bx bx-error-circle' style="color:#f59e0b; vertical-align:middle; font-size:14px;"></i> Sangat disarankan menggunakan file template yang diunduh agar <b>NISN tidak salah ketik</b>.</p>
        </div>
      </div>
      <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:20px 24px; display:flex; justify-content:flex-end; gap:12px; background:#f8fafc; border-bottom-left-radius:16px; border-bottom-right-radius:16px;">
        <button type="button" onclick="toggleModal('modal-import')" class="btn btn-secondary" style="height:48px; border-radius:12px; font-weight:600; padding:0 24px; background:#fff; border:1px solid #e2e8f0; font-size:14.5px; color:#64748b; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">Batal</button>
        <button type="submit" class="btn btn-primary" style="height:48px; border-radius:12px; font-weight:700; padding:0 28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(79,70,229,0.3); background:linear-gradient(135deg, var(--primary), #6366f1); border:none; color:#fff; font-size:14.5px; cursor:pointer; transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
          <i class='bx bx-upload' style="font-size:22px;"></i> Upload & Impor
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleModal(id) {
    document.getElementById(id).classList.toggle('active');
  }

  (function () {
    const input = document.getElementById('nilai-search');
    const resetBtn = document.getElementById('nilai-search-reset');
    const rows = document.querySelectorAll('tr.nilai-row');
    const noMatch = document.getElementById('nilai-no-match');

    if (!input || !rows.length) return;

    function filterRows() {
      const q = input.value.trim().toLowerCase();
      let visible = 0;

      rows.forEach(function (row) {
        const nama = row.dataset.nama || '';
        const nisn = row.dataset.nisn || '';
        const match = !q || nama.startsWith(q) || nisn.startsWith(q);
        row.style.display = match ? '' : 'none';
        
        if (match) visible++;
      });

      if (noMatch) {
        noMatch.style.display = q && visible === 0 ? '' : 'none';
      }
      if (resetBtn) {
        resetBtn.style.display = q ? '' : 'none';
      }
    }

    input.addEventListener('input', filterRows);

    if (resetBtn) {
      resetBtn.addEventListener('click', function () {
        input.value = '';
        input.focus();
        filterRows();
      });
    }

    filterRows();
  })();

  function formatNilaiDecimal(el) {
    if (!el) return;
    var raw = String(el.value).replace(/[^\d.,]/g, '').replace(',', '.');
    if (raw === '' || raw === '.') {
      el.value = '';
      return;
    }
    var v = parseFloat(raw);
    if (isNaN(v)) {
      el.value = '';
      return;
    }
    v = Math.min(100, Math.max(0, v));
    el.value = v.toFixed(2);
  }

  document.querySelectorAll('.nilai-decimal').forEach(function (el) {
    el.addEventListener('blur', function () { formatNilaiDecimal(el); });
    el.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        formatNilaiDecimal(el);
      }
    });
  });

  var formNilai = document.querySelector('#modal-add form');
  if (formNilai) {
    formNilai.addEventListener('submit', function () {
      var nilaiInput = formNilai.querySelector('[name=nilai]');
      formatNilaiDecimal(nilaiInput);
    });
  }
</script>