<?php
require __DIR__ . '/../vendor/autoload.php';
require_once 'WebsocketClient.php';
include 'WebSocket.php';
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use WebSocketManager\WebSocket;

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

$address = 'localhost';
$port = 8080;

$sock = null;
// if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
//     echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
// }

// if (socket_bind($sock, $address, $port) === false) {
//     echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
// }

// if (socket_listen($sock, 5) === false) {
//     echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
// }

// $socketServer = socket_accept($sock);

$socketServer = null;
$webSocketServer = new WebSocket();
$IOServer = IoServer::factory(new WsServer($webSocketServer), 8085);

class Thread1 extends Thread {

    protected $socketServer;

    public function __construct($socketServer){
        $this->socketServer = $socketServer;
    }

    public function run() {

        $deviceWSC = new WebsocketClient;
        $deviceWSC->connect('localhost', 8085, '', '');

        do {
            sleep(5);
            // if (false === ($buf = socket_read($this->msgsock, 2048, PHP_NORMAL_READ))) {
            //     echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($this->msgsock)) . "\n";
            //     break 2;
            // }
            // if ($buf == 'shutdown') {
            //     socket_close($this->msgsock);
            //     break 2;
            // }

            // Send Message over network connection back to Websocket port
            // echo "THREAD BUFFER";
            // $deviceWSC->sendData($buf);
            $deviceWSC->sendData('TEST');
            // echo "$buf\n";

        } while (true);
    }
}

$thread1 = new Thread1($socketServer);
$thread1->start();

// Kick Off IO Server
$IOServer->run();