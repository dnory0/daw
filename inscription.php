<?php
$dbhost = "localhost";
$dbuser = "hocine";
$dbpass = "hocine";
$dbname = "daw";

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname, );
if ($connection->connect_error) die("Could not connect to the database.");

unset($dbhost);
unset($dbuser);
unset($dbpass);
unset($dbname);


// echo '$_POST[\'nom\']: ' . $_POST['nom'] . '<br>';
// echo '$_POST[\'prenom\']: ' . $_POST['prenom'] . '<br>';
// echo '$_POST[\'daten\']: ' . $_POST['daten'] . '<br>';
// echo '$_POST[\'lieun\']: ' . $_POST['lieun'] . '<br>';
// echo '$_POST[\'email\']: ' . $_POST['email'] . '<br>';
// echo '$_POST[\'pass\']: ' . $_POST['pass'] . '<br>';
// echo '$_POST[\'tel\']: ' . $_POST['tel'] . '<br>';
// echo '$_POST[\'nationalite\']: ' . $_POST['nationalite'] . '<br>';
// echo '$_POST[\'pays\']: ' . $_POST['pays'] . '<br>';
// echo '$_POST[\'adresse\']: ' . $_POST['adresse'] . '<br>';
// echo '$_POST[\'lang\']: ' . $_POST['lang'] . '<br>';
// echo '$_POST[\'niveau\']: ' . $_POST['niveau'] . '<br>';
// echo '$_POST[\'diplome\']: ' . $_POST['diplome'] . '<br>';
// echo '$_POST[\'exeperionce\']: ' . $_POST['exeperionce'] . '<br>';
// echo '$_POST[\'dated\']: ' . $_POST['dated'] . '<br>';
// echo '$_POST[\'anneexeperionce\']: ' . $_POST['anneexeperionce'] . '<br>';

if (isset($_POST['nom']) && isset($_POST['prenom']) &&
    isset($_POST['daten']) && isset($_POST['lieun']) &&
    isset($_POST['email']) && isset($_POST['pass']) &&
    isset($_POST['tel']) && isset($_POST['nationalite']) &&
    isset($_POST['pays']) && isset($_POST['adresse']) &&
    isset($_POST['lang']) && isset($_POST['niveau']) &&
    isset($_POST['diplome']) && isset($_POST['dated']) &&
    isset($_POST['exeperionce']) && isset($_POST['anneexeperionce'])

  ) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $result = $connection->query("INSERT INTO etudiants VALUES(NULL, '$nom', '$prenom', '$email')");
    if (!$result) die ("Could not add user: $nom $prenom");
  }
