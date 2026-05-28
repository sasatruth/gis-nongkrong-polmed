<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css">

<div class="container-fluid py-3 px-4">
    <div class="row g-3">

        <div class="col-lg-3">

            <div class="card card-cafe p-3 mb-3">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-crosshair text-warning"></i>
                    Titik Awal
                </h5>

                <div class="small text-muted mb-2">
                    Default otomatis memakai lokasi kamu sekarang. Bisa juga cari lokasi bebas.
                </div>

                <button class="btn btn-warning w-100 fw-semibold btn-sm mb-2" onclick="useMyLocation()">
                    <i class="bi bi-geo-alt-fill"></i> Gunakan Lokasi Saya
                </button>

                <div class="input-group input-group-sm mb-2">
                    <input type="text" id="startSearchInput" class="form-control"
                           placeholder="Cari titik awal, contoh: USU, Ringroad, Amplas">
                    <button class="btn btn-coklat" onclick="searchStartLocation()">
                        Cari
                    </button>
                </div>

                <div id="startSearchResult" class="small mb-2"></div>

                <div id="startInfo" class="small text-muted">
                    Mencari lokasi kamu...
                </div>
            </div>

            <div class="card card-cafe p-3 mb-3">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-geo-alt-fill text-warning"></i>
                    Filter Radius
                </h5>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-warning fw-semibold" onclick="loadNearby(500)">
                        <i class="bi bi-circle"></i> 500 Meter
                    </button>
                    <button class="btn btn-outline-warning fw-semibold" onclick="loadNearby(1000)">
                        <i class="bi bi-circle"></i> 1 KM
                    </button>
                    <button class="btn btn-outline-warning fw-semibold" onclick="loadNearby(2000)">
                        <i class="bi bi-circle"></i> 2 KM
                    </button>
                    <button class="btn btn-coklat fw-semibold" onclick="loadMarkers()">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset Marker
                    </button>
                </div>
            </div>

            <div class="card card-cafe p-3 mb-3">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-funnel-fill text-warning"></i>
                    Filter Kategori
                </h5>

                <select id="categoryFilter" class="form-select mb-2" onchange="applyCategoryFilter()">
                    <option value="semua">Semua Kategori</option>
                    <option value="Kafe">☕ Kafe / Cafe</option>
                    <option value="Warkop">🍜 Warkop / Warung Makan</option>
                    <option value="Resto">🍽️ Resto / Lounge</option>
                    <option value="Bubble Tea">🧋 Bubble Tea</option>
                    <option value="Bakery">🥐 Bakery & Snack</option>
                    <option value="Outdoor">🌳 Outdoor / Taman</option>
                </select>

                <div class="small text-muted">
                    Filter ini mengikuti hasil marker yang sedang aktif, termasuk hasil radius.
                </div>
            </div>

            <div class="card card-cafe p-3 mb-3">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-signpost-split-fill text-warning"></i>
                    Rute Dinamis
                </h5>

                <select id="destinationSelect" class="form-select mb-2">
                    <option value="">Pilih tempat tujuan...</option>
                </select>

                <button class="btn btn-warning w-100 fw-semibold mb-2" onclick="routeFromSelect()">
                    Buat Rute
                </button>

                <button class="btn btn-outline-danger w-100 fw-semibold" onclick="clearRoute()">
                    Hapus Rute
                </button>

                <div id="routeInfo" class="mt-3 small text-muted">
                    Pilih titik awal dan tujuan, atau klik marker tempat.
                </div>
            </div>

            <div class="card card-cafe p-3 mb-3">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-stars text-warning"></i>
                    Rekomendasi Pintar
                </h5>
                <select id="needSelect" class="form-select mb-2">
                    <option value="nugas">📚 Mau Nugas</option>
                    <option value="hemat">💰 Mau Hemat</option>
                    <option value="wifi_colokan">📶 WiFi + Colokan</option>
                    <option value="tenang">🤫 Tempat Tenang</option>
                    <option value="rame">🎉 Nongkrong Rame-rame</option>
                </select>
                <button class="btn btn-warning w-100 fw-semibold" onclick="loadRecommendation()">
                    Cari Rekomendasi
                </button>
            </div>

            <div class="card card-cafe p-3">
                <h6 class="fw-bold mb-2">
                    <i class="bi bi-list-ul"></i>
                    Hasil
                    <span id="jumlahHasil" class="badge bg-warning text-dark ms-1">0</span>
                </h6>
                <div id="resultList" style="max-height:320px;overflow-y:auto;"></div>
            </div>
        </div>

        <div class="col-lg-9">
            <div id="map" style="height:82vh;border-radius:16px;
                 box-shadow:0 4px 20px rgba(0,0,0,.15);"></div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
const POLMED = [3.5666, 98.6549];

const params = new URLSearchParams(window.location.search);
const autoRouteToId = params.get('to');

let startPoint = null;
let currentData = [];
let rawData = [];
let activeCategory = 'semua';

let watchId = null;
let activeDestination = null;
let autoRouteDone = false;

let startMarker = null;
let routingControl = null;
let straightLine = null;
let radiusCircle = null;

const map = L.map('map').setView(POLMED, 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

const kategoriIcons = {
    'Kafe': '☕',
    'Cafe': '☕',
    'Cafe & Kopi': '☕',
    'Warkop': '🍜',
    'Warung Makan': '🍜',
    'Resto': '🍽️',
    'Resto & Lounge': '🍽️',
    'Taman': '🌳',
    'Outdoor': '🌳',
    'Bubble Tea': '🧋',
    'Bakery & Snack': '🥐'
};

function createKategoriIcon(icon) {
    return L.divIcon({
        html: `
            <div style="
                width:42px;height:42px;border-radius:50%;
                background:#A97142;border:3px solid white;
                display:flex;align-items:center;justify-content:center;
                font-size:20px;box-shadow:0 4px 10px rgba(0,0,0,.25);">
                ${icon}
            </div>
        `,
        className: '',
        iconSize: [42, 42],
        iconAnchor: [21, 42],
        popupAnchor: [0, -42]
    });
}

const polmedIcon = L.divIcon({
    html: `
        <div style="
            width:50px;height:50px;border-radius:50%;
            background:#7A4E2D;border:4px solid white;
            display:flex;align-items:center;justify-content:center;
            font-size:24px;box-shadow:0 4px 14px rgba(0,0,0,.35);">
            🏫
        </div>
    `,
    className: '',
    iconSize: [50, 50],
    iconAnchor: [25, 50],
    popupAnchor: [0, -50]
});

const startIcon = L.divIcon({
    html: `
        <div style="
            width:44px;height:44px;border-radius:50%;
            background:#198754;border:4px solid white;
            display:flex;align-items:center;justify-content:center;
            font-size:20px;box-shadow:0 4px 14px rgba(0,0,0,.35);">
            🚩
        </div>
    `,
    className: '',
    iconSize: [44, 44],
    iconAnchor: [22, 44],
    popupAnchor: [0, -44]
});

L.marker(POLMED, { icon: polmedIcon })
    .addTo(map)
    .bindPopup(`<b>Politeknik Negeri Medan</b><br>Titik referensi kampus`);

function setStartPoint(lat, lng, label = 'Titik Awal', moveMap = true) {
    startPoint = [parseFloat(lat), parseFloat(lng)];

    if (startMarker) {
        startMarker.setLatLng(startPoint);
        startMarker.bindPopup(`<b>${label}</b><br>Rute dan radius dihitung dari titik ini.`);
    } else {
        startMarker = L.marker(startPoint, {
            icon: startIcon,
            draggable: false
        })
        .addTo(map)
        .bindPopup(`<b>${label}</b><br>Rute dan radius dihitung dari titik ini.`);
    }

    document.getElementById('startInfo').innerHTML = `
        <b>Titik awal:</b><br>${label}
    `;

    if (moveMap) {
        map.setView(startPoint, 16);
    }
}

function useMyLocation() {
    if (!navigator.geolocation) {
        document.getElementById('startInfo').innerHTML =
            'Browser tidak mendukung geolocation. Cari lokasi bebas sebagai titik awal.';
        setStartPoint(POLMED[0], POLMED[1], 'Politeknik Negeri Medan');
        tryAutoRouteFromUrl();
        return;
    }

    if (watchId !== null) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
    }

    document.getElementById('startInfo').innerHTML = 'Mengambil lokasi kamu...';

    watchId = navigator.geolocation.watchPosition(
        position => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            setStartPoint(lat, lng, 'Lokasi Saya Saat Ini', !activeDestination);

            if (activeDestination) {
                routeTo(activeDestination, true);
            }

            tryAutoRouteFromUrl();
        },
        error => {
            document.getElementById('startInfo').innerHTML =
                'Lokasi tidak diizinkan. Default diarahkan ke Polmed.';
            setStartPoint(POLMED[0], POLMED[1], 'Politeknik Negeri Medan');
            tryAutoRouteFromUrl();
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

function searchStartLocation() {
    const keyword = document.getElementById('startSearchInput').value.trim();

    if (!keyword) {
        alert('Masukkan nama lokasi dulu.');
        return;
    }

    document.getElementById('startSearchResult').innerHTML =
        '<span class="text-muted">Mencari lokasi...</span>';

    const url = `https://photon.komoot.io/api/?q=${encodeURIComponent(keyword + ' Medan Indonesia')}&limit=6&lat=3.5666&lon=98.6549`;

    fetch(url)
        .then(r => r.json())
        .then(result => {
            const features = result.features || [];

            if (!features.length) {
                document.getElementById('startSearchResult').innerHTML =
                    '<span class="text-danger">Lokasi tidak ditemukan. Coba nama yang lebih spesifik.</span>';
                return;
            }

            let html = '';

            features.forEach((item) => {
                const props = item.properties;
                const coords = item.geometry.coordinates;

                const lng = coords[0];
                const lat = coords[1];

                const label = [
                    props.name,
                    props.street,
                    props.city,
                    props.state,
                    props.country
                ].filter(Boolean).join(', ');

                const safeLabel = label.replace(/'/g, "\\'");

                html += `
                    <div class="card p-2 mb-1"
                         style="cursor:pointer;border-radius:8px;border:1px solid #e8d5c0;"
                         onclick="chooseStartLocation(${lat}, ${lng}, '${safeLabel}')">
                        <div style="font-size:12px;font-weight:700;">
                            ${props.name ?? keyword}
                        </div>
                        <div style="font-size:11px;color:#999;">
                            ${label}
                        </div>
                    </div>
                `;
            });

            document.getElementById('startSearchResult').innerHTML = html;
        })
        .catch(error => {
            console.error(error);
            document.getElementById('startSearchResult').innerHTML =
                '<span class="text-danger">Gagal mencari lokasi.</span>';
        });
}

function chooseStartLocation(lat, lng, label) {
    setStartPoint(lat, lng, label);

    document.getElementById('startInfo').innerHTML = `
        <b>Titik awal:</b><br>${label}
    `;

    document.getElementById('startSearchResult').innerHTML = '';

    tryAutoRouteFromUrl();

    if (activeDestination) {
        routeTo(activeDestination);
    }
}

const legend = L.control({ position: 'topright' });

legend.onAdd = function () {
    const div = L.DomUtil.create('div', 'info legend');

    div.innerHTML = `
        <div style="
            background:white;padding:16px;border-radius:16px;
            box-shadow:0 6px 20px rgba(0,0,0,.15);
            min-width:230px;border:1px solid #eee;">
            <h4 style="margin:0 0 12px;font-size:16px;font-weight:700;color:#2B1B12;">
                LEGENDA GIS
            </h4>

            <div style="display:flex;gap:10px;margin-bottom:8px;"><span>☕</span><span>Kafe / Cafe</span></div>
            <div style="display:flex;gap:10px;margin-bottom:8px;"><span>🍜</span><span>Warkop / Warung Makan</span></div>
            <div style="display:flex;gap:10px;margin-bottom:8px;"><span>🍽️</span><span>Resto / Lounge</span></div>
            <div style="display:flex;gap:10px;margin-bottom:8px;"><span>🧋</span><span>Bubble Tea</span></div>
            <div style="display:flex;gap:10px;margin-bottom:8px;"><span>🥐</span><span>Bakery & Snack</span></div>
            <div style="display:flex;gap:10px;margin-bottom:8px;"><span>🌳</span><span>Outdoor / Taman</span></div>

            <hr>

            <div style="display:flex;gap:10px;margin-bottom:8px;"><span>🏫</span><span>Titik Polmed</span></div>
            <div style="display:flex;gap:10px;"><span>🚩</span><span>Titik Awal User</span></div>
        </div>
    `;

    return div;
};

legend.addTo(map);

let markersLayer = L.layerGroup().addTo(map);

function fasilitasBadge(tempat) {
    let html = '';
    const bool = v => v === true || v === 't' || v === '1' || v === 1;

    if (bool(tempat.wifi))          html += '<span class="badge bg-primary me-1">WiFi</span>';
    if (bool(tempat.colokan))       html += '<span class="badge bg-success me-1">Colokan</span>';
    if (bool(tempat.ac))            html += '<span class="badge bg-info text-dark me-1">AC</span>';
    if (bool(tempat.tempat_tenang)) html += '<span class="badge bg-secondary me-1">Tenang</span>';
    if (bool(tempat.parkir))        html += '<span class="badge bg-warning text-dark me-1">Parkir</span>';
    if (bool(tempat.mushola))       html += '<span class="badge bg-light text-dark me-1">Mushola</span>';

    return html || '<span class="text-muted small">-</span>';
}

function matchCategory(tempat, selected) {
    const kategori = (tempat.kategori || '').toLowerCase();

    if (selected === 'semua') return true;

    if (selected === 'Kafe') {
        return kategori.includes('kafe') || kategori.includes('cafe') || kategori.includes('kopi');
    }

    if (selected === 'Warkop') {
        return kategori.includes('warkop') || kategori.includes('warung') || kategori.includes('makan');
    }

    if (selected === 'Resto') {
        return kategori.includes('resto') || kategori.includes('lounge');
    }

    if (selected === 'Bubble Tea') {
        return kategori.includes('bubble');
    }

    if (selected === 'Bakery') {
        return kategori.includes('bakery') || kategori.includes('snack');
    }

    if (selected === 'Outdoor') {
        return kategori.includes('outdoor') || kategori.includes('taman');
    }

    return true;
}

function applyCategoryFilter() {
    activeCategory = document.getElementById('categoryFilter').value || 'semua';

    const filteredData = rawData.filter(tempat => {
        return matchCategory(tempat, activeCategory);
    });

    drawMarkerData(filteredData);
}

function renderMarkers(data) {
    rawData = data;
    applyCategoryFilter();
}

function drawMarkerData(data) {
    currentData = data;
    markersLayer.clearLayers();

    document.getElementById('jumlahHasil').textContent = data.length;

    let listHtml = '';
    let selectHtml = '<option value="">Pilih tempat tujuan...</option>';

    data.forEach(tempat => {
        const lat = parseFloat(tempat.latitude);
        const lng = parseFloat(tempat.longitude);

        if (isNaN(lat) || isNaN(lng)) return;

        selectHtml += `<option value="${tempat.id}">${tempat.nama}</option>`;

        const icon = createKategoriIcon(
            tempat.kategori_icon || kategoriIcons[tempat.kategori] || '📍'
        );

        const marker = L.marker([lat, lng], { icon });

        marker.bindPopup(`
            <div style="min-width:220px">
                <img src="${tempat.foto_url ?? 'https://placehold.co/300x150'}"
                     style="width:100%;height:120px;object-fit:cover;
                            border-radius:8px;margin-bottom:8px;">
                <b style="font-size:15px">${tempat.nama}</b><br>
                <small class="text-muted">${tempat.alamat ?? ''}</small><br><br>

                <span class="badge bg-warning text-dark me-1">${tempat.kategori ?? '-'}</span>
                <span class="badge bg-danger me-1">⭐ ${tempat.rating ?? '-'}</span>
                ${tempat.jarak_meter ? `<span class="badge bg-dark">${tempat.jarak_meter} m</span>` : ''}

                <br><br>
                ${fasilitasBadge(tempat)}
                <br><br>

                <button class="btn btn-sm btn-success w-100 mb-1"
                        onclick="routeTo(${tempat.id})">
                    Buat Rute ke Sini
                </button>

                <a href="/tempat/${tempat.id}" class="btn btn-sm btn-warning w-100">
                   Lihat Detail
                </a>
            </div>
        `);

        marker.on('click', () => routeTo(tempat.id));
        marker.addTo(markersLayer);

        listHtml += `
            <div class="card mb-2 p-2" style="border-radius:10px;cursor:pointer;border:1px solid #e8d5c0;"
                 onclick="routeTo(${tempat.id})">
                <div class="fw-semibold" style="font-size:13px">${tempat.nama}</div>
                <div class="text-muted" style="font-size:11px">
                    ${tempat.kategori ?? '-'}
                    ${tempat.jarak_meter ? '· ' + tempat.jarak_meter + ' m' : ''}
                </div>
                <div class="mt-1">${fasilitasBadge(tempat)}</div>
            </div>
        `;
    });

    document.getElementById('destinationSelect').innerHTML = selectHtml;

    document.getElementById('resultList').innerHTML =
        listHtml || '<p class="text-muted small">Tidak ada hasil.</p>';

    tryAutoRouteFromUrl();
}

function tryAutoRouteFromUrl() {
    if (autoRouteDone) return;
    if (!autoRouteToId) return;
    if (!startPoint) return;
    if (!currentData.length) return;

    const target = currentData.find(x => parseInt(x.id) === parseInt(autoRouteToId));

    if (!target) return;

    autoRouteDone = true;

    document.getElementById('destinationSelect').value = autoRouteToId;

    setTimeout(() => {
        routeTo(parseInt(autoRouteToId));
    }, 500);
}

function clearRadius() {
    if (radiusCircle) {
        map.removeLayer(radiusCircle);
        radiusCircle = null;
    }
}

function clearRoute(resetDestination = true) {
    if (resetDestination) {
        activeDestination = null;
    }

    if (routingControl) {
        map.removeControl(routingControl);
        routingControl = null;
    }

    if (straightLine) {
        map.removeLayer(straightLine);
        straightLine = null;
    }

    document.getElementById('routeInfo').innerHTML =
        'Pilih titik awal dan tujuan, atau klik marker tempat.';
}

function routeFromSelect() {
    const id = document.getElementById('destinationSelect').value;

    if (!startPoint) {
        alert('Tentukan titik awal dulu.');
        return;
    }

    if (!id) {
        alert('Pilih tujuan dulu.');
        return;
    }

    routeTo(parseInt(id));
}

function routeTo(id, silent = false) {
    activeDestination = id;

    if (!startPoint) {
        alert('Tentukan titik awal dulu.');
        return;
    }

    const tempat = currentData.find(x => parseInt(x.id) === parseInt(id));
    if (!tempat) return;

    const lat = parseFloat(tempat.latitude);
    const lng = parseFloat(tempat.longitude);

    if (isNaN(lat) || isNaN(lng)) return;

    clearRoute(false);

    const start = L.latLng(startPoint[0], startPoint[1]);
    const end   = L.latLng(lat, lng);

    if (!silent) {
        document.getElementById('routeInfo').innerHTML = `
            <b>Tujuan:</b> ${tempat.nama}<br>
            <span class="text-muted">Menghitung rute jalan...</span>
        `;
    }

    if (L.Routing) {
        routingControl = L.Routing.control({
            waypoints: [start, end],
            routeWhileDragging: false,
            addWaypoints: false,
            draggableWaypoints: false,
            fitSelectedRoutes: !silent,
            show: false,
            createMarker: function() { return null; },
            lineOptions: {
                styles: [
                    { color: '#7A4E2D', opacity: 0.95, weight: 7 }
                ]
            }
        }).addTo(map);

        routingControl.on('routesfound', function(e) {
            const route = e.routes[0];
            const distanceKm = (route.summary.totalDistance / 1000).toFixed(2);
            const timeMin = Math.round(route.summary.totalTime / 60);

            document.getElementById('routeInfo').innerHTML = `
                <b>Tujuan:</b> ${tempat.nama}<br>
                <b>Jarak rute:</b> ${distanceKm} km<br>
                <b>Estimasi:</b> ${timeMin} menit<br>
                <span class="text-muted">Rute diperbarui otomatis mengikuti lokasi kamu.</span>
            `;
        });

        routingControl.on('routingerror', function() {
            drawStraightLine(start, end, tempat, silent);
        });
    } else {
        drawStraightLine(start, end, tempat, silent);
    }
}

function drawStraightLine(start, end, tempat, silent = false) {
    clearRoute(false);

    straightLine = L.polyline([start, end], {
        color: '#7A4E2D',
        weight: 7,
        dashArray: '10 8',
        opacity: 0.95
    }).addTo(map);

    const distanceMeter = map.distance(start, end);
    const distanceKm = (distanceMeter / 1000).toFixed(2);

    if (!silent) {
        map.fitBounds(straightLine.getBounds(), { padding: [40, 40] });
    }

    document.getElementById('routeInfo').innerHTML = `
        <b>Tujuan:</b> ${tempat.nama}<br>
        <b>Jarak garis lurus:</b> ${distanceKm} km<br>
        <span class="text-muted">Fallback polyline karena rute jalan gagal dimuat.</span>
    `;
}

function loadMarkers() {
    clearRadius();
    clearRoute();

    fetch('/api/markers')
        .then(r => r.json())
        .then(r => renderMarkers(r.data))
        .catch(e => console.error('loadMarkers:', e));
}

function loadNearby(radius) {
    if (!startPoint) {
        alert('Tunggu lokasi kamu terbaca atau pilih titik awal dulu.');
        return;
    }

    clearRadius();
    clearRoute();

    radiusCircle = L.circle(startPoint, {
        radius,
        color: '#A97142',
        fillColor: '#A97142',
        fillOpacity: 0.10,
        weight: 2
    }).addTo(map);

    map.fitBounds(radiusCircle.getBounds());

    const lat = startPoint[0];
    const lng = startPoint[1];

    fetch(`/api/nearby?lat=${lat}&lng=${lng}&radius=${radius}`)
        .then(r => r.json())
        .then(r => renderMarkers(r.data))
        .catch(e => console.error('loadNearby:', e));
}

function loadRecommendation() {
    clearRadius();
    clearRoute();

    const need = document.getElementById('needSelect').value;

    fetch(`/api/recommendation?need=${need}`)
        .then(r => r.json())
        .then(r => renderMarkers(r.data))
        .catch(e => console.error('loadRecommendation:', e));
}

document.getElementById('startSearchInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchStartLocation();
    }
});

loadMarkers();
useMyLocation();
</script>

<?= $this->endSection() ?>