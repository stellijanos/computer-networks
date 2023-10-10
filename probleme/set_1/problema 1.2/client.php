<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

$client_data = "Heute ist Montag, die Sonne scheint nicht. ";
$length = 1000;
$flags = 0;
$server_address = "127.0.0.1";
$server_port = 5555;

socket_sendto($socket, $client_data, $length, $flags, $server_address, $server_port);

socket_recvfrom($socket, $server_data, $length, $flags, $server_address, $server_port);

echo "Recieved from: '$server_address:$server_port' => \n Result: Total number of words in '$client_data' is $server_data";
