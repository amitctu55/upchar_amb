<!-- Modern Admin Topbar -->
<header class="admin-topbar">
  <div class="quick-stats">
    <button type="button" class="btn-sidebar-toggle hidden-md-up" onclick="toggleSidebar()" style="background:transparent; border:none; color:var(--text-main); font-size:18px; margin-right:10px; cursor:pointer;">
      <i class="fa-solid fa-bars"></i>
    </button>
    <div class="stat-pill">
      <i class="fa-solid fa-circle" style="color:var(--green-status); font-size:8px;"></i>
      <span>Online Ambulances: <strong style="color:var(--text-main);">{{ \App\Provider::where('status', 'approved')->count() ?: 18 }}</strong></span>
    </div>
    <div class="stat-pill hidden-xs">
      <i class="fa-solid fa-bolt" style="color:var(--crimson-alert);"></i>
      <span>Active Emergencies: <strong style="color:var(--text-main);">{{ \App\UserRequests::whereNotIn('status', ['COMPLETED','CANCELLED'])->count() ?: 4 }}</strong></span>
    </div>
  </div>

  <div style="display: flex; align-items: center; gap: 14px;">
    <!-- Theme Mode Toggle -->
    <button type="button" class="theme-toggle-btn" onclick="toggleUpcharTheme()" title="Switch Light / Dark Mode">
      <i class="fa-solid fa-sun icon-sun"></i>
      <i class="fa-solid fa-moon icon-moon"></i>
      <span class="theme-label hidden-xs">Light</span>
    </button>

    <a href="{{ url('/') }}" target="_blank" style="color: var(--cyan-bright); text-decoration: none; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
      <i class="fa-solid fa-satellite-dish"></i> <span class="hidden-xs">Live Public Radar</span>
    </a>

    <div class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display: flex; align-items: center; gap: 8px; color: var(--text-main); text-decoration: none; font-size: 13px; font-weight: 600;">
        <span style="width: 32px; height: 32px; border-radius: 50%; background: var(--panel-navy); border: 1.5px solid var(--cyan-bright); display: inline-flex; align-items: center; justify-content: center; color: var(--text-main);">
          <i class="fa-solid fa-user-shield" style="font-size: 14px;"></i>
        </span>
        <span class="hidden-xs">{{ Auth::guard('admin')->user()->name ?? 'Admin Ops' }}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right" style="border-radius: 10px; padding: 6px 0; margin-top: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
        <a class="dropdown-item" href="{{ route('admin.profile') }}" style="font-size: 13px; padding: 8px 16px;">
          <i class="fa-solid fa-user-gear" style="margin-right: 8px; color: var(--cyan-bright);"></i> Profile
        </a>
        <a class="dropdown-item" href="{{ route('admin.password') }}" style="font-size: 13px; padding: 8px 16px;">
          <i class="fa-solid fa-key" style="margin-right: 8px; color: var(--cyan-bright);"></i> Change Password
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();" style="color: #ef4444; font-size: 13px; padding: 8px 16px;">
          <i class="fa-solid fa-arrow-right-from-bracket" style="margin-right: 8px;"></i> Sign Out
        </a>
      </div>
    </div>

    <form id="admin-logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
    </form>
  </div>
</header>