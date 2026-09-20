@extends('admin.layout.base')

@section('title', 'Update Fleet Partner - ')

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
                <i class="fa-solid fa-pen-to-square" style="color: var(--cyan-bright);"></i>
                <span>Update Fleet Partner: {{ $fleet->company }}</span>
            </h4>
            <span class="section-sub">Modify partner business info, commission rates, and representative phone numbers.</span>
        </div>
        <a href="{{ route('admin.fleet.index') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Fleet List
        </a>
    </div>

    <form action="{{ route('admin.fleet.update', $fleet->id) }}" method="POST" enctype="multipart/form-data" role="form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH">

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="company">Company / Hospital Name <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ $fleet->company }}" name="company" required id="company" placeholder="Company Name">
            </div>

            <div class="col-md-6 form-group">
                <label for="name">Representative Contact Person <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ $fleet->name }}" name="name" required id="name" placeholder="Full Name">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="mobile">Official Contact Phone <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ $fleet->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
            </div>

            <div class="col-md-6 form-group">
                <label for="email">Partner Account Email</label>
                <input class="form-control" type="email" readonly disabled value="{{ $fleet->email }}" id="email" style="opacity: 0.7;">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="commission">Fleet Commission Rate (%)</label>
                <input class="form-control" type="number" step="0.1" value="{{ $fleet->commission }}" name="commission" id="commission" placeholder="Commission %">
            </div>

            <div class="col-md-6 form-group">
                <label for="logo">Company Logo / Brand Asset</label>
                @if(isset($fleet->logo) && $fleet->logo)
                    <div style="margin-bottom: 10px;">
                        <img style="height: 60px; border-radius: 8px; border: 1px solid var(--border-line);" src="{{ asset('storage/'.$fleet->logo) }}" onerror="this.src='{{ img($fleet->logo) }}'">
                    </div>
                @endif
                <input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo">
            </div>
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-floppy-disk"></i> Save Fleet Partner Changes
            </button>
            <a href="{{ route('admin.fleet.index') }}" class="btn-cancel-action">
                @lang('admin.cancel')
            </a>
        </div>
    </form>
</div>
@endsection
