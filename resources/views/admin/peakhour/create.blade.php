@extends('admin.layout.base')

@section('title', 'Add Peak Hour Surge Window - ')

@section('styles')
<link rel="stylesheet" href="{{ asset('asset/css/bootstrap-material-datetimepicker.css') }}" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
    .dtp .dtp-header {
        background: #00A8FF !important;
    }
    .dtp .dtp-actual-meridien a.selected {
        background: #00A8FF !important;
    }
    .dtp .dtp-picker-time > a.dtp-select-hour.selected {
        background: #00A8FF !important;
    }
</style>
@endsection

@section('content')
<div class="form-glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h4>
                <i class="fa-solid fa-clock" style="color: var(--cyan-bright);"></i>
                <span>Add Peak Hour Surge Window</span>
            </h4>
            <span class="section-sub">Define start and end times for dynamic ambulance surge and rush hour pricing intervals.</span>
        </div>
        <a href="{{ route('admin.peakhour.index') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Windows
        </a>
    </div>

    <form action="{{ route('admin.peakhour.store') }}" method="POST" role="form">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="start_time">Peak Window Start Time <span style="color: var(--crimson-alert);">*</span></label>
                <div class="input-group">
                    <input class="form-control" autocomplete="off" type="text" value="{{ old('start_time') }}" name="start_time" required id="start_time" placeholder="e.g. 08:00 AM">
                    <span class="input-group-addon" style="background: var(--stat-pill-bg); border-color: var(--border-line); color: var(--cyan-bright);">
                        <i class="fa-solid fa-clock"></i>
                    </span>
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label for="end_time">Peak Window End Time <span style="color: var(--crimson-alert);">*</span></label>
                <div class="input-group">
                    <input class="form-control" autocomplete="off" type="text" value="{{ old('end_time') }}" name="end_time" required id="end_time" placeholder="e.g. 11:00 AM">
                    <span class="input-group-addon" style="background: var(--stat-pill-bg); border-color: var(--border-line); color: var(--cyan-bright);">
                        <i class="fa-solid fa-clock"></i>
                    </span>
                </div>
            </div>
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-check"></i> Save Peak Window
            </button>
            <a href="{{ route('admin.peakhour.index') }}" class="btn-cancel-action">
                @lang('admin.cancel')
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('asset/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/js/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#start_time').bootstrapMaterialDatePicker({
        format: 'hh:mm A',
        date: false,
        shortTime: true
    });
    $('#end_time').bootstrapMaterialDatePicker({
        format: 'hh:mm A',
        date: false,
        shortTime: true
    });
});
</script>
@endsection