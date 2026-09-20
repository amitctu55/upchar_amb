<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('constants.site_title', 'Upchar Ambulance - Emergency Medical Transit') }}</title>

    <!-- Theme Initialization Script (Default Light) -->
    <script>
      (function() {
        var savedTheme = localStorage.getItem('upchar_theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
      })();
    </script>

    <meta name="description" content="Fast, 24/7 emergency ambulance booking network with Basic Life Support (BLS), Advanced Cardiac Life Support (ALS), and ICU Ventilator Ambulances.">
    <meta name="author" content="Upchar Ambulance">
    <link rel="shortcut icon" type="image/png" href="{{ config('constants.site_icon', asset('favicon.png')) }}"/>

    <!-- Bootstrap & FontAwesome Icons -->
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    
    <!-- Modern Upchar Design System -->
    <link href="{{ asset('asset/css/landing.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
</head>
<body class="upchar-page">

    <!-- Top Emergency Hotline Bar -->
    <div class="emergency-top-bar">
        <div class="container">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                <div class="live-pulse">
                    <span class="pulse-dot"></span>
                    <span><strong>RAPID DISPATCH:</strong> 24/7 Emergency Ambulance Network Active</span>
                </div>
                <div style="display: flex; align-items: center; gap: 14px;">
                    <span class="hidden-xs" style="font-size: 12px; opacity: 0.9;"><i class="fa fa-map-marker"></i> Available Across All Major Cities</span>
                    <a href="tel:{{ config('constants.sos_number', '108') }}" class="topbar-sos-btn">
                        <i class="fa fa-phone"></i>
                        <span>SOS: {{ config('constants.sos_number', '108') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="upchar-nav">
        <div class="container nav-container">
            
            <!-- Brand Logo -->
            <a class="brand-logo-wrap" href="{{ url('/') }}">
                <img src="{{ config('constants.site_logo', asset('logo-black.png')) }}" alt="{{ config('constants.site_title', 'Upchar') }}" onerror="this.style.display='none'">
                <div class="brand-title-badge">
                    <span class="brand-name">{{ config('constants.site_title', 'Upchar Ambulance') }}</span>
                    <span class="brand-tagline">Emergency Healthcare Transit</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <ul class="nav-links-desktop">
                <li><a href="{{ url('/') }}" @if(Request::is('/')) class="active" @endif>Home</a></li>
                <li><a href="{{ url('/#fleet') }}">Ambulance Fleet</a></li>
                <li><a href="{{ url('/#how-it-works') }}">How It Works</a></li>
                <li><a href="{{ url('/#features') }}">Features</a></li>
                <li><a href="{{ url('/#coverage') }}">Coverage</a></li>
                <li><a href="{{ url('/help') }}" @if(Request::is('help')) class="active" @endif>24/7 Help</a></li>
            </ul>

            <!-- Navigation Actions -->
            <div class="nav-actions-wrap" style="display: flex; align-items: center; gap: 12px;">
                <!-- Theme Switcher -->
                <button type="button" class="theme-toggle-btn-user" onclick="toggleUpcharTheme()" title="Switch Light / Dark Mode" style="background: transparent; border: 1px solid rgba(0, 168, 255, 0.4); color: inherit; padding: 6px 12px; border-radius: 20px; cursor: pointer; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa fa-sun-o icon-sun" style="color: #f59e0b;"></i>
                    <i class="fa fa-moon-o icon-moon" style="display:none; color: #00A8FF;"></i>
                    <span class="theme-label hidden-xs">Light</span>
                </button>

                <a href="{{ url('/provider/register') }}" class="btn-nav-outline hidden-xs">
                    <i class="fa fa-id-card-o"></i>
                    <span>Driver / Fleet Partner</span>
                </a>
                <a href="{{ url('/login') }}" class="btn-nav-primary">
                    <i class="fa fa-ambulance"></i>
                    <span>Book / Sign In</span>
                </a>
            </div>

        </div>
    </header>

    <!-- Main Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Support Callout Bar -->
    <div style="background: linear-gradient(135deg, #0b132b 0%, #1e293b 100%); padding: 40px 0; color: #ffffff; border-top: 1px solid rgba(255,255,255,0.08);">
        <div class="container">
            <div class="row" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                <div class="col-md-7 col-sm-12">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: #e63946; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #fff; flex-shrink: 0;">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div>
                            <h3 style="color: #ffffff; font-size: 22px; font-weight: 800; margin: 0 0 4px 0;">Need Immediate Medical Assistance?</h3>
                            <p style="color: #cbd5e1; font-size: 14px; margin: 0;">Our emergency medical dispatchers are standing by 24 hours a day, 365 days a year.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12" style="text-align: right;">
                    <a href="tel:{{ config('constants.contact_number', '+919791101817') }}" style="background: #e63946; color: #fff; padding: 12px 28px; border-radius: 999px; font-weight: 800; font-size: 16px; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 15px rgba(230,57,70,0.4);">
                        <i class="fa fa-phone"></i>
                        <span>{{ config('constants.contact_number', '+91 97911 01817') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Redesigned Modern Upchar Footer -->
    <footer class="upchar-footer">
        <div class="container">
            <div class="footer-top-grid">
                
                <!-- Col 1: Brand & Emergency -->
                <div class="footer-col">
                    <div class="brand-title-badge" style="margin-bottom: 12px;">
                        <span class="brand-name" style="color: #ffffff;">{{ config('constants.site_title', 'Upchar Ambulance') }}</span>
                        <span class="brand-tagline">Emergency Healthcare Transit</span>
                    </div>
                    <p class="footer-brand-p">
                        Empowering patients with reliable, technology-driven emergency medical transport and rapid ICU ambulance dispatches across India.
                    </p>

                    <div class="footer-sos-card">
                        <span class="sos-label">Emergency SOS Hotline</span>
                        <a href="tel:{{ config('constants.sos_number', '108') }}" class="sos-tel">
                            <i class="fa fa-phone" style="color: #ef4444; margin-right: 6px;"></i>
                            {{ config('constants.sos_number', '108') }}
                        </a>
                    </div>
                </div>

                <!-- Col 2: Ambulance Services -->
                <div class="footer-col">
                    <h4>Ambulance Services</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/#fleet') }}">Basic Life Support (BLS)</a></li>
                        <li><a href="{{ url('/#fleet') }}">Advanced Life Support (ALS)</a></li>
                        <li><a href="{{ url('/#fleet') }}">ICU on Wheels (Ventilator)</a></li>
                        <li><a href="{{ url('/#fleet') }}">Neonatal & Pediatric Care</a></li>
                        <li><a href="{{ url('/#fleet') }}">Inter-City Hospital Shifting</a></li>
                        <li><a href="{{ url('/#fleet') }}">Mortuary Van Services</a></li>
                    </ul>
                </div>

                <!-- Col 3: Quick Links & Partners -->
                <div class="footer-col">
                    <h4>Quick Links & Portals</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/register') }}">Book Ambulance Online</a></li>
                        <li><a href="{{ url('/provider/register') }}">Join as Driver Partner</a></li>
                        <li><a href="{{ url('/fleet/login') }}">Fleet Operator Portal</a></li>
                        <li><a href="{{ url('/help') }}">Help & Emergency Guide</a></li>
                        <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ url('/terms') }}">Terms of Service</a></li>
                        <li><a href="{{ url('/cancellation') }}">Cancellation Policy</a></li>
                    </ul>
                </div>

                <!-- Col 4: App Download & Social -->
                <div class="footer-col">
                    <h4>Download Mobile App</h4>
                    <p style="color: var(--slate-400); font-size: 13px; margin-bottom: 14px;">
                        Get instant access to ambulance dispatch with real-time GPS tracking.
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a target="_blank" href="{{ config('constants.store_link_android_user', '#') }}">
                            <img src="{{ asset('asset/img/user-playstore.png') }}" style="height: 40px;" alt="Google Play">
                        </a>
                        <a target="_blank" href="{{ config('constants.store_link_ios_user', '#') }}">
                            <img src="{{ asset('asset/img/user-appstore.png') }}" style="height: 40px;" alt="App Store">
                        </a>
                    </div>

                    <div class="footer-social-links">
                        <a target="_blank" href="{{ config('constants.store_facebook_link', '#') }}" class="social-circle"><i class="fa fa-facebook"></i></a>
                        <a target="_blank" href="{{ config('constants.store_twitter_link', '#') }}" class="social-circle"><i class="fa fa-twitter"></i></a>
                        <a href="mailto:{{ config('constants.contact_email', 'support@upchar.com') }}" class="social-circle"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Bar -->
            <div class="footer-bottom-bar">
                <div>
                    {!! config('constants.site_copyright', '&copy; '.date('Y').' Upchar Ambulance Services. All rights reserved.') !!}
                </div>
                <div class="footer-bottom-links">
                    <a href="{{ url('/privacy') }}">Privacy Policy</a>
                    <a href="{{ url('/terms') }}">Terms of Use</a>
                    <a href="{{ url('/cancellation') }}">Cancellation</a>
                    <a href="{{ url('/help') }}">Support</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- City Availability Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: var(--upchar-navy); color: #fff; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 1;">&times;</button>
                    <h4 class="modal-title" style="color: #fff; font-weight: 800;"><i class="fa fa-check-circle" style="color: #10b981;"></i> Service Available in Your Area</h4>
                </div>
                <div class="modal-body" style="padding: 24px; font-size: 15px; color: var(--slate-700);">
                    <p><strong>{{ config('constants.site_title', 'Upchar Ambulance') }}</strong> operates rapid response emergency ambulance fleets 24/7 across your selected zone.</p>
                    <div style="background: var(--upchar-red-light); padding: 14px; border-radius: 10px; color: #b91c1c; font-size: 13px; font-weight: 600; margin-top: 14px;">
                        <i class="fa fa-clock-o"></i> Average ambulance arrival time in this zone: <strong>8-12 minutes</strong>.
                    </div>
                </div>
                <div class="modal-footer" style="padding: 16px 24px;">
                    <a href="{{ url('/register') }}" class="btn btn-danger" style="background: var(--upchar-red); border: none; font-weight: 700; border-radius: 8px; padding: 8px 20px;">Book Ambulance Now</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Scripts -->
    <script src="{{ asset('asset/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>

    <script>
      function toggleUpcharTheme() {
        var curTheme = document.documentElement.getAttribute('data-theme') || 'light';
        var newTheme = curTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('upchar_theme', newTheme);

        var isDark = newTheme === 'dark';
        var suns = document.querySelectorAll('.icon-sun');
        var moons = document.querySelectorAll('.icon-moon');
        var labels = document.querySelectorAll('.theme-label');

        suns.forEach(function(el) { el.style.display = isDark ? 'none' : 'inline-block'; });
        moons.forEach(function(el) { el.style.display = isDark ? 'inline-block' : 'none'; });
        labels.forEach(function(el) { el.innerText = isDark ? 'Dark' : 'Light'; });
      }

      document.addEventListener('DOMContentLoaded', function() {
        var curTheme = document.documentElement.getAttribute('data-theme') || 'light';
        var isDark = curTheme === 'dark';
        var suns = document.querySelectorAll('.icon-sun');
        var moons = document.querySelectorAll('.icon-moon');
        var labels = document.querySelectorAll('.theme-label');

        suns.forEach(function(el) { el.style.display = isDark ? 'none' : 'inline-block'; });
        moons.forEach(function(el) { el.style.display = isDark ? 'inline-block' : 'none'; });
        labels.forEach(function(el) { el.innerText = isDark ? 'Dark' : 'Light'; });
      });
    </script>

    @yield('scripts')
</body>
</html>
