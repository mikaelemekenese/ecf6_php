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
?>

<?php echo template_header('Accueil'); ?>

    <?php 

    $pdo = pdo_connect_mysql();
    
    $req = $pdo->query('SELECT id, titre, contenu, DATE_FORMAT(date_publication, \'%d/%m/%Y\') AS date_p FROM post ORDER BY date_publication DESC LIMIT 0, 5'); 

    while ($donnees = $req->fetch()) {
    ?>

        <div class="container">
            <div class="row">
                <div class="col-9">
                    <article>
                    
                    </article>
                </div>

                <div class="col-3">
                    <aside>
                    
                    </aside>
                </div>
            </div>
        </div>
    
    <?php } $req->closeCursor(); ?>

<?php echo template_footer(); ?>