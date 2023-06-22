const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Pool } = require("pg");
var bodyParser = require("body-parser");
var ModbusWriteTCP = require("./readModbus.js");
// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }));

// parse application/json
app.use(bodyParser.json());

const options = {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
    },
};

const pool = new Pool({
  host: '127.0.0.1',
  port: 5432,
  database: 'management-vmond',
  user: 'postgres',
  password: 'root',
})

pool.connect()

const io = require("socket.io")(server, options);
// io.on('connection', (socket) => {
//     console.log('a user connected');

//     socket.on('message', (msg) => {
//         console.log('DATA::'+msg);
//         socket.emit('message_client', msg);
//     });
//     socket.on('disconnect', () => {
    //           console.log('user disconnected');
    //         });
    //     });
let countOrder;

setInterval(() => {
    orderNotif();
}, 1000);
function orderNotif() {
    pool.query(`SELECT * FROM users`, (error, result) => {
        if (error) {
            throw error;
        }

        let data = result.rows;
        if (data.length > countOrder) {
            io.emit('notif-order', {
                data: data
            })
            console.log('Send Data Success!');
        }

        countOrder = data.length;

        // console.log(data);
    })
    // setInterval(() => {
    //     io.emit('message_client', "MASUK");
    // }, 1000);
}

app.post('/v1/api-control-lamp', (req, res) => {
    try {
        let data = req.body;
        data = JSON.stringify(data);
        data = JSON.parse(data);
        console.log(data);
        new ModbusWriteTCP(data.addr, data.val);

        res.status(200).send('Data Received');
    } catch (error) {
        console.error('Error occurred:', error);
        res.status(500).send('Error occurred');
    }
});

server.listen(3000, () => {
    console.log('listening on *:3000');
});
