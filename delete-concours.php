<?
require_once "root.php";
/** @var $connection mysqli*/
if (isset($_GET['conc_id'])) {
	$conc_id = $_GET['conc_id'];
	$connection->query("DELETE FROM etudiant WHERE conc_id=$conc_id");
	$result = $connection->query("DELETE FROM concours WHERE conc_id=$conc_id");
	echo "<div style='background-color: green; padding: 20px;'>Ce th&egrave;me a &eacute;t&eacute; supprim&eacute;, Actualiser la page.</div>";
} else echo "<div style='background-color: orangered; padding: 20px;'>On a une error de supprimer ce th&egrave;me.</div>";

