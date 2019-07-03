<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bienvenue</title>
  <style>
    @font-face {
      font-family: 'cairo';
      src: url('fonts/Cairo-SemiBold.ttf')
    }

    * {
      font-family: cairo;
    }

    body {
      margin: 0;
      background: url('img/bg.svg');
      background-size: cover;
      padding: 0;
      font-family: sans-serif;
      background-attachment: fixed;
    }

    body>div:first-child {
      float: left;
      width: 100%;
      min-height: 320px;
    }

    body>div:first-child>div {
      float: left;
    }

    body>div:first-child>div:first-child>h3 {
      padding: 60px 50px;
      font-size: 28px;
      color: #383838;
      width: 60vw;
      box-sizing: border-box;
    }

    body>div:first-child>div:not(:first-child) {
      width: 400px;
    }

    .theme-container {
      padding: 460px 12vw;
    }

    .theme-container>div {
      background-color: #e5e2eb;
      border: #696969 solid 1px;
      border-radius: 3px;
    }

    .theme {
      color: #242323;
      font-size: 18px;
      padding: 20px;
      height: 40px;
    }

    .theme:not(:last-child) {
      border-bottom: #696969 solid 1px;
    }

    .theme>* {
      float: left; 
    }
    
    .theme>button {
      float: right;
    }

    .theme-name {
      padding-right: 50px;
    }
    
    .signup-login {
        padding: 20px;
        margin-left: 50px;
    }
    .signup-login>a, button {
        padding: 6px 20px;
        text-decoration: none;
        color: #262626;
        border-radius: 6px;
        border: 1px solid #0006;
        background-color: #3aff00c7;
        margin-left: 50px;
    }
    
    .signup-login>a:hover, button:hover {
        background-color: #34d123;
    }
    
  
  </style>
</head>

<body>
  <div style="min-height: 450px">
    <div>
      <h3>Bienvenue Sur Le Site Web d'Enregistrement de Doctorat.</h3>
        <div class="signup-login">
          <a class="signup-login" href="inscription-etudiant.php">Sign up</a>
          <a class="signup-login" href="login.html">Log in</a>
        </div>
        
    </div>
    <div>
      <img src="/img/front.png">
    </div>
  </div>
  <div style="position: absolute; background-color: greenyellow; width: 100%; height: 350px; z-index: -1"></div>
  <div style="top: 350px; position: absolute; background-image: linear-gradient(to bottom, greenyellow, rgba(0, 0, 0, 0)); width: 100%; height: 120px; z-index: -1"></div>
  <div class="theme-container">
    <div>
      <?php
        require_once "root.php";
        /** @var $connection mysqli*/
        $result = $connection->query("SELECT conc_id, theme, d_insc_debut, d_insc_fin FROM concours");
        if ($result) {
          for ($i = 0; $i < $result->num_rows; ++$i) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $conc_id = $row['conc_id'];
            $theme = $row['theme'];
            $d_insc_debut = date('d/m/Y', strtotime($row['d_insc_debut']));
            $d_insc_fin = date('d/m/Y', strtotime($row['d_insc_fin']));
            echo <<<THEME
              <div class="theme">
                <div style="display: none">$conc_id</div>
                <div class="theme-name">$theme</div>
                <img src="img/calendar.png" alt="d'apr&egrave;s">
                <div>$d_insc_debut &agrave; $d_insc_fin</div>
                <button onclick="goToInscription(this.parentNode.children.item(0).innerHTML);">Choisissez ce th&egrave;me</button>
              </div>
            THEME;
            }
          } else {
            die(<<<NO_THEMES
          <div class="theme">
            <div style="background-color: orangered" class="theme-name">Pas encore de th&egrave;mes, retournez &agrave; nouveau &agrave; un autre moment.</div>
          </div>
NO_THEMES
);
        }

      ?>
      <div id="form-container">
      
      </div>
      <script>
        let form = document.createElement('form');
        form.style.display = 'none';
        document.getElementById('form-container').append(form);
        form.setAttribute("method", "get");
        form.setAttribute("action", `inscription-etudiant.php`);
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'conc_id';
        form.append(hiddenInput);
        function goToInscription(conc_id) {
          hiddenInput.value = conc_id;
          form.submit();
        }
      </script>
    </div>
  </div>


</body>

</html>