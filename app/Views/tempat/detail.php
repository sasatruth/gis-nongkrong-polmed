<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
    $bool = fn($v) => $v === true || $v === 't' || $v === '1' || $v == 1;
    $t = $tempat;
    // Flash data untuk form
    $formNama     = session()->getFlashdata('form_nama')     ?? '';
    $formKomentar = session()->getFlashdata('form_komentar') ?? '';
    $flashSuccess = session()->getFlashdata('success');
    $flashError   = session()->getFlashdata('error');
?>
<style>
:root {
    --brown:  #7A4E2D;
    --coffee: #A97142;
    --cream:  #F8EFE3;
    --dark:   #2B1B12;
    --gold:   #D4A017;
    --soft:   #EDE0D0;
}
/* ── Hero foto ─────────────────────────────────── */
.detail-hero {
    position: relative;
    height: 380px;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 2rem;
}
.detail-hero img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.detail-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.7) 0%, transparent 55%);
}
.detail-hero-content {
    position: absolute;
    bottom: 28px; left: 32px; right: 32px;
}
.detail-hero-content h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
    text-shadow: 0 2px 8px rgba(0,0,0,.4);
}
.detail-kat-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    color: #fff;
    border-radius: 999px;
    padding: 4px 14px;
    font-size: .78rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
    margin-bottom: 10px;
}
.rating-star {
    color: #f5c842;
    font-size: 1.1rem;
    font-weight: 700;
}
/* ── Info card ─────────────────────────────────── */
.info-card {
    background: #fff;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 2px 16px rgba(122,78,45,.08);
    border: 1px solid #f0e4d4;
    margin-bottom: 1.2rem;
}
.info-row {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--soft);
}
.info-row:last-child { border-bottom: none; padding-bottom: 0; }
.info-icon {
    width: 36px; height: 36px;
    background: var(--soft);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
    margin-top: 1px;
}
.info-label {
    font-size: .73rem;
    color: #aaa;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-bottom: 2px;
}
.info-val {
    font-size: .9rem;
    font-weight: 600;
    color: var(--dark);
}
/* ── Fasilitas grid ────────────────────────────── */
.fas-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}
.fas-item {
    background: var(--soft);
    border-radius: 12px;
    padding: 12px 10px;
    text-align: center;
    font-size: .75rem;
    font-weight: 600;
    color: var(--brown);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    transition: background .15s;
}
.fas-item.active  { background: #d4edda; color: #1a6e35; }
.fas-item.inactive { opacity: .4; filter: grayscale(1); }
.fas-item .fas-icon { font-size: 1.3rem; }
/* ── Mini map ──────────────────────────────────── */
#miniMap {
    height: 220px;
    border-radius: 14px;
    overflow: hidden;
    border: 2px solid var(--soft);
    margin-bottom: 1rem;
}
/* ── Review list ────────────────────────────────── */
.review-item {
    background: var(--soft);
    border-radius: 14px;
    padding: 16px 18px;
    margin-bottom: 12px;
    transition: box-shadow .15s;
}
.review-item:hover { box-shadow: 0 4px 14px rgba(122,78,45,.1); }
.review-item:last-child { margin-bottom: 0; }
.review-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 4px;
}
.review-nama {
    font-weight: 700;
    font-size: .88rem;
    color: var(--dark);
}
.review-rating { color: #f5c842; font-size: .85rem; }
.review-komentar {
    font-size: .82rem;
    color: #555;
    line-height: 1.55;
    margin-top: 6px;
}
.review-date { font-size: .7rem; color: #bbb; margin-top: 6px; }

/* ── Review Form ────────────────────────────────── */
.review-form-card {
    background: #fff;
    border-radius: 20px;
    padding: 28px;
    border: 1.5px solid #f0e4d4;
    box-shadow: 0 4px 24px rgba(122,78,45,.08);
    margin-bottom: 1.4rem;
}
.review-form-card .form-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
/* Star picker */
.star-picker {
    display: flex;
    gap: 6px;
    margin-bottom: 18px;
}
.star-picker input[type="radio"] { display: none; }
.star-picker label {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color .1s, transform .1s;
    line-height: 1;
    user-select: none;
}
.star-picker label:hover,
.star-picker label:hover ~ label,
.star-picker input[type="radio"]:checked ~ label { color: #ddd; }
/* Reverse-order trick: stars flow right-to-left in DOM, displayed LTR */
.star-picker {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
.star-picker label:hover,
.star-picker label:hover ~ label { color: #f5c842; transform: scale(1.15); }
.star-picker input[type="radio"]:checked + label,
.star-picker input[type="radio"]:checked ~ label { color: #f5c842; }
.star-hint {
    font-size: .75rem;
    color: #bbb;
    margin-bottom: 14px;
    font-style: italic;
    min-height: 18px;
    transition: color .15s;
}
/* Form inputs */
.rf-label {
    font-size: .73rem;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-bottom: 6px;
    display: block;
}
.rf-input,
.rf-textarea {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e8d5c0;
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: .87rem;
    color: var(--dark);
    background: #fdf8f3;
    outline: none;
    transition: border-color .15s, background .15s;
    margin-bottom: 14px;
}
.rf-input:focus,
.rf-textarea:focus {
    border-color: var(--coffee);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(169,113,66,.1);
}
.rf-textarea {
    resize: vertical;
    min-height: 90px;
    line-height: 1.55;
}
.rf-input.is-invalid,
.rf-textarea.is-invalid {
    border-color: #dc3545;
    background: #fff5f5;
}
.btn-submit-review {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #A97142, #7A4E2D);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: .88rem;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    box-shadow: 0 3px 10px rgba(122,78,45,.3);
    width: 100%;
    margin-top: 4px;
}
.btn-submit-review:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(122,78,45,.4);
}
.btn-submit-review:active { transform: translateY(0); }
/* Flash alerts */
.alert-custom {
    border-radius: 14px;
    padding: 13px 18px;
    margin-bottom: 16px;
    font-size: .85rem;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideDown .3s ease;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: none; }
}
.alert-success { background: #d4edda; color: #1a6e35; border: 1px solid #b8dfc6; }
.alert-error   { background: #fde8ea; color: #9b1a2a; border: 1px solid #f5c2c7; }
/* ── Rating summary bar ────────────────────────── */
.rating-summary {
    display: flex;
    align-items: center;
    gap: 16px;
    background: var(--cream);
    border-radius: 14px;
    padding: 16px 18px;
    margin-bottom: 16px;
    border: 1px solid #e8d5c0;
}
.rating-big {
    text-align: center;
    flex-shrink: 0;
}
.rating-big .num {
    font-family: 'Syne', sans-serif;
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--dark);
    line-height: 1;
}
.rating-big .stars { color: #f5c842; font-size: 1rem; margin: 4px 0 2px; }
.rating-big .count { font-size: .72rem; color: #bbb; }
.rating-bars { flex: 1; }
.rbar-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}
.rbar-row:last-child { margin-bottom: 0; }
.rbar-lbl { font-size: .7rem; font-weight: 700; color: #bbb; width: 20px; flex-shrink: 0; }
.rbar-track { flex: 1; height: 6px; background: #e8d5c0; border-radius: 3px; overflow: hidden; }
.rbar-fill  { height: 6px; border-radius: 3px; background: linear-gradient(to right, #f5c842, #e67e22); }
.rbar-num  { font-size: .7rem; color: #bbb; width: 18px; text-align: right; }
/* ── Serupa card ───────────────────────────────── */
.serupa-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #f0e4d4;
    box-shadow: 0 2px 10px rgba(122,78,45,.06);
    transition: transform .2s, box-shadow .2s;
    text-decoration: none;
    color: inherit;
    display: block;
}
.serupa-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 26px rgba(122,78,45,.14);
    color: inherit;
}
.serupa-card img { width: 100%; height: 120px; object-fit: cover; }
.serupa-body { padding: 12px 14px; }
.serupa-nama {
    font-weight: 700;
    font-size: .85rem;
    color: var(--dark);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.serupa-sub  { font-size: .72rem; color: #bbb; }
.serupa-price { font-size: .75rem; color: var(--brown); font-weight: 600; margin-top: 4px; }
/* ── Section title ─────────────────────────────── */
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
/* ── Breadcrumb ────────────────────────────────── */
.bc { font-size: .8rem; color: #bbb; margin-bottom: 1rem; }
.bc a { color: var(--coffee); text-decoration: none; }
.bc a:hover { text-decoration: underline; }
/* ── No review placeholder ── */
.no-review {
    text-align: center;
    padding: 36px 20px;
    background: var(--soft);
    border-radius: 16px;
    color: #ccc;
    margin-bottom: 1rem;
}
.no-review .icon { font-size: 2.4rem; margin-bottom: 8px; }
.no-review .msg  { font-size: .85rem; font-weight: 600; color: #bbb; }
</style>

<div class="container-fluid px-4 py-4">
    <!-- Breadcrumb -->
    <div class="bc">
        <a href="/">Home</a> ›
        <a href="/?kat=<?= $t['kategori_id'] ?>"><?= esc($t['kategori'] ?? 'Tempat') ?></a> ›
        <?= esc($t['nama']) ?>
    </div>

    <!-- ── HERO FOTO ── -->
    <div class="detail-hero">
        <img src="<?= esc($t['foto_url'] ?? 'https://placehold.co/1200x380/A97142/fff?text=Foto') ?>"
             alt="<?= esc($t['nama']) ?>">
        <div class="detail-hero-overlay"></div>
        <div class="detail-hero-content">
            <div class="detail-kat-badge">
                <?= esc($t['kategori_icon'] ?? '📍') ?> <?= esc($t['kategori'] ?? '') ?>
            </div>
            <h1><?= esc($t['nama']) ?></h1>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <?php if ($t['rating']): ?>
                <span class="rating-star">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?= $i <= round($t['rating']) ? '★' : '☆' ?>
                    <?php endfor; ?>
                </span>
                <span style="color:#fff;font-size:.9rem;font-weight:600;"><?= $t['rating'] ?> / 5</span>
                <?php endif; ?>
                <?php if ($t['jarak_meter']): ?>
                <span style="color:rgba(255,255,255,.7);font-size:.82rem;">
                    📍 <?= number_format((int)$t['jarak_meter']) ?> m dari Polmed
                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- ── KIRI: Info + Review ── -->
        <div class="col-lg-8">

            <!-- Info utama -->
            <div class="info-card">
                <?php if ($t['deskripsi']): ?>
                <p style="color:#555;font-size:.9rem;line-height:1.7;margin-bottom:16px;
                           padding-bottom:16px;border-bottom:1px solid var(--soft);">
                    <?= esc($t['deskripsi']) ?>
                </p>
                <?php endif; ?>
                <div class="info-row">
                    <div class="info-icon">📍</div>
                    <div>
                        <div class="info-label">Alamat</div>
                        <div class="info-val"><?= esc($t['alamat'] ?? '-') ?></div>
                    </div>
                </div>
                <?php if ($t['jam_buka'] && $t['jam_tutup']): ?>
                <div class="info-row">
                    <div class="info-icon">🕐</div>
                    <div>
                        <div class="info-label">Jam Operasional</div>
                        <div class="info-val"><?= substr($t['jam_buka'],0,5) ?> – <?= substr($t['jam_tutup'],0,5) ?></div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($t['harga_min'] || $t['harga_max']): ?>
                <div class="info-row">
                    <div class="info-icon">💰</div>
                    <div>
                        <div class="info-label">Kisaran Harga</div>
                        <div class="info-val">
                            <?php if ($t['harga_min']): ?>
                                Rp <?= number_format((int)$t['harga_min'],0,',','.') ?>
                                <?php if ($t['harga_max']): ?>
                                    – Rp <?= number_format((int)$t['harga_max'],0,',','.') ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($t['no_telepon']): ?>
                <div class="info-row">
                    <div class="info-icon">📞</div>
                    <div>
                        <div class="info-label">Telepon / WhatsApp</div>
                        <div class="info-val">
                            <a href="https://wa.me/<?= preg_replace('/\D/','',$t['no_telepon']) ?>"
                               target="_blank" style="color:var(--coffee);">
                                <?= esc($t['no_telepon']) ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($t['instagram']): ?>
                <div class="info-row">
                    <div class="info-icon">📸</div>
                    <div>
                        <div class="info-label">Instagram</div>
                        <div class="info-val">
                            <a href="https://instagram.com/<?= ltrim(esc($t['instagram']),'@') ?>"
                               target="_blank" style="color:var(--coffee);">
                                @<?= ltrim(esc($t['instagram']),'@') ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Fasilitas -->
            <div class="info-card">
                <div class="sec-title"><span>🛠️</span> Fasilitas</div>
                <div class="fas-grid">
                    <?php
                        $fasList = [
                            ['icon'=>'📶','label'=>'WiFi',       'key'=>'wifi'],
                            ['icon'=>'🔌','label'=>'Colokan',    'key'=>'colokan'],
                            ['icon'=>'❄️', 'label'=>'AC',         'key'=>'ac'],
                            ['icon'=>'🅿️', 'label'=>'Parkir',     'key'=>'parkir'],
                            ['icon'=>'🕌','label'=>'Mushola',    'key'=>'mushola'],
                            ['icon'=>'🌿','label'=>'Outdoor',    'key'=>'outdoor'],
                            ['icon'=>'🤫','label'=>'Tenang',     'key'=>'tempat_tenang'],
                            ['icon'=>'📚','label'=>'Cocok Nugas','key'=>'cocok_nugas'],
                            ['icon'=>'🎉','label'=>'Cocok Rame', 'key'=>'cocok_rame'],
                        ];
                    ?>
                    <?php foreach ($fasList as $f): ?>
                    <?php $ok = $bool($t[$f['key']] ?? false); ?>
                    <div class="fas-item <?= $ok ? 'active' : 'inactive' ?>">
                        <span class="fas-icon"><?= $f['icon'] ?></span>
                        <span><?= $f['label'] ?></span>
                        <?= $ok
                            ? '<span style="font-size:.65rem;">✅ Ada</span>'
                            : '<span style="font-size:.65rem;">✗ Tidak</span>' ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ══════════════════════════════════════════ -->
            <!-- REVIEW SECTION                            -->
            <!-- ══════════════════════════════════════════ -->
            <div id="reviews">

                <!-- Flash alerts -->
                <?php if ($flashSuccess): ?>
                <div class="alert-custom alert-success">
                    <span style="font-size:1.1rem;">✅</span>
                    <?= esc($flashSuccess) ?>
                </div>
                <?php endif; ?>
                <?php if ($flashError): ?>
                <div class="alert-custom alert-error">
                    <span style="font-size:1.1rem;">⚠️</span>
                    <?= esc($flashError) ?>
                </div>
                <?php endif; ?>

                <div class="sec-title"><span>💬</span> Review & Rating</div>

                <!-- Rating summary -->
                <?php
                    $totalReviews = count($reviews ?? []);
                    $avgRating    = $t['rating'] ? (float)$t['rating'] : 0;
                    // Hitung distribusi dari data reviews
                    $dist = [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
                    foreach ($reviews ?? [] as $rv) {
                        $r = (int)$rv['rating'];
                        if (isset($dist[$r])) $dist[$r]++;
                    }
                    $distMax = max(array_values($dist) ?: [1]) ?: 1;
                ?>
                <?php if ($totalReviews > 0): ?>
                <div class="rating-summary">
                    <div class="rating-big">
                        <div class="num"><?= number_format($avgRating, 1) ?></div>
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?= $i <= round($avgRating) ? '★' : '☆' ?>
                            <?php endfor; ?>
                        </div>
                        <div class="count"><?= $totalReviews ?> ulasan</div>
                    </div>
                    <div class="rating-bars">
                        <?php for ($s = 5; $s >= 1; $s--): ?>
                        <div class="rbar-row">
                            <div class="rbar-lbl"><?= $s ?>★</div>
                            <div class="rbar-track">
                                <div class="rbar-fill"
                                     style="width:<?= round($dist[$s]/$distMax*100) ?>%;"></div>
                            </div>
                            <div class="rbar-num"><?= $dist[$s] ?></div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Daftar review -->
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $rv): ?>
                    <div class="review-item">
                        <div class="review-header">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:36px;height:36px;border-radius:10px;
                                            background:linear-gradient(135deg,#A97142,#7A4E2D);
                                            display:flex;align-items:center;justify-content:center;
                                            color:#fff;font-weight:700;font-size:.9rem;flex-shrink:0;">
                                    <?= mb_strtoupper(mb_substr($rv['nama_reviewer'] ?? 'A', 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="review-nama"><?= esc($rv['nama_reviewer'] ?? 'Anonim') ?></div>
                                    <div class="review-date">
                                        <?= date('d M Y', strtotime($rv['created_at'])) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="review-rating" style="font-size:1rem;">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?= $i <= (int)$rv['rating'] ? '★' : '☆' ?>
                                <?php endfor; ?>
                                <span style="font-size:.78rem;color:#999;font-weight:600;margin-left:2px;">
                                    (<?= $rv['rating'] ?>)
                                </span>
                            </div>
                        </div>
                        <?php if ($rv['komentar']): ?>
                        <div class="review-komentar">"<?= esc($rv['komentar']) ?>"</div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-review">
                        <div class="icon">💬</div>
                        <div class="msg">Belum ada review untuk tempat ini.</div>
                        <div style="font-size:.78rem;color:#ccc;margin-top:4px;">Jadilah yang pertama memberikan ulasan!</div>
                    </div>
                <?php endif; ?>

                <!-- ── FORM TAMBAH REVIEW ── -->
                <div class="review-form-card" id="form-review">
                    <div class="form-title">
                        <span>✍️</span> Tulis Ulasanmu
                    </div>

                    <form action="/tempat/<?= $t['id'] ?>/review" method="POST" id="reviewForm" novalidate>
                        <?= csrf_field() ?>

                        <!-- Star picker -->
                        <label class="rf-label">Rating <span style="color:#dc3545;">*</span></label>
                        <div class="star-picker" id="starPicker">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>">
                            <label for="star<?= $i ?>" title="<?= $i ?> bintang">★</label>
                            <?php endfor; ?>
                        </div>
                        <div class="star-hint" id="starHint">Pilih rating bintang</div>

                        <!-- Nama -->
                        <label class="rf-label" for="nama_reviewer">
                            Nama <span style="color:#dc3545;">*</span>
                        </label>
                        <input type="text"
                               name="nama_reviewer"
                               id="nama_reviewer"
                               class="rf-input <?= $flashError && !$formNama ? 'is-invalid' : '' ?>"
                               placeholder="Nama kamu..."
                               value="<?= esc($formNama) ?>"
                               maxlength="100"
                               autocomplete="name">

                        <!-- Komentar -->
                        <label class="rf-label" for="komentar">Komentar <span style="color:#aaa;font-weight:400;">(opsional)</span></label>
                        <textarea name="komentar"
                                  id="komentar"
                                  class="rf-textarea"
                                  placeholder="Ceritakan pengalamanmu di sini..."
                                  maxlength="1000"><?= esc($formKomentar) ?></textarea>
                        <div style="font-size:.7rem;color:#bbb;margin-top:-10px;margin-bottom:14px;text-align:right;">
                            <span id="charCount">0</span>/1000
                        </div>

                        <button type="submit" class="btn-submit-review" id="submitBtn">
                            <span id="submitText">⭐ Kirim Ulasan</span>
                            <span id="submitSpinner" style="display:none;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                     style="animation:spin .7s linear infinite;">
                                    <circle cx="12" cy="12" r="10" stroke="rgba(255,255,255,.3)" stroke-width="3"/>
                                    <path d="M12 2a10 10 0 0 1 10 10" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                                Mengirim...
                            </span>
                        </button>
                    </form>
                </div>

            </div><!-- /#reviews -->
        </div>

        <!-- ── KANAN: Peta + serupa ── -->
        <div class="col-lg-4">
            <!-- Mini map -->
            <div class="info-card p-0" style="overflow:hidden;border-radius:18px;margin-bottom:1.2rem;">
                <div id="miniMap"></div>
                <div style="padding:14px 16px;display:flex;gap:10px;flex-wrap:wrap;">
                    <a href="/map" class="btn btn-sm"
                       style="background:var(--brown);color:#fff;border-radius:8px;font-size:.78rem;">
                        <i class="bi bi-map"></i> Buka Peta GIS
                    </a>

                    <a href="/map?to=<?= $t['id'] ?>"
                       class="btn btn-sm"
                       style="background:#ffc107;color:#2B1B12;border-radius:8px;font-size:.78rem;font-weight:700;">
                        <i class="bi bi-signpost-split"></i> Go to Map
                    </a>

                    <?php if ($t['latitude'] && $t['longitude']): ?>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $t['latitude'] ?>,<?= $t['longitude'] ?>"
                       target="_blank"
                       class="btn btn-sm btn-outline-secondary"
                       style="border-radius:8px;font-size:.78rem;">
                        <i class="bi bi-signpost-2"></i> Rute Google Maps
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tempat serupa -->
            <?php if (!empty($serupa)): ?>
            <div class="sec-title"><span>🔗</span> Tempat Serupa</div>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($serupa as $s): ?>
                <a href="/tempat/<?= $s['id'] ?>" class="serupa-card">
                    <img src="<?= esc($s['foto_url'] ?? 'https://placehold.co/400x120/A97142/fff?text=Foto') ?>"
                         alt="<?= esc($s['nama']) ?>">
                    <div class="serupa-body">
                        <div class="serupa-nama"><?= esc($s['nama']) ?></div>
                        <div class="serupa-sub">
                            <?= esc($s['kategori_icon'] ?? '📍') ?> <?= esc($s['kategori'] ?? '') ?>
                            <?php if ($s['jarak_meter']): ?>
                                · <?= number_format((int)$s['jarak_meter']) ?> m
                            <?php endif; ?>
                            <?php if ($s['rating']): ?>
                                · ⭐ <?= $s['rating'] ?>
                            <?php endif; ?>
                        </div>
                        <?php if ($s['harga_min']): ?>
                        <div class="serupa-price">
                            Rp <?= number_format((int)$s['harga_min'],0,',','.') ?>
                            <?php if ($s['harga_max']): ?>
                                – <?= number_format((int)$s['harga_max'],0,',','.') ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
<script>
// ── Mini Leaflet map ──────────────────────────────────────────
<?php if ($t['latitude'] && $t['longitude']): ?>
const lat = <?= (float)$t['latitude'] ?>;
const lng = <?= (float)$t['longitude'] ?>;
const miniMap = L.map('miniMap', { zoomControl: false, scrollWheelZoom: false })
                 .setView([lat, lng], 16);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(miniMap);
const cafeIcon = L.divIcon({
    html: `<div style="background:#A97142;color:#fff;border-radius:50%;
                width:36px;height:36px;display:flex;align-items:center;
                justify-content:center;font-size:18px;
                box-shadow:0 2px 8px rgba(0,0,0,.3);">
                <?= esc($t['kategori_icon'] ?? '📍') ?>
           </div>`,
    className: '', iconSize: [36,36], iconAnchor: [18,36]
});
L.marker([lat, lng], { icon: cafeIcon })
 .addTo(miniMap)
 .bindPopup('<b><?= esc($t['nama']) ?></b>').openPopup();
const polmedIcon = L.divIcon({
    html: `<div style="background:#7A4E2D;color:#fff;border-radius:50%;
                width:28px;height:28px;display:flex;align-items:center;
                justify-content:center;font-size:14px;
                box-shadow:0 2px 6px rgba(0,0,0,.25);">🏫</div>`,
    className: '', iconSize: [28,28], iconAnchor: [14,14]
});
L.marker([3.5666, 98.6549], { icon: polmedIcon })
 .addTo(miniMap)
 .bindPopup('<b>Politeknik Negeri Medan</b>');
L.polyline([[lat, lng], [3.5666, 98.6549]], {
    color: '#A97142', weight: 2, dashArray: '6 4', opacity: .6
}).addTo(miniMap);
<?php else: ?>
document.getElementById('miniMap').innerHTML =
    '<div style="height:220px;display:flex;align-items:center;justify-content:center;color:#bbb;">' +
    '📍 Koordinat belum tersedia</div>';
<?php endif; ?>

// ── Star picker hints ─────────────────────────────────────────
const starHints = {
    1: '😞 Sangat buruk',
    2: '😐 Kurang memuaskan',
    3: '😊 Cukup baik',
    4: '😃 Bagus!',
    5: '🤩 Luar biasa!'
};
const starInputs = document.querySelectorAll('.star-picker input[type="radio"]');
const starHintEl = document.getElementById('starHint');
starInputs.forEach(input => {
    input.addEventListener('change', () => {
        const v = parseInt(input.value);
        starHintEl.textContent = starHints[v] || '';
        starHintEl.style.color = '#A97142';
    });
});

// ── Komentar char counter ─────────────────────────────────────
const komentarEl  = document.getElementById('komentar');
const charCountEl = document.getElementById('charCount');
charCountEl.textContent = komentarEl.value.length;
komentarEl.addEventListener('input', () => {
    const len = komentarEl.value.length;
    charCountEl.textContent = len;
    charCountEl.style.color = len > 900 ? '#dc3545' : '#bbb';
});

// ── Form validation + spinner ─────────────────────────────────
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    const nama   = document.getElementById('nama_reviewer').value.trim();
    const rating = document.querySelector('.star-picker input[type="radio"]:checked');

    let valid = true;

    if (!nama) {
        document.getElementById('nama_reviewer').classList.add('is-invalid');
        document.getElementById('nama_reviewer').focus();
        valid = false;
    } else {
        document.getElementById('nama_reviewer').classList.remove('is-invalid');
    }

    if (!rating) {
        starHintEl.textContent = '⚠️ Pilih rating terlebih dahulu';
        starHintEl.style.color = '#dc3545';
        if (valid) document.getElementById('starPicker').scrollIntoView({ behavior: 'smooth', block: 'center' });
        valid = false;
    }

    if (!valid) { e.preventDefault(); return; }

    // Show spinner
    document.getElementById('submitText').style.display   = 'none';
    document.getElementById('submitSpinner').style.display = 'inline-flex';
    document.getElementById('submitBtn').disabled = true;
});

// ── Auto-scroll to review section if flash exists ────────────
<?php if ($flashSuccess || $flashError): ?>
window.addEventListener('load', () => {
    const el = document.getElementById('reviews');
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
});
<?php endif; ?>
</script>
<?= $this->endSection() ?>