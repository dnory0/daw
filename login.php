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

    /********* wrong email/password **********/
    body>div#main {
      text-align: center;
      height: 100vh;
      padding: 50px;
    }

    div.return {
      margin-top: 50px;
    }

    .return>a, [type="submit"] {
      text-decoration: none;
      color: black;
      padding: 2px 10px;
      margin: 36px 0 0;
      border-radius: 6px;
      border: 1px solid #0006;
      background-color: #f6f6f6;
    }

    .return>a:hover, [type="submit"]:hover {
      background-color: #e6e6e6;
    }
    /*******************************/
    table {
      border:  1px solid;
      border-collapse: collapse;
      width: 100%;
    }

    td {
      text-align: center;
    }

    tr>th:nth-child(even),
    tr>td:nth-child(even) {
      background-color: #e9e9e9;
    }

    tr>th:not(:nth-child(even)),
    tr>td:not(:nth-child(even)) {
      background-color: #fff;
    }

    input:not([type='submit']) {
      height: 28px;
      width: 130px;
      margin: 10px 0;
    }

    #select-conc {
      margin-bottom: 30px;
    }

    select {
      height: 36px;
    }
  </style>
</head>
<body>
  
<?php
// session_start();
require_once 'root.php';

// echo isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['type']);

if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['type'])) {
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $type = $_POST['type'];
  
  // to set title depending on the type of visitor
  $title = $type === "etudiant"? "Panneau de l'&eacute;tudiant" : "Panneau de l'administrateur";
  echo "<script>document.title = \"$title\"</script>";
  unset($title);
  
  
  // echo "SELECT * FROM $type WHERE email='$email' AND pass='$pass'";
  if ($type == 'etudiant') {
  $result = $connection->query("SELECT etudiant.nom, etudiant.prenom, 
   concours.d_insc_debut, concours.d_insc_fin,concours.d_passe_conc, 
    concours.d_doc, concours.d_resu_conc, concours.d_fin, concours.theme,
     etudiant.etat, etudiant.note FROM etudiant INNER JOIN concours WHERE
      etudiant.conc_id = concours.conc_id AND etudiant.email='$email' AND
       etudiant.pass='$pass'");


    if ($result->num_rows) {

    echo <<< _NAV
<nav>
  <a href="./"><img src="img/home.png" alt="home"></a>
</nav>
_NAV;
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
  <h2 id="page-header">Panneau de l'&eacute;tudiant</h2>
  <div id="basic-infos">
    <div id="basic-infos-inner">
      <header>Vos informations:</header>
      <div>Nom: $nom</div>
      <div>Pr&eacute;nom(s): $prenom</div>
      <div>Th&egrave;me: $theme</div>
    </div>
  </div>
  <div id="etat">
    <div id="etat-inner">
      <header>Votre &eacute;tat actuel:</header>
      <div class="etat">
        <img class="etat-img" src="img/success.png" alt="">
        <div class="etat-desc">
          Votre inscription est r&eacute;ussie.<br>
          Passer &agrave; l'&eacute;tape suivante.
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
          Prendre vos documents n&eacute;cessaires.<br>
          Passer &agrave; l'&eacute;tape suivante.
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
          Prendre vos documents n&eacute;cessaires.
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
          Les documents ont &eacute;t&eacute; &eacute;tudi&eacute;s et accept&eacute;s.<br>
          Passer &agrave; l'&eacute;tape suivante.
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
          Les documents ont &eacute;t&eacute; &eacute;tudi&eacute;s mais refus&eacute;s.
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
          Les documents sont en cours d'&eacute;tude.
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
          Passer &agrave; l'&eacute;tape suivante.
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
          L'affichage des r&eacute;sultats.
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
          L'affichage des r&eacute;sultats.
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
          L'affichage des r&eacute;sultats.
          <div>
            <img src="img/calendar.png" alt="" class="calender-img">
            <div>$d_resu_conc au $d_fin</div>
          </div>
        </div>
      </div>
_NOT_YET;

echo <<< _MAIN_END
    </div>
  </div>
</section>
_MAIN_END;
    } else {
      $errormsg = "E-mail/Mot de passe incorrect";
      echo <<< _ECHO
      <div id="main" style="background-color: #fff5f1;">
        <div><img src="img/fail.png" alt="Failed" style="width: 180px;"></div>
        <div>$errormsg</div>
        <div class="return"><a href="login.html">returnez &agrave; la page de connection</a></div>
      </div>
_ECHO;
    }

  } elseif ($type == 'admin') {
    $result = $connection->query("SELECT * FROM administrateur WHERE email='$email' AND pass='$pass'");
    if ($result->num_rows) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $nom = $row['nom'];
      $prenom = $row['prenom'];
    echo <<< _NAV
<nav>
  <a href="./"><img src="img/home.png" alt="home"></a>
</nav>
_NAV;
    echo <<< _MAIN_BEGIN
<section id="main">
  <h2 id="page-header">Panneau de l'administrateur</h2>

_MAIN_BEGIN;
      echo <<< _INNER_BEGIN
  <div style="padding: 20px;">
    <div>
      <h3>Ajouter un concours:</h3>
      <form method="GET" id="add-conc">
      <table>
        <tr>
          <th>Th&egrave;me:</th>
          <th>Nombre des places:</th>
          <th>Debut d'inscription:</th>
          <th>Fin d'inscription:</th>
          <th>Fin d'acceptation des documents:</th>
          <th>Date de l'&eacute;xamen:</th>
          <th>Date de r&eacute;sultat:</th>
          <th>Derni&egrave;re date d'affichage:</th>
        </tr>
        <tr>
          <td><input id="add-theme" type="text" name="theme" required></td>
          <td><input id="add-num_pl" type="number" name="num_pl" required></td>
          <td><input id="add-d_insc_debut" type="date" name="d_insc_debut" required></td>
          <td><input id="add-d_insc_fin" type="date" name="d_insc_fin" required></td>
          <td><input id="add-d_doc" type="date" name="d_doc" required></td>
          <td><input id="add-d_passe_conc" type="date" name="d_passe_conc" required></td>
          <td><input id="add-d_resu_conc" type="date" name="d_resu_conc" required></td>
          <td><input id="add-d_fin" type="date" name="d_fin" required></td>
        </tr>
      </table>
    </form>
    <div id="add-conc-msg"></div>
    <input type="submit" form="add-conc" value="Ajouter" style="margin-top: 20px; float:right;">
    <script>
      document.getElementById('add-conc').onsubmit = (e) => {
        event.preventDefault();
        conc_id = document.getElementById('concours-select').value;
        request = new XMLHttpRequest();
        theme = document.getElementById('add-theme').value;
        num_pl = document.getElementById('add-num_pl').value;
        d_insc_debut = document.getElementById('add-d_insc_debut').value;
        d_insc_fin = document.getElementById('add-d_insc_fin').value;
        d_doc = document.getElementById('add-d_doc').value;
        d_passe_conc = document.getElementById('add-d_passe_conc').value;
        d_resu_conc = document.getElementById('add-d_resu_conc').value;
        d_fin = document.getElementById('add-d_fin').value;
        request.open("GET", `ajouter-concours.php?
          theme=` + theme + `&
          num_pl=` + num_pl + `&
          d_insc_debut=` + d_insc_debut + `&
          d_insc_fin=` + d_insc_fin + `&
          d_doc=` + d_doc + `&
          d_passe_conc=` + d_passe_conc + `&
          d_resu_conc=` + d_resu_conc + `&
          d_fin=` + d_fin, true
        );
        request.onreadystatechange = function () {
          if (this.readyState == 4) {
            if (this.status == 200) {
              if (this.responseText != null) {
                let concours_space = document.getElementById('add-conc-msg');
                concours_space.innerHTML = this.responseText;
              } else alert("Communication error: No data received")
            } else alert("Communication error: " + this.statusText)
          }
        }
        request.send(null)
      }
    </script>
  </div>
  <div style="padding: 20px;">
    <h3>Modifier un concours ou les informations des &eacute;tudiants:</h3>
    <form id="select-conc">
      <select name="conc_id" id="concours-select">
        <option value="0" selected disabled>-</option>
_INNER_BEGIN;

  $result = $connection->query("SELECT conc_id, theme FROM concours");
  for ($i = 0; $i < $result->num_rows; ++$i) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $conc_id = $row['conc_id'];
    $theme = $row['theme'];
    echo "<option value='$conc_id'>$theme</option>";
  }
  echo <<< _INNER_END
        
      </select>
      <input type="submit" value="Trouver">
    </form>
    <div id="concours-space">
    </div>
    <script>
      form = document.getElementById('select-conc');
      form.onsubmit = (event) => {
        event.preventDefault();
        conc_id = document.getElementById('concours-select').value;
        request = new XMLHttpRequest();
        request.open("GET", "gestion-concours.php?conc_id=" + conc_id, true);
        request.onreadystatechange = function () {
          if (this.readyState == 4) {
            if (this.status == 200) {
              if (this.responseText != null) {
                let concours_space = document.getElementById('concours-space');
                concours_space.innerHTML = this.responseText;
                Array.from(concours_space.getElementsByTagName('script')).forEach((script) => {
                  eval(script.innerHTML);
                });

              } else alert("Communication error: No data received")
            } else alert("Communication error: " + this.statusText)
          }
        }
        request.send(null)
      }
    </script>
_INNER_END;
      for ($i = 0; $i < $result->num_rows; ++$i) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $theme = $row['theme'];
        
      }

      echo <<< _INNER
    </div>
  </div>
_INNER;
    } else {
      $errormsg = "E-mail/Mot de passe incorrect";
      echo <<< _ECHO
<div id="main" style="background-color: #fff5f1;">
  <div><img src="img/fail.png" alt="Failed" style="width: 180px;"></div>
  <div>$errormsg</div>
  <div class="return"><a href="login.html">returnez &agrave; la page de connection</a></div>
</div>
_ECHO;
    }
  }
}
?>
</body>
</html>