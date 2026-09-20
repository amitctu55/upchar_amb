<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') {{ config('constants.site_title', 'UPCHAR') }} - Ambulance Partner Portal</title>
    <link rel="shortcut icon" type="image/png" href="{{ config('constants.site_icon', asset('favicon.png')) }}"/>

    <!-- Theme Initialization Script (Default Light) -->
    <script>
      (function() {
        var savedTheme = localStorage.getItem('upchar_theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
      })();
    </script>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        :root, [data-theme="light"] {
            --navy-dark: #F1F5F9;
            --navy: #FFFFFF;
            --cyan: #0284C7;
            --crimson: #E63946;
            --green: #16A34A;
            --glass: #FFFFFF;
            --glass-border: rgba(2, 132, 199, 0.22);
            --card-bg: #FFFFFF;
            --card-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            --text-color: #0F172A;
            --slate-300: #334155;
            --slate-400: #64748B;
            --input-bg: #F8FAFC;
            --header-bg: rgba(255, 255, 255, 0.92);
            --footer-bg: #E2E8F0;
        }

        [data-theme="dark"] {
            --navy-dark: #041E2B;
            --navy: #08364B;
            --cyan: #00A8FF;
            --crimson: #E63946;
            --green: #9BC03C;
            --glass: rgba(255, 255, 255, 0.06);
            --glass-border: rgba(255, 255, 255, 0.14);
            --card-bg: rgba(8, 54, 75, 0.85);
            --card-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            --text-color: #FFFFFF;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --input-bg: rgba(4, 30, 43, 0.8);
            --header-bg: rgba(4, 30, 43, 0.85);
            --footer-bg: rgba(4, 30, 43, 0.6);
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
            overflow-x: hidden;
            position: relative;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Ambient Glow */
        .ambient-glow {
            position: fixed;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            filter: blur(140px);
            pointer-events: none;
            z-index: 0;
        }
        .glow-cyan { top: -100px; left: -100px; background: rgba(0, 168, 255, 0.15); }
        .glow-red { bottom: -100px; right: -100px; background: rgba(230, 57, 70, 0.12); }

        /* Top Header */
        .partner-header {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 5%;
            background: var(--header-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            transition: background 0.3s ease;
        }

        .brand-group {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-color);
        }

        .brand-logo-ring {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid var(--cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--navy);
            box-shadow: 0 0 15px rgba(2, 132, 199, 0.35);
        }

        .brand-logo-ring i {
            color: var(--crimson);
            font-size: 19px;
        }

        .brand-text h1 {
            font-size: 19px;
            font-weight: 900;
            letter-spacing: 2px;
            color: var(--text-color);
            margin: 0;
            line-height: 1.1;
        }

        .brand-text span {
            font-size: 9px;
            letter-spacing: 1.5px;
            color: var(--cyan);
            display: block;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Theme Switcher Button */
        .theme-toggle-header {
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

        .theme-toggle-header:hover {
            border-color: var(--cyan);
            color: var(--cyan);
            transform: scale(1.03);
        }

        [data-theme="light"] .theme-toggle-header .icon-moon { display: none; }
        [data-theme="light"] .theme-toggle-header .icon-sun { display: inline-block; color: #f59e0b; }
        [data-theme="dark"] .theme-toggle-header .icon-sun { display: none; }
        [data-theme="dark"] .theme-toggle-header .icon-moon { display: inline-block; color: var(--cyan); }

        .btn-home-link {
            color: var(--slate-300);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .btn-home-link:hover {
            color: var(--cyan);
            text-decoration: none;
        }

        .btn-helpline {
            background: var(--crimson);
            color: #ffffff !important;
            padding: 7px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 700;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 0 15px rgba(230, 57, 70, 0.4);
        }

        /* Main Auth Layout */
        .auth-container {
            position: relative;
            z-index: 5;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            width: 100%;
            flex: 1;
            display: flex;
            align-items: center;
        }

        .auth-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 40px;
            width: 100%;
            align-items: start;
        }

        /* Left Partner Info */
        .partner-showcase {
            padding: 20px 0;
        }

        .partner-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(2, 132, 199, 0.12);
            border: 1px solid var(--cyan);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            color: var(--cyan);
            margin-bottom: 16px;
        }

        .partner-headline {
            font-size: 36px;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 18px;
            color: var(--text-color);
        }

        .partner-headline span {
            background: linear-gradient(90deg, #0284C7, #16A34A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .partner-subtext {
            font-size: 15px;
            color: var(--slate-300);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .perks-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .perk-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(8px);
        }

        .perk-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(2, 132, 199, 0.12);
            color: var(--cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .perk-content h4 {
            font-size: 14px;
            font-weight: 800;
            color: var(--text-color);
            margin: 0 0 3px 0;
        }

        .perk-content p {
            font-size: 12px;
            color: var(--slate-400);
            margin: 0;
            line-height: 1.4;
        }

        /* Right Form Card */
        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 32px 28px;
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(16px);
            transition: background 0.3s ease;
        }

        .auth-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--glass-border);
        }

        .auth-card-header h3 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .auth-card-header a {
            font-size: 12px;
            font-weight: 700;
            color: var(--cyan);
            text-decoration: none;
            background: rgba(2, 132, 199, 0.1);
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid rgba(2, 132, 199, 0.3);
            transition: all 0.2s;
        }

        .auth-card-header a:hover {
            background: var(--cyan);
            color: #ffffff;
        }

        /* Form Controls Styling */
        .form-section-title {
            font-size: 11px;
            font-weight: 800;
            color: var(--cyan);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 18px 0 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section-title:first-of-type {
            margin-top: 0;
        }

        .form-section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--glass-border);
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
            height: auto !important;
        }

        .form-control-custom:focus {
            border-color: var(--cyan) !important;
            box-shadow: 0 0 12px rgba(2, 132, 199, 0.3) !important;
            outline: none !important;
        }

        .form-control-custom::placeholder {
            color: #94a3b8 !important;
        }

        select.form-control-custom option {
            background: var(--card-bg);
            color: var(--text-color);
        }

        .gender-options-wrap {
            display: flex;
            gap: 16px;
            padding: 6px 0;
        }

        .gender-radio-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--slate-300);
            cursor: pointer;
        }

        .gender-radio-label input[type="radio"] {
            accent-color: var(--cyan);
        }

        .btn-auth-submit {
            width: 100%;
            background: linear-gradient(90deg, #E63946, #c52230);
            border: none;
            color: #ffffff;
            padding: 14px;
            font-size: 15px;
            font-weight: 800;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 25px rgba(230, 57, 70, 0.4);
            margin-top: 22px;
            transition: all 0.2s;
        }

        .btn-auth-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(230, 57, 70, 0.6);
            color: #fff;
        }

        .auth-footer-help {
            text-align: center;
            margin-top: 16px;
            font-size: 12px;
            color: var(--slate-400);
        }

        .auth-footer-help a {
            color: var(--cyan);
            text-decoration: none;
            font-weight: 700;
        }

        .help-block {
            color: #f87171 !important;
            font-size: 11px !important;
            margin-top: 4px !important;
            display: block;
        }

        /* Footer */
        .auth-page-footer {
            position: relative;
            z-index: 5;
            padding: 16px 5%;
            border-top: 1px solid var(--glass-border);
            text-align: center;
            font-size: 12px;
            color: var(--slate-400);
            background: var(--footer-bg);
            transition: background 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .auth-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .partner-headline {
                font-size: 28px;
            }
            .auth-card {
                padding: 24px 18px;
            }
        }
    </style>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

    <div class="ambient-glow glow-cyan"></div>
    <div class="ambient-glow glow-red"></div>

    <!-- Top Navigation Header -->
    <header class="partner-header">
        <a href="{{ url('/') }}" class="brand-group">
            <div class="brand-logo-ring">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <div class="brand-text">
                <h1>{{ config('constants.site_title', 'UPCHAR') }}</h1>
                <span>AMBULANCE PARTNER PORTAL</span>
            </div>
        </a>

        <div class="header-actions">
            <!-- Theme Toggle Button -->
            <button type="button" class="theme-toggle-header" onclick="toggleUpcharTheme()" title="Switch Light / Dark Mode">
                <i class="fa-solid fa-sun icon-sun"></i>
                <i class="fa-solid fa-moon icon-moon"></i>
                <span class="theme-label">Light</span>
            </button>

            <a href="{{ url('/') }}" class="btn-home-link">
                <i class="fa fa-arrow-left"></i> <span>Back to Home</span>
            </a>
            <a href="tel:{{ config('constants.contact_number', '8448440603') }}" class="btn-helpline hidden-xs">
                <i class="fa fa-phone-alt"></i> {{ config('constants.contact_number', '844-844-0603') }}
            </a>
        </div>
    </header>

    <!-- Main Auth Content -->
    <div class="auth-container">
        <div class="auth-grid">
            
            <!-- Left Info Panel -->
            <div class="partner-showcase">
                <div class="partner-tag">
                    <i class="fa-solid fa-shield-heart"></i>
                    <span>VERIFIED AMBULANCE NETWORK</span>
                </div>

                <h2 class="partner-headline">
                    Drive to Save Lives.<br>
                    <span>Earn Guaranteed Income.</span>
                </h2>

                <p class="partner-subtext">
                    Join India's dedicated emergency transit platform. Connect your ambulance fleet with nearby hospital trauma centers, patients, and 24/7 centralized dispatch.
                </p>

                <ul class="perks-list">
                    <li class="perk-item">
                        <div class="perk-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div class="perk-content">
                            <h4>Instant Priority Dispatches</h4>
                            <p>Automated GPS trip assignments within your operating radius with zero delays.</p>
                        </div>
                    </li>

                    <li class="perk-item">
                        <div class="perk-icon" style="background: rgba(22, 163, 74, 0.15); color: var(--green);">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                        <div class="perk-content">
                            <h4>Guaranteed Weekly Settlements</h4>
                            <p>Direct bank transfers, transparent per-km rates, and zero hidden deductions.</p>
                        </div>
                    </li>

                    <li class="perk-item">
                        <div class="perk-icon" style="background: rgba(230, 57, 70, 0.15); color: var(--crimson);">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div class="perk-content">
                            <h4>24/7 Control Room & SOS Support</h4>
                            <p>Direct priority line to hospital emergency rooms and trauma care coordinators.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Right Form Card -->
            <div class="auth-card">
                @yield('content')
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="auth-page-footer">
        <div>{!! config('constants.site_copyright', '&copy; '.date('Y').' UPCHAR Ambulance Services. All rights reserved.') !!}</div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('asset/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>

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
