<?php
require_once 'functions.php';
$lang = lang();
echo <<<_MAIN
  <script>
    window.location.replace('/daw/$lang/');
  </script>
_MAIN;
?>
