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

// Updates th Monitoring Button and initiates/stops the Graph Monitor
var initiateMon = function(){

    // Change the text to indicate choice to stop monitoring
    if (!monitoringIsAlive){
    	$("#startMonBtn").html("Stop Monitoring");
    	monitoringIsAlive = true;
    	startMonitoring();
    } else {
    	$("#startMonBtn").html("Start Monitoring");
    	monitoringIsAlive = false;
    	stopMonitoring();
    }
}

// Stops fetching graph data and make line black
var stopMonitoring = function (){
    monitoringIsAlive = false;
    $(".line").css("stroke", "black");
}

// Starts fetching graph data and make line red
var startMonitoring = function (){
    monitoringIsAlive = true;
    $(".line").css("stroke", "#CF000F");
    fetchMonData();
}

// AJAX Loop to fetch data from buffer
var fetchMonData = function() {

	if(monitoringIsAlive){

		$.ajax({
			url: 'assets/ajax/ajax.php', 
			success: function(data) {

				// Attempt parsing data and check if undefined
				if(typeof JSON.parse(data)[0] != 'undefined'){
                    xvalue = JSON.parse(data)[0][0];
                    yvalue = JSON.parse(data)[0][1];
                    zvalue = JSON.parse(data)[0][2];
                }

                shiftUpdateGraph(xvalue,yvalue,zvalue);
            },
        });

	} else {
        // Reset Axis Values and stop calls to update graph
		xvalue = 0;
		yvalue = 0;
		zvalue = 0;
	}
};

// Called to update the graph values and shift the graph to the left
var shiftUpdateGraph = function (xvalue, yvalue, zvalue) {

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