<?php

echo <<< _HEADER_BEGIN
  <nav>
_HEADER_BEGIN;

echo <<< _HEADER_LOGO
    <div id="logo"><a href="/daw/temp.php"><img src="/daw/Cogn_mode.png" alt="logo" id="logo-img"></a></div>
    <div id="nav-right">
_HEADER_LOGO;

if ($loggedin) {
$logoutbtn = $lang == 'fr'? 'Déconnectez-vous' :
($lang == 'ar'? 'تسجيل الخروج' : 'Log out');
  echo <<< _HEADER_LOGGED_PROFILE
      <div id='profile'>
        <a href="../$lang/"><img src="/daw/Cogn_mode.png" alt="user"><label>$user</label></a>
      </div>
      <div class="member"><a href="/daw/logout.php">$logoutbtn</a></div>
_HEADER_LOGGED_PROFILE;
} else {
  echo <<< _HEADER_GUEST
      <div class="guest"><button onclick="openloginsignupall(); openlogintab();" >$member</button></div>
      <div class="guest"><button onclick="openloginsignupall(); opensignuptab();" >$guest</button></div>
_HEADER_GUEST;
}

switch ($lang) {
  case 'fr':
    $alt =  'french';
    $lang1 = 'en'; $alt1 = 'english';
    $lang2 = 'ar'; $alt2 = 'عربي';
    break;
  case 'ar':
    $alt = 'عربي';
    $lang2 = 'en'; $alt2 = 'english';
    $lang1 = 'fr'; $alt1 = 'français';
    break;
  default:
    $alt = 'english';
    $lang1 = 'fr'; $alt1 = 'français';
    $lang2 = 'ar'; $alt2 = 'عربي';
    break;
}

echo <<< _HEADER_LANG
      <div id="lang">
        <button title="$alt" onblur="setTimeout(closeLangMenu, 150)" onclick="langMenu()" id="lang-btn"><img src="/daw/img/lang/$lang.svg" alt="$alt"></button>
        <script>
          function langMenu() {
            if(document.getElementById('lang-block').style.display == 'block') closeLangMenu();
            else openLangMenu();
          }
          function openLangMenu(event) {document.getElementById('lang-block').style.display = 'block';}
          function closeLangMenu() {document.getElementById('lang-block').style.display = 'none';}
        </script>
        <div id="lang-block">
          <div class="lang"><a title="$alt1" href="../$lang1/$page"><img src="/daw/img/lang/$lang1.svg" alt="$alt1"></a></div>
          <div class="lang"><a title="$alt2" href="../$lang2/$page"><img src="/daw/img/lang/$lang2.svg" alt="$alt2"></a></div>
        </div>
      </div>
_HEADER_LANG;

echo <<< _HEADER_END
    </div>
  </nav>
_HEADER_END;
