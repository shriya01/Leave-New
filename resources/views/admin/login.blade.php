<!DOCTYPE html>
<html class="no-js">
    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>{{ __('messages.project_name') }}</title>
            <meta name="description" content="">	
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="{{ asset('public/frontend/css/style.css') }}" rel="stylesheet">
            <link href="{{ asset('public/backend/style_back.css') }}" rel="stylesheet">
            <link href="{{ asset('public/frontend/css/font-awesome.min.css') }}" rel="stylesheet" />
    </head>
    <body>
  	<div class="container">
            <div class="wrapper">
                    <form action="" method="post" name="Login_Form" class="form-signin">       
                        <h3 class="form-signin-heading">{{ __('messages.welcome_back') }}</h3>
                            <hr class="colorgraph"><br>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p class="error">
                                        {{ $error }}
                                    </p>
                                @endforeach
                            @endif
                              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                              <input type="text" class="form-control" name="email" placeholder="{{ __('messages.email') }}" required="" autofocus="" /> <br>
                              <input type="password" class="form-control" name="password" placeholder="*****" required/> 
                              <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">{{ __('messages.login_button') }}</button>  			
                    </form>			
            </div>
	</div>
  </body>
</html>
