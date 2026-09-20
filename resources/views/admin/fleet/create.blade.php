@extends('admin.layout.base')

@section('title', 'Onboard Fleet Partner / Hospital - ')

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
        color: #cbd5e1 !important;
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
        color: #ffffff !important;
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="form-glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h4>
                <i class="fa-solid fa-building-circle-check" style="color: var(--cyan-bright);"></i>
                <span>Onboard New Hospital / Fleet Partner</span>
            </h4>
            <span class="section-sub">Register partner commercial fleet operators, hospital fleets, and negotiate dispatch commission margins.</span>
        </div>
        <a href="{{ route('admin.fleet.index') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Fleet List
        </a>
    </div>

    <form action="{{ route('admin.fleet.store') }}" method="POST" enctype="multipart/form-data" role="form">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="company">Company / Hospital Name <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('company') }}" name="company" required id="company" placeholder="e.g. Apollo Hospitals Emergency Fleet">
            </div>

            <div class="col-md-6 form-group">
                <label for="name">Representative Contact Person <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="e.g. Dr. Rajesh Kumar">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="email">Partner Account Email <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="email" required name="email" value="{{ old('email') }}" id="email" placeholder="fleet@apollo.com">
            </div>

            <div class="col-md-6 form-group">
                <label for="mobile">Official Contact Phone <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="9876543210">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="password">Portal Access Password <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="password" name="password" required id="password" placeholder="Min 6 characters">
            </div>

            <div class="col-md-6 form-group">
                <label for="password_confirmation">Confirm Password <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="password" name="password_confirmation" required id="password_confirmation" placeholder="Re-type Password">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="commission">Fleet Commission Rate (%)</label>
                <input class="form-control" type="number" step="0.1" value="{{ old('commission', 10) }}" name="commission" id="commission" placeholder="e.g. 10">
                <small style="color: var(--text-dim); font-size: 11px;">Commission applied on dispatches handled by this fleet partner.</small>
            </div>

            <div class="col-md-6 form-group">
                <label for="logo">Company Logo / Brand Asset</label>
                <input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo">
            </div>
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-check"></i> Complete Fleet Partner Onboarding
            </button>
            <a href="{{ route('admin.fleet.index') }}" class="btn-cancel-action">
                @lang('admin.cancel')
            </a>
        </div>
    </form>
</div>
@endsection
