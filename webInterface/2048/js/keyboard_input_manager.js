function KeyboardInputManager() {
  this.events = {};

  if (window.navigator.msPointerEnabled) {
    //Internet Explorer 10 style
    this.eventTouchstart    = "MSPointerDown";
    this.eventTouchmove     = "MSPointerMove";
    this.eventTouchend      = "MSPointerUp";
  } else {
    this.eventTouchstart    = "touchstart";
    this.eventTouchmove     = "touchmove";
    this.eventTouchend      = "touchend";
  }

  this.listen();
}

KeyboardInputManager.prototype.on = function (event, callback) {
  if (!this.events[event]) {
    this.events[event] = [];
  }
  this.events[event].push(callback);
};

KeyboardInputManager.prototype.emit = function (event, data) {
  var callbacks = this.events[event];
  if (callbacks) {
    callbacks.forEach(function (callback) {
      callback(data);
    });
  }
};

var tempRef;

KeyboardInputManager.prototype.listen = function () {
  var self = this;
  tempRef = this;

  var map = {
    38: 0, // Up
    39: 1, // Right
    40: 2, // Down
    37: 3, // Left
    75: 0, // Vim up
    76: 1, // Vim right
    74: 2, // Vim down
    72: 3, // Vim left
    87: 0, // W
    68: 1, // D
    83: 2, // S
    65: 3  // A
  };

  // Respond to direction keys
  document.addEventListener("keydown", function (event) {
    var modifiers = event.altKey || event.ctrlKey || event.metaKey ||
                    event.shiftKey;
    var mapped    = map[event.which];

    if (!modifiers) {
      if (mapped !== undefined) {
        event.preventDefault();
        self.emit("move", mapped);
      }
    }

    // R key restarts the game
    if (!modifiers && event.which === 82) {
      self.restart.call(self, event);
    }
  });

  // Respond to button presses
  this.bindButtonPress(".retry-button", this.restart);
  this.bindButtonPress(".restart-button", this.restart);
  this.bindButtonPress(".keep-playing-button", this.keepPlaying);

  // Respond to swipe events
  var touchStartClientX, touchStartClientY;
  var gameContainer = document.getElementsByClassName("game-container")[0];

  gameContainer.addEventListener(this.eventTouchstart, function (event) {
    if ((!window.navigator.msPointerEnabled && event.touches.length > 1) ||
        event.targetTouches.length > 1) {
      return; // Ignore if touching with more than 1 finger
    }

    if (window.navigator.msPointerEnabled) {
      touchStartClientX = event.pageX;
      touchStartClientY = event.pageY;
    } else {
      touchStartClientX = event.touches[0].clientX;
      touchStartClientY = event.touches[0].clientY;
    }

    event.preventDefault();
  });

  gameContainer.addEventListener(this.eventTouchmove, function (event) {
    event.preventDefault();
  });

  gameContainer.addEventListener(this.eventTouchend, function (event) {
    if ((!window.navigator.msPointerEnabled && event.touches.length > 0) ||
        event.targetTouches.length > 0) {
      return; // Ignore if still touching with one or more fingers
    }

    var touchEndClientX, touchEndClientY;

    if (window.navigator.msPointerEnabled) {
      touchEndClientX = event.pageX;
      touchEndClientY = event.pageY;
    } else {
      touchEndClientX = event.changedTouches[0].clientX;
      touchEndClientY = event.changedTouches[0].clientY;
    }

    var dx = touchEndClientX - touchStartClientX;
    var absDx = Math.abs(dx);

    var dy = touchEndClientY - touchStartClientY;
    var absDy = Math.abs(dy);

    if (Math.max(absDx, absDy) > 10) {
      // (right : left) : (down : up)
      self.emit("move", absDx > absDy ? (dx > 0 ? 1 : 3) : (dy > 0 ? 2 : 0));
    }
  });
};

var conn = new WebSocket('ws://192.168.137.1:8080');

conn.onopen = function(e) {
  console.log('Connected to server:', conn);
  // Fetch the mode in which the arduino is in
  conn.send("U");
}

conn.onerror = function(e) {
  // Couldnt connect to the server, display error
}

conn.onclose = function(e) {
  conn.send("U");
  console.log('Connection closed');
}

conn.onmessage = function(e) {
  // console.log(e.data);
  var message = e.data;
  if (message.startsWith("AR_U:")) {
    getGesture(message.substring(5));
  }
}

function getGesture(sample) {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  })

  $(document).ajaxStart(function() {
      $('#loading').fadeIn("fast");
  });

  $(document).ajaxStop(function() {
      $('#loading').fadeOut("fast");
  });

  var formData = {
      sampleData: sample,
  }

  // console.log(formData);

  $.ajax({
      type: 'POST',
      url: "../public/gesture-get",
      data: formData,
      dataType: 'json',
      success: function(data) {
          // console.log(data.data);

          var map = {
            "up": 0, // Up
            "right": 1, // Right
            "down": 2, // Down
            "left": 3, // Left
            75: 0, // Vim up
            76: 1, // Vim right
            74: 2, // Vim down
            72: 3, // Vim left
            87: 0, // W
            68: 1, // D
            83: 2, // S
            65: 3  // A
          };

          // Respond to direction keys
          var mapped    = map[data.data];

          // if (!modifiers) {
            if (mapped !== undefined) {
              event.preventDefault();
              tempRef.emit("move", mapped);
            }

            if (data.data === "circle") {
              tempRef.restart.call(tempRef, event);
            }

          $('#gestureDetected').text(data.data);

      },
      error: function(data, responseText) {
          console.log(data);
          console.log(responseText);
      }
  });
};


KeyboardInputManager.prototype.restart = function (event) {
  event.preventDefault();
  this.emit("restart");
};

KeyboardInputManager.prototype.keepPlaying = function (event) {
  event.preventDefault();
  this.emit("keepPlaying");
};

KeyboardInputManager.prototype.bindButtonPress = function (selector, fn) {
  var button = document.querySelector(selector);
  button.addEventListener("click", fn.bind(this));
  button.addEventListener(this.eventTouchend, fn.bind(this));
};
