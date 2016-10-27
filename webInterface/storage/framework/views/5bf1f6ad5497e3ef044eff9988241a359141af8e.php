 <?php $__env->startSection('content'); ?>
<link href="./css/admin.css" rel="stylesheet">
<!-- BODY COMPONENT -->

<body>
    <div class="arduino-status">
        <img src="./img/arduino-3d.png" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div>
    <div class="jumbotron red-jumbotron">
        <div class="container">
            <h2>Admin Controls</h2>
            <p>Access information on the gesture control device networks</p>
        </div>
    </div>
    <div class="container">
        <div class="panel-body">
            <h4>Admin System Controls</h4>
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="btn custom-btn btn-lg btn-block" data-toggle="modal" data-target="#addDevice">Add Device</button>
                </div>
                <!-- <div class="col-md-3">
                    <button class="btn custom-btn btn-lg btn-block" id="initiateWebServer">Start WebSocket Server</button>
                </div>
                <div class="col-md-3">
                    <button class="btn custom-btn btn-lg btn-block" id="initiateMetricsUpdate">Update Metrics</button>
                </div>
                <div class="col-md-3">
                    <button class="btn custom-btn btn-lg btn-block" id="initateSystemCheck">Run System Check</button>
                </div> -->
            </div>
            <hr></hr>
            <!-- <div class="row">
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
                </div>
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
                </div>
            </div> -->
        </div>
    </div>
    <div id="addDevice" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Add Device
                </div>
                <div class="modal-body">
                    
                    <p>Set a identification number of the device to add to your profile.</p>

                    <form action="database" method="POST" class="form-horizontal">
                        <?php echo e(csrf_field()); ?>

                        <!-- Device Name -->
                        <div class="form-group">
                            <label for="device-name" class="col-sm-3 control-label">Device Name</label>
                            <div class="col-sm-6">
                                <input type="number" name="name" id="device-name" class="form-control" min="0" max="500" step="1">
                            </div>
                        </div>
                        <!-- Add Device Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-plus"></i> Add Device
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="./js/admin.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('common.basic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>