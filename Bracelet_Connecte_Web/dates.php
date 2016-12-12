<?php
session_start();
$servername = "localhost";
$username = "id190800_pouchopa";
$password = "azerty1234";
$dbname = "id190800_iot";

//Sélection des dates d'exercice pour un objet donné
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $pdo->prepare("SELECT date FROM gps WHERE device='" . $_SESSION['userDevice'] ."' GROUP BY date");
    $sth->execute();
    $dates = $sth->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
