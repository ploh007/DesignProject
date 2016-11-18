@extends('common.basic')
@section('content')

<body>
    <div class="arduino-status">
        <img src="{{ asset('img/arduino-3d.png') }}" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div><!-- /arduino-status -->

    <div class="jumbotron white-jumbotron-center">
        <div class="container">
            <h2>Gesture Notifier</h2>
            <h4>Notifies the user of the corresponding gesture which has been recognized.</h4>
            <button class="btn btn-lg custom-btn" id="startGestureRecognitionDemo">Start Demo</button>
            <div class="panel-body" id="gesture_performed">
            </div><!-- /panel-body -->
        </div><!-- /container -->
    </div><!-- /jumbotron white-jumbotron-center -->
</body>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/demo.js') }}"></script>
@endsection
