new WOW().init();

$("#helptabs").addClass("wow fadeInLeft");

$('.btn-default').click(function(){
	$(this).children(0).toggleClass('glyphicon-triangle-bottom');
})

// $("#overview").addClass("wow fadeInDown");
// $("#javaApp").addClass("wow fadeInDown");
// $("#serverApp").addClass("wow fadeInDown");
// $("#libraries").addClass("wow fadeInDown");
// $("#about").addClass("wow fadeInDown");