<?php

$domain = AF_INET;
$type = SOCK_DGRAM;
$protocol = 0;

$socket = socket_create($domain, $type, $protocol);

$client_data = "Client Data";
$length = strlen($client_data) ;
$flags = 0;
$server_address = "127.0.0.1";
$server_port = 5555;

socket_sendto($socket, $client_data, $length, $flags, $server_address, $server_port);
socket_recvfrom($socket, $server_data, $length, $flags, $server_address, $server_port);

echo "Recieved from: '$server_address:$server_port' the following data: \n $server_data";

socket_close($socket);
