<?php

require_once 'WebsocketClient.php';

$mode = "RAWDATA";

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$address = '192.168.137.1';
$port = 8080;

$sock = null;

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

// Create an instance of the WebSocket Client


$msgsock = socket_accept($sock);

class My extends Thread {

    protected $msgsock;

    public function __construct($msgsock){
        $this->msgsock = $msgsock;
    }

    public function run() {

        // echo "Starting Thread 1";

        while(true){

            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);

            socket_write($this->msgsock, $line, strlen($line));

            // if (trim($line) == 'U'){
            //     Echo "Receeived";
            //     socket_write($this->msgsock, 'U', strlen('U'));

            //     $buf2 = socket_read($this->msgsock, 2048, PHP_NORMAL_READ);

            //     $flag = true;


            //     while($flag){
            //         if($buf2 == 'AR_MU'){
            //             socket_write($this->msgsock, 'U', strlen('U'));
            //         } else {
            //             $flag = false;
            //         }
            //     }

            // } 

            // else if (trim($line) == 'R'){
            //     Echo "Receeived";
            //     socket_write($this->msgsock, 'R', strlen('R'));
            // } 
        }
    }
}


class My2 extends Thread {

    protected $msgsock;

    public function __construct($msgsock){
        $this->msgsock = $msgsock;

    }

    public function run() {

        $deviceWSC = new WebsocketClient;
        $deviceWSC->connect('192.168.137.1', 8085, '/demo', 'foo.lh');

        // echo "Starting Thread 2";
            /* Send instructions. */
            // $msg = 'U';
            // socket_write($msgsock, $msg, strlen($msg));
            // echo "Writing $msg to $msgsock";

            do {

                if (false === ($buf = socket_read($this->msgsock, 2048, PHP_NORMAL_READ))) {
                    echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($this->msgsock)) . "\n";
                    break 2;
                }
                if (!$buf = trim($buf)) {
                    continue;
                }
                if ($buf == 'quit') {
                    break;
                }
                if ($buf == 'shutdown') {
                    socket_close($this->msgsock);
                    break 2;
                }

                // Send Message over network connection back to Websocket port
                // echo "THREAD BUFFER";
                $deviceWSC->sendData($buf);
                
                // echo "$buf\n";

            } while (true);

            socket_close($this->msgsock);


        // socket_close($this->socket );
    }
}


$my = new My($msgsock);
$my->start();

$my2 = new My2($msgsock);
$my2->start();



// for($i = 0; $i < $testClients; $i++)
// {
//     $clients[$i] = new WebsocketClient;
//     $clients[$i]->connect('127.0.0.1', 8000, '/demo', 'foo.lh');
// }
// usleep(5000);
// $payload = json_encode(array(
//     'action' => 'echo',
//     'data' => 'dos'
// ));
// for($i = 0; $i < $testMessages; $i++)
// {
//     $clientId = rand(0, $testClients-1);
//     $clients[$clientId]->sendData($payload);
//     usleep(5000);
// }
// usleep(5000);