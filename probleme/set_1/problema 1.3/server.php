<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

socket_bind($socket, '0.0.0.0', 5555);

$length = 1000;
$flags = 0;
socket_recvfrom($socket, $client_data, $length, $flags, $client_address, $client_port);

echo "Recieved from: $client_address:$client_port => $client_data";

$server_data = preg_match_all('/[aeiouAEIOU]+/', $client_data, $matches);

socket_sendto($socket, $server_data, $length, $flags, $client_address, $client_port);