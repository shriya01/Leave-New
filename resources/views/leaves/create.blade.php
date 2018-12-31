@extends('layouts.master')
@section('content')
<div class="container">
	<div class="col-sm-4">
		@if($success)
		<div class="alert alert-success">
			<p>{{$success }}</p>
		</div>
		@endif
	</div>
	<div class="col-sm-4">
		@if($errors->any())
		<div class="alert alert-danger">
			<ul style="list-style: none;">
				<li>{{ $errors->first('leave_type') }}</li>
				<li>{{ $errors->first('from_date') }}</li>
				<li>{{ $errors->first('to_date') }}</li>
			</ul>
		</div>
		@endif
		<div class="row">
			<div class="box">
				<div class="col-lg-12">
					<form action="{{route('leaves/store')}}" id="leaveform" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
						@csrf
						<div class="form-group">
							<label >Leave Type</label>
							<select name="leave_type" id="leave_type" class="form-control" >
								<option value="" selected="selected">Select Leave Type</option>
								@foreach ($leave_types as $key) 
								<option value="	{{$key->leave_type_id}}">{{$key->leave_type_name}}</option>
								@endforeach
							</select>
						</div>
						<label >From Date</label>
						<input type="date" name="from_date" id="from_date" class="form-control"  />
						<label >To Date</label>
						<input type="date" name="to_date" id="to_date" class="form-control"  />
						<div class="form-group" id="leave_duration" style="display: none">
							<label >Leave Duration</label>
							<select name="leave_type_day" id="leave_type_day" class="form-control" >
								<option value=''>Select Leave Duration</option>
								<option value="1">Half</option>

								<option value="2">Full</option>
							</select>
						</div>
						<div class="form-group" id="leave_slot" style="display: none">
							<label >Leave Duration</label>
							<select name="leave_slot_day" id="leave_slot_day" class="form-control" >
								<option value=''>Select Leave Slot</option>
								<option value="1">Pre Lunch</option>
								<option value="2">Post Lunch</option>
							</select>
						</div>
						<hr/>
						<div class="row">
							<div class="col-xs-12 col-md-3">
								<input type="submit" id="ajaxSubmit" name="updateUser" value="SAVE"  class="btn btn-primary btn-lg" tabindex="7" />
							</div>
						</div>
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(document).ready(function() {
		jQuery('#to_date').change(function(e) {
			if (jQuery('#from_date').val() != '' && jQuery('#from_date').val() != '') {
				if (jQuery('#from_date').val() == jQuery('#to_date').val()) {
					jQuery('#leave_duration').css({
						'display': 'block'
					});
				} else {
					jQuery('#leave_duration').css({
						'display': 'none'
					});
				}
			}
		});
		jQuery('#leave_duration').change(function(e) {
			if (jQuery('#leave_type_day').val() == '1') {
				jQuery('#leave_slot').css({
					'display': 'block'
				});
			}
		});
		jQuery('#ajaxSubmit').click(function(e) {
			e.preventDefault();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			jQuery.ajax({
				url: "{{ route('leaves/checkvalidation') }}",
				method: 'post',
				data: {
					leave_type: jQuery('#leave_type').val(),
					from_date: jQuery('#from_date').val(),
					to_date: jQuery('#to_date').val()
				},
				success: function(result) {
					console.log(result);
					if (result == '1') {
						$("#leaveform").submit();
					}
				},
				error: function(xhr) {
					console.log(xhr);
					console.log(xhr.message);
				}
			});
		});
	});
</script>
@endsection