const express = require('express');
var https = require('https');
fs = require('fs');
const app = express();

var options = {
    key: fs.readFileSync( './selfsigned.key' ),
    cert: fs.readFileSync( './selfsigned.crt' ),
    requestCert: false,
    rejectUnauthorized: false
 };
 var port = process.env.PORT || 3000;
 var server = https.createServer( options, app );
app.use(require('cors')())
const io = require('socket.io')(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

io.on('connection', (socket) => {
    console.log('connection');

    socket.on('sendChatToServer', (message) => {
        console.log(message);

        // io.sockets.emit('sendChatToClient', message);
        socket.broadcast.emit('sendChatToClient', message);
    });

    socket.on('disconnect', (socket) => {
        console.log('Disconnect');
    });
});

server.listen( port, function () {
    console.log( 'Express server listening on port ' + server.address().port );
} );
