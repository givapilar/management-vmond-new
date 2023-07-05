// create an empty modbus client
const ModbusRTU = require("modbus-serial");
const client = new ModbusRTU();

// open connection to a tcp line
client.connectTCP("192.168.0.7", { port: 502 });
client.setID(1);

// read the values of 10 registers starting at address 0
// on device number 1. and log the values to the console.
class ModbusWriteTCP {
    constructor(address, value) {
      this.writeCoil(address, value);
    }

    writeCoil(addr, val) {
        val = (val == 'true') ? true : false;
        client.writeCoil(addr, val, (err, data) => {
            if (err) {
                console.error("Error occurred:", err);
            } else {
                console.log("Write successful. Response data:", data);
            }
        });
    }
}

module.exports = ModbusWriteTCP;
