<?php

// setting login to database variables
$dbhost = "localhost";
$dbuser = "hocine";
$dbpass = "hocine";
$dbname = "daw";

// connecting to databases
$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) die("Could not connect to the database.");

// unseting login variables
unset($dbhost);
unset($dbuser);
unset($dbpass);
unset($dbname);
