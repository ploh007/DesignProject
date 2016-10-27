@extends('common.basic') @section('content')
<!-- BODY COMPONENT -->
<link href="./css/pairing.css" rel="stylesheet">

<body>
    <div class="arduino-status">
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
                    <div class="pairingHolder">
                        <h2 class="circleNumber">1</h2>
                        <div class="divider"></div>
                        <div class="pairingText">Turn on the gesture control device and ensure that the LED turns blue</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="pairingHolder">
                        <h2 class="circleNumber">2</h2>
                        <div class="divider"></div>
                        <div class="pairingText">The device ID should be displayed in the list</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="pairingHolder">
                        <h2 class="circleNumber">3</h2>
                        <div class="divider"></div>
                        <div class="pairingText">Select the device and hit "Pair Device"</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="pairingHolder">
                        <h2 class="circleNumber">4</h2>
                        <div class="divider"></div>
                        <div class="pairingText">A notification will display indicating if the device was successfully paired.</div>
                    </div>
                </div>
            </div>

            <hr></hr>

            <div class="row">
            <div class="col-md-4">
                <h4>Device ID</h4>
                <select class="form-control" size="7">
                    <option>GestureDevice_068321</option>
                    <option>GestureDevice_630901</option>
                    <option>GestureDevice_312313</option>
                    <option>GestureDevice_746272</option>
                    <option>GestureDevice_321318</option>
                    <option>GestureDevice_068321</option>
                    <option>GestureDevice_630901</option>
                    <option>GestureDevice_312313</option>
                    <option>GestureDevice_746272</option>
                    <option>GestureDevice_321318</option>
                </select>
            </div>
            <div class="col-md-4">
                <h4>Device Details</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Detail</td>
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
            </div>
            <div class="col-md-4">
                <h4>Device Controls</h4>
                <button class="btn btn-block btn-default">
                    Pair Device
                </button>
                <button class="btn btn-block btn-default">
                    Disconnect Device
                </button>
                <button class="btn btn-block btn-default">
                    Refresh List
                </button>
            </div>
            </div>
            <form action="database" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <!-- Add Device Button -->
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <!-- <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus"></i> Add Device
                        </button> -->
                    </div>
            </form>
            </div>
</body>
@endsection
