<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

socket_bind($socket, '0.0.0.0', 5555);

socket_recvfrom($socket, $client_data, 1000, 0, $client_address, $client_port);

echo "Recieved from $client_address:$client_port => $client_data";

$client_data = json_decode($client_data, true);

$server_data = array_sum($client_data);

socket_sendto($socket, $server_data, 1000, 0, $client_address, $client_port);