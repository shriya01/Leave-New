@extends ('layouts.admin')
@section('content')       
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><i class="fa fa-file-text-o"></i> {{ __('messages.edit_user')}}</h3>
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard"> {{ __('messages.home')}}</a></li>
            <li><i class="fa fa-file-text-o"></i> {{ ucfirst($user->user_first_name) }} {{ ucfirst($user->user_last_name) }} </li>
        </ol>
    </div>
</div>
<form role="form" method="post" action="">
    <div class="row"><div class="col-lg-3"></div>
    <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                {{ __('messages.edit_user')}}
            </header>
            <div class="panel-body">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="error alert alert-block alert-danger fade in">
                    {{ $error }}
                </p>
                @endforeach
                @endif
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>{{ __('messages.user_firstname')}}</label>
                        <input type="text" class="form-control" name="user_firstname"  value="{{ $user->user_first_name }}" placeholder="{{ __('messages.user_firstname')}}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.user_lastname')}}</label>
                        <input type="text" class="form-control" name="user_lastname"  value="{{ $user->user_last_name }}" placeholder="{{ __('messages.user_lastname')}}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.user_email')}}</label>
                        <input type="text" class="form-control" name="user_email"  value="{{ $user->user_email }}" placeholder="{{ __('messages.user_email')}}" required>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label>User Country</label>
                        <select class="form-control" name="user_country" required>
                            <option value="IND" @if($user->user_country == 'IND') {{'selected'}} @endif>{{ __('messages.india')}}</option>
                            <option value="AUS" @if($user->user_country == 'AUS') {{'selected'}} @endif>{{ __('messages.australia')}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary">{{ __('messages.submit')}}</button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>
@endsection