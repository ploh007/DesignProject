/**
 * Calibration Finite State Machine
 * @author Paul Loh
 * @author Jordan Hatcher
 * @version 1.0
 */

/* Calibration States for FSM
 * Start >> Up >> Down >> Left >> Right >> Complete
 */

/* Complete Calibration State
 */
var CompleteCalibrationState = function(FSM) {
    this.FSM = FSM;
    calibrationStarted = false;

    // Enable Calibration Button
    $("#calibration-btn").prop("disabled", false);
    $("#calibration-counter").html("");
};

/* Down Calibration State
 */
var DownCalibrationState = function(FSM) {
    this.FSM = FSM;
    this.nextCalibration = function() {
        if (calibrationRep > reqCalibrationReps) {
            calibrationRep = 0;
            FSM.trigger(new CompleteCalibrationState(FSM));
            FSM.setState("CALIBCOMPLETE");
            showCalibrationInformation("Complete");
        }
    }
};

/* Up Calibration State
 */
var UpCalibrationationState = function(FSM) {
    this.FSM = FSM;
    this.nextCalibration = function() {
        if (calibrationRep >= reqCalibrationReps) {
            calibrationRep = 0;
            FSM.trigger(new DownCalibrationState(FSM));
            FSM.setState("CALIBDOWN");
            showCalibrationInformation("Down");
        }
    }
};

/* Right Calibration State
 */
var RightCalibrationState = function(FSM) {
    this.FSM = FSM;
    this.nextCalibration = function() {
        if (calibrationRep >= reqCalibrationReps) {
            calibrationRep = 0;
            FSM.trigger(new UpCalibrationationState(FSM));
            FSM.setState("CALIBUP");
            showCalibrationInformation("Up");
        }
    }
};

/* Left Calibration State
 */
var LeftCalibrationState = function(FSM) {
    this.FSM = FSM;
    this.nextCalibration = function() {
        if (calibrationRep >= reqCalibrationReps) {
            calibrationRep = 0;
            FSM.trigger(new RightCalibrationState(FSM));
            FSM.setState("CALIBRIGHT");
            showCalibrationInformation("Right");
        }
    }
};

/* Start Calibration State
 */
var StartCalibrationState = function(FSM) {
    this.FSM = FSM;
    this.nextCalibration = function() {
        FSM.trigger(new LeftCalibrationState(FSM));
        FSM.setState("CALIBLEFT");
        showCalibrationInformation("Left");
    }
}


/**
 * Calibration Finite State Machine methods
 */
var CalibrationFSM = function() {

    /* Holds the state machine */
    var currentState = new StartCalibrationState(this);

    /* Contains the state value as a string value */
    var currentStateVal = "";

    // Function called when calibration for one state is complete
    this.trigger = function(state) {
        // Reinstantiate required calibration count
        currentState = state;
    }

    this.begin = function() {
        currentState.nextCalibration();
    }

    this.getState = function() {
        return currentStateVal;
    }

    this.setState = function(stateString) {
        currentStateVal = stateString;
    }
};
