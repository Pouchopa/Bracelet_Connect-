<?php
session_start(); 
//Insertion date en session
$_SESSION["date"] = $_POST['date'];
//Redirection tableau utilisateur
header('Location: dashboard.php');
