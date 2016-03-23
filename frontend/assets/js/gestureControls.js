/**============================
* Javascript Gesture Controls
* @author Paul Loh
* @author Jordan Hatcher
============================**/

/**============================
	SCROLL CONTROLS
============================**/
// Scrolls Page to the left by the given magnitude 
scrollLeft = function (magnitude){
    var operator = "-=";
    $('html,body').scrollTo(operator.concat(magnitude), magnitude, x);
}

// Scrolls Page to the right by the given magnitude 
scrollRight = function (magnitude){
    var operator = "+=";
    $('html,body').scrollTo(operator.concat(magnitude), magnitude, x);
}

// Scrolls Page upwards by the given magnitude 
scrollUp = function (magnitude){
    var operator = "-=";
    $('html,body').scrollTo(operator.concat(magnitude), magnitude, y);
}

// Scrolls Page downwards by the given magnitude 
scrollDown = function (magnitude){
    var operator = "+=";
    $('html,body').scrollTo(operator.concat(magnitude), magnitude, y);
}

/**============================
	PANNING CONTROLS
============================**/

/**============================
	ZOOM CONTROLS
============================**/