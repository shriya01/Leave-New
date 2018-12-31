@extends ('layouts.master')
@section('styles')
<style type="text/css">
.dataTables_length select {
	display: none;
}
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			@if ($errors->any())
			@foreach ($errors->all() as $error)
			<p class="error alert alert-block alert-danger fade in">
				{{ $error }}
			</p>
			@endforeach
			@endif
			@if ($message = Session::get('success'))
			<div class="alert alert-success">
				<p>{{ Session::get('success') }}</p>
			</div>
			@endif
<table class="table table-striped table-advance table-hover" id="data-table">
				<thead>
					<tr>
						<th><i class="icon_profile"></i>{{ __('messages.full_name') }}</th>
						<th>{{ __('messages.leave_type') }}</th>

						<th><i class="icon_mail_alt"></i>{{ __('messages.email') }}</th>
						<th><i class="icon_calendar"></i>{{ __('messages.joining') }}</th>
						<th><i class="icon_pin_alt"></i>{{ __('messages.leave_duration') }}</th>
						<th><i class="icon_pin_alt"></i>{{ __('messages.leave_slot') }}</th>

						<th><i class="icon_pin_alt"></i>{{ __('messages.status') }}</th>

					</tr>
				</thead>
				<tbody>
					@foreach($leaves as $key)

					<tr>

						<td>{{ ucfirst($key->user_first_name) }} {{ ucfirst($key->user_last_name)}}</td>
						<td>{{ $key->leave_type_name }}</td>
						<td>{{ $key->leave_from_date}}</td>
						<td>{{ $key->leave_to_date}}</td>
						<!-- Leave Duration Half Or Full -->
						@switch($key->leave_duration_day)
						@case(1)
						<td>Half Day</td>
						@break
						@case(2)
						<td>Full Day</td>
						@break
						@default
						<td>NA</td>
						@endswitch
						<!-- Leave Slot Pre Or Post -->
						@switch($key->leave_slot_day)
						@case(1)
						<td>Pre Lunch</td>
						@break
						@case(2)
						<td>Post Lunch</td>
						@break
						@default
						<td>NA</td>
						@endswitch
						<!-- Status -->
						@switch($key->status)
						@case(1)
						<td>Approved</td>
						@break
						@case(2)
						<td>Pending</td>
						@break
						@case(3)
						<td>Rejected</td>
						@break
						@default
						<td>NA</td>
						@endswitch
					</tr>
					@endforeach
				</tbody>
			</table>
		</section>
	</div>
</div>
<div class="row">
	<!-- page end-->
</section>
</section>
<!--main content end-->
@endsection