@extends('common.basic')
@section('content')
<link href="{{ asset('css/pairing.css') }}" rel="stylesheet">

<body>
    <div class="arduino-status">
        <img src="{{ asset('img/arduino-3d.png') }}" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div><!-- /arduino-status -->

    <div class="jumbotron red-jumbotron" data-wow-duration="2s">
        <div class="container">
            <h2>Connect to Device</h2>
            <p>Follow the instruction sequence below to get your device setup and paired.</p>
        </div><!-- /container -->
    </div><!-- /jumbotron red-jumbotron -->
    
    <div class="jumbotron white-jumbotron-center">
        <div class="container">
            <h2>Connection Sequence</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="pairing-holder">
                        <h2 class="circle-number">1</h2>
                        <div class="divider"></div>
                        <div class="pairing-text">Turn on the gesture control device and ensure that the LED turns blue</div>
                    </div><!-- /pairing-holder -->
                </div><!-- /col-md-3 -->
                <div class="col-md-3">
                    <div class="pairing-holder">
                        <h2 class="circle-number">2</h2>
                        <div class="divider"></div>
                        <div class="pairing-text">The device ID should be displayed in the list</div>
                    </div><!-- /pairing-holder -->
                </div><!-- /col-md-3 -->
                <div class="col-md-3">
                    <div class="pairing-holder">
                        <h2 class="circle-number">3</h2>
                        <div class="divider"></div>
                        <div class="pairing-text">Select the device and hit "Pair Device"</div>
                    </div><!-- /pairing-holder -->
                </div><!-- /col-md-3 -->
                <div class="col-md-3">
                    <div class="pairing-holder">
                        <h2 class="circle-number">4</h2>
                        <div class="divider"></div>
                        <div class="pairing-text">A notification will display indicating if the device was successfully paired.</div>
                    </div><!-- /pairing-holder -->
                </div><!-- /col-md-3 -->
            </div><!-- /row -->
            <hr></hr>
            <div class="alert alert-danger" id="errors">
                <strong>Whoops! Something went wrong!</strong>
                <div id="errorsText"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h4>My Device(s) Details</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Details</td>
                                <td>Value</td>
                            </tr>
                        </thead>
                        <tbody id="mydevicesdata">
                            @include ('database.devices')
                        </tbody>
                    </table><!-- /table table-bordered -->
                </div><!-- /col-md-4 -->
                <div class="col-md-4">
                    <h4>Device ID Pool</h4>
                    <select class="form-control" size="7" name="devices-list" id="device-pool">
                        @foreach ($devices as $device)
                            <option value={{ $device->id }}>GestureDevice_{{ $device->id }}</option>
                        @endforeach
                    </select>
                </div><!-- /col-md-4 -->
                <div class="col-md-4">
                    <h4>Device Controls</h4>
                    <button class="btn btn-block btn-default" id="pair-device">
                        Pair Device
                    </button>
                    <button class="btn btn-block btn-default" id="unpair-device">
                        Disconnect Device
                    </button>
                    <button class="btn btn-block btn-default" id="refresh-device">
                        Refresh List
                    </button>
                </div><!-- /col-md-4 -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /jumbotron white-jumbotron-center -->
</body>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/database.js') }}"></script>
@endsection
