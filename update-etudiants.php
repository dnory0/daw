<?

require_once 'root.php';

$arr = $_GET['mat'];

for($i = 0; $i < count($arr); $i++) {
  $mat = $_GET['mat'][$i];
  $etat = $_GET['etat'][$i]; 
  $note = ($_GET['note'][$i] != 0)? ", note=\"" . $_GET['note'][$i] . "\"" : "";
  
  $result = $connection->query("UPDATE etudiant SET etat=\"$etat\"$note WHERE mat=\"$mat\"");
	if(!$result) die("<div style='background-color: red; padding: 20px;'>Désolé, On a une error de mettre &agrave; jour les informations des &eacute;tudiants.</div>");
}

echo "<div style='background-color: green; padding: 20px;'>Ces &eacute;tudiants ont &eacute;t&eacute; mis &agrave; jour.</div>";
