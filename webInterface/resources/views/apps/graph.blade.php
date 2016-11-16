<link href="{{ asset('css/graph.css') }}" rel="stylesheet">

<div class="jumbotron white-jumbotron" data-wow-duration="2s">
    <div class="container">
        <h3>Motion Capturing</h3>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-lg custom-btn" id="startMonBtn">
                    Start Monitoring
                </button>
                <h4>Monitoring Interval Settings: <span class="monIntervalSet">30</span></h4>
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div id="X-Coordinate">
                        <h3> X Coordinate Value </h3>
                        <h5 id="xval">- X-Coordinate Reading -</h5>
                    </div>
                </div><!-- /col-md-4 -->
                <div class="col-md-4">
                    <div id="Y-Coordinate">
                        <h3> Y Coordinate Value </h3>
                        <h5 id="yval">- Y-Coordinate Reading -</h5>
                    </div>
                </div><!-- /col-md-4 -->
                <div class="col-md-4">
                    <div id="Z-Coordinate">
                        <h3> Z Coordinate Value </h3>
                        <h5 id="zval">- Z-Coordinate Reading -</h5>
                    </div>
                </div><!-- /col-md-4 -->
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </div><!-- /container -->
</div><!-- /jumbotron white-jumbotron -->

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
                </div><!-- /modal-footer -->
            </form><!-- /form-horizontal -->
        </div><!-- /modal-content panel-danger -->
    </div><!-- /modal-dialog -->
</div><!-- /modal fade -->

<script src="{{ asset('js/graphControls.js') }}"></script>
<script src="{{ asset('js/graph.js') }}"></script>