<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
:root {
    --brown:  #7A4E2D;
    --coffee: #A97142;
    --cream:  #F8EFE3;
    --dark:   #2B1B12;
    --gold:   #D4A017;
    --soft:   #EDE0D0;
}

/* ── Hero ──────────────────────────────────────────── */
.hero-banner {
    background: linear-gradient(135deg, var(--brown) 0%, #4a2c14 55%, #2B1B12 100%);
    border-radius: 24px;
    padding: 52px 44px;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
}
.hero-banner::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(169,113,66,.3) 0%, transparent 70%);
    border-radius: 50%;
}
.hero-banner::after {
    content: '☕';
    position: absolute;
    bottom: -30px; right: 48px;
    font-size: 180px;
    opacity: .06;
    line-height: 1;
    pointer-events: none;
}
.hero-badge {
    display: inline-block;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    color: #fff;
    border-radius: 999px;
    padding: 5px 16px;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: .5px;
    margin-bottom: 18px;
}
.hero-banner h1 {
    font-size: 2.4rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: .5rem;
    line-height: 1.2;
}
.hero-banner p {
    color: rgba(255,255,255,.7);
    font-size: 1rem;
    max-width: 540px;
    margin-bottom: 0;
}

/* ── Search bar ────────────────────────────────────── */
.search-wrap {
    position: relative;
    margin-top: 28px;
    max-width: 520px;
}
.search-wrap input {
    width: 100%;
    padding: 14px 20px 14px 48px;
    border-radius: 14px;
    border: none;
    font-size: .95rem;
    font-family: 'Poppins', sans-serif;
    background: rgba(255,255,255,.95);
    box-shadow: 0 4px 20px rgba(0,0,0,.2);
    outline: none;
    color: var(--dark);
}
.search-wrap .search-icon {
    position: absolute;
    left: 16px; top: 50%;
    transform: translateY(-50%);
    color: var(--coffee);
    font-size: 1.1rem;
    pointer-events: none;
}
.search-wrap input::placeholder { color: #aaa; }

/* ── Insight chips ─────────────────────────────────── */
.insight-chip {
    background: #fff;
    border-radius: 14px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 12px rgba(122,78,45,.08);
    border: 1px solid #f0e4d4;
    transition: transform .2s;
}
.insight-chip:hover { transform: translateY(-2px); }
.insight-chip-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.insight-chip-val {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1;
}
.insight-chip-label {
    font-size: .72rem;
    color: #999;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-top: 2px;
}

/* ── Section title ─────────────────────────────────── */
.sec-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: .9rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.sec-title::after {
    content: '';
    flex: 1;
    height: 2px;
    background: linear-gradient(to right, var(--soft), transparent);
    border-radius: 2px;
}

/* ── Filter & Sort bar ─────────────────────────────── */
.filter-bar {
    background: #fff;
    border-radius: 16px;
    padding: 16px 20px;
    box-shadow: 0 2px 12px rgba(122,78,45,.07);
    border: 1px solid #f0e4d4;
    margin-bottom: 1.2rem;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
}
.filter-bar .filter-label {
    font-size: .75rem;
    font-weight: 700;
    color: #bbb;
    text-transform: uppercase;
    letter-spacing: .5px;
    white-space: nowrap;
}
.kat-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    flex: 1;
}
.kat-pill {
    background: var(--soft);
    border: 1.5px solid transparent;
    border-radius: 999px;
    padding: 6px 14px;
    font-size: .78rem;
    font-weight: 600;
    color: var(--brown);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    transition: all .15s;
}
.kat-pill:hover {
    background: #e0cdb8;
    color: var(--brown);
}
.kat-pill.active {
    background: var(--brown);
    color: #fff;
    border-color: var(--brown);
}
.sort-group {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.sort-btn {
    background: var(--soft);
    border: 1.5px solid transparent;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: .78rem;
    font-weight: 600;
    color: var(--brown);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    transition: all .15s;
}
.sort-btn:hover { background: #e0cdb8; color: var(--brown); }
.sort-btn.active {
    background: var(--coffee);
    color: #fff;
    border-color: var(--coffee);
}
.divider-bar {
    width: 1px;
    height: 24px;
    background: var(--soft);
    flex-shrink: 0;
}

/* ── Tempat card ───────────────────────────────────── */
.tc {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #f0e4d4;
    box-shadow: 0 2px 12px rgba(122,78,45,.07);
    transition: transform .22s, box-shadow .22s;
    height: 100%;
}
.tc:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(122,78,45,.16);
}
.tc-img {
    width: 100%; height: 160px;
    object-fit: cover;
    display: block;
}
.tc-body { padding: 14px 16px 16px; }
.tc-nama {
    font-weight: 700;
    font-size: .92rem;
    color: var(--dark);
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.tc-sub { font-size: .74rem; color: #aaa; margin-bottom: 10px; }
.tc-price { font-size: .78rem; color: var(--brown); font-weight: 600; }
.tc-rating {
    position: absolute;
    top: 10px; left: 10px;
    background: linear-gradient(135deg,#f5c842,#e67e22);
    color: #fff;
    border-radius: 8px;
    padding: 3px 9px;
    font-size: .72rem;
    font-weight: 700;
}
.tc-kat {
    position: absolute;
    top: 10px; right: 10px;
    background: rgba(255,255,255,.92);
    border-radius: 8px;
    padding: 3px 9px;
    font-size: .7rem;
    font-weight: 600;
    color: var(--brown);
}
.tc-fas {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-top: 8px;
}
.tc-badge {
    background: var(--soft);
    color: var(--brown);
    border-radius: 6px;
    padding: 2px 8px;
    font-size: .68rem;
    font-weight: 600;
}

/* ── Rekomendasi card ──────────────────────────────── */
.reko-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f0e4d4;
    box-shadow: 0 2px 12px rgba(122,78,45,.07);
    overflow: hidden;
    display: flex;
    transition: transform .2s, box-shadow .2s;
    text-decoration: none;
    color: inherit;
}
.reko-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(122,78,45,.14);
    color: inherit;
}
.reko-card img {
    width: 110px;
    min-height: 100%;
    object-fit: cover;
    flex-shrink: 0;
}
.reko-body { padding: 14px; flex: 1; min-width: 0; }
.reko-nama {
    font-weight: 700;
    font-size: .88rem;
    color: var(--dark);
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.reko-sub { font-size: .72rem; color: #bbb; margin-bottom: 6px; }
.reko-price { font-size: .76rem; color: var(--brown); font-weight: 600; }

/* ── Hasil count ───────────────────────────────────── */
.hasil-info {
    font-size: .8rem;
    color: #aaa;
    margin-bottom: .8rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.hasil-info strong { color: var(--dark); }

/* ── No result ─────────────────────────────────────── */
#noResult {
    display: none;
    text-align: center;
    padding: 48px 20px;
    color: #bbb;
}
#noResult .no-icon { font-size: 3rem; margin-bottom: 8px; }
</style>

<div class="container-fluid px-4 py-4">

    <!-- ── HERO ──────────────────────────────────────────── -->
    <div class="hero-banner">
        <span class="hero-badge">📍 Politeknik Negeri Medan · GIS Nongkrong</span>
        <h1>Cari Tempat <span style="color:var(--gold)">Nongkrong</span><br>di Sekitar Polmed</h1>
        <p>Temukan kafe, warung, dan spot terbaik dekat kampus — lengkap dengan fasilitas, harga, dan peta interaktif.</p>
        <div class="search-wrap">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="searchInput"
                   placeholder="Cari nama tempat atau alamat…"
                   oninput="filterSearch()">
        </div>
    </div>

    <!-- ── INSIGHT CHIPS ──────────────────────────────────── -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="insight-chip">
                <div class="insight-chip-icon" style="background:#fff3cd;">🗺️</div>
                <div>
                    <div class="insight-chip-val"><?= $stats['total_semua'] ?? 0 ?></div>
                    <div class="insight-chip-label">Total Tempat</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="insight-chip">
                <div class="insight-chip-icon" style="background:#d4edda;">📍</div>
                <div>
                    <div class="insight-chip-val"><?= $stats['radius_1km'] ?? 0 ?></div>
                    <div class="insight-chip-label">Dalam 1 KM</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="insight-chip">
                <div class="insight-chip-icon" style="background:#cce5ff;">⭐</div>
                <div>
                    <div class="insight-chip-val"><?= $stats['rata_rating'] ?? '-' ?></div>
                    <div class="insight-chip-label">Rata-rata Rating</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="insight-chip">
                <div class="insight-chip-icon" style="background:#fde8ea;">💰</div>
                <div>
                    <div class="insight-chip-val" style="font-size:1.1rem;">
                        <?= $stats['rata_harga_min']
                            ? 'Rp ' . number_format((int)$stats['rata_harga_min'], 0, ',', '.')
                            : '-' ?>
                    </div>
                    <div class="insight-chip-label">Rata Harga Min</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- ── KOLOM KIRI: Grid tempat ── -->
        <div class="col-lg-8">

            <!-- Filter + Sort bar (semua server-side via link) -->
            <div class="filter-bar">
                <!-- Filter kategori -->
                <span class="filter-label">Kategori</span>
                <div class="kat-pills">
                    <a href="?sort=<?= esc($sort) ?>"
                       class="kat-pill <?= $activeKatId === '' ? 'active' : '' ?>">
                        🏠 Semua
                    </a>
                    <?php foreach ($kategoriList as $k): ?>
                    <a href="?kat_id=<?= $k['id'] ?>&sort=<?= esc($sort) ?>"
                       class="kat-pill <?= (string)$activeKatId === (string)$k['id'] ? 'active' : '' ?>">
                        <?= esc($k['icon']) ?> <?= esc($k['nama']) ?>
                        <span style="opacity:.55;font-size:.7rem;"><?= $k['jumlah'] ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>

                <div class="divider-bar"></div>

                <!-- Sort -->
                <span class="filter-label">Urutkan</span>
                <div class="sort-group">
                    <a href="?sort=rating<?= $activeKatId !== '' ? '&kat_id='.$activeKatId : '' ?>"
                       class="sort-btn <?= $sort === 'rating'   ? 'active' : '' ?>">
                        ⭐ Rating
                    </a>
                    <a href="?sort=terdekat<?= $activeKatId !== '' ? '&kat_id='.$activeKatId : '' ?>"
                       class="sort-btn <?= $sort === 'terdekat' ? 'active' : '' ?>">
                        📍 Terdekat
                    </a>
                    <a href="?sort=hemat<?= $activeKatId !== '' ? '&kat_id='.$activeKatId : '' ?>"
                       class="sort-btn <?= $sort === 'hemat'    ? 'active' : '' ?>">
                        💸 Termurah
                    </a>
                </div>
            </div>

            <!-- Info jumlah hasil -->
            <div class="hasil-info">
                <strong id="jumlahTampil"><?= count($semuaTempat) ?></strong> tempat ditemukan
                <?php if ($activeKatId !== ''): ?>
                    <?php $aktifKat = array_filter($kategoriList, fn($k) => (string)$k['id'] === (string)$activeKatId); ?>
                    <?php $aktifKat = array_values($aktifKat)[0] ?? null; ?>
                    <?php if ($aktifKat): ?>
                    · filter: <strong><?= esc($aktifKat['icon'].' '.$aktifKat['nama']) ?></strong>
                    <a href="?sort=<?= esc($sort) ?>" style="color:var(--coffee);font-size:.75rem;">✕ hapus</a>
                    <?php endif; ?>
                <?php endif; ?>
                · diurutkan: <strong>
                    <?= match($sort) {
                        'terdekat' => 'Terdekat',
                        'hemat'    => 'Termurah',
                        default    => 'Rating Tertinggi',
                    } ?>
                </strong>
            </div>

            <!-- Grid tempat -->
            <div class="row g-3" id="tempatGrid">
                <?php foreach ($semuaTempat as $t): ?>
                <?php
                    $bool = fn($v) => $v === true || $v === 't' || $v === '1' || $v == 1;
                    $fas = [];
                    if ($bool($t['wifi']))    $fas[] = '📶 WiFi';
                    if ($bool($t['colokan'])) $fas[] = '🔌 Colokan';
                    if ($bool($t['ac']))      $fas[] = '❄️ AC';
                    if ($bool($t['parkir']))  $fas[] = '🅿️ Parkir';
                ?>
                <div class="col-6 col-md-4 tempat-item"
                     data-nama="<?= strtolower(esc($t['nama'])) ?>"
                     data-alamat="<?= strtolower(esc($t['alamat'] ?? '')) ?>">
                    <a href="/tempat/<?= $t['id'] ?>" class="text-decoration-none d-block h-100">
                        <div class="tc">
                            <div style="position:relative;">
                                <img class="tc-img"
                                     src="<?= esc($t['foto_url'] ?? 'https://placehold.co/400x200/A97142/fff?text=Foto') ?>"
                                     alt="<?= esc($t['nama']) ?>"
                                     loading="lazy">
                                <?php if ($t['rating']): ?>
                                <span class="tc-rating">⭐ <?= $t['rating'] ?></span>
                                <?php endif; ?>
                                <span class="tc-kat">
                                    <?= esc($t['kategori_icon'] ?? '📍') ?>
                                    <?= esc($t['kategori'] ?? '') ?>
                                </span>
                            </div>
                            <div class="tc-body">
                                <div class="tc-nama"><?= esc($t['nama']) ?></div>
                                <div class="tc-sub">
                                    <?php if ($t['jarak_meter']): ?>
                                        📍 <?= number_format((int)$t['jarak_meter']) ?> m dari Polmed
                                    <?php else: ?>
                                        <?= esc($t['alamat'] ?? '') ?>
                                    <?php endif; ?>
                                    <?php if ($t['jam_buka'] && $t['jam_tutup']): ?>
                                        · 🕐 <?= substr($t['jam_buka'],0,5) ?>–<?= substr($t['jam_tutup'],0,5) ?>
                                    <?php endif; ?>
                                </div>
                                <div class="tc-price">
                                    <?php if ($t['harga_min']): ?>
                                        Rp <?= number_format((int)$t['harga_min'],0,',','.') ?>
                                        <?php if ($t['harga_max']): ?>
                                            – <?= number_format((int)$t['harga_max'],0,',','.') ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span style="color:#ccc;">Harga belum diisi</span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($fas)): ?>
                                <div class="tc-fas">
                                    <?php foreach (array_slice($fas,0,3) as $f): ?>
                                    <span class="tc-badge"><?= $f ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>

                <?php if (empty($semuaTempat)): ?>
                <div class="col-12" id="noResult" style="display:block;">
                    <div style="text-align:center;padding:48px 20px;color:#bbb;">
                        <div style="font-size:3rem;margin-bottom:8px;">🔍</div>
                        <div style="font-weight:600;color:var(--dark);">Tidak ada tempat ditemukan</div>
                        <div style="font-size:.83rem;margin-top:4px;">
                            Coba kategori lain atau <a href="/" style="color:var(--coffee);">reset filter</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- No result saat search JS -->
            <div id="noResultSearch" style="display:none;text-align:center;padding:48px 20px;color:#bbb;">
                <div style="font-size:3rem;margin-bottom:8px;">🔍</div>
                <div style="font-weight:600;color:var(--dark);">Tidak ada tempat ditemukan</div>
                <div style="font-size:.83rem;margin-top:4px;">Coba kata kunci lain</div>
            </div>

        </div>

        <!-- ── KOLOM KANAN: Rekomendasi ── -->
        <div class="col-lg-4">

            <div class="sec-title"><span>⚡</span> Rekomendasi Cepat</div>
            <div class="d-flex flex-column gap-3 mb-4">
                <?php foreach ($rekomendasiCepat as $r): ?>
                <a href="/tempat/<?= $r['id'] ?>" class="reko-card">
                    <img src="<?= esc($r['foto_url'] ?? 'https://placehold.co/220x120/A97142/fff?text=Foto') ?>"
                         alt="<?= esc($r['nama']) ?>">
                    <div class="reko-body">
                        <div class="reko-nama"><?= esc($r['nama']) ?></div>
                        <div class="reko-sub">
                            <?= esc($r['kategori_icon'] ?? '📍') ?> <?= esc($r['kategori'] ?? '') ?>
                            <?php if ($r['jarak_meter']): ?>
                                · <?= number_format((int)$r['jarak_meter']) ?> m
                            <?php endif; ?>
                        </div>
                        <?php if ($r['rating']): ?>
                        <div style="font-size:.72rem;color:#e67e22;margin-bottom:4px;">
                            ⭐ <?= $r['rating'] ?>
                        </div>
                        <?php endif; ?>
                        <div class="reko-price">
                            <?php if ($r['harga_min']): ?>
                                Rp <?= number_format((int)$r['harga_min'],0,',','.') ?>
                                <?php if ($r['harga_max']): ?>
                                    – <?= number_format((int)$r['harga_max'],0,',','.') ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <span style="color:#ccc;font-size:.72rem;">Harga belum diisi</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- CTA Peta -->
            <div style="background:linear-gradient(135deg,var(--brown),#4a2c14);
                        border-radius:18px;padding:24px;text-align:center;">
                <div style="font-size:2rem;margin-bottom:8px;">🗺️</div>
                <div style="font-weight:700;color:#fff;font-size:.95rem;margin-bottom:6px;">
                    Eksplorasi via Peta GIS
                </div>
                <div style="color:rgba(255,255,255,.6);font-size:.78rem;margin-bottom:14px;">
                    Filter radius, rekomendasi AI,<br>visualisasi spasial PostGIS
                </div>
                <a href="/map"
                   style="background:var(--gold);color:var(--dark);border:none;
                          border-radius:12px;padding:11px 24px;font-weight:700;
                          font-size:.88rem;text-decoration:none;
                          display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-map-fill"></i> Buka Peta
                </a>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
// ── Search JS hanya filter nama & alamat (client-side) ─────────
// Kategori & sort tetap server-side via URL link
const items    = document.querySelectorAll('.tempat-item');
const noSearch = document.getElementById('noResultSearch');
const jumlah   = document.getElementById('jumlahTampil');
const total    = items.length;

function filterSearch() {
    const q = document.getElementById('searchInput').value.toLowerCase().trim();
    let visible = 0;
    items.forEach(item => {
        const nama   = item.dataset.nama   || '';
        const alamat = item.dataset.alamat || '';
        const match  = !q || nama.includes(q) || alamat.includes(q);
        item.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    jumlah.textContent = visible;
    noSearch.style.display = visible === 0 && q ? 'block' : 'none';
}
</script>
<?= $this->endSection() ?>