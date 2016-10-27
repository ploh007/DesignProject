<?php
/**
* PHP Script to initiate WebSocket to start a server and
* setup a Websocket.
*
* @category Network_Connections
* @package  Network
* @author   Paul Loh <ploh007@uottawa.com>
* @author   Jordan Hatcher <jordan@jordan.com>
* @license  MIT License
* @version  1.0
* @link     GitHub_Link
*/

require __DIR__ . '/../../vendor/autoload.php';
require 'WebSocket.php';
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use WebSocketManager\WebSocket;

/**
* Create an instance of the Web server with the WebSocket
*/
$server = IoServer::factory(new WsServer(new WebSocket()), 8080);

/**
* Run the server and start listening for incoming connections
*/
$server->run();
