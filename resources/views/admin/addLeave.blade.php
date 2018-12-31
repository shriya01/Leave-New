@extends ('layouts.admin')
@section('content')       
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><i class="fa fa-file-text-o"></i> {{ __('messages.add_user_leave_record')}}</h3>
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard"> {{ __('messages.home')}}</a></li>
            <li><i class="fa fa-file-text-o"></i> {{ __('messages.add_user_leave_record')}}</li>
        </ol>
    </div>
</div>
<div class="row"><div class="col-lg-3"></div>
<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
            {{ __('messages.add_user_leave_record')}}
        </header>
        <div class="panel-body">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <p class="error alert alert-block alert-danger fade in">
                {{ $error }}
            </p>
            @endforeach
            @endif
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            <div id="cserror" style="display:none"><div class="alert alert-danger"> The To Date Must Be Greater Than Or Equal To From Date</div></div>
            <form role="form" method="post" id="adminleaveform" action="{{route('admin/store')}}">
                @csrf
                <div class="col-lg-12">
                <input type="hidden" name="user_id" value="{{ Crypt::encrypt($id) }}">
                    <div class="form-group">
                        <label for="leave_type">Leave Type</label>
                        <select name="leave_type" id="leave_type" class="form-control" >
                            <option value="" selected="selected">Select Leave Type</option>
                            @foreach ($leave_types as $key) 
                            <option value="{{$key->leave_type_id}}">{{$key->leave_type_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="from_date" >From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"  />
                    </div>
                    <div class="form-group">
                        <label for="to_date" >To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"  />
                    </div>
                    <div class="form-group" id="leave_duration" style="display: none">
                        <label >Leave Duration</label>
                        <select name="leave_type_day" id="leave_type_day" class="form-control" >
                            <option value=''>Select Leave Duration</option>
                            <option value="1">Half</option>
                            <option value="2">Full</option>
                            <option value="3">Specified Hours</option>
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
                    <div class="row" id="timebox" style="display: none">
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                <label >From Time</label>
                                <input type="time" name="from_time" id="from_time" class="form-control"  />
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                <label>To Time</label>
                                <input type="time" name="to_time" id="to_time" class="form-control"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <input type="submit" id="ajaxSubmit" name="updateUser" value="SAVE"  class="btn btn-primary btn-lg" tabindex="7" />
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>
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
                jQuery('#timebox').css({
                    'display': 'none'
                });
            }
                if (jQuery('#leave_type_day').val() == '2') {
               jQuery('#leave_slot').css({
                    'display': 'none'
                });
                jQuery('#timebox').css({
                    'display': 'none'
                });
            }
            if(jQuery('#leave_type_day').val() == '3'){
                jQuery('#timebox').css({
                    'display': 'block'
                });
                jQuery('#leave_slot').css({
                    'display': 'none'
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
                url: "{{ route('admin/checkvalidation') }}",
                type: 'POST',
                data: {
                    leave_type: jQuery('#leave_type').val(),
                    from_date: jQuery('#from_date').val(),
                    to_date: jQuery('#to_date').val()
                },
                success: function(result) {
                    if (result == '1') {
                        $("#adminleaveform").submit();
                    }
                    else
                    {
                        jQuery('#cserror').css({
                            'display': 'block'
                        });
                    }
                },
                error: function(xhr) {
                }
            });
        });
    });
</script>
@endsection