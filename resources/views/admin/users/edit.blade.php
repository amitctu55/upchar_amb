@extends('admin.layout.base')

@section('title', 'Update Patient / User - ')

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
                <i class="fa-solid fa-user-pen" style="color: var(--cyan-bright);"></i>
                <span>Update Patient / User Profile: {{ $user->first_name }} {{ $user->last_name }}</span>
            </h4>
            <span class="section-sub">Modify personal contact details, mobile credentials and profile photo for Patient ID #{{ $user->id }}</span>
        </div>
        <div>
            <a href="{{ route('admin.user.show', $user->id) }}" class="btn-cancel-action" style="margin-right: 6px;">
                <i class="fa-solid fa-id-card"></i> View Dossier
            </a>
            <a href="{{ route('admin.user.index') }}" class="btn-cancel-action">
                <i class="fa-solid fa-arrow-left"></i> Back to Users List
            </a>
        </div>
    </div>

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data" role="form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH">

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="first_name">First Name <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('first_name', $user->first_name) }}" name="first_name" required id="first_name">
            </div>

            <div class="col-md-6 form-group">
                <label for="last_name">Last Name <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('last_name', $user->last_name) }}" name="last_name" required id="last_name">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="email">Account Email</label>
                <input class="form-control" type="email" disabled value="{{ $user->email }}" id="email">
                <small style="color: var(--text-dim); font-size: 11px;">Primary email is tied to auth token and cannot be edited directly.</small>
            </div>

            <div class="col-md-6 form-group">
                <label for="mobile">Mobile Number <span style="color: var(--crimson-alert);">*</span></label>
                <input type="hidden" name="country_code" id="country_code" value="{{ $user->country_code ?? '+91' }}">
                <input class="form-control" type="text" value="{{ old('mobile', $user->mobile) }}" name="mobile" required id="mobile">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 form-group">
                <label for="picture">Profile Photo</label>
                @if($user->picture)
                    <div style="margin-bottom: 12px; display: flex; align-items: center; gap: 12px;">
                        <img src="{{ img($user->picture) }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #00A8FF;">
                        <span style="font-size: 12px; color: var(--text-dim);">Current Avatar Photo</span>
                    </div>
                @endif
                <input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture">
            </div>
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-floppy-disk"></i> Save Profile Changes
            </button>
            <a href="{{ route('admin.user.index') }}" class="btn-cancel-action">
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
    var input = document.querySelector("#mobile");
    var iti = window.intlTelInput(input, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "{{ asset('asset/js/utils.js') }}"
    });

    $('form').on('submit', function() {
        var countryData = iti.getSelectedCountryData();
        $('#country_code').val('+' + countryData.dialCode);
    });
</script>
@endsection