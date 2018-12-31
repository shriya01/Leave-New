@extends('layouts.master')
@section('content')
<div class="row">
    <div class="box">
        <div class="col-lg-12">
            <hr>	
            <h2 class="intro-text text-center">{{ __('messages.login_detail')}}</h2>
            <hr>
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <p class="error">
                {{ $error }}
            </p>
            @endforeach
            @endif
            @if(session()->has('message'))
            <p class="success">
                {{ session()->get('message') }}
            </p>
            @endif
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">					
                    <form method="POST" action="" accept-charset="UTF-8" role="form">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="log" class="control-label">{{ __('messages.email')}}</label>
                                <input class="form-control" placeholder="{{ __('messages.email')}}" name="user_email" type="user_email" id="user_email" required>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="password" class="control-label">{{ __('messages.password')}}</label>
                                <input class="form-control" placeholder="******" name="password" type="password" value="" id="password">
                            </div>
                            <div class="form-group col-lg-12">
                                <input class="btn btn-default" type="submit" value="{{ __('messages.login_button')}}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

