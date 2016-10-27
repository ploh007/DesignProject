/**
 * Calibration Javascript
 * @author Paul Loh
 * @author Jordan Hatcher
 * @version 1.0
 */

// Global Variables
var calibrationStarted = false;
var timeStamp = "0";
var calibrationRep = 0;
var reqCalibrationReps = 3;

/* Calibration Notification */

// Hide Calibration Notification
var hideCalibrationNotification = function() {
    $("#calibration-notification").css("display", "none");
    $('#calibration-notification').hide();
}

// Show Calibration Notification
var showCalibrationNotification = function() {
    $("#calibration-notification").css("display", "block");
    $('#calibration-notification').show();
}   

/**
 * Set Calibration Notifier Contextual Information
 * @param {string} bgColor - The background color
 * @param {string} color - The font color 
 * @param {string} content - The string content to display
 */
var setCalibrationNotification = function(bgColor, color, content) {
    $("#calibration-notification").css("background-color", bgColor);
    $('#calibration-notification').css("color", color);
    $('#calibration-notification').html(content);
}

/* Calibration Notifier */

// Hide Calibration Notifier
var hideCalibrationNotifier = function() {
    $("#calibration-notifier").css("display", "none");
    $("#calibration-notifier").hide();
}

// Show Calibration Notifier
var showCalibrationNotifier = function() {
    $("#calibration-notifier").css("display", "block");
    $("#calibration-notifier").show();
}

/**
 * Set Calibration Notifier Message
 * @param {string} message - The calibration notifier message to display
 */
var setCalibrationNotifier = function(message) {
    $("#calibration-notifier").html(message);
}

/* Calibration Image */

// Hide Calibration Image
var hideCalibrationImage = function() {
    $("#calibration-image").css("display", "none");
    $("#calibration-image").hide();
}

// Show Calibration Image
var showCalibrationImage = function() {
    $("#calibration-image").css("display", "block");
    $("#calibration-image").show();
}

/**
 * Set Calibration Image
 * @param {string} image - The path to the calibration image
 */
var setCalibrationImage = function(image) {
    $("#calibration-image").html(image);
}

/**
 * Set Calibration Instructions
 * @param {string} message - The calibration instruction to display
 */
var setCalibrationInstructions = function(message) {
    $("#calibration-instructions").html(message);
}

/**
 * Update the calibration Status Peek In Notifier
 * @param {int} calibStatus - The status code to inform the user (0 = Success, 1 = Failure, Other = Pending)
 */
var updateCalibrationStatus = function(calibStatus) {

    hideCalibrationNotification();

    if (calibStatus == 0) {
        setCalibrationNotification("#26A65B", "#FFF", "<span class='glyphicon glyphicon-ok-circle'></span> Calibration Successful");
        calibrationRep = calibrationRep + 1;
        $("#calibration-counter").html("Successfully Calibrated: " + calibrationRep + "/" + reqCalibrationReps);
    } else if (calibStatus == 1) {
        setCalibrationNotification("#F22613", "#FFF", "<span class='glyphicon glyphicon-remove-circle'></span> Calibration Failed");
    } else {
        setCalibrationNotification("#DADFE1", "#BDC3C7", "<span class='glyphicon glyphicon-hourglass'></span>  Pending Input");
    }
}

/**
 * Resets calibration page to initial contents
 */
var resetCalibration = function() {

    // Enable Calibration Button
    $("#calibration-btn").prop("disabled", false);
    $("#calibration-btn").html("Start <br> Calibration");

    // Reset the Calibration Notifier
    hideCalibrationNotifier();
    setCalibrationNotifier("Calibration Not Initiated ");
    showCalibrationNotifier();

    // Hide the Calibration Notification
    hideCalibrationNotification();

    // Set the Calibration Instructions
    setCalibrationInstructions("Click the button above to initiate the calibration sequence for the gesture control system. Calibration mode provides a baseline for the system to be able to perform analysis of gestures accurately and efficiently. <br><br> Increasing the number of calibration iterations will enable the system to detect gestures accurately and less efficiently whereas having fewer iterations will increase efficiency while lowering accuracy. ");
    setCalibrationImage("");
}

/**
 * Shows calibration information pertaining to the appropriate context
 * @param {int} gestureType - The gesture type to display information for
 */
var showCalibrationInformation = function(gestureType) {

    hideCalibrationNotifier();

    if (gestureType == "Right") {
        setCalibrationNotifier("Calibration for Right Gesture");
        setCalibrationImage("<h2><img src='assets/images/swipe-helper.gif' width=200px></h2>");
        setCalibrationInstructions(" Hold the Gesture Control Device and perform the swipe right motion.");
    } else if (gestureType == "Left") {
        setCalibrationNotifier("Calibration for Left Gesture");
        setCalibrationImage("<h2><img src='assets/images/swipe_left.gif' width=200px></h2>");
        setCalibrationInstructions(" Hold the Gesture Control Device and perform the swipe left motion.");
    } else if (gestureType == "Down") {
        setCalibrationNotifier("Calibration for Down Gesture");
        setCalibrationImage("<h2><img src='assets/images/swipe_left.gif' width=200px></h2>");
        setCalibrationInstructions(" Hold the Gesture Control Device and perform the swipe down motion.");
    } else if (gestureType == "Up") {
        setCalibrationNotifier("Calibration for Up Gesture");
        setCalibrationImage("<h2><img src='assets/images/swipe_left.gif' width=200px></h2>");
        setCalibrationInstructions(" Hold the Gesture Control Device and perform the swipe Up motion.");
    } else if (gestureType == "Complete") {
        setCalibrationNotifier("Calibration Process Complete");
        setCalibrationImage("<h2><img src='assets/images/swipe_left.gif' width=200px></h2>");
        setCalibrationInstructions(" Calibration Process Complete");
    }

    showCalibrationNotifier();
    showCalibrationImage();
}

var startCalibration = function() {

    // Instatiate a new Calibration FSM
    var StateMachine;

    // Create a Websocket
    var conn = new WebSocket('ws://localhost:8080');

    /**
    * Open the Websocket connection with the Server
    */
    conn.onopen = function(e) {

        if (DEBUGMODE) {
            console.log('Connected to server:', conn);
        }

        // Fetch the mode in which the arduino is in
        conn.send("GETMODE");
    }

    /**
    * Error reached on the Websocket connection Handler
    */
    conn.onerror = function(e) {

        // Couldnt connect to the server, display error
        if (DEBUGMODE) {
            console.log('Error: Could not connect to server.');
            console.log(e);
        }

        calibrationStarted = false;

        // Enable Calibration Button
        $("#calibration-btn").prop("disabled", false);
        $("#calibration-counter").html("");

        resetCalibration();
        setArduinoStatus("DISCONNECTED", "Idle");

        $('#errorModal').modal('show');
    }

    /**
    * Close the websocket connection
    */
    conn.onclose = function(e) {

        // Set the Arduino to the User Mode
        conn.send("SETMODEUSER");
        setArduinoStatus("DISCONNECTED", "Idle");

        if (DEBUGMODE) {
            console.log('Connection closed');
        }
    }

    /**
    * Handles the websocket messages
    * - Sets upcommunication with the arduino board and 
    *   and ensures the arduino is operating in the calibration state. 
    * - Begins calibration sequence once initialized.
    */
    conn.onmessage = function(e) {
        
        var message = e.data;

        if (message.startsWith("ARDUINO")) {
            if (calibrationStarted) {

                if (message == "ARDUINOCALIBSUCCESS") {
                    updateCalibrationStatus(0);
                    conn.send(StateMachine.getState());
                } else if (message == "ARDUINOCALIBFAIL") {
                    updateCalibrationStatus(1);
                } 

                StateMachine.begin();

            } else {
                if (message == "ARDUINOMODECALIB") {

                    calibrationStarted = true;
                    
                    $("#calibration-btn").prop("disabled", true);
                    setArduinoStatus("CONNECTED", "Calib");
                  
                    // Initialize State Machine and Begin
                    StateMachine = new CalibrationFSM();
                    StateMachine.begin();

                } else if (message == "ARDUINOMODERAW" || message == "ARDUINOMODEUSER") {
                    conn.send("SETMODECALIB");
                }
            }
        }
    }
}
