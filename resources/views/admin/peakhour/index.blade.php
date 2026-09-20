@extends('admin.layout.base')

@section('title', 'Peak Hours & Surge Windows - ')

@section('styles')
<style>
    .peakhour-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .peakhour-header-card h4 {
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

    .btn-add-peakhour {
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

    .btn-add-peakhour:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 168, 255, 0.6);
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

    .time-slot-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        background: rgba(0, 168, 255, 0.12);
        color: #00A8FF;
        border: 1px solid rgba(0, 168, 255, 0.25);
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
<div class="peakhour-header-card">
    <div>
        <h4>
            <i class="fa-solid fa-clock-rotate-left" style="color: var(--cyan-bright);"></i>
            <span>Peak Hours & Surge Windows</span>
        </h4>
        <div style="font-size: 12px; color: var(--text-dim);">Define scheduled peak emergency windows where dynamic surge multipliers or priority pricing apply</div>
    </div>
    @can('peak-hour-create')
    <a href="{{ route('admin.peakhour.create') }}" class="btn-add-peakhour">
        <i class="fa-solid fa-plus"></i> Add Peak Hour Window
    </a>
    @endcan
</div>

@if(Setting::get('demo_mode', 0) == 1)
<div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; padding: 10px 16px; margin-bottom: 16px; color: #ef4444; font-size: 12px; font-weight: 600;">
    <i class="fa-solid fa-triangle-exclamation"></i> Demo Mode Active: Modifications are restricted.
</div>
@endif

<div class="stat-badge-row">
    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(0, 168, 255, 0.15); color: #00A8FF;">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div>
            <div class="val">{{ count($peakhour) }}</div>
            <div class="lbl">Configured Peak Windows</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <div>
            <div class="val">Surge Enabled</div>
            <div class="lbl">Auto-applied during triage</div>
        </div>
    </div>
</div>

<div class="table-container-card">
    <table class="table table-striped table-bordered dataTable" id="table-2" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Peak Window Interval</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peakhour as $index => $peak)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <div class="time-slot-badge">
                        <i class="fa-solid fa-bolt" style="color: #F59E0B;"></i>
                        <span>{{ date('h:i A', strtotime($peak->start_time)) }} &mdash; {{ date('h:i A', strtotime($peak->end_time)) }}</span>
                    </div>
                </td>
                <td>
                    <strong style="color: var(--text-main);">{{ date('h:i A', strtotime($peak->start_time)) }}</strong>
                </td>
                <td>
                    <strong style="color: var(--text-main);">{{ date('h:i A', strtotime($peak->end_time)) }}</strong>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        @if(Setting::get('demo_mode', 0) == 0)
                            @can('peak-hour-edit')
                            <a href="{{ route('admin.peakhour.edit', $peak->id) }}" class="btn-action-edit" title="Edit Window">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            @endcan

                            @can('peak-hour-delete')
                            <form action="{{ route('admin.peakhour.destroy', $peak->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this peak hour window?');">
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