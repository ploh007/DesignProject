<?php

$host = '192.168.137.1'; //host
$port = '8080'; //port
$null = NULL; //null var

//Create TCP/IP sream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//reuseable port
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

//bind socket to specified host
socket_bind($socket, 0, $port);

//listen to port
socket_listen($socket);

//create & add listning socket to the list
$clients = array($socket);

$arduinoID = array();

//start endless loop, so that our script doesn't stop
while (true) {
    //manage multipal connections
    $changed = $clients;
    //returns the socket resources in $changed array
    socket_select($changed, $null, $null, 0, 10);
    
    //check for new socket
    if (in_array($socket, $changed)) {
        $socket_new = socket_accept($socket); //accpet new socket
        $clients[] = $socket_new; //add socket to client array
        
        $header = socket_read($socket_new, 1024); //read data sent by the socket

        // echo "Header Data:".$header;

        $query = "GET";
        if (substr($header, 0, strlen($query)) === $query){
            echo "\n Connection is a Websocket Connection";
            perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake
            socket_getpeername($socket_new, $ip); //get ip address of connected socket
            $response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' connected'))); //prepare json data
            send_message($response); //notify all users about new connection
            print_r($clients);
        } else {
            echo "\n Connection is a Arduino Connection";
            echo "Socket Details:".$socket_new."\n";
            array_push($arduinoID,$socket_new);
            print_r($arduinoID);
            print_r($clients);
        }
        
        //make room for new socket
        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
    }
    
    //loop through all connected sockets
    foreach ($changed as $changed_socket) { 

        //check for any incomming data
        while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
        {
            echo "Receving message".$buf."\n";
            // $received_text = unmask($buf); //unmask data
            if(str_replace(PHP_EOL, '', $buf) != ""){

                $response_text = "";

                if(in_array($changed_socket, $arduinoID)){
                    $response_text = $buf;
                    echo "Received Message from Arduino : ".$response_text."\n";
                    socket_write($changed_socket,"C",strlen("C"));
                    // send_message($response_text); //send data
                } else {
                    $response_text = unmask($buf);

                    if(substr($response_text, 0, strlen("C")) === "C"){
                        $response_text = 'C';
                        echo "Attempting to send Message to Arduino \n";
                        send_Arduino($response_text);
                    }

                    else if(substr($response_text, 0, strlen("U")) === "U"){
                        $response_text = 'U';
                        echo "Attempting to send Message to Arduino \n";
                        send_Arduino($response_text);
                    }

                    else if(substr($response_text, 0, strlen("R")) === "R"){
                        $response_text = 'R';
                        echo "Attempting to send Message to Arduino \n";
                        send_Arduino($response_text);
                    }

                    echo "Received Message from Client : ".$response_text."\n";
                    
                }

                


                // $tst_msg = json_decode($received_text); //json decode 
                // $user_name = $tst_msg->name; //sender name
                // $user_message = $tst_msg->message; //message text
                // $user_color = $tst_msg->color; //color
                
                // //prepare data to be sent to client
                // $response_text = mask(json_encode(array('type'=>'usermsg', 'name'=>$user_name, 'message'=>$user_message, 'color'=>$user_color)));
                // $response_text = mask(json_encode(array('type'=>'usermsg')));
                // sleep(2);
                
                
            }

            break 2; //exist this loop
        }
        
        if(!in_array($changed_socket, $arduinoID)){
            if(socket_recv($changed_socket, $buf, 1024, 0) < 1){
                // remove client for $clients array
                $found_socket = array_search($changed_socket, $clients);
                socket_getpeername($changed_socket, $ip);
                unset($clients[$found_socket]);

                echo "Client Disconnected".$changed_socket."\n";
                
                //notify all users about disconnected connection
                // $response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
                // send_message($response);
            }
        } else {
            $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
            if($buf === false){
                // remove client for $clients array
                $found_socket = array_search($changed_socket, $clients);
                socket_getpeername($changed_socket, $ip);
                print_r($clients);
                echo "TEST 4";
                unset($clients[$found_socket]);
                echo "TEST 4";
                print_r($clients);
                echo "TEST 4";      
                print_r($arduinoID);
                $found_socket = array_search($changed_socket, $arduinoID);
                unset($arduinoID[$found_socket]);
                echo "TEST 4";
                print_r($arduinoID);

                echo "Arduino Disconnected".$changed_socket."\n";
                
                //notify all users about disconnected connection
                // $response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
                // send_message($response);
            } 
        }
    }
}

// close the listening socket
socket_close($socket);

function send_message($msg)
{
    global $clients;

    global $arduinoID;

    foreach($clients as $changed_socket)
    {
        if (!in_array($changed_socket, $arduinoID)){
            socket_write($changed_socket,$msg,strlen($msg));
            echo "Sending Message to Client : ".$msg." to $changed_socket \n";
        } 
    }
    return true;
}

function send_Arduino($msg)
{
    global $clients;

    global $arduinoID;

    foreach($arduinoID as $changed_socket){
        socket_write($changed_socket,$msg,strlen($msg));
        echo "Sending Message to Arduino : ".$msg." to $changed_socket \n";
    }
    return true;
}


//Unmask incoming framed message
function unmask($text) {
    $length = ord($text[1]) & 127;
    if($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    }
    elseif($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    }
    else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}

//Encode message for transfer to client.
function mask($text)
{
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);
    
    if($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header.$text;
}

//handshake new client.
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach($lines as $line)
    {
        $line = chop($line);
        if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
        {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    //hand shaking header
    $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
    "Upgrade: websocket\r\n" .
    "Connection: Upgrade\r\n" .
    "WebSocket-Origin: $host\r\n" .
    "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
    "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn,$upgrade,strlen($upgrade));
}
