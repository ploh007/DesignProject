@extends('common.basic') @section('content')
<link href="./css/calibration.css" rel="stylesheet">

<body>
    <div id="calibration-notification">
    </div>
    <div class="arduino-status">
        <img src="./img/arduino-3d.png" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div>
    <div class="jumbotron" id="calibration-jumbrotron">
        <div class="container">
            <button class="btn btn-lg custom-btn custom-btn-light" onclick="startCalibration()" id="calibration-btn">
                Start<br> Calibration
            </button>
            <h3 id="calibration-notifier"> Calibration Not Initiated </h3>
            <div id="calibration-instructions">
                Click the button above to initiate the calibration sequence for the gesture control system. Calibration mode provides a baseline for the system to be able to perform analysis of gestures accurately and efficiently. Increasing the number of calibration iterations will enable the system to detect gestures accurately and less efficiently whereas having fewer iterations will increase efficiency while lowering accuracy.
            </div>
            <h3 id="calibration-counter"></h3>
        </div>
        <div class="col-md-12">
            <!-- <div id="calibration_image"></div> -->
        </div>
    </div>
</body>
<script src="./js/calibration.js"></script>
<script src="./js/calibrationFSM.js"></script>
@endsection
