<?php
include 'functions_custom.php';
$bdd =pdo_connect_mysql();
session_start();
?>

<?php
    $pdo_statement = $conn->prepare("SELECT titre, contenu,  FROM post");
    $pdo_statement->execute();
    $blog = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

if (isset($_SESSION['nom_admin']) && isset($_SESSION['mdp'])) {
    $mdp = $_SESSION['mdp'];
    echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_admin'] ."</div>";
    echo "<style>#connected { display:none; }</style>";
} else {
    echo "<style>#logout { display:none; }</style>";
}


if (isset($_GET["s"]) AND $_GET["s"] == "Rechercher")
{
 $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les intrusions html
 $terme = $_GET["terme'];
 $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
 $terme = strip_tags($terme); //pour supprimer les balises html dans la requête 

 if (isset($terme))
 {
  $terme = strtolower($terme);
  $select_terme = $bdd->prepare("SELECT titre,contenu, FROM post WHERE titre ="LIKE ? OR contenu LIKE?"");
  $select_terme->execute(array("%".$terme."%", "%".$terme."%"));
 }
 else
 {
  $message = "Vous devez entrer votre requete dans la barre de recherche";
 }
}
?>

