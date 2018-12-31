@extends ('layouts.admin')
@section('content')       
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><i class="fa fa-file-text-o"></i> {{ __('messages.add_user')}}</h3>
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard"> {{ __('messages.home')}}</a></li>
            <li><i class="fa fa-file-text-o"></i> {{ __('messages.add_user')}}</li>
        </ol>
    </div>
</div>
<form role="form" method="post" action="">
    <div class="row"><div class="col-lg-3"></div>
    <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                {{ __('messages.add_user')}}
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
                        <input type="text" class="form-control" name="user_firstname"  value="{{ old('user_firstname')}}" placeholder="{{ __('messages.user_firstname')}}" required />
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.user_lastname')}}</label>
                        <input type="text" class="form-control" name="user_lastname"  value="{{ old('user_lastname')}}" placeholder="{{ __('messages.user_lastname')}}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.user_email')}}</label>
                        <input type="text" class="form-control" name="user_email"  value="{{ old('user_email')}}" placeholder="{{ __('messages.user_email')}}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.password')}}</label>
                        <input type="password" class="form-control" name="password"  value="{{ old('password')}}" placeholder="{{ __('messages.password')}}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.password_confirmation')}}</label>
                        <input type="password" class="form-control" name="password_confirmation"  value="{{ old('password_confirmation')}}" placeholder="{{ __('messages.password_confirmation')}}" required>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <label>User Country</label>
                        <select class="form-control" name="user_country" required>
                            <option value="">Select Country</option>
                            <option value="IND">{{ __('messages.india')}}</option>
                            <option value="AUS">{{ __('messages.australia')}}</option>
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