var setArduinoStatus = function(arduinoStatus, mode) {
    // CONNECTED
    if (arduinoStatus === "CONNECTED") {
        $('.arduino-status').css("background-color", "#26A65B");
        $('.arduino-status').css("border-color", "#26A65B");
        $('#arduino-status-text').html("Connected");
    }
    // DISCONNECTED
    else if (arduinoStatus === "DISCONNECTED") {
        $('.arduino-status').css("background-color", "#c0392b");
        $('.arduino-status').css("border-color", "#c0392b");
        $('#arduino-status-text').html("Disconnected");
    }

    $("#arduino-status-mode").text("Mode: " + mode.toUpperCase());
}
