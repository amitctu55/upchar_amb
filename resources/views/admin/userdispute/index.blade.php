@extends('admin.layout.base')

@section('title', 'Patient & Paramedic Live Disputes - ')

@section('styles')
<style>
    .dispute-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .dispute-header-card h4 {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stat-badge-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .stat-badge-item {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        border-radius: 10px;
        padding: 10px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 160px;
    }

    .stat-badge-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .stat-badge-item .val {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
    }

    .stat-badge-item .lbl {
        font-size: 11px;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-add-dispute {
        background: linear-gradient(90deg, #00A8FF, #0284c7);
        color: #ffffff !important;
        font-size: 13px;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.4);
        border: none;
        transition: all 0.2s;
    }

    .btn-add-dispute:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 168, 255, 0.6);
        text-decoration: none;
    }

    .btn-outline-back {
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

    .btn-outline-back:hover {
        background: rgba(255, 255, 255, 0.15);
        text-decoration: none;
    }

    .table-container-card {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(14px);
    }

    .table thead th {
        background: rgba(0, 168, 255, 0.08) !important;
        color: var(--cyan-bright) !important;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        border-bottom: 1px solid var(--border-line) !important;
        padding: 12px 14px;
    }

    .table tbody td {
        padding: 12px 14px;
        vertical-align: middle;
        font-size: 13px;
        color: var(--text-main);
        border-bottom: 1px solid var(--border-line);
    }

    .type-pill {
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
    .type-pill.user {
        background: rgba(0, 168, 255, 0.15);
        color: #00A8FF;
        border: 1px solid rgba(0, 168, 255, 0.3);
    }
    .type-pill.provider {
        background: rgba(168, 85, 247, 0.15);
        color: #A855F7;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-badge.open {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .status-badge.closed {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .btn-action-view {
        background: rgba(0, 168, 255, 0.15);
        color: #00A8FF !important;
        border: 1px solid rgba(0, 168, 255, 0.3);
        font-size: 11px;
        padding: 6px 14px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 700;
        transition: all 0.2s;
    }
    .btn-action-view:hover {
        background: #00A8FF;
        color: #ffffff !important;
    }
</style>
@endsection

@section('content')
<div class="dispute-header-card">
    <div>
        <h4>
            <i class="fa-solid fa-triangle-exclamation" style="color: var(--crimson-alert);"></i>
            <span>Live Patient & Paramedic Dispute Tickets</span>
        </h4>
        <div style="font-size: 12px; color: var(--text-dim);">Resolve ambulance dispatch complaints, trip fare discrepancies, and issue wallet refunds</div>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.dispute.index') }}" class="btn-outline-back">
            <i class="fa-solid fa-list"></i> Manage Dispute Categories
        </a>
        @can('lost-item-create')
        <a href="{{ route('admin.userdisputecreate') }}" class="btn-add-dispute">
            <i class="fa-solid fa-plus"></i> Open Dispute Ticket
        </a>
        @endcan
    </div>
</div>

@if(Setting::get('demo_mode', 0) == 1)
<div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; padding: 10px 16px; margin-bottom: 16px; color: #ef4444; font-size: 12px; font-weight: 600;">
    <i class="fa-solid fa-triangle-exclamation"></i> Demo Mode Active: Dispute resolutions and refunds are simulated.
</div>
@endif

<div class="stat-badge-row">
    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div>
            <div class="val">{{ $disputes->where('status', 'open')->count() }}</div>
            <div class="lbl">Open Tickets</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
            <div class="val">{{ $disputes->where('status', 'closed')->count() }}</div>
            <div class="lbl">Resolved & Closed</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>
        <div>
            <div class="val">{{ currency($disputes->sum('refund_amount')) }}</div>
            <div class="lbl">Total Refunds Granted</div>
        </div>
    </div>
</div>

<div class="table-container-card">
    <table class="table table-striped table-bordered dataTable" id="table-2" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Audience</th>
                <th>Complainant Name</th>
                <th>Booking ID</th>
                <th>Dispute Subject</th>
                <th>Admin Comments</th>
                <th>Refund Granted</th>
                <th>Ticket Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disputes as $index => $dispute)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <span class="type-pill {{ strtolower($dispute->dispute_type) }}">
                        @if(strtolower($dispute->dispute_type) == 'user')
                            <i class="fa-solid fa-user"></i> Patient
                        @else
                            <i class="fa-solid fa-user-nurse"></i> Paramedic
                        @endif
                    </span>
                </td>
                <td>
                    <strong style="color: var(--text-main);">
                        @if($dispute->dispute_type == 'user')
                            {{ $dispute->user ? $dispute->user->first_name.' '.$dispute->user->last_name : 'Patient #'.$dispute->user_id }}
                        @else
                            {{ $dispute->provider ? $dispute->provider->first_name.' '.$dispute->provider->last_name : 'Paramedic #'.$dispute->provider_id }}
                        @endif
                    </strong>
                </td>
                <td>
                    <span style="font-weight: 700; color: var(--cyan-bright);">
                        #{{ $dispute->request ? $dispute->request->booking_id : $dispute->request_id }}
                    </span>
                </td>
                <td>{{ $dispute->dispute_name }}</td>
                <td style="max-width: 200px; font-size: 12px; color: var(--text-dim);">
                    {{ $dispute->comments ?? 'Pending investigation' }}
                </td>
                <td>
                    <strong style="color: #10B981;">{{ currency($dispute->refund_amount) }}</strong>
                </td>
                <td>
                    @if($dispute->status == 'open')
                        <span class="status-badge open"><i class="fa-solid fa-clock"></i> Open Ticket</span>
                    @else
                        <span class="status-badge closed"><i class="fa-solid fa-check"></i> Resolved</span>
                    @endif
                </td>
                <td>
                    @if(Setting::get('demo_mode', 0) == 0)
                        @can('dispute-edit')
                            @if($dispute->status == 'open')
                                <a href="{{ route('admin.userdisputeedit', $dispute->id) }}" class="btn-action-view" title="Investigate & Resolve">
                                    <i class="fa-solid fa-gavel"></i> Resolve
                                </a>
                            @else
                                <span style="font-size: 11px; color: var(--text-dim);"><i class="fa-solid fa-lock"></i> Settled</span>
                            @endif
                        @endcan
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection