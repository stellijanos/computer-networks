<?php

$domain = AF_INET;
$type = SOCK_DGRAM;
$protocol = 0;

$socket = socket_create($domain, $type, $protocol); // create socket

$address = '0.0.0.0';
$port = 5555;

socket_bind($socket, $address, $port); // bind the associate address and port

$length = 100;
$flags = 0;

socket_recvfrom($socket, $client_data, $length, $flags, $client_address, $client_port); // recieve sendto data from client

echo "Recieved from: '$client_address: $client_port'\n $client_data"; // print out sendto data from client

// additional operations 

$server_data = $client_data.$client_data;

socket_sendto($socket, $server_data, $length, $flags, $client_address, $client_port); // send data (answer) to client 

