<?php
function pdo_connect_mysql() {
    // AJOUTER LE CODE DE CONNECTION ICI

    $nom_admin = "root";
    $mdp = "";

    try {
        $conn = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', $nom_admin, $mdp);
        return $conn;

    } catch (PDOException $e) {
        return false;
    }
}

function template_header($title) {
  echo <<<EOT
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>$title</title>
      <link href="style.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
      <nav class="navtop">
        <div style="width:auto;">
          <a href="index.php" style="padding-left:20px;"><h1>Blog MYNT</h1></a>
          <a href="index.php"><i class="fas fa-home"></i>Accueil</a>
          <input class="form-outline" id="search-input" type="search" name="search" placeholder="Que cherchez-vous ?"/>
          <a href="categories.php"><i class="fas fa-address-book"></i>Catégories</a>
          <a href="tagsIndex.php"><i class="fas fa-book"></i>Tags</a>
          <a id="post-create" href="post-create.php"><i class="fas fa-book-reader"></i>Créer un post</a>
          <a href="posts.php"><i class="fas fa-book-reader"></i>Posts</a>
          <a id="connected" href="login.php"><i class="fas fa-user"></i>Connexion</a>
          <a id="logout" href="logout.php"><i class="fas fa-sign-out-alt"></i>Déconnexion</a>
        </div>
      </nav>
  EOT;
}


/**
 * function permettant de printer la template de footer
 */
function template_footer() {
  $year = date("Y");
  echo <<<EOT
        <footer>
          <p>©$year blog-mynt.nc</p>
        </footer>
      </body>
  </html>
  EOT;
}

function escape($valeur)
{
    // Convertit les caractères spéciaux en entités HTML
    return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
}

?>