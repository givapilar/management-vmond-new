const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Pool } = require("pg");
var bodyParser = require("body-parser");
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
server.listen(3000, () => {
    console.log('listening on *:3000');
});
