var CalibrationFSM2 = function(calibrationDictionary) {

    /* Holds the state machine */
    var currentState = "";
    /* Contains the state value as a string value */
    var currentStateVal = "";

    this.getState = function() {
        return currentStateVal;
    }

    this.setState = function(stateString) {
        currentStateVal = stateString;
    }

    this.next = function() {
        console.log("CAL"+calibrationRep);
        console.log("REQ"+reqCalibrationReps);
        
        console.log("DIC" + Object.keys(calibrationDictionary).length);
        console.log("FSM" + FSMIndex);

            if (calibrationRep == reqCalibrationReps) {
                FSMIndex = FSMIndex + 1;
                if(FSMIndex > Object.keys(calibrationDictionary).length-1){
                    $("#calibration-btn").prop("disabled", false);
                    $("#calibration-counter").html("");
                    calibrationStarted = false;
                    showCalibrationInformation('Complete');
                    conn.close();
                } else {
                    this.setState(calibrationDictionary[FSMIndex]);
                    showCalibrationInformation(calibrationDictionary[FSMIndex]);
                    calibrationRep = 0;
                    $("#calibration-counter").html("Calibrated: " + calibrationRep + "/" + reqCalibrationReps);
                }
            }   else {
                $("#calibration-counter").html("Calibrated: " + calibrationRep + "/" + reqCalibrationReps);
            }
    }
};