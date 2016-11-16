@extends('common.basic') @section('content')
<link href="{{ asset('css/help.css') }}" rel="stylesheet">
<link href="{{ asset('css/devicon.css') }}" rel="stylesheet">

<body>
    <div class="jumbotron red-jumbotron">
        <h2>Help Content</h2>
        <p>Documentation, API and licensing information</p>
    </div><!-- /jumbotron red-jumbotron -->
    <div class="container">
        <div class="panel-body">
            <div class="col-md-4">
                <ul class="nav nav-pills nav-stacked" role="tablist" id="helptabs">
                    <li role="presentation" class="active"><a href="#overview" aria-controls="home" role="tab" data-toggle="tab">Overview</a></li>
                    <li role="presentation"><a href="#javaApp" aria-controls="profile" role="tab" data-toggle="tab">Java Application</a></li>
                    <li role="presentation"><a href="#serverApp" aria-controls="profile" role="tab" data-toggle="tab">Server Processing</a></li>
                    <li role="presentation"><a href="#libraries" aria-controls="profile" role="tab" data-toggle="tab">Libraries</a></li>
                    <li role="presentation"><a href="#api" aria-controls="profile" role="tab" data-toggle="tab">API</a></li>
                    <li role="presentation"><a href="#about" aria-controls="settings" role="tab" data-toggle="tab">About</a></li>
                </ul><!-- /nav nav-pills nav-stacked -->
            </div><!-- /col-md-4 -->
            <div class="col-md-8">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="overview">
                        <h3>Overview of System</h3>
                        <p>The purpose of this project is to develop a system that can capture and analyze gestures performed by the user in order to control or provide inputs to a variety of different devices. We intend for this system improve upon conventional methods of controlling devices by making the experience more natural for the user.</p>
                    </div><!-- /tab-pane active -->
                    <div role="tabpanel" class="tab-pane" id="javaApp">
                        <h3>Java Intepreter</h3>
                        <p>The SerialReader class is used to monitor the serial port that the Gesture processing program uses to receive the gesture data. The SerialReader makes use of the RXTX library, which provides cross-platform support for reading and sending data over serial ports from the Java programming language. When the gesture sensor sends data to the Gesture processing program, a serial event is triggered, and the data is able to be read.
                        </p>
                        <p>
                            When the system is operating in user mode or calibration mode, the Arduino sends the data in four parts (x, y, z, jerk vector). The SerialReader class implements a state machine to keep track of which data segment is being read. When all the data has been read, then the SerialReader class uses the Comparator class to determine which gesture had been performed.
                        </p>
                        <p>
                            When the system is operating in calibration mode, the system works essentially the same way as with user mode. The main difference is that when all data has been received, the SerialReader uses the SampleDao to store the gesture data to the hard drive.
                        </p>
                        <p>
                            When the system is operating in raw data mode, the Arduino is sending a constant stream of data. The SerialReader does not use a state machine in this mode, and instead returns the x, y, and z acceleration readings from the sensor.
                        </p>
                    </div><!-- /tab-pane -->
                    <div role="tabpanel" class="tab-pane" id="serverApp">
                        <h3>Server Application</h3> The server application is built upon the following technologies
                        <ul>
                            <li>WAMP</li>
                            <li>Laravel</li>
                            <li>PHP</li>
                        </ul>
                    </div><!-- /tab-pane -->

                    @include('help.libraries')
                    @include('help.api')

                    <div role="tabpanel" class="tab-pane" id="about">
                        <h3>About the Team</h3>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="caption">
                                    <h4>Jordan Hatcher</h4>
                                    <p>Jordan is a fourth year Computer Engineering Student at the University of Ottawa.</p>
                                </div><!-- /caption -->
                            </div><!-- /col-sm-6 col-md-6 -->
                            <div class="col-sm-6 col-md-6">
                                <div class="caption">
                                    <h4>Paul Loh</h4>
                                    <p>Paul is a fourth year Computer Engineering Student at the University of Ottawa.</p>
                                    <p><a href="www.paulloh.com">www.paulloh.com</a></p>
                                </div><!-- /caption -->
                            </div><!-- /col-sm-6 col-md-6 -->
                        </div><!-- /row -->
                    </div><!-- /tab-pane -->
                </div><!-- /tab-content -->
            </div><!-- /col-md-8 -->
        </div><!-- /panel-body -->
    </div><!-- /container -->
</body>
<script src="{{ asset('js/help.js') }}"></script>
@endsection

