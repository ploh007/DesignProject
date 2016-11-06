// $("#add-sample").click(function(e) {

//     e.preventDefault();
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     })

//     $(document).ajaxStart(function() {
//         $('#loading').fadeIn("slow");
//     });

//     $(document).ajaxStop(function() {
//         $('#loading').fadeOut("slow");
//     });

//     var formData = {
//         pair_id: '1',
//         gestureName: "TESTING",
//         sampleData: "1231231231231"
//     }
//     console.log(formData);

//     $.ajax({
//         type: 'POST',
//         url: "./samples-add",
//         data: formData,
//         dataType: 'json',
//         success: function(data) {
//             console.log(data);
//         },
//         error: function(data, responseText) {
//             console.log(data.responseJSON);
//         }
//     });
// });

$("#add-sample").click(function(e) {startCalibration()});


var startCalibration = function() {


    // Create a Websocket
    var conn = new WebSocket('ws://localhost:8085');

    /**
    * Open the Websocket connection with the Server
    */
    conn.onopen = function(e) {
            conn.send("SENDARDUINO");
    }

    /**
    * Error reached on the Websocket connection handler
    */
    conn.onerror = function(e) {
    }

    /**
    * Close the websocket connection
    */
    conn.onclose = function(e) {

    }

    /**
    * Handles the websocket messages
    * - Sets upcommunication with the arduino board and 
    *   and ensures the arduino is operating in the calibration state. 
    * - Begins calibration sequence once initialized.
    */
    conn.onmessage = function(e) {
        
    }
}