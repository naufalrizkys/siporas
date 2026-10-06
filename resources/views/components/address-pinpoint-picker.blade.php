@props([
    'latitude' => null,
    'longitude' => null,
    'latName' => 'latitude',
    'lngName' => 'longitude',
    'alamatId' => 'alamat_sekretariat',
    'rtId' => null,
    'kelurahanId' => 'kelurahan',
    'kecamatanId' => 'kecamatan',
    'kotaId' => 'kota',
    'provinsiId' => 'provinsi',
    'mapId' => 'shopee_map_picker',
    'title' => 'Pin Point Penempatan Alamat Kantor',
    'subtitle' => 'Klik pada peta atau geser penanda merah untuk menyimpan titik lokasi presisi',
])

@php
    $defaultLat = $latitude ? (float)$latitude : -7.0867;
    $defaultLng = $longitude ? (float)$longitude : 110.9167;
    $hasInitialCoords = !empty($latitude) && !empty($longitude);
@endphp

<div class="shopee-pinpoint-wrapper border border-gray-200 rounded-xl bg-white p-4 shadow-sm my-4">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Hidden Inputs --}}
    <input type="hidden" name="{{ $latName }}" id="input_{{ $latName }}_{{ $mapId }}" value="{{ old($latName, $latitude) }}">
    <input type="hidden" name="{{ $lngName }}" id="input_{{ $lngName }}_{{ $mapId }}" value="{{ old($lngName, $longitude) }}">

    {{-- Header --}}
    <div class="flex items-center gap-2.5 mb-3 pb-3 border-b border-gray-100">
        <div class="w-9 h-9 rounded-full bg-red-50 border border-red-200 flex items-center justify-center text-red-600 flex-shrink-0">
            <i class="fas fa-map-marker-alt text-base"></i>
        </div>
        <div>
            <h4 class="font-extrabold text-sm text-gray-900">{{ $title }}</h4>
            <p class="text-xs text-gray-500 font-medium">{{ $subtitle }}</p>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="relative mb-3">
        <div class="flex items-center gap-2">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text"
                       id="search_input_{{ $mapId }}"
                       placeholder="Cari jalan, kelurahan, kecamatan, atau patokan lokasi..."
                       class="w-full text-xs pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-gray-50"
                       onkeydown="if(event.key==='Enter'){ event.preventDefault(); window.pinpointSearch_{{ $mapId }}(); }">
            </div>
            <button type="button"
                    onclick="window.pinpointSearch_{{ $mapId }}()"
                    class="bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold px-4 py-2.5 rounded-lg transition-colors flex items-center gap-1.5 flex-shrink-0">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
        <div id="search_results_{{ $mapId }}" class="hidden absolute z-30 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto text-xs" style="z-index:9999;"></div>
    </div>

    {{-- Map --}}
    <div class="relative rounded-lg overflow-hidden border border-gray-300 mb-3" style="background:#e5e7eb;">
        <div id="{{ $mapId }}" style="height:320px;width:100%;z-index:1;"></div>

        {{-- Toggle Satellite / Normal pojok kanan atas --}}
        <div id="btn_layer_{{ $mapId }}"
             style="position:absolute;top:10px;right:10px;z-index:10;display:flex;border-radius:6px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,.3);border:1.5px solid rgba(0,0,0,.2);">
            <button type="button" id="btn_normal_{{ $mapId }}"
                    onclick="window.pinpointSetLayer_{{ $mapId }}('normal')"
                    style="padding:5px 10px;font-size:11px;font-weight:700;background:#fff;color:#374151;border:none;cursor:pointer;transition:.15s;font-family:inherit;">
                <i class="fas fa-map" style="margin-right:3px;"></i>Peta
            </button>
            <button type="button" id="btn_satellite_{{ $mapId }}"
                    onclick="window.pinpointSetLayer_{{ $mapId }}('satellite')"
                    style="padding:5px 10px;font-size:11px;font-weight:700;background:#374151;color:#fff;border:none;cursor:pointer;transition:.15s;font-family:inherit;">
                <i class="fas fa-satellite" style="margin-right:3px;"></i>Satelit
            </button>
        </div>

        {{-- Instruksi pojok kiri bawah --}}
        <div style="position:absolute;bottom:8px;left:8px;z-index:10;background:rgba(255,255,255,.92);padding:4px 10px;border-radius:6px;border:1px solid #e5e7eb;font-size:11px;font-weight:600;color:#374151;display:flex;align-items:center;gap:5px;pointer-events:none;">
            <i class="fas fa-hand-pointer" style="color:#dc2626;"></i> Klik atau geser pin untuk menentukan posisi
        </div>

        {{-- Tombol GPS pojok kanan bawah --}}
        <button type="button"
                id="btn_gps_{{ $mapId }}"
                title="Gunakan Lokasi Saat Ini"
                style="position:absolute;bottom:44px;right:10px;z-index:10;width:34px;height:34px;background:#fff;border:2px solid rgba(0,0,0,.25);border-radius:4px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,.2);">
            <i class="fas fa-crosshairs" style="font-size:16px;color:#444;"></i>
        </button>
    </div>

    {{-- Info koordinat --}}
    <div id="pin_card_{{ $mapId }}" class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-xs flex flex-wrap items-center justify-between gap-2">
        <div class="flex items-start gap-2">
            <i class="fas fa-map-pin text-red-600 text-sm mt-0.5 flex-shrink-0"></i>
            <div>
                <div class="font-bold text-gray-900 flex items-center gap-2">
                    <span id="pin_status_{{ $mapId }}">{{ $hasInitialCoords ? 'Lokasi Terpasang' : 'Belum Ditandai' }}</span>
                    <span id="pin_coords_{{ $mapId }}" class="font-mono text-[10px] bg-gray-200 text-gray-700 px-2 py-0.5 rounded">
                        {{ $hasInitialCoords ? number_format($defaultLat, 6).', '.number_format($defaultLng, 6) : 'Pilih titik di peta' }}
                    </span>
                </div>
                <div id="pin_address_{{ $mapId }}" class="text-gray-500 text-[11px] mt-0.5 italic">
                    {{ $hasInitialCoords ? 'Koordinat tersimpan.' : 'Klik peta atau gunakan GPS untuk menandai lokasi.' }}
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="window.pinpointUpdateAddr_{{ $mapId }}()"
                    style="font-size:11px;font-weight:700;color:#b91c1c;background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:4px;padding:0;">
                <i class="fas fa-sync-alt" style="font-size:10px;"></i> Perbarui Alamat
            </button>
            <span style="color:#d1d5db;">|</span>
            <button type="button"
                    id="btn_save_{{ $mapId }}"
                    onclick="window.pinpointSave_{{ $mapId }}()"
                    style="font-size:11px;font-weight:700;color:#fff;background:#991b1b;border:none;border-radius:6px;cursor:pointer;display:flex;align-items:center;gap:5px;padding:5px 12px;transition:background .15s;"
                    onmouseover="this.style.background='#7f1d1d'"
                    onmouseout="this.style.background='#991b1b'">
                <i class="fas fa-save" style="font-size:10px;"></i> Simpan Lokasi
            </button>
        </div>
    </div>

    {{-- Badge lokasi tersimpan (tersembunyi sampai Simpan diklik) --}}
    <div id="pin_saved_badge_{{ $mapId }}" style="display:none;margin-top:8px;background:#f0fdf4;border:1.5px solid #86efac;border-radius:8px;padding:8px 14px;font-size:12px;font-weight:600;color:#166534;display:none;align-items:center;gap:8px;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;"></i>
        <span>Lokasi berhasil disimpan — </span>
        <span id="pin_saved_addr_{{ $mapId }}" style="font-weight:400;font-style:italic;color:#166534;"></span>
    </div>
</div>

<script>
(function () {
    const MAP_ID    = '{{ $mapId }}';
    const LAT_ID    = 'input_{{ $latName }}_{{ $mapId }}';
    const LNG_ID    = 'input_{{ $lngName }}_{{ $mapId }}';
    const ALAMAT_ID = '{{ $alamatId }}';
    const RT_ID     = '{{ $rtId }}';
    const KEL_ID    = '{{ $kelurahanId }}';
    const KEC_ID    = '{{ $kecamatanId }}';
    const KOTA_ID   = '{{ $kotaId }}';
    const PROV_ID   = '{{ $provinsiId }}';

    let map, marker;

    const defaultLat  = {{ $defaultLat }};
    const defaultLng  = {{ $defaultLng }};
    const hasInitial  = {{ $hasInitialCoords ? 'true' : 'false' }};

    // ── Tile layers ───────────────────────────────────────────────
    const TILES = {
        normal: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors',
        }),
        satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: '&copy; Esri &mdash; Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP',
        }),
    };

    let currentLayer = 'normal';

    window['pinpointSetLayer_' + MAP_ID] = function (type) {
        if (type === currentLayer || !map) { return; }

        TILES[currentLayer].remove();
        TILES[type].addTo(map);
        currentLayer = type;

        const btnNormal    = document.getElementById('btn_normal_'    + MAP_ID);
        const btnSatellite = document.getElementById('btn_satellite_' + MAP_ID);

        if (type === 'satellite') {
            btnSatellite.style.background = '#374151';
            btnSatellite.style.color      = '#fff';
            btnNormal.style.background    = '#fff';
            btnNormal.style.color         = '#374151';
        } else {
            btnNormal.style.background    = '#374151';
            btnNormal.style.color         = '#fff';
            btnSatellite.style.background = '#fff';
            btnSatellite.style.color      = '#374151';
        }
    };

    // ── Icon pin merah ────────────────────────────────────────────
    function makeIcon() {
        return L.divIcon({
            className: '',
            html: `<div style="position:relative;width:28px;height:38px;">
                <div style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:12px;height:5px;background:rgba(0,0,0,.25);border-radius:50%;filter:blur(1px);"></div>
                <div style="position:absolute;top:0;left:0;width:28px;height:28px;background:linear-gradient(135deg,#ef4444,#b91c1c);border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:2px solid #fff;box-shadow:0 2px 8px rgba(185,28,28,.4);display:flex;align-items:center;justify-content:center;">
                    <div style="width:8px;height:8px;background:#fff;border-radius:50%;transform:rotate(45deg);"></div>
                </div>
            </div>`,
            iconSize: [28, 38],
            iconAnchor: [14, 38],
            popupAnchor: [0, -38],
        });
    }

    function initMap() {
        const container = document.getElementById(MAP_ID);
        if (!container || container._leaflet_id) { return; }

        map = L.map(MAP_ID, {
            center: [defaultLat, defaultLng],
            zoom: hasInitial ? 16 : 14,
            zoomControl: true,
        });

        TILES[currentLayer].addTo(map);

        // Set state tombol awal
        const btnN = document.getElementById('btn_normal_'    + MAP_ID);
        const btnS = document.getElementById('btn_satellite_' + MAP_ID);
        if (btnN && btnS) {
            btnN.style.background = '#374151'; btnN.style.color = '#fff';
            btnS.style.background = '#fff';    btnS.style.color = '#374151';
        }

        if (hasInitial) {
            marker = L.marker([defaultLat, defaultLng], { icon: makeIcon(), draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                const p = e.target.getLatLng();
                setPin(p.lat, p.lng, true);
            });
        }

        map.on('click', function (e) {
            setPin(e.latlng.lat, e.latlng.lng, true);
        });

        // Fix tile rendering ketika kontainer muncul dari display:none atau di-resize
        setTimeout(function () { map.invalidateSize(); }, 300);

        if (window.ResizeObserver) {
            const ro = new ResizeObserver(function () {
                if (map) { map.invalidateSize(); }
            });
            ro.observe(container);
        }

        if (window.IntersectionObserver) {
            const io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting && map) {
                        setTimeout(function () { map.invalidateSize(); }, 100);
                    }
                });
            });
            io.observe(container);
        }

        window.addEventListener('resize', function () {
            if (map) { map.invalidateSize(); }
        });

        // GPS button
        const gpsBtn = document.getElementById('btn_gps_' + MAP_ID);
        if (gpsBtn) {
            gpsBtn.addEventListener('click', handleGps);
        }

        // Tutup dropdown search saat klik di luar
        document.addEventListener('click', function (e) {
            const box = document.getElementById('search_results_' + MAP_ID);
            const inp = document.getElementById('search_input_' + MAP_ID);
            if (box && !box.contains(e.target) && e.target !== inp) {
                box.classList.add('hidden');
            }
        });
    }

    // ── Set pin + simpan koordinat ────────────────────────────────
    function setPin(lat, lng, fetchAddr) {
        lat = parseFloat(lat);
        lng = parseFloat(lng);

        document.getElementById(LAT_ID).value = lat.toFixed(8);
        document.getElementById(LNG_ID).value = lng.toFixed(8);

        document.getElementById('pin_status_' + MAP_ID).innerText = 'Lokasi Terpasang';
        document.getElementById('pin_coords_' + MAP_ID).innerText =
            lat.toFixed(6) + ', ' + lng.toFixed(6);

        const card = document.getElementById('pin_card_' + MAP_ID);
        card.style.background = '#fff5f5';
        card.style.borderColor = '#fca5a5';

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { icon: makeIcon(), draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                const p = e.target.getLatLng();
                setPin(p.lat, p.lng, true);
            });
        }

        // Pusatkan peta ke koordinat
        map.setView([lat, lng], map.getZoom() < 15 ? 16 : map.getZoom());

        if (fetchAddr) { reverseGeocode(lat, lng); }
    }

    // ── GPS ───────────────────────────────────────────────────────
    function handleGps() {
        if (!navigator.geolocation) {
            showNotice('Browser tidak mendukung fitur GPS.', 'warn');
            return;
        }

        const btn = document.getElementById('btn_gps_' + MAP_ID);
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="font-size:14px;color:#dc2626;"></i>';
        btn.disabled  = true;

        function onOk(pos) {
            btn.innerHTML = '<i class="fas fa-crosshairs" style="font-size:16px;color:#444;"></i>';
            btn.disabled  = false;
            // Zoom ke 17 dulu, lalu setPin agar setView tidak override
            map.setZoom(17);
            setPin(pos.coords.latitude, pos.coords.longitude, true);
            showNotice('Lokasi GPS berhasil ditemukan!', 'ok');
        }

        function onErr(err) {
            btn.innerHTML = '<i class="fas fa-crosshairs" style="font-size:16px;color:#444;"></i>';
            btn.disabled  = false;
            const msgs = {
                1: 'Izin lokasi ditolak. Aktifkan izin lokasi di pengaturan browser.',
                2: 'Sinyal lokasi tidak tersedia. Gunakan kolom pencarian.',
                3: 'GPS timeout. Gunakan kolom pencarian.',
            };
            showNotice(msgs[err.code] || 'Gagal mengambil lokasi GPS.', 'err');
        }

        navigator.geolocation.getCurrentPosition(onOk, onErr, {
            enableHighAccuracy: true,
            timeout: 12000,
            maximumAge: 0,
        });
    }

    // ── Reverse geocoding ─────────────────────────────────────────
    function reverseGeocode(lat, lng) {
        const el = document.getElementById('pin_address_' + MAP_ID);
        el.innerText = 'Mengambil alamat...';

        // Jalankan kedua API secara paralel
        const nominatimUrl = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat +
            '&lon=' + lng + '&zoom=18&addressdetails=1&accept-language=id';
        const bigdataUrl = 'https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=' + lat +
            '&longitude=' + lng + '&localityLanguage=id';

        Promise.all([
            fetch(nominatimUrl).then(function(r) { return r.json(); }).catch(function() { return {}; }),
            fetch(bigdataUrl).then(function(r) { return r.json(); }).catch(function() { return {}; }),
        ]).then(function(results) {
            const nom = results[0];
            const bdc = results[1];

            // Tampilkan display_name dari Nominatim
            if (nom && nom.display_name) {
                el.innerText = nom.display_name;
            }

            fillForm(nom, bdc);
        }).catch(function() {
            el.innerText = 'Koordinat: ' + lat.toFixed(5) + ', ' + lng.toFixed(5);
        });
    }

    function fillForm(nom, bdc) {
        const nomAddr  = (nom && nom.address) || {};
        const admins   = (bdc && bdc.localityInfo && bdc.localityInfo.administrative) || [];
        const infos    = (bdc && bdc.localityInfo && bdc.localityInfo.informative) || [];

        // Kelurahan — dari Nominatim (paling akurat per titik)
        const kelurahan = nomAddr.village || nomAddr.hamlet || nomAddr.suburb || nomAddr.town || '';

        // Kecamatan — dari BigDataCloud informative (description mengandung "kecamatan")
        const kecObj    = infos.find(function(i) {
            return i.description && i.description.toLowerCase().includes('kecamatan');
        });
        const kecamatan = (kecObj && kecObj.name) || '';

        // Kabupaten — BigDataCloud adminLevel 5
        const kabObj    = admins.find(function(a) { return a.adminLevel === 5; });
        const kota      = (kabObj && kabObj.name) || nomAddr.county || 'Kabupaten Grobogan';

        // Provinsi — BigDataCloud adminLevel 4
        const provObj   = admins.find(function(a) { return a.adminLevel === 4; });
        const provinsi  = (provObj && provObj.name) || nomAddr.state || 'Jawa Tengah';

        const get = function (id) { return id ? document.getElementById(id) : null; };

        if (get(KEL_ID)  && kelurahan)  { get(KEL_ID).value  = kelurahan;  }
        if (get(KEC_ID)  && kecamatan)  { get(KEC_ID).value  = kecamatan;  }
        if (get(KOTA_ID) && kota)       { get(KOTA_ID).value = kota;       }
        if (get(PROV_ID) && provinsi)   { get(PROV_ID).value = provinsi;   }

        // Susun alamat
        const road = nomAddr.road || nomAddr.pedestrian || nomAddr.footway || '';
        if (get(ALAMAT_ID)) {
            const parts = [
                road,
                kelurahan,
                kecamatan ? 'Kec. ' + kecamatan : '',
                kota,
            ].filter(Boolean);
            get(ALAMAT_ID).value = parts.join(', ');
        }

        // Visual feedback hijau
        [KEL_ID, KEC_ID, KOTA_ID, PROV_ID].forEach(function(id) {
            const el = get(id);
            if (!el || !el.value) { return; }
            el.style.borderColor = '#86efac';
            el.style.background  = '#f0fff4';
            setTimeout(function() {
                el.style.borderColor = '';
                el.style.background  = '';
            }, 2000);
        });
    }

    // ── Search ────────────────────────────────────────────────────
    let searchTimer = null;

    // Autocomplete saat mengetik
    const searchInput = document.getElementById('search_input_' + MAP_ID);
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);
            const q = this.value.trim();
            if (q.length < 2) {
                document.getElementById('search_results_' + MAP_ID).classList.add('hidden');
                return;
            }
            searchTimer = setTimeout(function () {
                doSearch(q);
            }, 400);
        });
    }

    function doSearch(rawQ) {
        const box = document.getElementById('search_results_' + MAP_ID);
        // Tambahkan "Grobogan" sebagai konteks jika belum ada kata wilayah
        const keywords = ['grobogan','jawa tengah','semarang','kudus','demak','blora','pati'];
        const lower = rawQ.toLowerCase();
        const hasRegion = keywords.some(function(k){ return lower.includes(k); });
        const q = hasRegion ? rawQ : rawQ + ', Grobogan';

        box.classList.remove('hidden');
        box.innerHTML = '<div style="padding:10px;text-align:center;color:#6b7280;"><i class="fas fa-spinner fa-spin"></i> Mencari...</div>';

        fetch('https://nominatim.openstreetmap.org/search?format=json' +
              '&q=' + encodeURIComponent(q) +
              '&countrycodes=id' +
              '&limit=8' +
              '&accept-language=id' +
              '&addressdetails=1' +
              '&viewbox=110.5,6.7,111.5,7.5' +  // bounding box Kab. Grobogan
              '&bounded=0',                        // 0 = tampilkan luar bbox juga jika kurang hasil
              { headers: { 'Accept-Language': 'id' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data || !data.length) {
                    // Coba ulang tanpa suffix Grobogan
                    if (rawQ !== q) {
                        return fetch('https://nominatim.openstreetmap.org/search?format=json' +
                                     '&q=' + encodeURIComponent(rawQ) +
                                     '&countrycodes=id&limit=8&accept-language=id')
                                .then(function(r){ return r.json(); })
                                .then(function(d){ renderResults(d, box); });
                    }
                    box.innerHTML = '<div style="padding:10px;text-align:center;color:#6b7280;">Lokasi tidak ditemukan. Coba tambahkan nama kecamatan.</div>';
                    return;
                }
                renderResults(data, box);
            })
            .catch(function () {
                box.innerHTML = '<div style="padding:10px;text-align:center;color:#dc2626;">Gagal koneksi. Periksa internet Anda.</div>';
            });
    }

    function renderResults(data, box) {
        if (!data || !data.length) {
            box.innerHTML = '<div style="padding:10px;text-align:center;color:#6b7280;">Lokasi tidak ditemukan.</div>';
            return;
        }
        let html = '<ul style="list-style:none;margin:0;padding:0;">';
        data.forEach(function (item) {
            const name = item.display_name.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
            const shortName = item.display_name.split(',').slice(0, 3).join(',');
            html += '<li style="padding:8px 12px;cursor:pointer;border-bottom:1px solid #f3f4f6;" ' +
                    'onmouseover="this.style.background=\'#fff5f5\'" ' +
                    'onmouseout="this.style.background=\'\'" ' +
                    'onclick="window[\'pinpointPick_' + MAP_ID + '\'](\''+item.lat+'\',\''+item.lon+'\',\''+name+'\')">' +
                    '<div style="font-weight:700;font-size:12px;color:#111827;">' +
                    '<i class="fas fa-map-marker-alt" style="color:#dc2626;margin-right:4px;"></i>' +
                    item.display_name.split(',')[0] + '</div>' +
                    '<div style="font-size:11px;color:#9ca3af;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' +
                    shortName + '</div></li>';
        });
        html += '</ul>';
        box.innerHTML = html;
    }

    window['pinpointSearch_' + MAP_ID] = function () {
        const q = (document.getElementById('search_input_' + MAP_ID).value || '').trim();
        if (!q) { return; }
        doSearch(q);
    };

    window['pinpointPick_' + MAP_ID] = function (lat, lng, name) {
        document.getElementById('search_results_' + MAP_ID).classList.add('hidden');
        document.getElementById('search_input_'   + MAP_ID).value = name.split(',')[0];
        setPin(parseFloat(lat), parseFloat(lng), false);
        document.getElementById('pin_address_' + MAP_ID).innerText = name;
        map.setZoom(16);
    };

    window['pinpointUpdateAddr_' + MAP_ID] = function () {
        const lat = document.getElementById(LAT_ID).value;
        const lng = document.getElementById(LNG_ID).value;
        if (lat && lng) {
            reverseGeocode(parseFloat(lat), parseFloat(lng));
        } else {
            alert('Silakan klik lokasi pada peta terlebih dahulu.');
        }
    };

    window['pinpointSave_' + MAP_ID] = function () {
        const lat = document.getElementById(LAT_ID).value;
        const lng = document.getElementById(LNG_ID).value;

        if (!lat || !lng) {
            showNotice('Belum ada titik lokasi yang dipilih. Klik peta atau gunakan GPS terlebih dahulu.', 'warn');
            return;
        }

        const addrEl   = document.getElementById('pin_address_' + MAP_ID);
        const badgeEl  = document.getElementById('pin_saved_badge_' + MAP_ID);
        const addrText = document.getElementById('pin_saved_addr_'  + MAP_ID);
        const saveBtn  = document.getElementById('btn_save_' + MAP_ID);

        // Tampilkan badge hijau
        addrText.innerText = addrEl ? addrEl.innerText : lat + ', ' + lng;
        badgeEl.style.display = 'flex';

        // Ubah tombol jadi centang
        saveBtn.innerHTML  = '<i class="fas fa-check" style="font-size:10px;"></i> Tersimpan';
        saveBtn.style.background = '#16a34a';
        saveBtn.onmouseover = function () { this.style.background = '#15803d'; };
        saveBtn.onmouseout  = function () { this.style.background = '#16a34a'; };

        // Update card jadi hijau
        const card = document.getElementById('pin_card_' + MAP_ID);
        card.style.background   = '#f0fdf4';
        card.style.borderColor  = '#86efac';

        showNotice('Lokasi berhasil disimpan! Koordinat: ' + parseFloat(lat).toFixed(6) + ', ' + parseFloat(lng).toFixed(6), 'ok');
    };

    // ── Notifikasi ─────────────────────────────────────────────────
    function showNotice(msg, type) {
        const card = document.getElementById('pin_card_' + MAP_ID);
        if (!card) { return; }
        const old = document.getElementById('gps_notice_' + MAP_ID);
        if (old) { old.remove(); }
        const colors = {
            ok:   'background:#f0fdf4;border-color:#86efac;color:#166534;',
            warn: 'background:#fffbeb;border-color:#fde68a;color:#92400e;',
            err:  'background:#fff1f2;border-color:#fda4af;color:#9f1239;',
        };
        const icons = { ok: 'fa-check-circle', warn: 'fa-exclamation-circle', err: 'fa-info-circle' };
        const div = document.createElement('div');
        div.id = 'gps_notice_' + MAP_ID;
        div.style.cssText = 'display:flex;align-items:flex-start;gap:8px;border:1px solid;border-radius:8px;padding:10px 12px;margin:6px 0;font-size:12px;' + (colors[type] || colors.err);
        div.innerHTML = '<i class="fas ' + (icons[type] || icons.err) + '" style="margin-top:1px;flex-shrink:0;"></i><span style="flex:1;">' + msg + '</span>' +
                        '<button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:14px;line-height:1;color:inherit;opacity:.6;">&times;</button>';
        card.insertAdjacentElement('beforebegin', div);
    }

    // Init setelah DOM siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMap);
    } else {
        initMap();
    }
})();
</script>
