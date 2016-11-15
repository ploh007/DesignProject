<?php
/* 
 * TCP/IP Socket + WebSocket Server
 * @author Jordan Hatcher
 * @author Paul Loh
 */

// Set up the Socket Server
$host = '192.168.137.1'; //host
$port = '8080'; //port
$null = null; //null var

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); //Create TCP/IP sream socket
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1); //reuseable port
socket_bind($socket, 0, $port); //bind socket to specified host
socket_listen($socket); //listen to port

// Create & add listning socket to the list
$clients = array($socket);

// Create a list to add arduino devices to
$socketClients = array();

while (true) {
    // Manage multiple socket connections
    $changed = $clients;

    // socket_select() accepts arrays of sockets and waits for them to change statu
    socket_select($changed, $null, $null, 0, 0);
    
    //check for new socket
    if (in_array($socket, $changed)) {
        $socket_new = socket_accept($socket); // Accept New Socket
        $clients[] = $socket_new; // Add Socket to clients array
        
        $header = socket_read($socket_new, 1024); //read data sent by the socket
        $query = "GET";
        
        // Determine if the socket connection is a WebSocket Connection or regular socket
        if (substr($header, 0, strlen($query)) === $query) {
            perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake

            // socket_getpeername($socket_new, $ip); //get ip address of connected socket
        } else {
            array_push($socketClients, $socket_new); // Regular Socket Connection
        }

        //make room for new socket
        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
    }
    
    // Loop through all connected sockets
    foreach ($changed as $changed_socket) {
        // Check for any incoming data
        while (socket_recv($changed_socket, $buf, 1024, 0) >= 1) {
            if (str_replace(PHP_EOL, '', $buf) != "") {
                $response_text = "";

                if (in_array($changed_socket, $socketClients)) {
                    $response_text = mask($buf);
                    send_websocketClients($response_text);
                } else {
                    $response_text = unmask($buf);

                    if (substr($response_text, 0, strlen("C")) === "C") {
                        $response_text = 'C';
                        echo "Attempting to send Message to Arduino \n";
                        send_socketClients($response_text);
                    } else if (substr($response_text, 0, strlen("U")) === "U") {
                        $response_text = 'U';
                        echo "Attempting to send Message to Arduino \n";
                        send_socketClients($response_text);
                    } else if (substr($response_text, 0, strlen("R")) === "R") {
                        $response_text = 'R';
                        echo "Attempting to send Message to Arduino \n";
                        send_socketClients($response_text);
                    } else if (substr($response_text, 0, strlen("M")) === "M") {
                        $response_text = 'M';
                        echo "Attempting to send Message to Arduino \n";
                        send_socketClients($response_text);
                    }
                    echo "Received Message from Client : ".$response_text."\n";
                }
            }
            break 2; // Break from the loop when no more data to receive
        }
        
        if (!in_array($changed_socket, $socketClients)) {
            if (socket_recv($changed_socket, $buf, 1024, 0) < 1) {
                // remove client for $clients array
                $found_socket = array_search($changed_socket, $clients);
                socket_getpeername($changed_socket, $ip);
                unset($clients[$found_socket]);

                echo "Web Socket Client: ".$changed_socket." disconnected \n";
            }
        } else {
            $buf = socket_read($changed_socket, 1024, PHP_BINARY_READ);
            if ($buf === false) {
                // Remove client from clients array
                $found_socket = array_search($changed_socket, $clients);
                unset($clients[$found_socket]);

                // Remove client from the socket clients
                $found_socket = array_search($changed_socket, $socketClients);
                unset($socketClients[$found_socket]);

                echo "Socket Client: ".$changed_socket." disconnected \n";
            }
        }
    }
}

// Close the listening socket
socket_close($socket);

/* Sends the message to only all the Websocket Clients */
function send_websocketClients($msg)
{
    global $clients;
    global $socketClients;

    foreach ($clients as $changed_socket) {
        if (!in_array($changed_socket, $socketClients)) {
            @socket_write($changed_socket, $msg, strlen($msg));
            echo "Sending Message to Client : ".$msg." to $changed_socket \n";
        }
    }
    return true;
}

/* Sends the message to only all the Socket Clients */
function send_socketClients($msg)
{
    global $socketClients;

    foreach ($socketClients as $changed_socket) {
        socket_write($changed_socket, $msg, strlen($msg));
        echo "Sending Message to Arduino : ".$msg." to $changed_socket \n";
    }
    return true;
}


// Unmask incoming framed message
function unmask($payload)
{
    $length = ord($payload[1]) & 127;

    if ($length == 126) {
        $masks = substr($payload, 4, 4);
        $data = substr($payload, 8);
    } elseif ($length == 127) {
        $masks = substr($payload, 10, 4);
        $data = substr($payload, 14);
    } else {
        $masks = substr($payload, 2, 4);
        $data = substr($payload, 6);
    }

    $text = '';
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}

// Encode message for transfer to client
function mask($text)
{
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);
    
    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length > 125 && $length < 65536) {
        $header = pack('CCS', $b1, 126, $length);
    } elseif ($length >= 65536) {
        $header = pack('CCN', $b1, 127, $length);
    }
    return $header.$text;
}

// Perform the appropriate handshake for the WebSocket Clients
function perform_handshaking($receved_header, $client_conn, $host, $port)
{
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach ($lines as $line) {
        $line = chop($line);
        if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    
    // WebSocket Handshaking Header
    $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
    "Upgrade: websocket\r\n" .
    "Connection: Upgrade\r\n" .
    "WebSocket-Origin: $host\r\n" .
    "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
    "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn, $upgrade, strlen($upgrade));
}

function _hybi10Encode($payload, $type = 'text', $masked = true)
{
    $frameHead = array();
    $frame = '';
    $payloadLength = strlen($payload);
    
    switch ($type) {
        case 'text':
            // first byte indicates FIN, Text-Frame (10000001):
            $frameHead[0] = 129;
            break;
    
        case 'close':
            // first byte indicates FIN, Close Frame(10001000):
            $frameHead[0] = 136;
            break;
    
        case 'ping':
            // first byte indicates FIN, Ping frame (10001001):
            $frameHead[0] = 137;
            break;
    
        case 'pong':
            // first byte indicates FIN, Pong frame (10001010):
            $frameHead[0] = 138;
            break;
    }
    
    // set mask and payload length (using 1, 3 or 9 bytes)
    if ($payloadLength > 65535) {
        $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
        $frameHead[1] = ($masked === true) ? 255 : 127;
        for ($i = 0; $i < 8; $i++) {
            $frameHead[$i+2] = bindec($payloadLengthBin[$i]);
        }
        // most significant bit MUST be 0 (close connection if frame too big)
        if ($frameHead[2] > 127) {
            $this->close(1004);
            return false;
        }
    } elseif ($payloadLength > 125) {
        $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
        $frameHead[1] = ($masked === true) ? 254 : 126;
        $frameHead[2] = bindec($payloadLengthBin[0]);
        $frameHead[3] = bindec($payloadLengthBin[1]);
    } else {
        $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
    }
    // convert frame-head to string:
    foreach (array_keys($frameHead) as $i) {
        $frameHead[$i] = chr($frameHead[$i]);
    }
    if ($masked === true) {
        // generate a random mask:
        $mask = array();
        for ($i = 0; $i < 4; $i++) {
            $mask[$i] = chr(rand(0, 255));
        }
        
        $frameHead = array_merge($frameHead, $mask);
    }
    $frame = implode('', $frameHead);
    // append payload to frame:
    $framePayload = array();
    for ($i = 0; $i < $payloadLength; $i++) {
        $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
    }
    return $frame;
}
