$("#add-sample").click(function(e) {

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
        pair_id: '1',
        gestureName: "TESTING",
        sampleData: "1231231231231"
    }
    console.log(formData);

    $.ajax({
        type: 'POST',
        url: "./samples-add",
        data: formData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
        },
        error: function(data, responseText) {
            console.log(data.responseJSON);
        }
    });
});