<?php

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

socket_bind($socket, '0.0.0.0', 5555);

socket_recvfrom($socket, $client_data, 1000, 0, $client_address, $client_port);

echo "Recieved from $client_address:$client_port => $client_data";

$wordsArray = explode(' ',$client_data);

$mostNrOfVowels = 0;

foreach($wordsArray as $word) {
    $nrVowels = preg_match_all('/[bcdfghjklmnpqrstvwxyz]/i', $word, $mathes);
    if ( $nrVowels > $mostNrOfVowels) {
        $mostNrOfVowels = $nrVowels;
    }
}

socket_sendto($socket, $mostNrOfVowels, 1000, 0, $client_address, $client_port);