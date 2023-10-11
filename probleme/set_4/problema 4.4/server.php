<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

$server_port = 5555;

socket_bind($socket, '0.0.0.0', $server_port);

socket_recvfrom($socket, $client_data, 1000, 0, $client_address, $client_port);

echo "Recieved from $client_address:$client_port => $client_data";

$client_data = json_decode($client_data, true);


$numbersAsString = [
    0 => 'zero',
    1 => 'una',
    2 => 'doua',
    3 => 'trei',
    4 => 'patru',
    5 => 'cinci',
    6 => 'sase',
    7 => 'sapte',
    8 => 'opt',
    9 => 'noua',
    10 => 'zece',
    11 => 'unsprezece',
    12 => 'doisprezece',
    13 => 'treisprezece',
    14 => 'paisprezece',
    15 => 'cincisprezece',
    16 => 'saisprezece',
    17 => 'saptesprezece',
    18 => 'optsprezece',
    19 => 'nouasprezece',
];

$number = $client_data;


if ($number < 20) {
    $server_data = $numbersAsString[$number];
} 

if ($number > 20 && $number < 100) {
    $server_data = $numbersAsString[$number / 10] . 'zeci';
    if ($number % 10 != 0) {
        $server_data .= ( ' si '.$numbersAsString[$number % 10] );
    }
}

if ($number > 99 && $number < 1000) {
    $server_data = $numbersAsString[$number / 100] . (intval($number / 100) == 1 ? ' suta ' : ' sute ' );
    $server_data .= ($numbersAsString[$number / 10 % 10] . 'zeci');
    if ($number % 10 != 0) {
        $server_data .= ( ' si '.$numbersAsString[$number % 10] );
    }
}

if ($number > 999 && $number < 10000) {
    $server_data = intval($number / 1000 == 1) ? 'O mie ' : $numbersAsString[$number/ 1000].' mii ';
    $server_data .= $numbersAsString[$number / 100 % 10] . (intval($number / 100) == 1 ? ' suta ' : ' sute ' );
    $server_data .= ($numbersAsString[$number / 10 % 10] . 'zeci');
    if ($number % 10 != 0) {
        $server_data .= ( ' si '.$numbersAsString[$number % 10] );
    }
}

$server_data = ucfirst($server_data);

socket_sendto($socket, $server_data, 1000, 0, $client_address, $client_port);