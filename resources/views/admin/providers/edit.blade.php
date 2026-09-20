@extends('admin.layout.base')

@section('title', 'Update Ambulance Driver / Paramedic - ')

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
                <i class="fa-solid fa-user-pen" style="color: var(--cyan-bright);"></i>
                <span>Update Driver Profile: {{ $provider->first_name }} {{ $provider->last_name }}</span>
            </h4>
            <span class="section-sub">Update driver contact records, profile image, and mobile dispatch routing numbers.</span>
        </div>
        <a href="{{ route('admin.provider.index') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Fleet
        </a>
    </div>

    <form action="{{ route('admin.provider.update', $provider->id) }}" method="POST" enctype="multipart/form-data" role="form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH">

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="first_name">@lang('admin.first_name') <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ $provider->first_name }}" name="first_name" required id="first_name" placeholder="First Name">
            </div>

            <div class="col-md-6 form-group">
                <label for="last_name">@lang('admin.last_name') <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ $provider->last_name }}" name="last_name" required id="last_name" placeholder="Last Name">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="mobile">@lang('admin.mobile') <span style="color: var(--crimson-alert);">*</span></label>
                <div class="row no-gutters">
                    <div class="col-4 pr-2">
                        <input type="text" name="country_code" class="form-control country-name" id="country_code" value="{{ $provider->country_code ?? '+91' }}">
                    </div>
                    <div class="col-8">
                        <input class="form-control" type="text" value="{{ $provider->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
                    </div>
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label for="email">@lang('admin.email')</label>
                <input class="form-control" type="email" readonly disabled value="{{ $provider->email }}" id="email" style="opacity: 0.7;">
            </div>
        </div>

        <div class="form-group" style="margin-top: 10px;">
            <label for="picture">Driver Profile Photo</label>
            @if(isset($provider->avatar) && $provider->avatar)
                <div style="margin-bottom: 12px;">
                    <img style="height: 70px; width: 70px; object-fit: cover; border-radius: 50%; border: 2px solid var(--cyan-bright);" src="{{ asset('storage/'.$provider->avatar) }}" onerror="this.src='{{ img($provider->avatar) }}'">
                </div>
            @endif
            <input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture">
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-floppy-disk"></i> Save Driver Changes
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