@extends('common.basic') @section('content')
<!-- BODY COMPONENT -->
<link href="./css/pairing.css" rel="stylesheet">

<body>
    <div class="arduino-status">
        <img src="./img/arduino-3d.png" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div>
    <div class="jumbotron red-jumbotron" data-wow-duration="2s">
        <div class="container">
            <h2>Connect to Device</h2>
            <p>
                Follow the instruction sequence below to get your device setup and paired.
            </p>
        </div>
    </div>
    <div class="jumbotron white-jumbotron-center">
        <div class="container">
            <h2>Connection Sequence</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="pairing-holder">
                        <h2 class="circle-number">1</h2>
                        <div class="divider"></div>
                        <div class="pairing-text">Turn on the gesture control device and ensure that the LED turns blue</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="pairing-holder">
                        <h2 class="circle-number">2</h2>
                        <div class="divider"></div>
                        <div class="pairing-text">The device ID should be displayed in the list</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="pairing-holder">
                        <h2 class="circle-number">3</h2>
                        <div class="divider"></div>
                        <div class="pairing-text">Select the device and hit "Pair Device"</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="pairing-holder">
                        <h2 class="circle-number">4</h2>
                        <div class="divider"></div>
                        <div class="pairing-text">A notification will display indicating if the device was successfully paired.</div>
                    </div>
                </div>
            </div>
            <hr></hr>
            <div class="alert alert-danger" id="errors">
                <strong>Whoops! Something went wrong!</strong>
                <div id="errorsText">
                </div>
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
                    </table>
                </div>
                <div class="col-md-4">
                    <h4>Device ID Pool</h4>
                    <select class="form-control" size="7" name="devices-list" id="device-pool">
                        @foreach ($devices as $device)
                            <option value={{ $device->id }}>GestureDevice_{{ $device->id }}</option>
                        @endforeach
                    </select>
                </div>
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
                </div>
            </div>
            <!-- <div class="col-md-4">
                <form action="#" id="pairForm" method="POST" class="form-horizontal">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="form-group">
                        <select class="form-control" size="7" name="devicespair">
                            @foreach ($devices as $device)
                            <option value={{ $device->id }}>GestureDevice_{{ $device->id }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus"></i> Pair Device
                        </button>
                        @include('common.errors')
                    </div>
                </form>
            </div> -->
            <!--             <div class="col-md-4">
                <form action="#" id="unpairForm" method="POST" class="form-horizontal">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="form-group">
                        <select class="form-control" size="7" name="devicesunpair">
                            @foreach ($devices as $device)
                            <option value={{ $device->id }}>GestureDevice_{{ $device->id }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus"></i> Unpair Device
                        </button>
                        @include('common.errors')
                    </div>
                </form>
            </div> -->
            <!-- <div class="col-md-4">
                    <h4>Device Details</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Details</td>
                                <td>Value</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>IP Address</td>
                                <td>192.168.0.1</td>
                            </tr>
                            <tr>
                                <td>MAC Address</td>
                                <td>0E:21:12:B2:12</td>
                            </tr>
                            <tr>
                                <td>Signal Strength (dBm)</td>
                                <td>30</td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->

                
        </div>
</body>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="./js/database.js"></script>
@endsection
