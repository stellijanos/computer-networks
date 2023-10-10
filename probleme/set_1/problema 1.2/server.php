<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

$address = '0.0.0.0';
$port = 5555;

socket_bind($socket, $address, $port);

$length = 1000;
$flags = 0;

socket_recvfrom($socket, $client_data, $length, $flags, $client_address, $client_port);

echo "Recieved from: $client_address:$client_port => $client_data";

$server_data = count (explode(' ', trim($client_data)));

socket_sendto($socket, $server_data, $length, $flags, $client_address, $client_port);
