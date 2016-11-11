<?php

    /* Handling of WebSocket Events */
    namespace WebSocketManager;
    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;

    class WebSocket implements MessageComponentInterface {
        
        // $address = '192.168.137.1';
        // $port = 8080;

        // if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
        //     echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        // }

        // if (socket_bind($sock, $address, $port) === false) {
        //     echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        // }

        // if (socket_listen($sock, 5) === false) {
        //     echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        // }

        protected $clients;

        // Constructor
        public function __construct() {
            echo "Hello";
            $this->clients = array();
        }

        // Invoked when a client is connected to the server
        public function onOpen(ConnectionInterface $conn) {
            $this->clients[$conn->resourceId] = $conn;
            echo "New connection! ({$conn->resourceId})\n";
            echo sprintf("Number of connected cients: %s."."\n", count($this->clients));
        }

        // Invoked when a client sends a message to the server
        public function onMessage(ConnectionInterface $from, $msg) {
            $numRecv = count($this->clients) - 1;
            echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
                , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');


            foreach ($this->clients as $key => $client) {
                // if ($from !== $client) {
                // $json = json_decode($msg,true);
                // $json['sender'] = $from->resourceId;
                $client->send($msg);


            }

            $client = $this->clients[$from->resourceId];
            $client->send("Message successfully sent to $numRecv users.");
        }

        // Invoked when a connection is disconnected from the server
        public function onClose(ConnectionInterface $conn) {
            unset($this->clients[$conn->resourceId]);
            echo "Connection {$conn->resourceId} has disconnected\n";
        }

        // Invoked when a connection error 
        public function onError(ConnectionInterface $conn, \Exception $e) {
            echo "An error has occurred: {$e->getMessage()}\n";
            $conn->close();
        }

        public function send() {

            echo "Number of Clients".count($this->clients);

            foreach ($this->clients as $key => $client) {
                // if ($from !== $client) {
                // $json = json_decode($msg,true);
                // $json['sender'] = $from->resourceId;
                $client->send("Test");
            }
            echo "Sent Message";
            
        }

    }

?>