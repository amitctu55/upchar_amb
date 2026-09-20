<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="UPCHAR Emergency Ambulance - Admin Command Center">
    <meta name="author" content="UPCHAR Ambulance">

    <title>{{ config('constants.site_title', 'UPCHAR') }} - Control & Dispatch Command Center</title>
    <link rel="shortcut icon" type="image/png" href="{{ config('constants.site_icon', asset('favicon.png')) }}"/>

    <!-- Theme Initialization Script -->
    <script>
      (function() {
        var savedTheme = localStorage.getItem('upchar_theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
      })();
    </script>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('main/vendor/bootstrap4/bootstrap.min.css') }}">

    <style>
        :root, [data-theme="light"] {
            --navy-dark: #F1F5F9;
            --navy: #FFFFFF;
            --cyan: #0284C7;
            --crimson: #E63946;
            --green: #16A34A;
            --glass: rgba(0, 0, 0, 0.03);
            --glass-border: rgba(2, 132, 199, 0.25);
            --card-bg: #FFFFFF;
            --card-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            --text-color: #0F172A;
            --slate-300: #334155;
            --slate-400: #64748B;
            --input-bg: #F8FAFC;
            --tab-bg: #F1F5F9;
        }

        [data-theme="dark"] {
            --navy-dark: #041E2B;
            --navy: #08364B;
            --cyan: #00A8FF;
            --crimson: #E63946;
            --green: #9BC03C;
            --glass: rgba(255, 255, 255, 0.06);
            --glass-border: rgba(255, 255, 255, 0.12);
            --card-bg: rgba(8, 54, 75, 0.88);
            --card-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
            --text-color: #FFFFFF;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --input-bg: rgba(4, 30, 43, 0.8);
            --tab-bg: rgba(4, 30, 43, 0.8);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: var(--navy-dark);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            position: relative;
            padding: 40px 15px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Ambient Glow */
        .ambient-glow {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(150px);
            pointer-events: none;
            z-index: 0;
        }
        .glow-cyan { top: -100px; left: -100px; background: rgba(0, 168, 255, 0.15); }
        .glow-red { bottom: -100px; right: -100px; background: rgba(230, 57, 70, 0.12); }

        .auth-wrapper {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 680px;
            margin: 0 auto;
        }

        /* Top Bar with Home & Theme Switcher */
        .auth-topbar-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .theme-toggle-auth {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-color);
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transition: all 0.2s;
        }

        .theme-toggle-auth:hover {
            border-color: var(--cyan);
            color: var(--cyan);
            transform: scale(1.03);
        }

        [data-theme="light"] .theme-toggle-auth .icon-moon { display: none; }
        [data-theme="light"] .theme-toggle-auth .icon-sun { display: inline-block; color: #f59e0b; }
        [data-theme="dark"] .theme-toggle-auth .icon-sun { display: none; }
        [data-theme="dark"] .theme-toggle-auth .icon-moon { display: inline-block; color: var(--cyan); }

        .brand-header-box {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo-ring {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            border: 2px solid var(--cyan);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--navy);
            box-shadow: 0 0 25px rgba(2, 132, 199, 0.4);
            margin-bottom: 12px;
        }

        .brand-logo-ring i {
            color: var(--crimson);
            font-size: 24px;
        }

        .brand-header-box h1 {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 2px;
            color: var(--text-color);
            margin: 0;
        }

        .brand-header-box span {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: var(--cyan);
            text-transform: uppercase;
            display: block;
            margin-top: 4px;
        }

        /* Command Center Card */
        .command-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(18px);
            transition: background 0.3s ease;
        }

        /* Nav Tabs */
        .nav-portal-tabs {
            display: flex;
            background: var(--tab-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 26px;
            list-style: none;
            gap: 4px;
        }

        .nav-portal-tabs .nav-item {
            flex: 1;
            text-align: center;
        }

        .nav-portal-tabs .nav-link {
            color: var(--slate-400);
            font-size: 12px;
            font-weight: 700;
            padding: 9px 4px;
            border-radius: 8px;
            text-decoration: none;
            display: block;
            transition: all 0.2s;
            border: none;
            background: transparent;
        }

        .nav-portal-tabs .nav-link:hover {
            color: var(--text-color);
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-portal-tabs .nav-link.active {
            background: var(--cyan);
            color: #ffffff;
            box-shadow: 0 0 15px rgba(2, 132, 199, 0.4);
        }

        /* Form Controls */
        .form-group-custom {
            margin-bottom: 18px;
        }

        .form-group-custom label {
            font-size: 11px;
            font-weight: 700;
            color: var(--slate-400);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            display: block;
        }

        .form-control-custom {
            width: 100%;
            background: var(--input-bg) !important;
            border: 1.5px solid var(--glass-border) !important;
            border-radius: 10px !important;
            color: var(--text-color) !important;
            padding: 12px 14px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
        }

        .form-control-custom:focus {
            border-color: var(--cyan) !important;
            box-shadow: 0 0 12px rgba(2, 132, 199, 0.3) !important;
            outline: none !important;
        }

        .btn-portal-submit {
            width: 100%;
            background: linear-gradient(90deg, #E63946, #c52230);
            border: none;
            color: #ffffff;
            padding: 14px;
            font-size: 14px;
            font-weight: 800;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 25px rgba(230, 57, 70, 0.4);
            margin-top: 10px;
            transition: all 0.2s;
        }

        .btn-portal-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(230, 57, 70, 0.6);
            color: #ffffff;
        }

        .demo-credentials-box {
            margin-top: 20px;
            background: rgba(2, 132, 199, 0.08);
            border: 1px dashed rgba(2, 132, 199, 0.3);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 12px;
            color: var(--slate-300);
        }

        .demo-credentials-box strong {
            color: var(--cyan);
        }

        .back-home-strip {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }

        .back-home-strip a {
            color: var(--cyan);
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-home-strip a:hover {
            color: var(--crimson);
        }

        @media (max-width: 600px) {
            .nav-portal-tabs {
                flex-wrap: wrap;
            }
            .nav-portal-tabs .nav-item {
                flex: 1 1 45%;
            }
            .command-card {
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-glow glow-cyan"></div>
    <div class="ambient-glow glow-red"></div>

    <div class="auth-wrapper">
        <div class="auth-topbar-actions">
            <a href="{{ url('/') }}" style="color: var(--cyan); text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-arrow-left"></i> Main Public Portal
            </a>

            <button type="button" class="theme-toggle-auth" onclick="toggleUpcharTheme()" title="Switch Light / Dark Mode">
                <i class="fa-solid fa-sun icon-sun"></i>
                <i class="fa-solid fa-moon icon-moon"></i>
                <span class="theme-label">Light</span>
            </button>
        </div>

        <div class="brand-header-box">
            <div class="brand-logo-ring">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <h1>{{ config('constants.site_title', 'UPCHAR') }}</h1>
            <span>Command & Dispatch Operations</span>
        </div>

        <div class="command-card">
            @yield('content')
        </div>

        <div class="back-home-strip">
            <a href="{{ url('/') }}"><i class="fa fa-arrow-left"></i> Return to Main Public Portal</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('main/vendor/jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('main/vendor/bootstrap4/bootstrap.min.js') }}"></script>

    <script>
      function toggleUpcharTheme() {
        var curTheme = document.documentElement.getAttribute('data-theme') || 'light';
        var newTheme = curTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('upchar_theme', newTheme);

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
    </script>

    @yield('scripts')
</body>
</html>
