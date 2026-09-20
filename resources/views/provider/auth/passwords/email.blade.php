@extends('provider.layout.auth')

@section('title', 'Reset Password - ')

@section('content')
<div class="auth-card-header">
    <h3>
        <i class="fa-solid fa-key" style="color: var(--cyan);"></i>
        <span>Reset Password</span>
    </h3>
    <a href="{{ url('/provider/login') }}">
        <i class="fa fa-sign-in"></i> Back to Sign In
    </a>
</div>

@if (session('status'))
    <div style="background: rgba(155, 192, 60, 0.15); border: 1px solid var(--green); border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; color: #bef264; font-size: 13px;">
        <i class="fa fa-check-circle"></i> {{ session('status') }}
    </div>
@endif

@if (count($errors) > 0)
    <div style="background: rgba(230, 57, 70, 0.15); border: 1px solid var(--crimson); border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 18px; color: #fecaca; font-size: 12px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form role="form" method="POST" action="{{ url('/provider/password/email') }}">
    {{ csrf_field() }}

    <p style="font-size: 13px; color: var(--slate-300); margin-bottom: 16px; line-height: 1.5;">
        Enter your registered email address and we will send you a secure password reset link.
    </p>

    <div style="margin-bottom: 16px;">
        <label style="font-size: 11px; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Email Address</label>
        <input id="email" type="email" class="form-control-custom" name="email" value="{{ old('email') }}" placeholder="Enter registered partner email" required autofocus>
        @if ($errors->has('email'))
            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>

    <button type="submit" class="btn-auth-submit">
        <i class="fa-solid fa-paper-plane"></i>
        <span>SEND RESET LINK</span>
    </button>

    <div class="auth-footer-help">
        Remembered your password? <br>
        <a href="{{ url('/provider/login') }}"><i class="fa fa-arrow-left"></i> Sign in to Driver Account</a>
    </div>
</form>
@endsection
