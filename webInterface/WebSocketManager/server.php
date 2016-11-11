<?php
	require __DIR__ . '/../vendor/autoload.php';
	include 'WebSocket.php';
	use Ratchet\Server\IoServer;
	use Ratchet\WebSocket\WsServer;
	use WebSocketManager\WebSocket;

	// Create an instance of the webserver application
	$server = IoServer::factory(
	    new WsServer(
	        new WebSocket()
	    )
	    , 8085
	);

	echo "Server has started!";

	$server->run();

	echo "Server running";

