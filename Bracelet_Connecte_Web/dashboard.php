<?php 
include "dates.php";
session_start();
//echo "UserId : " . $_SESSION['userId'] . " email : " . $_SESSION['userEmail'] . " device : " . $_SESSION['userDevice'] . " name : " . $_SESSION['name'];
?>

<!DOCTYPE html5>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Bracelet Connecté</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcDE8rQKpqH6g9wdOJMXOQstjFEKuW0Eo" type="text/javascript"></script>

    <script type="text/javascript" src="script.js"></script>

  </head>

  <body onload="load()">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <a class="navbar-brand" href="#">Bracelet Connecté</a>
          <ul class="nav navbar-nav navbar-right">
           <li><a href="logout.php">Se déconnecter</a></li>
         </ul>
        <div>
      </div><!-- /.container-fluid -->
    </nav>

    <div class="col-sm-offset-1">
      <form method="POST" action="selectDate.php" class="form-inline">
        <div class="form-group">
          <label for="device"> Date : </label>
          <select class="form-control" id="date" name="date">
            <option value="">Date de l'exercice</option>
            <?php foreach($dates as $date){ 
              if($_SESSION["date"] == $date["date"]) {
                echo '<option value="' . $date['date'] . '" selected>' . $date["date"] . '</option>';
              } else {
                echo '<option value="' . $date['date'] . '">' . $date["date"] . '</option>';
              }
            } ?>
          </select>
  	    </div>
        <button type="submit" class="btn btn-default">Sélectionner</button>
      </form>
    </div>
    <div id="map" style="width: 75%; height: 75%; margin: 0 auto;"></div>
    <br />

    <div class="col-sm-10 col-sm-offset-1">
      <table class="table table-hover">
        <thead>
          <th>Latitude</th>
          <th>Longitude</th>
          <th>Date</th>
      	</thead>
        <tbody id="txtHint">
        </tbody>
      </table>
    </div>
  </body>
</html>