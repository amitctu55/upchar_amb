@extends('provider.layout.auth')

@section('title', 'Partner Login - ')

@section('content')
<div class="auth-card-header">
    <h3>
        <i class="fa-solid fa-right-to-bracket" style="color: var(--cyan);"></i>
        <span>Partner Sign In</span>
    </h3>
    <a href="{{ url('/provider/register') }}">
        <i class="fa fa-user-plus"></i> New Partner? Register
    </a>
</div>

@if (count($errors) > 0)
    <div style="background: rgba(230, 57, 70, 0.15); border: 1px solid var(--crimson); border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 18px; color: #fecaca; font-size: 12px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form role="form" method="POST" action="{{ url('/provider/login') }}">
    {{ csrf_field() }}

    <div style="margin-bottom: 14px;">
        <label style="font-size: 11px; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Email Address</label>
        <input id="email" type="email" class="form-control-custom" name="email" value="{{ old('email') }}" placeholder="Enter registered email address" required autofocus>
        @if ($errors->has('email'))
            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>

    <div style="margin-bottom: 14px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <label style="font-size: 11px; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">Password</label>
            <a href="{{ url('/provider/password/reset') }}" style="font-size: 11px; color: var(--cyan); text-decoration: none;">Forgot Password?</a>
        </div>
        <input id="password" type="password" class="form-control-custom" name="password" placeholder="Enter your password" required>
        @if ($errors->has('password'))
            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
        @endif
    </div>

    <div style="display: flex; align-items: center; gap: 8px; margin: 16px 0;">
        <input type="checkbox" id="remember" name="remember" style="accent-color: var(--cyan); width: 16px; height: 16px;">
        <label for="remember" style="font-size: 13px; color: var(--slate-300); margin: 0; font-weight: 500; cursor: pointer;">Remember this device</label>
    </div>

    <button type="submit" class="btn-auth-submit">
        <i class="fa-solid fa-sign-in"></i>
        <span>SIGN IN TO DRIVER DASHBOARD</span>
    </button>

    @if(config('constants.social_login', 0) == 1)
        <div style="display: flex; gap: 10px; margin-top: 18px;">
            <a href="{{ url('provider/auth/facebook') }}" style="flex: 1; background: #1877f2; color: #fff; text-align: center; padding: 10px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none;">
                <i class="fa fa-facebook"></i> Facebook
            </a>
            <a href="{{ url('provider/auth/google') }}" style="flex: 1; background: #ea4335; color: #fff; text-align: center; padding: 10px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none;">
                <i class="fa fa-google"></i> Google
            </a>
        </div>
    @endif

    <div class="auth-footer-help">
        Need assistance with driver login? <br>
        Call Partner Helpline: <a href="tel:{{ config('constants.contact_number', '8448440603') }}"><i class="fa fa-phone"></i> {{ config('constants.contact_number', '844-844-0603') }}</a>
    </div>
</form>
@endsection
