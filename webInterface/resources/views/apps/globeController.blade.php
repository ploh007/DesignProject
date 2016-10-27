@extends('common.basic') @section('content')
<!-- BODY COMPONENT -->

<body>
    <div class="arduino-status">
        <img src="./img/arduino-3d.png" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div>
    <div class="jumbotron white-jumbotron-center">
        <div class="container">
                <h2>Globe Controller</h2>
                
                <h4>Visualizes a globe that can be controlled using accelerometer data.</h4>
                <div class="row" id="worldGlobeDemo">
                </div>
                <button class="btn btn-lg custom-btn" id="startGlobeBtn">Start Discovering</button>
        </div>
    </div>
</body>
<script src="https://d3js.org/topojson.v1.min.js"></script>
<script src="https://d3js.org/queue.v1.min.js"></script>
<script src="./js/globe.js"></script>
@endsection
