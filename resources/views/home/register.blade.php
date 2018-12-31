@extends('layouts.master')
@section('content')
<div class="row">
    <div class="box">
        <div class="col-lg-12">
            <hr>	
            <h2 class="intro-text text-center">{{ __('messages.register_detail')}}</h2>
            <hr>
            <p>{{ __('messages.fill_detail')}}</p>		
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <p class="error">
                {{ $error }}
            </p>
            @endforeach
            @endif
            <form method="POST" action="" accept-charset="UTF-8" role="form">
                <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">	
                <div class="row">
                    <div class="form-group col-lg-6 ">
                        <label for="firstname" class="control-label">{{ __('messages.first_name')}}</label>
                        <input class="form-control" placeholder="{{ __('messages.first_name')}}" name="first_name" type="text" id="firstname" value="{{ old( 'first_name' ) }}" required>
                    </div>
                    <div class="form-group col-lg-6 ">
                        <label for="lastname" class="control-label">{{ __('messages.last_name')}}</label>
                        <input class="form-control" placeholder="{{ __('messages.last_name')}}" name="last_name" type="text" id="lastname" value="{{ old( 'last_name' ) }}" required>
                    </div>
                </div>
                <div class="row">	
                    <div class="form-group col-lg-6 ">
                        <label for="email" class="control-label">{{ __('messages.email')}}</label>
                        <input class="form-control" placeholder="{{ __('messages.email')}}" name="user_email" type="email" id="user_email" value="{{ old( 'user_email' ) }}" required>
                    </div>
                    <div class="form-group col-lg-6 ">
                        <label for="password" class="control-label">{{ __('messages.password')}}</label>
                        <input class="form-control" placeholder="*****" name="password" type="password" value="" id="password" required>
                    </div>

                    <div class="form-group col-lg-6 ">
                        <label for="confirm_password" class="control-label">{{ __('messages.c_password')}}</label>
                        <input class="form-control" placeholder="*****" name="confirm_password" type="password" value="" id="confirm_password" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label">&nbsp;</label><br>
                        <input class="btn btn-default" type="submit" value="{{ __('messages.register_button')}}">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection