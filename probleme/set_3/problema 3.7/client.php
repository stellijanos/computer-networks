<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

$client_data = json_encode(['num1' => 3, 'num2' => 7, 'num3' => 5, 'num4' => 10, 'num5' => 2 ]);

socket_sendto($socket, $client_data, 1000, 0, '127.0.0.1', 5555);

socket_recvfrom($socket, $server_data, 1000, 0, $server_address, $server_port);

echo "Result from $server_address:$server_port is: $server_data";
