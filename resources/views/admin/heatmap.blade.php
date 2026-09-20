@extends('admin.layout.base')

@section('title', 'Emergency Demand Heatmap - ')

@section('styles')
<!-- Leaflet & Heatmap CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .heatmap-card-wrapper {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(14px);
    }

    .heatmap-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 20px;
    }

    .heatmap-header h4 {
        font-size: 22px;
        font-weight: 900;
        color: var(--text-main);
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kpi-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .kpi-pill {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        border-radius: 10px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 140px;
    }

    .kpi-pill .val {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
    }

    .kpi-pill .lbl {
        font-size: 11px;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Controls Bar */
    .heatmap-controls-bar {
        background: rgba(0, 168, 255, 0.05);
        border: 1px solid var(--border-line);
        border-radius: 12px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .control-btn-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-heatmap-tool {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        color: var(--text-main);
        font-size: 12px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-heatmap-tool:hover, .btn-heatmap-tool.active {
        border-color: var(--cyan-bright);
        background: rgba(0, 168, 255, 0.15);
        color: var(--cyan-bright);
    }

    /* Main Grid */
    .heatmap-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        height: 600px;
    }

    #heatmap-viewport {
        width: 100%;
        height: 100%;
        border-radius: 14px;
        border: 1px solid var(--border-line);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        z-index: 1;
    }

    /* Hotspot Analytics Side Panel */
    .hotspot-panel {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .hotspot-panel-head {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-line);
        background: rgba(0, 168, 255, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hotspot-panel-head h5 {
        font-size: 13px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .hotspot-list {
        list-style: none;
        padding: 12px;
        margin: 0;
        overflow-y: auto;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .hotspot-item {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 10px;
        padding: 12px;
        transition: all 0.2s;
    }

    .hotspot-item:hover {
        border-color: var(--cyan-bright);
        transform: translateY(-1px);
    }

    .hotspot-progress-bar {
        height: 6px;
        background: rgba(0, 168, 255, 0.1);
        border-radius: 4px;
        margin-top: 8px;
        overflow: hidden;
    }

    .hotspot-progress-fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(90deg, #0284C7, #E63946);
    }

    @media (max-width: 991px) {
        .heatmap-grid {
            grid-template-columns: 1fr;
            height: auto;
        }
        #heatmap-viewport {
            height: 450px;
        }
    }
</style>
@endsection

@section('content')
<div class="heatmap-card-wrapper">
    <div class="heatmap-header">
        <div>
            <h4>
                <i class="fa-solid fa-fire" style="color: var(--crimson-alert);"></i>
                <span>Emergency Demand Heatmap & Surge Analytics</span>
            </h4>
            <span style="font-size: 12px; color: var(--text-dim);">
                Spatial density clustering of incoming patient SOS requests, surge hotspots, and high-frequency emergency pickup corridors.
            </span>
        </div>

        <div>
            <button type="button" class="btn btn-sm btn-outline-info" onclick="fetchHeatmapData()" style="border-radius: 8px; font-weight: 700; font-size: 12px;">
                <i class="fa-solid fa-rotate" id="heat-spin"></i> Refresh Clusters
            </button>
        </div>
    </div>

    <!-- KPI Metric Badges -->
    <div class="kpi-row">
        <div class="kpi-pill">
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(230, 57, 70, 0.15); color: var(--crimson-alert); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <div class="val">4 High-Surge Zones</div>
                <div class="lbl">Emergency Corridors</div>
            </div>
        </div>

        <div class="kpi-pill">
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(0, 168, 255, 0.15); color: var(--cyan-bright); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                <i class="fa-solid fa-location-crosshairs"></i>
            </div>
            <div>
                <div class="val" id="stat-points-count">0 Points</div>
                <div class="lbl">Density Samples</div>
            </div>
        </div>

        <div class="kpi-pill">
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(22, 163, 74, 0.15); color: var(--green-status); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <div class="val">8.4 Mins</div>
                <div class="lbl">Avg Response Time</div>
            </div>
        </div>
    </div>

    <!-- Controls Bar -->
    <div class="heatmap-controls-bar">
        <div class="control-btn-group">
            <button type="button" class="btn-heatmap-tool active" id="btnToggleLayer" onclick="toggleHeatmapLayer()">
                <i class="fa-solid fa-layer-group"></i> Heatmap Layer: ON
            </button>
            <button type="button" class="btn-heatmap-tool" onclick="cycleRadius()">
                <i class="fa-solid fa-circle-dot"></i> Radius: <span id="lblRadius">25px</span>
            </button>
            <button type="button" class="btn-heatmap-tool" onclick="cycleBlur()">
                <i class="fa-solid fa-eye-dropper"></i> Blur: <span id="lblBlur">15px</span>
            </button>
            <button type="button" class="btn-heatmap-tool" onclick="cycleGradient()">
                <i class="fa-solid fa-palette"></i> Palette: <span id="lblPalette">Thermal Red</span>
            </button>
        </div>

        <div style="font-size: 12px; color: var(--text-dim);">
            <i class="fa-solid fa-circle" style="color: #E63946; font-size: 8px;"></i> High Surge &nbsp;
            <i class="fa-solid fa-circle" style="color: #f59e0b; font-size: 8px;"></i> Moderate &nbsp;
            <i class="fa-solid fa-circle" style="color: #0284C7; font-size: 8px;"></i> Low Density
        </div>
    </div>

    <!-- Main Grid -->
    <div class="heatmap-grid">
        <!-- Left: Map Canvas -->
        <div style="position: relative;">
            <div id="heatmap-viewport"></div>
        </div>

        <!-- Right: Identified High-Surge Zones -->
        <div class="hotspot-panel">
            <div class="hotspot-panel-head">
                <h5><i class="fa-solid fa-fire" style="color: var(--crimson-alert);"></i> Surge Hotspots</h5>
                <span class="badge badge-danger" style="font-size: 10px;">Live Density</span>
            </div>

            <ul class="hotspot-list">
                <li class="hotspot-item" onclick="panToHub(25.2815, 82.9995)">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="color:var(--text-main); font-size:12px;">BHU Trauma Center Wing</strong>
                        <span style="color:#E63946; font-weight:800; font-size:11px;">95% Surge</span>
                    </div>
                    <small style="color:var(--text-dim); font-size:11px;">Severe trauma emergency corridor</small>
                    <div class="hotspot-progress-bar">
                        <div class="hotspot-progress-fill" style="width: 95%;"></div>
                    </div>
                </li>

                <li class="hotspot-item" onclick="panToHub(25.3176, 82.9739)">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="color:var(--text-main); font-size:12px;">Sigra Commercial Hub</strong>
                        <span style="color:#E63946; font-weight:800; font-size:11px;">90% Surge</span>
                    </div>
                    <small style="color:var(--text-dim); font-size:11px;">High pedestrian traffic & cardiac requests</small>
                    <div class="hotspot-progress-bar">
                        <div class="hotspot-progress-fill" style="width: 90%;"></div>
                    </div>
                </li>

                <li class="hotspot-item" onclick="panToHub(25.3356, 82.9862)">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="color:var(--text-main); font-size:12px;">Varanasi Cantt Station Junction</strong>
                        <span style="color:#f59e0b; font-weight:800; font-size:11px;">85% Surge</span>
                    </div>
                    <small style="color:var(--text-dim); font-size:11px;">Transit transfers & inter-city emergency</small>
                    <div class="hotspot-progress-bar">
                        <div class="hotspot-progress-fill" style="width: 85%;"></div>
                    </div>
                </li>

                <li class="hotspot-item" onclick="panToHub(25.2950, 83.0100)">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="color:var(--text-main); font-size:12px;">Lanka & Heritage Ghats Zone</strong>
                        <span style="color:#0284C7; font-weight:800; font-size:11px;">75% Surge</span>
                    </div>
                    <small style="color:var(--text-dim); font-size:11px;">Crowded lanes - BLS priority response</small>
                    <div class="hotspot-progress-bar">
                        <div class="hotspot-progress-fill" style="width: 75%;"></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet & Leaflet-heat Plugins -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
<script>
    let heatMap = null;
    let heatTileLayer = null;
    let heatLayer = null;
    let heatPoints = [];
    let isHeatmapVisible = true;

    // Heatmap Config State
    let currentRadius = 25;
    let currentBlur = 15;
    let currentGradientIndex = 0;

    const gradients = [
        {
            name: "Thermal Red",
            gradient: { 0.2: '#0284C7', 0.5: '#f59e0b', 0.8: '#E63946', 1.0: '#990000' }
        },
        {
            name: "Neon Medical",
            gradient: { 0.2: '#00A8FF', 0.6: '#9BC03C', 0.9: '#E63946', 1.0: '#ffffff' }
        },
        {
            name: "Classic Rainbow",
            gradient: { 0.2: 'blue', 0.4: 'cyan', 0.6: 'lime', 0.8: 'yellow', 1.0: 'red' }
        }
    ];

    // 1. Initialize Leaflet Map
    function initHeatmap() {
        heatMap = L.map('heatmap-viewport', { zoomControl: true }).setView([25.3176, 82.9739], 13);
        applyMapTheme();
        fetchHeatmapData();
    }

    function applyMapTheme() {
        const theme = document.documentElement.getAttribute('data-theme') || 'light';
        if (heatTileLayer) {
            heatMap.removeLayer(heatTileLayer);
        }

        if (theme === 'dark') {
            heatTileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CartoDB &copy; OpenStreetMap'
            }).addTo(heatMap);
        } else {
            heatTileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CartoDB &copy; OpenStreetMap'
            }).addTo(heatMap);
        }
    }

    // 2. Fetch Heatmap Points via AJAX
    function fetchHeatmapData() {
        const spin = document.getElementById('heat-spin');
        if (spin) spin.classList.add('fa-spin');

        $.get("{{ route('admin.get_heatmap') }}", function(data) {
            if (spin) spin.classList.remove('fa-spin');
            if (data && Array.isArray(data)) {
                heatPoints = data.map(pt => [pt.lat, pt.lng, pt.count || 0.8]);
                document.getElementById('stat-points-count').innerText = heatPoints.length + " Points";
                renderHeatLayer();
            }
        }).fail(function() {
            if (spin) spin.classList.remove('fa-spin');
        });
    }

    // 3. Render Leaflet Heat Layer
    function renderHeatLayer() {
        if (heatLayer) {
            heatMap.removeLayer(heatLayer);
        }

        if (!isHeatmapVisible || heatPoints.length === 0) return;

        heatLayer = L.heatLayer(heatPoints, {
            radius: currentRadius,
            blur: currentBlur,
            maxZoom: 17,
            gradient: gradients[currentGradientIndex].gradient
        }).addTo(heatMap);
    }

    // 4. Interactive Adjusters
    function toggleHeatmapLayer() {
        isHeatmapVisible = !isHeatmapVisible;
        const btn = document.getElementById('btnToggleLayer');
        if (isHeatmapVisible) {
            btn.classList.add('active');
            btn.innerHTML = '<i class="fa-solid fa-layer-group"></i> Heatmap Layer: ON';
        } else {
            btn.classList.remove('active');
            btn.innerHTML = '<i class="fa-solid fa-layer-group"></i> Heatmap Layer: OFF';
        }
        renderHeatLayer();
    }

    function cycleRadius() {
        const radii = [15, 25, 35, 50];
        const idx = (radii.indexOf(currentRadius) + 1) % radii.length;
        currentRadius = radii[idx];
        document.getElementById('lblRadius').innerText = currentRadius + "px";
        renderHeatLayer();
    }

    function cycleBlur() {
        const blurs = [10, 15, 25];
        const idx = (blurs.indexOf(currentBlur) + 1) % blurs.length;
        currentBlur = blurs[idx];
        document.getElementById('lblBlur').innerText = currentBlur + "px";
        renderHeatLayer();
    }

    function cycleGradient() {
        currentGradientIndex = (currentGradientIndex + 1) % gradients.length;
        document.getElementById('lblPalette').innerText = gradients[currentGradientIndex].name;
        renderHeatLayer();
    }

    function panToHub(lat, lng) {
        heatMap.flyTo([lat, lng], 15, { animate: true, duration: 1.2 });
    }

    // 5. DOM Ready & Observer
    document.addEventListener('DOMContentLoaded', function() {
        initHeatmap();

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "data-theme") {
                    applyMapTheme();
                }
            });
        });
        observer.observe(document.documentElement, { attributes: true });
    });
</script>
@endsection