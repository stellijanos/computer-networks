<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

socket_bind($socket, '0.0.0.0', 5555);

socket_recvfrom($socket, $client_data, 1000, 0, $client_address, $client_port);

echo "Recieved from $client_address:$client_port => $client_data";

$wordsArray = explode(' ', trim($client_data));

$mostNrOfChars = 0;

foreach($wordsArray as $word) {
    if (strlen($word) > $mostNrOfChars) 
        $mostNrOfChars = strlen($word);
}

socket_sendto($socket, $mostNrOfChars, 1000, 0, $client_address, $client_port);
