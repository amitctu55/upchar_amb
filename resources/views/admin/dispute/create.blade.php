@extends('admin.layout.base')

@section('title', 'Add Dispute Reason - ')

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
                <i class="fa-solid fa-scale-balanced" style="color: var(--cyan-bright);"></i>
                <span>Add Dispute Complaint Reason</span>
            </h4>
            <span class="section-sub">Create standardized options for users and ambulance crew when flagging trip disputes.</span>
        </div>
        <a href="{{ route('admin.dispute.index') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Reasons
        </a>
    </div>

    <form action="{{ route('admin.dispute.store') }}" method="POST" role="form">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="dispute_type">Target Audience / Role <span style="color: var(--crimson-alert);">*</span></label>
                <select name="dispute_type" class="form-control" required>
                    <option value="">-- Select Audience --</option>
                    <option value="user">Patient / App User</option>
                    <option value="provider">Paramedic / Ambulance Driver</option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label for="dispute_status">Category Status <span style="color: var(--crimson-alert);">*</span></label>
                <select name="dispute_status" class="form-control" required>
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 form-group">
                <label for="dispute_name">Dispute Reason Title <span style="color: var(--crimson-alert);">*</span></label>
                <input class="form-control" type="text" value="{{ old('dispute_name') }}" name="dispute_name" required id="dispute_name" placeholder="e.g. Driver requested extra cash payment / Fare calculation issue">
            </div>
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-check"></i> Save Dispute Reason
            </button>
            <a href="{{ route('admin.dispute.index') }}" class="btn-cancel-action">
                @lang('admin.cancel')
            </a>
        </div>
    </form>
</div>
@endsection
