<?php
    include 'functions_custom.php';

    session_start();

    if (isset($_SESSION['nom_admin']) && isset($_SESSION['mdp'])) {
        $mdp = $_SESSION['mdp'];
        echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_admin'] ."</div>";
        echo "<style>#connected { display:none; }</style>";
    } else {
        echo "<style>#logout { display:none; }</style>";
        echo "<style>#post-create { display:none; }</style>";
    }

    $pdo = pdo_connect_mysql();

    $req = $pdo->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_publication, \'%d/%m/%Y\') AS date_p FROM post WHERE id = ?');
    $req->execute(array($_GET['billet']));
    $donnees = $req->fetch();
?>

<?php echo template_header('Commentaire'); ?>

    <div class="news">
        <h2>
            <?php echo htmlspecialchars($donnees['titre']); ?><br>
            <em>le <?php echo $donnees['date_p']; ?></em>
        </h2><br>
        
        <p><?php echo htmlspecialchars($donnees['contenu']); ?></p>
    </div>

    <h3>Commentaires</h3>

    <?php
    $req->closeCursor();

    $req = $pdo->prepare('SELECT user_email, contenu, DATE_FORMAT(date_publication, \'%d/%m/%Y\') AS date_p FROM comments WHERE id = ? ORDER BY date_publication');
    $req->execute(array($_GET['billet']));

    while ($donnees = $req->fetch()) { ?>
        <p><strong><?php echo htmlspecialchars($donnees['auteur']); ?></strong> le <?php echo $donnees['date_p']; ?></p>
        <p><?php echo htmlspecialchars($donnees['commentaire']); ?></p>
    <?php } $req->closeCursor(); ?>

<?php echo template_footer(); ?>