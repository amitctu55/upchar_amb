@extends('admin.layout.base')

@section('title', 'Dispute Reasons & Categories - ')

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

    .btn-user-disputes {
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

    .btn-user-disputes:hover {
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
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-badge.active {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .status-badge.inactive {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-action-edit {
        background: rgba(245, 158, 11, 0.15);
        color: #F59E0B !important;
        border: 1px solid rgba(245, 158, 11, 0.3);
        font-size: 11px;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-action-edit:hover {
        background: #F59E0B;
        color: #ffffff !important;
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444 !important;
        border: 1px solid rgba(239, 68, 68, 0.3);
        font-size: 11px;
        padding: 6px 12px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-action-delete:hover {
        background: #EF4444;
        color: #ffffff !important;
    }
</style>
@endsection

@section('content')
<div class="dispute-header-card">
    <div>
        <h4>
            <i class="fa-solid fa-scale-balanced" style="color: var(--cyan-bright);"></i>
            <span>Dispute Reasons & Complaint Categories</span>
        </h4>
        <div style="font-size: 12px; color: var(--text-dim);">Pre-configured complaint categories available to patients and paramedics during trip dispute resolution</div>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.userdisputes') }}" class="btn-user-disputes">
            <i class="fa-solid fa-inbox"></i> Live Customer Dispute Tickets
        </a>
        @can('dispute-create')
        <a href="{{ route('admin.dispute.create') }}" class="btn-add-dispute">
            <i class="fa-solid fa-plus"></i> Add Dispute Reason
        </a>
        @endcan
    </div>
</div>

@if(Setting::get('demo_mode', 0) == 1)
<div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; padding: 10px 16px; margin-bottom: 16px; color: #ef4444; font-size: 12px; font-weight: 600;">
    <i class="fa-solid fa-triangle-exclamation"></i> Demo Mode Active: Modifications are restricted.
</div>
@endif

<div class="stat-badge-row">
    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(0, 168, 255, 0.15); color: #00A8FF;">
            <i class="fa-solid fa-list-check"></i>
        </div>
        <div>
            <div class="val">{{ count($dispute) }}</div>
            <div class="lbl">Total Categories</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(0, 168, 255, 0.15); color: #00A8FF;">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <div class="val">{{ $dispute->where('dispute_type', 'user')->count() }}</div>
            <div class="lbl">Patient Reasons</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(168, 85, 247, 0.15); color: #A855F7;">
            <i class="fa-solid fa-user-nurse"></i>
        </div>
        <div>
            <div class="val">{{ $dispute->where('dispute_type', 'provider')->count() }}</div>
            <div class="lbl">Paramedic Reasons</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
            <div class="val">{{ $dispute->where('status', 'active')->count() }}</div>
            <div class="lbl">Active Reasons</div>
        </div>
    </div>
</div>

<div class="table-container-card">
    <table class="table table-striped table-bordered dataTable" id="table-2" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Target Audience</th>
                <th>Dispute Category Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dispute as $index => $dist)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <span class="type-pill {{ strtolower($dist->dispute_type) }}">
                        @if(strtolower($dist->dispute_type) == 'user')
                            <i class="fa-solid fa-user"></i> Patient
                        @else
                            <i class="fa-solid fa-user-nurse"></i> Paramedic
                        @endif
                    </span>
                </td>
                <td>
                    <strong style="color: var(--text-main); font-size: 14px;">{{ ucfirst($dist->dispute_name) }}</strong>
                </td>
                <td>
                    @if($dist->status == 'active')
                        <span class="status-badge active"><i class="fa-solid fa-circle-check"></i> Active</span>
                    @else
                        <span class="status-badge inactive"><i class="fa-solid fa-circle-xmark"></i> Inactive</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        @if(Setting::get('demo_mode', 0) == 0)
                            @can('dispute-edit')
                            <a href="{{ route('admin.dispute.edit', $dist->id) }}" class="btn-action-edit" title="Edit Reason">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            @endcan

                            @can('dispute-delete')
                            <form action="{{ route('admin.dispute.destroy', $dist->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this dispute reason?');">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn-action-delete" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                            @endcan
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection