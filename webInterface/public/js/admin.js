/**
 * Admin Page Controls JS
 * @author Paul Loh
 * @author Jordan Hatcher
 * @version 1.0
 */

// Web Socket Initiate Button
var webServerBtn = document.getElementById("initiateWebServer");
webServerBtn.addEventListener("click", function() {
    startServer();
});

// AJAX Script call to initiate Websocket Server Listener
function startServer() {
    $.ajax({
        url: './ajax/server.php',
        success: function(data) {
        	console.log(data);
        },
        error: function(data) {
        	$('#errorModal').modal('show');
        }
    });
}

// Metrics Collection Button
var metricsUpdateBtn = document.getElementById("initiateMetricsUpdate");
metricsUpdateBtn.addEventListener("click", function(){});

// System Check Button
var systemCheckBtn = document.getElementById("initateSystemCheck");
systemCheckBtn.addEventListener("click", function(){});


