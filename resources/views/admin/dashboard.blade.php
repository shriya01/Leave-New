@extends ('layouts.admin')
@section('content')
<!--overview start-->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><i class="fa fa-laptop"></i>{{ __('messages.dashboard') }}</h3>
    </div>
</div>
<div class="row"> 
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
        <!--/.info-box-->
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box blue-bg">
            <div class="count">{{ $count['users'] }}</div>
            <div class="title">{{ __('messages.users') }}</div>
        </div>
        <!--/.info-box-->
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <!--/.info-box-->
    </div>
    <!--/.col-->
</div>
@endsection