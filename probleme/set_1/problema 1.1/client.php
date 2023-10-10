<?php

$domain = AF_INET;
$type = SOCK_DGRAM;
$protocol = 0;

$socket = socket_create($domain, $type, $protocol); // create socket

$client_data = "J";
$length = 100;
$flags = 0;
$server_address = "127.0.0.1";
$server_port = 5555;

socket_sendto($socket, $client_data, $length, $flags, $server_address, $server_port); // send data to server 

socket_recvfrom($socket, $server_data, $length, $flags, $server_address, $server_port);  // recieve data from server
echo "Recieved from: '$server_address:$server_port' => \n $server_data"; // print out recieved data from server
