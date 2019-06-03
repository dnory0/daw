<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Vérification</title>
  <style>
    @font-face {
      font-family: "cairo";
      src: url('fonts/Cairo-SemiBold.ttf')
    }

    * {
      font-family: "cairo";
    }

    body {
      margin: 0;
    }

    body>div#main {
      text-align: center;
      height: 100vh;
      padding: 50px;
    }

    div.return {
      margin-top: 50px;
    }

    div#note {
      text-align: left;
      max-width: 500px;
      min-width: 400px;
      margin: auto;
      margin-top: 26px;
      border-left: 5px #ff5516 solid;
      padding: 20px 10px;
      background-color: #edf7c4;
    }

    a {
      text-decoration: none;
      color: black;
      padding: 2px 10px;
      margin: 36px 0 0;
      border-radius: 6px;
      border: 1px solid #0006;
      background-color: #f6f6f6;
    }

    a:hover {
      background-color: #e6e6e6;
    }
  </style>
</head>

<body>
<?php
require_once 'root.php';
$success = false;

if (isset($_POST['nom']) && isset($_POST['prenom']) &&
    isset($_POST['daten']) && isset($_POST['lieun']) &&
    isset($_POST['email']) && isset($_POST['pass']) &&
    isset($_POST['tel']) && isset($_POST['nationalite']) &&
    isset($_POST['pays']) && isset($_POST['adresse']) &&
    isset($_POST['lang']) && isset($_POST['niveau']) &&
    isset($_POST['diplome']) && isset($_POST['dated'])
  ) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $daten = $_POST['daten'];
    $lieun = $_POST['lieun'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $tel = $_POST['tel'];
    $nationalite = $_POST['nationalite'];
    $pays = $_POST['pays'];
    $adresse = $_POST['adresse'];
    $lang = $_POST['lang'];
    $niveau = $_POST['niveau'];
    $diplome = $_POST['diplome'];
    $dated = $_POST['dated'];
    // les champs de experience et anneexperience ne sont pas obliguatoires.
    if (isset($_POST['experience']) && isset($_POST['anneexperience'])) {
      // on utilisée plus tard.
      $experience = $_POST['experience'];
      $anneexperience = $_POST['anneexperience'];
    }
    // check email and phone number if already exist in our database: stop registration, else continue.
    $result = $connection->query("SELECT mat FROM etudiant WHERE email='$email' OR tel='$tel'");
    if (!$result->num_rows) {
      // insert new user.
      $result = $connection->query("INSERT INTO etudiant VALUES(
        NULL, '$nom', '$prenom', '$daten', '$lieun', '$email', '$pass', '$tel', '$nationalite',
        '$pays', '$adresse', '$lang', '$niveau', 'att', 1
      )");
      if ($result) {
        // inserting new user successfully.
        $success = true;
        $successmsg = <<< _SUCCESS_MSG
        <div>Félicitations $nom! Votre compte a été créé.</div>
        <div id="note">
          <span style="background-color: #ff5516;">&nbsp;Note:&nbsp;</span>
          &nbsp;Cet compte va être supprimer automatiquement si vous avez été réfusés
          ou après la réalisation de concours.
        </div>
_SUCCESS_MSG;
      } else {
        // inserting new user failed.
        $success = false;
        $failmsg = <<< _FAIL_MSG
          <div>Désolé, on a un problème unconnue pour le moment, reéssayer après un moment.</div>
_FAIL_MSG;
      }
    } else {
      // email/tel already exists on the database.
      $success = false;
      $failmsg = <<< _FAIL_MSG
        <div>Désolé, cet e-mail ou/et téléphone a déjà utilisé.</div>
_FAIL_MSG;
    }
  } else {
    // didn't enter all required informations.
    $success = false;
    $failmsg = <<< _FAIL_MSG
      <div>Désolé, vous devez remplir tous les informations nécessaire pour l'inscription .</div>
_FAIL_MSG;
  }

if ($success) {
  echo <<< _BEGIN
    <div id="main" style="background-color: #deffe0;">
      <div><img src="img/success.png" alt="Success" style="width: 180px;"></div>
_BEGIN;
  echo $successmsg;
  echo <<< _END
      <div class="return"><a href=".">returnez à la page principale</a></div>
    </div>
_END;
} else {
  echo <<< _BEGIN
    <div id="main" style="background-color: #fff5f1;">
      <div><img src="img/fail.png" alt="Failed" style="width: 180px;"></div>
_BEGIN;
  echo $failmsg;
  echo <<< _END
      <div class="return"><a href="inscription-etudiant.html">returnez à la page d'inscription</a></div>
    </div>
_END;
}
?>
</body>

</html>