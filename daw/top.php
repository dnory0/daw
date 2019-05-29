<?php
$table = 'customer';

// LOGIN AND SIGNUP: POST SIDE
if (count($_POST)) {
  if ( // LOGIN SIDE
    isset($_POST['lemail']) && $_POST['lemail'] != '' &&
    isset($_POST['lpassword']) && $_POST['lpassword'] != ''
  ) {
    $_SESSION['lemail'] = sanitize_string($_POST['lemail']);
    $_SESSION['lpassword'] = sanitize_string($_POST['lpassword']);

    header("HTTP/1.1 303");
    header("Location: http://$_SERVER[HTTP_HOST]/daw/$page");
    die();
  }
  
  if ( // SIGNUP SIDE
    isset($_POST['sfname']) && $_POST['sfname'] != '' &&
    isset($_POST['slname']) && $_POST['slname'] != '' &&
    isset($_POST['semail']) && $_POST['semail'] != '' &&
    isset($_POST['spassword']) && $_POST['spassword'] != '' &&
    isset($_POST['scpassword']) && $_POST['scpassword'] != ''
  ) {
    $_SESSION['sfname'] = sanitize_string($_POST['sfname']);
    $_SESSION['slname'] = sanitize_string($_POST['slname']);
    $_SESSION['semail'] = sanitize_string($_POST['semail']);
    $_SESSION['spassword'] = sanitize_string($_POST['spassword']);
    $_SESSION['scpassword'] = sanitize_string($_POST['scpassword']);
    
    // IF USERNAME GIVEN, $_SESSION['susername'] IS SET,
    // ELSE WE RANDOMIZE A USERNAME USING FNAME + LNAME + NUM_OCCURANCE
    // in the database.
    if (isset($_POST['susername']) && $_POST['susername'] != '')
      $_SESSION['susername'] = sanitize_string($_POST['susername']);
    else {
      $tempfname = $_SESSION['sfname'];
      $templname = $_SESSION['slname'];
      $result = query_mysql(
        "SELECT * FROM $table WHERE fname='$tempfname' AND lname='$templname'"
      );
      
      $_SESSION['susername'] = preg_replace('/\s+/', '',
        substr("$tempfname$templname", 0, 22) . substr($result->num_rows, 0, 2)
      );
      unset($tempfname);
      unset($templname);
    }
    
    header("HTTP/1.1 303");
    header("Location: http://$_SERVER[HTTP_HOST]/daw/$page");
    die();
  }
}

$errormsg = '';

// LOGIN AND SIGNUP: SESSION SIDE
if (isset($_SESSION['lemail']) && isset($_SESSION['lpassword'])) {
  if (
    filter_var($_SESSION['lemail'], FILTER_VALIDATE_EMAIL) && 
    7 < strlen($_SESSION['lpassword'])
  ) {
    $lemail = $_SESSION['lemail'];
    $lpassword = $_SESSION['lpassword'];
    $result = query_mysql(
      "SELECT * FROM $table WHERE email='$lemail'"
    );
    // add verify password
    if (!$result->num_rows) {
      $errormsg = $lang == 'ar' ? "البريد الإلكتروني/كلمة السر الخطأ." :
        ($lang == 'fr'? "Adresse email/Mot de passe incorrect." : 
          "Wrong email/password.");
    } else {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      if (password_verify($lpassword, $row['pass'])) $_SESSION['user'] = $row['user'];
      else $errormsg = $lang == 'ar' ? "البريد الإلكتروني/كلمة السر الخطأ." :
        ($lang == 'fr'? "Adresse email/Mot de passe incorrect." : 
          "Wrong email/password.");
    }
  } else $errormsg = $lang == 'ar' ? "البريد الإلكتروني/كلمة السر الخطأ." :
    ($lang == 'fr'? "Adresse email/Mot de passe incorrect." : 
      "Wrong email/password.");
  $errortype = true; // error type is login type
  unset($_SESSION['lemail']);
  unset($_SESSION['lpassword']);
}

if (
  isset($_SESSION['sfname']) && isset($_SESSION['slname']) &&
  isset($_SESSION['susername']) && isset($_SESSION['semail']) && 
  isset($_SESSION['spassword']) && isset($_SESSION['scpassword'])
) {
  if (
    filter_var($_SESSION['semail'], FILTER_VALIDATE_EMAIL)
    && 7 < strlen($_SESSION['spassword']) && 7 < strlen($_SESSION['scpassword'])
  ) {
    // CHECK IF USERNAME ALREADY REGISTERED. IF NOT PROCEED ELSE EXIT WITH ERRORMSG
    $tempusername = $_SESSION['susername'];
    $result = query_mysql(
      "SELECT * FROM $table WHERE user='$tempusername'"
    );
    unset($tempusername);
    if(!$result->num_rows) {
      // CHECK IF EMAIL ALREADY REGISTERED. IF NOT PROCEED ELSE EXIT WITH ERRORMSG
      $tempemail = $_SESSION['semail'];
      $result = query_mysql(
        "SELECT * FROM $table WHERE email='$tempemail'"
      );
      unset($tempemail);

      if(!$result->num_rows) {
        if ($_SESSION['spassword'] === $_SESSION['scpassword']) {
          $sfname = $_SESSION['sfname'];
          $slname = $_SESSION['slname'];
          $susername = $_SESSION['susername'];
          $semail = $_SESSION['semail'];
          $spassword = password_hash($_SESSION['spassword'], PASSWORD_DEFAULT);
          query_mysql(
            "INSERT INTO $table VALUES(
              null, '$sfname', '$slname', '$susername', '$semail', '$spassword'
            )"
          );
          $result = query_mysql("SELECT * FROM $table WHERE email='$semail'");
          
          if (!$result->num_rows)
            $errormsg = $lang == 'ar' ? "نعتذر، هناك خطأ في تسجيل المستخدم
            الجديد، أعد المحاولة." : ($lang == 'fr'? "Désolé, une erreur est 
            servenue lors de l'enregistrement de l'utilisateur. réessayer." : 
            "Sorry, there is an error with registering the user. try again.");
          else $_SESSION['user'] = $result->fetch_array(MYSQLI_ASSOC)['user']; // should be user
        } else $errormsg = $lang == 'ar' ? "تأكيد كلمة السر خاطئ." :
                ($lang == 'fr'? "Confirmation de mot de passe incorrect." : 
                  "Incorrect password confirmation.");
      } else $errormsg = $lang == 'ar' ? "هذا البريد الإلكتروني مسجل من قبل." :
                ($lang == 'fr'? "Email est déjà enregistré." : 
                  "Email is already registered before.");
    } else $errormsg = $lang == 'ar' ? "هذا الإسم المستخدم مسجل من قبل." :
            ($lang == 'fr'? "Nom d'utilisateur est déjà enregistré." : 
              "Username is already registered before.");
  } else $errormsg = $lang == 'ar' ? "البريد الإلكتروني/كلمة السر غير مقبول." :
    ($lang == 'fr'? "Email/Mot de passe inacceptable." : 
      "Inacceptable email/password.");
  $errortype = false; // error type is signup type
  unset($_SESSION['sfname']);
  unset($_SESSION['slname']);
  unset($_SESSION['susername']);
  unset($_SESSION['semail']);
  unset($_SESSION['spassword']);
  unset($_SESSION['scpassword']);
}

if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
  $user = $_SESSION['user'];
  $loggedin = true;
} else {
  $loggedin = false;
}

// FEEDBACK: POST SIDE
if (count($_POST)) {
  if (
    isset($_POST['feedback']) && $_POST['feedback'] != '' &&
    (isset($_POST['femail']) && $_POST['femail'] != '' || $loggedin)
  ) {
      $_SESSION['feedback'] = $_POST['feedback'];
      if (!$loggedin) $_SESSION['femail'] = $_POST['femail'];

      header("HTTP/1.1 303");
      header("Location: http://$_SERVER[HTTP_HOST]/daw/$page");
      die();
  }
}

// FEEDBACK: POST SIDE
if (isset($_SESSION['feedback'])) {
  $feedbackgiven = true;
  setcookie('feedbackgiven', true, time () + 86400, '/');
  // save feedback to database.
  unset($_SESSION['feedback']);
  unset($_SESSION['femail']);
} else {
  if (isset($_COOKIE['feedbackgiven']) && $_COOKIE['feedbackgiven']) $feedbackgiven = true;
  else $feedbackgiven = false;
}

$classAr = $lang == 'ar'? 'class="ar"' : '';
