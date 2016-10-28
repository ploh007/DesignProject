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

    var formData = {}
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: "./database-show",
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
