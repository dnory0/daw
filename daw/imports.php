<?php
echo <<< _DEFAULT_IMPORT
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->
  <link rel="stylesheet" href="/daw/css/header.css">
  <link rel="stylesheet" href="/daw/css/footer.css">
_DEFAULT_IMPORT;
if (!$loggedin) {
  echo <<< _LOGIN_SIGNUP_IMPORT
  <link rel="stylesheet" href="/daw/css/login-signup.css">
_LOGIN_SIGNUP_IMPORT;
}
