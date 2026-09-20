@extends('admin.layout.base')

@section('title', 'Emergency Command Dashboard - ')

@section('styles')
	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
	<style>
		.med-stat-card {
			background: #ffffff;
			border-radius: 14px;
			padding: 22px;
			margin-bottom: 24px;
			border: 1px solid #e2e8f0;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
			display: flex;
			align-items: center;
			justify-content: space-between;
			transition: all 0.25s ease;
			position: relative;
			overflow: hidden;
		}

		.med-stat-card:hover {
			transform: translateY(-4px);
			box-shadow: 0 10px 25px rgba(8, 54, 75, 0.08);
			border-color: #cbd5e1;
		}

		.med-stat-card::before {
			content: '';
			position: absolute;
			left: 0;
			top: 0;
			bottom: 0;
			width: 4px;
		}

		.med-card-primary::before { background: #00A8FF; }
		.med-card-danger::before { background: #E63946; }
		.med-card-success::before { background: #9BC03C; }
		.med-card-warning::before { background: #f59e0b; }
		.med-card-purple::before { background: #8b5cf6; }

		.med-stat-icon {
			width: 52px;
			height: 52px;
			border-radius: 12px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 22px;
			flex-shrink: 0;
		}

		.icon-bg-primary { background: rgba(0, 168, 255, 0.12); color: #00A8FF; }
		.icon-bg-danger { background: rgba(230, 57, 70, 0.12); color: #E63946; }
		.icon-bg-success { background: rgba(155, 192, 60, 0.15); color: #739420; }
		.icon-bg-warning { background: rgba(245, 158, 11, 0.12); color: #d97706; }
		.icon-bg-purple { background: rgba(139, 92, 246, 0.12); color: #7c3aed; }

		.med-stat-info h6 {
			font-size: 12px;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			color: #64748b;
			margin: 0 0 4px 0;
		}

		.med-stat-info h2 {
			font-size: 26px;
			font-weight: 800;
			color: #08364B;
			margin: 0 0 4px 0;
			line-height: 1.1;
		}

		.med-stat-info .stat-sub {
			font-size: 11px;
			font-weight: 600;
			color: #94a3b8;
		}

		.dash-table-card {
			background: #ffffff;
			border-radius: 14px;
			border: 1px solid #e2e8f0;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
			overflow: hidden;
			margin-bottom: 24px;
		}

		.dash-table-header {
			padding: 18px 22px;
			background: #ffffff;
			border-bottom: 1px solid #f1f5f9;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.dash-table-header h5 {
			font-size: 16px;
			font-weight: 800;
			color: #08364B;
			margin: 0;
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.tag-custom {
			padding: 4px 10px;
			border-radius: 20px;
			font-size: 11px;
			font-weight: 700;
			letter-spacing: 0.3px;
		}

		.tag-completed { background: rgba(155, 192, 60, 0.15); color: #607d18; }
		.tag-cancelled { background: rgba(230, 57, 70, 0.12); color: #dc2626; }
		.tag-active { background: rgba(0, 168, 255, 0.12); color: #0284c7; }
	</style>
@endsection

@section('content')

<div class="content-area py-1">
<div class="container-fluid">

	<!-- Header Greeting & Live Status -->
	<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; margin-bottom: 20px; padding: 14px 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0;">
		<div>
			<h4 style="font-weight: 800; color: #08364B; margin: 0 0 2px 0;">Emergency Dispatch & Operations Command</h4>
			<span style="font-size: 12px; color: #64748b;"><i class="fa fa-circle" style="color: #9BC03C; font-size: 9px;"></i> Live GPS Telemetry Active &bull; Real-time Emergency Monitoring</span>
		</div>
		<div class="hidden-xs">
			<span style="font-size: 12px; font-weight: 700; color: #08364B; background: #f1f5f9; padding: 6px 14px; border-radius: 20px;">
				<i class="fa fa-calendar-check-o"></i> {{ date('l, d F Y') }}
			</span>
		</div>
	</div>

	<!-- Primary Stats Row -->
    <div class="row row-md">
    	@can('dashboard-menus')
		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="med-stat-card med-card-danger">
				<div class="med-stat-info">
					<h6>Total Emergency Trips</h6>
					<h2>{{$rides->count()}}</h2>
					<span class="stat-sub">
						<span style="color: #E63946; font-weight: 700;">@if($cancel_rides == 0) 0.00% @else {{round($cancel_rides/$rides->count()*100, 1)}}% @endif</span> cancelled
					</span>
				</div>
				<div class="med-stat-icon icon-bg-danger">
					<i class="fa fa-ambulance"></i>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="med-stat-card med-card-success">
				<div class="med-stat-info">
					<h6>Total Revenue</h6>
					<h2>{{currency($revenue)}}</h2>
					<span class="stat-sub text-success"><i class="fa fa-caret-up"></i> from {{$rides->count()}} dispatches</span>
				</div>
				<div class="med-stat-icon icon-bg-success">
					<i class="fa fa-money"></i>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="med-stat-card med-card-primary">
				<div class="med-stat-info">
					<h6>Active Services / Fleet</h6>
					<h2>{{$service}}</h2>
					<span class="stat-sub">Categories (BLS, ALS, ICU)</span>
				</div>
				<div class="med-stat-icon icon-bg-primary">
					<i class="fa fa-medkit"></i>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="med-stat-card med-card-purple">
				<div class="med-stat-info">
					<h6>Scheduled Transfers</h6>
					<h2>{{$scheduled_rides}}</h2>
					<span class="stat-sub">Advance patient bookings</span>
				</div>
				<div class="med-stat-icon icon-bg-purple">
					<i class="fa fa-calendar"></i>
				</div>
			</div>
		</div>
		@endcan
	</div>

	<!-- Secondary Stats Row -->
	<div class="row row-md">
		@can('dashboard-menus')
		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="med-stat-card med-card-warning">
				<div class="med-stat-info">
					<h6>User Cancellations</h6>
					<h2>{{$user_cancelled}}</h2>
					<span class="stat-sub">Cancelled before pickup</span>
				</div>
				<div class="med-stat-icon icon-bg-warning">
					<i class="fa fa-user-times"></i>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="med-stat-card med-card-danger">
				<div class="med-stat-info">
					<h6>Driver Cancellations</h6>
					<h2>{{$provider_cancelled}}</h2>
					<span class="stat-sub">Declined by provider</span>
				</div>
				<div class="med-stat-icon icon-bg-danger">
					<i class="fa fa-ban"></i>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="med-stat-card med-card-success">
				<div class="med-stat-info">
					<h6>Active EMTs & Drivers</h6>
					<h2>{{$provider}}</h2>
					<span class="stat-sub">Verified on platform</span>
				</div>
				<div class="med-stat-icon icon-bg-success">
					<i class="fa fa-user-md"></i>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="med-stat-card med-card-primary">
				<div class="med-stat-info">
					<h6>Fleet Operators</h6>
					<h2>{{$fleet}}</h2>
					<span class="stat-sub">Hospital & partner fleets</span>
				</div>
				<div class="med-stat-icon icon-bg-primary">
					<i class="fa fa-hospital-o"></i>
				</div>
			</div>
		</div>
		@endcan
	</div>

	<!-- Details Row: Financial Summary & Recent Dispatches -->
	<div class="row row-md mb-2">
		@can('wallet-summary')
		<div class="col-md-4">
			<div class="dash-table-card">
				<div class="dash-table-header">
					<h5><i class="fa fa-credit-card" style="color: #00A8FF;"></i> Financial & Wallet Overview</h5>
				</div>
				<table class="table mb-0" style="font-size: 13px;">
					<tbody>
						@php($total=$wallet['admin'])
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Admin Net Credit</th>
							<td class="text-right text-success" style="font-weight: 700;">{{currency($wallet['admin'])}}</td>
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Provider Total Credit</th>
							@if($wallet['provider_credit'])
								@php($total=$total-$wallet['provider_credit'][0]['total_credit'])
								<td class="text-right text-success" style="font-weight: 700;">{{currency($wallet['provider_credit'][0]['total_credit'])}}</td>
							@else
								<td class="text-right text-success" style="font-weight: 700;">{{currency()}}</td>	
							@endif	
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Provider Debit</th>
							@if($wallet['provider_debit'])
								<td class="text-right text-danger" style="font-weight: 700;">{{currency($wallet['provider_debit'][0]['total_debit'])}}</td>
							@else
								<td class="text-right text-danger" style="font-weight: 700;">{{currency()}}</td>	
							@endif
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Fleet Total Credit</th>
							@if($wallet['fleet_credit'])
								@php($total=$total-($wallet['fleet_credit'][0]['total_credit']))
								<td class="text-right text-success" style="font-weight: 700;">{{currency($wallet['fleet_credit'][0]['total_credit'])}}</td>
							@else
								<td class="text-right text-success" style="font-weight: 700;">{{currency()}}</td>		
							@endif	
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Fleet Debit</th>
							@if($wallet['fleet_debit'])								
								<td class="text-right text-danger" style="font-weight: 700;">{{currency($wallet['fleet_debit'][0]['total_debit'])}}</td>
							@else
								<td class="text-right text-danger" style="font-weight: 700;">{{currency()}}</td>		
							@endif	
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Platform Commission</th>
							<td class="text-right text-success" style="font-weight: 700;">{{currency($wallet['admin_commission'])}}</td>
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Emergency Peak Commission</th>
							<td class="text-right text-success" style="font-weight: 700;">{{currency($wallet['peak_commission'])}}</td>
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Waiting Charges</th>
							<td class="text-right text-success" style="font-weight: 700;">{{currency($wallet['waiting_commission'])}}</td>
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Discounts Applied</th>
							<td class="text-right text-danger" style="font-weight: 700;">{{currency($wallet['admin_discount'])}}</td>
						</tr>
						<tr>
							@php($total=$total-($wallet['admin_tax']))
							<th scope="row" style="font-weight: 600; color: #475569;">Tax Collected</th>
							<td class="text-right text-success" style="font-weight: 700;">{{currency($wallet['admin_tax'])}}</td>
						</tr>
						<tr>
							<th scope="row" style="font-weight: 600; color: #475569;">Tips / Gratuity</th>
							<td class="text-right text-danger" style="font-weight: 700;">{{currency($wallet['tips'])}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		@endcan

		@can('recent-rides')
		<div class="col-md-8">
			<div class="dash-table-card">
				<div class="dash-table-header">
					<h5><i class="fa fa-ambulance" style="color: #E63946;"></i> Live & Recent Emergency Dispatches</h5>
					<span style="font-size: 11px; font-weight: 700; color: #64748b;">Showing latest records</span>
				</div>
				<div class="table-responsive">
					<table class="table mb-0" style="font-size: 13px;">
						<thead style="background: #f8fafc;">
							<tr>
								<th style="color: #64748b; font-weight: 700;">#</th>
								<th style="color: #64748b; font-weight: 700;">Patient / Caller</th>
								<th style="color: #64748b; font-weight: 700;">Dispatch Details</th>
								<th style="color: #64748b; font-weight: 700;">Time Elapsed</th>
								<th style="color: #64748b; font-weight: 700; text-align: right;">Status</th>
							</tr>
						</thead>
						<tbody>
						@foreach($rides as $index => $ride)
							<tr>
								<th scope="row" style="color: #64748b;">{{$index + 1}}</th>
								<td>
									<strong style="color: #08364B;">{{$ride->user->first_name ?? 'Guest'}} {{$ride->user->last_name ?? 'Caller'}}</strong>
									@if(isset($ride->booking_id))
										<br><small style="color: #94a3b8;">{{$ride->booking_id}}</small>
									@endif
								</td>
								<td>
									@if($ride->status != "CANCELLED")
										<a class="text-primary font-weight-bold" href="{{route('admin.requests.show',$ride->id)}}">
											<i class="fa fa-eye"></i> View Telemetry & GPS
										</a>
									@else
										<span class="text-muted"><i class="fa fa-ban"></i> No Route Active</span>
									@endif									
								</td>
								<td>
									<span class="text-muted" style="font-size: 12px;"><i class="fa fa-clock-o"></i> {{$ride->created_at->diffForHumans()}}</span>
								</td>
								<td class="text-right">
									@if($ride->status == "COMPLETED")
										<span class="tag-custom tag-completed"><i class="fa fa-check-circle"></i> COMPLETED</span>
									@elseif($ride->status == "CANCELLED")
										<span class="tag-custom tag-cancelled"><i class="fa fa-times-circle"></i> CANCELLED</span>
									@else
										<span class="tag-custom tag-active"><i class="fa fa-spinner fa-spin"></i> {{$ride->status}}</span>
									@endif
								</td>
							</tr>
							<?php if($index==10) break; ?>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		@endcan
	</div>

</div>
</div>
@endsection

@section('scripts')    
<script type="text/javascript">
var _registration = null;
function registerServiceWorker() {
  return navigator.serviceWorker.register("{{ asset('js/service-worker.js') }}")
  .then(function(registration) {
    console.log('Service worker successfully registered.');
    _registration = registration;
    return registration;
  })
  .catch(function(err) {
    console.error('Unable to register service worker.', err);
  });
}

function askPermission() {
  return new Promise(function(resolve, reject) {
    const permissionResult = Notification.requestPermission(function(result) {
      resolve(result);
    });

    if (permissionResult) {
      permissionResult.then(resolve, reject);
    }
  })
  .then(function(permissionResult) {
    if (permissionResult !== 'granted') {
      throw new Error('We weren\'t granted permission.');
    }
    else{
      subscribeUserToPush();
    }
  });
}

function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

function getSWRegistration(){
  var promise = new Promise(function(resolve, reject) {
  if (_registration != null) {
    resolve(_registration);
  }
  else {
    reject(Error("It broke"));
  }
  });
  return promise;
}

function subscribeUserToPush() {
  getSWRegistration()
  .then(function(registration) {
    const subscribeOptions = {
      userVisibleOnly: true,
      applicationServerKey: urlBase64ToUint8Array(
        "{{env('VAPID_PUBLIC_KEY')}}"
      )
    };
    return registration.pushManager.subscribe(subscribeOptions);
  })
  .then(function(pushSubscription) {
    sendSubscriptionToBackEnd(pushSubscription);
    return pushSubscription;
  });
}

function sendSubscriptionToBackEnd(subscription) {
    $.ajax({
        url: "/save-subscription/{{Auth::user()->id}}/admin",
        headers: {'Content-Type': 'application/json'},
        type: 'post',
        data: JSON.stringify(subscription),
        success:function(data, textStatus, jqXHR) {
            console.log(data);
        }
    });
}

registerServiceWorker();
askPermission();
</script>
@endsection