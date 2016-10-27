@extends('common.basic') @section('content')
<!-- BODY COMPONENT -->

<body>
    <div class="arduino-status arduino-status-light">
        <img src="./img/arduino-3d.png" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div>
    <!-- MAINJUMBOTRON COMPONENT -->
<!--     <div class="jumbotron" id="mainjumbotron">
        <div class="container">
            
        </div>
    </div> -->
    <div class="jumbotron white-jumbotron-center">
        <div class="container">
            <h2>Gesture Notifier</h2>
            <h4>Notifies the user of the corresponding gesture which has been recognized.</h4>
            <button class="btn btn-lg custom-btn" id="startGestureRecognitionDemo">Start Demo</button>
            <div class="panel-body" id="gesture_performed">
            </div>
        </div>
    </div>
</body>
<script src="./js/demo.js"></script>
@endsection
