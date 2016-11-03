<?php


require_once 'WebsocketClient.php';


error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$address = '192.168.137.1';
$port = 8080;

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

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


// Create an instance of the WebSocket Client
$deviceWSC = new WebsocketClient;
$deviceWSC->connect('192.168.137.1', 8085, '/demo', 'foo.lh');
// $deviceInitData = json_encode(array(
//     'data' => 'DEVICE_001'
// ));
$deviceWSC->sendData('DEVICE_001');

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }
    /* Send instructions. */
    $msg = 'U';
    socket_write($msgsock, $msg, strlen($msg));

    echo "Writing $msg to $msgsock";

    do {
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }
        if (!$buf = trim($buf)) {
            continue;
        }
        if ($buf == 'quit') {
            break;
        }
        if ($buf == 'shutdown') {
            socket_close($msgsock);
            break 2;
        }
        // $talkback = "U";

        // echo "$msgsock : $buf \n";

        // for($i=0; $i<20; $i++){
            // $msg = 'U';
            // socket_write($msgsock, $msg, strlen($msg));
            // echo "Writing $msg to $msgsock";
        // }

        // Send Message over network connection back to Websocket port
        $deviceWSC->sendData($buf);

        // socket_write($msgsock, $talkback, strlen($talkback));
        // echo "$buf\n";
    } while (true);
    socket_close($msgsock);
} while (true);

socket_close($sock);
?>