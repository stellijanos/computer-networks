<?php

$s = socket_create(AF_INET, SOCK_DGRAM, 0);
socket_bind($s, '0.0.0.0', 5555);
socket_recvfrom($s, $b, 100, 0, $client_ip, $client_port);
echo "Recieved $b from ip=$client_ip : $client_port";


$array = json_decode($b, true);

$sum  = $array['num1'] + $array['num2'];

echo '<br> Sum = '. $sum ;

socket_sendto($s, "Sum = ".$sum, 5, 0, $client_ip, $client_port);
