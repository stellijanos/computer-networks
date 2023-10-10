<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

$data = "Something";
$data_max_length ;
$special_flags = 0;
$server_ip = "127.0.0.1";
$server_port = 5555;

socket_sendto($socket, $data, $data_max_length, $special_flags, $server_ip, $server_port);

