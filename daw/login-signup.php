<?php

switch ($lang) {
  case 'fr':
    $fname = 'Nom';
    $lname = 'Prenom';
    $username = "Nom d'utilisateur";
    $email = 'Adresse email';
    $password = 'Mot de passe';
    $cpassword = 'Confirmer le mot de passe';

    $cancel = 'Annuler';
    $member = 'Connectez-vous';
    $guest = "S'inscrire";
    break;
  case 'ar':
    $fname = 'الإسم';
    $lname = 'اللقب (إسم العائلة)';
    $username = "إسم المستخدم";
    $email = 'البريد الإلكتروني';
    $password = 'كلمة السر';
    $cpassword = 'تأكيد كلمة السر';

    $cancel = 'إلغاء';
    $member = 'تسجيل الدخول';
    $guest = 'إنشاء حساب';
    break;
  default:
    $fname = 'First name';
    $lname = 'Last name';
    $username = "Username";
    $email = 'Email';
    $password = 'Password';
    $cpassword = 'Confirm Password';

    $cancel = 'Cancel';
    $member = 'Login';
    $guest = 'Sign up';
    break;
}
echo <<< _BEGIN
  <div>
_BEGIN;

echo <<< _LOGIN_SIGNUP_BACKGROUND
    <div onclick="closeloginsignupall();" id="login-signup-bg"></div>
    <script>
      function closeloginsignupall() {
        document.getElementById('login-signup-bg').style.display = 'none';
        document.getElementById('login-signup-pane').style.display = 'none';
      }
    </script>
_LOGIN_SIGNUP_BACKGROUND;

echo <<< _LOGIN_SIGNUP_PANE_BEGIN
    <div id="login-signup-pane">
_LOGIN_SIGNUP_PANE_BEGIN;
echo <<< _LOGIN_SIGNUP_TABS
      <div id="login-signup-tabs">
        <label id="login-tab" class="login-signup-tab"><input type="radio" onclick="openlogintab();">$member</label>
        <label id="signup-tab" class="login-signup-tab"><input type="radio" onclick="opensignuptab();">$guest</label>
        <script>
          function openlogintab() {
            document.getElementById('login-tab').classList.add('chosen-tab');
            document.getElementById('signup-tab').classList.remove('chosen-tab');
            document.getElementById('signup-submit').parentNode.style.display= "none";
            document.getElementById('login-submit').parentNode.style.display= "block";
            document.getElementById('login-form').classList.add("chosen-content");
            document.getElementById('signup-form').classList.remove("chosen-content");
          }
          
          function opensignuptab() {
            document.getElementById('signup-tab').classList.add('chosen-tab');
            document.getElementById('login-tab').classList.remove('chosen-tab');
            document.getElementById('login-submit').parentNode.style.display= "none";
            document.getElementById('signup-submit').parentNode.style.display= "block";
            document.getElementById('signup-form').classList.add("chosen-content");
            document.getElementById('login-form').classList.remove("chosen-content");
          }
        </script>
      </div>
_LOGIN_SIGNUP_TABS;

if ($errormsg) {
echo <<< _LOGIN_SIGNUP_ERRORMSG
      <div id="errormsg-field" $classAr><div>$errormsg</div></div>
_LOGIN_SIGNUP_ERRORMSG;
}
echo <<< _LOGIN_SIGNUP_CONTENT
      <form method="post" action="./$page" class="content" id="login-form">
        <label $classAr>$email:<input $classAr required type="email" name="lemail" maxlength="64"></label>
        <label $classAr>$password:<input $classAr required type="password" name="lpassword" autocomplete='on' minlength="8" maxlength="24"></label>
      </form>
      <form method="post" action="./$page" class="content" id="signup-form">
        <label $classAr>$fname*: <input required type="text" name="sfname" maxlength="24"></label>
        <label $classAr>$lname*: <input required type="text" name="slname" maxlength="24"></label>
        <label $classAr>$username: <input $classAr type="text" name="susername" maxlength="24"></label>
        <label $classAr>$email*: <input $classAr required type="email" name="semail" maxlength="64"></label>
        <label $classAr>$password*: <input $classAr required type="password" name="spassword" autocomplete='on' minlength="8" maxlength="24"></label>
        <label $classAr>$cpassword*: <input $classAr required type="password" name="scpassword" autocomplete='on' minlength="8" maxlength="24"></label>
      </form>
_LOGIN_SIGNUP_CONTENT;

echo <<<_LOGIN_SIGNUP_FOOTER
      <div id="login-signup-footer" $classAr>
        <div><button onclick="closeloginsignupall();">$cancel</button></div>
        <div><input id="login-submit" type="submit" form="login-form" value="$member"></div>
        <div><input id="signup-submit" type="submit" form="signup-form" value="$guest"></div>
      </div>
_LOGIN_SIGNUP_FOOTER;
echo <<< _LOGIN_SIGNUP_PANE_END
    </div>
    <script>
        function openloginsignupall() {
          document.getElementById('login-signup-bg').style.display = 'block';
          document.getElementById('login-signup-pane').style.display = 'block';
        }
      </script>
_LOGIN_SIGNUP_PANE_END;

echo <<< _END
  </div>
_END;

if($errormsg) {
  if ($errortype) { // errortype: login or signup
    echo <<< _OPEN_LOGIN
    <script>
      openloginsignupall();
      openlogintab();
      setTimeout(() => {
        document.getElementById('errormsg-field').children[0].classList.add('error-triggerd');
      }, 1);
    </script>
_OPEN_LOGIN;
  } else {
    echo <<< _OPEN_SIGNUP
    <script>
      openloginsignupall();
      opensignuptab();
      setTimeout(() => {
        document.getElementById('errormsg-field').children[0].classList.add('error-triggerd')
      }, 1);
    </script>
_OPEN_SIGNUP;
  }
}
// if ()
