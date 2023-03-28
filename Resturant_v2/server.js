const express = require('express');
const app = express();
const bodyParser = require('body-parser')
const socketIO = require('socket.io')
const cors = require('cors')

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({extended:true}))
app.use(cors())


const server = app.listen(3000, () => {
    console.log('server is running....')
})

const io = socketIO(server, {
    cors: {
      origin: "*",
      methods: ["GET", "POST"]
    }
  });

io.on('connection', (socket) => {
    console.log('client socket connected')
    socket.on('order', (response) => {
        console.log(response)
        io.sockets.emit('cooking', response);
        io.sockets.emit('bars', response);
    })
    socket.on('call_order', (response) => {
      console.log(response)
      io.sockets.emit('showTable', response)
    })

    socket.on('submit_success', (response) => {
      console.log(response)
      io.sockets.emit('successOrder_co_dr', response)
    })
})

