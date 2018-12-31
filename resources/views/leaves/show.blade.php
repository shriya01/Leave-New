@extends ('layouts.admin')
@section('styles')
<style type="text/css">
.dataTables_length select {
	padding: 5px 0px;
}
</style>
@endsection
@section('content')
<div class="col-lg-12">
	<h3 class="page-header"><i class="fa fa-table"></i>		
		@if(isset($leaves[0]->user_first_name)){{ ucfirst($leaves[0]->user_first_name) }} @endif
		@if(isset($leaves[0]->user_last_name)){{ ucfirst($leaves[0]->user_last_name) }} @endif
		<a class="btn btn-primary pull-right" href=" {{ url('/') }}/addLeave/{{Crypt::encrypt($leaves[0]->user_id)}}"> {{__('messages.add_user_leave_record')}}</a>
	</h3>
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard">{{ __('messages.home') }}</a></li>
		<li><i class="fa fa-th-list"></i>
			@if(isset($leaves[0]->user_first_name))	 {{ ucfirst($leaves[0]->user_first_name) }} @endif
			@if(isset($leaves[0]->user_last_name))
			{{ ucfirst($leaves[0]->user_last_name)}}
			@endif
		</li>
	</ol>
	<h3>Filter Records For Export</h3>
	<form method="post" action="{{url('leaves/downloadExcel')}}">
		@csrf
		<label>From Date</label>
		<input type="date" name="from_date">
		<input type="date" name="to_date" >
		<input type="hidden" name="user_id" @if(isset( $leaves[0]->user_id )) value="{{ $leaves[0]->user_id }} @endif">
		<select name="file_type">
			<option value="xls">Excel XLS</option>
			<option value="xlsx">Excel XLSX</option>
			<option value="csv">CSV</option>
		</select>
		<input type="submit" name="submit" class="btn btn-primary" value="export">
	</form>
	<hr/>
</div>
</div>
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
						<th>Action</th>
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
						<td>
							<select id="changestatus" name="changestatus" data-id="{{$key->leave_id}}">
								<option value="1" @if($key->status == 1) {{'selected'}} @endif>Approved</option>
								<option value="2" @if($key->status == 2) {{'selected'}} @endif>Pending</option>
								<option value="3" @if($key->status == 3) {{'selected'}} @endif>Rejected</option>
							</select>
						</td>
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
@section('scripts')
<script>
	jQuery(document).ready(function() {
		var value = attrid ='';
		jQuery('select').change(function() {
			value = $(this).val();
			attrid = $(this).attr("data-id");
			jQuery.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			jQuery.ajax({
				url: "{{ route('leaves/changestatus') }}",
				type: 'post',
				data: {
					id:value,
					attrid:attrid
				},
				success: function(result) {
					if(result == 1)
					{
						location.reload();
					}	
				},
			});
		});
	});
</script>
@endsection