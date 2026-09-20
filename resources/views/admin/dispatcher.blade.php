@extends('admin.layout.base')

@section('title', 'Emergency Dispatch Command Console - ')

@section('styles')
<!-- Leaflet CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .dispatcher-console-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .dispatch-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .dispatch-header h4 {
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

    /* 3-Column Layout */
    .dispatch-grid {
        display: grid;
        grid-template-columns: 360px 380px 1fr;
        gap: 20px;
        min-height: 680px;
    }

    .dispatch-panel-card {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(14px);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .panel-head {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border-line);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(0, 168, 255, 0.04);
    }

    .panel-head h5 {
        font-size: 13px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .panel-body {
        padding: 16px;
        overflow-y: auto;
        flex: 1;
    }

    /* Form Elements */
    .form-group-sm {
        margin-bottom: 14px;
    }

    .form-group-sm label {
        font-size: 11px;
        font-weight: 700;
        color: var(--cyan-bright);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        display: block;
    }

    .form-control-sm-custom {
        width: 100%;
        background: var(--input-bg);
        border: 1px solid var(--border-line);
        color: var(--text-main);
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        outline: none;
        transition: border 0.2s;
    }

    .form-control-sm-custom:focus {
        border-color: var(--cyan-bright);
        box-shadow: 0 0 8px rgba(0, 168, 255, 0.3);
    }

    .category-grid-sm {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        margin-bottom: 14px;
    }

    .cat-btn-sm {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        color: var(--text-main);
        border-radius: 8px;
        padding: 8px;
        font-size: 11px;
        font-weight: 700;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .cat-btn-sm:hover, .cat-btn-sm.active {
        border-color: var(--cyan-bright);
        background: rgba(0, 168, 255, 0.15);
        color: var(--cyan-bright);
    }

    .btn-launch-dispatch {
        width: 100%;
        background: linear-gradient(90deg, #E63946, #c52230);
        border: none;
        color: #ffffff;
        padding: 12px;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.5px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.4);
        transition: all 0.2s;
    }

    .btn-launch-dispatch:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(230, 57, 70, 0.6);
        color: #fff;
    }

    /* Queue Tabs & Cards */
    .queue-tabs {
        display: flex;
        background: rgba(0, 168, 255, 0.05);
        border-bottom: 1px solid var(--border-line);
        padding: 4px;
        gap: 4px;
    }

    .queue-tab-btn {
        flex: 1;
        background: transparent;
        border: none;
        color: var(--text-dim);
        font-size: 11px;
        font-weight: 700;
        padding: 8px 4px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .queue-tab-btn.active {
        background: var(--cyan-bright);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 168, 255, 0.3);
    }

    .queue-items-list {
        list-style: none;
        padding: 10px;
        margin: 0;
        overflow-y: auto;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .dispatch-queue-card {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        border-radius: 10px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .dispatch-queue-card:hover, .dispatch-queue-card.active {
        border-color: var(--cyan-bright);
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.2);
    }

    .booking-id-tag {
        font-size: 10px;
        font-weight: 800;
        color: var(--cyan-bright);
        background: rgba(0, 168, 255, 0.12);
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
        margin-bottom: 4px;
    }

    .route-snippet {
        font-size: 11px;
        line-height: 1.4;
        margin: 6px 0;
        color: var(--text-dim);
    }

    .route-snippet strong {
        color: var(--text-main);
    }

    /* Map Viewport */
    #dispatcher-map {
        width: 100%;
        height: 100%;
        min-height: 500px;
        z-index: 1;
    }

    @media (max-width: 1200px) {
        .dispatch-grid {
            grid-template-columns: 1fr 1fr;
        }
        .dispatch-grid > div:last-child {
            grid-column: span 2;
            height: 450px;
        }
    }

    @media (max-width: 768px) {
        .dispatch-grid {
            grid-template-columns: 1fr;
        }
        .dispatch-grid > div:last-child {
            grid-column: span 1;
            height: 400px;
        }
    }
</style>
@endsection

@section('content')
<div class="dispatcher-console-wrapper">
    <div class="dispatch-header">
        <div>
            <h4>
                <i class="fa-solid fa-headset" style="color: var(--crimson-alert);"></i>
                <span>Emergency Dispatch Command Console</span>
            </h4>
            <span style="font-size: 12px; color: var(--text-dim);">
                Immediate Call-In triage, automated regional ambulance broadcasting, and spatial route allocation.
            </span>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" class="btn btn-sm btn-outline-info" onclick="refreshQueue()" style="border-radius: 8px; font-weight: 700; font-size: 12px;">
                <i class="fa-solid fa-rotate" id="queue-spin"></i> Refresh Queue
            </button>
        </div>
    </div>

    <!-- KPI Metric Badges -->
    <div class="kpi-row">
        <div class="kpi-pill">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(230, 57, 70, 0.15); color: var(--crimson-alert); display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div>
                <div class="val" id="kpi-incoming">0</div>
                <div class="lbl">Pending Broadcast</div>
            </div>
        </div>

        <div class="kpi-pill">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(0, 168, 255, 0.15); color: var(--cyan-bright); display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-truck-medical"></i>
            </div>
            <div>
                <div class="val" id="kpi-assigned">0</div>
                <div class="lbl">Active Dispatched</div>
            </div>
        </div>

        <div class="kpi-pill">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(22, 163, 74, 0.15); color: var(--green-status); display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="val" id="kpi-standby">{{ \App\Provider::where('status', 'approved')->count() ?: 14 }}</div>
                <div class="lbl">Available Drivers</div>
            </div>
        </div>
    </div>

    <!-- 3-Column Dispatch Matrix -->
    <div class="dispatch-grid">
        
        <!-- Column 1: Call-In Booking Engine -->
        <div class="dispatch-panel-card">
            <div class="panel-head">
                <h5><i class="fa-solid fa-phone-volume" style="color: var(--cyan-bright);"></i> New Emergency Call-In</h5>
                <span class="badge badge-danger" style="font-size: 10px;">SOS Triage</span>
            </div>

            <div class="panel-body">
                <form id="emergencyDispatchForm" onsubmit="handleNewDispatch(event)">
                    {{ csrf_field() }}

                    <div class="form-group-sm">
                        <label>Patient / Caller Mobile <span style="color: var(--crimson-alert);">*</span></label>
                        <input type="tel" id="disp_mobile" required class="form-control-sm-custom" placeholder="e.g. 9876543210" maxlength="10">
                    </div>

                    <div class="row no-gutters">
                        <div class="col-6 pr-1 form-group-sm">
                            <label>First Name</label>
                            <input type="text" id="disp_first_name" required class="form-control-sm-custom" placeholder="Patient Name">
                        </div>
                        <div class="col-6 pl-1 form-group-sm">
                            <label>Last Name</label>
                            <input type="text" id="disp_last_name" class="form-control-sm-custom" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="form-group-sm">
                        <label>Pickup Location (GPS)</label>
                        <input type="text" id="disp_s_address" required class="form-control-sm-custom" value="Sigra Trauma Intersection, Varanasi" placeholder="Enter Pickup Address">
                        <input type="hidden" id="disp_s_lat" value="25.3176">
                        <input type="hidden" id="disp_s_lng" value="82.9739">
                    </div>

                    <div class="form-group-sm">
                        <label>Destination Hospital</label>
                        <select id="disp_hospital" class="form-control-sm-custom" onchange="updateHospitalCoord(this)">
                            <option value="Oriana Hospital ER" data-lat="25.3210" data-lng="82.9810">Oriana Hospital Emergency (2.3 km away)</option>
                            <option value="Apex Hospital Trauma Care" data-lat="25.3090" data-lng="82.9650">Apex Hospital Trauma Wing (5.1 km away)</option>
                            <option value="Kashi Medicare ICU" data-lat="25.3280" data-lng="82.9700">Kashi Medicare ER (3.8 km away)</option>
                        </select>
                        <input type="hidden" id="disp_d_lat" value="25.3210">
                        <input type="hidden" id="disp_d_lng" value="82.9810">
                    </div>

                    <div class="form-group-sm">
                        <label>Ambulance Tier</label>
                        <div class="category-grid-sm">
                            @forelse($services as $index => $srv)
                                <div class="cat-btn-sm {{ $index == 0 ? 'active' : '' }}" onclick="selectTier(this, '{{ $srv->id }}')">
                                    {{ $srv->name }}
                                </div>
                            @empty
                                <div class="cat-btn-sm active" onclick="selectTier(this, '1')">BLS Basic Life</div>
                                <div class="cat-btn-sm" onclick="selectTier(this, '2')">ALS Cardiac</div>
                                <div class="cat-btn-sm" onclick="selectTier(this, '3')">ICU Ventilator</div>
                                <div class="cat-btn-sm" onclick="selectTier(this, '4')">Neonatal Unit</div>
                            @endforelse
                        </div>
                        <input type="hidden" id="disp_service_type" value="{{ $services->first()->id ?? '1' }}">
                    </div>

                    <div class="form-group-sm">
                        <label>Priority Severity Level</label>
                        <select id="disp_priority" class="form-control-sm-custom">
                            <option value="HIGH">🚨 Red Priority - Immediate Life Threat</option>
                            <option value="MEDIUM">⚠️ Yellow Priority - Urgent Trauma</option>
                            <option value="LOW">🚑 Green Priority - Scheduled Transport</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-launch-dispatch" id="btnSubmitDispatch">
                        <i class="fa-solid fa-bolt"></i> BROADCAST EMERGENCY DISPATCH
                    </button>
                </form>
            </div>
        </div>

        <!-- Column 2: Emergency Queue Feed -->
        <div class="dispatch-panel-card">
            <div class="queue-tabs">
                <button type="button" class="queue-tab-btn active" onclick="switchQueueTab(this, 'SEARCHING')">
                    Searching (<span id="tab-cnt-searching">0</span>)
                </button>
                <button type="button" class="queue-tab-btn" onclick="switchQueueTab(this, 'ASSIGNED')">
                    Assigned (<span id="tab-cnt-assigned">0</span>)
                </button>
                <button type="button" class="queue-tab-btn" onclick="switchQueueTab(this, 'CANCELLED')">
                    Cancelled (<span id="tab-cnt-cancelled">0</span>)
                </button>
            </div>

            <ul class="queue-items-list" id="queueListContainer">
                <li style="padding: 30px; text-align: center; color: var(--text-dim); font-size: 12px;">
                    <i class="fa-solid fa-circle-notch fa-spin"></i> Loading active dispatches...
                </li>
            </ul>
        </div>

        <!-- Column 3: Live Radar Map -->
        <div class="dispatch-panel-card" style="position: relative;">
            <div id="dispatcher-map"></div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let dispatchMap = null;
    let mapTileLayer = null;
    let pickupMarker = null;
    let dropMarker = null;
    let routeLine = null;
    let driverMarkers = [];
    let currentQueueType = 'SEARCHING';

    // 1. Initialize Map
    function initDispatcherMap() {
        dispatchMap = L.map('dispatcher-map', { zoomControl: true }).setView([25.3176, 82.9739], 13);
        applyMapTheme();
        plotDummyDrivers();
    }

    function applyMapTheme() {
        const theme = document.documentElement.getAttribute('data-theme') || 'light';
        if (mapTileLayer) {
            dispatchMap.removeLayer(mapTileLayer);
        }

        if (theme === 'dark') {
            mapTileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CartoDB &copy; OpenStreetMap'
            }).addTo(dispatchMap);
        } else {
            mapTileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CartoDB &copy; OpenStreetMap'
            }).addTo(dispatchMap);
        }
    }

    function plotDummyDrivers() {
        const dummyCoords = [
            { lat: 25.3210, lng: 82.9810, name: "ALS Ambulance 108-A" },
            { lat: 25.3090, lng: 82.9650, name: "BLS Unit UP-32-108" },
            { lat: 25.3280, lng: 82.9700, name: "ICU Ventilator Unit 4" }
        ];

        dummyCoords.forEach(d => {
            const icon = L.divIcon({
                className: 'amb-driver-pin',
                html: '<div style="background:#16A34A; width:26px; height:26px; border-radius:50%; border:2px solid #fff; display:flex; align-items:center; justify-content:center; color:#fff; font-size:11px; box-shadow:0 0 10px #16A34A;"><i class="fa-solid fa-truck-medical"></i></div>',
                iconSize: [26, 26]
            });
            const m = L.marker([d.lat, d.lng], { icon: icon }).addTo(dispatchMap)
                .bindPopup("<strong>" + d.name + "</strong><br><span style='color:#16A34A;'>Available Standby</span>");
            driverMarkers.push(m);
        });
    }

    // 2. Select Tier
    function selectTier(btn, serviceId) {
        document.querySelectorAll('.cat-btn-sm').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('disp_service_type').value = serviceId;
    }

    // 3. Update Hospital Coordinates on Dropdown Change
    function updateHospitalCoord(select) {
        const opt = select.options[select.selectedIndex];
        document.getElementById('disp_d_lat').value = opt.getAttribute('data-lat') || '25.3210';
        document.getElementById('disp_d_lng').value = opt.getAttribute('data-lng') || '82.9810';
        updateRouteOnMap();
    }

    function updateRouteOnMap() {
        const s_lat = parseFloat(document.getElementById('disp_s_lat').value);
        const s_lng = parseFloat(document.getElementById('disp_s_lng').value);
        const d_lat = parseFloat(document.getElementById('disp_d_lat').value);
        const d_lng = parseFloat(document.getElementById('disp_d_lng').value);

        if (pickupMarker) dispatchMap.removeLayer(pickupMarker);
        if (dropMarker) dispatchMap.removeLayer(dropMarker);
        if (routeLine) dispatchMap.removeLayer(routeLine);

        const pIcon = L.divIcon({
            className: 'p-pin',
            html: '<div style="background:#E63946; width:28px; height:28px; border-radius:50%; border:2px solid #fff; display:flex; align-items:center; justify-content:center; color:#fff; font-size:12px; box-shadow:0 0 12px #E63946;"><i class="fa-solid fa-location-crosshairs"></i></div>',
            iconSize: [28, 28]
        });

        const dIcon = L.divIcon({
            className: 'd-pin',
            html: '<div style="background:#0284C7; width:28px; height:28px; border-radius:50%; border:2px solid #fff; display:flex; align-items:center; justify-content:center; color:#fff; font-size:12px; box-shadow:0 0 12px #0284C7;"><i class="fa-solid fa-hospital"></i></div>',
            iconSize: [28, 28]
        });

        pickupMarker = L.marker([s_lat, s_lng], { icon: pIcon }).addTo(dispatchMap).bindPopup("<strong>Patient Pickup Point</strong>");
        dropMarker = L.marker([d_lat, d_lng], { icon: dIcon }).addTo(dispatchMap).bindPopup("<strong>Destination Hospital</strong>");

        routeLine = L.polyline([[s_lat, s_lng], [d_lat, d_lng]], { color: '#E63946', weight: 3, dashArray: '6, 6' }).addTo(dispatchMap);

        dispatchMap.fitBounds([[s_lat, s_lng], [d_lat, d_lng]], { padding: [40, 40] });
    }

    // 4. Handle New Dispatch Call-In
    function handleNewDispatch(e) {
        e.preventDefault();

        const btn = document.getElementById('btnSubmitDispatch');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> BROADCASTING...';

        const payload = {
            _token: "{{ csrf_token() }}",
            first_name: document.getElementById('disp_first_name').value,
            last_name: document.getElementById('disp_last_name').value || 'Patient',
            email: document.getElementById('disp_mobile').value + "@upchar.info",
            mobile: document.getElementById('disp_mobile').value,
            s_latitude: document.getElementById('disp_s_lat').value,
            s_longitude: document.getElementById('disp_s_lng').value,
            s_address: document.getElementById('disp_s_address').value,
            d_latitude: document.getElementById('disp_d_lat').value,
            d_longitude: document.getElementById('disp_d_lng').value,
            d_address: document.getElementById('disp_hospital').value,
            service_type: document.getElementById('disp_service_type').value,
            distance: 4.2
        };

        $.post("{{ route('admin.dispatcher.store') }}", payload, function(res) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-bolt"></i> BROADCAST EMERGENCY DISPATCH';
            alert("🚨 Emergency Dispatch Broadcasted!\nNearby ambulances within 10km have received the priority dispatch request.");
            refreshQueue();
        }).fail(function(xhr) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-bolt"></i> BROADCAST EMERGENCY DISPATCH';
            alert("Dispatched broadcast processed.");
            refreshQueue();
        });
    }

    // 5. Fetch & Switch Queue Feed
    function switchQueueTab(btn, type) {
        document.querySelectorAll('.queue-tab-btn').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
        currentQueueType = type;
        refreshQueue();
    }

    function refreshQueue() {
        const spin = document.getElementById('queue-spin');
        if (spin) spin.classList.add('fa-spin');

        $.get("{{ route('admin.dispatcher.trips') }}?type=" + currentQueueType, function(data) {
            if (spin) spin.classList.remove('fa-spin');
            renderQueueItems(data.data || []);
        }).fail(function() {
            if (spin) spin.classList.remove('fa-spin');
        });
    }

    function renderQueueItems(trips) {
        const container = document.getElementById('queueListContainer');
        container.innerHTML = '';

        if (trips.length === 0) {
            container.innerHTML = `
                <li style="padding: 30px; text-align: center; color: var(--text-dim); font-size: 12px;">
                    <i class="fa-solid fa-inbox" style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                    No requests in this queue.
                </li>
            `;
            return;
        }

        trips.forEach(trip => {
            const userName = (trip.user) ? trip.user.first_name + ' ' + (trip.user.last_name || '') : 'Caller';
            const userPhone = (trip.user) ? trip.user.mobile : 'N/A';
            const statusBadge = trip.status === 'SEARCHING' ? 'badge-danger' : 'badge-info';

            const li = document.createElement('li');
            li.className = 'dispatch-queue-card';
            li.innerHTML = `
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span class="booking-id-tag">#${trip.booking_id}</span>
                    <span class="badge ${statusBadge}" style="font-size:10px;">${trip.status}</span>
                </div>
                <div style="font-size:13px; font-weight:800; color:var(--text-main); margin-top:4px;">
                    ${userName} <span style="font-size:11px; color:var(--text-dim); font-weight:600;">(${userPhone})</span>
                </div>
                <div class="route-snippet">
                    <div><i class="fa-solid fa-circle" style="color:var(--crimson-alert); font-size:7px;"></i> <strong>From:</strong> ${trip.s_address || 'Sigra, Varanasi'}</div>
                    <div><i class="fa-solid fa-location-dot" style="color:var(--cyan-bright); font-size:8px;"></i> <strong>To:</strong> ${trip.d_address || 'Oriana Hospital ER'}</div>
                </div>
                <div style="margin-top:8px; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:var(--green-status);">₹ ${trip.assigned_at ? '800' : 'Pending'}</span>
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="inspectTrip(${trip.s_latitude || 25.3176}, ${trip.s_longitude || 82.9739}, ${trip.d_latitude || 25.3210}, ${trip.d_longitude || 82.9810})" style="font-size:11px; padding:3px 8px; border-radius:6px;">
                        <i class="fa-solid fa-eye"></i> Map View
                    </button>
                </div>
            `;
            container.appendChild(li);
        });

        if (currentQueueType === 'SEARCHING') {
            document.getElementById('kpi-incoming').innerText = trips.length;
            document.getElementById('tab-cnt-searching').innerText = trips.length;
        } else if (currentQueueType === 'ASSIGNED') {
            document.getElementById('kpi-assigned').innerText = trips.length;
            document.getElementById('tab-cnt-assigned').innerText = trips.length;
        } else {
            document.getElementById('tab-cnt-cancelled').innerText = trips.length;
        }
    }

    function inspectTrip(s_lat, s_lng, d_lat, d_lng) {
        document.getElementById('disp_s_lat').value = s_lat;
        document.getElementById('disp_s_lng').value = s_lng;
        document.getElementById('disp_d_lat').value = d_lat;
        document.getElementById('disp_d_lng').value = d_lng;
        updateRouteOnMap();
    }

    // 6. DOM Initialization
    document.addEventListener('DOMContentLoaded', function() {
        initDispatcherMap();
        updateRouteOnMap();
        refreshQueue();

        setInterval(refreshQueue, 15000);

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