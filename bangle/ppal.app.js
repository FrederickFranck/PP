Bangle.setGPSPower(1)
Bangle.on('GPS', onGPS);

function onGPS(fix){
    hasfix = fix.fix;
    if(hasfix){
        fix.time.getTime()
        fix.lat.toFixed(6)
        fix.long.toFixed(6)
        fix.speed.toFixed(6)
    }

}