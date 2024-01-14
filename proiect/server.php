<?php

// database part

function dbConnection() {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "retele_proiect";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Something went wrong!");
    }
    return $conn;
}


function getUsers($conn) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);


    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc() ) {
            $data[] = $row;
        }
    }

    return $data;
}



function createUser($conn, $data) {
    $sql = "INSERT INTO users (firstname, ;astname, email, username)
            VALUES(?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    extract($data); // all the key value pairs will be variables 

    $stmt->bind_param("s,s,s,s", $firstname, $lastname, $email, $username);

    return $stmt->execute();
}



$conn = dbConnection();

$server_response = json_encode(getUsers($conn));



// end of database part

$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

socket_bind($socket, '0.0.0.0', 5555);

$client_address = '';
$client_port = 0;

socket_recvfrom($socket, $client_data, 4096, 0, $client_address, $client_port);

echo "Recieved from client: ".$client_data;

// $server_response = "Hello I am server man!";

socket_sendto($socket, $server_response, 2048, 0, $client_address, $client_port);

