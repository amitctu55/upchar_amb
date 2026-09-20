@extends('admin.layout.base')

@section('title', 'Onboard Ambulance Driver / Paramedic - ')

@section('styles')
<link rel="stylesheet" href="{{ asset('asset/css/intlTelInput.css') }}">
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
    .iti { width: 100%; }
    .iti__country-list {
        background: #08364B !important;
        color: #ffffff !important;
        border: 1px solid var(--border-line) !important;
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
                <i class="fa-solid fa-user-plus" style="color: var(--cyan-bright);"></i>
                <span>Onboard New Ambulance Driver / EMT</span>
            </h4>
            <span class="section-sub">Create driver credentials, assign country dialing codes, and configure emergency dispatch identity.</span>
        </div>
        <a href="{{ route('admin.provider.index') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Fleet
        </a>
    </div>

    <form action="{{ route('admin.provider.store') }}" method="POST" enctype="multipart/form-data" role="form">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="first_name">@lang('admin.first_name') <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="Driver's First Name">
            </div>

            <div class="col-md-6 form-group">
                <label for="last_name">@lang('admin.last_name') <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name" required id="last_name" placeholder="Driver's Last Name">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="email">@lang('admin.email') <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="email" required name="email" value="{{ old('email') }}" id="email" placeholder="driver@upchar.info">
            </div>

            <div class="col-md-6 form-group">
                <label for="mobile">@lang('admin.mobile') <span style="color: var(--crimson-alert);">*</span></label>
                <div class="row no-gutters">
                    <div class="col-4 pr-2">
                        <input type="text" name="country_code" value="+91" class="form-control country-name" id="country_code" placeholder="+91">
                    </div>
                    <div class="col-8">
                        <input class="form-control" type="text" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="9876543210">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="password">@lang('admin.password') <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="password" name="password" required id="password" placeholder="Min 6 characters">
            </div>

            <div class="col-md-6 form-group">
                <label for="password_confirmation">@lang('admin.provides.password_confirmation') <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="password" name="password_confirmation" required id="password_confirmation" placeholder="Re-type Password">
            </div>
        </div>

        <div class="form-group" style="margin-top: 10px;">
            <label for="picture">Driver Profile Photo / Picture</label>
            <input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture">
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-check"></i> Complete Driver Onboarding
            </button>
            <a href="{{ route('admin.provider.index') }}" class="btn-cancel-action">
                @lang('admin.cancel')
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('asset/js/intlTelInput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/js/intlTelInput-jquery.min.js') }}"></script>
<script type="text/javascript">
    var input = document.querySelector("#country_code");
    if (input && window.intlTelInput) {
        window.intlTelInput(input, {});
        $(".country-name").click(function(){
            var myVar = $(this).closest('.country').find(".dial-code").text();
            if (myVar) $('#country_code').val(myVar);
        });
    }
</script>
@endsection