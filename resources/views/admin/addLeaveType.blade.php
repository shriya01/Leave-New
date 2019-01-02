@extends ('layouts.admin')
@section('content')       
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Leave Type</h3>
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard"> {{ __('messages.home')}}</a></li>
            <li><i class="fa fa-file-text-o"></i>Add Leave Type</li>
        </ol>
    </div>
</div>
<div class="row"><div class="col-lg-3"></div>
<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
            Add Leave Type
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
            <form role="form" method="post" id="adminleaveform" action="">
                @csrf
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="leave_type_name" >Leave Type</label>
                        <input type="text" name="leave_type_name" id="leave_type_name" class="form-control"  />
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