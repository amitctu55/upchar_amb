@extends('provider.layout.auth')

@section('title', 'Partner Registration - ')

@section('content')
<div class="auth-card-header">
    <h3>
        <i class="fa-solid fa-ambulance" style="color: var(--crimson);"></i>
        <span>Register Ambulance</span>
    </h3>
    <a href="{{ url('/provider/login') }}">
        <i class="fa fa-sign-in"></i> Already Registered? Sign In
    </a>
</div>

@if (count($errors) > 0)
    <div style="background: rgba(230, 57, 70, 0.15); border: 1px solid var(--crimson); border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;">
        <strong style="color: #ff7675; font-size: 13px; display: block; margin-bottom: 4px;">Please correct the errors below:</strong>
        <ul style="margin: 0; padding-left: 18px; color: #fecaca; font-size: 12px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form role="form" method="POST" action="{{ url('/provider/register') }}">
    {{ csrf_field() }}

    <!-- Section 1: Personal Details -->
    <div class="form-section-title">
        <i class="fa-solid fa-user"></i>
        <span>Driver / Owner Profile</span>
    </div>

    <div class="row" style="margin: 0 -6px 12px -6px;">
        <div class="col-xs-6" style="padding: 0 6px;">
            <input id="fname" type="text" class="form-control-custom" name="first_name" value="{{ old('first_name') }}" placeholder="First Name *" required autofocus>
            @if ($errors->has('first_name'))
                <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
            @endif
        </div>
        <div class="col-xs-6" style="padding: 0 6px;">
            <input id="lname" type="text" class="form-control-custom" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name *" required>
            @if ($errors->has('last_name'))
                <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
            @endif
        </div>
    </div>

    <div style="margin-bottom: 12px;">
        <input id="email" type="email" class="form-control-custom" name="email" value="{{ old('email') }}" placeholder="Email Address *" required>
        @if ($errors->has('email'))
            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>

    <!-- Phone Number with Country Code -->
    <div class="row" style="margin: 0 -6px 12px -6px;">
        <div class="col-xs-4" style="padding: 0 6px;">
            <input value="{{ old('country_code', '+91') }}" type="text" class="form-control-custom" id="country_code" name="country_code" readonly style="text-align: center; font-weight: 700;">
        </div>
        <div class="col-xs-8" style="padding: 0 6px;">
            <input type="tel" id="phone_number" class="form-control-custom" placeholder="10-Digit Mobile Number *" name="phone_number" value="{{ old('phone_number') }}" maxlength="10" required>
            @if ($errors->has('phone_number'))
                <span class="help-block"><strong>{{ $errors->first('phone_number') }}</strong></span>
            @endif
        </div>
    </div>

    <!-- Gender Selector -->
    <div style="margin-bottom: 14px;">
        <span style="font-size: 11px; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Gender</span>
        <div class="gender-options-wrap">
            <label class="gender-radio-label">
                <input type="radio" name="gender" value="MALE" checked>
                <span>Male</span>
            </label>
            <label class="gender-radio-label">
                <input type="radio" name="gender" value="FEMALE" {{ old('gender') == 'FEMALE' ? 'checked' : '' }}>
                <span>Female</span>
            </label>
        </div>
    </div>

    <!-- Section 2: Account Security -->
    <div class="form-section-title">
        <i class="fa-solid fa-lock"></i>
        <span>Account Security</span>
    </div>

    <div class="row" style="margin: 0 -6px 12px -6px;">
        <div class="col-xs-6" style="padding: 0 6px;">
            <input id="password" type="password" class="form-control-custom" name="password" placeholder="Password (Min 6) *" required minlength="6">
            @if ($errors->has('password'))
                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </div>
        <div class="col-xs-6" style="padding: 0 6px;">
            <input id="password-confirm" type="password" class="form-control-custom" name="password_confirmation" placeholder="Confirm Password *" required minlength="6">
            @if ($errors->has('password_confirmation'))
                <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
            @endif
        </div>
    </div>

    <!-- Section 3: Ambulance Details -->
    <div class="form-section-title">
        <i class="fa-solid fa-truck-medical"></i>
        <span>Ambulance Vehicle Details</span>
    </div>

    <div style="margin-bottom: 12px;">
        <select class="form-control-custom" name="service_type" id="service_type" required>
            <option value="">Select Ambulance Category *</option>
            @foreach(get_all_service_types() as $type)
                <option value="{{ $type->id }}" {{ old('service_type') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }} (Capacity: {{ $type->capacity }})
                </option>
            @endforeach
        </select>
        @if ($errors->has('service_type'))
            <span class="help-block"><strong>{{ $errors->first('service_type') }}</strong></span>
        @endif
    </div>

    <div class="row" style="margin: 0 -6px 12px -6px;">
        <div class="col-xs-6" style="padding: 0 6px;">
            <input id="service-number" type="text" class="form-control-custom" name="service_number" value="{{ old('service_number') }}" placeholder="Vehicle Reg. No (e.g. UP 65 AB 1234) *" required>
            @if ($errors->has('service_number'))
                <span class="help-block"><strong>{{ $errors->first('service_number') }}</strong></span>
            @endif
        </div>
        <div class="col-xs-6" style="padding: 0 6px;">
            <input id="service-model" type="text" class="form-control-custom" name="service_model" value="{{ old('service_model') }}" placeholder="Ambulance Model (e.g. Force Winger) *" required>
            @if ($errors->has('service_model'))
                <span class="help-block"><strong>{{ $errors->first('service_model') }}</strong></span>
            @endif
        </div>
    </div>

    @if (config('constants.paypal_adaptive') == 1)
        <div style="margin-bottom: 12px;">
            <input id="paypal_email" type="email" class="form-control-custom" name="paypal_email" value="{{ old('paypal_email') }}" placeholder="PayPal Payout Email">
            @if ($errors->has('paypal_email'))
                <span class="help-block"><strong>{{ $errors->first('paypal_email') }}</strong></span>
            @endif
        </div>
    @else
        <input type="hidden" name="paypal_email" value="">
    @endif

    @if(config('constants.referral') == 1)
        <div style="margin-bottom: 12px;">
            <input type="text" placeholder="Referral Code (Optional)" class="form-control-custom" name="referral_code" value="{{ old('referral_code') }}">
            @if ($errors->has('referral_code'))
                <span class="help-block"><strong>{{ $errors->first('referral_code') }}</strong></span>
            @endif
        </div>
    @else
        <input type="hidden" name="referral_code" value="">
    @endif

    <button type="submit" class="btn-auth-submit">
        <i class="fa-solid fa-user-plus"></i>
        <span>SUBMIT & REGISTER AS PARTNER</span>
    </button>

    <div class="auth-footer-help">
        Need assistance with driver onboarding? <br>
        Call Partner Helpline: <a href="tel:{{ config('constants.contact_number', '8448440603') }}"><i class="fa fa-phone"></i> {{ config('constants.contact_number', '844-844-0603') }}</a>
    </div>
</form>
@endsection