@extends('common.basic')
@section('content')

<link href="{{ asset('css/admin.css') }}" rel="stylesheet">

<body>
    <div class="arduino-status">
        <img src="{{ asset('img/arduino-3d.png') }}" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div><!-- /arduino-status -->
    <div class="jumbotron red-jumbotron">
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
                    <button type="button" class="btn custom-btn btn-lg btn-block" data-toggle="modal" data-target="#addDevice">Add Device</button>
                </div><!-- /col-md-3 -->
                <div class="col-md-3">
                    <button class="btn custom-btn btn-lg btn-block" id="initiateWebServer">Start WebSocket Server</button>
                </div><!-- /col-md-3 -->
                <div class="col-md-3">
                    <button class="btn custom-btn btn-lg btn-block" id="initiateMetricsUpdate">Update Metrics</button>
                </div><!-- /col-md-3 -->
                <div class="col-md-3">
                    <button class="btn custom-btn btn-lg btn-block" id="initateSystemCheck">Run System Check</button>
                </div><!-- /col-md-3 -->
            </div><!-- /row -->
            <hr></hr>
            <div class="row">
                <h3>System Health Overview Information</h3>
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
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Gesture Device</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Database Status</td>
                                <td></td>
                                <td></td>
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
                            <th>Description</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Latency</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Transferred Data</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Database Status</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /col-md-6 -->
            </div><!-- /row -->
            <hr></hr>
            @include("apps.graph")
        </div><!-- /panel-body -->
    </div><!-- /container -->
</body>

<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>
@endsection
