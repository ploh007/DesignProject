<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('img/favicon.png') }}">
    <title>Design Project | Welcome</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/d3.min.js') }}"></script>
    <script src="{{ asset('js/wow.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
</head>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home">
                Gesture Control System
            </a><!-- /navbar-brand -->
        </div><!-- /navbar-header -->
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('/home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
                <li><a href="{{ url('/help') }}"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Help</a></li>
                @if (Auth::guest())
                    <li>
                        <a href="{{ url('/admin') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Login</a>
                    </li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @endif
                @if (!Auth::guest())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span> Demo <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/gestureNotifier') }}">Gesture Notifier</a></li>
                            <li><a href="{{ url('/globeController') }}">Globe Controller</a></li>
                            <li><a href="{{ url('/graph') }}">Graph Controller</a></li>
                            <li><a href="../game/">Demo Game</a></li>
                            <li><a href="../2048/">Demo 2048</a></li>
                        </ul><!-- /dropdown-menu -->
                    </li><!-- /dropdown -->
                    <li><a href="{{ url('/presentation') }}"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> Presentation</a></li>
                    <li><a href="{{ url('/calibration') }}"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Calibration</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/admin') }}">Admin Controls</a></li>
                            <li>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul><!-- /dropdown-menu -->
                    </li><!-- /dropdown -->
                @endif
            </ul><!-- /nav navbar-nav navbar-right -->
        </div><!-- /navbar-collapse collapse -->
    </div><!-- /container-fluid -->
</nav><!-- /navbar navbar-inverse navbar-fixed-top -->

@yield('content')

<div id="loading"></div>

<footer>
    <div> CEG 4192/4193 © 2017. Jordan Hatcher || Paul Loh </div>
    <!-- <buton class="btn btn-sm custom-btn" id="scroll-top">Go To Top</button> -->
</footer>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel-danger">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="errorModalHeader"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Connectivity Error</h4>
            </div><!-- /modal-header panel-heading -->
            <form class="form-horizontal">
                <div class="modal-body">
                    <p>Error Connecting to Server. Please Ensure that server is running and network is setup correctly.</p>
                </div><!-- /modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div><!-- /modal-footer -->
            </form><!-- /form-horizontal -->
        </div><!-- /modal-content panel-danger -->
    </div><!-- /modal-dialog -->
</div><!-- /modal fade -->

</html>
