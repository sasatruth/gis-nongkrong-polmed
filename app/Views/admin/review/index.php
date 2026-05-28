<?= $this->extend('admin/layouts/admin') ?>
<?= $this->section('content') ?>
<?php $pageTitle = 'Manajemen Review'; ?>
<style>
/* ── Toolbar ── */
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
/* ── Stat cards ── */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;}
.stat-card{
    background:#fff;border-radius:18px;padding:18px 20px;
    border:1px solid #e8d5c0;box-shadow:0 2px 12px rgba(122,78,45,.06);
    display:flex;align-items:center;gap:14px;transition:transform .2s,box-shadow .2s;
}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(122,78,45,.1);}
.stat-icon{width:46px;height:46px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.stat-val{font-family:'Syne',sans-serif;font-size:1.65rem;font-weight:800;color:#2B1B12;line-height:1;}
.stat-lbl{font-size:.68rem;color:#aaa;font-weight:500;text-transform:uppercase;letter-spacing:.4px;margin-top:3px;}
.stat-sub{font-size:.7rem;margin-top:4px;font-weight:600;color:#A97142;}
/* ── Table card ── */
.table-card{background:#fff;border-radius:18px;border:1px solid #e8d5c0;overflow:hidden;box-shadow:0 2px 12px rgba(122,78,45,.06);}
table{width:100%;border-collapse:collapse;}
thead th{
    background:#f8efe3;padding:12px 16px;
    font-size:.68rem;font-weight:700;color:#aaa;
    text-transform:uppercase;letter-spacing:.6px;
    text-align:left;border-bottom:1px solid #e8d5c0;white-space:nowrap;
}
tbody tr{border-bottom:1px solid #f5ede0;transition:background .12s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#fdf8f3;}
tbody td{padding:13px 16px;font-size:.84rem;color:#2B1B12;vertical-align:middle;}
/* ── Reviewer cell ── */
.reviewer-avatar{
    width:36px;height:36px;border-radius:10px;
    background:linear-gradient(135deg,#A97142,#7A4E2D);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-weight:700;font-size:.85rem;flex-shrink:0;
}
.reviewer-nama{font-weight:600;font-size:.86rem;}
.reviewer-date{font-size:.7rem;color:#bbb;margin-top:2px;}
/* ── Star rating ── */
.stars-display{display:flex;align-items:center;gap:3px;}
.star-filled{color:#f5c842;font-size:.9rem;}
.star-empty{color:#e0d0c0;font-size:.9rem;}
.rating-num{font-weight:700;font-size:.82rem;color:#2B1B12;margin-left:4px;}
/* ── Komentar ── */
.komentar-text{
    font-size:.8rem;color:#555;font-style:italic;
    max-width:320px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
.no-komentar{font-size:.75rem;color:#ddd;}
/* ── Tempat chip ── */
.tempat-chip{
    display:inline-flex;align-items:center;gap:5px;
    background:#f8efe3;border-radius:8px;padding:3px 9px;
    font-size:.73rem;font-weight:600;color:#7A4E2D;
    max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
/* ── Badge rating ── */
.badge-r5{background:#d4edda;color:#1a6e35;border-radius:7px;padding:3px 10px;font-size:.7rem;font-weight:700;}
.badge-r4{background:#fff3cd;color:#856404;border-radius:7px;padding:3px 10px;font-size:.7rem;font-weight:700;}
.badge-r3{background:#f8efe3;color:#7A4E2D;border-radius:7px;padding:3px 10px;font-size:.7rem;font-weight:700;}
.badge-r2,.badge-r1{background:#fde8ea;color:#9b1a2a;border-radius:7px;padding:3px 10px;font-size:.7rem;font-weight:700;}
/* ── Actions ── */
.actions{display:flex;gap:6px;align-items:center;}
.btn-act{
    padding:6px 13px;border-radius:8px;font-size:.74rem;font-weight:600;
    text-decoration:none;border:none;cursor:pointer;
    transition:all .15s;display:inline-flex;align-items:center;gap:4px;
    font-family:'DM Sans',sans-serif;
}
.btn-view{background:#f8efe3;color:#7A4E2D;}
.btn-view:hover{background:#e0cdb8;color:#7A4E2D;}
.btn-del{background:#fde8ea;color:#9b1a2a;}
.btn-del:hover{background:#f5c2c7;}
/* ── Empty ── */
.empty{text-align:center;padding:52px 20px;color:#ccc;}
.empty .ei{font-size:3rem;margin-bottom:10px;}
/* ── Footer ── */
.tbl-footer{
    padding:14px 20px;border-top:1px solid #f0e4d4;
    font-size:.78rem;color:#bbb;
    display:flex;align-items:center;justify-content:space-between;
}
.tbl-footer strong{color:#2B1B12;}
/* ── Rating dist mini bar ── */
.dist-row{display:flex;align-items:center;gap:8px;margin-bottom:6px;}
.dist-row:last-child{margin-bottom:0;}
.dist-label{font-size:.72rem;font-weight:700;color:#f5c842;width:28px;flex-shrink:0;}
.dist-bar{flex:1;height:7px;background:#f0e4d4;border-radius:4px;overflow:hidden;}
.dist-fill{height:7px;border-radius:4px;background:linear-gradient(to right,#f5c842,#e67e22);}
.dist-num{font-size:.7rem;font-weight:700;color:#aaa;width:24px;text-align:right;}
/* ── Detail modal ── */
#detailModal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;}
.modal-box{
    background:#fff;border-radius:22px;padding:32px;
    max-width:460px;width:90%;
    box-shadow:0 20px 60px rgba(0,0,0,.25);
}
.modal-reviewer{display:flex;align-items:center;gap:14px;margin-bottom:18px;}
.modal-avatar{
    width:52px;height:52px;border-radius:14px;
    background:linear-gradient(135deg,#A97142,#7A4E2D);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:1.4rem;font-weight:800;flex-shrink:0;
}
.modal-nama{font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:#2B1B12;}
.modal-meta{font-size:.75rem;color:#aaa;margin-top:2px;}
.modal-tempat{
    background:#f8efe3;border-radius:12px;padding:12px 16px;
    font-size:.82rem;font-weight:600;color:#7A4E2D;
    margin-bottom:16px;display:flex;align-items:center;gap:8px;
}
.modal-stars{display:flex;gap:4px;margin-bottom:16px;}
.modal-stars .star{font-size:1.4rem;}
.modal-komentar{
    background:#fdf8f3;border-radius:12px;padding:16px;
    font-size:.85rem;color:#555;font-style:italic;line-height:1.6;
    border:1px solid #f0e4d4;margin-bottom:20px;min-height:60px;
}
.modal-komentar.empty-komen{color:#ccc;font-style:normal;text-align:center;padding:24px;}
.modal-footer-btns{display:flex;gap:10px;}
@media(max-width:900px){.stat-grid{grid-template-columns:repeat(2,1fr);}}
</style>

<?php
$total    = (int)($stats['total'] ?? 0);
$avgRat   = $stats['avg_rating'] ?? '-';
$b5       = (int)($stats['bintang5']      ?? 0);
$b4       = (int)($stats['bintang4']      ?? 0);
$b3       = (int)($stats['bintang3']      ?? 0);
$bRendah  = (int)($stats['bintang_rendah'] ?? 0);
$mingguIni= (int)($stats['minggu_ini']    ?? 0);
$distMax  = max($b5, $b4, $b3, $bRendah, 1);
?>

<!-- ── Stat Cards ── -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#e8d5f5;">💬</div>
        <div>
            <div class="stat-val"><?= $total ?></div>
            <div class="stat-lbl">Total Review</div>
            <div class="stat-sub"><?= $mingguIni ?> minggu ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff3cd;">⭐</div>
        <div>
            <div class="stat-val"><?= $avgRat ?></div>
            <div class="stat-lbl">Rata-rata Rating</div>
            <div class="stat-sub">dari semua review</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#d4edda;">😍</div>
        <div>
            <div class="stat-val"><?= $b5 + $b4 ?></div>
            <div class="stat-lbl">Rating Positif (4–5★)</div>
            <div class="stat-sub"><?= $total > 0 ? round(($b5+$b4)/$total*100) : 0 ?>% dari total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fde8ea;">😞</div>
        <div>
            <div class="stat-val"><?= $bRendah ?></div>
            <div class="stat-lbl">Rating Rendah (≤2★)</div>
            <div class="stat-sub"><?= $total > 0 ? round($bRendah/$total*100) : 0 ?>% dari total</div>
        </div>
    </div>
</div>

<!-- ── Toolbar ── -->
<div class="toolbar">
    <form method="GET" action="/admin/review" style="display:contents;">
        <div class="search-wrap">
            <i class="bi bi-search si"></i>
            <input type="text" name="q" value="<?= esc($search) ?>"
                   placeholder="Cari nama reviewer, komentar, atau tempat...">
        </div>
        <select name="rating" class="filter-sel" onchange="this.form.submit()">
            <option value="">Semua Rating</option>
            <?php for ($i = 5; $i >= 1; $i--): ?>
            <option value="<?= $i ?>" <?= $activeRating == $i ? 'selected' : '' ?>>
                <?= str_repeat('★', $i) . str_repeat('☆', 5-$i) ?> (<?= $i ?>)
            </option>
            <?php endfor; ?>
        </select>
        <select name="sort" class="filter-sel" onchange="this.form.submit()">
            <option value="terbaru"     <?= $activeSort === 'terbaru'     ? 'selected' : '' ?>>Terbaru</option>
            <option value="rating_desc" <?= $activeSort === 'rating_desc' ? 'selected' : '' ?>>Rating Tertinggi</option>
            <option value="rating_asc"  <?= $activeSort === 'rating_asc'  ? 'selected' : '' ?>>Rating Terendah</option>
        </select>
        <?php if ($search || $activeRating): ?>
        <a href="/admin/review" class="btn-act btn-view" style="white-space:nowrap;">✕ Reset</a>
        <?php endif; ?>
        <button type="submit" class="btn-act btn-view" style="white-space:nowrap;">
            <i class="bi bi-search"></i> Cari
        </button>
    </form>
</div>

<!-- ── Main layout: Table + Distribusi ── -->
<div style="display:grid;grid-template-columns:1fr 220px;gap:18px;align-items:start;">

    <!-- Table -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Tempat</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($reviews)): ?>
            <tr>
                <td colspan="5">
                    <div class="empty">
                        <div class="ei">💬</div>
                        <div style="font-weight:600;color:#888;">Tidak ada review ditemukan</div>
                        <div style="font-size:.8rem;margin-top:4px;">
                            <?= $search || $activeRating ? 'Coba filter lain' : 'Belum ada review masuk' ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php else: ?>
            <?php foreach ($reviews as $rv):
                $initial = mb_strtoupper(mb_substr($rv['nama_reviewer'] ?? 'A', 0, 1));
                $rating  = (int)$rv['rating'];
                $badgeClass = match(true) {
                    $rating === 5 => 'badge-r5',
                    $rating === 4 => 'badge-r4',
                    $rating === 3 => 'badge-r3',
                    default       => 'badge-r1',
                };
            ?>
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div class="reviewer-avatar"><?= esc($initial) ?></div>
                        <div>
                            <div class="reviewer-nama"><?= esc($rv['nama_reviewer'] ?? 'Anonim') ?></div>
                            <div class="reviewer-date">
                                <?= date('d M Y, H:i', strtotime($rv['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="tempat-chip" title="<?= esc($rv['tempat_nama']) ?>">
                        <?= esc($rv['kategori_icon'] ?? '📍') ?>
                        <?= esc($rv['tempat_nama']) ?>
                    </span>
                </td>
                <td>
                    <div style="display:flex;flex-direction:column;gap:4px;">
                        <div class="stars-display">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="<?= $i <= $rating ? 'star-filled' : 'star-empty' ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <span class="<?= $badgeClass ?>"><?= $rating ?>★</span>
                    </div>
                </td>
                <td>
                    <?php if ($rv['komentar']): ?>
                    <div class="komentar-text" title="<?= esc($rv['komentar']) ?>">
                        "<?= esc($rv['komentar']) ?>"
                    </div>
                    <?php else: ?>
                    <span class="no-komentar">— tanpa komentar —</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="actions">
                        <button onclick="showDetail(<?= htmlspecialchars(json_encode($rv)) ?>)"
                                class="btn-act btn-view">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        <button onclick="confirmDelete(<?= $rv['id'] ?>, '<?= esc($rv['nama_reviewer']) ?>')"
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
            <div>Menampilkan <strong><?= count($reviews) ?></strong> review
                <?= ($search || $activeRating) ? '(difilter)' : '' ?>
            </div>
            <?php if ($search || $activeRating): ?>
            <a href="/admin/review" style="color:#A97142;font-weight:600;text-decoration:none;">Reset filter</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar: Distribusi Rating -->
    <div style="display:flex;flex-direction:column;gap:14px;">
        <div style="background:#fff;border-radius:18px;border:1px solid #e8d5c0;
                    padding:20px;box-shadow:0 2px 12px rgba(122,78,45,.06);">
            <div style="font-family:'Syne',sans-serif;font-size:.88rem;font-weight:700;
                        color:#2B1B12;margin-bottom:14px;display:flex;align-items:center;gap:6px;">
                ⭐ Distribusi Rating
            </div>
            <?php
            $distRows = [
                ['label' => '5★', 'val' => $b5,      'color' => '#f5c842'],
                ['label' => '4★', 'val' => $b4,      'color' => '#e67e22'],
                ['label' => '3★', 'val' => $b3,      'color' => '#A97142'],
                ['label' => '≤2★','val' => $bRendah, 'color' => '#dc3545'],
            ];
            ?>
            <?php foreach ($distRows as $d): ?>
            <div class="dist-row">
                <div class="dist-label" style="color:<?= $d['color'] ?>;"><?= $d['label'] ?></div>
                <div class="dist-bar">
                    <div class="dist-fill"
                         style="width:<?= round($d['val']/$distMax*100) ?>%;background:<?= $d['color'] ?>;"></div>
                </div>
                <div class="dist-num"><?= $d['val'] ?></div>
            </div>
            <?php endforeach; ?>
            <div style="margin-top:14px;padding-top:12px;border-top:1px solid #f0e4d4;
                        text-align:center;">
                <div style="font-family:'Syne',sans-serif;font-size:1.6rem;font-weight:800;
                            color:#2B1B12;"><?= $avgRat ?></div>
                <div style="display:flex;justify-content:center;gap:2px;margin:4px 0;">
                    <?php
                    $avgFloat = (float)$avgRat;
                    for ($i = 1; $i <= 5; $i++):
                        $col = $i <= round($avgFloat) ? '#f5c842' : '#e0d0c0';
                    ?>
                    <span style="color:<?= $col ?>;font-size:1rem;">★</span>
                    <?php endfor; ?>
                </div>
                <div style="font-size:.7rem;color:#aaa;"><?= $total ?> total review</div>
            </div>
        </div>

        <!-- Shortcut filter rating -->
        <div style="background:#fff;border-radius:18px;border:1px solid #e8d5c0;
                    padding:16px 20px;box-shadow:0 2px 12px rgba(122,78,45,.06);">
            <div style="font-family:'Syne',sans-serif;font-size:.85rem;font-weight:700;
                        color:#2B1B12;margin-bottom:12px;">Filter Cepat</div>
            <?php
            $quickFilters = [
                ['label' => '😍 Rating 5★', 'val' => 5, 'bg' => '#d4edda', 'color' => '#1a6e35'],
                ['label' => '👍 Rating 4★', 'val' => 4, 'bg' => '#fff3cd', 'color' => '#856404'],
                ['label' => '😐 Rating 3★', 'val' => 3, 'bg' => '#f8efe3', 'color' => '#7A4E2D'],
                ['label' => '👎 Rating ≤2★','val' => 2, 'bg' => '#fde8ea', 'color' => '#9b1a2a'],
            ];
            foreach ($quickFilters as $qf): ?>
            <a href="/admin/review?rating=<?= $qf['val'] ?>"
               style="display:flex;align-items:center;justify-content:space-between;
                      padding:8px 12px;border-radius:9px;margin-bottom:6px;
                      background:<?= $activeRating == $qf['val'] ? $qf['bg'] : 'transparent' ?>;
                      color:<?= $qf['color'] ?>;font-size:.78rem;font-weight:600;
                      text-decoration:none;transition:background .15s;"
               onmouseover="this.style.background='<?= $qf['bg'] ?>'"
               onmouseout="this.style.background='<?= $activeRating == $qf['val'] ? $qf['bg'] : 'transparent' ?>'">
                <span><?= $qf['label'] ?></span>
                <span style="background:<?= $qf['bg'] ?>;padding:2px 8px;border-radius:6px;font-size:.7rem;">
                    <?= match($qf['val']) {
                        5 => $b5,
                        4 => $b4,
                        3 => $b3,
                        2 => $bRendah,
                        default => 0,
                    } ?>
                </span>
            </a>
            <?php endforeach; ?>
            <?php if ($activeRating): ?>
            <a href="/admin/review"
               style="display:block;text-align:center;padding:8px;border-radius:9px;
                      background:#f5f5f5;color:#aaa;font-size:.75rem;font-weight:600;
                      text-decoration:none;margin-top:4px;">
                ✕ Hapus Filter
            </a>
            <?php endif; ?>
        </div>
    </div>

</div><!-- end grid -->

<!-- ── Detail Modal ── -->
<div id="detailModal" onclick="closeDetail()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-reviewer">
            <div class="modal-avatar" id="modalAvatar">A</div>
            <div>
                <div class="modal-nama" id="modalNama">—</div>
                <div class="modal-meta" id="modalDate">—</div>
            </div>
        </div>
        <div class="modal-tempat" id="modalTempat">📍 —</div>
        <div class="modal-stars" id="modalStars"></div>
        <div class="modal-komentar" id="modalKomentar">—</div>
        <div class="modal-footer-btns">
            <button onclick="closeDetail()"
                    style="flex:1;padding:11px;border:1.5px solid #e8d5c0;border-radius:12px;
                           background:#fff;font-family:'DM Sans',sans-serif;font-size:.85rem;
                           font-weight:600;color:#888;cursor:pointer;">
                Tutup
            </button>
            <button id="modalDelBtn"
                    style="flex:1;padding:11px;background:linear-gradient(135deg,#dc3545,#a71c27);
                           color:#fff;border-radius:12px;border:none;
                           font-family:'DM Sans',sans-serif;font-size:.85rem;font-weight:700;cursor:pointer;">
                <i class="bi bi-trash3-fill"></i> Hapus Review
            </button>
        </div>
    </div>
</div>

<!-- ── Delete Confirm Modal ── -->
<div id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);
     z-index:1000;align-items:center;justify-content:center;" onclick="closeDelete()">
    <div style="background:#fff;border-radius:20px;padding:32px;max-width:380px;width:90%;
                box-shadow:0 20px 60px rgba(0,0,0,.3);" onclick="event.stopPropagation()">
        <div style="font-size:2.5rem;text-align:center;margin-bottom:12px;">🗑️</div>
        <div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:700;
                    text-align:center;margin-bottom:8px;color:#2B1B12;">Hapus Review?</div>
        <div style="font-size:.85rem;color:#888;text-align:center;margin-bottom:24px;">
            Review dari "<strong id="deleteNama"></strong>" akan dihapus permanen.
        </div>
        <div style="display:flex;gap:10px;">
            <button onclick="closeDelete()"
                    style="flex:1;padding:11px;border:1.5px solid #e8d5c0;border-radius:12px;
                           background:#fff;font-family:'DM Sans',sans-serif;font-size:.85rem;
                           font-weight:600;color:#888;cursor:pointer;">
                Batal
            </button>
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
/* ── Detail modal ── */
function showDetail(rv) {
    document.getElementById('modalAvatar').textContent =
        (rv.nama_reviewer || 'A').charAt(0).toUpperCase();
    document.getElementById('modalNama').textContent = rv.nama_reviewer || 'Anonim';
    const d = new Date(rv.created_at);
    document.getElementById('modalDate').textContent =
        d.toLocaleDateString('id-ID', {day:'numeric',month:'long',year:'numeric',hour:'2-digit',minute:'2-digit'});
    document.getElementById('modalTempat').innerHTML =
        (rv.kategori_icon || '📍') + ' ' + (rv.tempat_nama || '-');
    const rating = parseInt(rv.rating) || 0;
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += `<span class="star" style="color:${i<=rating?'#f5c842':'#e0d0c0'}">★</span>`;
    }
    document.getElementById('modalStars').innerHTML = stars;
    const kEl = document.getElementById('modalKomentar');
    if (rv.komentar) {
        kEl.textContent = '"' + rv.komentar + '"';
        kEl.classList.remove('empty-komen');
    } else {
        kEl.textContent = 'Tidak ada komentar';
        kEl.classList.add('empty-komen');
    }
    document.getElementById('modalDelBtn').onclick = () => {
        closeDetail();
        confirmDelete(rv.id, rv.nama_reviewer);
    };
    document.getElementById('detailModal').style.display = 'flex';
}
function closeDetail() {
    document.getElementById('detailModal').style.display = 'none';
}

/* ── Delete modal ── */
function confirmDelete(id, nama) {
    document.getElementById('deleteNama').textContent = nama;
    document.getElementById('deleteConfirmBtn').href = `/admin/review/delete/${id}`;
    document.getElementById('deleteModal').style.display = 'flex';
}
function closeDelete() {
    document.getElementById('deleteModal').style.display = 'none';
}
</script>
<?= $this->endSection() ?>