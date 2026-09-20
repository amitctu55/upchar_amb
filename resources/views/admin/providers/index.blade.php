@extends('admin.layout.base')

@section('title', 'Ambulance Drivers & Paramedics - ')

@section('styles')
<style>
    .provider-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .provider-header-card h4 {
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

    .btn-add-provider {
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

    .btn-add-provider:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 168, 255, 0.6);
        text-decoration: none;
    }

    /* Table custom wrap */
    .table-container-card {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(14px);
    }

    .custom-provider-table {
        width: 100% !important;
        margin-bottom: 0;
        color: var(--text-main);
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-provider-table th {
        background: var(--table-head-bg) !important;
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

    .custom-provider-table td {
        padding: 14px 12px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid var(--border-line) !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        font-size: 13px;
        color: var(--text-main);
    }

    .custom-provider-table tr:hover td {
        background: rgba(0, 168, 255, 0.04);
    }

    .provider-avatar-chip {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .provider-avatar-chip .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--panel-navy);
        border: 1.5px solid var(--cyan-bright);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--cyan-bright);
        font-weight: 700;
        font-size: 15px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .provider-avatar-chip .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-status.active {
        background: rgba(22, 163, 74, 0.15);
        color: var(--green-status);
        border: 1px solid var(--green-status);
    }

    .badge-status.inactive {
        background: rgba(230, 57, 70, 0.15);
        color: var(--crimson-alert);
        border: 1px solid var(--crimson-alert);
    }

    .badge-doc-ok {
        background: rgba(22, 163, 74, 0.15);
        color: var(--green-status);
        border: 1px solid var(--green-status);
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .badge-doc-ok:hover {
        background: var(--green-status);
        color: #ffffff;
        text-decoration: none;
    }

    .badge-doc-pending {
        background: rgba(230, 57, 70, 0.15);
        color: var(--crimson-alert);
        border: 1px solid var(--crimson-alert);
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .badge-doc-pending:hover {
        background: var(--crimson-alert);
        color: #ffffff;
        text-decoration: none;
    }

    .dropdown-menu.dark-menu {
        background: var(--dropdown-bg) !important;
        border: 1px solid var(--border-line) !important;
        border-radius: 10px !important;
        padding: 6px 0 !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
        z-index: 1050;
    }

    .dropdown-menu.dark-menu a,
    .dropdown-menu.dark-menu button {
        color: var(--text-main) !important;
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
        background: rgba(0, 168, 255, 0.12) !important;
        color: var(--cyan-bright) !important;
        text-decoration: none;
    }

    /* DataTables search & buttons styling */
    .dataTables_wrapper .dataTables_filter {
        float: right;
        margin-bottom: 14px;
    }

    .dataTables_wrapper .dataTables_filter input {
        background: var(--input-bg) !important;
        border: 1px solid var(--border-line) !important;
        color: var(--text-main) !important;
        border-radius: 8px !important;
        padding: 6px 12px;
        font-size: 12px;
        margin-left: 8px;
        outline: none;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--cyan-bright) !important;
        box-shadow: 0 0 10px rgba(0, 168, 255, 0.3) !important;
    }

    .dt-buttons {
        margin-bottom: 14px;
        display: inline-flex;
        gap: 6px;
    }

    .dt-buttons .btn {
        background: var(--stat-pill-bg) !important;
        border: 1px solid var(--border-line) !important;
        color: var(--text-main) !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        border-radius: 6px !important;
        padding: 5px 12px !important;
        transition: all 0.2s;
    }

    .dt-buttons .btn:hover {
        background: rgba(0, 168, 255, 0.15) !important;
        color: var(--cyan-bright) !important;
        border-color: var(--cyan-bright) !important;
    }

    /* Pagination container */
    .pagination-wrapper {
        margin-top: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 12px;
        color: var(--text-dim);
    }
</style>
@endsection

@section('content')
<div class="table-container-card">
    <div class="provider-header-card">
        <div>
            <h4>
                <i class="fa-solid fa-user-doctor" style="color: var(--cyan-bright);"></i>
                <span>Ambulance Drivers & EMT Paramedics</span>
            </h4>
            <span style="font-size: 12px; color: var(--text-dim);">
                Manage verified drivers, compliance documents, vehicle ratings, and operational status.
            </span>
        </div>

        @can('provider-create')
        <a href="{{ route('admin.provider.create') }}" class="btn-add-provider">
            <i class="fa-solid fa-user-plus"></i> Onboard New Driver
        </a>
        @endcan
    </div>

    <!-- Quick Stats Summary -->
    <div class="stat-badge-row">
        <div class="stat-badge-item">
            <div class="stat-badge-icon" style="background: rgba(0, 168, 255, 0.15); color: var(--cyan-bright);">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="val">{{ $pagination->total ?? count($providers) }}</div>
                <div class="lbl">Total Drivers</div>
            </div>
        </div>

        <div class="stat-badge-item">
            <div class="stat-badge-icon" style="background: rgba(22, 163, 74, 0.15); color: var(--green-status);">
                <i class="fa-solid fa-truck-medical"></i>
            </div>
            <div>
                <div class="val">{{ $providers->where('status', 'approved')->count() }}</div>
                <div class="lbl">Approved & Active</div>
            </div>
        </div>

        <div class="stat-badge-item">
            <div class="stat-badge-icon" style="background: rgba(230, 57, 70, 0.15); color: var(--crimson-alert);">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
            <div>
                <div class="val">{{ $total_documents ?? 0 }}</div>
                <div class="lbl">Mandatory KYC Docs</div>
            </div>
        </div>
    </div>

    @if(Setting::get('demo_mode', 0) == 1)
        <div style="background: rgba(230, 57, 70, 0.12); border: 1px dashed var(--crimson-alert); border-radius: 8px; padding: 10px 14px; margin-bottom: 20px; font-size: 12px; color: var(--crimson-alert);">
            <i class="fa-solid fa-triangle-exclamation"></i> <strong>Demo Mode Active:</strong> Driver phone numbers and emails are partially masked.
        </div>
    @endif

    <div style="overflow-x: auto; min-height: 280px;">
        <table class="table custom-provider-table" id="table-5">
            <thead>
                <tr>
                    <th style="width: 45px;">#</th>
                    <th>Driver / Paramedic</th>
                    <th>Contact Info</th>
                    <th style="text-align: center;">Total Trips</th>
                    <th style="text-align: center;">Completed</th>
                    <th style="text-align: center;">Cancelled</th>
                    @can('provider-documents')
                    <th style="text-align: center;">KYC Status</th>
                    @endcan
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: right; width: 130px;">Action</th>
                </tr>
            </thead>
            <tbody>
            @php($page = ($pagination->currentPage-1)*$pagination->perPage)
            @foreach($providers as $index => $provider)
            @php($page++)
                <tr>
                    <td style="font-weight: 700; color: var(--cyan-bright);">{{ $page }}</td>
                    <td>
                        <div class="provider-avatar-chip">
                            <div class="avatar-circle">
                                @if($provider->avatar)
                                    <img src="{{ asset('storage/'.$provider->avatar) }}" alt="{{ $provider->first_name }}" onerror="this.style.display='none'; this.parentElement.innerText='{{ strtoupper(substr($provider->first_name, 0, 1)) }}';">
                                @else
                                    {{ strtoupper(substr($provider->first_name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <strong style="color: var(--text-main); font-size: 14px;">{{ $provider->first_name }} {{ $provider->last_name }}</strong>
                                <br>
                                <small style="color: var(--text-dim);">
                                    @if($provider->service)
                                        <i class="fa-solid fa-truck-medical" style="color: var(--cyan-bright);"></i> {{ $provider->service->service_model ?? 'Ambulance' }} ({{ $provider->service->service_number ?? 'UP-AMB' }})
                                    @else
                                        <span style="color: #f59e0b;"><i class="fa-solid fa-circle-exclamation"></i> Unassigned Vehicle</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 12px; line-height: 1.6;">
                            @if(Setting::get('demo_mode', 0) == 1)
                                <div><i class="fa-solid fa-envelope" style="color: var(--cyan-bright); width: 16px;"></i> {{ substr($provider->email, 0, 3).'****'.substr($provider->email, strpos($provider->email, "@")) }}</div>
                                <div><i class="fa-solid fa-phone" style="color: var(--green-status); width: 16px;"></i> +91 98765 ****</div>
                            @else
                                <div><i class="fa-solid fa-envelope" style="color: var(--cyan-bright); width: 16px;"></i> {{ $provider->email }}</div>
                                <div><i class="fa-solid fa-phone" style="color: var(--green-status); width: 16px;"></i> {{ $provider->mobile }}</div>
                            @endif
                        </div>
                    </td>
                    <td style="text-align: center; font-weight: 800; font-size: 14px; color: var(--text-main);">
                        {{ $provider->total_requests() }}
                    </td>
                    <td style="text-align: center; font-weight: 800; color: var(--green-status);">
                        {{ $provider->accepted_requests() }}
                    </td>
                    <td style="text-align: center; font-weight: 800; color: var(--crimson-alert);">
                        {{ $provider->total_requests() - $provider->accepted_requests() }}
                    </td>
                    @can('provider-documents')
                    <td style="text-align: center;">
                        @if($provider->active_documents() == $total_documents && $provider->service != null)
                            <a class="badge-doc-ok" href="{{ route('admin.provider.document.index', $provider->id) }}" title="All documents verified">
                                <i class="fa-solid fa-circle-check"></i> Verified
                            </a>
                        @else                               
                            <a class="badge-doc-pending" href="{{ route('admin.provider.document.index', $provider->id) }}" title="Pending documents verification">
                                <i class="fa-solid fa-circle-exclamation"></i> Pending ({{ $provider->pending_documents() }})
                            </a>
                        @endif
                    </td>
                    @endcan
                    <td style="text-align: center;">
                        @if($provider->status == 'approved')
                            <span class="badge-status active"><i class="fa-solid fa-circle" style="font-size: 7px;"></i> ACTIVE</span>
                        @elseif($provider->status == 'banned')
                            <span class="badge-status inactive"><i class="fa-solid fa-circle" style="font-size: 7px;"></i> BANNED</span>
                        @else
                            <span class="badge-status inactive"><i class="fa-solid fa-circle" style="font-size: 7px;"></i> {{ strtoupper($provider->status) }}</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div class="dropdown" style="display: inline-block;">
                            <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: var(--stat-pill-bg); border: 1px solid var(--cyan-bright); color: var(--text-main); font-size: 12px; font-weight: 700; border-radius: 6px; padding: 5px 12px;">
                                Manage <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dark-menu">
                                @can('provider-status')
                                    @if($provider->status == 'approved')
                                        <a href="{{ route('admin.provider.disapprove', $provider->id) }}" style="color: var(--crimson-alert) !important;">
                                            <i class="fa-solid fa-user-slash"></i> Disable Account
                                        </a>
                                    @else
                                        <a href="{{ route('admin.provider.approve', $provider->id) }}" style="color: var(--green-status) !important;">
                                            <i class="fa-solid fa-user-check"></i> Approve / Enable
                                        </a>
                                    @endif
                                @endcan

                                @can('provider-history')
                                    <a href="{{ route('admin.provider.request', $provider->id) }}">
                                        <i class="fa-solid fa-clock-rotate-left" style="color: var(--cyan-bright);"></i> Trip History
                                    </a>
                                @endcan

                                @can('provider-statements')
                                    <a href="{{ route('admin.provider.statement', $provider->id) }}">
                                        <i class="fa-solid fa-file-invoice-dollar" style="color: var(--green-status);"></i> Payout Statement
                                    </a>
                                @endcan

                                @if(Setting::get('demo_mode', 0) == 0)
                                    @can('provider-edit')
                                        <a href="{{ route('admin.provider.edit', $provider->id) }}">
                                            <i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Edit Profile
                                        </a>
                                    @endcan

                                    @can('provider-delete')
                                        <form action="{{ route('admin.provider.destroy', $provider->id) }}" method="POST" style="margin: 0;">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" onclick="return confirm('Are you sure you want to remove this driver?')" style="color: var(--crimson-alert) !important;">
                                                <i class="fa-solid fa-trash-can"></i> Delete Driver
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

    <div class="pagination-wrapper">
        @include('common.pagination')
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#table-5').DataTable({
                responsive: true,
                paging: false,
                info: false,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copyHtml5', className: 'btn' },
                    { extend: 'excelHtml5', className: 'btn' },
                    { extend: 'csvHtml5', className: 'btn' },
                    { extend: 'pdfHtml5', className: 'btn' }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search drivers, vehicles..."
                }
            });
        }
    });
</script>
@endsection