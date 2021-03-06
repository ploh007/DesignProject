
var startMonitoringBtn = document.getElementById('startGlobeBtn');
startMonitoringBtn.addEventListener('click', function() { initiateGlobe() });

var globeMonitoring = false;
var connection;

// Updates th Monitoring Button and initiates/stops the Graph Monitor
var initiateGlobe = function() {

    // Change the text to indicate choice to stop monitoring
    if (!globeMonitoring) {
        $("#startGlobeBtn").html("Stop Discovering");
        connection = new startGlobeMonitoring();
    } else {
        $("#startGlobeBtn").html("Start Discovering");
        globeMonitoring = false;
        $(".line").css("stroke", "black");
        connection.closeConnection();
    }
}

var startGlobeMonitoring = function(){

    // Insert HTML into DIV element
    $("#worldGlobeDemo").html(
        '<div class="col-md-12" id="globeParent"><div style="display:none;"><img id="plane" src="./img/plane.png"></div></div>'
    );

    var width = 500,
        height = 500;

    //the scale corrsponds to the radius more or less so 1/2 width
    var projection = d3.geo.orthographic()
        .scale(180)
        .clipAngle(90)
        .translate([width/2,height/2]);

    var canvas = d3.select("#globeParent").append("canvas")
        .attr("width", width)
        .attr("height", height)
        .style("cursor", "move");

    var c = canvas.node().getContext("2d");

    var path = d3.geo.path()
        .projection(projection)
        .context(c);

    var selectedCountryFill = "#007ea3",
        flightPathColor = "#007ea3",
        landFill = "#b9b5ad",
        seaFill = "#e9e4da";
    var startCountry = "Australia";
    var endCountry = "United Kingdom";

    //interpolator from http://bl.ocks.org/jasondavies/4183701
    var d3_geo_greatArcInterpolator = function() {
        var d3_radians = Math.PI / 180;
        var x0, y0, cy0, sy0, kx0, ky0,
            x1, y1, cy1, sy1, kx1, ky1,
            d,
            k;

        function interpolate(t) {
            var B = Math.sin(t *= d) * k,
                A = Math.sin(d - t) * k,
                x = A * kx0 + B * kx1,
                y = A * ky0 + B * ky1,
                z = A * sy0 + B * sy1;
            return [
                Math.atan2(y, x) / d3_radians,
                Math.atan2(z, Math.sqrt(x * x + y * y)) / d3_radians
            ];
        }

        interpolate.distance = function() {
            if (d == null) k = 1 / Math.sin(d = Math.acos(Math.max(-1, Math.min(1, sy0 * sy1 + cy0 * cy1 * Math.cos(x1 - x0)))));
            return d;
        };

        interpolate.source = function(_) {
            var cx0 = Math.cos(x0 = _[0] * d3_radians),
                sx0 = Math.sin(x0);
            cy0 = Math.cos(y0 = _[1] * d3_radians);
            sy0 = Math.sin(y0);
            kx0 = cy0 * cx0;
            ky0 = cy0 * sx0;
            d = null;
            return interpolate;
        };

        interpolate.target = function(_) {
            var cx1 = Math.cos(x1 = _[0] * d3_radians),
                sx1 = Math.sin(x1);
            cy1 = Math.cos(y1 = _[1] * d3_radians);
            sy1 = Math.sin(y1);
            kx1 = cy1 * cx1;
            ky1 = cy1 * sx1;
            d = null;
            return interpolate;
        };

        return interpolate;
    }

    function ready(error, world, names) {
        if (error) throw error;

        var globe = {type: "Sphere"},
            land = topojson.feature(world, world.objects.land),
            countries = topojson.feature(world, world.objects.countries).features,
            i = -1;

        countries = countries.filter(function(d) {
            return names.some(function(n) {
                if (d.id == n.id) return d.name = n.name;
            });
        }).sort(function(a, b) {
            return a.name.localeCompare(b.name);
        });

        // var startIDObj = names.filter(function(d){
        //     return (d.name).toLowerCase() == (startCountry).toLowerCase();
        // })[0];
        // var endIDObj = names.filter(function(d){
        //     return (d.name).toLowerCase() == (endCountry).toLowerCase();
        // })[0];


        // var startGeom = countries.filter(function(d){
        //         return d.id == startIDObj.id
        //     }),
        //     endGeom = countries.filter(function(d){
        //         return d.id == endIDObj.id
        //     })

        // var journey = [];
        // journey[0] = startGeom[0];
        // journey[1] = endGeom[0];
        // var n = countries.length;
        // var startCoord = d3.geo.centroid(journey[0]),
            // endCoord = d3.geo.centroid(journey[1])
        // var coords = [-startCoord[0], -startCoord[1]]

        function redrawGlobeOnly(){
            c.clearRect(0, 0, width, height);
            //base globe
            c.shadowBlur = 0, c.shadowOffsetX = 0, c.shadowOffsetY = 0;
            c.fillStyle = seaFill, c.beginPath(), path(globe), c.fill();
            c.fillStyle = landFill, c.beginPath(), path(land), c.fill();
            //fills for start and end countries
            c.fillStyle = flightPathColor, c.beginPath(), path(journey[0]), c.fill();
            c.fillStyle = flightPathColor, c.beginPath(), path(journey[1]), c.fill();
        }
        function redraw(){
            c.clearRect(0, 0, width, height);
            //base globe
            c.shadowBlur = 0, c.shadowOffsetX = 0, c.shadowOffsetY = 0;
            c.fillStyle = seaFill, c.beginPath(), path(globe), c.fill();
            c.fillStyle = landFill, c.beginPath(), path(land), c.fill();
            //fills for start and end countries
            // c.fillStyle = selectedCountryFill, c.beginPath(), path(journey[0]), c.fill();
            // c.fillStyle = selectedCountryFill, c.beginPath(), path(journey[1]), c.fill();
            //flight path
            // c.strokeStyle = selectedCountryFill, c.lineWidth = 3, c.setLineDash([10, 10])
            //     c.beginPath(), path(flightPath),
                //c.shadowColor = "#373633",
                //c.shadowBlur = 20, c.shadowOffsetX = 5, c.shadowOffsetY = 20,
                // c.stroke();
        }


        // Create a Websocket
        var conn = new WebSocket('ws://192.168.137.1:8080');

        conn.onopen = function(e) {
            console.log('Connected to server:', conn);

            // Fetch the mode in which the arduino is in
            conn.send("R");
        }

        conn.onerror = function(e) {
            // Couldnt connect to the server, display error

            setArduinoStatus("DISCONNECTED", "Idle");
            $('#errorModal').modal('show');
             $("#worldGlobeDemo").html("");
            console.log('Error: Could not connect to server.');
        }

        conn.onclose = function(e) {
            console.log('Connection closed');
        }

        this.closeConnection = function() {
            conn.send("SETMODEUSER");
            setArduinoStatus("DISCONNECTED", "Idle");
            conn.close();
        }

        // var dzTemp = 0;

        conn.onmessage = function(e) {
            
            var message = e.data;
            
            globeMonitoring = true;
            setArduinoStatus("CONNECTED", "RAW");

            if (globeMonitoring){
                var partsOfStr = message.split(',');
                if(globeMonitoring && (partsOfStr.length == 3)){

                    var dx = partsOfStr[0]/2;
                    var dy = -partsOfStr[1]/2;

                    var rotation = projection.rotate();
                    var radius = projection.scale();
                    var scale = d3.scale.linear()
                        .domain([-1 * radius, radius])
                        .range([-90, 90]);
                    var degX = scale(dx);
                    var degY = scale(dy);
                    rotation[0] += degX;
                    rotation[1] -= degY;

                    projection.rotate(rotation);
                    redraw();

                }
            }
        }

        //make the plane always align with the direction of travel
        function calcAngle(originalRotate, newRotate){
            var deltaX = newRotate[0] - originalRotate[0],
                deltaY = newRotate[1] - originalRotate[1]

            return Math.atan2(deltaY, deltaX);
        }

        //this is to make the globe rotate and the plane fly along the path
        function customTransition(journey){
            var rotateFunc = d3_geo_greatArcInterpolator();
            d3.transition()
                .delay(250)
                .duration(5050)
                .tween("rotate", function() {
                    var point = d3.geo.centroid(journey[1])
                    rotateFunc.source(projection.rotate()).target([-point[0], -point[1]]).distance();
                    var pathInterpolate = d3.geo.interpolate(projection.rotate(), [-point[0], -point[1]]);
                    var oldPath = startCoord;
                        return function (t) {
                            projection.rotate(rotateFunc(t));
                            var newPath = [-pathInterpolate(t)[0], -pathInterpolate(t)[1]];
                            var planeAngle = calcAngle(projection(oldPath), projection(newPath));
                            var flightPathDynamic = {}
                            flightPathDynamic.type = "LineString";
                            flightPathDynamic.coordinates = [startCoord, [-pathInterpolate(t)[0], -pathInterpolate(t)[1]]];
                            var maxPlaneSize =  0.1 * projection.scale();
                            //this makes the plane grows and shrinks at the takeoff, landing
                            if (t <0.1){
                                redraw3(flightPathDynamic, planeAngle, Math.pow(t/0.1, 0.5) * maxPlaneSize);
                            }else if(t > 0.9){
                                redraw3(flightPathDynamic, planeAngle, Math.pow((1-t)/0.1, 0.5) * maxPlaneSize );
                            }else{
                                redraw3(flightPathDynamic, planeAngle, maxPlaneSize);
                            }
                            //redraw3(flightPathDynamic, (planeAngle))
                        };
                    //}
                }).each("end", function(){
                    //make the plane disappears after it's reached the destination
                    //also enable the drag interaction at this point
                    redraw();
                    d3.select("#globeParent").select('canvas').call(dragBehaviour);
                })
        }

        //add the plane to the canvas and rotate it
        function drawPlane(context, image, xPos, yPos, angleInRad, imageWidth, imageHeight){
            context.save();
            context.translate(xPos, yPos);
            // rotate around that point, converting our
            // angle from degrees to radians
            context.rotate(angleInRad);
            // draw it up and to the left by half the width
            // and height of the image, plus add some shadow
            //context.shadowColor = "#373633", context.shadowBlur = 20, context.shadowOffsetX = 5, context.shadowOffsetY = 10;
            context.drawImage(image, -(imageWidth/2), -(imageHeight/2), imageWidth, imageHeight);

            // and restore the co-ords to how they were when we began
            context.restore();
        }
    }

    queue()
        .defer(d3.json, "./img/world-110m.json")
        .defer(d3.tsv, "./img/world-country-names.tsv")
        .await(ready);
}