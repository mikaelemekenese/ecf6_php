<?php
session_start();

if (isset($_POST['nom_admin']) && isset($_POST['mdp'])) {
    require 'functions_custom.php';
    $bdd = pdo_connect_mysql();

    $requete = "SELECT * FROM admins WHERE BINARY nom_admin = ? AND mdp = ?";
    $resultat = $bdd->prepare($requete);

    $login = $_POST['nom_admin'];
    $mdp = $_POST['mdp'];

    $resultat->execute(array($login, $mdp));

    if ($resultat->rowCount() == 1) {
        $_SESSION['nom_admin'] = $login;
        $_SESSION['mdp'] = $mdp;
        $authOK = true;
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Résultat de l'authentification</title>
    </head>

    <body>
        <?php echo template_header('Authentification'); ?>

        <div class="container">
            <h1 style="margin-top:50px;margin-bottom:20px;">Résultat de l'authentification</h1>

            <?php
            if (isset($authOK)) {
                echo "<p>Vous avez été reconnu(e) en tant que <b>" . escape($login) . "</b>.</p>";
                echo '<a href="index.php">Poursuivre vers la page d\'accueil</a>';
                echo "<style>#connected { display:none; }</style>";
            }
            else { 
                echo "<style>#logout { display:none; }</style>";
                echo "<style>#post-create { display:none; }</style>"; ?>
                
                <p>Vous n'avez pas été reconnu(e)</p>
                <p><a href="login.php">Nouvel essai</p>
            <?php } ?>
        </div>

        <?php echo template_footer(); ?>
    </body>
</html>