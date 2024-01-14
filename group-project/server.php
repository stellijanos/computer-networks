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



/**
 * 
* {"year": "2023", "semester": "1", "spec": "IG", "acad_year": "2", "group": "2", "sub_group": "2"}
 * 
 */



 function insertIntoDatabase($filters, $result) {
    $conn = connect();

    $sql = "INSERT INTO orar_studenti (year, semester, spec, acad_year, ggroup, sub_group, orar) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssss', $filters['year'], $filters['semester'], $filters['spec'], $filters['acad_year'], $filters['group'], $filters['sub_group'], $result);
    
    $stmt->execute();

    $stmt->close();
    $conn->close();
}



function getTableElement($html_content) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // Suppress HTML parsing errors
    $dom->loadHTML($html_content);
    libxml_use_internal_errors(false);
    
    // Use XPath to find all table elements
    $xpath = new DOMXPath($dom);
    return $xpath->query('//table');
}

function getHeaderRow($row) {
    $headerRows = [];
    foreach($row->getElementsByTagName('th') as $header) {
        $headerRows[] = $header->textContent;
    }
    return $headerRows;
}

function getRowData($row, $headerRow) {
    $rowData = array();
    $index = 0;
    foreach($row->getElementsByTagName('td') as $cell) {
        $rowData[$headerRow[$index]] = $cell->textContent;
        $index ++;
    }
    return $rowData;
}

function getTableData($table, $headerRow) {
    $skipHeader = true;
    $tableData = array();

    foreach($table->getElementsByTagName('tr') as $row) {
        if ($skipHeader) {
            $skipHeader = false;
            continue;
        }
        $tableData[] = getRowData($row, $headerRow);
    }
    return $tableData;
}

function getAllTables($tables, $headerRow) {
    $allTables = [];
    // $headerRow = getheaderRow($tables[0]->getElementsByTagName('tr')[0]);
    foreach( $tables as $table) {
        $allTables[] = getTableData($table, $headerRow);
    }
    return $allTables;
}


$socket = socket_create(AF_INET, SOCK_DGRAM, 0);

socket_bind($socket, '0.0.0.0', 5555);


while (true) {

    socket_recvfrom($socket, $client_data, 50000, 0, $client_address, $client_port);

    echo "Recieved from $client_address:$client_port => $client_data";

    $filters = json_decode($client_data,true);

    $filters['token']= 'jancsika_api';

    // ------------------------------------------------------------

    $url = 'https://www.cs.ubbcluj.ro/files/orar/'.$filters['year'].'-'.$filters['semester'].'/tabelar/'.$filters['spec'].$filters['acad_year'].'.html';

    // $url = 'https://www.cs.ubbcluj.ro/files/orar/2022-1/tabelar/IG1.html';


    $html_content = @file_get_contents($url);
    if ($html_content === false ) {

        $jsonArray = json_encode([]);
    
        // die("Failed to fetch HTML content from the URL.");
    } else {
        $tables = getTableElement($html_content);

        if ( $tables->length <=0 || $filters['group'] > $tables->length) {
            echo "[]";
            exit();
        }
        
        $headerRow = getheaderRow($tables[0]->getElementsByTagName('tr')[0]);
        $table = $tables->item($filters['group']-1);
        
        $result = getTableData($table, $headerRow);
        
        $jsonArray = json_encode($result, JSON_PRETTY_PRINT);

        insertIntoDatabase($filters, $jsonArray);

    }

    // ------------------------------------------------------------

    $server_data = $jsonArray;

    socket_sendto($socket, $server_data, 50000, 0, $client_address, $client_port);
}
