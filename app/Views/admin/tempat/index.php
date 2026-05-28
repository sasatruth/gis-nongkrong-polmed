<?= $this->extend('admin/layouts/admin') ?>
<?= $this->section('content') ?>
<?php $pageTitle = 'Manajemen Tempat'; ?>
<style>
.toolbar{
    display:flex;align-items:center;flex-wrap:wrap;gap:10px;
    background:#fff;border-radius:16px;
    padding:16px 20px;
    border:1px solid #e8d5c0;
    margin-bottom:18px;
    box-shadow:0 2px 10px rgba(122,78,45,.05);
}
.search-wrap{position:relative;flex:1;min-width:220px;}
.search-wrap input{
    width:100%;padding:10px 14px 10px 40px;
    border:1.5px solid #e8d5c0;border-radius:11px;
    font-family:'DM Sans',sans-serif;font-size:.85rem;color:#2B1B12;
    outline:none;transition:border-color .15s;
    background:#fdf8f3;
}
.search-wrap input:focus{border-color:#A97142;background:#fff;}
.search-wrap .si{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#ccc;font-size:.95rem;}
.filter-sel{
    padding:10px 14px;border:1.5px solid #e8d5c0;border-radius:11px;
    font-family:'DM Sans',sans-serif;font-size:.83rem;
    background:#fdf8f3;color:#2B1B12;outline:none;cursor:pointer;
}
.filter-sel:focus{border-color:#A97142;}
.btn-add{
    display:inline-flex;align-items:center;gap:7px;
    padding:10px 20px;
    background:linear-gradient(135deg,#A97142,#7A4E2D);
    color:#fff;border:none;border-radius:11px;
    font-family:'DM Sans',sans-serif;font-size:.85rem;font-weight:600;
    cursor:pointer;text-decoration:none;
    transition:all .2s;
    box-shadow:0 2px 8px rgba(122,78,45,.3);
    white-space:nowrap;
}
.btn-add:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(122,78,45,.4);color:#fff;}
/* Table */
.table-card{background:#fff;border-radius:18px;border:1px solid #e8d5c0;overflow:hidden;box-shadow:0 2px 12px rgba(122,78,45,.06);}
table{width:100%;border-collapse:collapse;}
thead th{
    background:#f8efe3;padding:13px 18px;
    font-size:.7rem;font-weight:700;color:#aaa;
    text-transform:uppercase;letter-spacing:.6px;
    text-align:left;border-bottom:1px solid #e8d5c0;white-space:nowrap;
}
tbody tr{border-bottom:1px solid #f5ede0;transition:background .12s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#fdf8f3;}
tbody td{padding:13px 18px;font-size:.84rem;color:#2B1B12;vertical-align:middle;}
.td-img{width:52px;height:52px;border-radius:10px;object-fit:cover;}
.td-nama{font-weight:600;font-size:.88rem;}
.td-sub{font-size:.7rem;color:#bbb;margin-top:2px;}
.kat-chip{display:inline-flex;align-items:center;gap:5px;background:#f8efe3;border-radius:8px;padding:3px 9px;font-size:.73rem;font-weight:600;color:#7A4E2D;}
.badge-active{background:#d4edda;color:#1a6e35;border-radius:6px;padding:3px 10px;font-size:.7rem;font-weight:700;}
.badge-nonactive{background:#fde8ea;color:#9b1a2a;border-radius:6px;padding:3px 10px;font-size:.7rem;font-weight:700;}
/* Action buttons */
.actions{display:flex;gap:6px;align-items:center;}
.btn-act{
    padding:6px 13px;border-radius:8px;font-size:.74rem;font-weight:600;
    text-decoration:none;border:none;cursor:pointer;
    transition:all .15s;display:inline-flex;align-items:center;gap:4px;
    font-family:'DM Sans',sans-serif;
}
.btn-edit{background:#f8efe3;color:#7A4E2D;}
.btn-edit:hover{background:#e0cdb8;color:#7A4E2D;}
.btn-toggle{background:#cce5ff;color:#003d82;}
.btn-toggle:hover{background:#b3d8fd;}
.btn-del{background:#fde8ea;color:#9b1a2a;}
.btn-del:hover{background:#f5c2c7;}
/* Fas mini badges */
.fas-mini{display:flex;flex-wrap:wrap;gap:3px;}
.fas-mini span{background:#f0e4d4;color:#7A4E2D;border-radius:5px;padding:1px 7px;font-size:.66rem;font-weight:600;}
/* Empty state */
.empty{text-align:center;padding:52px 20px;color:#ccc;}
.empty .ei{font-size:3rem;margin-bottom:10px;}
/* Pagination info */
.tbl-footer{
    padding:14px 20px;border-top:1px solid #f0e4d4;
    font-size:.78rem;color:#bbb;
    display:flex;align-items:center;justify-content:space-between;
}
.tbl-footer strong{color:#2B1B12;}
</style>

<div class="toolbar">
    <form method="GET" action="/admin/tempat" style="display:contents;">
        <div class="search-wrap">
            <i class="bi bi-search si"></i>
            <input type="text" name="q" value="<?= esc($search) ?>"
                   placeholder="Cari nama atau alamat tempat…">
        </div>
        <select name="kat_id" class="filter-sel" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategoriList as $k): ?>
            <option value="<?= $k['id'] ?>" <?= $activeKatId == $k['id'] ? 'selected' : '' ?>>
                <?= esc($k['icon'].' '.$k['nama']) ?>
            </option>
            <?php endforeach; ?>
        </select>
        <select name="status" class="filter-sel" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="aktif"    <?= $activeStatus === 'aktif'    ? 'selected' : '' ?>>Aktif</option>
            <option value="nonaktif" <?= $activeStatus === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
        </select>
        <?php if ($search || $activeKatId || $activeStatus): ?>
        <a href="/admin/tempat" class="btn-act btn-edit" style="white-space:nowrap;">✕ Reset</a>
        <?php endif; ?>
    </form>
    <a href="/admin/tempat/create" class="btn-add">
        <i class="bi bi-plus-lg"></i> Tambah Tempat
    </a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th style="width:60px;">Foto</th>
                <th>Nama & Alamat</th>
                <th>Kategori</th>
                <th>Rating</th>
                <th>Harga Min</th>
                <th>Fasilitas</th>
                <th>Status</th>
                <th style="width:180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tempat)): ?>
            <tr>
                <td colspan="8">
                    <div class="empty">
                        <div class="ei">🔍</div>
                        <div style="font-weight:600;color:#888;">Tidak ada tempat ditemukan</div>
                        <div style="font-size:.8rem;margin-top:4px;">
                            <?= $search ? 'Coba kata kunci lain' : 'Belum ada data tempat' ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php else: ?>
            <?php
                $bool = fn($v) => $v === true || $v === 't' || $v === '1' || $v == 1;
                foreach ($tempat as $t):
                $fas = [];
                if ($bool($t['wifi']))    $fas[] = '📶 WiFi';
                if ($bool($t['colokan'])) $fas[] = '🔌 Colokan';
                if ($bool($t['ac']))      $fas[] = '❄️ AC';
                if ($bool($t['parkir']))  $fas[] = '🅿️ Parkir';
                $aktif = $bool($t['is_active']);
            ?>
            <tr>
                <td>
                    <img class="td-img"
                         src="<?= esc($t['foto_url'] ?? 'https://placehold.co/80/A97142/fff?text=📍') ?>"
                         alt="<?= esc($t['nama']) ?>">
                </td>
                <td>
                    <div class="td-nama"><?= esc($t['nama']) ?></div>
                    <div class="td-sub"><?= esc(substr($t['alamat'] ?? '', 0, 45)) ?></div>
                </td>
                <td>
                    <span class="kat-chip">
                        <?= esc($t['kategori_icon'] ?? '📍') ?>
                        <?= esc($t['kategori'] ?? '-') ?>
                    </span>
                </td>
                <td>
                    <?php if ($t['rating']): ?>
                    <span style="color:#f5c842;font-weight:700;">★</span>
                    <span style="font-weight:600;"><?= $t['rating'] ?></span>
                    <?php else: ?>
                    <span style="color:#ddd;">–</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($t['harga_min']): ?>
                    <span style="font-weight:600;font-size:.82rem;">
                        Rp <?= number_format((int)$t['harga_min'], 0, ',', '.') ?>
                    </span>
                    <?php else: ?>
                    <span style="color:#ddd;font-size:.78rem;">–</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($fas)): ?>
                    <div class="fas-mini">
                        <?php foreach (array_slice($fas, 0, 3) as $f): ?>
                        <span><?= $f ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <span style="color:#ddd;font-size:.78rem;">–</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="<?= $aktif ? 'badge-active' : 'badge-nonactive' ?>">
                        <?= $aktif ? 'Aktif' : 'Nonaktif' ?>
                    </span>
                </td>
                <td>
                    <div class="actions">
                        <a href="/admin/tempat/edit/<?= $t['id'] ?>" class="btn-act btn-edit">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <a href="/admin/tempat/toggle/<?= $t['id'] ?>" class="btn-act btn-toggle"
                           title="<?= $aktif ? 'Nonaktifkan' : 'Aktifkan' ?>">
                            <i class="bi bi-<?= $aktif ? 'eye-slash' : 'eye' ?>-fill"></i>
                        </a>
                        <button onclick="confirmDelete(<?= $t['id'] ?>, '<?= esc($t['nama']) ?>')"
                                class="btn-act btn-del">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="tbl-footer">
        <div>Menampilkan <strong><?= count($tempat) ?></strong> tempat</div>
        <?php if ($search || $activeKatId || $activeStatus): ?>
        <div><a href="/admin/tempat" style="color:#A97142;text-decoration:none;font-weight:600;">Reset filter</a></div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete confirm modal -->
<div id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);
     z-index:999;align-items:center;justify-content:center;" onclick="closeModal()">
    <div style="background:#fff;border-radius:20px;padding:32px;max-width:380px;width:90%;
                box-shadow:0 20px 60px rgba(0,0,0,.3);" onclick="event.stopPropagation()">
        <div style="font-size:2.5rem;text-align:center;margin-bottom:12px;">🗑️</div>
        <div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:700;
                    text-align:center;margin-bottom:8px;color:#2B1B12;">Hapus Tempat?</div>
        <div style="font-size:.85rem;color:#888;text-align:center;margin-bottom:24px;">
            Tempat "<strong id="deleteNama"></strong>" akan dihapus permanen dan tidak dapat dikembalikan.
        </div>
        <div style="display:flex;gap:10px;">
            <button onclick="closeModal()"
                    style="flex:1;padding:11px;border:1.5px solid #e8d5c0;border-radius:12px;
                           background:#fff;font-family:'DM Sans',sans-serif;font-size:.85rem;
                           font-weight:600;color:#888;cursor:pointer;">Batal</button>
            <a id="deleteConfirmBtn" href="#"
               style="flex:1;padding:11px;background:linear-gradient(135deg,#dc3545,#a71c27);
                      color:#fff;border-radius:12px;text-align:center;text-decoration:none;
                      font-family:'DM Sans',sans-serif;font-size:.85rem;font-weight:700;">
                Ya, Hapus
            </a>
        </div>
    </div>
</div>
<script>
const modal = document.getElementById('deleteModal');
function confirmDelete(id, nama) {
    document.getElementById('deleteNama').textContent = nama;
    document.getElementById('deleteConfirmBtn').href = `/admin/tempat/delete/${id}`;
    modal.style.display = 'flex';
}
function closeModal() { modal.style.display = 'none'; }
</script>
<?= $this->endSection() ?>