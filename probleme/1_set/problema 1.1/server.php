<?php

$domain = AF_INET;
$type = SOCK_DGRAM;
$protocol = 0;

$socket = socket_create($domain, $type, $protocol);

$address = '0.0.0.0';
$port = 5555;

socket_bind($socket, $address, $port);

$length = 100;
$flags = 0;

socket_recvfrom($socket, $client_data, $length, $flags, $client_address, $client_port);

echo "Recieved from: '$client_address: $client_port'\n $client_data";

// additional operations 

$server_data = 'Server Data';

socket_sendto($socket, $server_data, $length, $flags, $client_address, $client_port);

