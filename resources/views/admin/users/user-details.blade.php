@extends('admin.layout.base')

@section('title', 'Patient & User Profile Dossier - ')

@section('styles')
<style>
    .user-profile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .user-profile-header h4 {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-profile-header .header-sub {
        font-size: 12px;
        color: var(--text-dim);
    }

    .btn-action-outline {
        background: rgba(255, 255, 255, 0.08);
        color: var(--text-main) !important;
        font-size: 13px;
        font-weight: 600;
        padding: 9px 18px;
        border-radius: 8px;
        border: 1px solid var(--border-line);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-action-outline:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-action-primary {
        background: linear-gradient(90deg, #00A8FF, #0284c7);
        color: #ffffff !important;
        font-size: 13px;
        font-weight: 700;
        padding: 9px 20px;
        border-radius: 8px;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.4);
        transition: all 0.2s;
    }

    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 168, 255, 0.6);
        text-decoration: none;
    }

    /* Stats Grid */
    .stat-badge-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-badge-item {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: var(--card-shadow);
    }

    .stat-badge-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-badge-item .val {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
    }

    .stat-badge-item .lbl {
        font-size: 11px;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 3px;
    }

    /* Cards */
    .profile-card {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(14px);
        margin-bottom: 24px;
    }

    .card-heading {
        font-size: 15px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-line);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-hero-box {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .user-avatar-lg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #00A8FF;
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.3);
    }

    .user-avatar-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00A8FF, #0066cc);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 800;
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.3);
    }

    .user-name-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 4px 0;
    }

    .user-meta-sub {
        font-size: 13px;
        color: var(--text-dim);
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }

    .info-cell {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        border-radius: 10px;
        padding: 12px 16px;
    }

    .info-cell .info-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--cyan-bright);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .info-cell .info-value {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        word-break: break-word;
    }

    /* Status Pills */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-badge.completed {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .status-badge.cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .status-badge.searching, .status-badge.accepted, .status-badge.started, .status-badge.arrived {
        background: rgba(0, 168, 255, 0.15);
        color: #00a8ff;
        border: 1px solid rgba(0, 168, 255, 0.3);
    }

    /* Table styles */
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table th {
        background: rgba(0, 168, 255, 0.08);
        color: var(--cyan-bright);
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        border-bottom: 1px solid var(--border-line);
    }

    .custom-table td {
        padding: 12px 14px;
        font-size: 13px;
        color: var(--text-main);
        border-bottom: 1px solid var(--border-line);
        vertical-align: middle;
    }

    .custom-table tr:hover td {
        background: rgba(0, 168, 255, 0.04);
    }
</style>
@endsection

@section('content')
<div class="user-profile-header">
    <div>
        <h4>
            <i class="fa-solid fa-id-card-clip" style="color: var(--cyan-bright);"></i>
            <span>Patient & User Profile Dossier</span>
        </h4>
        <span class="header-sub">Emergency medical contact records, dispatch telemetry, wallet, and trip history for ID #{{ $user->id }}</span>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.user.index') }}" class="btn-action-outline">
            <i class="fa-solid fa-arrow-left"></i> Back to Users List
        </a>
        <a href="{{ route('admin.user.request', $user->id) }}" class="btn-action-outline">
            <i class="fa-solid fa-clock-rotate-left"></i> Full Trip History
        </a>
        @can('user-edit')
        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-action-primary">
            <i class="fa-solid fa-pen-to-square"></i> Edit Profile
        </a>
        @endcan
    </div>
</div>

<!-- Stat Row -->
<div class="stat-badge-row">
    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(0, 168, 255, 0.15); color: #00A8FF;">
            <i class="fa-solid fa-truck-medical"></i>
        </div>
        <div>
            <div class="val">{{ $total_trips ?? 0 }}</div>
            <div class="lbl">Total Dispatches</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
            <div class="val">{{ $completed_trips ?? 0 }}</div>
            <div class="lbl">Completed Missions</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">
            <i class="fa-solid fa-circle-xmark"></i>
        </div>
        <div>
            <div class="val">{{ $cancelled_trips ?? 0 }}</div>
            <div class="lbl">Cancelled Requests</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">
            <i class="fa-solid fa-wallet"></i>
        </div>
        <div>
            <div class="val">{{ currency($user->wallet_balance) }}</div>
            <div class="lbl">Wallet Balance</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(168, 85, 247, 0.15); color: #A855F7;">
            <i class="fa-solid fa-indian-rupee-sign"></i>
        </div>
        <div>
            <div class="val">{{ currency($total_spent ?? 0) }}</div>
            <div class="lbl">Lifetime Spend</div>
        </div>
    </div>
</div>

<!-- Profile Details Card -->
<div class="profile-card">
    <div class="user-hero-box">
        @if($user->picture)
            <img src="{{ img($user->picture) }}" alt="{{ $user->first_name }}" class="user-avatar-lg">
        @else
            <div class="user-avatar-placeholder">
                {{ strtoupper(substr($user->first_name, 0, 1)) }}
            </div>
        @endif

        <div>
            <h3 class="user-name-title">{{ $user->first_name }} {{ $user->last_name }}</h3>
            <div class="user-meta-sub">
                <span><i class="fa-solid fa-envelope" style="color: var(--cyan-bright);"></i> {{ Setting::get('demo_mode', 0) == 1 ? substr($user->email, 0, 3).'****'.substr($user->email, strpos($user->email, '@')) : $user->email }}</span>
                <span><i class="fa-solid fa-phone" style="color: var(--cyan-bright);"></i> {{ Setting::get('demo_mode', 0) == 1 ? '+91 98765 43210' : ($user->country_code ? $user->country_code.' ' : '').$user->mobile }}</span>
                <span><i class="fa-solid fa-star" style="color: #F59E0B;"></i> {{ number_format($user->rating, 1) }} Rating</span>
                <span class="status-badge completed"><i class="fa-solid fa-shield-halved"></i> Active Account</span>
            </div>
        </div>
    </div>

    <div class="card-heading">
        <i class="fa-solid fa-circle-info" style="color: var(--cyan-bright);"></i>
        <span>Account & Emergency Telemetry</span>
    </div>

    <div class="info-grid">
        <div class="info-cell">
            <div class="info-label">Account ID</div>
            <div class="info-value">#{{ $user->id }}</div>
        </div>

        <div class="info-cell">
            <div class="info-label">Gender / Blood Group</div>
            <div class="info-value">{{ ucfirst($user->gender ?? 'Not Specified') }}</div>
        </div>

        <div class="info-cell">
            <div class="info-label">Preferred Payment Mode</div>
            <div class="info-value"><i class="fa-solid fa-credit-card" style="color: var(--cyan-bright);"></i> {{ $user->payment_mode ?? 'CASH' }}</div>
        </div>

        <div class="info-cell">
            <div class="info-label">Login Method</div>
            <div class="info-value">{{ ucfirst($user->login_by ?? 'Manual') }}</div>
        </div>

        <div class="info-cell">
            <div class="info-label">Operating Device</div>
            <div class="info-value">{{ ucfirst($user->device_type ?? 'Android / Web') }}</div>
        </div>

        <div class="info-cell">
            <div class="info-label">Referral Unique ID</div>
            <div class="info-value">{{ $user->referral_unique_id ?? 'UPCHAR-'.$user->id }}</div>
        </div>

        <div class="info-cell">
            <div class="info-label">Registered On</div>
            <div class="info-value">{{ $user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A' }}</div>
        </div>

        <div class="info-cell">
            <div class="info-label">Last Updated</div>
            <div class="info-value">{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A' }}</div>
        </div>
    </div>

    @if($user->qrcode_url)
    <div style="margin-top: 20px; padding: 16px; background: var(--stat-pill-bg); border-radius: 10px; border: 1px solid var(--border-line); display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
        <img src="{{ $user->qrcode_url }}" alt="Emergency QR Code" style="width: 80px; height: 80px; border-radius: 8px; background: #ffffff; padding: 4px;">
        <div>
            <div style="font-weight: 800; font-size: 14px; color: var(--text-main);"><i class="fa-solid fa-qrcode" style="color: var(--cyan-bright);"></i> Patient Emergency Rapid Check-In QR</div>
            <div style="font-size: 12px; color: var(--text-dim); margin-top: 3px;">Paramedics and triage receptionists can scan this QR code to rapidly pull up patient emergency medical history and contact data.</div>
        </div>
    </div>
    @endif
</div>

<!-- Recent Requests Card -->
<div class="profile-card">
    <div class="card-heading">
        <i class="fa-solid fa-clock-rotate-left" style="color: var(--cyan-bright);"></i>
        <span>Recent Ambulance Bookings & Dispatches (Latest 10)</span>
    </div>

    @if($user->trips && count($user->trips) > 0)
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Ambulance Type</th>
                    <th>Driver / Paramedic</th>
                    <th>Pickup Location</th>
                    <th>Destination Hospital</th>
                    <th>Status</th>
                    <th>Fare</th>
                    <th>Date / Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->trips as $trip)
                <tr>
                    <td><strong>#{{ $trip->booking_id ?? $trip->id }}</strong></td>
                    <td>
                        <span style="font-weight: 700; color: var(--cyan-bright);">
                            {{ $trip->service_type ? $trip->service_type->name : 'Emergency Ambulance' }}
                        </span>
                    </td>
                    <td>
                        @if($trip->provider)
                            <div style="display: flex; align-items: center; gap: 8px;">
                                @if($trip->provider->avatar)
                                    <img src="{{ img($trip->provider->avatar) }}" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                                @endif
                                <span>{{ $trip->provider->first_name }} {{ $trip->provider->last_name }}</span>
                            </div>
                        @else
                            <span style="color: var(--text-dim);">Unassigned / Auto-routing</span>
                        @endif
                    </td>
                    <td style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $trip->s_address }}">
                        <i class="fa-solid fa-location-dot" style="color: #10B981;"></i> {{ $trip->s_address ?? 'GPS Coordinate' }}
                    </td>
                    <td style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $trip->d_address }}">
                        <i class="fa-solid fa-hospital" style="color: #EF4444;"></i> {{ $trip->d_address ?? 'Emergency Center' }}
                    </td>
                    <td>
                        @php($st = strtolower($trip->status))
                        <span class="status-badge {{ $st }}">
                            {{ $trip->status }}
                        </span>
                    </td>
                    <td>
                        <strong>{{ $trip->payment ? currency($trip->payment->total) : '-' }}</strong>
                    </td>
                    <td style="font-size: 12px; color: var(--text-dim);">
                        {{ $trip->created_at ? $trip->created_at->format('M d, Y H:i') : '-' }}
                    </td>
                    <td>
                        @if(Route::has('admin.requests.show'))
                            <a href="{{ route('admin.requests.show', $trip->id) }}" class="btn btn-sm btn-info" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                <i class="fa-solid fa-eye"></i> Details
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; padding: 40px 20px; color: var(--text-dim);">
        <i class="fa-solid fa-truck-medical" style="font-size: 36px; opacity: 0.4; margin-bottom: 12px; display: block;"></i>
        <h5>No Ambulance Trips Recorded Yet</h5>
        <p style="font-size: 12px;">This patient has not initiated any emergency ambulance requests yet.</p>
    </div>
    @endif
</div>
@endsection
