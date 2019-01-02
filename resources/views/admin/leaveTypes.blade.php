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
    <h3 class="page-header"><i class="fa fa-table"></i>{{__('messages.users')}}<a class="btn btn-primary pull-right" href=" {{ url('/') }}/addLeaveType">Add Leave Type</a></h3>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard">{{ __('messages.home') }}</a></li>
        <li><i class="fa fa-th-list"></i>{{ __('messages.users') }}</li>
    </ol>
    <hr/>
</div>
</div>
<div class="col-lg-12">
    <section class="panel">
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
        <table class="table table-striped table-advance table-hover" id="data-table">
            <thead>
                <tr>
                    <th>{{ __('messages.sno') }}</th>
                    <th><i class="icon_profile"></i>Leave Type Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaveTypes as $key => $row)
                <tr>
                    <th>{{$key+1}}</th>
                    <td>{{$row->leave_type_name}}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-success" title="{{__('messages.edit')}}" href="{{ url('/') }}/addLeaveType/{{ Crypt::encrypt($row->leave_type_id) }}" data-toggle="tooltip"><i class='fa fa-edit'></i></a>
                            <a class="btn btn-danger deleteDetail" title="{{__('messages.delete')}}" data-id="{{ Crypt::encrypt($row->leave_type_id) }}" href="#" data-toggle="tooltip"><i class='fa fa-trash'></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>
<!-- page end-->
</section>
</section>
<!--main content end-->
@endsection
@section('scripts')
    <script src="{{ asset('public/backend/js/leavetype.js') }}" type="text/javascript"></script>
@endsection
