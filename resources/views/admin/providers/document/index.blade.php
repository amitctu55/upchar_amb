@extends('admin.layout.base')

@section('title', 'Provider Documents & Allocation - ')

@section('styles')
<style>
    .doc-glass-card {
        background: var(--card-glass);
        border: 1px solid var(--border-line);
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(14px);
        margin-bottom: 24px;
    }
    .doc-glass-card h5 {
        font-size: 16px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-action-cyan {
        background: linear-gradient(90deg, #00A8FF, #0284c7);
        color: #ffffff !important;
        font-size: 12px;
        font-weight: 700;
        padding: 8px 18px;
        border-radius: 8px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.4);
        transition: all 0.2s;
    }
    .btn-action-cyan:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 168, 255, 0.6);
        color: #fff;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h4 style="font-size: 20px; font-weight: 800; color: #ffffff; margin: 0;">
            <i class="fa-solid fa-id-card-clip" style="color: var(--cyan-bright);"></i>
            <span>KYC Verification & Vehicle Allocation: {{ $Provider->first_name }} {{ $Provider->last_name }}</span>
        </h4>
        <span style="font-size: 12px; color: var(--text-dim);">Verify uploaded licenses, medical certificates, and assign emergency ambulance vehicles.</span>
    </div>
    <a href="{{ $backurl }}" class="btn btn-sm btn-outline-light" style="border-radius: 8px; font-weight: 600;">
        <i class="fa-solid fa-arrow-left"></i> Back to Drivers List
    </a>
</div>

@if(Setting::get('demo_mode', 0) == 1)
    <div style="background: rgba(230, 57, 70, 0.15); border: 1px dashed var(--crimson-alert); border-radius: 8px; padding: 10px 14px; margin-bottom: 20px; font-size: 12px; color: #ff7675;">
        <i class="fa-solid fa-triangle-exclamation"></i> <strong>Demo Mode:</strong> Modifications to documents and vehicle allocation are disabled.
    </div>
@endif

@can('provider-services')
<div class="doc-glass-card">
    <h5>
        <i class="fa-solid fa-truck-medical" style="color: var(--cyan-bright);"></i>
        <span>Vehicle & Ambulance Category Allocation</span>
    </h5>
    <p style="font-size: 12px; color: var(--text-dim); margin-bottom: 20px;">Assign vehicle model, registration number, and service tier to this driver.</p>

    @if($ProviderService->count() > 0)
    <div style="margin-bottom: 24px;">
        <h6 style="color: var(--cyan-bright); font-size: 13px; font-weight: 700; margin-bottom: 12px;">Active Allocated Vehicles:</h6>
        <table class="table table-bordered" style="font-size: 13px;">
            <thead>
                <tr>
                    <th>Service Category</th>
                    <th>Vehicle Reg. Number</th>
                    <th>Ambulance Model</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ProviderService as $service)
                <tr>
                    <td><strong style="color: #ffffff;">{{ $service->service_type->name }}</strong></td>
                    <td><span style="background: rgba(0, 168, 255, 0.15); color: var(--cyan-bright); padding: 3px 8px; border-radius: 4px; font-weight: 700;">{{ $service->service_number }}</span></td>
                    <td>{{ $service->service_model }}</td>
                    <td style="text-align: right;">
                        @if(Setting::get('demo_mode', 0) == 0)
                            <form action="{{ route('admin.provider.document.service', [$Provider->id, $service->id]) }}" method="POST" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                @can('provider-service-delete')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this vehicle allocation?')" style="border-radius: 6px; font-size: 11px;">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                                @endcan
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <form action="{{ route('admin.provider.document.store', $Provider->id) }}" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-4 form-group">
                <label style="color: var(--cyan-bright); font-size: 11px; font-weight: 700; text-transform: uppercase;">Service Type</label>
                <select class="form-control" name="service_type" required>
                    @forelse($ServiceTypes as $Type)
                        <option value="{{ $Type->id }}">{{ $Type->name }}</option>
                    @empty
                        <option>- Select Service -</option>
                    @endforelse
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label style="color: var(--cyan-bright); font-size: 11px; font-weight: 700; text-transform: uppercase;">Vehicle Reg Number</label>
                <input type="text" required name="service_number" class="form-control" placeholder="UP 32 AM 1080">
            </div>
            <div class="col-md-3 form-group">
                <label style="color: var(--cyan-bright); font-size: 11px; font-weight: 700; text-transform: uppercase;">Model / Specifications</label>
                <input type="text" required name="service_model" class="form-control" placeholder="Force Traveller - ICU">
            </div>
            @if(Setting::get('demo_mode', 0) == 0)
            <div class="col-md-2 form-group" style="display: flex; align-items: flex-end;">
                @can('provider-service-update')
                <button class="btn btn-action-cyan w-100" type="submit" style="height: 38px;">
                    <i class="fa-solid fa-plus"></i> Allocate
                </button>
                @endcan
            </div>
            @endif
        </div>
    </form>
</div>
@endcan

@can('provider-documents')
<div class="doc-glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div>
            <h5>
                <i class="fa-solid fa-file-medical" style="color: var(--green-status);"></i>
                <span>Compliance & Verification Documents</span>
            </h5>
            <span style="font-size: 12px; color: var(--text-dim);">Review driver's license, EMT paramedic certificate, vehicle insurance, and pollution clearance.</span>
        </div>
        @if(Setting::get('demo_mode', 0) == 0 && count($Provider->documents) > 0)
            <a href="{{ route('admin.download', $Provider->id) }}" class="btn btn-sm btn-outline-info" style="border-radius: 6px; font-size: 12px; font-weight: 700;">
                <i class="fa-solid fa-file-arrow-down"></i> Download ZIP
            </a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="table-2" style="font-size: 13px;">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Document Type</th>
                    <th style="text-align: center;">Verification Status</th>
                    <th style="text-align: right; width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Provider->documents as $Index => $Document)
                <tr>
                    <td style="color: var(--cyan-bright); font-weight: 700;">{{ $Index + 1 }}</td>
                    <td><strong style="color: #ffffff;">@if($Document->document){{ $Document->document->name }}@endif</strong></td>
                    <td style="text-align: center;">
                        @if($Document->status == 'ACTIVE')
                            <span class="badge" style="background: rgba(155, 192, 60, 0.2); color: var(--green-status); border: 1px solid var(--green-status); padding: 5px 10px; border-radius: 20px; font-size: 11px;">ACTIVE</span>
                        @elseif($Document->status == 'ASSESSING')
                            <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid #f59e0b; padding: 5px 10px; border-radius: 20px; font-size: 11px;">ASSESSING</span>
                        @else
                            <span class="badge" style="background: rgba(230, 57, 70, 0.2); color: #ff7675; border: 1px solid var(--crimson-alert); padding: 5px 10px; border-radius: 20px; font-size: 11px;">{{ $Document->status }}</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if(Setting::get('demo_mode', 0) == 0)
                            @can('provider-document-edit')
                            <a href="{{ route('admin.provider.document.edit', [$Provider->id, $Document->id]) }}" class="btn btn-sm btn-outline-info" style="border-radius: 6px; font-size: 11px; padding: 4px 10px;">
                                <i class="fa-solid fa-eye"></i> View
                            </a>
                            @endcan

                            @can('provider-document-delete')
                            <form action="{{ route('admin.provider.document.destroy', [$Provider->id, $Document->id]) }}" method="POST" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" onclick="return confirm('Delete this KYC document?')" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; font-size: 11px; padding: 4px 10px;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endcan
@endsection