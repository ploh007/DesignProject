var presentationStarted = false;

// Jquery tp locate start Gesture Recognition App
var startPresentationBtn = document.getElementById('startPresentationBtn');
startPresentationBtn.addEventListener('click', function() { startPresentation() });

var startPresentation = function() {

    // Create a Websocket
    var conn = new WebSocket('ws://192.168.137.1:8080');

    conn.onopen = function(e) {
        console.log('Connected to server:', conn);
        // $('#startGestureRecognitionDemo').hide();
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
        // $('#startGestureRecognitionDemo').show();
    }

    conn.onmessage = function(e) {

        var message = e.data;

        if (message.startsWith("ARDUINO")) {
            if (presentationStarted) {

                if (message == "ARDUINOLEFT") {
                    moveCarousel("LEFT");
                } else if (message == "ARDUINORIGHT") {
                    moveCarousel("RIGHT");
                } else {
                    //
                }
            } else {
                if (message == "ARDUINOMODECALIB") {
                    conn.send("SETMODEUSER");
                } else if (message == "ARDUINOMODERAW") {
                    conn.send("SETMODEUSER");
                } else if (message == "ARDUINOMODEUSER") {
                    presentationStarted = true;
                    setArduinoStatus("CONNECTED", "User");
                }
            }
        }
    }
}

// Updates the HTML
var moveCarousel = function(direction) {
    if (direction == "RIGHT") {
        $('.carousel').carousel('next');
    } else {
        $('.carousel').carousel('prev');
    }
}
