var demoStarted = false;

// Jquery tp locate start Gesture Recognition App
var startGestureRecognitionBtn = document.getElementById('startGestureRecognitionDemo');
startGestureRecognitionBtn.addEventListener('click', function() { startGestureRecognition() });

var startGestureRecognition = function() {

    // Create a Websocket
    var conn = new WebSocket('ws://192.168.137.1:8080');

    conn.onopen = function(e) {
        console.log('Connected to server:', conn);
        $('#startGestureRecognitionDemo').hide();
        // Fetch the mode in which the arduino is in
        conn.send("U");
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
        if (demoStarted) {
            if (message.startsWith("AR_U:")) {
                getGesture(message.substring(5));
            }
        } else {
            if (message.includes("AR_MU")) {
                demoStarted = true;
            } else {
                conn.send('U');
            }
        }
    }
}

// Updates the HTML
var updateGesturedPerformed = function(gesturePerformed) {
    $("#gesture_performed").html(gesturePerformed);
}


function getGesture(sample) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $(document).ajaxStart(function() {
        $('#loading').fadeIn("fast");
    });

    $(document).ajaxStop(function() {
        $('#loading').fadeOut("fast");
    });

    var formData = {
        sampleData: sample,
    }

    console.log(formData);

    $.ajax({
        type: 'POST',
        url: "./gesture-get",
        data: formData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            // Display to the user the gesture which has been performed
            updateGesturedPerformed(data.data);

        },
        error: function(data, responseText) {
            console.log(data);
            console.log(responseText);
        }
    });
};
