@extends('common.basic') @section('content')
<link href="./css/help.css" rel="stylesheet">
<link href="./css/devicon.css" rel="stylesheet">

<body>
    <div class="jumbotron red-jumbotron">
        <h2>Help Content</h2>
        <p>Documentation, API and licensing information</p>
    </div>
    <div class="container">
        <div class="panel-body">
            <!-- Nav tabs -->
            <div class="col-md-4">
                <ul class="nav nav-pills nav-stacked" role="tablist" id="helptabs">
                    <li role="presentation" class="active"><a href="#overview" aria-controls="home" role="tab" data-toggle="tab">Overview</a></li>
                    <li role="presentation"><a href="#javaApp" aria-controls="profile" role="tab" data-toggle="tab">Java Application</a></li>
                    <li role="presentation"><a href="#serverApp" aria-controls="profile" role="tab" data-toggle="tab">Server Processing</a></li>
                    <li role="presentation"><a href="#libraries" aria-controls="profile" role="tab" data-toggle="tab">Libraries</a></li>
                    <li role="presentation"><a href="#api" aria-controls="profile" role="tab" data-toggle="tab">API</a></li>
                    <li role="presentation"><a href="#about" aria-controls="settings" role="tab" data-toggle="tab">About</a></li>
                </ul>
            </div>
            <div class="col-md-8">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="overview">
                        <h3>Overview of System</h3>
                        <p>The purpose of this project is to develop a system that can capture and analyze gestures performed by the user in order to control or provide inputs to a variety of different devices. We intend for this system improve upon conventional methods of controlling devices by making the experience more natural for the user.</p>
                    </div>
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
                    </div>
                    <div role="tabpanel" class="tab-pane" id="serverApp">
                        <h3>Server Application</h3> The server application is built upon the following technologies
                        <ul>
                            <li>WAMP</li>
                            <li>Laravel</li>
                            <li>PHP</li>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="libraries">
                        <h3>Libraries</h3>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <!-- <img src="..." alt="..."> -->
                                        <div class="caption">
                                            <h4>D3</h4>
                                            <p>JavaScript library for manipulating documents based on data</p>
                                        </div>
                                        <a href="https://d3js.org/" class="btn custom-btn btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <!-- <img src="..." alt="..."> -->
                                        <div class="caption">
                                            <h4>BootStrap</h4>
                                            <p>HTML, CSS, and JS framework for developing responsive projects on the web.</p>
                                        </div>
                                        <a href="http://getbootstrap.com/" class="btn custom-btn btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail thumbnail-alt">
                                        <!-- <img src="..." alt="..."> -->
                                        <div class="caption">
                                            <h4><span class="glyphicon devicon-java-plain"></span> Java</h4>
                                            <p>A library for interfacing with serial port communication</p>
                                        </div>
                                        <a href="https://www.java.com/en/" class="btn custom-btn btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail thumbnail-alt">
                                        <!-- <img src="..." alt="..."> -->
                                        <div class="caption">
                                            <h4>Cboden Ratchet</h4>
                                            <p>PHP Plugin which allows communicating data using Websockets</p>
                                        </div>
                                        <a href="http://socketo.me/" class="btn custom-btn btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <!-- <img src="..." alt="..."> -->
                                        <div class="caption">
                                            <h4>RXTX</h4>
                                            <p>A library for interfacing with serial port communication</p>
                                        </div>
                                        <a href="http://rxtx.qbang.org" class="btn custom-btn btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail thumbnail-alt">
                                        <!-- <img src="..." alt="..."> -->
                                        <div class="caption">
                                            <h4><span class="glyphicon devicon-laravel-plain"></span> Laravel</h4>
                                            <p>PHP Web Application Framework</p>
                                        </div>
                                        <a href="https://laravel.com/" class="btn custom-btn btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="api">
                        <h3>System API</h3>
                        <h3>Program Laravel Directory Structure</h3>
                        <!-- App Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#app"><span class="glyphicon glyphicon-triangle-right"></span> app</button>
                            <div id="app" class="collapse">
                                <ul>
                                    <li>Console</li>
                                    <li>Exceptions</li>
                                    <li>
                                        Http
                                        <ul>
                                            <li>
                                                Controllers
                                                <ul>
                                                    <li>Auth</li>
                                                    <li>Custom Controllers</li>
                                                </ul>
                                            </li>
                                            <li>Middleware</li>
                                        </ul>
                                    </li>
                                    <li>Providers</li>
                                    <li>Custom Models</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Bootstrap Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#bootstrap"> bootstrap</button>
                        </div>
                        <!-- Config Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#config">config</button>
                            <div id="config" class="collapse">
                            </div>
                        </div>
                        <!-- Database Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#database"><span class="glyphicon glyphicon-triangle-right"></span> database</button>
                            <div id="database" class="collapse">
                                <ul>
                                    <li>factories</li>
                                    <li>migrations</li>
                                    <li>seeds</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Public Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#public"><span class="glyphicon glyphicon-triangle-right"></span> public</button>
                            <div id="public" class="collapse">
                                <ul>
                                    <li>ajax</li>
                                    <li>css</li>
                                    <li>fonts</li>
                                    <li>img</li>
                                    <li>js</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Resources Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#resources"><span class="glyphicon glyphicon-triangle-right"></span> resources</button>
                            <div id="resources" class="collapse">
                                <ul>
                                    <li>assets
                                        <ul>
                                            <li>js</li>
                                            <li>sass</li>
                                        </ul>
                                    </li>
                                    <li>lang</li>
                                    <li>
                                        views
                                        <ul>
                                            <li>admin</li>
                                            <li>apps</li>
                                            <li>auth</li>
                                            <li>common</li>
                                            <li>errors</li>
                                            <li>layouts</li>
                                            <li>vendor</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Routes Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#routes"><span class="glyphicon glyphicon-triangle-right"></span> routes</button>
                            <div id="routes" class="collapse">
                            </div>
                        </div>
                        <!-- Storage Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#storage">storage</button>
                            <div id="storage" class="collapse">
                            </div>
                        </div>
                        <!-- Tests Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#tests">tests</button>
                            <div id="tests" class="collapse">
                            </div>
                        </div>
                        <!-- Vendor Section -->
                        <div class="row">
                            <button type="button" class="btn btn-default btn-api" data-toggle="collapse" data-target="#vendor">vendor</button>
                            <div id="vendor" class="collapse">
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="about">
                        <h3>About the Team</h3>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div>
                                    <div class="caption">
                                        <h4>Jordan Hatcher</h4>
                                        <p>Jordan is a fourth year Computer Engineering Student at the University of Ottawa.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div>
                                    <div class="caption">
                                        <h4>Paul Loh</h4>
                                        <p>Paul is a fourth year Computer Engineering Student at the University of Ottawa.</p>
                                        <a href="www.paulloh.com">www.paulloh.com</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/help.js"></script>
</body>
@endsection
