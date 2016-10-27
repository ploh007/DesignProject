<?php
/**
* Contains the WebSocket Class and the necesary statements.
*
* @category Network_Connections
* @package  Network
* @author   Paul Loh <ploh007@uottawa.com>
* @author   Jordan Hatcher <jordan@jordan.com>
* @license  MIT License
* @version  1.0
* @link     GitHub_Link
*/

namespace WebSocketManager;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
* Websocket Class for managing websocket connections to the application
*
* @category Network_Connections
* @package  Network
* @author   Paul Loh <ploh007@uottawa.com>
* @author   Jordan Hatcher <jordan@jordan.com>
* @license  MIT License
* @version  1.0
* @link     GitHub_Link
*/
class WebSocket implements MessageComponentInterface
{
    protected $clients;

    /**
    * Constructor for initializing a WebSocket Object
    */
    public function __construct()
    {
        $this->clients = array();
    }

    /**
    * Invoked when a client is connected to the server
    *
    * @param ConnectionInterface $conn A Connection Interface object.
    *
    * @return Prints out the connection resourceId and the total number of connected clients.
    */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})\n";
        echo sprintf("Number of connected cients: %s."."\n", count($this->clients));
    }

    /**
    * Invoked when a client sends a message to the server
    *
    * @param ConnectionInterface $from A Connection Interface object.
    * @param string              $msg  The message to send to other active connections.
    *
    * @return Prints out the message to be sent and sends them to all active clients which are connected.
    */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $key => $client) {
            // if ($from !== $client) {
                // $json = json_decode($msg,true);
                // $json['sender'] = $from->resourceId;
                $client->send($msg);
            // }
        }

        $client = $this->clients[$from->resourceId];
        $client->send("Message successfully sent to $numRecv users.");
    }

    /**
    * Invoked when a client closes its connection with the server.
    *
    * @param ConnectionInterface $conn A Connection Interface object.
    *
    * @return Removes the connection from the list of clients and prints out the client id which disconnected.
    */
    public function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
    * Invoked when an error occurs to the connection.
    *
    * @param ConnectionInterface $conn A Connection Interface object.
    * @param Exception           $e    The Exception which was thrown.

    * @return Prints out the error which had occurred and closes the connection.
    */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
