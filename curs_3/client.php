<?php

$socket = socket_create(AF_INET, SOCK_STREAM, 0);

socket_bind($socket, '0.0.0.0', 2562);

socket_connect($socket, '193.231.20.76', 9999);


// $send_data = "multumesc";
// socket_send($socket, $send_data, strlen($send_data), 0);

socket_recv($socket, $buffer, 20, 0);

echo $buffer."\n";

socket_close($socket);
