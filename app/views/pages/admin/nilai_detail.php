<div style="background: #fff; border-radius: 0; border: none; overflow: hidden; display: flex; flex-direction: column; height: 100vh; margin: -24px;">
  
  <!-- Profile & Header Section -->
  <div style="padding: 20px 32px; border-bottom: 1px solid rgba(226, 232, 240, 0.8); display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%); flex-shrink: 0; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 20px;">
      <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 22px; flex-shrink: 0; box-shadow: 0 8px 16px rgba(79,70,229,0.25);">
        <?= substr($siswa['nama'] ?: 'U', 0, 1) ?>
      </div>
      <div>
        <h2 style="margin: 0; font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;"><?= e($siswa['nama']) ?></h2>
        <div style="font-size: 13.5px; color: #64748b; margin-top: 4px; font-weight: 500;">
          <span style="color:#94a3b8;">NISN:</span> <?= e($siswa['nisn'] ?: '—') ?>
          <?php if ($siswa['kelas_nama']): ?>
            <span style="margin: 0 8px; color: #cbd5e1;">|</span>
            <span class="badge" style="font-size: 11px; padding: 3px 8px; background: rgba(79,70,229,0.1); color: #4f46e5; border: none; font-weight: 700;"><?= e($siswa['kelas_nama']) ?> Kelas</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <div style="display: flex; gap: 12px; align-items: center;">
      <a href="<?= url('/admin/nilai') ?>" class="btn btn-secondary" style="height: 44px; font-size: 13.5px; border-radius: 12px; display: inline-flex; align-items: center; gap: 6px; background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); font-weight: 600; color: #64748b; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'; this.style.color='#1e293b';" onmouseout="this.style.background='white'; this.style.color='#64748b';">
        <i class='bx bx-arrow-back'></i> Kembali
      </a>
      <button onclick="toggleModal('modal-add')" class="btn btn-primary" style="height: 44px; font-size: 13.5px; border-radius: 12px; box-shadow: 0 4px 12px rgba(79,70,229,0.25); background: linear-gradient(135deg, var(--primary), #6366f1); border: none; color: #fff; transition: all 0.3s ease; font-weight: 600;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(79,70,229,0.25)'; this.style.transform='translateY(0)';">
        <i class='bx bx-edit-alt' style="font-size: 16px;"></i> Input Nilai Baru
      </button>
    </div>
  </div>

  <!-- Table Section -->
  <div style="flex: 1; overflow-x: auto; overflow-y: auto; background: #fff;">
    <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
        <thead style="position: sticky; top: 0; z-index: 10;">
          <tr>
            <th style="background: rgba(248,250,252,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 32px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; width:40%;">Mata Pelajaran</th>
            <th style="background: rgba(248,250,252,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 32px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; text-align:center;">Nilai Angka</th>
            <th style="background: rgba(248,250,252,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 32px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">Status</th>
            <th style="background: rgba(248,250,252,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 32px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; text-align:right;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($nilai as $item): ?>
            <?php $lulus = (float)$item['nilai'] >= (float)($item['kkm'] ?? 60); ?>
            <tr style="transition: all 0.2s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
              <td style="padding: 12px 32px; border-bottom:1px solid #f1f5f9;">
                <div style="font-weight:700; color:#1e293b; font-size:13.5px;"><?= e($item['mapel_nama']) ?></div>
                <div style="font-size:11.5px; color:#94a3b8; margin-top:2px; font-weight:500;">KKM: <?= e(format_nilai($item['kkm'] ?? 0)) ?></div>
              </td>
              <td style="text-align:center; padding: 12px 32px; border-bottom:1px solid #f1f5f9;">
                <span style="font-size:16px; font-weight:900; font-variant-numeric:tabular-nums; color:<?= $lulus ? '#16a34a' : '#ef4444' ?>;">
                  <?= e(format_nilai($item['nilai'] ?? 0)) ?>
                </span>
              </td>
              <td style="padding: 12px 32px; border-bottom:1px solid #f1f5f9;">
                <?php if ($lulus): ?>
                  <span class="badge" style="background: rgba(22, 163, 74, 0.1); color: #16a34a; font-size: 10px; border: none; font-weight: 700;"><i class='bx bx-check'></i> Tuntas</span>
                <?php else: ?>
                  <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 10px; border: none; font-weight: 700;"><i class='bx bx-x'></i> Remedial</span>
                <?php endif; ?>
              </td>
              <td style="text-align:right; padding: 12px 32px; border-bottom:1px solid #f1f5f9;">
                <button onclick="openEditModal(<?= $item['mapel_id'] ?>, '<?= e(addslashes($item['mapel_nama'])) ?>', <?= $item['nilai'] ?>)" class="btn-icon text-info" title="Edit nilai ini" style="margin-right: 4px; background: rgba(56, 189, 248, 0.1);">
                  <i class='bx bx-edit' style="color: #0ea5e9;"></i>
                </button>
                <form action="<?= url('/admin/nilai/' . $item['id'] . '/delete') ?>" method="POST" style="display:inline;"
                  onsubmit="confirmAction(event, 'Hapus nilai <?= e(addslashes($item['mapel_nama'])) ?> untuk siswa ini?')">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn-icon text-danger" title="Hapus nilai ini" style="background: rgba(239, 68, 68, 0.1);">
                    <i class='bx bx-trash' style="color: #ef4444;"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($nilai)): ?>
            <tr>
              <td colspan="4">
                <div class="empty-state" style="padding: 40px 20px;">
                  <i class='bx bx-list-minus' style="font-size: 48px; color: #cbd5e1; margin-bottom: 12px;"></i>
                  <p style="font-weight: 600; color: #475569; margin:0;">Belum ada nilai yang diinput</p>
                  <small style="color: #94a3b8; display:block; margin-top:4px;">Silakan klik tombol "Input Nilai" di atas.</small>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
</div>

<!-- Modal Input Nilai Khusus Siswa Ini -->
<div id="modal-add" class="modal">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h2 class="modal-title" style="display: flex; align-items: center; gap: 8px;"><i class='bx bx-edit-alt' style="color: var(--primary);"></i> Input Nilai: <?= e($siswa['nama']) ?></h2>
      <button type="button" onclick="toggleModal('modal-add')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/nilai') ?>" method="POST">
      <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 20px;">
        <?= csrf_field() ?>
        <input type="hidden" name="siswa_id" value="<?= $siswa['id'] ?>">
        
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

<!-- Modal Edit Nilai -->
<div id="modal-edit" class="modal">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h2 class="modal-title" id="edit-modal-title" style="display: flex; align-items: center; gap: 8px;"><i class='bx bx-edit' style="color: var(--info);"></i> Edit Nilai</h2>
      <button type="button" onclick="toggleModal('modal-edit')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/nilai') ?>" method="POST">
      <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 20px;">
        <?= csrf_field() ?>
        <input type="hidden" name="is_edit" value="1">
        <input type="hidden" name="siswa_id" value="<?= $siswa['id'] ?>">
        <input type="hidden" name="mapel_id" id="edit-mapel-id" value="">
        
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Mata Pelajaran</label>
          <div style="position:relative;">
            <i class='bx bx-book-open' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="text" id="edit-mapel-nama" class="form-control" readonly style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f1f5f9; border:1px solid #cbd5e1; color:#64748b; cursor:not-allowed;">
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Nilai Akhir Baru <span style="color:var(--danger)">*</span></label>
          <div style="position:relative;">
            <i class='bx bx-edit' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
            <input type="text" name="nilai" id="edit-nilai-input" class="form-control nilai-decimal" inputmode="decimal" placeholder="00.00" autocomplete="off" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:15px; font-family:monospace; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          </div>
          <p class="form-hint" style="margin-top:8px;"><i class='bx bx-info-circle'></i> Format otomatis 00.00 (contoh: 85 → 85.00)</p>
        </div>
      </div>
      <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:20px 24px; display:flex; justify-content:flex-end; gap:12px; background:#f8fafc; border-bottom-left-radius:16px; border-bottom-right-radius:16px;">
        <button type="button" onclick="toggleModal('modal-edit')" class="btn btn-secondary" style="height:48px; border-radius:12px; font-weight:600; padding:0 24px; background:#fff; border:1px solid #e2e8f0; font-size:14.5px; color:#64748b; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">Batal</button>
        <button type="submit" class="btn btn-primary" style="height:48px; border-radius:12px; font-weight:700; padding:0 28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(79,70,229,0.3); background:linear-gradient(135deg, var(--primary), #6366f1); border:none; color:#fff; font-size:14.5px; cursor:pointer; transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
          <i class='bx bx-save' style="font-size:22px;"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleModal(id) {
    document.getElementById(id).classList.toggle('active');
  }

  function openEditModal(mapelId, mapelNama, nilai) {
    document.getElementById('edit-mapel-id').value = mapelId;
    document.getElementById('edit-mapel-nama').value = mapelNama;
    document.getElementById('edit-nilai-input').value = parseFloat(nilai).toFixed(2);
    document.getElementById('edit-modal-title').innerText = "Edit Nilai: " + mapelNama;
    toggleModal('modal-edit');
  }

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

  var formNilaiAdd = document.querySelector('#modal-add form');
  if (formNilaiAdd) {
    formNilaiAdd.addEventListener('submit', function () {
      formatNilaiDecimal(formNilaiAdd.querySelector('[name=nilai]'));
    });
  }

  var formNilaiEdit = document.querySelector('#modal-edit form');
  if (formNilaiEdit) {
    formNilaiEdit.addEventListener('submit', function () {
      formatNilaiDecimal(formNilaiEdit.querySelector('[name=nilai]'));
    });
  }
</script>
