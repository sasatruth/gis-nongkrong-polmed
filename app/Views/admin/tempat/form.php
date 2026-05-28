<?= $this->extend('admin/layouts/admin') ?>
<?= $this->section('content') ?>
<?php
    $t    = $tempat;
    $edit = $t !== null;
    $bool = fn($v) => $v === true || $v === 't' || $v === '1' || $v == 1;
    $pageTitle = $edit ? 'Edit Tempat' : 'Tambah Tempat';
?>
<style>
.form-card{background:#fff;border-radius:20px;border:1px solid #e8d5c0;
           box-shadow:0 2px 14px rgba(122,78,45,.07);overflow:hidden;margin-bottom:20px;}
.form-section-header{
    padding:18px 28px;border-bottom:1px solid #f0e4d4;
    display:flex;align-items:center;gap:10px;
}
.form-section-header span{font-size:1.1rem;}
.form-section-header h3{
    font-family:'Syne',sans-serif;font-size:.95rem;font-weight:700;
    color:#2B1B12;margin:0;
}
.form-body{padding:24px 28px;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;}
.form-row.col3{grid-template-columns:1fr 1fr 1fr;}
.form-row.col1{grid-template-columns:1fr;}
.form-group{display:flex;flex-direction:column;gap:6px;}
.form-group label{
    font-size:.73rem;font-weight:700;color:#aaa;
    text-transform:uppercase;letter-spacing:.5px;
}
.form-group input,
.form-group select,
.form-group textarea{
    padding:11px 14px;
    border:1.5px solid #e8d5c0;border-radius:11px;
    font-family:'DM Sans',sans-serif;font-size:.88rem;color:#2B1B12;
    outline:none;background:#fdf8f3;
    transition:all .15s;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{
    border-color:#A97142;background:#fff;
    box-shadow:0 0 0 3px rgba(169,113,66,.1);
}
.form-group textarea{resize:vertical;min-height:90px;}
.form-group input[type="number"]{-moz-appearance:textfield;}

/* Fasilitas toggles */
.fas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px;padding:4px 0;}
.fas-toggle{
    display:flex;align-items:center;gap:10px;
    padding:12px 14px;
    border:1.5px solid #e8d5c0;border-radius:12px;
    cursor:pointer;user-select:none;
    transition:all .15s;background:#fdf8f3;
}
.fas-toggle:hover{border-color:#A97142;background:#fff8f0;}
.fas-toggle input{display:none;}
.fas-toggle.checked{
    background:#d4edda;border-color:#86cfaa;
}
.fas-toggle-icon{font-size:1.2rem;}
.fas-toggle-label{font-size:.8rem;font-weight:600;color:#555;}
.fas-toggle.checked .fas-toggle-label{color:#1a6e35;}
.toggle-dot{
    width:20px;height:20px;border-radius:50%;
    background:#ddd;margin-left:auto;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    font-size:.65rem;transition:background .15s;
}
.fas-toggle.checked .toggle-dot{background:#28a745;color:#fff;}

/* Map picker */
#mapPicker{height:280px;border-radius:12px;overflow:hidden;border:1.5px solid #e8d5c0;margin-top:8px;}
.coord-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px;}

/* Foto preview */
.foto-preview{
    width:100%;height:160px;object-fit:cover;border-radius:12px;
    display:none;margin-top:10px;border:2px solid var(--sf);
}
.foto-preview.show{display:block;}

/* Buttons */
.form-actions{
    display:flex;align-items:center;gap:12px;
    padding:20px 28px;border-top:1px solid #f0e4d4;
}
.btn-save{
    padding:13px 30px;
    background:linear-gradient(135deg,#A97142,#7A4E2D);
    color:#fff;border:none;border-radius:13px;
    font-family:'Syne',sans-serif;font-size:.95rem;font-weight:700;
    cursor:pointer;transition:all .2s;
    box-shadow:0 3px 12px rgba(122,78,45,.3);
    display:inline-flex;align-items:center;gap:8px;
}
.btn-save:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(122,78,45,.4);}
.btn-cancel{
    padding:13px 24px;border:1.5px solid #e8d5c0;border-radius:13px;
    background:#fff;color:#888;font-family:'DM Sans',sans-serif;
    font-size:.9rem;font-weight:600;cursor:pointer;text-decoration:none;
    transition:all .15s;
}
.btn-cancel:hover{border-color:#ccc;color:#555;}

/* Breadcrumb */
.bc{font-size:.78rem;color:#bbb;margin-bottom:18px;}
.bc a{color:#A97142;text-decoration:none;}
</style>

<div class="bc">
    <a href="/admin">Dashboard</a> › <a href="/admin/tempat">Tempat</a> › <?= $edit ? 'Edit' : 'Tambah' ?>
</div>

<form action="<?= $formAction ?>" method="POST" id="mainForm">
    <?= csrf_field() ?>

    <!-- ── Info Dasar ── -->
    <div class="form-card">
        <div class="form-section-header">
            <span>📋</span><h3>Informasi Dasar</h3>
        </div>
        <div class="form-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Tempat *</label>
                    <input type="text" name="nama" required
                           placeholder="e.g. Kopi Kenangan Polmed"
                           value="<?= esc($t['nama'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategoriList as $k): ?>
                        <option value="<?= $k['id'] ?>"
                            <?= ($t['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                            <?= esc($k['icon'].' '.$k['nama']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row col1">
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat"
                           placeholder="Jl. Politeknik No.1, Medan"
                           value="<?= esc($t['alamat'] ?? '') ?>">
                </div>
            </div>
            <div class="form-row col1">
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi"
                              placeholder="Ceritakan sedikit tentang tempat ini…"><?= esc($t['deskripsi'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="form-row col3">
                <div class="form-group">
                    <label>Harga Min (Rp)</label>
                    <input type="number" name="harga_min" min="0" step="500"
                           placeholder="5000"
                           value="<?= esc($t['harga_min'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Harga Max (Rp)</label>
                    <input type="number" name="harga_max" min="0" step="500"
                           placeholder="50000"
                           value="<?= esc($t['harga_max'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Rating (0–5)</label>
                    <input type="number" name="rating" min="0" max="5" step="0.1"
                           placeholder="4.5"
                           value="<?= esc($t['rating'] ?? '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Jam Buka</label>
                    <input type="time" name="jam_buka"
                           value="<?= esc(substr($t['jam_buka'] ?? '', 0, 5)) ?>">
                </div>
                <div class="form-group">
                    <label>Jam Tutup</label>
                    <input type="time" name="jam_tutup"
                           value="<?= esc(substr($t['jam_tutup'] ?? '', 0, 5)) ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>No. Telepon / WhatsApp</label>
                    <input type="text" name="no_telepon"
                           placeholder="08xxxxxxxxxx"
                           value="<?= esc($t['no_telepon'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="instagram"
                           placeholder="@namaakun"
                           value="<?= esc($t['instagram'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- ── Foto ── -->
    <div class="form-card">
        <div class="form-section-header"><span>🖼️</span><h3>Foto</h3></div>
        <div class="form-body">
            <div class="form-group">
                <label>URL Foto</label>
                <input type="url" name="foto_url" id="fotoUrl"
                       placeholder="https://example.com/foto.jpg"
                       value="<?= esc($t['foto_url'] ?? '') ?>"
                       oninput="previewFoto(this.value)">
            </div>
            <img id="fotoPreview" class="foto-preview
                 <?= !empty($t['foto_url']) ? 'show' : '' ?>"
                 src="<?= esc($t['foto_url'] ?? '') ?>"
                 alt="Preview foto">
        </div>
    </div>

    <!-- ── Fasilitas ── -->
    <div class="form-card">
        <div class="form-section-header"><span>🛠️</span><h3>Fasilitas & Karakteristik</h3></div>
        <div class="form-body">
            <div class="fas-grid" id="fasGrid">
                <?php
                    $fasList = [
                        ['key'=>'wifi',         'icon'=>'📶','label'=>'WiFi'],
                        ['key'=>'colokan',      'icon'=>'🔌','label'=>'Colokan'],
                        ['key'=>'ac',           'icon'=>'❄️', 'label'=>'AC'],
                        ['key'=>'parkir',       'icon'=>'🅿️', 'label'=>'Parkir'],
                        ['key'=>'mushola',      'icon'=>'🕌','label'=>'Mushola'],
                        ['key'=>'outdoor',      'icon'=>'🌿','label'=>'Outdoor'],
                        ['key'=>'tempat_tenang','icon'=>'🤫','label'=>'Tempat Tenang'],
                        ['key'=>'cocok_nugas',  'icon'=>'📚','label'=>'Cocok Nugas'],
                        ['key'=>'cocok_rame',   'icon'=>'🎉','label'=>'Cocok Rame'],
                    ];
                    foreach ($fasList as $f):
                        $checked = $bool($t[$f['key']] ?? false);
                ?>
                <label class="fas-toggle <?= $checked ? 'checked' : '' ?>" id="lbl_<?= $f['key'] ?>">
                    <input type="hidden" name="<?= $f['key'] ?>" value="<?= $checked ? '1' : '0' ?>"
                           id="inp_<?= $f['key'] ?>">
                    <span class="fas-toggle-icon"><?= $f['icon'] ?></span>
                    <span class="fas-toggle-label"><?= $f['label'] ?></span>
                    <span class="toggle-dot" id="dot_<?= $f['key'] ?>"><?= $checked ? '✓' : '' ?></span>
                </label>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ── Lokasi ── -->
    <div class="form-card">
        <div class="form-section-header"><span>📍</span><h3>Lokasi (Koordinat)</h3></div>
        <div class="form-body">
            <div style="font-size:.8rem;color:#aaa;margin-bottom:10px;">
                Klik pada peta untuk mengatur lokasi, atau isi manual di bawah.
            </div>
            <div id="mapPicker"></div>
            <div class="coord-row">
                <div class="form-group">
                    <label>Latitude</label>
                    <input type="number" name="latitude" id="latInput"
                           step="0.000001" placeholder="3.5666"
                           value="<?= esc($t['latitude'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Longitude</label>
                    <input type="number" name="longitude" id="lngInput"
                           step="0.000001" placeholder="98.6549"
                           value="<?= esc($t['longitude'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- ── Status ── -->
    <div class="form-card">
        <div class="form-section-header"><span>⚙️</span><h3>Status Publikasi</h3></div>
        <div class="form-body">
            <div class="fas-grid" style="grid-template-columns:repeat(2,1fr);max-width:320px;">
                <?php $aktif = $edit ? $bool($t['is_active'] ?? false) : true; ?>
                <label class="fas-toggle <?= $aktif ? 'checked' : '' ?>" id="lbl_is_active">
                    <input type="hidden" name="is_active" value="<?= $aktif ? '1' : '0' ?>"
                           id="inp_is_active">
                    <span class="fas-toggle-icon">✅</span>
                    <span class="fas-toggle-label">Aktif / Tampil</span>
                    <span class="toggle-dot" id="dot_is_active"><?= $aktif ? '✓' : '' ?></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-save">
            <i class="bi bi-check-lg"></i>
            <?= $edit ? 'Simpan Perubahan' : 'Tambah Tempat' ?>
        </button>
        <a href="/admin/tempat" class="btn-cancel">Batal</a>
    </div>
</form>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// ── Fasilitas toggles ────────────────────────────────────────────
const toggleKeys = ['wifi','colokan','ac','parkir','mushola','outdoor',
                    'tempat_tenang','cocok_nugas','cocok_rame','is_active'];
toggleKeys.forEach(key => {
    const lbl = document.getElementById('lbl_' + key);
    if (!lbl) return;
    lbl.addEventListener('click', () => {
        const inp = document.getElementById('inp_' + key);
        const dot = document.getElementById('dot_' + key);
        const now = inp.value === '1';
        inp.value = now ? '0' : '1';
        lbl.classList.toggle('checked', !now);
        dot.textContent = now ? '' : '✓';
    });
});

// ── Foto preview ────────────────────────────────────────────────
function previewFoto(url) {
    const img = document.getElementById('fotoPreview');
    img.src = url;
    img.classList.toggle('show', !!url);
}

// ── Map picker ───────────────────────────────────────────────────
const POLMED = [3.5666, 98.6549];
const initLat = parseFloat(document.getElementById('latInput').value) || POLMED[0];
const initLng = parseFloat(document.getElementById('lngInput').value) || POLMED[1];

const pickMap = L.map('mapPicker').setView([initLat, initLng], 16);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(pickMap);

// Polmed marker
L.marker(POLMED, {
    icon: L.divIcon({
        html: `<div style="background:#7A4E2D;color:#fff;border-radius:50%;
                    width:28px;height:28px;display:flex;align-items:center;
                    justify-content:center;font-size:14px;">🏫</div>`,
        className: '', iconSize: [28,28], iconAnchor: [14,14]
    })
}).addTo(pickMap).bindPopup('<b>Politeknik Negeri Medan</b>');

let pickMarker = null;

function placeMarker(lat, lng) {
    if (pickMarker) pickMap.removeLayer(pickMarker);
    pickMarker = L.marker([lat, lng], {
        icon: L.divIcon({
            html: `<div style="background:#A97142;color:#fff;border-radius:50%;
                        width:32px;height:32px;display:flex;align-items:center;
                        justify-content:center;font-size:16px;
                        box-shadow:0 2px 8px rgba(0,0,0,.3);">📍</div>`,
            className: '', iconSize: [32,32], iconAnchor: [16,32]
        }),
        draggable: true
    }).addTo(pickMap);
    pickMarker.on('dragend', e => {
        const p = e.target.getLatLng();
        document.getElementById('latInput').value = p.lat.toFixed(6);
        document.getElementById('lngInput').value = p.lng.toFixed(6);
    });
}

if (initLat !== POLMED[0] || initLng !== POLMED[1]) {
    placeMarker(initLat, initLng);
}

pickMap.on('click', e => {
    const { lat, lng } = e.latlng;
    document.getElementById('latInput').value = lat.toFixed(6);
    document.getElementById('lngInput').value = lng.toFixed(6);
    placeMarker(lat, lng);
});

// Sync coord inputs → map
['latInput','lngInput'].forEach(id => {
    document.getElementById(id).addEventListener('change', () => {
        const lat = parseFloat(document.getElementById('latInput').value);
        const lng = parseFloat(document.getElementById('lngInput').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            pickMap.setView([lat, lng], 16);
            placeMarker(lat, lng);
        }
    });
});
</script>
<?= $this->endSection() ?>