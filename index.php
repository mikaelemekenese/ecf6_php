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
            <div class="col-3">
                <div class="row">
                        <aside>
                            <div id="searchbar">
                        
                                <h1>Saissez votre recherche</h1>

                                <form action="" class="formulaire">
                                    <input class="champ" type="text" value="Search...)"/>
                                    <input class="bouton" type="button" value="" />
                                    
                                </form>
                            </div>
                
                </aside>
                </div>
            </div>
        </div>  





        <div class="container">
            <div class="row">
                <div class="col-9">

                <div class="container">
	                <br><h1 style="padding-top:5px;text-align:center;color:grey;">Accueil</h1><br>

	                <br><div class="home-buttons">
		        <div class="home-livre">
                    <i class="fas fa-book fa-2x"><br><h3>ARTICLES</h3></i><br><br>
                    <a type="button" class="btn btn-info" href="livre-read.php"><h5>ARTICLES</h5></a><br>
                    
		        </div>
                <div class="home-adh">
                    <i class="fas fa-address-book fa-2x"><br><h3>CATEGORIES</h3></i><br><br>
                    <a type="button" class="btn btn-info" href="adh-read.php"><h5>CATEGORIES</h5></a><br>
                   
                </div>
                <div class="home-empr">
                    <i class="fas fa-book-reader fa-2x"><br><h3>TAGS</h3></i><br><br>
                    <a type="button" class="btn btn-info" href="empr-read.php"><h5>TAGS</h5></a><br>
                    
                </div>
        </div>
        





                    <article>
                        <h3>
                            <?php echo htmlspecialchars($donnees['titre']); ?><br>
                            <em>le <?php echo $donnees['date_p']; ?></em><br>
                        </h3>
                        <p>
                            <?php echo htmlspecialchars($donnees['contenu']); ?><br>
                            <em><a href="comments.php?billet=<?php echo $donnees['id']; ?>">Commentaires</a></em>
                        </p>
                    </article>
            </div>

            

            </div>
        </div>
    </div>
    
    <?php } $req->closeCursor(); ?>

<?php echo template_footer(); ?>