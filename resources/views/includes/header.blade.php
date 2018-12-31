<header role="banner">
    <div class="brand">{{ __('messages.project_name')}}</div>
    <div class="address-bar">{{ __('messages.project_name_description')}}</div>
    <div id="flags" class="text-center"></div>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">||</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ url('/') }}">{{ __('messages.home') }}</a>
                    </li>
                    @if(!empty(Auth::user()->user_id))
                    <li>
                        <a href="{{ url('/leaves/create') }}">{{ __('messages.apply_leave') }}</a>
                    </li>
                    <li>
                        <a href="{{ url('/leaves/showleaves') }}">{{ __('messages.show_leave') }}</a>
                    </li>
                    <li>
                        <a>{{ __('messages.welcome') }} {{ Auth::user()->user_first_name }} {{ Auth::user()->user_last_name }}</a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}">{{ __('messages.logout') }}</a>
                    </li>
                    @else
                    <li>
                        <a href="{{ url('/login') }}">{{ __('messages.login') }}</a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}">{{ __('messages.register') }}</a>
                    </li>
                    @endif
                    <li><br>
                        <form action="{{ route('changeLanguage') }}" method="post" id="langForm" >
                            <select class="langSelect" name="lang" onchange="this.form.submit()">
                                <option value="">-- Select Language --</option>
                                <option value="en" @if(Config::get('app.locale') == "en") selected @endif >English</option>
                                <option value="in" @if(Config::get('app.locale') == "in") selected @endif >Hindi</option>
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            </select>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>