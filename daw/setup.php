<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Setup</title>
</head>
<body>
<?php

require_once 'functions.php';

echo 'creating tables...<br>';

create_table('etudiants', "
  etd_mat INT(12) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  etd_nom VARCHAR(24),
  etd_prenom VARCHAR(24),
  etd_email VARCHAR(64),
  INDEX(etd_email),
  INDEX(etd_nom),
  INDEX(etd_prenom)
");

create_table('admins', '
  adm_num INT(12) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  adm_nom VARCHAR(24),
  adm_prenom VARCHAR(24),
  adm_email VARCHAR(64),
  INDEX(adm_email),
  INDEX(adm_nom),
  INDEX(adm_prenom)
');

create_table('themes', '
  thm_num INT(12) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  thm_nom VARCHAR(24),
  INDEX(thm_nom)
');

create_table('concours', '
  con_num INT(12) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  con_nom VARCHAR(24),
  con_theme INT(12),
  con_admin INT(12),
  con_date_fin INT(8) UNSIGNED,
  INDEX(con_nom)
');

// create_table('participations', "
//   par_num INT(12) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
//   par_etudiant VARCHAR(24),
//   par_concours VARCHAR(24),
//   par_date INT(8) UNSIGNED,
//   par_etat TINYINT UNSIGNED
// ");

echo 'done.';

// echo "
// create table custom(
//   id int(12) unsigned not null primary key auto_increment,
//   fname varchar(24) character set utf8 collate utf8_general_ci,
//   lname varchar(24) character set utf8 collate utf8_general_ci,
//   user varchar(24),
//   email varchar(64),
//   password varchar(24),
//   index(fname),
//   index(lname),
//   index(user),
//   index(email)
// )"
?>