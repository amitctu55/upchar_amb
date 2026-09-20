<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="UPCHAR Emergency Operations Center">
    <meta name="author" content="UPCHAR Ambulance">

    <title>@yield('title'){{ config('constants.site_title', 'UPCHAR') }} - Emergency Operations Center</title>

    <link rel="shortcut icon" type="image/png" href="{{ config('constants.site_icon', asset('favicon.png')) }}">

    <!-- Theme Initialization Script (Prevents flash of unstyled theme, default is light) -->
    <script>
      (function() {
        var savedTheme = localStorage.getItem('upchar_theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
      })();
    </script>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('main/vendor/bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/DataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/bootstrap-datepicker.min.css') }}">

    <style>
      :root, [data-theme="light"] {
        --bg-surface: #F1F5F9;
        --panel-navy: #FFFFFF;
        --card-glass: #FFFFFF;
        --card-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
        --border-line: rgba(0, 168, 255, 0.25);
        --cyan-bright: #0284C7;
        --crimson-alert: #E63946;
        --green-status: #16A34A;
        --text-main: #0F172A;
        --text-dim: #64748B;
        --sidebar-bg: #FFFFFF;
        --sidebar-border: #E2E8F0;
        --sidebar-text: #334155;
        --topbar-bg: rgba(255, 255, 255, 0.92);
        --table-head-bg: #F8FAFC;
        --table-border: #E2E8F0;
        --input-bg: #FFFFFF;
        --input-color: #0F172A;
        --dropdown-bg: #FFFFFF;
        --dropdown-color: #334155;
        --stat-pill-bg: #FFFFFF;
      }

      [data-theme="dark"] {
        --bg-surface: #041822;
        --panel-navy: #08364B;
        --card-glass: rgba(8, 54, 75, 0.65);
        --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
        --border-line: rgba(0, 168, 255, 0.18);
        --cyan-bright: #00A8FF;
        --crimson-alert: #E63946;
        --green-status: #9BC03C;
        --text-main: #FFFFFF;
        --text-dim: #94A3B8;
        --sidebar-bg: rgba(4, 24, 34, 0.96);
        --sidebar-border: rgba(0, 168, 255, 0.18);
        --sidebar-text: #cbd5e1;
        --topbar-bg: rgba(8, 54, 75, 0.55);
        --table-head-bg: rgba(4, 24, 34, 0.7);
        --table-border: rgba(255, 255, 255, 0.06);
        --input-bg: rgba(4, 24, 34, 0.8);
        --input-color: #FFFFFF;
        --dropdown-bg: #08364B;
        --dropdown-color: #cbd5e1;
        --stat-pill-bg: rgba(255, 255, 255, 0.05);
      }

      * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif; }
      body { background: var(--bg-surface); color: var(--text-main); display: flex; min-height: 100vh; overflow-x: hidden; transition: background 0.3s ease, color 0.3s ease; }

      /* Layout Wrapper */
      .admin-layout-wrapper { display: flex; width: 100%; min-height: 100vh; }

      /* Sidebar */
      .admin-sidebar {
        width: 270px;
        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        z-index: 100;
        transition: transform 0.3s ease, background 0.3s ease;
      }

      .brand-box {
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid var(--sidebar-border);
        background: var(--sidebar-bg);
      }

      .nav-list { list-style: none; padding: 12px 10px 40px; overflow-y: auto; flex: 1; margin: 0; }
      .nav-label { font-size: 10px; text-transform: uppercase; color: var(--cyan-bright); padding: 14px 12px 4px; font-weight: 800; letter-spacing: 1px; }
      .nav-label:first-child { padding-top: 6px; }
      
      .nav-item a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 9px 14px;
        color: var(--sidebar-text);
        text-decoration: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
        margin-bottom: 3px;
      }

      .nav-item a:hover, .nav-item.active a {
        background: rgba(0, 168, 255, 0.12);
        color: var(--cyan-bright);
        border-left: 3px solid var(--cyan-bright);
        text-decoration: none;
      }
      .nav-item a i { width: 18px; text-align: center; font-size: 14px; }

      /* Main Content Viewport */
      .admin-main-viewport {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
        background: var(--bg-surface);
        overflow-y: auto;
      }

      /* Topbar */
      .admin-topbar {
        min-height: 62px;
        background: var(--topbar-bg);
        border-bottom: 1px solid var(--border-line);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 24px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        position: sticky;
        top: 0;
        z-index: 90;
        transition: background 0.3s ease;
      }

      .quick-stats { display: flex; align-items: center; gap: 14px; }
      .stat-pill {
        font-size: 12px;
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        color: var(--text-main);
        padding: 5px 14px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 6px;
      }

      /* Theme Toggle Switcher Button */
      .theme-toggle-btn {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        color: var(--text-main);
        padding: 6px 14px;
        border-radius: 20px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        transition: all 0.2s ease;
      }

      .theme-toggle-btn:hover {
        border-color: var(--cyan-bright);
        color: var(--cyan-bright);
        transform: scale(1.03);
      }

      [data-theme="light"] .theme-toggle-btn .icon-moon { display: none; }
      [data-theme="light"] .theme-toggle-btn .icon-sun { display: inline-block; color: #f59e0b; }
      [data-theme="dark"] .theme-toggle-btn .icon-sun { display: none; }
      [data-theme="dark"] .theme-toggle-btn .icon-moon { display: inline-block; color: var(--cyan-bright); }

      /* Page Canvas */
      .content-canvas { padding: 24px; flex: 1; }

      /* Glass Cards */
      .glass-card, .box.bg-white, .table-container-card, .form-glass-card, .doc-glass-card {
        background: var(--card-glass) !important;
        border: 1px solid var(--border-line) !important;
        border-radius: 14px !important;
        padding: 22px !important;
        box-shadow: var(--card-shadow) !important;
        backdrop-filter: blur(14px) !important;
        -webkit-backdrop-filter: blur(14px) !important;
        margin-bottom: 24px !important;
        color: var(--text-main) !important;
        transition: background 0.3s ease, color 0.3s ease;
      }

      .glass-card h4, .glass-card h5, .glass-card h6,
      .box.bg-white h4, .box.bg-white h5, .box.bg-white h6,
      .table-container-card h4, .form-glass-card h4, .doc-glass-card h5 {
        color: var(--text-main) !important;
      }

      .table { color: var(--text-main) !important; }
      .table th { background: var(--table-head-bg) !important; border-color: var(--table-border) !important; color: var(--cyan-bright) !important; font-weight: 700 !important; }
      .table td { border-color: var(--table-border) !important; color: var(--text-main) !important; }

      .form-control {
        background: var(--input-bg) !important;
        border: 1px solid var(--border-line) !important;
        color: var(--input-color) !important;
        border-radius: 8px !important;
      }
      .form-control:focus {
        border-color: var(--cyan-bright) !important;
        box-shadow: 0 0 10px rgba(0, 168, 255, 0.3) !important;
      }

      .dropdown-menu {
        background: var(--dropdown-bg) !important;
        border: 1px solid var(--border-line) !important;
        color: var(--dropdown-color) !important;
      }

      /* Mobile responsiveness */
      @media (max-width: 900px) {
        .admin-sidebar {
          position: fixed;
          top: 0; bottom: 0; left: 0;
          transform: translateX(-100%);
        }
        .admin-sidebar.open {
          transform: translateX(0);
          box-shadow: 0 0 40px rgba(0, 0, 0, 0.8);
        }
      }
    </style>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @yield('styles')
</head>
<body>

  <div class="admin-layout-wrapper">
    <!-- Sidebar Navigation -->
    @include('admin.include.nav')

    <!-- Main Viewport -->
    <div class="admin-main-viewport">
      @include('admin.include.header')

      <div class="content-canvas">
        @include('common.notify')
        @yield('content')
      </div>
    </div>
  </div>

  <!-- Vendor JS -->
  <script type="text/javascript" src="{{ asset('main/vendor/jquery/jquery-1.12.3.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/tether/js/tether.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/bootstrap4/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/switchery/dist/switchery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/dropify/dist/js/dropify.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/js/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/js/dataTables.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/Responsive/js/dataTables.responsive.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/Responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/Buttons/js/dataTables.buttons.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/Buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/JSZip/jszip.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/pdfmake/build/pdfmake.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/pdfmake/build/vfs_fonts.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/Buttons/js/buttons.html5.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('main/vendor/DataTables/Buttons/js/buttons.print.min.js') }}"></script>

  <script>
    function toggleSidebar() {
      var sidebar = document.getElementById('adminSidebar');
      if (sidebar) {
        sidebar.classList.toggle('open');
      }
    }

    function toggleUpcharTheme() {
      var currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
      var newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('upchar_theme', newTheme);
      
      // Update label text if present
      var labels = document.querySelectorAll('.theme-label');
      labels.forEach(function(el) {
        el.innerText = newTheme === 'dark' ? 'Dark' : 'Light';
      });
    }

    // Update label on load
    document.addEventListener('DOMContentLoaded', function() {
      var activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
      var labels = document.querySelectorAll('.theme-label');
      labels.forEach(function(el) {
        el.innerText = activeTheme === 'dark' ? 'Dark' : 'Light';
      });
    });
  </script>

  @yield('scripts')

</body>
</html>