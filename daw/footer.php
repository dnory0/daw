
<?php

echo <<< _FOOTER_BEGIN
  <footer>
_FOOTER_BEGIN;

echo <<< _LEFT_SIDE_BEGIN
    <div id="footer-left">
      <h2 id="copyright-symbol">&#169;</h2><h4 id="copyright-text">By Hocine Abdellatif Houari.</h4>
_LEFT_SIDE_BEGIN;

switch($lang) {
  case 'fr':
    $aboutus = 'À propos de nous';
    $aboutusdesc = "ceci est juste un modèle créé à partir de hocine abdellatif,
    ces infos sont juste pour remplacer temporairement un 'à propos de nous'.
    et cela ne vous aide en rien, alors ne
    perdre votre temps avec elle.";
    break;
  case 'ar':
    $aboutus = 'معلومات عنا:';
    $aboutusdesc = "
    هذا مجرد قالب تم إنشاؤه من طرف حسين عبداللطيف ، 
    هذه المعلومات هي مجرد استبدال مؤقت لـ 'معلومات عنا'. 
    وهي لن تساعدك في أي شيء لذلك لا تضيع وقتك معها.";
    break;
  default:
    $aboutus = 'About us';
    $aboutusdesc = "
    this is just a template created from hocine abdellatif, 
    this infos is just to replace an 'about us' temporarily. 
    and it doesn't help you in anything so don't 
    waste your time with it.";
    break;

}

echo <<< _ABOUT_US
    <div id="aboutus">
      <h4 $classAr>$aboutus</h4>
      <div $classAr>$aboutusdesc</div>
    </div>
_ABOUT_US;
echo <<< _LEFT_SIDE_END
  </div>
_LEFT_SIDE_END;

switch($lang) {
  case 'fr':
    $feedback = 'Vos réactions';
    $submitbtn = 'Envoyer';
    break;
  case 'ar':
    $feedback = 'رأيك';
    $submitbtn = 'أرسل';
    break;
  default:
    $feedback = 'Your Feedback';
    $submitbtn = 'Send';
    break;
}

echo <<< _RIGHT_SIDE_BEGIN
    <div id="footer-right" $classAr>
_RIGHT_SIDE_BEGIN;

if ($feedbackgiven) {
  $thanks = $lang == 'fr'? 'Merci pour vos réactions.' :
  ($lang == 'ar'? 'شكرا لمشاركتك رأيك معنا.' : 'Thank you for your feedback.');
  echo <<< _TEMP
      <h4 id="thanks">$thanks</h4>
      <form action="./$page" method="post">
_TEMP;
} else {
  echo <<< _TEMP
      <form action="./$page" method="post">
_TEMP;
}
  
if (!$loggedin) {
  $femail = $lang == 'fr'? 'Adresse email: (Champs obligatoires)' :
    ($lang == 'ar'? 'البريد الإلكتروني: (مطلوب)' :
    'Email: (Required)');
  echo <<< _EMAIL_SEC
        <label>$femail<input required type="email" maxlength="64" name="femail" id="email"></label>
_EMAIL_SEC;
}
echo <<< _RIGHT_SIDE_END
        <label>$feedback:<textarea required name="feedback" id="feedback-textarea" cols="60" rows="6"></textarea></label>
        <input id="feedback-btn" type="submit" value="$submitbtn">
      </form>
    </div>
_RIGHT_SIDE_END;

echo <<< _FOOTER_END
  </footer>
_FOOTER_END;
?>
