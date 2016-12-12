<?php
session_start();

$servername = "localhost";
$username = "id190800_pouchopa";
$password = "azerty1234";
$dbname = "id190800_iot";

//Sélection en BDD des latitudes et longitudes pour une date et un objet donné
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!empty($_SESSION["date"])) {
      $sth = $pdo->prepare("SELECT latitude, longitude FROM gps WHERE (date='" . $_SESSION['date'] . "' AND device='" . $_SESSION['userDevice'] ."')");
     } else {
      $sth = $pdo->prepare("SELECT latitude, longitude FROM gps WHERE (date=(SELECT MAX(date) FROM gps) AND device='" . $_SESSION['userDevice'] ."')");
    }
	$sth->execute();
	$locations = $sth->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;

//Encode the $locations array in JSON format and print it out.
header('Content-Type: application/json');
echo json_encode($locations);

?>
