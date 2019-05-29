<?php
  session_start();
  session_unset();
  session_destroy();
  setcookie('feedbackgiven', true, 1, '/');
  header('Location: /daw/');
  exit;
