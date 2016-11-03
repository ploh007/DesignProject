$("#unpair-device").click(function(e) {

    $('#errors').hide();
    $('#mydevicesdata').hide();

    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    var formData = {
        deviceslist: $('select[name="devices-list"]').val(),
    }

    console.log(formData);

    $(document).ajaxStart(function() {
        $('#loading').fadeIn("slow");
    });

    $(document).ajaxStop(function() {
        $('#loading').fadeOut("slow");
    });

    $.ajax({
        type: 'POST',
        url: "./database-unpair",
        data: formData,
        dataType: 'json',
        success: function(data) {
            $('#mydevicesdata').html(data);
            $('#mydevicesdata').show();
        },
        error: function(data, responseText) {
            console.log(data.responseJSON);
            $('#errorsText').html("Error With Unpairing Device!");
            $("#errors").css("display", "block");
            $('#errors').show();
        }
    });
});

$("#pair-device").click(function(e) {

    $('#errors').hide();
    $('#mydevicesdata').hide();

    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $(document).ajaxStart(function() {
        $('#loading').fadeIn("slow");
    });

    $(document).ajaxStop(function() {
        $('#loading').fadeOut("slow");
    });

    var formData = {
        deviceslist: $('select[name="devices-list"]').val(),
    }
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: "./database-pair",
        data: formData,
        dataType: 'json',
        success: function(data) {
            $('#mydevicesdata').html(data);
            $('#mydevicesdata').show();
        },
        error: function(data, responseText) {
            console.log(data.responseJSON);
            $('#errorsText').html(data.responseJSON);
            $("#errors").css("display", "block");
            $('#errors').show();

        }
    });
});

$("#refresh-device").click(function(e) {

    // $('#errors').hide();
    // $('#mydevicesdata').hide();

    // e.preventDefault();
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // })

    // $(document).ajaxStart(function() {
    //     $('#loading').fadeIn("slow");
    // });

    // $(document).ajaxStop(function() {
    //     $('#loading').fadeOut("slow");
    // });

    // var formData = {}
    // console.log(formData);
    // $.ajax({
    //     type: 'POST',
    //     url: "./database-show",
    //     data: formData,
    //     dataType: 'json',
    //     success: function(data) {
    //         $('#mydevicesdata').html(data);
    //         $('#mydevicesdata').show();
    //     },
    //     error: function(data, responseText) {
    //         console.log(data.responseJSON);
    //         $('#errorsText').html(data.responseJSON);
    //         $("#errors").css("display", "block");
    //         $('#errors').show();
    //     }
    // });

        // Create a Websocket
    try {
        var conn = new WebSocket('ws://localhost:8085');
    } catch (e) {
        throw e;
    }

    this.closeConnection = function() {
        // conn.send("SETMODEUSER");
        // setArduinoStatus("DISCONNECTED", "Idle");
        // conn.close();
    }

    conn.onopen = function(e) {
        console.log('Connected to server:', conn);
        // Sends a request to the serial port to fetch the arduino mode
        // conn.send("GETMODE");
    }

    conn.onerror = function(e) {
        console.log(e);
    }

    conn.onclose = function(e) {
        console.log('Connection closed');
    }

    conn.onmessage = function(e) {
        var message = e.data;

        if (message.startsWith("DEVICE")){
            option = "<option value='message'>"+message+"</option>";
            $('#device-pool').html(option);
        }

    }


});
