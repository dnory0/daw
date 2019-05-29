<?php

$dbhost = 'localhost';
$dbuser = 'hocine';
$dbpass = 'hocine';
$dbname = 'daw';

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) die('Fatal error: could not connect to database.');

unset($dbhost);
unset($dbuser);
unset($dbpass);
unset($dbname);

function query_mysql($query) {
  global $connection;
  $result = $connection->query($query);
  if (!$result) die('Fatal error: could not perform this query.<br>' . $query);
  return $result;
}

function create_table($tbname, $columns) {
  query_mysql("CREATE TABLE IF NOT EXISTS $tbname($columns)");
  echo "Table $tbname was created or already exists.<br>";
}

function lang($lang = '') {
  if (isset($_COOKIE['lang'])) {
    if($lang) {
      if ($lang != $_COOKIE['lang']) setcookie('lang', $lang, time() + 2592000, "/");
    } else {
      $lang = sanitize_string($_COOKIE['lang']);
      if ($lang != 'fr' && $lang != 'ar') $lang = 'en';
    }
  } else {
    if (!$lang) $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if ($lang != 'fr' && $lang != 'ar') $lang = 'en';
    setcookie('lang', $lang, time() + 2592000, "/");
  }
  return $lang;
}

function sanitize_string($str) {
  global $connection;
  $str = strip_tags($str);
  $str = htmlentities($str);
  if (get_magic_quotes_gpc())
    $str = stripslashes($str);
  return $connection->real_escape_string($str);
}
