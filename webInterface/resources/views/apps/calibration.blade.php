@extends('common.basic') @section('content')
<link href="{{ asset('css/calibration.css') }}" rel="stylesheet">

<body>
    <div id="calibration-notification"></div>
    <div class="arduino-status">
        <img src="{{ asset('img/arduino-3d.png') }}" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div>
    <!-- /arduino-status -->
    <div class="jumbotron" id="calibration-jumbrotron">
        <div class="container">
            <button class="btn btn-lg custom-btn custom-btn-light" id="calibration-btn" data-toggle="modal" data-target="#calibrationModal">
                Setup
                <br> Calibration
            </button>
            <h3 id="calibration-notifier"> Calibration Not Initiated </h3>
            <div id="calibration-instructions">
                Click the button above to initiate the calibration sequence for the gesture control system. Calibration mode provides a baseline for the system to be able to perform analysis of gestures accurately and efficiently. Increasing the number of calibration iterations will enable the system to detect gestures accurately and less efficiently whereas having fewer iterations will increase efficiency while lowering accuracy.
            </div>
            <h3 id="calibration-counter"></h3>
        </div>
        <!-- /container -->
    </div>
    <!-- /jumbotron -->
    <!-- Calibration Modal -->
    <div class="modal fade" id="calibrationModal" tabindex="-1" role="dialog" aria-labelledby="calibrationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" id="calibrationSettingsHeader">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="calibrationSettings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Setup Calibration</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <p>
                                Select the pre-defined gestures or create your own gesture to calibrate for using the controls below. Hover over the input field to obtain more information regarding the setup controls.
                            </p>
                            <div id="gestureControlsMessage">
                            </div>
                            <label class="control-label">
                                <h4>Gesture List Controls</h4>
                            </label>
                            <div id="customBtnGroup">
                                <div class="input-group">
                                    <input class="form-control custom-input" id="customGestureName" required type="text">
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-default" id="addCustomGesture" onclick="addToGestureList()"><span class="glyphicon glyphicon-plus"></span> Add</button>
                                        <button class="btn btn-sm btn-danger" onclick="removeFromGestureList()"><span class="glyphicon glyphicon-minus"></span> Remove</button>
                                    </span>
                                    <span class="input-group-addon label-white">Gestures Samples</span>
                                    <input class="form-control custom-input" id="calibrationSampleVal" required type="number" min=1 max=15 value="5">
                                </div>
                            </div>
                            <label class="control-label">
                                <h4>Gesture List</h4>
                            </label>
                            <div>
                                <select multiple class="form-control" size="7" name="gesture-list" id="gesture-list">
                                    <option value="up">Up</option>
                                    <option value="down">Down</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn custom-btn" data-dismiss="modal" onclick="startCalibration()">Start Calibration</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
                <!-- /modal-footer -->
            </div>
            <!-- /modal-content panel-danger -->
        </div>
        <!-- /modal-dialog -->
    </div>
    <!-- /modal fade -->
</body>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/calibration.js') }}"></script>
<script src="{{ asset('js/calibrationFSM.js') }}"></script>
@endsection
