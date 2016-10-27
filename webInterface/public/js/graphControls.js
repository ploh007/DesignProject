/**============================
* Javascript Graph Controls
* @author Paul Loh
* @author Jordan Hatcher
============================**/

// Init values of graph points
var xvalue = 0;
var yvalue = 0;
var zvalue = 0;

// Flags and values array
var monitoringIsAlive = false;
var timeVar = 0;
var values = [];

// Connection Object
var connection;

// Event Listener For Monitoring Button
var startMonitoringBtn = document.getElementById('startMonBtn');
startMonitoringBtn.addEventListener('click', function() { initiateMon() });

// Updates th Monitoring Button and initiates/stops the Graph Monitor
var initiateMon = function() {
    // Change the text to indicate choice to stop monitoring
    if (!monitoringIsAlive) {
        $("#startMonBtn").html("Stop Monitoring");
        connection = new startMonitoring();
    } else {
        $("#startMonBtn").html("Start Monitoring");
        monitoringIsAlive = false;
        $(".line").css("stroke", "black");
        connection.closeConnection();
    }
}

// Initiates the Websocket connection and sets the Arduino mode 
var startMonitoring = function() {

    // Create a Websocket
    try {
        var conn = new WebSocket('ws://localhost:8080');
    } catch (e) {
        throw e;
    }

    this.closeConnection = function() {
        conn.send("SETMODEUSER");
        setArduinoStatus("DISCONNECTED", "Idle");
        conn.close();
    }

    conn.onopen = function(e) {
        console.log('Connected to server:', conn);
        // Sends a request to the serial port to fetch the arduino mode
        conn.send("GETMODE");
    }

    conn.onerror = function(e) {
        // setArduinoStatus(1);
        $("#startMonBtn").html("Start Monitoring");
        monitoringIsAlive = false;
        $(".line").css("stroke", "black");
        // conn.closeConnection();
        // Displays an error modal
        $('#errorModal').modal('show');

        console.log(e);
    }

    conn.onclose = function(e) {
        console.log('Connection closed');
    }

    conn.onmessage = function(e) {
        var message = e.data;
        if (message.startsWith("ARDUINO")) {
            if (message == "ARDUINOMODERAW") {
                $("#startMonBtn").html("Stop Monitoring");
                monitoringIsAlive = true;
                $(".line").css("stroke", "red");
                setArduinoStatus("CONNECTED", "Raw");
            } else if (message == "ARDUINOMODECALIB") {
                conn.send("SETMODERAW");
            } else if (message == "ARDUINOMODEUSER") {
                conn.send("SETMODERAW");
            }
        } else {
            if (monitoringIsAlive) {
                var partsOfStr = message.split(',');
                if (monitoringIsAlive && (partsOfStr.length == 3)) {
                    shiftUpdateGraph(partsOfStr[0], partsOfStr[1], partsOfStr[2]);
                } else {
                    shiftUpdateGraph(0, 0, 0);
                }
            }
        }
    }
}

// Called to update the graph values and shift the graph to the left
var shiftUpdateGraph = function(xvalue, yvalue, zvalue) {

    // X Coordinate Reading
    data.push(xvalue);
    path
        .attr("d", line)
        .attr("transform", null)
        .transition()
        .duration(0)
        .ease("linear")
        .attr("transform", "translate(" + x(-60) + ",0)")
        .each("end", fetchMonData);
    data.shift();

    // Y Value Coordinate Reading
    data2.push(yvalue);
    path2
        .attr("d", line)
        .attr("transform", null)
        .transition()
        .duration(0)
        .ease("linear")
        .attr("transform", "translate(" + x(-60) + ",0)")
        .each("end", fetchMonData);
    data2.shift();

    // Z Value Coordinate Reading
    data3.push(zvalue);
    path3
        .attr("d", line)
        .attr("transform", null)
        .transition()
        .duration(0)
        .ease("linear")
        .attr("transform", "translate(" + x(-60) + ",0)")
        .each("end", fetchMonData);
    data3.shift();
}

// Empty Function
var fetchMonData = function() {

}
