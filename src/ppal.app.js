function draw(){
  g.clear();
  g.setFontAlign(0,0); // center font
  g.setFont("Vector",20); // vector font, 80px  
  // draw the current counter value
  g.drawString("Work in progress\n:)" ,120,120);
  g.flip();
  
    
  Bangle.loadWidgets();
  Bangle.drawWidgets();

}

function onGPS(fix){
    hasfix = fix.fix;
    if(hasfix){

      NRF.updateServices({
        0x66FF : {
          0x0001 : {
            value : fix.lat.toFixed(6).toString(),
            notify: true
          },
          0x0002 : {
            value : fix.long.toFixed(6).toString(),
            notify: true
          },
          0x0003 : {
            value : fix.time.getTime(),
            notify: true
          },
          0x0004 : {
            value : fix.speed.toFixed(6).toString(),
            notify: true
          },
        }
      });        
    }
}


function initServices(){
  NRF.setServices({
    //Custom Service For Punctuality Pal
    0x66FF : {
      0x0001 : {
        value : (5.000001).toString(), // optional
        readable : true,   // optional, default is false
        writable : false,   // optional, default is false
        notify : true,   // optional, default is false
        description: "latitude"  // optional, default is null,
      },
      0x0002 : {
        value : (6.000001).toString(), // optional
        readable : true,   // optional, default is false
        writable : false,   // optional, default is false
        notify : true,   // optional, default is false
        description: "longitude"  // optional, default is null,
      },
      0x0003 : {
        value : "1997-03-10T00:00:00.000Z", // optional
        readable : true,   // optional, default is false
        writable : false,   // optional, default is false
        notify : true,   // optional, default is false
        description: "time"  // optional, default is null,
      },
      0x0004 : {
        value : 0.000000, // optional
        broadcast : true, // optional, default is false
        readable : true,   // optional, default is false
        writable : false,   // optional, default is false
        notify : true,   // optional, default is false
        description: "Speed",  // optional, default is null,
        
        onWrite : function(evt) { // optional
          console.log("Got ", evt.data); // an ArrayBuffer
        }
      },
      0x0005 : {
        value : "Ferry", // optional
        broadcast : true, // optional, default is false
        readable : true,   // optional, default is false
        writable : true,   // optional, default is false
        notify : true,   // optional, default is false
        description: "Description of next public transport",  // optional, default is null,
        
        onWrite : function(evt) { // optional
          console.log("Got ", evt.data); // an ArrayBuffer
        }
      },
      0x0006 : {
        value : "1997-03-10T00:00:00.000Z", // optional
        broadcast : true, // optional, default is false
        readable : true,   // optional, default is false
        writable : true,   // optional, default is false
        notify : true,   // optional, default is false
        description: "Time when next public transport leaves",  // optional, default is null,
        
        onWrite : function(evt) { // optional
          console.log("Got ", evt.data); // an ArrayBuffer
        }
      },
      0x0007 : {
        value : "1997-03-10T00:00:00.000Z", // optional
        broadcast : true, // optional, default is false
        readable : true,   // optional, default is false
        writable : true,   // optional, default is false
        notify : true,   // optional, default is false
        description: "Estimated time of arrival",  // optional, default is null,
        
        onWrite : function(evt) { // optional
          console.log("Got ", evt.data); // an ArrayBuffer
        }
      }
      // more characteristics allowed
    }
    // more services allowed
  });
}

function init(){
  Bangle.setGPSPower(1);
  initServices();
  Bangle.on('GPS', onGPS);
  draw();
}



init();