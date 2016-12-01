@extends('common.basic')
@section('content')

<link href="{{ asset('css/calibration.css') }}" rel="stylesheet">

<body>
    <div id="calibration-notification"></div>
    <div class="arduino-status">
        <img src="{{ asset('img/arduino-3d.png') }}" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div><!-- /arduino-status -->
    <div class="jumbotron" id="calibration-jumbrotron">
        <div class="container">
            <!-- <button class="btn btn-lg custom-btn custom-btn-light" onclick="startCalibration()" id="calibration-btn"> -->
            <button class="btn btn-lg custom-btn custom-btn-light" id="calibration-btn" data-toggle="modal" data-target="#calibrationModal">
                Setup<br> Calibration
            </button>
            <h3 id="calibration-notifier"> Calibration Not Initiated </h3>
            <div id="calibration-instructions">
                Click the button above to initiate the calibration sequence for the gesture control system. Calibration mode provides a baseline for the system to be able to perform analysis of gestures accurately and efficiently. Increasing the number of calibration iterations will enable the system to detect gestures accurately and less efficiently whereas having fewer iterations will increase efficiency while lowering accuracy.
            </div>
            <h3 id="calibration-counter"></h3>
        </div><!-- /container -->
    </div><!-- /jumbotron -->

    <!-- Calibration Modal -->
    <div class="modal fade" id="calibrationModal" tabindex="-1" role="dialog" aria-labelledby="calibrationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="calibrationSettings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Setup Calibration</h4>
                </div>
<!--                 <form class="form-horizontal"> -->
                    <div class="modal-body">
                        <p>
                            Select the pre-defined gestures or create your own gesture to calibrate for using the controls below. 
                            Hover over the input field to obtain more information regarding the setup controls.
                        </p>

                        <div class="form-group">
                            <!-- <label for="inputPassword3" class="col-sm-4 control-label">Basic Gestures</label> -->
                            <div class="panel-body">

                                <div class="col-md-6">
                                    <h4>
                                        Gesture List
                                        <button class="btn btn-sm btn-danger pull-right" onclick="removeFromGestureList()"><span class="glyphicon glyphicon-minus"></span></button>
                                        
                                    </h4>
                                    <select multiple class="form-control" size="7" name="gesture-list" id="gesture-list">
                                        <option value="up">Up</option>
                                        <option value="down">Down</option>
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                    <table class="table table-responsive">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <input id="customGestureName" class="form-control" required type="text">
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-block" id="addCustomGesture" onclick="addToGestureList()">Add <span class="glyphicon glyphicon-plus"></span></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>

                                </div><!-- /col-md-6 -->

                                <div class="col-md-6">
                                    <h4>
                                        Calibration Settings
                                    </h4>
                                    <table class="table table-responsive">
                                        <tr>
                                             <td>Gestures Samples</td>
                                            <td><input id="calibrationSampleVal" required type="number" min=1 max=15 value="5"></td>
                                        </tr>
                                    </table>
                                </div><!-- /col-md-6 -->

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn custom-btn" data-dismiss="modal" onclick="startCalibration()">Start Calibration</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div><!-- /modal-footer -->
                <!-- </form>/form-horizontal -->
            </div><!-- /modal-content panel-danger -->
        </div><!-- /modal-dialog -->
    </div><!-- /modal fade -->

</body>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="{{ asset('js/calibration.js') }}"></script>
<!-- <script src="{{ asset('js/calibrationFSM.js') }}"></script> -->
<script src="{{ asset('js/calibrationFSM2.js') }}"></script>
@endsection
