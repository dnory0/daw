<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Page d'inscription</title>
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
      
    }

    nav {
      height: 33px;
      background-color: #50bc30;
      padding: 5px 10px;
    }

    nav>a {
      float: left;
      border: 1px solid black;
      height: 30px;
      padding: 0 20px;
    }

    nav>a:hover {
      background-color: #249318;
    }

    section {
      float: left;
      min-width: 400px;
      background: #fff7;
      width: 100%;
    }

    section>h2 {
      text-align: center;
      margin: 10px 0 0;
      padding: 20px;
      color: #3c3c3c;
    }

    form {
      float: left;
      padding: 20px;
      width: calc(100% - 40px);
    }

    form>div {
      padding: 10px;
      min-width: 400px;
      width: calc(50% - 20px);
      float: left;
    }

    article {
      padding: 20px 0;
      width: 386px;
      margin: auto;
    }

    article#note>div {
      margin-top: 6px;
      border-left: 5px greenyellow solid;
      padding: 20px 10px;
      background-color: #edf7c4;
    }

    input {
      height: 30px;
      width: 380px;
      padding: 2px;
      margin: 10px 0;
      border: 1px solid;
      border-radius: 3px;
    }

    select {
      height: 36px;
    }

    [type="submit"] {
      width: 386px;
      margin-top: 15px;
      border-radius: 6px;
      border: 1px solid #0006;
      background-color: #3aff00c7;
      margin-left: calc(50% - 193px);
    }

    [type="submit"]:hover {
      background-color: #34d123;
    }

    @media only screen and (max-width: 889px) {
      form {
        padding-left: calc(50% - 210px);
        width: 420px;
      }
      form>div:last-child {
        width: 386px;
      }
    }
  </style>
</head>

<body>
  <nav>
    <a href="./"><img src="img/home.png" alt="home"></a>
    <!-- <a href="inscription.html">S'inscrire comme un administrateur</a>
    <a href=""></a> -->
  </nav>
  <section>

    <h2>
      Les informations de l'inscription:
    </h2>
    <form action="inscription.php" method="post" onsubmit="return passwordMatch()">
      <div>
        <article>
          <label for="nom">Nom:*</label><br>
          <input type="text" name="nom" id="nom" required maxlength="24" placeholder="Exemple: Boussif"><br>

          <label for="prenom">Prénom:*</label><br>
          <input type="text" name="prenom" id="prenom" required maxlength="24" placeholder="Exemple: Zineb"><br>

          <label for="daten">Date de Naissance:*</label><br>
          <input type="date" name="daten" id="daten" required><br>

          <label for="lieun">Lieu de Naissance:*</label><br>
          <input type="lieun" name="lieun" id="lieun" placeholder="Exemple: thenia boumerdes" required><br>

          <label for="email">E-mail:*</label><br>
          <input type="email" name="email" id="email" placeholder="Exemple: user@e-mail.com" maxlength="64" required><br>

          <label for="pass">Mot de Passe:*</label><br>
          <input type="password" name="pass" id="pass" maxlength="24" minlength="8" required><br>

          <label for="cpass">Confirmer le Mot de Passe:*</label><br>
          <input type="password" name="cpass" id="cpass" maxlength="24" minlength="8" required><br>
        </article>
      </div>

      <div>
        <article>
          <label for="tel">Téléphone:*</label><br>
          <input type="tel" name="tel" id="tel" placeholder="Exemple: +213558985005" required><br>

          <label for="nationalite">Nationalité:*</label><br>
          <input type="text" name="nationalite" id="nationalite" maxlength="64" placeholder="Exemple: Algerien" required><br>

          <label for="pays">Pays:*</label><br>
          <select name="pays" id="pays" style="width: 386px" required>
            <option disabled selected>-</option>
            <option value="DZ">Algeria</option>
            <option value="TN">Tunisia</option>
            <option value="MO">Morocco</option>
          </select>
          <label for="adresse">Adresse:*</label><br>
          <input type="text" name="adresse" id="adresse" maxlength="256"
            placeholder="Exemple: rue bouakel rabah thenia boumerdes" required><br>
          
          <label for="theme">Theme de concours:*</label><br>
          <?php

          require_once 'root.php';
          if (isset($_GET['theme'])) {
            $theme = $_GET['theme'];
            echo <<< _THEME
            <select id="theme" name="theme" disabled required style="width: 386px;">
              <option value="$theme" selected>$theme</option>
            </select>
_THEME;
          } else {
            echo <<< _THEME_BEGIN
            <select id="theme" name="theme" required style="width: 386px;">
              <option value="none" selected disabled>-</option>
_THEME_BEGIN;
            $result = $connection->query('SELECT conc_id, theme FROM concours');
            for ($i = 0; $i < $result->num_rows; $i++) {
              $row = $result->fetch_row();
              $conc_id = $row[0];
              $theme = htmlspecialchars_decode($row[1]);
              echo "
              <option value=\"$conc_id\">$theme</option>
              ";
            }
            // $theme = htmlentities("Réseau");
            // $result = $connection->query("insert into concours values(null, '$theme', 54,null, null, null, null, null)");
            echo <<< _THEME_END
            </select>
_THEME_END;
          }
          ?>
          
        </article>


        <article id="note">
          <div>
            <span style="background-color: greenyellow;">&nbsp;Note:&nbsp;</span>&nbsp;(*) est un champ obligatoire.
          </div>
        </article>
        <article>
          <input type="submit" value="S'inscrire">
        </article>
      
      </div>
    </form>
  </section>
  <script>
    function passwordMatch() {
      if (document.getElementById('pass').value ===
        document.getElementById('cpass').value)
        return true;
      alert('La confirmation du mot de passe est incorrect');
      return false;
    }
  </script>
</body>

</html>