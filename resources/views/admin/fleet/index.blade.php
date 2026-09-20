@extends('admin.layout.base')

@section('title', 'Hospital & Partner Fleet Operators - ')

@section('styles')
<style>
    .fleet-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .fleet-header-card h4 {
        font-size: 20px;
        font-weight: 800;
        color: #ffffff;
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
        background: rgba(8, 54, 75, 0.6);
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
        color: #ffffff;
        line-height: 1.1;
    }

    .stat-badge-item .lbl {
        font-size: 11px;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-add-fleet {
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

    .btn-add-fleet:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 168, 255, 0.6);
        text-decoration: none;
    }

    .table-container-card {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(14px);
    }

    .custom-fleet-table {
        width: 100% !important;
        margin-bottom: 0;
        color: #ffffff;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-fleet-table th {
        background: rgba(4, 24, 34, 0.7) !important;
        color: var(--cyan-bright) !important;
        font-weight: 700 !important;
        font-size: 12px !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 12px !important;
        border-top: 1px solid var(--border-line) !important;
        border-bottom: 1px solid var(--border-line) !important;
        border-left: none !important;
        border-right: none !important;
        vertical-align: middle !important;
    }

    .custom-fleet-table td {
        padding: 14px 12px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        font-size: 13px;
        color: #e2e8f0;
    }

    .custom-fleet-table tr:hover td {
        background: rgba(0, 168, 255, 0.04);
    }

    .fleet-logo-chip {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .fleet-logo-chip .logo-circle {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #08364B;
        border: 1.5px solid var(--border-line);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--cyan-bright);
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .fleet-logo-chip .logo-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .commission-badge {
        background: rgba(0, 168, 255, 0.15);
        color: var(--cyan-bright);
        border: 1px solid rgba(0, 168, 255, 0.3);
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 12px;
        display: inline-block;
    }

    .ambulances-link {
        background: rgba(155, 192, 60, 0.15);
        color: #9BC03C !important;
        border: 1px solid rgba(155, 192, 60, 0.3);
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .ambulances-link:hover {
        background: #9BC03C;
        color: #041822 !important;
        text-decoration: none;
    }

    .dropdown-menu.dark-menu {
        background: #08364B !important;
        border: 1px solid var(--border-line) !important;
        border-radius: 10px !important;
        padding: 6px 0 !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.6) !important;
        z-index: 1050;
    }

    .dropdown-menu.dark-menu a,
    .dropdown-menu.dark-menu button {
        color: #cbd5e1 !important;
        font-size: 12px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        transition: background 0.15s;
    }

    .dropdown-menu.dark-menu a:hover,
    .dropdown-menu.dark-menu button:hover {
        background: rgba(0, 168, 255, 0.15) !important;
        color: #ffffff !important;
        text-decoration: none;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        margin-bottom: 14px;
    }

    .dataTables_wrapper .dataTables_filter input {
        background: rgba(4, 24, 34, 0.8) !important;
        border: 1px solid var(--border-line) !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        padding: 6px 12px;
        font-size: 12px;
        margin-left: 8px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--cyan-bright) !important;
        outline: none;
        box-shadow: 0 0 10px rgba(0, 168, 255, 0.3) !important;
    }

    .dt-buttons {
        margin-bottom: 14px;
        display: inline-flex;
        gap: 6px;
    }

    .dt-buttons .btn {
        background: rgba(8, 54, 75, 0.7) !important;
        border: 1px solid var(--border-line) !important;
        color: #cbd5e1 !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        border-radius: 6px !important;
        padding: 5px 12px !important;
        transition: all 0.2s;
    }

    .dt-buttons .btn:hover {
        background: rgba(0, 168, 255, 0.2) !important;
        color: #ffffff !important;
        border-color: var(--cyan-bright) !important;
    }
</style>
@endsection

@section('content')
<div class="table-container-card">
    <div class="fleet-header-card">
        <div>
            <h4>
                <i class="fa-solid fa-hospital" style="color: var(--cyan-bright);"></i>
                <span>Hospital & Partner Fleet Operators</span>
            </h4>
            <span style="font-size: 12px; color: var(--text-dim);">
                Manage commercial ambulance aggregators, hospital-owned fleets, dispatch commissions, and fleet vehicle rosters.
            </span>
        </div>

        @can('fleet-create')
        <a href="{{ route('admin.fleet.create') }}" class="btn-add-fleet">
            <i class="fa-solid fa-building-circle-check"></i> Onboard Fleet Partner
        </a>
        @endcan
    </div>

    <!-- Quick Stats -->
    <div class="stat-badge-row">
        <div class="stat-badge-item">
            <div class="stat-badge-icon" style="background: rgba(0, 168, 255, 0.15); color: var(--cyan-bright);">
                <i class="fa-solid fa-building"></i>
            </div>
            <div>
                <div class="val">{{ count($fleets) }}</div>
                <div class="lbl">Partner Companies</div>
            </div>
        </div>

        <div class="stat-badge-item">
            <div class="stat-badge-icon" style="background: rgba(155, 192, 60, 0.15); color: var(--green-status);">
                <i class="fa-solid fa-truck-medical"></i>
            </div>
            <div>
                <div class="val">
                    {{ $fleets->sum(function($f) { return $f->providers ? $f->providers->count() : 0; }) }}
                </div>
                <div class="lbl">Fleet Ambulances</div>
            </div>
        </div>

        <div class="stat-badge-item">
            <div class="stat-badge-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                <i class="fa-solid fa-percent"></i>
            </div>
            <div>
                <div class="val">
                    {{ count($fleets) > 0 ? round($fleets->avg('commission'), 1) : 0 }}%
                </div>
                <div class="lbl">Avg Commission</div>
            </div>
        </div>
    </div>

    @if(Setting::get('demo_mode', 0) == 1)
        <div style="background: rgba(230, 57, 70, 0.15); border: 1px dashed var(--crimson-alert); border-radius: 8px; padding: 10px 14px; margin-bottom: 20px; font-size: 12px; color: #ff7675;">
            <i class="fa-solid fa-triangle-exclamation"></i> <strong>Demo Mode Active:</strong> Fleet contact details and phone numbers are masked.
        </div>
    @endif

    <div style="overflow-x: auto; min-height: 260px;">
        <table class="table custom-fleet-table" id="table-fleet">
            <thead>
                <tr>
                    <th style="width: 45px;">#</th>
                    <th>Partner & Company</th>
                    <th>Contact Info</th>
                    <th style="text-align: center;">Ambulances</th>
                    <th style="text-align: center;">Commission</th>
                    <th style="text-align: right; width: 130px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fleets as $index => $fleet)
                <tr>
                    <td style="font-weight: 700; color: var(--cyan-bright);">{{ $index + 1 }}</td>
                    <td>
                        <div class="fleet-logo-chip">
                            <div class="logo-circle">
                                @if($fleet->logo)
                                    <img src="{{ asset('storage/'.$fleet->logo) }}" alt="{{ $fleet->company }}" onerror="this.style.display='none'; this.parentElement.innerText='{{ strtoupper(substr($fleet->company, 0, 1)) }}';">
                                @else
                                    <i class="fa-solid fa-hospital-user"></i>
                                @endif
                            </div>
                            <div>
                                <strong style="color: #ffffff; font-size: 14px;">{{ $fleet->company }}</strong>
                                <br>
                                <small style="color: var(--text-dim);">
                                    <i class="fa-solid fa-user-tie" style="color: var(--cyan-bright);"></i> {{ $fleet->name }}
                                </small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 12px; line-height: 1.6;">
                            @if(Setting::get('demo_mode', 0) == 1)
                                <div><i class="fa-solid fa-envelope" style="color: var(--cyan-bright); width: 16px;"></i> {{ substr($fleet->email, 0, 3).'****'.substr($fleet->email, strpos($fleet->email, "@")) }}</div>
                                <div><i class="fa-solid fa-phone" style="color: var(--green-status); width: 16px;"></i> +91 98765 ****</div>
                            @else
                                <div><i class="fa-solid fa-envelope" style="color: var(--cyan-bright); width: 16px;"></i> {{ $fleet->email }}</div>
                                <div><i class="fa-solid fa-phone" style="color: var(--green-status); width: 16px;"></i> {{ $fleet->mobile }}</div>
                            @endif
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.provider.index') }}?fleet={{ $fleet->id }}" class="ambulances-link" title="View all ambulances in this fleet">
                            <i class="fa-solid fa-truck-medical"></i> {{ $fleet->providers ? $fleet->providers->count() : 0 }} Ambulances
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <span class="commission-badge">
                            {{ $fleet->commission ?? 0 }}%
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div class="dropdown" style="display: inline-block;">
                            <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: rgba(8, 54, 75, 0.8); border: 1px solid var(--cyan-bright); color: #fff; font-size: 12px; font-weight: 700; border-radius: 6px; padding: 5px 12px;">
                                Manage <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dark-menu">
                                @can('fleet-providers')
                                    <a href="{{ route('admin.provider.index') }}?fleet={{ $fleet->id }}">
                                        <i class="fa-solid fa-truck-medical" style="color: var(--cyan-bright);"></i> View Ambulances
                                    </a>
                                @endcan

                                @if(Setting::get('demo_mode', 0) == 0)
                                    @can('fleet-edit')
                                        <a href="{{ route('admin.fleet.edit', $fleet->id) }}">
                                            <i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Edit Fleet
                                        </a>
                                    @endcan

                                    @can('fleet-delete')
                                        <form action="{{ route('admin.fleet.destroy', $fleet->id) }}" method="POST" style="margin: 0;">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" onclick="return confirm('Are you sure you want to remove this fleet partner?')" style="color: #ff7675 !important;">
                                                <i class="fa-solid fa-trash-can"></i> Delete Fleet
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#table-fleet').DataTable({
                responsive: true,
                paging: true,
                pageLength: 10,
                info: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copyHtml5', className: 'btn' },
                    { extend: 'excelHtml5', className: 'btn' },
                    { extend: 'csvHtml5', className: 'btn' },
                    { extend: 'pdfHtml5', className: 'btn' }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search fleet companies..."
                }
            });
        }
    });
</script>
@endsection