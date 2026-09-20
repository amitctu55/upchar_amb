@extends('admin.layout.base')

@section('title', 'Registered Patients & Users - ')

@section('styles')
<style>
    .user-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .user-header-card h4 {
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

    .btn-add-user {
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

    .btn-add-user:hover {
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

    .user-avatar-sm {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #00A8FF;
    }

    .user-initial-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00A8FF, #0284c7);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
    }

    .btn-table-action {
        font-size: 11px;
        padding: 5px 10px;
        border-radius: 6px;
        margin: 2px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 600;
        border: none;
        text-decoration: none;
        transition: all 0.15s;
    }
    .btn-action-view {
        background: rgba(0, 168, 255, 0.15);
        color: #00A8FF !important;
        border: 1px solid rgba(0, 168, 255, 0.3);
    }
    .btn-action-view:hover {
        background: #00A8FF;
        color: #ffffff !important;
    }
    .btn-action-history {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981 !important;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .btn-action-history:hover {
        background: #10B981;
        color: #ffffff !important;
    }
    .btn-action-edit {
        background: rgba(245, 158, 11, 0.15);
        color: #F59E0B !important;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    .btn-action-edit:hover {
        background: #F59E0B;
        color: #ffffff !important;
    }
    .btn-action-delete {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444 !important;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .btn-action-delete:hover {
        background: #EF4444;
        color: #ffffff !important;
    }
</style>
@endsection

@section('content')
<div class="user-header-card">
    <div>
        <h4>
            <i class="fa-solid fa-users" style="color: var(--cyan-bright);"></i>
            <span>Registered Patients & App Users</span>
        </h4>
        <div style="font-size: 12px; color: var(--text-dim);">Manage registered medical service users, emergency emergency check-in dossiers, wallet balances and trip history</div>
    </div>
    @can('user-create')
    <a href="{{ route('admin.user.create') }}" class="btn-add-user">
        <i class="fa-solid fa-user-plus"></i> Add New Patient / User
    </a>
    @endcan
</div>

@if(Setting::get('demo_mode', 0) == 1)
<div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; padding: 10px 16px; margin-bottom: 16px; color: #ef4444; font-size: 12px; font-weight: 600;">
    <i class="fa-solid fa-triangle-exclamation"></i> Demo Mode Active: Personal email & mobile numbers are partially masked.
</div>
@endif

<div class="stat-badge-row">
    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(0, 168, 255, 0.15); color: #00A8FF;">
            <i class="fa-solid fa-user-group"></i>
        </div>
        <div>
            <div class="val">{{ $pagination->total ?? count($users) }}</div>
            <div class="lbl">Total Patients</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
            <i class="fa-solid fa-wallet"></i>
        </div>
        <div>
            <div class="val">{{ currency($users->sum('wallet_balance')) }}</div>
            <div class="lbl">Page Wallet Total</div>
        </div>
    </div>

    <div class="stat-badge-item">
        <div class="stat-badge-icon" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">
            <i class="fa-solid fa-star"></i>
        </div>
        <div>
            <div class="val">{{ number_format($users->avg('rating'), 1) }}</div>
            <div class="lbl">Avg Satisfaction</div>
        </div>
    </div>
</div>

<div class="table-container-card">
    <table class="table table-striped table-bordered dataTable" id="table-5" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient / User</th>
                <th>Email Address</th>
                <th>Mobile Number</th>
                <th>Rating</th>
                <th>Wallet Balance</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php($page = ($pagination->currentPage - 1) * $pagination->perPage)
            @foreach($users as $index => $user)
            @php($page++)
            <tr>
                <td>{{ $page }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($user->picture)
                            <img src="{{ img($user->picture) }}" alt="{{ $user->first_name }}" class="user-avatar-sm">
                        @else
                            <div class="user-initial-badge">
                                {{ strtoupper(substr($user->first_name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('admin.user.show', $user->id) }}" style="font-weight: 700; color: var(--text-main); text-decoration: none;">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </a>
                            <div style="font-size: 11px; color: var(--text-dim);">ID: #{{ $user->id }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if(Setting::get('demo_mode', 0) == 1)
                        {{ substr($user->email, 0, 3).'****'.substr($user->email, strpos($user->email, "@")) }}
                    @else
                        {{ $user->email }}
                    @endif
                </td>
                <td>
                    @if(Setting::get('demo_mode', 0) == 1)
                        +91 98765 43210
                    @else
                        {{ $user->country_code ? $user->country_code.' ' : '' }}{{ $user->mobile }}
                    @endif
                </td>
                <td>
                    <span style="font-weight: 700; color: #F59E0B;">
                        <i class="fa-solid fa-star"></i> {{ number_format($user->rating, 1) }}
                    </span>
                </td>
                <td>
                    <strong style="color: #10B981;">{{ currency($user->wallet_balance) }}</strong>
                </td>
                <td style="font-size: 12px; color: var(--text-dim);">
                    {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                </td>
                <td>
                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                        <a href="{{ route('admin.user.show', $user->id) }}" class="btn-table-action btn-action-view" title="View Patient Dossier">
                            <i class="fa-solid fa-id-card"></i> Dossier
                        </a>

                        @can('user-history')
                        <a href="{{ route('admin.user.request', $user->id) }}" class="btn-table-action btn-action-history" title="Trip History">
                            <i class="fa-solid fa-clock-rotate-left"></i> History
                        </a>
                        @endcan

                        @if(Setting::get('demo_mode', 0) == 0)
                            @can('user-edit')
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-table-action btn-action-edit" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            @endcan

                            @can('user-delete')
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this user?');">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn-table-action btn-action-delete">
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
    @include('common.pagination')
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    jQuery.fn.DataTable.Api.register('buttons.exportData()', function (options) {
        if (this.context.length) {
            var jsonResult = $.ajax({
                url: "{{ url('admin/user') }}?page=all",
                data: {},
                success: function (result) {
                    p = new Array();
                    $.each(result.data, function (i, d) {
                        var item = [d.id, d.first_name, d.last_name, d.email, d.mobile, d.rating, d.wallet_balance];
                        p.push(item);
                    });
                },
                async: false
            });
            var head = new Array();
            head.push("ID", "First Name", "Last Name", "Email", "Mobile", "Rating", "Wallet Amount");
            return { body: p, header: head };
        }
    });

    $('#table-5').DataTable({
        responsive: true,
        paging: false,
        info: false,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });
</script>
@endsection