new WOW().init();

// WOW Scroll Reveal Animation class attachments
// $("#mainjumbotron").addClass( "wow fadeInDown");
// $("#motioncapturingjumbotron").addClass( "wow fadeInDown");
// $("#howitworksjumbotron").addClass( "wow fadeInDown");

$(".arduino-status").addClass("wow fadeInRight");

$(document).ready(function() {

$('#scroll-top').on('click', function() {
    $('html,body').scrollTo(0, 1000);
    console.log("HELLO");
});

});
