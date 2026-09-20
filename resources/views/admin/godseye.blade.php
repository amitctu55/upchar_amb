@extends('admin.layout.base')

@section('title', "God's Eye - Real-Time Fleet Radar - ")

@section('styles')
<!-- Leaflet CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .godseye-card-wrapper {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(14px);
    }

    .godseye-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 20px;
    }

    .godseye-header h4 {
        font-size: 22px;
        font-weight: 900;
        color: var(--text-main);
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .telemetry-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .telemetry-pill {
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

    .telemetry-pill .val {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
    }

    .telemetry-pill .lbl {
        font-size: 11px;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filters Bar */
    .radar-filter-bar {
        background: rgba(0, 168, 255, 0.05);
        border: 1px solid var(--border-line);
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .status-tab-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-status-filter {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        color: var(--text-dim);
        font-size: 12px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-status-filter:hover {
        color: var(--cyan-bright);
        border-color: var(--cyan-bright);
    }

    .btn-status-filter.active {
        background: var(--cyan-bright);
        color: #ffffff;
        border-color: var(--cyan-bright);
        box-shadow: 0 0 12px rgba(0, 168, 255, 0.4);
    }

    .filter-dropdown-select {
        background: var(--input-bg);
        border: 1px solid var(--border-line);
        color: var(--text-main);
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        outline: none;
    }

    /* Radar Main Layout */
    .radar-grid {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 20px;
        height: 620px;
    }

    /* Left Sidebar: Fleet List */
    .fleet-sidebar {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .fleet-sidebar-head {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-line);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .fleet-sidebar-head span {
        font-size: 13px;
        font-weight: 800;
        color: var(--text-main);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .fleet-search-input {
        padding: 10px 14px;
        border-bottom: 1px solid var(--border-line);
        background: transparent;
    }

    .fleet-search-input input {
        width: 100%;
        background: var(--input-bg);
        border: 1px solid var(--border-line);
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        color: var(--text-main);
        outline: none;
    }

    .fleet-cards-list {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        list-style: none;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .ambulance-feed-card {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 10px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .ambulance-feed-card:hover, .ambulance-feed-card.active {
        border-color: var(--cyan-bright);
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.25);
        transform: translateY(-1px);
    }

    .amb-avatar-box {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--panel-navy);
        border: 2px solid var(--cyan-bright);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        color: var(--cyan-bright);
        flex-shrink: 0;
        overflow: hidden;
    }

    .amb-avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .amb-info-box {
        flex: 1;
        min-width: 0;
    }

    .amb-info-box h5 {
        font-size: 13px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 2px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .amb-info-box p {
        font-size: 11px;
        color: var(--text-dim);
        margin: 0;
        line-height: 1.3;
    }

    .status-badge-mini {
        font-size: 9px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin-top: 4px;
        text-transform: uppercase;
    }

    .status-badge-mini.available {
        background: rgba(22, 163, 74, 0.15);
        color: #16A34A;
        border: 1px solid #16A34A;
    }

    .status-badge-mini.enroute {
        background: rgba(230, 57, 70, 0.15);
        color: #E63946;
        border: 1px solid #E63946;
    }

    .status-badge-mini.arrived {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
        border: 1px solid #f59e0b;
    }

    .status-badge-mini.transit {
        background: rgba(2, 132, 199, 0.15);
        color: #0284C7;
        border: 1px solid #0284C7;
    }

    /* Right Side: Map Canvas */
    #godseye-map {
        width: 100%;
        height: 100%;
        border-radius: 14px;
        border: 1px solid var(--border-line);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        z-index: 1;
    }

    /* Pulse Markers */
    .amb-pulse-marker {
        position: relative;
    }
    .amb-marker-inner {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 13px;
        box-shadow: 0 0 15px rgba(0,0,0,0.4);
        border: 2px solid #ffffff;
    }

    .pulse-ring {
        position: absolute;
        width: 44px;
        height: 44px;
        top: -6px;
        left: -6px;
        border-radius: 50%;
        animation: radarPing 1.8s infinite;
    }

    @keyframes radarPing {
        0% { transform: scale(0.7); opacity: 0.9; }
        100% { transform: scale(1.4); opacity: 0; }
    }

    @media (max-width: 991px) {
        .radar-grid {
            grid-template-columns: 1fr;
            height: auto;
        }
        #godseye-map {
            height: 450px;
        }
    }
</style>
@endsection

@section('content')
<div class="godseye-card-wrapper">
    <div class="godseye-header">
        <div>
            <h4>
                <i class="fa-solid fa-satellite" style="color: var(--cyan-bright);"></i>
                <span>God's Eye - Real-Time Fleet Radar</span>
            </h4>
            <span style="font-size: 12px; color: var(--text-dim);">
                Real-time spatial GPS tracking of online ambulances, active emergency trip dispatches, and partner hospital fleets.
            </span>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" class="btn btn-sm btn-outline-info" onclick="fetchLiveTelemetry()" style="border-radius: 8px; font-weight: 700; font-size: 12px;">
                <i class="fa-solid fa-rotate" id="refresh-spin"></i> Refresh Telemetry
            </button>
        </div>
    </div>

    <!-- Live Telemetry KPI Badges -->
    <div class="telemetry-pills">
        <div class="telemetry-pill">
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(0, 168, 255, 0.15); color: var(--cyan-bright); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                <i class="fa-solid fa-truck-medical"></i>
            </div>
            <div>
                <div class="val" id="stat-total-online">0</div>
                <div class="lbl">Online Fleet</div>
            </div>
        </div>

        <div class="telemetry-pill">
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(22, 163, 74, 0.15); color: var(--green-status); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="val" id="stat-available">0</div>
                <div class="lbl">Available / Standby</div>
            </div>
        </div>

        <div class="telemetry-pill">
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(230, 57, 70, 0.15); color: var(--crimson-alert); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div>
                <div class="val" id="stat-in-transit">0</div>
                <div class="lbl">Dispatched / Enroute</div>
            </div>
        </div>

        <div class="telemetry-pill">
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(245, 158, 11, 0.15); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <div>
                <div class="val">{{ count($fleets) }}</div>
                <div class="lbl">Partner Fleets</div>
            </div>
        </div>
    </div>

    <!-- Filter Control Bar -->
    <div class="radar-filter-bar">
        <div class="status-tab-group">
            <button type="button" class="btn-status-filter active" data-status="ALL" onclick="filterByStatus(this, 'ALL')">
                <i class="fa-solid fa-layer-group"></i> All Fleet (<span id="count-all">0</span>)
            </button>
            <button type="button" class="btn-status-filter" data-status="ACTIVE" onclick="filterByStatus(this, 'ACTIVE')">
                <i class="fa-solid fa-circle-check"></i> Available (<span id="count-active">0</span>)
            </button>
            <button type="button" class="btn-status-filter" data-status="STARTED" onclick="filterByStatus(this, 'STARTED')">
                <i class="fa-solid fa-person-running"></i> Enroute to Patient (<span id="count-started">0</span>)
            </button>
            <button type="button" class="btn-status-filter" data-status="ARRIVED" onclick="filterByStatus(this, 'ARRIVED')">
                <i class="fa-solid fa-location-dot"></i> At Scene (<span id="count-arrived">0</span>)
            </button>
            <button type="button" class="btn-status-filter" data-status="PICKEDUP" onclick="filterByStatus(this, 'PICKEDUP')">
                <i class="fa-solid fa-hospital-user"></i> Hospital Transit (<span id="count-pickedup">0</span>)
            </button>
        </div>

        <div>
            <select class="filter-dropdown-select" id="fleetFilterSelect" onchange="filterByFleet(this.value)">
                <option value="ALL">All Hospital & Partner Fleets</option>
                @foreach($fleets as $fleet)
                    <option value="{{ $fleet->id }}">{{ $fleet->company }} ({{ $fleet->name }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Main 2-Column Radar Canvas -->
    <div class="radar-grid">
        <!-- Left Column: Active Ambulances List -->
        <div class="fleet-sidebar">
            <div class="fleet-sidebar-head">
                <span><i class="fa-solid fa-radar" style="color: var(--cyan-bright);"></i> Active Ambulances</span>
                <span id="sidebar-count" style="color: var(--cyan-bright);">0 Found</span>
            </div>

            <div class="fleet-search-input">
                <input type="text" id="driverSearchInput" placeholder="Search driver, phone, number plate..." onkeyup="filterSidebarList()">
            </div>

            <ul class="fleet-cards-list" id="ambulanceListContainer">
                <!-- Dynamically populated via AJAX -->
                <li style="padding: 20px; text-align: center; color: var(--text-dim); font-size: 13px;">
                    <i class="fa-solid fa-circle-notch fa-spin"></i> Initializing radar telemetry...
                </li>
            </ul>
        </div>

        <!-- Right Column: Leaflet Map -->
        <div style="position: relative;">
            <div id="godseye-map"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map = null;
    let currentTileLayer = null;
    let markersMap = {};
    let allProvidersData = [];
    let activeStatusFilter = 'ALL';
    let activeFleetFilter = 'ALL';

    // 1. Initialize Map
    function initGodsEyeMap() {
        map = L.map('godseye-map', {
            zoomControl: true
        }).setView([25.3176, 82.9739], 12);

        applyMapTheme();
    }

    function applyMapTheme() {
        const theme = document.documentElement.getAttribute('data-theme') || 'light';
        if (currentTileLayer) {
            map.removeLayer(currentTileLayer);
        }

        if (theme === 'dark') {
            currentTileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CartoDB &copy; OpenStreetMap'
            }).addTo(map);
        } else {
            currentTileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; CartoDB &copy; OpenStreetMap'
            }).addTo(map);
        }
    }

    // 2. Fetch Live Telemetry Data
    function fetchLiveTelemetry() {
        const spin = document.getElementById('refresh-spin');
        if (spin) spin.classList.add('fa-spin');

        let url = "{{ route('admin.godseye_list') }}?status=" + activeStatusFilter;
        if (activeFleetFilter !== 'ALL') {
            url += "&fleet=" + activeFleetFilter;
        }

        $.get(url, function(data) {
            if (spin) spin.classList.remove('fa-spin');
            if (data && data.providers) {
                allProvidersData = data.providers;
                renderTelemetry(data.providers, data.locations);
            }
        }).fail(function() {
            if (spin) spin.classList.remove('fa-spin');
        });
    }

    // 3. Render Telemetry on Map & Sidebar
    function renderTelemetry(providers, locations) {
        // Clear existing markers
        for (let id in markersMap) {
            map.removeLayer(markersMap[id]);
        }
        markersMap = {};

        const listContainer = document.getElementById('ambulanceListContainer');
        listContainer.innerHTML = '';

        let countActive = 0;
        let countStarted = 0;
        let countArrived = 0;
        let countPickedup = 0;

        if (providers.length === 0) {
            listContainer.innerHTML = `
                <li style="padding: 30px; text-align: center; color: var(--text-dim); font-size: 13px;">
                    <i class="fa-solid fa-satellite-dish" style="font-size: 28px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                    No ambulances match the selected telemetry filter.
                </li>
            `;
            document.getElementById('sidebar-count').innerText = "0 Found";
            return;
        }

        const bounds = [];

        providers.forEach(function(provider, index) {
            const loc = locations[index] || { lat: 25.3176, lng: 82.9739 };
            bounds.push([loc.lat, loc.lng]);

            // Determine trip status
            let tripStatus = 'ACTIVE';
            let tripObj = null;
            if (provider.trips && provider.trips.length > 0) {
                tripObj = provider.trips[0];
                tripStatus = tripObj.status;
            }

            if (tripStatus === 'STARTED') countStarted++;
            else if (tripStatus === 'ARRIVED') countArrived++;
            else if (tripStatus === 'PICKEDUP') countPickedup++;
            else countActive++;

            // Icon Color Determination
            let markerColor = '#16A34A'; // Green
            let statusBadgeClass = 'available';
            let statusLabel = 'Available / Standby';

            if (tripStatus === 'STARTED') {
                markerColor = '#E63946'; // Red
                statusBadgeClass = 'enroute';
                statusLabel = 'Enroute to Patient';
            } else if (tripStatus === 'ARRIVED') {
                markerColor = '#f59e0b'; // Amber
                statusBadgeClass = 'arrived';
                statusLabel = 'Reached Patient';
            } else if (tripStatus === 'PICKEDUP') {
                markerColor = '#0284C7'; // Blue
                statusBadgeClass = 'transit';
                statusLabel = 'Hospital Transit';
            }

            // Create Leaflet Custom Pulse Icon
            const customIcon = L.divIcon({
                className: 'amb-pulse-marker',
                html: `
                    <div class="pulse-ring" style="border: 2px solid ${markerColor};"></div>
                    <div class="amb-marker-inner" style="background: ${markerColor};">
                        <i class="fa-solid fa-truck-medical"></i>
                    </div>
                `,
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });

            // Create Marker
            const marker = L.marker([loc.lat, loc.lng], { icon: customIcon }).addTo(map);
            markersMap[provider.id] = marker;

            // Popup HTML
            const avatarUrl = provider.avatar ? "{{ asset('storage') }}/" + provider.avatar : "{{ asset('main/avatar.jpg') }}";
            const serviceModel = (provider.service) ? (provider.service.service_model || 'Ambulance') + ' (' + (provider.service.service_number || 'UP-AMB') + ')' : 'Unassigned';
            const fleetName = (provider.fleet_company) ? provider.fleet_company.company : 'Independent Operator';
            
            let trackLink = '';
            if (tripObj && tripObj.id) {
                trackLink = `<div style="margin-top: 8px;"><a href="{{ url('/track') }}/${tripObj.id}" target="_blank" style="background: #0284C7; color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 11px; text-decoration: none; font-weight: 700; display: inline-block;"><i class="fa-solid fa-location-crosshairs"></i> Live GPS Tracking</a></div>`;
            }

            const popupContent = `
                <div style="font-family: -apple-system, system-ui; padding: 6px; min-width: 220px; font-size: 12px; color: #0F172A;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <img src="${avatarUrl}" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1.5px solid #0284C7;" onerror="this.src='{{ asset('main/avatar.jpg') }}'">
                        <div>
                            <strong style="font-size: 13px; color: #0F172A;">${provider.first_name} ${provider.last_name}</strong>
                            <div style="color: #64748B; font-size: 11px;"><i class="fa-solid fa-phone"></i> ${provider.mobile}</div>
                        </div>
                    </div>
                    <div style="border-top: 1px solid #E2E8F0; padding-top: 6px; line-height: 1.5;">
                        <div><strong>Vehicle:</strong> ${serviceModel}</div>
                        <div><strong>Fleet:</strong> ${fleetName}</div>
                        <div><strong>Status:</strong> <span style="color: ${markerColor}; font-weight: 800;">${statusLabel}</span></div>
                        ${trackLink}
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);

            // Create Sidebar Item
            const li = document.createElement('li');
            li.className = 'ambulance-feed-card';
            li.id = 'feed-card-' + provider.id;
            li.innerHTML = `
                <div class="amb-avatar-box">
                    <img src="${avatarUrl}" onerror="this.style.display='none'; this.parentElement.innerText='${provider.first_name.substr(0,1).toUpperCase()}';">
                </div>
                <div class="amb-info-box">
                    <h5>${provider.first_name} ${provider.last_name}</h5>
                    <p><i class="fa-solid fa-truck-medical" style="color: var(--cyan-bright);"></i> ${serviceModel}</p>
                    <p style="color: var(--cyan-bright); font-weight: 600;"><i class="fa-solid fa-hospital"></i> ${fleetName}</p>
                    <span class="status-badge-mini ${statusBadgeClass}">${statusLabel}</span>
                </div>
            `;

            li.onclick = function() {
                highlightAmbulance(provider.id, loc.lat, loc.lng);
            };

            listContainer.appendChild(li);
        });

        // Update Stat Counters
        document.getElementById('stat-total-online').innerText = providers.length;
        document.getElementById('stat-available').innerText = countActive;
        document.getElementById('stat-in-transit').innerText = (countStarted + countArrived + countPickedup);
        document.getElementById('sidebar-count').innerText = providers.length + " Found";

        document.getElementById('count-all').innerText = providers.length;
        document.getElementById('count-active').innerText = countActive;
        document.getElementById('count-started').innerText = countStarted;
        document.getElementById('count-arrived').innerText = countArrived;
        document.getElementById('count-pickedup').innerText = countPickedup;

        // Auto Fit Bounds if markers present
        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
        }
    }

    // 4. Highlight & Pan to Marker on Map
    function highlightAmbulance(providerId, lat, lng) {
        document.querySelectorAll('.ambulance-feed-card').forEach(el => el.classList.remove('active'));
        const card = document.getElementById('feed-card-' + providerId);
        if (card) card.classList.add('active');

        if (markersMap[providerId]) {
            map.flyTo([lat, lng], 15, { animate: true, duration: 1 });
            setTimeout(() => {
                markersMap[providerId].openPopup();
            }, 1000);
        }
    }

    // 5. Status Filter Click
    function filterByStatus(btn, status) {
        document.querySelectorAll('.btn-status-filter').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
        activeStatusFilter = status;
        fetchLiveTelemetry();
    }

    // 6. Fleet Dropdown Filter Change
    function filterByFleet(fleetId) {
        activeFleetFilter = fleetId;
        fetchLiveTelemetry();
    }

    // 7. Instant Search Filter inside Sidebar
    function filterSidebarList() {
        const query = document.getElementById('driverSearchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.ambulance-feed-card');
        let visibleCount = 0;

        cards.forEach(function(card) {
            const text = card.innerText.toLowerCase();
            if (text.includes(query)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('sidebar-count').innerText = visibleCount + " Found";
    }

    // 8. Lifecycle & Listeners
    document.addEventListener('DOMContentLoaded', function() {
        initGodsEyeMap();
        fetchLiveTelemetry();

        // Auto poll every 15 seconds
        setInterval(fetchLiveTelemetry, 15000);

        // Observer for Theme Changes
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