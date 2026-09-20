@extends('admin.layout.base')

@section('title', 'Open New Dispute Ticket - ')

@section('styles')
<link href="{{ asset('asset/css/jquery-ui.css') }}" rel="stylesheet"> 
<style>
    .form-glass-card {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        padding: 28px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(14px);
    }
    .form-glass-card h4 {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-glass-card .section-sub {
        font-size: 12px;
        color: var(--text-dim);
        margin-bottom: 24px;
        display: block;
    }
    .form-group label {
        color: var(--cyan-bright);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .btn-submit-action {
        background: linear-gradient(90deg, #00A8FF, #0284c7);
        color: #ffffff !important;
        font-weight: 700;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.4);
        transition: all 0.2s;
    }
    .btn-submit-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 168, 255, 0.6);
    }
    .btn-cancel-action {
        background: rgba(255, 255, 255, 0.08);
        color: var(--text-main) !important;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
        border: 1px solid var(--border-line);
        margin-left: 10px;
        text-decoration: none;
        display: inline-block;
    }
    .btn-cancel-action:hover {
        background: rgba(255, 255, 255, 0.15);
        text-decoration: none;
    }
    .ui-autocomplete {
        background: #08364B !important;
        border: 1px solid var(--border-line) !important;
        border-radius: 8px;
        color: #ffffff !important;
        max-height: 200px;
        overflow-y: auto;
        z-index: 9999 !important;
    }
    .ui-menu-item-wrapper {
        padding: 8px 12px !important;
        color: #ffffff !important;
    }
    .ui-menu-item-wrapper.ui-state-active {
        background: #00A8FF !important;
        color: #ffffff !important;
        border: none !important;
    }
</style>
@endsection

@section('content')
<div class="form-glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h4>
                <i class="fa-solid fa-triangle-exclamation" style="color: var(--crimson-alert);"></i>
                <span>Open New Dispatch Dispute Ticket</span>
            </h4>
            <span class="section-sub">Search for patient or paramedic, associate dispatch booking ID, and lodge dispute description.</span>
        </div>
        <a href="{{ route('admin.userdisputes') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Disputes
        </a>
    </div>

    <form action="{{ route('admin.userdisputestore') }}" method="POST" role="form">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="dispute_type">Dispute Target Audience <span style="color: var(--crimson-alert);">*</span></label>
                <select class="form-control" name="dispute_type" id="dispute_type" required>
                    <option value="user">Patient / App User</option>
                    <option value="provider">Paramedic / Ambulance Driver</option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label for="namesearch">Search Name or ID <span style="color: var(--crimson-alert);">*</span></label>
                <div class="input-group">
                    <input class="form-control" type="text" value="{{ old('name') }}" name="name" id="namesearch" placeholder="Type name to search..." required autocomplete="off">
                    <span class="input-group-addon" style="background: var(--stat-pill-bg); border-color: var(--border-line); color: var(--cyan-bright);">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                </div>
                <input type="hidden" name="user_id1" id="user_id1" value="">
            </div>
        </div>

        <div class="form-group">
            <label>Associated Ambulance Trip / Dispatch Booking <span style="color: var(--crimson-alert);">*</span></label>
            <div class="table-responsive" style="background: var(--stat-pill-bg); border-radius: 8px; border: 1px solid var(--border-line); padding: 10px;">
                <table class="table table-bordered requestList" style="margin-bottom: 0;">
                    <thead>
                        <tr style="background: rgba(0, 168, 255, 0.08);">
                            <th style="color: var(--cyan-bright);">Booking ID</th>
                            <th style="color: var(--cyan-bright);">Pickup Point</th>
                            <th style="color: var(--cyan-bright);">Hospital Destination</th>
                            <th style="color: var(--cyan-bright); text-align: center;">Select Trip</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="4" style="text-align: center; color: var(--text-dim);">Search a user/provider above to load recent ambulance dispatches</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <label for="dispute_name">Dispute Subject / Category <span style="color: var(--crimson-alert);">*</span></label>
            <select class="form-control" name="dispute_name" id="dispute_name" required>
                <option value="">-- Select Dispute Category --</option>
            </select>
            <textarea style="display: none; margin-top: 10px;" class="form-control" name="dispute_other" id="dispute_other" placeholder="Describe the dispute issue in detail...">{{ old('dispute_other') }}</textarea>
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <input type="hidden" name="is_admin" value="1" />
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-check"></i> Lodge Dispute Ticket
            </button>
            <a href="{{ route('admin.userdisputes') }}" class="btn-cancel-action">
                @lang('admin.cancel')
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('asset/js/jquery-ui.js') }}"></script>
<script type="text/javascript">
var sflag = '';
get_disputes('user');

$("#dispute_type").on('change', function() {
    $("#namesearch").val('');
    $('.requestList tbody').html('<tr><td colspan="4" style="text-align: center; color: var(--text-dim);">Search a user/provider above to load recent ambulance dispatches</td></tr>');
    get_disputes($(this).val());
    $("#dispute_other").hide().attr('required', false);
});

$("#dispute_name").on('change', function() {
    if ($(this).val() == 'others') {
        $("#dispute_other").show().attr('required', true);
    } else {
        $("#dispute_other").hide().attr('required', false);
    }
});

$('#namesearch').autocomplete({
    source: function(request, response) {
        var url = '{{ route("admin.usersearch") }}';
        sflag = 0;
        if ($("#dispute_type").val() == 'provider') {
            sflag = 1;
            url = '{{ route("admin.userprovider") }}';
        }
        $.ajax({
            type: "GET",
            url: url,
            data: { stext: request.term },
            dataType: "json",
            success: function(responsedata) {
                if (!responsedata.data.length) {
                    response([{ id: 0, label: "No Records Found" }]);
                } else {
                    response($.map(responsedata.data, function(item) {
                        return {
                            value: item.first_name + " " + (item.last_name || '') + " (ID: #" + item.id + ")",
                            id: item.id
                        };
                    }));
                }
            }
        });
    },
    minLength: 2,
    change: function(event, ui) {
        if (ui.item == null || ui.item.id == 0) {
            $("#namesearch").val('');
        }
    },
    select: function(event, ui) {
        $.ajax({
            url: "{{ route('admin.ridesearch') }}",
            type: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                id: ui.item.id,
                sflag: sflag
            },
            success: function(data) {
                var requestList = $('.requestList tbody');
                requestList.html('<tr><td colspan="4" style="text-align: center; color: var(--text-dim);">No recent trips found for this account</td></tr>');
                if (data.data && data.data.length > 0) {
                    var html = '';
                    var result = data.data;
                    for (var i in result) {
                        html += `<tr>
                            <td><strong>#` + result[i].booking_id + `</strong></td>
                            <td style="font-size: 12px;">` + (result[i].s_address || 'Pickup Point') + `</td>
                            <td style="font-size: 12px;">` + (result[i].d_address || 'Destination Hospital') + `</td>
                            <td style="text-align: center;">
                                <input name="request_id" value="` + result[i].id + `" type="radio" required />
                                <input name="user_id" value="` + result[i].user_id + `" type="hidden" />
                                <input name="provider_id" value="` + result[i].provider_id + `" type="hidden" />
                            </td>
                        </tr>`;
                    }
                    requestList.html(html);
                }
            }
        });
        $("#user_id1").val(ui.item.id);
    }
});

function get_disputes(dispute_type) {
    $.ajax({
        url: "{{ url('admin/disputelist') }}",
        type: 'get',
        data: { dispute_type: dispute_type },
        success: function(data) {
            $('#dispute_name').empty();
            $.each(data, function(key, value) {
                $('#dispute_name').append($("<option/>", {
                    value: value.dispute_name,
                    text: value.dispute_name
                }));
            });
            $('#dispute_name').append($("<option/>", {
                value: 'others',
                text: 'Others / Custom Complaint'
            }));
            if (data.length > 0) {
                $("#dispute_other").hide().attr('required', false);
            } else {
                $("#dispute_other").show().attr('required', true);
            }
        }
    });
}
</script>
@endsection