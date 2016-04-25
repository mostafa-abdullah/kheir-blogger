<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>--}}

    <!-- Styles -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- dataTables style -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            /*font-family: 'Lato';*/
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    @yield('styling')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Kheir Blogger
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    <li>
                        <div style="padding:10px">
                            @include('search.query')
                        </div>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->

                    @if(Auth::user())

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->first_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/volunteer', Auth::user()->id)}}">View profile</a></li>
                                <li><a href="/notifications">Notifications</a></li>
                                <li><a href="/feedback">Feedback</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>

                    @elseif(auth()->guard('organization')->check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ auth()->guard('organization')->user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/organization', Auth::guard('organization')->id())}}">View profile</a></li>
                                <li><a href="{{ url('/logout_organization') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ url('/login') }}">Login (Volunteer)</a></li>
                        <li><a href="{{ url('/register') }}">Register (Volunteer)</a></li>
                        <li><a href="{{ url('/login_organization') }}">Login (Organization)</a></li>
                        <li><a href="{{ url('/register_organization') }}">Register (Organization)</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    {{-- For Search Validation --}}
    @include('errors')

    @if(auth()->guard('user')->check())

            Hello
    @endif
    <div class="container">
        @yield('content')
    </div>

    <!-- JavaScripts -->
    <script src="{{asset('js/jquery-1.11.3.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- dataTables JS -->
    <script src="{{asset('js/view-organizations.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
    @yield('scripts')
</body>
</html>
