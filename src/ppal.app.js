require("FontDylex7x13").add(Graphics);

var NextFerry = 2;
const X = 0, Y = 80;

function draw() {
  g.reset();
  g.setFont("Dylex7x13", 2);
  //g.setFont("Vector", 20); // vector font, 80px  
  // draw the current counter value
  var d = new Date();
  var h = d.getHours(), m = d.getMinutes();
  var time = (" " + h).substr(-2) + ":" + ("0" + m).substr(-2);

  g.drawString("Time :", X, Y);
  g.drawString(time, X +80 , Y, true);
  g.drawString("Next Ferry:", X, Y + 80);
  g.drawString(NextFerry, X + 130, Y + 80, true);

  Bangle.loadWidgets();
  Bangle.drawWidgets();

}

function updateTime(){
d = new Date();
epoch = Math.round(d.getTime());
NRF.updateServices({
      0x66FF: {
        0x0003: {
          value: epoch.toString(),
        }
      }
    });
}

function updateFerry(buffer) {
  ferrytime ="";
  for (let x of buffer){
    let c = String.fromCharCode(x);
    ferrytime.concat(c);
  }
  NextFerry = ferrytime;

}
function onGPS(fix) {
  hasfix = fix.fix;
  if (hasfix) {
    round = 5;
    let _lat = fix.lat.toFixed(round);
    let _long = fix.lon.toFixed(round);
    let _speed = fix.speed.toFixed(round);
    Terminal.println("lat: " + _lat);
    Terminal.println("long: " + _long);
    Terminal.println("speed: " + _speed);

    NRF.updateServices({
      0x66FF: {
        0x0001: {
          value: _lat,
        }
      }
    });

    NRF.updateServices({
      0x66FF: {
        0x0002: {
          value: _long,
        }
      }
    });

    NRF.updateServices({
      0x66FF: {
        0x0003: {
          value: fix.time.getTime().toString(),
        }
      }
    });

    NRF.updateServices({
      0x66FF: {
        0x0004: {
          value: _speed,
        }
      }
    });

  }
}


function initServices() {
  NRF.setServices({
    //Custom Service For Punctuality Pal
    0x66FF: {
      0x0001: {
        value: (51.174070).toString(), // optional
        readable: true,   // optional, default is false
        writable: false,   // optional, default is false
        notify: true,   // optional, default is false
        description: "latitude"  // optional, default is null,
      },
      0x0002: {
        value: (4.380827).toString(), // optional
        readable: true,   // optional, default is false
        writable: false,   // optional, default is false
        notify: true,   // optional, default is false
        description: "longitude"  // optional, default is null,
      },
      0x0003: {
        value: "1616162138000", // optional
        readable: true,   // optional, default is false
        writable: false,   // optional, default is false
        notify: true,   // optional, default is false
        description: "time"  // optional, default is null,
      },
      0x0004: {
        value: "78178178", // optional
        broadcast: true, // optional, default is false
        readable: true,   // optional, default is false
        writable: true,   // optional, default is false
        notify: true,   // optional, default is false
        description: "Speed",  // optional, default is null,

        onWrite: function (evt) { // optional
          E.showMessage("0004 ", evt.data); // an ArrayBuffer
        }
      },
      0x0005: {
        value: "Ferry", // optional
        broadcast: true, // optional, default is false
        readable: true,   // optional, default is false
        writable: true,   // optional, default is false
        notify: true,   // optional, default is false
        description: "Description of next public transport",  // optional, default is null,

        onWrite: function (evt) { // optional
          console.log("0005 ", evt.data); // an ArrayBuffer
        }
      },
      0x0006: {
        value: "16:15:00", // optional
        broadcast: true, // optional, default is false
        readable: true,   // optional, default is false
        writable: true,   // optional, default is false
        notify: true,   // optional, default is false
        description: "Time when next public transport leaves",  // optional, default is null,

        onWrite: function (evt) { // optional
          NextFerry = "";
          for(var i =0; i < evt.data.length; i++){
            NextFerry += String.fromCharCode(evt.data[i]);
          }          
          draw();
          //draw();
        }
      },
      0x0007: {
        value: "16:00:00", // optional
        broadcast: true, // optional, default is false
        readable: true,   // optional, default is false
        writable: true,   // optional, default is false
        notify: true,   // optional, default is false
        description: "Estimated time of arrival",  // optional, default is null,

        onWrite: function (evt) { // optional
          console.log("Got ", evt.data); // an ArrayBuffer
        }
      }
      // more characteristics allowed
    }
    // more services allowed
  });
}

function init() {
  g.clear();
  Bangle.setGPSPower(1);
  initServices();
  Bangle.on('GPS', onGPS);
  draw();
  var timestampInterval = setInterval(updateTime, 1000);
}



init();
console.log("test");