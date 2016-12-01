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
            <h4>Admin System Controls</h4>
            <div class="row">
                <div class="col-md-3">
                    <button class="btn custom-btn btn-lg btn-block" id="initateSystemCheck">Run System Check</button>
                </div><!-- /col-md-3 -->
            </div><!-- /row -->
            <hr></hr>
            <div class="row">
                <h3><span class="glyphicon glyphicon-cog"></span> System Health Overview Information</h3>
                <div class="col-md-6">
                    <h4>System Status</h4>
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <th>System Component</th>
                            <th>Status</th>
                            <th>Error Message</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Listening Server</td>
                                <td>192.168.137.1</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Database Status</td>
                                @if ($databaseTable)
                                    <td class="success">No Issues</td>
                                    <td></td>
                                @else
                                    <td class="danger">Error</td>
                                    <td></td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /col-md-6 -->
                <div class="col-md-6">
                    <h4>Data Metrics</h4>
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <th>System Component</th>
                            <th>Value</th>
                            
                        </thead>
                        <tbody>
                            <tr>
                                <td>Gesture Samples</td>
                                <td>{{$sampleCount}}</td>
                                
                            </tr>
                            <tr>
                                <td>Paired Devices</td>
                                <td>{{$userDevices}}</td>
                            </tr>
                            <tr>
                                <td>User ID</td>
                                <td>{{$userID}}</td>
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
