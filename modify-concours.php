<?php

require_once 'root.php';

$conc_id = $_GET['conc_id'];
$theme = htmlentities($_GET['theme']);
$num_pl = $_GET['num_pl'];
$d_insc_debut = $_GET['d_insc_debut'];
$d_insc_fin = $_GET['d_insc_fin'];
$d_doc = $_GET['d_doc'];
$d_passe_conc = $_GET['d_passe_conc'];
$d_resu_conc = $_GET['d_resu_conc'];
$d_fin = $_GET['d_fin'];

$result = $connection->query("UPDATE concours SET theme='$theme', num_pl='$num_pl', d_insc_debut='$d_insc_debut', d_insc_fin='$d_insc_fin', d_doc='$d_doc', d_passe_conc='$d_passe_conc', d_resu_conc='$d_resu_conc', d_fin='$d_fin' WHERE conc_id='$conc_id'");
if(!$result) die("<div style='background-color: red; padding: 20px;'>Désolé, On a une error de mettre &agrave; jour les informations de ce concours.</div>");
else echo "<div style='background-color: green; padding: 20px;'>Ce theme a &eacute;t&eacute; mis &agrave; jour.</div>";

// foreach($_GET as $key => $item)
//   echo "$key='\$$key',  ";