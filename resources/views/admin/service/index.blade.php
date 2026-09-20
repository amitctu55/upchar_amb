@extends('admin.layout.base')

@section('title', 'Ambulance Types & Pricing Models - ')

@section('styles')
<style>
    .service-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .service-header-card h4 {
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

    .btn-add-service {
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

    .btn-add-service:hover {
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

    .table tbody tr:hover td {
        background: rgba(0, 168, 255, 0.04);
    }

    .service-img-preview {
        width: 48px;
        height: 38px;
        object-fit: contain;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-line);
        border-radius: 6px;
        padding: 2px;
    }

    .calc-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
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
<div class="service-header-card">
    <div>
        <h4>
            <i class="fa-solid fa-truck-medical" style="color: var(--cyan-bright);"></i>
            <span>Ambulance Categories & Pricing Matrix</span>
        </h4>
        <div style="font-size: 12px; color: var(--text-dim);">Configure ambulance categories (BLS, ALS, ICU, Transport), seat capacities, base fares, mileage rates, and waiting wave rules</div>
    </div>
    @can('service-types-create')
    <a href="{{ route('admin.service.create') }}" class="btn-add-service">
        <i class="fa-solid fa-plus"></i> Add New Ambulance Type
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
            <i class="fa-solid fa-truck-medical"></i>
        </div>
        <div>
            <div class="val">{{ count($services) }}</div>
            <div class="lbl">Active Vehicle Types</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
            <i class="fa-solid fa-calculator"></i>
        </div>
        <div>
            <div class="val">{{ currency($services->avg('fixed')) }}</div>
            <div class="lbl">Avg Base Fare</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">
            <i class="fa-solid fa-route"></i>
        </div>
        <div>
            <div class="val">{{ currency($services->avg('price')) }} / {{ config('constants.distance', 'Kms') }}</div>
            <div class="lbl">Avg Mileage Rate</div>
        </div>
    </div>
</div>

<div class="table-container-card">
    <table class="table table-striped table-bordered dataTable" id="table-2" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Ambulance Type</th>
                <th>Capacity</th>
                <th>Base Fare</th>
                <th>Base Dist.</th>
                <th>Distance Rate</th>
                <th>Minute Rate</th>
                <th>Hour Rate</th>
                <th>Calculation Logic</th>
                <th>Vehicle Icon</th>
                <th>Map Pin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $index => $service)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong style="color: var(--text-main); font-size: 14px;">{{ $service->name }}</strong>
                    @if($service->description)
                        <div style="font-size: 11px; color: var(--text-dim); max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $service->description }}</div>
                    @endif
                </td>
                <td>
                    <span style="font-weight: 700; color: var(--cyan-bright);">
                        <i class="fa-solid fa-users"></i> {{ $service->capacity }}
                    </span>
                </td>
                <td><strong>{{ currency($service->fixed) }}</strong></td>
                <td>{{ distance($service->distance) }}</td>
                <td>{{ currency($service->price) }}</td>
                <td>{{ currency($service->minute) }}</td>
                <td>
                    @if($service->calculator == 'DISTANCEHOUR' || $service->calculator == 'HOUR') 
                        {{ currency($service->hour) }}
                    @else
                        <span style="color: var(--text-dim);">-</span>
                    @endif
                </td>
                <td>
                    <span class="calc-pill">@lang('servicetypes.'.$service->calculator)</span>
                </td>
                <td style="text-align: center;">
                    @if($service->image) 
                        <img src="{{ $service->image }}" class="service-img-preview" alt="{{ $service->name }}">
                    @else
                        <span style="color: var(--text-dim);">N/A</span>
                    @endif
                </td>
                <td style="text-align: center;">
                    @if($service->marker) 
                        <img src="{{ $service->marker }}" style="width: 28px; height: 28px; object-fit: contain;" alt="Marker">
                    @else
                        <span style="color: var(--text-dim);">N/A</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        @if(Setting::get('demo_mode', 0) == 0)
                            @can('service-types-edit')
                            <a href="{{ route('admin.service.edit', $service->id) }}" class="btn-action-edit" title="Edit Pricing & Configuration">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            @endcan

                            @can('service-types-delete')
                            <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this ambulance category?');">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
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