<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('constants.site_title', 'UPCHAR') }} Live Ambulance Radar | 24/7 Rapid Medical Dispatch</title>
  <meta name="description" content="Book instant GPS-tracked emergency ambulances on UPCHAR. Real-time hospital ER triage, ALS, BLS, and neonatal transport.">
  <link rel="shortcut icon" type="image/png" href="{{ config('constants.site_icon', asset('favicon.png')) }}"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Theme Initialization Script (Default is Light) -->
  <script>
    (function() {
      var savedTheme = localStorage.getItem('upchar_theme') || 'light';
      document.documentElement.setAttribute('data-theme', savedTheme);
    })();
  </script>

  <!-- Leaflet OpenStreetMap CDN -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <style>
    :root, [data-theme="light"] {
      --navy-bg: #F1F5F9;
      --card-surface: rgba(255, 255, 255, 0.94);
      --nav-surface: rgba(255, 255, 255, 0.92);
      --text-color: #0F172A;
      --text-subtle: #475569;
      --cyan: #0284C7;
      --crimson: #E63946;
      --green: #16A34A;
      --glass-border: rgba(2, 132, 199, 0.22);
      --input-box-bg: #F8FAFC;
      --input-border: #CBD5E1;
      --modal-bg: #FFFFFF;
      --modal-text: #0F172A;
      --card-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
      --veh-bg: #F8FAFC;
      --veh-selected-bg: rgba(2, 132, 199, 0.12);
    }

    [data-theme="dark"] {
      --navy-bg: #041822;
      --card-surface: rgba(8, 54, 75, 0.88);
      --nav-surface: rgba(4, 24, 34, 0.85);
      --text-color: #FFFFFF;
      --text-subtle: #CBD5E1;
      --cyan: #00A8FF;
      --crimson: #E63946;
      --green: #9BC03C;
      --glass-border: rgba(0, 168, 255, 0.25);
      --input-box-bg: rgba(4, 24, 34, 0.9);
      --input-border: rgba(0, 168, 255, 0.25);
      --modal-bg: #08364B;
      --modal-text: #FFFFFF;
      --card-shadow: 0 15px 40px rgba(0, 0, 0, 0.55);
      --veh-bg: rgba(255, 255, 255, 0.02);
      --veh-selected-bg: rgba(0, 168, 255, 0.18);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
    body { background: var(--navy-bg); color: var(--text-color); overflow-x: hidden; min-height: 100vh; position: relative; transition: background 0.3s ease, color 0.3s ease; }

    /* Map Interface Occupies the Viewport */
    #map-viewport { height: 100vh; width: 100vw; position: absolute; top: 0; left: 0; z-index: 1; }

    /* Top Floating Header */
    .floating-nav {
      position: absolute;
      top: 20px;
      left: 24px;
      right: 24px;
      z-index: 10;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: var(--nav-surface);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      padding: 12px 24px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      transition: background 0.3s ease;
    }
    .brand-head { display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-color); }
    .brand-logo-ring {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 2px solid var(--cyan);
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--nav-surface);
      box-shadow: 0 0 12px rgba(2, 132, 199, 0.4);
    }
    .brand-head i.logo-heart { color: var(--crimson); font-size: 18px; filter: drop-shadow(0 0 8px var(--crimson)); }
    .brand-head h1 { font-size: 18px; letter-spacing: 1.5px; font-weight: 900; margin: 0; line-height: 1; }
    .brand-head h1 span { color: var(--cyan); }

    .nav-actions { display: flex; align-items: center; gap: 14px; }
    .nav-link-subtle {
      color: var(--text-subtle);
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s;
    }
    .nav-link-subtle:hover {
      color: var(--cyan);
    }

    /* Theme Switcher Button */
    .theme-toggle-nav {
      background: var(--nav-surface);
      border: 1px solid var(--glass-border);
      color: var(--text-color);
      padding: 7px 14px;
      border-radius: 20px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 12px;
      font-weight: 700;
      transition: all 0.2s ease;
    }

    .theme-toggle-nav:hover {
      border-color: var(--cyan);
      transform: scale(1.03);
    }

    [data-theme="light"] .theme-toggle-nav .icon-moon { display: none; }
    [data-theme="light"] .theme-toggle-nav .icon-sun { display: inline-block; color: #f59e0b; }
    [data-theme="dark"] .theme-toggle-nav .icon-sun { display: none; }
    [data-theme="dark"] .theme-toggle-nav .icon-moon { display: inline-block; color: var(--cyan); }

    .btn-helpline {
      background: var(--crimson);
      color: #fff !important;
      text-decoration: none;
      padding: 8px 18px;
      border-radius: 30px;
      font-size: 13px;
      font-weight: 700;
      box-shadow: 0 0 15px rgba(230, 57, 70, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      animation: pulseGlow 2s infinite;
    }

    /* Left Bottom Floating Booking Matrix */
    .booking-overlay-card {
      position: absolute;
      bottom: 24px;
      left: 24px;
      width: 440px;
      max-width: calc(100vw - 48px);
      background: var(--card-surface);
      border: 1px solid var(--glass-border);
      border-radius: 20px;
      padding: 22px;
      z-index: 10;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      box-shadow: var(--card-shadow);
      color: var(--text-color);
      transition: background 0.3s ease, color 0.3s ease;
    }
    .radar-indicator {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 14px;
    }
    .badge-live-radar {
      font-size: 11px;
      font-weight: 800;
      background: rgba(22, 163, 74, 0.12);
      color: var(--green);
      border: 1px solid var(--green);
      padding: 4px 12px;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    .dot-pulse {
      width: 8px;
      height: 8px;
      background: var(--green);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--green);
      animation: ping 1.5s infinite;
    }

    /* Pickup & Drop Route Box */
    .route-box {
      background: var(--input-box-bg);
      border: 1px solid var(--input-border);
      border-radius: 12px;
      padding: 6px 12px;
      margin-bottom: 14px;
    }
    .route-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; }
    .route-row:first-child { border-bottom: 1px solid var(--input-border); }
    .route-row input, .route-row select {
      background: transparent;
      border: none;
      outline: none;
      color: var(--text-color);
      font-size: 13px;
      font-weight: 600;
      width: 100%;
    }
    .route-row select option { background: var(--modal-bg); color: var(--text-color); }

    /* Category Selectors */
    .vehicle-types { display: flex; gap: 8px; margin-bottom: 16px; }
    .vehicle-card {
      flex: 1;
      border: 1.5px solid var(--glass-border);
      border-radius: 10px;
      padding: 10px 8px;
      text-align: center;
      cursor: pointer;
      background: var(--veh-bg);
      transition: all 0.2s ease-in-out;
    }
    .vehicle-card:hover {
      border-color: var(--cyan);
      background: var(--veh-selected-bg);
    }
    .vehicle-card.selected {
      border-color: var(--cyan);
      background: var(--veh-selected-bg);
      box-shadow: 0 0 15px rgba(2, 132, 199, 0.25);
    }
    .vehicle-card h6 { font-size: 12px; margin-bottom: 4px; font-weight: 700; color: var(--text-color); }
    .vehicle-card p { font-size: 11px; color: var(--green); font-weight: 800; margin: 0; }

    .btn-dispatch {
      width: 100%;
      background: linear-gradient(90deg, #E63946, #c52230);
      border: none;
      color: #fff;
      padding: 14px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 800;
      letter-spacing: 0.5px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 8px 25px rgba(230, 57, 70, 0.45);
      transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-dispatch:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(230, 57, 70, 0.6);
    }

    .partner-sub-link {
      display: block;
      text-align: center;
      margin-top: 10px;
      font-size: 11px;
      color: var(--text-subtle);
    }
    .partner-sub-link a {
      color: var(--cyan);
      text-decoration: none;
      font-weight: 700;
    }

    /* Modal - Frictionless Auth Interceptor */
    .auth-backdrop {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      z-index: 1000;
      display: none;
      align-items: center;
      justify-content: center;
    }
    .auth-modal {
      background: var(--modal-bg);
      border: 1px solid var(--cyan);
      border-radius: 20px;
      width: 380px;
      max-width: 90vw;
      padding: 30px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
      text-align: center;
      position: relative;
      color: var(--modal-text);
    }
    .close-modal { position: absolute; top: 15px; right: 15px; color: var(--text-subtle); cursor: pointer; font-size: 18px; }
    .auth-modal h3 { font-size: 20px; margin-bottom: 8px; color: var(--modal-text); font-weight: 800; }
    .auth-modal p { font-size: 12px; color: var(--text-subtle); margin-bottom: 20px; line-height: 1.4; }
    .phone-input-group {
      display: flex;
      background: var(--input-box-bg);
      border: 1px solid var(--input-border);
      border-radius: 8px;
      padding: 10px 14px;
      margin-bottom: 16px;
      align-items: center;
      gap: 8px;
    }
    .phone-input-group span { font-weight: 700; color: var(--cyan); font-size: 15px; }
    .phone-input-group input {
      background: transparent;
      border: none;
      outline: none;
      color: var(--text-color);
      font-size: 15px;
      font-weight: 600;
      width: 100%;
    }
    .btn-verify-otp {
      width: 100%;
      background: var(--green);
      border: none;
      color: #fff;
      padding: 12px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 800;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(22, 163, 74, 0.35);
    }

    @keyframes pulseGlow {
      0% { box-shadow: 0 0 10px rgba(230, 57, 70, 0.4); }
      50% { box-shadow: 0 0 25px rgba(230, 57, 70, 0.8); }
      100% { box-shadow: 0 0 10px rgba(230, 57, 70, 0.4); }
    }

    @keyframes ping {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(22, 163, 74, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }

    @media (max-width: 600px) {
      .floating-nav {
        top: 10px;
        left: 12px;
        right: 12px;
        padding: 10px 14px;
      }
      .booking-overlay-card {
        bottom: 12px;
        left: 12px;
        right: 12px;
        width: auto;
      }
      .nav-link-subtle {
        display: none;
      }
    }
  </style>
</head>
<body>

  <!-- Map Radar Container -->
  <div id="map-viewport"></div>

  <!-- Floating Navigation Header -->
  <nav class="floating-nav">
    <a href="{{ url('/') }}" class="brand-head">
      <div class="brand-logo-ring">
        <i class="fa-solid fa-heart-pulse logo-heart"></i>
      </div>
      <h1>UPCHAR <span>RADAR</span></h1>
    </a>

    <div class="nav-actions">
      <!-- Theme Switcher -->
      <button type="button" class="theme-toggle-nav" onclick="toggleUpcharTheme()" title="Switch Light / Dark Mode">
        <i class="fa-solid fa-sun icon-sun"></i>
        <i class="fa-solid fa-moon icon-moon"></i>
        <span class="theme-label hidden-xs">Light</span>
      </button>

      <a href="{{ url('/provider/register') }}" class="nav-link-subtle hidden-xs">
        <i class="fa-solid fa-id-card"></i> Driver Partner
      </a>
      <a href="{{ url('/login') }}" class="nav-link-subtle">
        <i class="fa-solid fa-user"></i> Sign In
      </a>
      <a href="tel:{{ config('constants.contact_number', '8448440603') }}" class="btn-helpline">
        <i class="fa-solid fa-phone"></i> {{ config('constants.contact_number', '844-844-0603') }}
      </a>
    </div>
  </nav>

  <!-- Guest Booking Overlay -->
  <div class="booking-overlay-card">
    <div class="radar-indicator">
      <div class="badge-live-radar">
        <span class="dot-pulse"></span> 14 Ambulances Available Nearby
      </div>
      <span style="font-size:11px; color:var(--text-subtle);">Avg arrival: <strong>9 mins</strong></span>
    </div>

    <!-- Route Selector -->
    <div class="route-box">
      <div class="route-row">
        <i class="fa-solid fa-location-crosshairs" style="color:var(--cyan)"></i>
        <input type="text" id="guest_pickup" value="Sigra, Varanasi (Detected GPS)" placeholder="Confirm Pickup Point">
      </div>
      <div class="route-row">
        <i class="fa-solid fa-hospital" style="color:var(--crimson)"></i>
        <select id="guest_hospital">
          <option value="1">Oriana Hospital Emergency (2.3 km away)</option>
          <option value="2">Apex Hospital Trauma Wing (5.1 km away)</option>
          <option value="3">Kashi Medicare ER (3.8 km away)</option>
          <option value="0">Custom Destination...</option>
        </select>
      </div>
    </div>

    <!-- Category Selector -->
    <div class="vehicle-types">
      <div class="vehicle-card selected" onclick="pickCategory(this, 'BLS', 800)">
        <h6>BLS Unit</h6>
        <p>₹ 800</p>
      </div>
      <div class="vehicle-card" onclick="pickCategory(this, 'ALS', 1800)">
        <h6>Cardiac ALS</h6>
        <p>₹ 1,800</p>
      </div>
      <div class="vehicle-card" onclick="pickCategory(this, 'NEO', 2200)">
        <h6>Neonatal</h6>
        <p>₹ 2,200</p>
      </div>
    </div>

    <!-- The Auth Gate Trigger Button -->
    <button class="btn-dispatch" onclick="attemptBooking()">
      <i class="fa-solid fa-bolt"></i> REQUEST EMERGENCY VEHICLE
    </button>

    <div class="partner-sub-link">
      Ambulance Driver or Fleet Owner? <a href="{{ url('/provider/register') }}">Join Network</a>
    </div>
  </div>

  <!-- Frictionless Phone OTP Auth Gate Modal -->
  <div class="auth-backdrop" id="authModal">
    <div class="auth-modal">
      <span class="close-modal" onclick="closeAuth()">&times;</span>
      <i class="fa-solid fa-shield-heart" style="font-size:36px; color:var(--cyan); margin-bottom:12px; display:inline-block;"></i>
      <h3>Confirm Your Contact</h3>
      <p>Enter your mobile number to receive driver tracking details and coordinate your emergency transport.</p>

      <div class="phone-input-group">
        <span>+91</span>
        <input type="tel" id="auth_phone" placeholder="98765 43210" maxlength="10">
      </div>

      <div class="phone-input-group" id="otpBox" style="display:none;">
        <input type="text" id="auth_otp" placeholder="Enter 4-Digit OTP" maxlength="4" style="text-align:center; letter-spacing:4px;">
      </div>

      <button class="btn-verify-otp" id="authActionBtn" onclick="handleAuth()">SEND VERIFICATION CODE</button>
      <small style="display:block; margin-top:14px; font-size:11px; color:var(--text-subtle);">Protected by UPCHAR Safe Patient Protocol</small>
    </div>
  </div>

  <!-- Map Initialization & Logic -->
  <script>
    // 1. Initialize Map Centered on Regional Hub (Varanasi: 25.3176, 82.9739)
    const map = L.map('map-viewport', { zoomControl: false }).setView([25.3176, 82.9739], 13);
    
    let currentTileLayer = null;

    function applyMapTiles(theme) {
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

    var initialTheme = document.documentElement.getAttribute('data-theme') || 'light';
    applyMapTiles(initialTheme);

    function toggleUpcharTheme() {
      var curTheme = document.documentElement.getAttribute('data-theme') || 'light';
      var newTheme = curTheme === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('upchar_theme', newTheme);
      applyMapTiles(newTheme);

      var labels = document.querySelectorAll('.theme-label');
      labels.forEach(function(el) {
        el.innerText = newTheme === 'dark' ? 'Dark' : 'Light';
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      var curTheme = document.documentElement.getAttribute('data-theme') || 'light';
      var labels = document.querySelectorAll('.theme-label');
      labels.forEach(function(el) {
        el.innerText = curTheme === 'dark' ? 'Dark' : 'Light';
      });
    });

    // Try HTML5 Geolocation to center on user
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(pos) {
        map.setView([pos.coords.latitude, pos.coords.longitude], 14);
        
        // Add User Marker
        const userIcon = L.divIcon({
          className: 'custom-user-pin',
          html: '<div style="background:#00A8FF; border:3px solid #fff; border-radius:50%; width:18px; height:18px; box-shadow:0 0 15px #00A8FF;"></div>',
          iconSize: [18, 18]
        });
        L.marker([pos.coords.latitude, pos.coords.longitude], { icon: userIcon }).addTo(map)
          .bindPopup("<strong>Your Location</strong>");
      }, function() {});
    }

    // 2. Plot Real-Time Guest Ambulances around coordinates
    const ambulanceIcon = L.divIcon({
      className: 'custom-amb-pin',
      html: '<div style="background:#E63946; border:2px solid #fff; border-radius:50%; width:30px; height:30px; display:flex; align-items:center; justify-content:center; box-shadow:0 0 15px #E63946;"><i class="fa-solid fa-truck-medical" style="color:#fff; font-size:13px;"></i></div>',
      iconSize: [30, 30]
    });

    const dummyAmbulances = [
      { coords: [25.3210, 82.9810], title: 'UPCHAR Ambulance (ALS Ready)', eta: '5 mins away' },
      { coords: [25.3090, 82.9650], title: 'UPCHAR BLS Oxygen Unit', eta: '8 mins away' },
      { coords: [25.3280, 82.9700], title: 'UPCHAR ICU Ventilator Unit', eta: '10 mins away' },
      { coords: [25.3000, 82.9900], title: 'UPCHAR Neonatal Care Unit', eta: '12 mins away' }
    ];

    dummyAmbulances.forEach(amb => {
      L.marker(amb.coords, { icon: ambulanceIcon }).addTo(map)
        .bindPopup("<div style='padding:4px;'><strong>" + amb.title + "</strong><br><span style='color:#16A34A; font-weight:700;'><i class='fa fa-clock'></i> " + amb.eta + "</span></div>");
    });

    // 3. Category Switching
    let currentCategory = 'BLS';
    function pickCategory(element, cat, fare) {
      document.querySelectorAll('.vehicle-card').forEach(el => el.classList.remove('selected'));
      element.classList.add('selected');
      currentCategory = cat;
    }

    // 4. Session & Auth State Management
    let isAuthenticated = @if(Auth::check()) true @else false @endif;

    function attemptBooking() {
      if (!isAuthenticated) {
        document.getElementById('authModal').style.display = 'flex';
      } else {
        executeDispatch();
      }
    }

    function closeAuth() {
      document.getElementById('authModal').style.display = 'none';
    }

    // 5. Frictionless Phone/OTP Verification Step
    let otpSent = false;
    function handleAuth() {
      const phone = document.getElementById('auth_phone').value;
      const btn = document.getElementById('authActionBtn');

      if (!otpSent) {
        if (phone.length < 10) {
          alert('Please enter a valid 10-digit mobile number');
          return;
        }
        btn.innerText = "VERIFY & CONFIRM DISPATCH";
        document.getElementById('otpBox').style.display = 'flex';
        otpSent = true;
      } else {
        const otp = document.getElementById('auth_otp').value;
        if (otp.length < 4) {
          alert('Please enter the 4-digit verification code');
          return;
        }
        isAuthenticated = true;
        closeAuth();
        executeDispatch();
      }
    }

    function executeDispatch() {
      const hospitalName = document.getElementById('guest_hospital').options[document.getElementById('guest_hospital').selectedIndex].text;
      const bookingCode = "UPAMB-" + Math.floor(1000 + Math.random() * 9000);
      alert("🚑 Emergency Confirmed!\n\nBooking ID: " + bookingCode + "\nCategory: " + currentCategory + "\nDestination: " + hospitalName + "\n\nNearest Ambulance is en-route with live telemetry.");
    }
  </script>
</body>
</html>