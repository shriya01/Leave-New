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
    <h3 class="page-header"><i class="fa fa-table"></i>{{__('messages.users')}}<a class="btn btn-primary pull-right" href=" {{ url('/') }}/addUser"> {{__('messages.add_user')}}</a></h3>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard">{{ __('messages.home') }}</a></li>
        <li><i class="fa fa-th-list"></i>{{ __('messages.users') }}</li>
    </ol>
    <form method="post" action="{{url('leaves/downloadExcel')}}">
        @csrf
        <label>From Date</label>
        <input type="date" name="from_date">
        <input type="date" name="to_date" >
        <select name="file_type">
            <option value="xls">Excel XLS</option>
            <option value="xlsx">Excel XLSX</option>
            <option value="csv">CSV</option>
        </select>
        <input type="submit" name="submit" class="btn btn-primary" value="export">
    </form>
    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ url('leaves/importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (Session::has('import_success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('import_success') }}</p>
        </div>
        @endif
        @if ($message = Session::get('error_array'))
        <div class="alert alert-danger">
            <ul>
                @foreach(Session::get('error_array') as $key)
                <li>
                    {{ $key }}  
                </li>
                <hr />
                @endforeach
            </ul>

        </div>
        @endif
        @if (Session::has('import_error'))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('import_error') }}</p>
        </div>
        @endif
        <input type="file" name="import_file" />
        <button class="btn btn-primary">Import File</button>
    </form>
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
                    <th><i class="icon_profile"></i>{{ __('messages.full_name') }}</th>
                    <th><i class="icon_mail_alt"></i>{{ __('messages.email') }}</th>
                    <th><i class="icon_calendar"></i>{{ __('messages.joining') }}</th>
                    <th><i class="icon_pin_alt"></i>{{ __('messages.status') }}</th>
                    <th><i class="icon_cogs"></i> {{__('messages.action')}}</th>

                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $row)
                <tr>
                    <th>{{$key+1}}</th>
                    <td>{{$row->user_first_name}} {{$row->user_last_name}}</td>
                    <td>{{$row->user_email}}</td>
                    <td>{{ date('d-M Y', strtotime($row->user_created_at)) }}</td>
                    <td>{!! showStatus($row->user_status) !!}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-success" title="{{__('messages.edit')}}" href="{{ url('/') }}/addUser/{{ Crypt::encrypt($row->user_id) }}" data-toggle="tooltip">{{__('messages.edit')}}</a>
                            <a class="btn btn-danger deleteDetail" title="{{__('messages.delete')}}" data-id="{{ Crypt::encrypt($row->user_id) }}" href="#" data-toggle="tooltip">{{__('messages.delete')}}</a>
                            <a class="btn btn-info " title="{{__('messages.view_leave_records')}}" data-id="{{ Crypt::encrypt($row->user_id) }}" href="{{route('leaves/show',Crypt::encrypt($row->user_id))}}" data-toggle="tooltip">{{__('messages.view_leave_records')}}</a>
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