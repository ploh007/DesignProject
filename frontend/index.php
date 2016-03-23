<?php
    include('header.php');
?>

<!-- BODY COMPONENT -->
<body>

    <!-- MAINJUMBOTRON COMPONENT -->
    <div class="jumbotron" id="mainjumbotron">
        <div class="container" >
            <div id="title">
                <h2>Gesture Control System</h2>
                <p>
                    Seamlessly intergrating gesture controls with your everyday devices. 
                    The *Gesture Control Device makes interacting with your devices easier than ever.
                </p>
                <h3 class="hardware-heading custom-btn">Overview</h3>
            </div>
        </div>
    </div>
    <!-- END MAINJUMBOTRON COMPONENT -->

    <!-- HOWITWORKSJUMBOTRON COMPONENT -->
    <div class="jumbotron" id="howitworksjumbotron">
        <div class="container" >

            <h2>How It Works</h2>
            <p>The gesture device system works using an Arduino Uno and an ADXL345 accelerometer</p>
            <hr>

            <!-- ARDUINO DIAGRAM -->
            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="assets/images/arduino_3d.png" width = "180px">
                </div>
                <h3 class="hardware-heading">Arduino Uno</h3>
                <h5>The Arduino Uno offers a plethora of prototyping methods at an affordable cost. </h5>
            </div>
            <!-- END ARDUINO DIAGRAM -->

            <!-- ADXL345 DIAGRAM -->
            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="assets/images/adxl345_3d.png" width = "180px">
                </div>
                <h3 class="hardware-heading">SparkFun ADXL 345</h3>
                <h5>The ADXL 345 allows measuring of acceleration data in 3 different axes (X,Y,Z). </h5>
            </div>
            <!-- END ADXL345 DIAGRAM -->

        </div>
    </div>
    <!-- END HOWITWORKSJUMBOTRON COMPONENT -->

    <!-- MOTIONCAPTURINGJUMBOTRON COMPONENT -->
    <div class="jumbotron" id="motioncapturingjumbotron">

        <div class="container">
            <h3>Motion Capturing</h3>

            <div class="row">
                <div class="col-md-12">
                    <h3 class="hardware-heading" id="startMonBtn" onclick="initiateMon()">
                        Start Monitoring
                    </h3>
                    <div>
                        <h4>Monitoring Interval Settings: <span class="monIntervalSet">30</span></h4>
                    </div>
                </div>
            </div>

            <!-- ACCELEROMETER GRAPHS -->
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <div id="X-Coordinate">
                            <h3> X Coordinate Value </h3>
                            <h5 id="xval">- X-Coordinate Reading -</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="Y-Coordinate">
                            <h3> Y Coordinate Value </h3>
                            <h5 id="yval">- Y-Coordinate Reading -</h5>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div id="Z-Coordinate">
                            <h3> Z Coordinate Value </h3>
                            <h5 id="zval">- Z-Coordinate Reading -</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ACCELEROMETER GRAPHS -->

        </div>
    </div>
    <!-- MOTIONCAPTURINGJUMBOTRON COMPONENT -->

</body>
<!-- END BODY COMPONENT -->

<!-- SETTINGS MODAL -->
<div class="modal fade" id="monModal" tabindex="-1" role="dialog" aria-labelledby="settingsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="settingsModal"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Monitoring Rate</h4>
            </div>

            <form class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Monitoring Rate (ms)</label>

                        <div class="input-group">
                            <input id="userMonitoringVal" required type="number" min=1 max=8000 value="250" class="form-control">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- END SETTINGS MODAL -->

<?php
    include('footer.php');
?>
