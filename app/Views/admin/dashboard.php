<?= $this->extend('admin/layouts/admin') ?>
<?= $this->section('content') ?>
<?php $pageTitle = 'Dashboard'; ?>
<style>
/* ── Vars ── */
:root{--br:#7A4E2D;--cf:#A97142;--cr:#F8EFE3;--dk:#2B1B12;--sf:#EDE0D0;}

/* ── Stat cards ── */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
.stat-card{
    background:#fff;border-radius:18px;padding:20px 22px;
    border:1px solid #e8d5c0;box-shadow:0 2px 12px rgba(122,78,45,.06);
    display:flex;align-items:center;gap:14px;transition:transform .2s,box-shadow .2s;
}
.stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(122,78,45,.12);}
.stat-icon{width:50px;height:50px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.stat-val{font-family:'Syne',sans-serif;font-size:1.75rem;font-weight:800;color:var(--dk);line-height:1;}
.stat-lbl{font-size:.7rem;color:#aaa;font-weight:500;text-transform:uppercase;letter-spacing:.4px;margin-top:3px;}
.stat-trend{font-size:.7rem;margin-top:4px;font-weight:600;}
.trend-up{color:#1a6e35;}.trend-down{color:#9b1a2a;}.trend-neu{color:#aaa;}

/* ── Section ── */
.sec-title{
    font-family:'Syne',sans-serif;font-size:.95rem;font-weight:700;color:var(--dk);
    margin-bottom:14px;display:flex;align-items:center;gap:8px;
}
.sec-title::after{content:'';flex:1;height:2px;background:linear-gradient(to right,#EDE0D0,transparent);border-radius:2px;}
.card{background:#fff;border-radius:18px;border:1px solid #e8d5c0;box-shadow:0 2px 12px rgba(122,78,45,.06);}

/* ── Grid layout ── */
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:20px;}
.grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:18px;margin-bottom:20px;}
.grid-65{display:grid;grid-template-columns:1.6fr 1fr;gap:18px;margin-bottom:20px;}

/* ── Chart containers ── */
.chart-wrap{padding:22px;}
.chart-wrap canvas{max-height:220px;}

/* ── Radius cards ── */
.radius-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;padding:18px;}
.radius-card{
    background:var(--cr);border-radius:14px;padding:16px;text-align:center;
    border:1px solid #e8d5c0;
}
.radius-val{font-family:'Syne',sans-serif;font-size:1.6rem;font-weight:800;color:var(--dk);}
.radius-lbl{font-size:.7rem;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px;margin-top:2px;}
.radius-sub{font-size:.75rem;color:var(--cf);font-weight:600;margin-top:4px;}

/* ── GIS monitor ── */
.gis-row{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-bottom:1px solid #f5ede0;}
.gis-row:last-child{border-bottom:none;}
.gis-label{font-size:.83rem;font-weight:600;color:#555;display:flex;align-items:center;gap:8px;}
.gis-val{font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--dk);}
.gis-bar{flex:1;height:6px;background:#f0e4d4;border-radius:3px;margin:0 14px;overflow:hidden;}
.gis-bar-fill{height:6px;border-radius:3px;background:linear-gradient(to right,#A97142,#7A4E2D);}

/* ── Rating dist ── */
.rating-row{display:flex;align-items:center;gap:10px;padding:6px 0;}
.r-stars{font-size:.78rem;color:#f5c842;width:60px;flex-shrink:0;font-weight:700;}
.r-bar{flex:1;height:10px;background:#f0e4d4;border-radius:5px;overflow:hidden;}
.r-fill{height:10px;border-radius:5px;background:linear-gradient(to right,#f5c842,#e67e22);transition:width .8s ease;}
.r-count{font-size:.75rem;font-weight:700;color:#888;width:28px;text-align:right;}

/* ── Tabel ── */
table{width:100%;border-collapse:collapse;}
thead th{background:#f8efe3;padding:11px 16px;font-size:.7rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:.5px;text-align:left;border-bottom:1px solid #e8d5c0;}
tbody tr{border-bottom:1px solid #f5ede0;transition:background .12s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#fdf8f3;}
tbody td{padding:11px 16px;font-size:.83rem;color:var(--dk);vertical-align:middle;}
.badge-a{background:#d4edda;color:#1a6e35;border-radius:6px;padding:2px 9px;font-size:.68rem;font-weight:700;}
.badge-n{background:#fde8ea;color:#9b1a2a;border-radius:6px;padding:2px 9px;font-size:.68rem;font-weight:700;}
.kat-chip{display:inline-flex;align-items:center;gap:5px;background:#f8efe3;border-radius:8px;padding:3px 9px;font-size:.72rem;font-weight:600;color:var(--br);}

/* ── Review card ── */
.review-item{padding:14px 18px;border-bottom:1px solid #f5ede0;}
.review-item:last-child{border-bottom:none;}
.rv-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;}
.rv-nama{font-weight:700;font-size:.83rem;}
.rv-stars{color:#f5c842;font-size:.78rem;}
.rv-tempat{font-size:.72rem;color:var(--cf);font-weight:600;margin-bottom:4px;}
.rv-komen{font-size:.78rem;color:#666;font-style:italic;}

/* ── Progress donut ── */
.donut-wrap{position:relative;width:120px;height:120px;margin:0 auto 12px;}
.donut-label{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;}
.donut-val{font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--dk);line-height:1;}
.donut-sub{font-size:.62rem;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px;}

/* ── Completeness ── */
.complete-row{display:flex;align-items:center;gap:10px;padding:9px 18px;border-bottom:1px solid #f5ede0;}
.complete-row:last-child{border-bottom:none;}
.complete-lbl{font-size:.8rem;font-weight:600;color:#555;flex:1;}
.complete-bar{width:120px;height:8px;background:#f0e4d4;border-radius:4px;overflow:hidden;}
.complete-fill{height:8px;border-radius:4px;}
.complete-pct{font-size:.75rem;font-weight:700;color:var(--br);width:36px;text-align:right;}

@media(max-width:1100px){
    .stat-grid{grid-template-columns:repeat(2,1fr);}
    .grid-2,.grid-3,.grid-65{grid-template-columns:1fr;}
}
</style>

<?php
    $total  = (int)($stats['total_tempat'] ?? 1) ?: 1;
    $aktif  = (int)($stats['aktif'] ?? 0);
    $bool   = fn($v) => $v === true || $v === 't' || $v === '1' || $v == 1;

    // Completeness pct
    $pctKoord  = round(($stats['ada_koordinat'] ?? 0) / $total * 100);
    $pctFoto   = round(($stats['ada_foto']      ?? 0) / $total * 100);
    $pctHarga  = round(($stats['ada_harga']     ?? 0) / $total * 100);
    $pctAktif  = round($aktif / $total * 100);

    // Rating dist
    $rd    = $distribusiRating;
    $rdMax = max(array_values($rd) ?: [1]) ?: 1;

    // Fasilitas untuk chart
    $fas = $fasilitas;
    $fasKeys   = ['wifi','colokan','ac','parkir','mushola','outdoor','tenang','nugas','rame'];
    $fasLabels = ['WiFi','Colokan','AC','Parkir','Mushola','Outdoor','Tenang','Nugas','Rame'];
    $fasVals   = array_map(fn($k) => (int)($fas[$k] ?? 0), $fasKeys);

    // Kategori untuk chart
    $katLabels = array_column($perKategori, 'nama');
    $katVals   = array_map('intval', array_column($perKategori, 'jumlah'));
    $katColors = ['#A97142','#7A4E2D','#D4A017','#c0784a','#e6a86a','#5c3317','#d4915e','#b8622c'];
?>

<!-- ── ROW 1: Stat Cards ──────────────────────────────────────── -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff3cd;">🗺️</div>
        <div>
            <div class="stat-val"><?= $stats['total_tempat'] ?? 0 ?></div>
            <div class="stat-lbl">Total Tempat</div>
            <div class="stat-trend trend-neu"><?= $aktif ?> aktif · <?= $stats['nonaktif'] ?? 0 ?> nonaktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#d4edda;">✅</div>
        <div>
            <div class="stat-val"><?= $stats['aktif'] ?? 0 ?></div>
            <div class="stat-lbl">Tempat Aktif</div>
            <div class="stat-trend trend-up"><?= $pctAktif ?>% dari total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e8d5f5;">💬</div>
        <div>
            <div class="stat-val"><?= $totalReview ?></div>
            <div class="stat-lbl">Total Review</div>
            <div class="stat-trend trend-neu"><?= $totalKat ?> kategori</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#cce5ff;">⭐</div>
        <div>
            <div class="stat-val"><?= $stats['avg_rating'] ?? '-' ?></div>
            <div class="stat-lbl">Rata-rata Rating</div>
            <div class="stat-trend trend-up"><?= $stats['rating_tinggi'] ?? 0 ?> tempat ≥ 4★</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0e4d4;">📍</div>
        <div>
            <div class="stat-val"><?= $stats['ada_koordinat'] ?? 0 ?></div>
            <div class="stat-lbl">Punya Koordinat</div>
            <div class="stat-trend <?= $pctKoord >= 80 ? 'trend-up' : 'trend-down' ?>"><?= $pctKoord ?>% lengkap</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fde8ea;">⏸️</div>
        <div>
            <div class="stat-val"><?= $stats['nonaktif'] ?? 0 ?></div>
            <div class="stat-lbl">Nonaktif</div>
            <div class="stat-trend trend-down"><?= 100 - $pctAktif ?>% dari total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#d4edda;">🖼️</div>
        <div>
            <div class="stat-val"><?= $stats['ada_foto'] ?? 0 ?></div>
            <div class="stat-lbl">Ada Foto</div>
            <div class="stat-trend <?= $pctFoto >= 80 ? 'trend-up' : 'trend-neu' ?>"><?= $pctFoto ?>% lengkap</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff3cd;">💰</div>
        <div>
            <div class="stat-val"><?= $stats['ada_harga'] ?? 0 ?></div>
            <div class="stat-lbl">Ada Harga</div>
            <div class="stat-trend <?= $pctHarga >= 80 ? 'trend-up' : 'trend-neu' ?>"><?= $pctHarga ?>% lengkap</div>
        </div>
    </div>
</div>

<!-- ── ROW 2: Chart Kategori + Chart Fasilitas ───────────────────── -->
<div class="grid-2">
    <!-- Donut kategori -->
    <div class="card">
        <div class="chart-wrap">
            <div class="sec-title"><span>📂</span> Distribusi Kategori</div>
            <canvas id="chartKat" style="max-height:220px;"></canvas>
        </div>
    </div>
    <!-- Bar fasilitas -->
    <div class="card">
        <div class="chart-wrap">
            <div class="sec-title"><span>🛠️</span> Ketersediaan Fasilitas</div>
            <canvas id="chartFas" style="max-height:220px;"></canvas>
        </div>
    </div>
</div>

<!-- ── ROW 3: Rating dist + GIS Radius + Completeness ───────────── -->
<div class="grid-3">
    <!-- Rating distribusi -->
    <div class="card">
        <div class="chart-wrap" style="padding-bottom:14px;">
            <div class="sec-title"><span>⭐</span> Distribusi Rating</div>
            <?php
                $ratingRows = [
                    ['label'=>'★★★★★ (4.5+)', 'val'=>(int)$rd['bintang5'], 'color'=>'#f5c842'],
                    ['label'=>'★★★★☆ (3.5–4.5)', 'val'=>(int)$rd['bintang4'], 'color'=>'#e67e22'],
                    ['label'=>'★★★☆☆ (2.5–3.5)', 'val'=>(int)$rd['bintang3'], 'color'=>'#A97142'],
                    ['label'=>'★★☆☆☆ (1.5–2.5)', 'val'=>(int)$rd['bintang2'], 'color'=>'#c0784a'],
                    ['label'=>'★☆☆☆☆ (<1.5)',   'val'=>(int)$rd['bintang1'], 'color'=>'#dc3545'],
                    ['label'=>'Belum diisi',       'val'=>(int)$rd['tanpa_rating'], 'color'=>'#dee2e6'],
                ];
                $rdMaxVal = max(array_column($ratingRows,'val') ?: [1]) ?: 1;
            ?>
            <?php foreach ($ratingRows as $r): ?>
            <div class="rating-row">
                <div class="r-stars" style="color:<?= $r['color'] ?>;font-size:.7rem;"><?= $r['label'] ?></div>
                <div class="r-bar">
                    <div class="r-fill" style="width:<?= round($r['val']/$rdMaxVal*100) ?>%;background:<?= $r['color'] ?>;"></div>
                </div>
                <div class="r-count"><?= $r['val'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- GIS Radius stats -->
    <div class="card">
        <div class="sec-title" style="padding:18px 18px 0;"><span>🗺️</span> Monitoring GIS Radius</div>
        <div class="radius-grid">
            <div class="radius-card" style="background:#e8f5e9;">
                <div class="radius-val" style="color:#1a6e35;"><?= $radiusStats['radius_500m'] ?? 0 ?></div>
                <div class="radius-lbl">Tempat</div>
                <div class="radius-sub">≤ 500 m</div>
            </div>
            <div class="radius-card" style="background:#fff3cd;">
                <div class="radius-val" style="color:#856404;"><?= $radiusStats['radius_1km'] ?? 0 ?></div>
                <div class="radius-lbl">Tempat</div>
                <div class="radius-sub">≤ 1 KM</div>
            </div>
            <div class="radius-card" style="background:#cce5ff;">
                <div class="radius-val" style="color:#003d82;"><?= $radiusStats['radius_2km'] ?? 0 ?></div>
                <div class="radius-lbl">Tempat</div>
                <div class="radius-sub">≤ 2 KM</div>
            </div>
        </div>
        <div>
            <div class="gis-row">
                <span class="gis-label">📍 Punya Koordinat</span>
                <div class="gis-bar">
                    <div class="gis-bar-fill" style="width:<?= $total > 0 ? round(($radiusStats['punya_koordinat']??0)/$total*100) : 0 ?>%;"></div>
                </div>
                <span class="gis-val"><?= $radiusStats['punya_koordinat'] ?? 0 ?></span>
            </div>
            <div class="gis-row">
                <span class="gis-label">❌ Tanpa Koordinat</span>
                <div class="gis-bar">
                    <div class="gis-bar-fill" style="width:<?= $total > 0 ? round(($radiusStats['tanpa_koordinat']??0)/$total*100) : 0 ?>%;background:linear-gradient(to right,#dc3545,#a71c27);"></div>
                </div>
                <span class="gis-val"><?= $radiusStats['tanpa_koordinat'] ?? 0 ?></span>
            </div>
            <div class="gis-row">
                <span class="gis-label">📏 Rata-rata Jarak</span>
                <span class="gis-val"><?= $radiusStats['avg_jarak_km'] ?? '-' ?> km</span>
            </div>
        </div>
    </div>

    <!-- Data completeness -->
    <div class="card">
        <div class="sec-title" style="padding:18px 18px 0;"><span>📋</span> Kelengkapan Data</div>
        <div style="padding-top:10px;">
            <?php
                $completes = [
                    ['lbl'=>'📍 Koordinat GIS', 'pct'=>$pctKoord,
                     'color'=>$pctKoord>=80?'#28a745':($pctKoord>=50?'#ffc107':'#dc3545')],
                    ['lbl'=>'🖼️ Foto Tempat',   'pct'=>$pctFoto,
                     'color'=>$pctFoto>=80?'#28a745':($pctFoto>=50?'#ffc107':'#dc3545')],
                    ['lbl'=>'💰 Info Harga',    'pct'=>$pctHarga,
                     'color'=>$pctHarga>=80?'#28a745':($pctHarga>=50?'#ffc107':'#dc3545')],
                    ['lbl'=>'✅ Status Aktif',  'pct'=>$pctAktif,
                     'color'=>$pctAktif>=80?'#28a745':($pctAktif>=50?'#ffc107':'#dc3545')],
                    ['lbl'=>'⭐ Punya Rating',  'pct'=>round((($total-($rd['tanpa_rating']??0))/$total)*100),
                     'color'=>'#A97142'],
                ];
            ?>
            <?php foreach ($completes as $c): ?>
            <div class="complete-row">
                <div class="complete-lbl"><?= $c['lbl'] ?></div>
                <div class="complete-bar">
                    <div class="complete-fill" style="width:<?= $c['pct'] ?>%;background:<?= $c['color'] ?>;"></div>
                </div>
                <div class="complete-pct" style="color:<?= $c['color'] ?>;"><?= $c['pct'] ?>%</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ── ROW 4: Tabel recent + Review terbaru ──────────────────────── -->
<div class="grid-65">
    <!-- Tabel tempat terbaru -->
    <div>
        <div class="sec-title"><span>🕐</span> Tempat Terbaru</div>
        <div class="card" style="overflow:hidden;">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th><th>Kategori</th><th>Rating</th><th>Status</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentTempat as $t): ?>
                    <?php $a = ($t['is_active'] === true || $t['is_active'] === 't' || $t['is_active'] == 1); ?>
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:.85rem;"><?= esc($t['nama']) ?></div>
                            <div style="font-size:.7rem;color:#bbb;"><?= esc(substr($t['alamat']??'',0,38)) ?></div>
                        </td>
                        <td><span class="kat-chip"><?= esc($t['kategori_icon']??'📍') ?> <?= esc($t['kategori']??'-') ?></span></td>
                        <td>
                            <?php if ($t['rating']): ?>
                            <span style="color:#f5c842;font-weight:700;">★</span>
                            <span style="font-weight:600;"><?= $t['rating'] ?></span>
                            <?php else: ?><span style="color:#ddd;">–</span><?php endif; ?>
                        </td>
                        <td><span class="<?= $a ? 'badge-a' : 'badge-n' ?>"><?= $a ? 'Aktif' : 'Nonaktif' ?></span></td>
                        <td><a href="/admin/tempat/edit/<?= $t['id'] ?>" style="color:#A97142;font-size:.75rem;font-weight:700;text-decoration:none;">Edit →</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="padding:12px 16px;border-top:1px solid #f0e4d4;">
                <a href="/admin/tempat" style="color:#A97142;font-size:.78rem;font-weight:700;text-decoration:none;">
                    Lihat semua <?= $stats['total_tempat'] ?? 0 ?> tempat →
                </a>
            </div>
        </div>
    </div>

    <!-- Review terbaru -->
<div>
    <div class="sec-title"><span>💬</span> Review Terbaru</div>
    <div class="card">
        <?php if (!empty($recentReview)): ?>
            <?php foreach ($recentReview as $rv): ?>
                <?php
                    $visible = $rv['is_visible'] === true 
                        || $rv['is_visible'] === 't' 
                        || $rv['is_visible'] == 1;
                ?>

                <div class="review-item">
                    <div class="rv-head">
                        <span class="rv-nama">
                            <?= esc($rv['nama_reviewer'] ?? 'Anonim') ?>
                        </span>

                        <span class="rv-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?= $i <= (int)$rv['rating'] ? '★' : '☆' ?>
                            <?php endfor; ?>
                        </span>
                    </div>

                    <div class="rv-tempat">
                        📍 <?= esc($rv['tempat_nama'] ?? '-') ?>
                    </div>

                    <?php if (!empty($rv['komentar'])): ?>
                        <div class="rv-komen">
                            "<?= esc(substr($rv['komentar'], 0, 80)) . (strlen($rv['komentar']) > 80 ? '…' : '') ?>"
                        </div>
                    <?php endif; ?>

                    <div style="display:flex;gap:8px;margin-top:10px;flex-wrap:wrap;">
                        <a href="/admin/review/toggle/<?= $rv['id'] ?>"
                           style="font-size:.72rem;font-weight:700;text-decoration:none;
                                  padding:5px 9px;border-radius:7px;
                                  background:<?= $visible ? '#d4edda' : '#fde8ea' ?>;
                                  color:<?= $visible ? '#1a6e35' : '#9b1a2a' ?>;">
                            <?= $visible ? '✅ Tampil' : '⛔ Disembunyikan' ?>
                        </a>

                        <a href="/admin/review/delete/<?= $rv['id'] ?>"
                           onclick="return confirm('Yakin hapus review ini?')"
                           style="font-size:.72rem;font-weight:700;text-decoration:none;
                                  padding:5px 9px;border-radius:7px;
                                  background:#fde8ea;color:#9b1a2a;">
                            🗑 Hapus
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <div style="padding:12px 16px;border-top:1px solid #f0e4d4;">
                <a href="/admin/review"
                   style="color:#A97142;font-size:.78rem;font-weight:700;text-decoration:none;">
                    Kelola semua review →
                </a>
            </div>
        <?php else: ?>
            <div style="padding:32px;text-align:center;color:#ccc;">
                <div style="font-size:2rem;margin-bottom:6px;">💬</div>
                Belum ada review
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ── Chart.js ── -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.color = '#888';

// ── Donut Kategori ──────────────────────────────────────────────
new Chart(document.getElementById('chartKat'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($katLabels) ?>,
        datasets: [{
            data: <?= json_encode($katVals) ?>,
            backgroundColor: <?= json_encode(array_slice($katColors, 0, count($katLabels))) ?>,
            borderWidth: 2,
            borderColor: '#fff',
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '62%',
        plugins: {
            legend: {
                position: 'right',
                labels: { boxWidth: 12, padding: 14, font: { size: 12 } }
            },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed} tempat`
                }
            }
        }
    }
});

// ── Bar Fasilitas ───────────────────────────────────────────────
const fasLabels = <?= json_encode($fasLabels) ?>;
const fasVals   = <?= json_encode($fasVals) ?>;
const fasColors = fasVals.map(v => {
    const pct = v / <?= $aktif ?: 1 ?>;
    if (pct >= .7) return '#28a745';
    if (pct >= .4) return '#A97142';
    return '#dc3545';
});

new Chart(document.getElementById('chartFas'), {
    type: 'bar',
    data: {
        labels: fasLabels,
        datasets: [{
            label: 'Jumlah Tempat',
            data: fasVals,
            backgroundColor: fasColors,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        indexAxis: 'y',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.parsed.x} dari <?= $aktif ?> tempat aktif`
                }
            }
        },
        scales: {
            x: {
                grid: { color: '#f0e4d4' },
                max: <?= $aktif ?: 1 ?>,
                ticks: { stepSize: 1 }
            },
            y: { grid: { display: false } }
        }
    }
});
</script>
<?= $this->endSection() ?>