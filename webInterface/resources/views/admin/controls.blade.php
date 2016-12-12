@extends('common.basic')
@section('content')

<link href="{{ asset('css/admin.css') }}" rel="stylesheet">

<body>
    <div class="arduino-status">
        <img src="{{ asset('img/arduino-3d.png') }}" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div><!-- /arduino-status -->

    <div class="jumbotron red-jumbotron" id="admin-header">
        <div class="container">
            <h2>Admin Controls</h2>
            <p>Access information on the gesture control device networks</p>
        </div><!-- /container -->
    </div><!-- /jumbotron red-jumbotron -->

    <div class="container">
        <div class="panel-body">
            
            <div class="row">
                <div class="col-md-3">
                    <h3><span class="glyphicon glyphicon-user"></span> System Controls</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a class="btn custom-btn btn-block" id="initateSystemCheck">Run System Check</a></li>

                        <li class="list-group-item"><a class="btn custom-btn btn-block" href="calibration">Run Calibration Sequence</a></li>

                        <li class="list-group-item"><a class="btn custom-btn btn-block" href="pairing">Pair With A Device</a></li>

                        <!-- <li class="list-group-item"><a class="btn custom-btn btn-block" href="pairing"> Device</a></li> -->
                    </ul>
                </div>
                <div class="col-md-9">
                    <h3><span class="glyphicon glyphicon-cog"></span> System Overview</h3>
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <th>Component</th>
                            <th>Status</th>
                            <th>Description</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td >Listening Server</td>
                                <td>192.168.137.1</td>
                                <td>The IP Address of the system server which facilitates the web socket protocol communication.</td>
                            </tr>
                            <tr>
                                <td>Database Status</td>
                                @if ($databaseTable)
                                    <td class="success">No Issues</td>
                                @else
                                    <td class="danger">Error</td>
                                @endif
                                <td>The status of the database connections, data integrity and database tables.</td>
                            </tr>
                            <tr>
                                <td>Gesture Samples</td>
                                <td>{{$sampleCount}}</td>
                                <td>The total number of calibration samples that has been done for all devices.</td>
                            </tr>
                            <tr>
                                <td>Paired Devices</td>
                                <td>{{$userDevices}}</td>
                                <td>The total number of devices which have been paired with.</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /col-md-6 -->
            </div><!-- /row -->
        </div><!-- /panel-body -->
    </div><!-- /container -->
</body>

<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>
@endsection
