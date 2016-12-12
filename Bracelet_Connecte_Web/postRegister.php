<?php
$servername = "localhost";
$username = "id190800_pouchopa";
$password = "azerty1234";
$dbname = "id190800_iot";

//Création utilisation dans la BDD
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $pdo->prepare("INSERT INTO users (email, password, device, name) VALUES('" . $_POST['email'] . "', '" . $_POST['password'] . "', '" . $_POST['device'] . "', '" . $_POST['name'] ."')");
    $sth->execute();
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;

//Redirection accueil
header('Location: index.php');
?>
