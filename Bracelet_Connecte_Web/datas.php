<?php
$servername = "localhost";
$username = "id190800_pouchopa";
$password = "azerty1234";
$dbname = "id190800_iot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Insertion des données GPS en BDD envoyées par Sigfox
$sql = "INSERT INTO gps (latitude, longitude, time, date, device) VALUES ('".$_REQUEST['slot_lat']."','".$_REQUEST['slot_lon']."','".$_REQUEST['time']."','".$_REQUEST['time']."','".$_REQUEST['device']."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
