<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

$server_port = 5555;

socket_bind($socket, '0.0.0.0', $server_port);

socket_recvfrom($socket, $client_data, 1000, 0, $client_address, $client_port);

echo "Recieved from $client_address:$client_port => $client_data";

$client_data = json_decode($client_data, true);

function sumOfDigits($number) {
    $sum = 0;
    while ($number > 0) {
        $sum += $number % 10;
        $number /=10;
    }
    return $sum;
}


$server_data = sumOfDigits($server_port) + $client_data;

socket_sendto($socket, $server_data, 1000, 0, $client_address, $client_port);