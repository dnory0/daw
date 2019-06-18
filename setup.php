<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Setup tables</title>
</head>

<body>
  <?php
require_once 'root.php';

function create_table($table, $query) {
  global $connection;
  $result = $connection->query($query);
  if ($result) echo "table $table ✅.<br>";
  else die("error ❌ creating table $table.<br>
  possible fixes: edit the user and pass.<br>");
}

create_table("concours", "CREATE TABLE IF NOT EXISTS concours(
  conc_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  theme VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  num_pl SMALLINT UNSIGNED,
  d_insc_debut DATE,
  d_insc_fin DATE,
  d_doc DATE,
  d_passe_conc DATE,
  d_resu_conc DATE,
  d_fin DATE
)");

create_table("etudiant", "CREATE TABLE IF NOT EXISTS etudiant(
  mat INT(12) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  nom VARCHAR(24),
  prenom VARCHAR(24),
  d_nais DATE,
  l_nais VARCHAR(256),
  email VARCHAR(64) UNIQUE,
  pass VARCHAR(24),
  tel VARCHAR(16) UNIQUE,
  nat VARCHAR(64),
  pays VARCHAR(64),
  adrs VARCHAR(64),
  etat ENUM('att', 'doc', 'ref', 'can', 'pas', 'nre', 'reu'),
  note FLOAT CHECK (note BETWEEN 0.0 AND 20.0),
  conc_id INT UNSIGNED NOT NULL,

  FOREIGN KEY (conc_id)
  REFERENCES concours(conc_id)
  ON DELETE NO ACTION
  ON UPDATE CASCADE
)");

create_table("administrateur", "CREATE TABLE IF NOT EXISTS administrateur(
  mat INT(12) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  nom VARCHAR(24),
  prenom VARCHAR(24),
  email VARCHAR(64),
  pass VARCHAR(24)
)");

echo "All tables are created successfully.";
?>
</body>

</html>