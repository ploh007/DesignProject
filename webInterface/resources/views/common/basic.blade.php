<html lang="en">
<!-- HEAD COMPONENT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Design Project | Welcome</title>
    <!-- CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/animate.css" rel="stylesheet">
    <link href="./css/common.css" rel="stylesheet">
    <!-- JAVASCRIPTS -->
    <script src="./js/jquery-1.11.3.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/d3.min.js"></script>
    <script src="./js/wow.js"></script>
    <script src="./js/common.js"></script>
    <!-- FONTS -->
<!--     <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'> -->
</head>
<!-- END HEAD COMPONENT -->
<!-- NAVBAR COMPONENT -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home">Gesture Control System</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                    <!-- <li><a href="{{ url('/login') }}">Login</a></li> -->
                    <li>
                        <a href="home"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a>
                    </li>
                    <li>
                        <a href="help"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Help</a>
                    </li>
                @if (Auth::guest())
                    <li>
                        <a href="admin"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Login</a>
                    </li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @endif
                @if (!Auth::guest())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tests <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/database') }}">Database Test</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span> Demo <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="gestureNotifier">Gesture Notifier</a></li>
                            <li><a href="globeController">Globe Controller</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="presentation"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> Presentation</a>
                    </li>
                    <li>
                        <a href="calibration"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Calibration</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="admin">Admin Controls</a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- END NAVBAR COMPONENT -->
@yield('content')

<div id="loading"></div>

<!-- FOOTER COMPONENT -->
<footer>
    <div> CEG 4912/4913 © 2016. Jordan Hatcher || Paul Loh </div>
    <div id="scroll-top">Go To Top</div>
</footer>
<!-- END FOOTER COMPONENT -->

</html>

<!-- ERROR MODAL -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel-danger">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="errorModalHeader"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Connectivity Error</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <p>
                        Error Connecting to Server. Please Ensure that server is running and network is setup correctly.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END ERROR MODAL -->

<!-- JS SCRIPTS -->
