<?php

require_once 'root.php';
if (isset($_GET['conc_id'])) {
  // echo "<div style='background-color: red'>" . $_GET['conc_id'] . "</div>";
  $conc_id = $_GET['conc_id'];
  $result = $connection->query("SELECT * FROM concours WHERE conc_id='$conc_id'");
  $row = $result->fetch_array(MYSQLI_ASSOC);
  $theme = html_entity_decode($row['theme']);
  $num_pl = $row['num_pl'];
  $d_insc_debut = $row['d_insc_debut'];
  $d_insc_fin = $row['d_insc_fin'];
  $d_doc = $row['d_doc'];
  $d_passe_conc = $row['d_passe_conc'];
  $d_resu_conc = $row['d_resu_conc'];
  $d_fin = $row['d_fin'];
  // $result = $connection->query("SELECT * FROM etudiant WHERE conc_id='$conc_id'");
  echo <<< _BEGIN

  <div>
_BEGIN;
  echo <<< _RESPONSE

  <form method="GET" id="modify-conc">
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
        <td><input id="modify-theme" type="text" name="theme" required></td>
        <td><input id="modify-num_pl" type="number" name="num_pl" required></td>
        <td><input id="modify-d_insc_debut" type="date" name="d_insc_debut" required></td>
        <td><input id="modify-d_insc_fin" type="date" name="d_insc_fin" required></td>
        <td><input id="modify-d_doc" type="date" name="d_doc" required></td>
        <td><input id="modify-d_passe_conc" type="date" name="d_passe_conc" required></td>
        <td><input id="modify-d_resu_conc" type="date" name="d_resu_conc" required></td>
        <td><input id="modify-d_fin" type="date" name="d_fin" required></td>
      </tr>
    </table>
  </form>
  <div id="modify-conc-msg"></div>
  <input type="submit" form="modify-conc" value="Modifier" style="margin-top: 20px; float:right;">
  <script id="modify-conc-script">
    conc_tr = document.getElementById('modify-conc').children[0].children[0].children[1];
    conc_tr.children[0].children[0].value = "$theme";
    conc_tr.children[1].children[0].value = "$num_pl";
    conc_tr.children[2].children[0].value = "$d_insc_debut";
    conc_tr.children[3].children[0].value = "$d_insc_fin";
    conc_tr.children[4].children[0].value = "$d_doc";
    conc_tr.children[5].children[0].value = "$d_passe_conc";
    conc_tr.children[6].children[0].value = "$d_resu_conc";
    conc_tr.children[7].children[0].value = "$d_fin";
    document.getElementById('modify-conc').onsubmit = (e) => {
      e.preventDefault();
      conc_id = document.getElementById('concours-select').value;
      request = new XMLHttpRequest();
      theme = document.getElementById('modify-theme').value;
      num_pl = document.getElementById('modify-num_pl').value;
      d_insc_debut = document.getElementById('modify-d_insc_debut').value;
      d_insc_fin = document.getElementById('modify-d_insc_fin').value;
      d_doc = document.getElementById('modify-d_doc').value;
      d_passe_conc = document.getElementById('modify-d_passe_conc').value;
      d_resu_conc = document.getElementById('modify-d_resu_conc').value;
      d_fin = document.getElementById('modify-d_fin').value;
      request.open("GET", `modify-concours.php?
        conc_id=` + $conc_id + `&
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
              let modify_conc_msg = document.getElementById('modify-conc-msg');
              modify_conc_msg.innerHTML = this.responseText
            } else alert("Communication error: No data received")
          } else alert("Communication error: " + this.statusText)
        }
      }
      request.send(null)
    }
  </script>

_RESPONSE;
  
  echo <<< _STUDENT_BEGIN

    <div style="padding: 20px;">
      <form method="GET" id="etd" style="padding: 50px;">
        <table id="etat-etd" style="border: 1px black solid">
          <tr>
            <th>Nom:</th>
            <th>Pr&eacute;nom:</th>
            <th>&Eacute;tat:</th>
            <th>Note:</th>
          </tr>  
_STUDENT_BEGIN;
  $result = $connection->query("SELECT * FROM etudiant WHERE conc_id='$conc_id'");
  for ($i = 0; $i < $result->num_rows; ++$i) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $mat = $row['mat'];
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $etat = $row['etat'];
    $note = $row['note'];
    // echo '$note: ' . $note;
    echo <<< _TD

          <tr>
            <td><p>$nom</p></td>
            <td><p>$prenom</p></td>
            <td>
              <select name="etat-select" class="etat-select">
                <option value="att">En Attente</option>
                <option value="doc">Ses documents sont r&eacute;&ccedil;u</option>
                <option value="ref">Les documents sont r&eacute;fus&eacute;s</option>
                <option value="can">Les documents sont v&eacute;rifi&eacute;s</option>
                <option value="pas">L'examen est pass&eacute;</option>
                <option value="reu">A r&eacute;ussi</option>
                <option value="nre">&Eacute;chou&eacute;</option>
              </select>
            </td>
            <td>
              <input type="number" name="note" class="note" step="0.25">
              <input type="hidden" name="mat" value="$mat">
            </td>
            <script>
              Array.from(document.getElementsByName('etat-select')[$i].children).forEach((element) => {
                if (element.value == '$etat')
                  element.selected = true;
              });
              if('$note')
                document.getElementsByName('note')[$i].value = '$note';
            </script>
          </tr>
_TD;
  }

  echo <<< _STUDENT_END

        </table>
      </form>
    </div>
    <div id="etd-msg"></div>
    <input type="submit" form="etd" value="Mettre &agrave; jour" style="margin-top: 20px; float:right;">
    <script>
      var etatSelect = Array.from(document.getElementsByName('etat-select'));
      var note = Array.from(document.getElementsByName('note'));
      var mat = Array.from(document.getElementsByName('mat'));
      var varsString = '';
      document.getElementById('etd').onsubmit = (event) => {
        event.preventDefault();
        varsString = '';
        for (i = 0; i < etatSelect.length; i++) {
          varsString += 'etat[]=' + etatSelect[i].value +'&';
        }
        for (i = 0; i < note.length; i++) {
          varsString += 'note[]=' + note[i].value +'&';
        }
        for (i = 0; i < mat.length; i++) {
          varsString += 'mat[]=' + mat[i].value +'&';
        }
        console.log('update-etudiants.php?' + varsString.substring(0, varsString.length-1));
        request = new XMLHttpRequest();
        request.open('GET', 'update-etudiants.php?' + varsString.substring(0, varsString.length-1), true);
        request.onreadystatechange = function() {
          if (this.readyState == 4) {
            if (this.status == 200) {
              if (this.responseText != null) {
                // console.log(this.responseText)
                document.getElementById('etd-msg').innerHTML = this.responseText;
              } else alert("Communication error: No data received")
            } else alert("Communication error: " + this.statusText)
          }
        }
        request.send(null);
      }
    </script>
_STUDENT_END;

        // for ($i = 0; $i=)
//         echo <<< _STUDENT_END
//       request = new XMLHttpRequest();
//       request.open("GET", `update-etudiants.php?
//         conc_id=` + $conc_id + `&
//         theme=` + theme + `&
//         num_pl=` + num_pl + `&
//         d_insc_debut=` + d_insc_debut + `&
//         d_insc_fin=` + d_insc_fin + `&
//         d_doc=` + d_doc + `&
//         d_passe_conc=` + d_passe_conc + `&
//         d_resu_conc=` + d_resu_conc + `&
//         d_fin=` + d_fin, true
//       );
//       request.onreadystatechange = function () {
//         if (this.readyState == 4) {
//           if (this.status == 200) {
//             if (this.responseText != null) {
//               let modify_conc_msg = document.getElementById('modify-conc-msg');
//               modify_conc_msg.innerHTML = this.responseText
//             } else alert("Communication error: No data received")
//           } else alert("Communication error: " + this.statusText)
//         }
//       }
//       request.send(null)
//       }
//     </script>
// _STUDENT_END;

echo <<< _END

  </div>
_END;
}
?>