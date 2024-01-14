<?php

$socket = socket_create(AF_INET, SOCK_STREAM, 0);

socket_bind($socket, '0.0.0.0', 9999);
 
socket_listen($socket);

$client_socket = socket_accept($s);

// $socket_send($client_data, "Hello", 5, 0);