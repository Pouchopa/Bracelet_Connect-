<?php
session_start();
$servername = "localhost";
$username = "id190800_pouchopa";
$password = "azerty1234";
$dbname = "id190800_iot";

//Requête pour savoir si l'utilisateur existe
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $pdo->prepare("SELECT id, email, password, device, name FROM users WHERE email='" . $_POST['email'] . "' AND password='" . $_POST['password'] . "'");
    $sth->execute();
    $user = $sth->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;

//Si utilisateur trouvé, création d'une session utilisateur
if(!empty($user)) {
	$_SESSION['userId'] = $user['id'];
	$_SESSION['userEmail'] = $user['email'];
	$_SESSION['userDevice'] = $user['device'];
	$_SESSION['name'] = $user['name'];
	header('Location: dashboard.php');
}
//Redirection utilisateur accueil
else {
	header('Location: index.php');
}
?>
