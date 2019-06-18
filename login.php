<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title id="title"></title>
  <style>
    @font-face {
      font-family: 'cairo';
      src: url('fonts/Cairo-SemiBold.ttf')
    }

    * {
      font-family: cairo;
    }

    body {
      margin: 0;
      background: url('img/bg.svg');
      background-size: cover;
      background-attachment: fixed;
    }

    nav {
      height: 33px;
      background-color: #50bc30;
      padding: 5px 10px;
    }

    nav>a {
      float: left;
      border: 1px solid black;
      height: 30px;
      padding: 0 20px;
    }

    nav>a:hover {
      background-color: #249318;
    }

    /* section#main {} */

    #page-header {
      padding: 30px;
      text-align: center;
    }

    #basic-infos {
      padding: 20px calc(50% - 211px);
    }

    #basic-infos-inner {
      padding: 20px;
      background-color: #fff;
      border: 1px black solid;
      width: 380px;
    }

    #etat {
      padding: 50px calc(50% - 280px);
    }

    #etat-inner {
      /* background-color: #fff; */
      /* border: 1px black solid; */
      max-width: 520px;
      min-width: 280px;
      padding: 60px;
    }

    #etat-inner>header, #basic-infos-inner>header {
      text-align: center;
      margin-bottom: 20px;
      font-size: 22px;
      font-weight: bold;
      color: #383838;
    }

    #etat-inner>header {
      text-align: center;
      margin-bottom: 40px;
      border-bottom: 3px solid #50bc30;
      border-bottom-color: rgb(80, 188, 48);
      border-bottom-style: solid;
      border-bottom-width: 3px;
     }

    .etat {
      padding: 5px;
    }

    .etat-img {
      width: 31px;
      float: left;
      background: #bdbdbd;
      border-radius: 50%;
    }

    .etat-desc {
      background-color: white;
      padding-left: 10px;
      border: 1px solid #a8a8a8;
      border-radius: 3px;
      box-shadow: 0px 0px 4px #848484;
      margin-left: 10px;
      padding: 6px;
      width: 360px;
      margin-left: 40px;
    }

    .calender-img {
      float: left;
    }
  </style>
</head>
<body>
  
<?php
// session_start();
require_once 'root.php';

// echo isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['type']);

echo <<< _NAV
<nav>
  <a href="./"><img src="img/home.png" alt="home"></a>
</nav>
_NAV;


if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['type'])
) {
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $type = $_POST['type'] === 'etudiant'? "etudiant" : "administrateur";
  
  // to set title depending on the type of visitor
  $title = $type === "etudiant"? "Panneau de l'étudiant" : "Panneau de l'administrateur";
  echo "<script>document.title = \"$title\"</script>";
  unset($title);
  
  $result = $connection->query("SELECT etudiant.nom, etudiant.prenom, 
  concours.d_insc_debut, concours.d_insc_fin,concours.d_passe_conc, 
   concours.d_doc, concours.d_resu_conc, concours.d_fin, concours.theme,
    etudiant.etat, etudiant.note FROM etudiant INNER JOIN concours WHERE
     etudiant.conc_id = concours.conc_id AND etudiant.email='$email' AND
      etudiant.pass='$pass'");

  // echo "SELECT * FROM $type WHERE email='$email' AND pass='$pass'";
  if ($result->num_rows) {

    if ($type == 'etudiant') {
      $row = $result->fetch_array(MYSQLI_ASSOC);
    // needed for 
      $nom = $row['nom'];
      $prenom = $row['prenom'];
      $theme = $row['theme'];
      $etat = $row['etat'];
      $date_doc = $row['d_doc'];
      $note = $row['note'];

    // to substract the date from concours table in the 'dd/mm/yyyy' format  
      $d_insc_debut = date('d/m/Y', strtotime($row['d_insc_debut']));
      $d_insc_fin = date('d/m/Y', strtotime($row['d_insc_fin']));
      // the acception of documents starts after 2 days of inscription end.
      $d_debut_pren_doc = date('d/m/Y', strtotime('2 day', strtotime($row['d_insc_fin'])));
      $d_fin_pren_doc = date('d/m/Y', strtotime($row['d_doc']));
      // precessing starts after 2 days of the final date of the acception of the documents.
      $d_debut_acc_doc = date('d/m/Y', strtotime('2 day', strtotime($row['d_doc'])));
      // before 7 days of the exam studiant must know if he is accepted to pass or not
      $d_fin_acc_doc = date('d/m/Y', strtotime('-7 day', strtotime($row['d_passe_conc'])));
      $d_passe_conc = date('d/m/Y', strtotime($row['d_passe_conc']));
      $d_resu_conc = date('d/m/Y', strtotime($row['d_resu_conc']));
      $d_fin = date('d/m/Y', strtotime($row['d_fin']));
      echo <<< _MAIN_BEGIN
<section id="main">
  <h2 id="page-header">Panneau de l'étudiant</h2>
  <div id="basic-infos">
    <div id="basic-infos-inner">
      <header>Vos informations:</header>
      <div>Nom: $nom</div>
      <div>Prénom(s): $prenom</div>
      <div>Thème: $theme</div>
    </div>
  </div>
  <div id="etat">
    <div id="etat-inner">
      <header>Votre état actuel:</header>
      <div class="etat">
        <img class="etat-img" src="img/success.png" alt="">
        <div class="etat-desc">
          Votre inscription est réussie.<br>
          Passer à l'étape suivante.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_insc_debut au $d_insc_fin</div>
          </div>
        </div>
      </div>
_MAIN_BEGIN;
      // if documents where brought by the student or not yet
      if (in_array($etat, array('doc', 'ref', 'can', 'pas', 'nre', 'reu')))
        echo <<< _DOC
      <div class="etat">
        <img class="etat-img" src="img/success.png" alt="">
        <div class="etat-desc">
          Prendre vos documents nécessaires.<br>
          Passer à l'étape suivante.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_debut_pren_doc au $d_fin_pren_doc</div>
          </div>
        </div>
      </div>
_DOC;
      else echo <<< _NOT_YET
      <div class="etat">
        <img class="etat-img" src="img/not-yet.png" alt="">
        <div class="etat-desc">
          Prendre vos documents nécessaires.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_debut_pren_doc au $d_fin_pren_doc</div>
          </div>
        </div>
      </div>
_NOT_YET;

      // if was accepted is candidate or toward, else if refused else is gonna be 'att'
      if (in_array($etat, array('can', 'pas', 'nre', 'reu')))
      echo <<< _CAN
      <div class="etat">
        <img class="etat-img" src="img/success.png" alt="">
          <div class="etat-desc">
          Les documents ont été étudiés et acceptés.<br>
          Passer à l'étape suivante.
        <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_debut_acc_doc au $d_fin_acc_doc</div>
          </div>
        </div>
      </div>
_CAN;
      elseif ($etat == 'ref') echo <<< _REF
      <div class="etat">
        <img class="etat-img" src="img/fail.png" alt="">
        <div class="etat-desc">
          Les documents ont été étudiés mais refusés.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_debut_acc_doc au $d_fin_acc_doc</div>
          </div>
        </div>
      </div>
_REF;
      else echo <<< _NOT_YET
      <div class="etat">
        <img class="etat-img" src="img/not-yet.png" alt="">
        <div class="etat-desc">
          Les documents sont en cours d'étude.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_debut_acc_doc au $d_fin_acc_doc</div>
          </div>
        </div>
      </div>
_NOT_YET;

      if (in_array($etat, array('pas', 'nre', 'reu')))
      echo <<< _PAS
      <div class="etat">
        <img class="etat-img" src="img/success.png" alt="">
        <div class="etat-desc">
          Passer l'examen.<br>
          Passer à l'étape suivante.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_passe_conc</div>
          </div>
        </div>
      </div>
_PAS;
      else echo <<< _NOT_YET
      <div class="etat">
        <img class="etat-img" src="img/not-yet.png" alt="">
        <div class="etat-desc">
          Passer l'examen.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_passe_conc</div>
          </div>
        </div>
      </div>
_NOT_YET;
      
      if ($etat == 'reu')
      echo <<< _REU
      <div class="etat">
        <img class="etat-img" src="img/success.png" alt="">
        <div class="etat-desc">
          L'affichage des résultats.
          <div>
            Note: $note<br>
          <div>
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_resu_conc au $d_fin</div>
          </div>
        </div>
      </div>
_REU;
      elseif ($etat == 'nre') echo <<< _NRE
      <div class="etat">
        <img class="etat-img" src="img/fail.png" alt="">
        <div class="etat-desc">
          L'affichage des résultats.
          <div>
            Note: $note<br>
          <div>
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_resu_conc au $d_fin</div>
          </div>
        </div>
      </div>
_NRE;
      else echo <<< _NOT_YET
      <div class="etat">
        <img class="etat-img" src="img/not-yet.png" alt="">
        <div class="etat-desc">
          L'affichage des résultats.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_resu_conc au $d_fin</div>
          </div>
        </div>
      </div>
_NOT_YET;

      // echo <<< _MAIN_END
// </div>
// _MAIN_END;
    } elseif ($type == 'administrateur') {
      echo 'hi';
    }
  } else {
    $errormsg = "E-mail/Mot de passe incorrect";
  } 
}
?>
</body>
</html>