<!-- UPCHAR Modern Navigation Matrix -->
<aside class="admin-sidebar" id="adminSidebar">
  <div class="brand-box">
    <div style="width: 36px; height: 36px; border-radius: 50%; background: #08364B; border: 1.5px solid var(--cyan-bright); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 10px rgba(0,168,255,0.4);">
      <i class="fa-solid fa-truck-medical" style="color: var(--crimson-alert); font-size: 16px;"></i>
    </div>
    <div style="display: flex; flex-direction: column;">
      <h2 style="font-size: 16px; font-weight: 900; letter-spacing: 1.5px; color: #fff; margin: 0; line-height: 1;">UPCHAR <span style="color: var(--cyan-bright); font-size: 11px;">OPS</span></h2>
      <span style="font-size: 9px; color: #94a3b8; letter-spacing: 0.5px; text-transform: uppercase;">Command Center</span>
    </div>
  </div>

  <ul class="nav-list">
    <!-- Module 1: Real-Time Operations -->
    <li class="nav-label">1. Real-Time Operations</li>
    <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
      <a href="{{ route('admin.dashboard') }}">
        <i class="fa-solid fa-gauge-high"></i> <span>Command Dashboard</span>
      </a>
    </li>

    @can('god-eye')
    <li class="nav-item {{ Request::is('admin/godseye') ? 'active' : '' }}">
      <a href="{{ route('admin.godseye') }}">
        <i class="fa-solid fa-satellite-dish"></i> <span>God's Eye Radar</span>
      </a>
    </li>
    @endcan

    @can('dispatcher-panel')
    <li class="nav-item {{ Request::is('admin/dispatcher*') ? 'active' : '' }}">
      <a href="{{ route('admin.dispatcher.index') }}">
        <i class="fa-solid fa-headset"></i> <span>Assisted Dispatcher</span>
      </a>
    </li>
    @endcan

    @can('heat-map')
    <li class="nav-item {{ Request::is('admin/heatmap') ? 'active' : '' }}">
      <a href="{{ route('admin.heatmap') }}">
        <i class="fa-solid fa-fire"></i> <span>Demand Heatmap</span>
      </a>
    </li>
    @endcan

    @can('request-history')
    <li class="nav-item {{ Request::is('admin/requests') ? 'active' : '' }}">
      <a href="{{ route('admin.requests.index') }}">
        <i class="fa-solid fa-clock-rotate-left"></i> <span>Live Bookings</span>
      </a>
    </li>
    @endcan

    @can('scheduled-rides')
    <li class="nav-item {{ Request::is('admin/scheduled/rides') ? 'active' : '' }}">
      <a href="{{ route('admin.requests.scheduled') }}">
        <i class="fa-solid fa-calendar-check"></i> <span>Scheduled Transfers</span>
      </a>
    </li>
    @endcan

    <!-- Module 2: Supply & Fleet Entities -->
    <li class="nav-label">2. Fleet & Supply</li>
    @can('provider-list')
    <li class="nav-item {{ Request::is('admin/provider*') ? 'active' : '' }}">
      <a href="{{ route('admin.provider.index') }}">
        <i class="fa-solid fa-user-doctor"></i> <span>Drivers / Paramedics</span>
      </a>
    </li>
    @endcan

    @can('fleet-list')
    <li class="nav-item {{ Request::is('admin/fleet*') ? 'active' : '' }}">
      <a href="{{ route('admin.fleet.index') }}">
        <i class="fa-solid fa-hospital"></i> <span>Hospital Fleets</span>
      </a>
    </li>
    @endcan

    @can('user-list')
    <li class="nav-item {{ Request::is('admin/user*') ? 'active' : '' }}">
      <a href="{{ route('admin.user.index') }}">
        <i class="fa-solid fa-users"></i> <span>Patients & Accounts</span>
      </a>
    </li>
    @endcan

    @can('service-types-list')
    <li class="nav-item {{ Request::is('admin/service*') ? 'active' : '' }}">
      <a href="{{ route('admin.service.index') }}">
        <i class="fa-solid fa-shapes"></i> <span>Service Tiers (ALS/BLS)</span>
      </a>
    </li>
    @endcan

    @can('peak-hour-list')
    <li class="nav-item {{ Request::is('admin/peakhour*') ? 'active' : '' }}">
      <a href="{{ route('admin.peakhour.index') }}">
        <i class="fa-solid fa-chart-line"></i> <span>Dynamic Tariff Rules</span>
      </a>
    </li>
    @endcan

    <!-- Module 3: Quality, Safety & Disputes -->
    <li class="nav-label">3. Safety & Disputes</li>
    @can('dispute-list')
    <li class="nav-item {{ Request::is('admin/dispute*') ? 'active' : '' }}">
      <a href="{{ route('admin.dispute.index') }}">
        <i class="fa-solid fa-triangle-exclamation"></i> <span>Active Disputes</span>
      </a>
    </li>
    <li class="nav-item {{ Request::is('admin/userdisputes*') ? 'active' : '' }}">
      <a href="{{ route('admin.userdisputes') }}">
        <i class="fa-solid fa-user-shield"></i> <span>Patient Grievances</span>
      </a>
    </li>
    @endcan

    @can('lost-item-list')
    <li class="nav-item {{ Request::is('admin/lostitem*') ? 'active' : '' }}">
      <a href="{{ route('admin.lostitem.index') }}">
        <i class="fa-solid fa-box-open"></i> <span>Lost Patient Items</span>
      </a>
    </li>
    @endcan

    @can('ratings')
    <li class="nav-item {{ Request::is('admin/provider/review*') ? 'active' : '' }}">
      <a href="{{ route('admin.provider.review') }}">
        <i class="fa-solid fa-star-half-stroke"></i> <span>Driver Reviews</span>
      </a>
    </li>
    @endcan

    <!-- Module 4: Financial Reconciliation -->
    <li class="nav-label">4. Finance & Payouts</li>
    @can('statements')
    <li class="nav-item {{ Request::is('admin/statement*') ? 'active' : '' }}">
      <a href="{{ route('admin.ride.statement') }}">
        <i class="fa-solid fa-file-invoice-dollar"></i> <span>Payout Statements</span>
      </a>
    </li>
    @endcan

    @can('settlements')
    <li class="nav-item {{ Request::is('admin/transactions*') || Request::is('admin/payment*') ? 'active' : '' }}">
      <a href="{{ route('admin.payment') }}">
        <i class="fa-solid fa-money-check-dollar"></i> <span>Transaction Logs</span>
      </a>
    </li>
    @endcan

    @can('promocodes-list')
    <li class="nav-item {{ Request::is('admin/promocode*') ? 'active' : '' }}">
      <a href="{{ route('admin.promocode.index') }}">
        <i class="fa-solid fa-ticket"></i> <span>Medical Vouchers</span>
      </a>
    </li>
    @endcan

    <!-- Module 5: System Administration -->
    <li class="nav-label">5. System Administration</li>
    @can('role-list')
    <li class="nav-item {{ Request::is('admin/role*') ? 'active' : '' }}">
      <a href="{{ route('admin.role.index') }}">
        <i class="fa-solid fa-id-badge"></i> <span>RBAC Permissions</span>
      </a>
    </li>
    @endcan

    @can('sub-admin-list')
    <li class="nav-item {{ Request::is('admin/sub-admins*') ? 'active' : '' }}">
      <a href="{{ route('admin.sub-admins.index') }}">
        <i class="fa-solid fa-user-gear"></i> <span>Sub-Admins</span>
      </a>
    </li>
    @endcan

    @can('documents-list')
    <li class="nav-item {{ Request::is('admin/document*') ? 'active' : '' }}">
      <a href="{{ route('admin.document.index') }}">
        <i class="fa-solid fa-file-shield"></i> <span>Vehicle & DL Docs</span>
      </a>
    </li>
    @endcan

    @can('site-settings')
    <li class="nav-item {{ Request::is('admin/settings*') ? 'active' : '' }}">
      <a href="{{ route('admin.settings') }}">
        <i class="fa-solid fa-sliders"></i> <span>Site Parameters</span>
      </a>
    </li>
    @endcan
  </ul>
</aside>