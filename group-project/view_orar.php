<?php 

function connect() {
    // dsn=data source name
    $serverName='localhost';
    $dbUserName='root';
    $dbPassword='';
    $dbName='janos_db';

    // Create connection
    $conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}



function viewAllOrar() {

    $sql ='SELECT * from orar_studenti';

    $conn = connect();

    $result = $conn->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
    }

    
}


viewAllOrar();

