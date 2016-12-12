<?php
session_start();

$servername = "localhost";
$username = "id190800_pouchopa";
$password = "azerty1234";
$dbname = "id190800_iot";

//Sélection en BDD des champs de la table GPS pour être affichées
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(!empty($_SESSION["date"])) {
      $sth = $pdo->prepare("SELECT id, latitude, longitude, time, device FROM gps WHERE (date='" . $_SESSION['date'] . "' AND device='" . $_SESSION['userDevice'] ."') ORDER BY id ASC");
     } else {
      $sth = $pdo->prepare("SELECT id, latitude, longitude, time, device FROM gps WHERE (device='" . $_SESSION['userDevice'] . "' AND date=(SELECT MAX(date) FROM gps)) ORDER BY id ASC");
    }
    $sth->execute();
    $locations = $sth->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;

//Affichage sous forme de tableau
 foreach($locations as $location){ 
 $date = new DateTime($location['time']);
//Transformation date GMT en GMT+1
 $date->setTimezone(new DateTimeZone('Europe/Paris'));	
  echo "<tr>
    <td>" . $location['latitude'] . "</td>
    <td>" . $location['longitude'] . "</td>
    <td>" . $date->format('d/m/Y H:i:s') . "</td>
  </tr>";
 }

?>
