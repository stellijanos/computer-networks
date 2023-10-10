<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

$client_data = readline("Enter a number max. 4 digits: ");

( is_numeric($client_data) && $client_data <= 9999 ) || $client_data = 0;

socket_sendto($socket, $client_data, 1000, 0, '127.0.0.1', 5555);

socket_recvfrom($socket, $server_data, 1000, 0, $server_address, $server_port);

echo "Result from $server_address:$server_port is: $server_data";

