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

$mode = '';
$modeFlag = '';

// Create a list to add arduino devices to
$socketClients = array();

$completeCalibFlag = false;
$completeCalibCount = 0;
$calibDataString = "";

$completeCalibFlag = false;
$completeUserCount = 0;
$userDataString = "";


while (true) {
    // Manage multiple socket connections
    $changed = $clients;

    // socket_select() accepts arrays of sockets and waits for them to change status
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
                    if (strpos($buf, "AR_MC") !== false) {
                        $response_text = "AR_MC";
                        $modeFlag = true;
                    } else if (strpos($buf, "AR_MR") !== false) {
                        $response_text = "AR_MR";
                        $modeFlag = true;
                    } else if (strpos($buf, "AR_MU") !== false) {
                        $response_text = "AR_MU";
                        $modeFlag = true;
                    } else if ($modeFlag == false && $mode == "CALIB") {
                        send_socketClients('C');
                    } else if ($modeFlag == false && $mode == "USER") {
                        send_socketClients('U');
                    } else if ($modeFlag == false && $mode == "RAW") {
                        send_socketClients('R');
                    } else if (($mode == "CALIB") && ($modeFlag == true)) {
                        // $intArray = binaryToIntArray($buf);
                        // echo "RECEVIED CALIBRATION DATA with length:" + count($intArray);
                        // print_r($intArray);
                        // vardump($intArray);

                        if (strpos($buf, "TOOLOW") !== false) {
                            send_websocketClients(mask("AR_C0"));
                        } else {
                            $calibDataString .= $buf.";";
                            if ($completeCalibCount == 2) {
                                $completeCalibCount = 0;

                                // Do Database stuff
                                send_websocketClients(mask("AR_C1:$calibDataString"));
                                $calibDataString = "";
                            } else {
                                $completeCalibCount++;
                            }
                        }
                    } else if (($mode == "USER") && ($modeFlag == true)) {
                        $userDataString .= $buf.";";
                        if ($completeUserCount == 2) {
                            $completeUserCount = 0;

                            // Do Database stuff
                            send_websocketClients(mask("AR_U:$userDataString"));
                            $userDataString = "";
                        } else {
                            $completeUserCount++;
                        }
                    }

                    // echo "Received Message from Arduino: ".$buf."\n";
                    $response_text = mask($buf);
                    send_websocketClients($response_text);

                } else {
                    $response_text = unmask($buf);

                    if (substr($response_text, 0, strlen("C")) === "C") {
                        $response_text = 'C';
                        $modeFlag = false;
                        $mode = "CALIB";
                        // echo "Attempting to send Message to Arduino \n";
                        send_socketClients($response_text);
                    } else if (substr($response_text, 0, strlen("U")) === "U") {
                        $response_text = 'U';
                        $modeFlag = false;
                        $mode = "USER";
                        // echo "Attempting to send Message to Arduino \n";
                        send_socketClients($response_text);
                    } else if (substr($response_text, 0, strlen("R")) === "R") {
                        $response_text = 'R';
                        $modeFlag = false;
                        $mode = "RAW";
                        // echo "Attempting to send Message to Arduino \n";
                        send_socketClients($response_text);
                    } else if (substr($response_text, 0, strlen("M")) === "M") {
                        $response_text = 'M';
                        // echo "Attempting to send Message to Arduino \n";
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

                // echo "Web Socket Client: ".$changed_socket." disconnected \n";
            }
        } else {
            $buf = socket_read($changed_socket, 384, PHP_BINARY_READ);

            if ($buf === false) {
                // Remove client from clients array
                $found_socket = array_search($changed_socket, $clients);
                unset($clients[$found_socket]);

                // Remove client from the socket clients
                $found_socket = array_search($changed_socket, $socketClients);
                unset($socketClients[$found_socket]);

                // echo "Socket Client: ".$changed_socket." disconnected \n";
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
            // echo "Sending Message to Client : ".$msg." to $changed_socket \n";
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
        // echo "Sending Message to Arduino : ".$msg." to $changed_socket \n";
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

function binaryToIntArray($buf)
{
    $intArray = array();

    for ($i = 0; $i < strlen($buf); $i+=2) {
        $unsignedVal = (ord($buf[$i]) << 8) | ord($buf[$i+1]);
        $signBit = $unsignedVal & 0x8000;

        if ($signBit != 0) {
            if (PHP_INT_SIZE == 8) {
                $signBit = 0xFFFFFFFFFFFF0000;
            } else {
                $signBit = 0xFFFF0000;
            }
        }

        echo $unsignedVal;

        $signedVal = $signBit | $unsignedVal;
        array_push($intArray, $signedVal);
    }
    return $intArray;
}

// Encode message for transfer to client
function mask($text)
{
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);
    
    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length > 125 && $length < 65536) {
        $header = pack('CCn', $b1, 126, $length);
    } elseif ($length >= 65536) {
        $header = pack('CCNN', $b1, 127, $length);
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
