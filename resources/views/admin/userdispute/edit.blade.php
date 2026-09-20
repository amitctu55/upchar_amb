@extends('admin.layout.base')

@section('title', 'Resolve Dispute & Grant Refund - ')

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
    .section-divider-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--text-main);
        margin: 24px 0 16px 0;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border-line);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit-action {
        background: linear-gradient(90deg, #10B981, #059669);
        color: #ffffff !important;
        font-weight: 700;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        transition: all 0.2s;
    }
    .btn-submit-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.6);
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
                <i class="fa-solid fa-gavel" style="color: var(--cyan-bright);"></i>
                <span>Resolve Dispute Ticket #{{ $dispute->id }}</span>
            </h4>
            <span class="section-sub">Investigate booking telemetry, add administrator remarks, and issue wallet refund credit.</span>
        </div>
        <a href="{{ route('admin.userdisputes') }}" class="btn-cancel-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Disputes
        </a>
    </div>

    <form action="{{ route('admin.userdisputeupdate', $dispute->id) }}" method="POST" role="form">
        {{ csrf_field() }}

        <div class="section-divider-title">
            <i class="fa-solid fa-circle-info" style="color: var(--cyan-bright);"></i>
            <span>Dispute & Participant Metadata</span>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label>Complainant Type</label>
                <input class="form-control" type="text" value="{{ ucfirst($dispute->dispute_type) }}" disabled>
            </div>

            <div class="col-md-6 form-group">
                <label>Complainant Account</label>
                <input class="form-control" type="text" value="{{ $dispute->user ? $dispute->user->first_name.' '.$dispute->user->last_name : ($dispute->provider ? $dispute->provider->first_name.' '.$dispute->provider->last_name : 'Account #'.$dispute->user_id) }}" disabled>
            </div>
        </div>

        <div class="form-group">
            <label>Associated Ambulance Trip Details</label>
            <div class="table-responsive" style="background: var(--stat-pill-bg); border-radius: 8px; border: 1px solid var(--border-line); padding: 10px;">
                <table class="table table-bordered" style="margin-bottom: 0;">
                    <thead>
                        <tr style="background: rgba(0, 168, 255, 0.08);">
                            <th style="color: var(--cyan-bright);">Booking ID</th>
                            <th style="color: var(--cyan-bright);">Pickup Point</th>
                            <th style="color: var(--cyan-bright);">Destination Hospital</th>
                            <th style="color: var(--cyan-bright);">Trip Fare</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#{{ $dispute->request ? $dispute->request->booking_id : '-' }}</strong></td>
                            <td style="font-size: 13px;">{{ $dispute->request ? $dispute->request->s_address : '-' }}</td>
                            <td style="font-size: 13px;">{{ $dispute->request ? $dispute->request->d_address : '-' }}</td>
                            <td><strong style="color: #10B981;">{{ $dispute->request && $dispute->request->payment ? currency($dispute->request->payment->total) : '-' }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <label>Lodge Complaint Subject</label>
            <textarea class="form-control" rows="2" disabled>{{ $dispute->dispute_name }}</textarea>
        </div>

        <div class="section-divider-title">
            <i class="fa-solid fa-scale-balanced" style="color: var(--cyan-bright);"></i>
            <span>Resolution & Refund Grant</span>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="refund_amount">Refund Credit Amount ({{ currency() }})</label>
                <input class="form-control price" type="number" step="0.01" value="{{ old('refund_amount', $dispute->refund_amount ?? 0) }}" name="refund_amount" id="refund_amount" placeholder="0.00" min="0">
                <small style="color: var(--text-dim); font-size: 11px;">Amount will be credited back into the patient's in-app wallet balance.</small>
            </div>

            <div class="col-md-6 form-group">
                <label for="status">Ticket Status on Save</label>
                <input class="form-control" type="text" readonly value="closed" name="status" style="color: #10B981; font-weight: 700;">
                <small style="color: var(--text-dim); font-size: 11px;">Ticket will be marked as settled upon submitting resolution.</small>
            </div>
        </div>

        <div class="form-group">
            <label for="comments">Administrator Findings & Resolution Remarks <span style="color: var(--crimson-alert);">*</span></label>
            <textarea class="form-control" name="comments" id="comments" rows="3" required placeholder="Explain why the refund was granted or how the conflict was addressed with the paramedic/patient...">{{ old('comments', $dispute->comments) }}</textarea>
        </div>

        <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-line);">
            <input type="hidden" name="is_admin" value="1" />
            <button type="submit" class="btn-submit-action">
                <i class="fa-solid fa-circle-check"></i> Grant Settlement & Close Ticket
            </button>
            <a href="{{ route('admin.userdisputes') }}" class="btn-cancel-action">
                @lang('admin.cancel')
            </a>
        </div>
    </form>
</div>
@endsection