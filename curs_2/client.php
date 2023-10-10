<?php

$s = socket_create(AF_INET, SOCK_DGRAM, 0);
socket_sendto($s, json_encode(['num1' => 1, 'num2'=> 2]), 100, 0, "127.0.0.1", 5555);
socket_recvfrom($s, $b, 10, 0, $serv_ip, $serv_port);
echo "Recieved:  $b from $serv_ip : $serv_port";
