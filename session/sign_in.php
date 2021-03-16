<?php
//Lorsqu'uen session n'est pas démarée et qu'on appelle session_start()
//PHP va chercher s'il existe un PHPSESSID, donc un identifiant de session, dans les cookies.
//S'il ne trouve pas d'identifiant, donc de PHPSESSID, alors il va en créer un, et le renvoyer au client dans un cookie.
//S'il trouve un identifaint de session, donc un cookie PHPSESSID, alors il va restituer le contexte de la session dans le tabelau $_SESSION
//Par défaut, le tableau $_SESSION sera vide
//Nous pourrons écrire des informations dans $_SESSION, contrairement 
?>

<?php
include_once "layout/header.php";
require_once "model/users.php";
?>

<form method="post">
  <input type="text" name="login" placeholder="Login" required />

  <input type="password" name="password" placeholder="Password" required />

  <input type="submit" value="Connect" name="connect_submit">
</form>

<?php

if (isset($_POST['connect_submit']) && session_status() == PHP_SESSION_ACTIVE) {

  if (!empty($_POST['login']) && !empty($_POST['password'])) {

    $goodLogin = false;
    $goodPassword = false;

    foreach ($users as $user) {

      if ($_POST['login'] == $user['email'] && $goodLogin == false) {
        $goodLogin = true;
        if ($_POST['password'] == $user['pass'] && $goodPassword == false) {
          $goodPassword = true;
        } else {
          $formError = "password incorrect";
        }
      } else {
        $formError = "login incorrect";
      }

      if ($goodLogin && $goodPassword) {
        $_SESSION['login'] = $user['firstname'];
      }
    }
  } else {
    $formError = "password or login are empty";
  }
}

if (isset($_SESSION['login'])) {
  header("Location: index.php");
}

if (isset($formError)) { ?>
  <div class="form_text_error"><?php echo $formError; ?></div>
<?php }

$_SESSION['page_counter'] = 1;

?>


<?php include_once "layout/footer.php"; ?>

<!-- 
Retenir le nombre de pages visitées par l'utilisateur

Réaliser un petit mécanisme de connexion, à partir d'un formulaire (login / mot de passe) en méthode POST, qui viendra écrire en session que l'utilisateur est connecté si le login et le mot de passe correspondent respectivement à une certaine valeur. Dans votre layout, si l'utilisateur est connecté, ajoutez un élément visuel pour indiquer qu'il est bien connecté. Cet élément devra donc le suivre de page en page

Réaliser un sélecteur de thème CSS avec les sessions : sur toutes les pages, on aura une liste déroulante avec 2 thèmes possibles : "sombre" ou "clair". Suivant le thème choisi par l'utilisateur, il faudra adapter l'affichage du site pour appliquer le bon thème. Réalisez vos CSS en accord avec chaque apparence
-->