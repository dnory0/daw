<?php

require_once 'root.php';

if (isset($_GET['theme']) && isset($_GET['num_pl']) &&
isset($_GET['d_insc_debut']) && isset($_GET['d_insc_fin']) &&
isset($_GET['d_doc']) && isset($_GET['d_passe_conc']) &&
isset($_GET['d_resu_conc']) && isset($_GET['d_fin'])) {
  $theme = htmlentities($_GET['theme']);
  $num_pl = $_GET['num_pl'];
  $d_insc_debut = $_GET['d_insc_debut'];
  $d_insc_fin = $_GET['d_insc_fin'];
  $d_doc = $_GET['d_doc'];
  $d_passe_conc = $_GET['d_passe_conc'];
  $d_resu_conc = $_GET['d_resu_conc'];
  $d_fin = $_GET['d_fin'];
  
  
  $result = $connection->query("SELECT * FROM concours WHERE theme='$theme'");
  if (!$result->num_rows) {
    $result = $connection->query("INSERT INTO concours VALUES(
      null,
      '$theme',
      '$num_pl',
      '$d_insc_debut',
      '$d_insc_fin',
      '$d_doc',
      '$d_passe_conc',
      '$d_resu_conc',
      '$d_fin'
    )");
    if (!$result) die("<div style='background-color: red; padding: 20px;'>On a une error d'ajouter ce concours.</div>");
    else echo "<div style='background-color: green; padding: 20px;'>Ce theme a &eacute;t&eacute; ajout&eacute;.</div>";
  } else echo "<div style='background-color: orangered; padding: 20px;'>Ce theme d&eacute;j&agrave; existe.</div>";

}
