var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var request = require('request');

const port = process.env.PORT || 3000

var users = {};
io.on('connection',function(socket){
	socket.on("join_skt",function(id_user){
		var user_id_case;
		switch(id_user){
		case 1:
			user_id_case = '1';
		break;
		}

		socket.join(user_id_case);
		users[socket.id] = id_user;
    
		request.get("http://localhost/conference/api_carrega.php", (error, response, body) => {
			if(error) {
				return console.dir(error);
			}
      
			socket.emit(JSON.parse(body));
		});


});
http.listen(port)
