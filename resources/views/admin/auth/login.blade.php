@extends('admin.layout.auth')

@section('content')
<!-- Portal Selector Navigation Tabs -->
<ul class="nav-portal-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link @if (!$errors->has('login_type') || $errors->first('login_type') == 'admin') active @endif" href="#tab-admin" data-toggle="tab" role="tab">
            <i class="fa fa-shield-halved"></i> Admin
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if ($errors->has('login_type') && $errors->first('login_type') == 'dispatcher') active @endif" href="#tab-dispatcher" data-toggle="tab" role="tab">
            <i class="fa fa-headset"></i> Dispatcher
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if ($errors->has('login_type') && $errors->first('login_type') == 'fleet') active @endif" href="#tab-fleet" data-toggle="tab" role="tab">
            <i class="fa fa-truck-medical"></i> Fleet
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if ($errors->has('login_type') && $errors->first('login_type') == 'account') active @endif" href="#tab-account" data-toggle="tab" role="tab">
            <i class="fa fa-file-invoice-dollar"></i> Accounts
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if ($errors->has('login_type') && $errors->first('login_type') == 'dispute') active @endif" href="#tab-dispute" data-toggle="tab" role="tab">
            <i class="fa fa-scale-balanced"></i> Dispute
        </a>
    </li>
</ul>

<div class="tab-content">
    
    <!-- 1. Super Admin Tab -->
    <div class="tab-pane fade @if (!$errors->has('login_type') || $errors->first('login_type') == 'admin') active in show @endif" id="tab-admin" role="tabpanel">
        <form role="form" method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}
            <input type="hidden" name="login_type" value="admin">

            <div class="form-group-custom">
                <label>Super Admin Email <span style="color: var(--crimson);">*</span></label>
                <input type="email" name="email" class="form-control-custom" placeholder="admin@upchar.info" required autofocus @if(Setting::get('demo_mode', 0)==1) value="admin@demo.com" @endif>
                @if ($errors->has('email') && $errors->first('login_type') == 'admin')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group-custom">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label style="margin: 0;">Password <span style="color: var(--crimson);">*</span></label>
                    <a href="{{ url('/admin/password/reset') }}" style="font-size: 11px; color: var(--cyan); text-decoration: none;">Forgot Password?</a>
                </div>
                <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required @if(Setting::get('demo_mode', 0)==1) value="123456" @endif>
                @if ($errors->has('password') && $errors->first('login_type') == 'admin')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-portal-submit">
                <i class="fa-solid fa-lock"></i> SIGN IN AS SUPER ADMIN
            </button>
        </form>

        @if(Setting::get('demo_mode', 0)==1)
            <div class="demo-credentials-box">
                <strong>Demo Credentials:</strong> <code>admin@demo.com</code> / <code>123456</code>
            </div>
        @endif
    </div>

    <!-- 2. Dispatcher Tab -->
    <div class="tab-pane fade @if ($errors->has('login_type') && $errors->first('login_type') == 'dispatcher') active in show @endif" id="tab-dispatcher" role="tabpanel">
        <form role="form" method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}
            <input type="hidden" name="login_type" value="dispatcher">

            <div class="form-group-custom">
                <label>Dispatcher Email <span style="color: var(--crimson);">*</span></label>
                <input type="email" name="email" class="form-control-custom" placeholder="dispatcher@upchar.info" required @if(Setting::get('demo_mode', 0)==1) value="dispatcher@demo.com" @endif>
                @if ($errors->has('email') && $errors->first('login_type') == 'dispatcher')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group-custom">
                <label>Password <span style="color: var(--crimson);">*</span></label>
                <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required @if(Setting::get('demo_mode', 0)==1) value="123456" @endif>
                @if ($errors->has('password') && $errors->first('login_type') == 'dispatcher')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-portal-submit">
                <i class="fa-solid fa-headset"></i> SIGN IN AS DISPATCHER
            </button>
        </form>

        @if(Setting::get('demo_mode', 0)==1)
            <div class="demo-credentials-box">
                <strong>Demo Credentials:</strong> <code>dispatcher@demo.com</code> / <code>123456</code>
            </div>
        @endif
    </div>

    <!-- 3. Fleet Tab -->
    <div class="tab-pane fade @if ($errors->has('login_type') && $errors->first('login_type') == 'fleet') active in show @endif" id="tab-fleet" role="tabpanel">
        <form role="form" method="POST" action="{{ url('/fleet/login') }}">
            {{ csrf_field() }}
            <input type="hidden" name="login_type" value="fleet">

            <div class="form-group-custom">
                <label>Fleet Operator Email <span style="color: var(--crimson);">*</span></label>
                <input type="email" name="email" class="form-control-custom" placeholder="fleet@upchar.info" required @if(Setting::get('demo_mode', 0)==1) value="fleet@demo.com" @endif>
                @if ($errors->has('email') && $errors->first('login_type') == 'fleet')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group-custom">
                <label>Password <span style="color: var(--crimson);">*</span></label>
                <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required @if(Setting::get('demo_mode', 0)==1) value="123456" @endif>
                @if ($errors->has('password') && $errors->first('login_type') == 'fleet')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-portal-submit">
                <i class="fa-solid fa-truck-medical"></i> SIGN IN AS FLEET OPERATOR
            </button>
        </form>

        @if(Setting::get('demo_mode', 0)==1)
            <div class="demo-credentials-box">
                <strong>Demo Credentials:</strong> <code>fleet@demo.com</code> / <code>123456</code>
            </div>
        @endif
    </div>

    <!-- 4. Accounts Tab -->
    <div class="tab-pane fade @if ($errors->has('login_type') && $errors->first('login_type') == 'account') active in show @endif" id="tab-account" role="tabpanel">
        <form role="form" method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}
            <input type="hidden" name="login_type" value="account">

            <div class="form-group-custom">
                <label>Accountant Email <span style="color: var(--crimson);">*</span></label>
                <input type="email" name="email" class="form-control-custom" placeholder="account@upchar.info" required @if(Setting::get('demo_mode', 0)==1) value="account@demo.com" @endif>
                @if ($errors->has('email') && $errors->first('login_type') == 'account')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group-custom">
                <label>Password <span style="color: var(--crimson);">*</span></label>
                <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required @if(Setting::get('demo_mode', 0)==1) value="123456" @endif>
                @if ($errors->has('password') && $errors->first('login_type') == 'account')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-portal-submit">
                <i class="fa-solid fa-file-invoice-dollar"></i> SIGN IN AS ACCOUNT MANAGER
            </button>
        </form>

        @if(Setting::get('demo_mode', 0)==1)
            <div class="demo-credentials-box">
                <strong>Demo Credentials:</strong> <code>account@demo.com</code> / <code>123456</code>
            </div>
        @endif
    </div>

    <!-- 5. Dispute Tab -->
    <div class="tab-pane fade @if ($errors->has('login_type') && $errors->first('login_type') == 'dispute') active in show @endif" id="tab-dispute" role="tabpanel">
        <form role="form" method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}
            <input type="hidden" name="login_type" value="dispute">

            <div class="form-group-custom">
                <label>Dispute Manager Email <span style="color: var(--crimson);">*</span></label>
                <input type="email" name="email" class="form-control-custom" placeholder="dispute@upchar.info" required @if(Setting::get('demo_mode', 0)==1) value="dispute@demo.com" @endif>
                @if ($errors->has('email') && $errors->first('login_type') == 'dispute')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group-custom">
                <label>Password <span style="color: var(--crimson);">*</span></label>
                <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required @if(Setting::get('demo_mode', 0)==1) value="123456" @endif>
                @if ($errors->has('password') && $errors->first('login_type') == 'dispute')
                    <span style="color: #f87171; font-size: 11px; margin-top: 4px; display: block;">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-portal-submit">
                <i class="fa-solid fa-scale-balanced"></i> SIGN IN AS DISPUTE OFFICER
            </button>
        </form>

        @if(Setting::get('demo_mode', 0)==1)
            <div class="demo-credentials-box">
                <strong>Demo Credentials:</strong> <code>dispute@demo.com</code> / <code>123456</code>
            </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Tab switching support
    $(document).ready(function(){
        $('.nav-portal-tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            $('.nav-portal-tabs a').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
@endsection
