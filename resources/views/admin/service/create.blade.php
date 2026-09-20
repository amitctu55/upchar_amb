@extends('admin.layout.base')

@section('title', 'Add New Ambulance Category - ')

@section('styles')
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
    .section-divider-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--text-main);
        margin: 28px 0 16px 0;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border-line);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .calc-formula-box {
        background: var(--stat-pill-bg);
        border: 1px solid var(--border-line);
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 13px;
        color: #00A8FF;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
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
</style>
@endsection

@section('content')
<div class="form-glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h4>
                <i class="fa-solid fa-truck-medical" style="color: var(--cyan-bright);"></i>
                <span>Add Ambulance Category & Fare Policy</span>
            </h4>
            <span class="section-sub">Define dispatch pricing rules, mileage parameters, vehicle icons and peak surge multipliers.</span>
        </div>
        <a href="{{ route('admin.service.index') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Categories
        </a>
    </div>

    <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data" role="form">
        {{ csrf_field() }}

        <div class="section-divider-title">
            <i class="fa-solid fa-circle-info" style="color: var(--cyan-bright);"></i>
            <span>Basic Vehicle Specifications</span>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="name">Ambulance Category Name <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="e.g. Advanced Life Support (ALS)">
            </div>

            <div class="col-md-6 form-group">
                <label for="capacity">Passenger / Paramedic Capacity <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="number" value="{{ old('capacity', 2) }}" name="capacity" required id="capacity" placeholder="e.g. 2" min="1">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="image">Ambulance Vehicle Icon (.png / .ico)</label>
                <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="image">
            </div>

            <div class="col-md-6 form-group">
                <label for="marker">Map Telemetry Pin Marker (.png / .ico)</label>
                <input type="file" accept="image/*" name="marker" class="dropify form-control-file" id="marker">
            </div>
        </div>

        <div class="section-divider-title">
            <i class="fa-solid fa-calculator" style="color: var(--cyan-bright);"></i>
            <span>Fare Pricing Logic & Base Rates</span>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="calculator">Pricing Logic Calculator <span style="color: var(--crimson-alert);">*</span></label>
                <select class="form-control" id="calculator" name="calculator">
                    <option value="MIN">@lang('servicetypes.MIN')</option>
                    <option value="HOUR">@lang('servicetypes.HOUR')</option>
                    <option value="DISTANCE">@lang('servicetypes.DISTANCE')</option>
                    <option value="DISTANCEMIN" selected>@lang('servicetypes.DISTANCEMIN')</option>
                    <option value="DISTANCEHOUR">@lang('servicetypes.DISTANCEHOUR')</option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label>Active Calculation Formula</label>
                <div class="calc-formula-box">
                    <i class="fa-solid fa-function"></i>
                    <span id="changecal">BP + (Total Dist - Base Dist)*Dist Price + (Minutes * Minute Price)</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="fixed">Base Price / Starting Fare ({{ currency() }}) <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control price" type="number" step="0.01" value="{{ old('fixed', 150) }}" name="fixed" required id="fixed" placeholder="Base Price">
            </div>

            <div class="col-md-4 form-group">
                <label for="distance">Base Distance Included ({{ distance() }})</label>
                <input class="form-control price" type="number" step="0.01" value="{{ old('distance', 2) }}" name="distance" id="distance" placeholder="Base Distance">
            </div>

            <div class="col-md-4 form-group">
                <label for="price">Unit Distance Rate / {{ config('constants.distance', 'Km') }} ({{ currency() }})</label>
                <input class="form-control price" type="number" step="0.01" value="{{ old('price', 25) }}" name="price" id="price" placeholder="Distance Price">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="minute">Unit Time Rate / Minute ({{ currency() }})</label>
                <input class="form-control price" type="number" step="0.01" value="{{ old('minute', 2) }}" name="minute" id="minute" placeholder="Per Minute Rate">
            </div>

            <div class="col-md-6 form-group" id="hour_price_group">
                <label for="hourly_price">Hourly Rate ({{ currency() }}) - For Hourly Packages</label>
                <input class="form-control price" type="number" step="0.01" value="{{ old('hour') }}" name="hour" id="hourly_price" placeholder="Per Hour Rate">
            </div>
        </div>

        <div class="section-divider-title">
            <i class="fa-solid fa-clock-rotate-left" style="color: var(--cyan-bright);"></i>
            <span>Waiting & Wave Fee Policies</span>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="waiting_free_mins">Free Waiting Window (Minutes)</label>
                <input class="form-control" type="number" value="{{ old('waiting_free_mins', 5) }}" name="waiting_free_mins" id="waiting_free_mins" placeholder="e.g. 5">
            </div>

            <div class="col-md-6 form-group">
                <label for="waiting_min_charge">Waiting Charge / Minute ({{ currency() }})</label>
                <input class="form-control price" type="number" step="0.01" value="{{ old('waiting_min_charge', 5) }}" name="waiting_min_charge" id="waiting_min_charge" placeholder="e.g. 5.00">
            </div>
        </div>

        @if(isset($Peakhour) && count($Peakhour) > 0)
        <div class="section-divider-title">
            <i class="fa-solid fa-bolt" style="color: #F59E0B;"></i>
            <span>Peak Hour Surge Multipliers</span>
        </div>

        <div class="table-responsive" style="margin-bottom: 24px;">
            <table class="table table-bordered" style="background: var(--stat-pill-bg);">
                <thead>
                    <tr style="background: rgba(0, 168, 255, 0.08);">
                        <th style="color: var(--cyan-bright);">#</th>
                        <th style="color: var(--cyan-bright);">Peak Time Window</th>
                        <th style="color: var(--cyan-bright);">Surge Flat Charge / Multiplier ({{ currency() }})</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Peakhour as $index => $w)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong style="color: var(--text-main);">
                                <i class="fa-solid fa-clock" style="color: var(--cyan-bright);"></i>
                                {{ date('h:i A', strtotime($w->start_time)) }} - {{ date('h:i A', strtotime($w->end_time)) }}
                            </strong>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control" style="max-width: 200px;" name="peak_price[{{ $w->id }}]" placeholder="Surge amount in {{ currency() }}" min="0">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-check"></i> Create Ambulance Category
            </button>
            <a href="{{ route('admin.service.index') }}" class="btn-cancel-action">
                @lang('admin.cancel')
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var cal = $("#calculator").val() || 'DISTANCEMIN';
    priceInputs(cal);
    $("#calculator").on('change', function() {
        cal = $(this).val();
        priceInputs(cal);
    });

    function priceInputs(cal) {
        if (cal == 'MIN') {
            $("#minute").prop('disabled', false).prop('required', true);
            $("#hourly_price, #distance, #price").prop('disabled', true).prop('required', false);
            $("#changecal").text('BP + (Minutes * Minute Price)');
        } else if (cal == 'HOUR') {
            $("#hourly_price").prop('disabled', false).prop('required', true);
            $("#minute, #distance, #price").prop('disabled', true).prop('required', false);
            $("#changecal").text('BP + (Hours * Hourly Price)');
        } else if (cal == 'DISTANCE') {
            $("#price, #distance").prop('disabled', false).prop('required', true);
            $("#minute, #hourly_price").prop('disabled', true).prop('required', false);
            $("#changecal").text('BP + (Distance - Base Distance) * Distance Price');
        } else if (cal == 'DISTANCEMIN') {
            $("#price, #distance, #minute").prop('disabled', false).prop('required', true);
            $("#hourly_price").prop('disabled', true).prop('required', false);
            $("#changecal").text('BP + (Distance - Base Distance) * Dist Price + (Minutes * Minute Price)');
        } else if (cal == 'DISTANCEHOUR') {
            $("#price, #distance, #hourly_price").prop('disabled', false).prop('required', true);
            $("#minute").prop('disabled', true).prop('required', false);
            $("#changecal").text('BP + (Distance - Base Distance) * Dist Price + (Hours * Hourly Price)');
        }
    }
</script>
@endsection