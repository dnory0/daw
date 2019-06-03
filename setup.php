<?php
require_once 'root.php';

function create_table($table, $query) {
  global $connection;
  $result = $connection->query($query);
  if ($result) echo "table $table ✅.<br>";
  else die("error ❌ creating table $table.<br>");
}

create_table("concours", "CREATE TABLE IF NOT EXISTS concours(
  conc_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  theme VARCHAR(64) NOT NULL,
  num_pl SMALLINT UNSIGNED,
  d_debut DATE,
  d_fin DATE
)");

create_table("etudiant", "CREATE TABLE IF NOT EXISTS etudiant(
   mat INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
   nom VARCHAR(24),
   prenom VARCHAR(24),
   d_nais DATE,
   l_nais VARCHAR(256),
   email VARCHAR(64),
   pass VARCHAR(24),
   tel VARCHAR(16),
   nat VARCHAR(64),
   pays VARCHAR(64),
   adrs VARCHAR(64),
   lang VARCHAR(12),
   niv VARCHAR(12),
   sit ENUM('att', 'ref', 'acc', 'can', 'dep', 'reu'),
   concours INT UNSIGNED NOT NULL,

   FOREIGN KEY (concours)
   REFERENCES concours(conc_id)
   ON DELETE NO ACTION
   ON UPDATE CASCADE
)");

create_table("admin", "CREATE TABLE IF NOT EXISTS admin(
   mat INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
   nom VARCHAR(24),
   prenom VARCHAR(24),
   email VARCHAR(64),
   pass VARCHAR(24)
)");

echo "All tables are created successfully.";