<div class="table-container" style="background: #fff; border-radius: 0; border: none; height: 100vh; display: flex; flex-direction: column; overflow: hidden; margin: -32px -36px;">
  <!-- Toolbar -->
  <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fff; flex-shrink: 0; gap: 16px; flex-wrap: wrap;">
    
    <h1 style="font-size: 20px; font-weight: 800; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
      <i class='bx bxs-group' style="color: var(--primary); font-size: 24px;"></i> Data Siswa
    </h1>

    <div style="display: flex; gap: 12px; flex: 1; min-width: 250px;">
      <div style="position:relative; width: 100%; max-width: 320px;">
        <i class='bx bx-search' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px;"></i>
        <input type="search" id="siswa-search" class="form-control" style="padding-left:44px; border-radius: 12px; height: 44px; font-size: 14px; background: #f8fafc; border: 1px solid transparent; transition: all 0.3s ease; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);"
          placeholder="Cari nama atau NISN siswa..." value="<?= e($search) ?>"
          autocomplete="off" spellcheck="false"
          onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'"
          onblur="this.style.background='#f8fafc'; this.style.borderColor='transparent'; this.style.boxShadow='inset 0 2px 4px rgba(0,0,0,0.02)'">
      </div>
      
      <form action="<?= url('/admin/siswa') ?>" method="GET" style="margin: 0; position:relative;">
        <?php if ($status): ?><input type="hidden" name="status" value="<?= e($status) ?>"><?php endif; ?>
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
      <button type="button" id="siswa-search-reset" onclick="window.location.href='<?= url('/admin/siswa') ?>'" class="btn btn-secondary" style="<?= (isset($kelas_id) && $kelas_id > 0) || $status ? 'display:inline-flex;' : 'display:none;' ?> height: 44px; font-size: 13.5px; border-radius: 12px; align-items: center;">
         <i class='bx bx-reset'></i> Reset
      </button>
      <?php if ($status): ?>
        <a href="<?= url('/admin/siswa' . (isset($kelas_id) && $kelas_id > 0 ? '?kelas='.$kelas_id : '')) ?>" class="btn btn-secondary" style="height: 44px; font-size: 13.5px; border-radius: 12px; display: inline-flex; align-items: center;">Semua Status</a>
      <?php endif; ?>
      <div style="width: 1px; height: 24px; background: #e2e8f0; margin: 0 4px;"></div>
      <button onclick="toggleModal('modal-import')" class="btn btn-secondary" style="height: 44px; font-size: 13.5px; border-radius: 12px; background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <i class='bx bx-upload'></i> Impor Data
      </button>
      <button onclick="toggleModal('modal-add')" class="btn btn-primary" style="height: 44px; font-size: 13.5px; border-radius: 12px; box-shadow: 0 4px 12px rgba(79,70,229,0.25);">
        <i class='bx bx-user-plus'></i> Tambah Siswa
      </button>
    </div>
  </div>
  <div style="flex: 1; overflow-y: auto; overflow-x: auto; background: #fff;">
    <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
      <thead style="position: sticky; top: 0; z-index: 10;">
        <tr>
          <th style="background: rgba(248,250,252,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 20px; width:50px; font-size: 11px;">No</th>
          <th style="background: rgba(248,250,252,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 20px; font-size: 11px;">NISN</th>
          <th style="background: rgba(248,250,252,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 20px; font-size: 11px;">Nama Lengkap</th>
          <th style="background: rgba(248,250,252,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 20px; font-size: 11px; width:60px; text-align:center;">L/P</th>
          <th style="background: rgba(248,250,252,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 20px; font-size: 11px;">Kelas</th>
          <th style="background: rgba(248,250,252,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 20px; font-size: 11px;">Status Kelulusan</th>
          <th style="background: rgba(248,250,252,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 12px 20px; font-size: 11px; text-align:right;">Aksi</th>
        </tr>
      </thead>
    <tbody>
      <?php $i = 1; foreach ($siswa as $item): ?>
        <tr class="siswa-row" data-nama="<?= e(strtolower($item['nama'] ?? '')) ?>" data-nisn="<?= e(strtolower($item['nisn'] ?? '')) ?>" style="transition: all 0.2s ease;">
          <td style="color:var(--text-light); font-weight:600; padding: 12px 20px; font-size: 13px;"><?= $i++ ?></td>
          <td style="font-family:monospace; font-size:13px; color:#64748b; font-weight:600; padding: 12px 20px;">
            <?= e($item['nisn'] ?: '—') ?>
          </td>
          <td style="padding: 12px 20px;">
            <div style="font-weight:700; color:#1e293b; font-size:13.5px;"><?= e($item['nama'] ?: 'Tanpa Nama') ?></div>
          </td>
          <td style="text-align:center; font-weight:700; padding: 12px 20px; font-size: 13px; color: <?= ($item['jenis_kelamin'] ?? 'L') === 'L' ? '#3b82f6' : '#ec4899' ?>;">
            <?= e($item['jenis_kelamin'] ?? 'L') ?>
          </td>
          <td style="padding: 12px 20px;">
            <?php if ($item['kelas_nama']): ?>
              <span class="badge badge-info"><?= e($item['kelas_nama']) ?></span>
            <?php else: ?>
              <span style="color:var(--text-light); font-size:12px;">— Belum ditentukan</span>
            <?php endif; ?>
          </td>
          <td style="padding: 12px 20px;">
            <?php if ($item['status'] === 'lulus'): ?>
              <span class="badge badge-success"><i class='bx bx-check'></i> Lulus</span>
            <?php elseif ($item['status'] === 'tidak_lulus'): ?>
              <span class="badge badge-danger"><i class='bx bx-x'></i> Tidak Lulus</span>
            <?php else: ?>
              <span class="badge badge-gray"><i class='bx bx-time'></i> Belum Diproses</span>
            <?php endif; ?>
          </td>
          <td style="text-align:right; white-space:nowrap; padding: 12px 20px;">
            <div style="display:flex; justify-content:flex-end; gap:8px;">
              <button type="button" title="Edit data siswa" 
                style="background: rgba(99, 102, 241, 0.1); color: #4f46e5; border: none; width: 34px; height: 34px; border-radius: 10px; display: inline-flex; justify-content: center; align-items: center; cursor: pointer; transition: all 0.2s ease;"
                onmouseover="this.style.background='rgba(99, 102, 241, 0.2)'; this.style.transform='scale(1.05)';"
                onmouseout="this.style.background='rgba(99, 102, 241, 0.1)'; this.style.transform='scale(1)';"
                onclick="openEditModal({
                  id: <?= $item['id'] ?>,
                  nisn: <?= htmlspecialchars(json_encode($item['nisn'] ?? '')) ?>,
                  nama: <?= htmlspecialchars(json_encode($item['nama'] ?? '')) ?>,
                  kelas_id: <?= htmlspecialchars(json_encode($item['kelas_id'] ?? '')) ?>,
                  jenis_kelamin: <?= htmlspecialchars(json_encode($item['jenis_kelamin'] ?? 'L')) ?>,
                  status: <?= htmlspecialchars(json_encode($item['status'] ?? 'belum')) ?>
                })">
                <i class='bx bx-edit-alt' style="font-size: 18px;"></i>
              </button>
              <form action="<?= url('/admin/siswa/' . $item['id'] . '/delete') ?>" method="POST" style="display:inline;"
                onsubmit="confirmAction(event, 'Hapus data siswa <?= e(addslashes($item['nama'])) ?>?\\nTindakan ini tidak dapat dibatalkan.')">
                <?= csrf_field() ?>
                <button type="submit" title="Hapus siswa"
                  style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 34px; height: 34px; border-radius: 10px; display: inline-flex; justify-content: center; align-items: center; cursor: pointer; transition: all 0.2s ease;"
                  onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'; this.style.transform='scale(1.05)';"
                  onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.transform='scale(1)';"
                >
                  <i class='bx bx-trash' style="font-size: 18px;"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      <tr id="siswa-no-match" style="display:none;">
        <td colspan="7">
          <div class="empty-state">
            <i class='bx bx-search-alt'></i>
            <p>Tidak ada siswa yang cocok dengan pencarian.</p>
            <small>Coba ketik huruf atau angka awal nama / NISN.</small>
          </div>
        </td>
      </tr>
      <?php if (empty($siswa)): ?>
        <tr id="siswa-empty-db">
          <td colspan="7">
            <div class="empty-state">
              <i class='bx bxs-group'></i>
              <p>Tidak ada data siswa.</p>
              <small>Klik "Tambah Siswa" untuk menambahkan data baru.</small>
            </div>
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  </div>
</div>

<!-- Modal Tambah Siswa -->
<div id="modal-add" class="modal">
  <div class="modal-content" style="max-width:640px;">
    <div class="modal-header">
      <h2 class="modal-title">Tambah Data Siswa Baru</h2>
      <button onclick="toggleModal('modal-add')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/siswa') ?>" method="POST">
      <div class="modal-body" style="padding: 24px;">
        <?= csrf_field() ?>
        
        <div style="display:flex; flex-direction:column; gap:24px;">
          <!-- Wrapper NISN & Nama -->
          <div style="display:grid; grid-template-columns:1fr 1.5fr; gap:20px;">
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">NISN <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-id-card' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
                <input type="text" name="nisn" class="form-control" placeholder="10 digit angka" required maxlength="10" inputmode="numeric" style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-family:monospace; font-size:15px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              </div>
            </div>
            
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Nama Lengkap <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-user' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
                <input type="text" name="nama" class="form-control" placeholder="Sesuai ijazah resmi" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              </div>
            </div>
          </div>
          
          <!-- Wrapper Kelas & JK -->
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Kelas <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-building-house' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
                <select name="kelas_id" class="form-control" required style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                  <option value="">— Pilih Kelas —</option>
                  <?php foreach ($kelas as $j): ?>
                    <option value="<?= e($j['id']) ?>"><?= e($j['nama']) ?></option>
                  <?php endforeach; ?>
                </select>
                <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
              </div>
            </div>

            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Jenis Kelamin <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-male-female' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
                <select name="jenis_kelamin" class="form-control" required style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
                <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:20px 24px; display:flex; justify-content:flex-end; gap:12px; background:#f8fafc; border-bottom-left-radius:16px; border-bottom-right-radius:16px;">
        <button type="button" onclick="toggleModal('modal-add')" class="btn btn-secondary" style="height:48px; border-radius:12px; font-weight:600; padding:0 24px; background:#fff; border:1px solid #e2e8f0; font-size:14.5px; color:#64748b; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">Batal</button>
        <button type="submit" class="btn btn-primary" style="height:48px; border-radius:12px; font-weight:700; padding:0 28px; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(79,70,229,0.3); background:linear-gradient(135deg, var(--primary), #6366f1); border:none; color:#fff; font-size:14.5px; cursor:pointer; transition:all 0.3s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(79,70,229,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 14px rgba(79,70,229,0.3)'; this.style.transform='translateY(0)'">
          <i class='bx bx-check-circle' style="font-size:22px;"></i> Simpan Data Siswa
        </button>
      </div>
    </form>
  </div>
</div>

</div>

<!-- Modal Edit Siswa -->
<div id="modal-edit" class="modal">
  <div class="modal-content" style="max-width:640px;">
    <div class="modal-header">
      <h2 class="modal-title">Edit Data Siswa</h2>
      <button onclick="toggleModal('modal-edit')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form id="form-edit-siswa" action="" method="POST">
      <div class="modal-body" style="padding: 24px;">
        <?= csrf_field() ?>
        
        <div style="display:flex; flex-direction:column; gap:24px;">
          <!-- Wrapper NISN & Nama -->
          <div style="display:grid; grid-template-columns:1fr 1.5fr; gap:20px;">
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">NISN <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-id-card' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
                <input type="text" id="edit-nisn" name="nisn" class="form-control" placeholder="10 digit angka" required maxlength="10" inputmode="numeric" style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-family:monospace; font-size:15px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              </div>
            </div>
            
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Nama Lengkap <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-user' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; pointer-events:none;"></i>
                <input type="text" id="edit-nama" name="nama" class="form-control" placeholder="Sesuai ijazah resmi" required style="width:100%; padding-left:46px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; transition:all 0.3s ease; outline:none;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
              </div>
            </div>
          </div>
          
          <!-- Wrapper Kelas & JK -->
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Kelas <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-building-house' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
                <select id="edit-kelas" name="kelas_id" class="form-control" required style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                  <option value="">— Pilih Kelas —</option>
                  <?php foreach ($kelas as $j): ?>
                    <option value="<?= e($j['id']) ?>"><?= e($j['nama']) ?></option>
                  <?php endforeach; ?>
                </select>
                <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
              </div>
            </div>

            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Jenis Kelamin <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-male-female' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
                <select id="edit-jk" name="jenis_kelamin" class="form-control" required style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
                <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
              </div>
            </div>
          </div>
          
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" style="font-weight:700; color:#334155; margin-bottom:8px; display:block;">Status Kelulusan <span style="color:var(--danger)">*</span></label>
              <div style="position:relative;">
                <i class='bx bx-shield-quarter' style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:20px; z-index:2; pointer-events:none;"></i>
                <select id="edit-status" name="status" class="form-control" style="width:100%; padding-left:46px; padding-right:40px; height:48px; border-radius:12px; font-weight:600; font-size:14.5px; background:#f8fafc; border:1px solid #e2e8f0; appearance:none; cursor:pointer; position:relative; z-index:1; transition:all 0.3s ease; outline:none; color:#1e293b;" onfocus="this.style.background='#fff'; this.style.borderColor='#818cf8'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)'" onblur="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                  <option value="belum">Belum Diproses</option>
                  <option value="lulus">Lulus</option>
                  <option value="tidak_lulus">Tidak Lulus</option>
                </select>
                <i class='bx bx-chevron-down' style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:22px; z-index:2; pointer-events:none;"></i>
              </div>
              <p class="form-hint" style="margin-top:8px;"><i class='bx bx-info-circle'></i> Status ini akan diperbarui otomatis saat Anda menjalankan Proses Kelulusan.</p>
            </div>
          </div>
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

<!-- Modal Impor -->
<div id="modal-import" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Impor Data Siswa</h2>
      <button onclick="toggleModal('modal-import')" class="btn-icon"><i class='bx bx-x'></i></button>
    </div>
    <form action="<?= url('/admin/import/siswa') ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Pilih File Excel atau CSV</label>
          <input type="file" name="file" class="form-control" accept=".csv,.xlsx,.xls" required>
        </div>
        <div style="background:var(--bg-body); padding:16px; border-radius:var(--radius); border:1px solid var(--border);">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <p style="font-size:12px; font-weight:700; color:var(--text-main); margin:0;">Format Kolom yang Dibutuhkan:</p>
            <a href="<?= url('/admin/import/siswa/template') ?>"
              style="font-size:12px; color:var(--primary); text-decoration:none; font-weight:700; display:flex; align-items:center; gap:4px;">
              <i class='bx bx-download'></i> Unduh Template
            </a>
          </div>
          <p style="font-size:12px; color:var(--text-muted); font-family:monospace;">No, NISN, Nama Lengkap, L/P, Kelas, Status Kelulusan, Aksi</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="toggleModal('modal-import')" class="btn btn-secondary">Batal</button>
        <button type="submit" class="btn btn-primary"><i class='bx bx-upload'></i> Upload & Impor</button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleModal(id) {
    document.getElementById(id).classList.toggle('active');
  }

  function openEditModal(data) {
    document.getElementById('form-edit-siswa').action = `<?= url('/admin/siswa/') ?>${data.id}`;
    document.getElementById('edit-nisn').value = data.nisn;
    document.getElementById('edit-nama').value = data.nama;
    document.getElementById('edit-kelas').value = data.kelas_id;
    document.getElementById('edit-jk').value = data.jenis_kelamin;
    document.getElementById('edit-status').value = data.status || 'belum';
    toggleModal('modal-edit');
  }

  (function () {
    const input = document.getElementById('siswa-search');
    const resetBtn = document.getElementById('siswa-search-reset');
    const rows = document.querySelectorAll('tr.siswa-row');
    const noMatch = document.getElementById('siswa-no-match');

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
</script>