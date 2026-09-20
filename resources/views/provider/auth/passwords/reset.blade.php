@extends('provider.layout.auth')

@section('title', 'Set New Password - ')

@section('content')
<div class="auth-card-header">
    <h3>
        <i class="fa-solid fa-lock-open" style="color: var(--cyan);"></i>
        <span>Create New Password</span>
    </h3>
    <a href="{{ url('/provider/login') }}">
        <i class="fa fa-sign-in"></i> Sign In
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

<form role="form" method="POST" action="{{ url('/provider/password/reset') }}">
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">

    <div style="margin-bottom: 14px;">
        <label style="font-size: 11px; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Email Address</label>
        <input id="email" type="email" class="form-control-custom" name="email" value="{{ old('email') }}" placeholder="Enter email address" required autofocus>
        @if ($errors->has('email'))
            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>

    <div style="margin-bottom: 14px;">
        <label style="font-size: 11px; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">New Password</label>
        <input id="password" type="password" class="form-control-custom" name="password" placeholder="Enter new password (Min 6)" required minlength="6">
        @if ($errors->has('password'))
            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
        @endif
    </div>

    <div style="margin-bottom: 16px;">
        <label style="font-size: 11px; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Confirm New Password</label>
        <input id="password-confirm" type="password" class="form-control-custom" name="password_confirmation" placeholder="Re-type new password" required minlength="6">
        @if ($errors->has('password_confirmation'))
            <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
        @endif
    </div>

    <button type="submit" class="btn-auth-submit">
        <i class="fa-solid fa-check"></i>
        <span>UPDATE PASSWORD</span>
    </button>

    <div class="auth-footer-help">
        <a href="{{ url('/provider/login') }}"><i class="fa fa-arrow-left"></i> Return to Partner Login</a>
    </div>
</form>
@endsection
