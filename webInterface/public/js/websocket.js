var initiateConnection = function() {

    // Create a Websocket
    var conn = new WebSocket('ws://localhost:8080');

    conn.onopen = function(e) {
        console.log('Connected to server:', conn);
        $('#startGestureRecognitionDemo').hide();
        // Fetch the mode in which the arduino is in
        conn.send("GETMODE");
    }

    conn.onerror = function(e) {
        // Couldnt connect to the server, display error
        setArduinoStatus("DISCONNECTED", "Idle");
        $('#errorModal').modal('show');
        console.log('Error: Could not connect to server.');
    }

    conn.onclose = function(e) {
        conn.send("SETMODEUSER");
        setArduinoStatus("DISCONNECTED", "Idle");
        console.log('Connection closed');
        $('#startGestureRecognitionDemo').show();
    }

    conn.onmessage = function(e) {

        var message = e.data;

        if (message.startsWith("ARDUINO")) {
            if (demoStarted) {

                if (message == "ARDUINOLEFT") {
                    updateGesturedPerformed("<div class='alert alert-success' role='alert'>ARDUINOLEFT</div>");
                } else if (message == "ARDUINOUP") {
                    updateGesturedPerformed("<div class='alert alert-success' role='alert'>ARDUINOUP</div>");
                } else if (message == "ARDUINODOWN") {
                    updateGesturedPerformed("<div class='alert alert-success' role='alert'>ARDUINODOWN</div>");
                } else if (message == "ARDUINORIGHT") {
                    updateGesturedPerformed("<div class='alert alert-success' role='alert'>ARDUINORIGHT</div>");
                } else {
                    updateGesturedPerformed("<div class='alert alert-warning' role='alert'>NOGESTURE</div>");
                }
            } else {
                if (message == "ARDUINOMODECALIB") {
                    conn.send("SETMODEUSER");
                } else if (message == "ARDUINOMODERAW") {
                    conn.send("SETMODEUSER");
                } else if (message == "ARDUINOMODEUSER") {
                    demoStarted = true;
                    setArduinoStatus("CONNECTED", "User");
                }
            }
        }
    }
}