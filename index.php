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
        echo "<style>#add-post,#edit-post,#delete-post { display:none; }</style>";
    }
?>
<?php echo template_header('Accueil'); ?>

    <?php 
        $pdo = pdo_connect_mysql();
        $req = $pdo->query('SELECT id, titre, contenu, DATE_FORMAT(date_publication, \'%d/%m/%Y\') AS date_p FROM post ORDER BY date_publication DESC LIMIT 0, 5'); 
    ?>

    <br><h1 style="padding-top:5px;text-align:center;color:grey;">Accueil</h1><br>
    
    <div class="container" style="text-align:center;width:100%;">
        <div class="form-outline">

            <form action="verif-form.php" class="formulaire" style="display:flex;margin-bottom:80px;margin-top:50px;">
            <input class="form-control" id="search-input" type="search" name="search" placeholder="Que cherchez-vous ?">
                

                </button>  
            </form>
        </div>
    </div><br>

    <div class="container">
        <div class="row"><br>
            <div class="home-buttons">
                <div>
                    <a type="button" class="btn btn-info" href="posts.php"><h5>Posts</h5></a><br>
                </div>
                <div>
                    <a type="button" class="btn btn-info" href="categories.php"><h5>Catégories</h5></a><br>
                </div>
                <div>    
                    <a type="button" class="btn btn-info" href="tagsIndex.php"><h5>Tags</h5></a><br>
                </div>
            </div>
        </div>
    </div>

<!-- pagination tamata -->

<?php
    // On détermine sur quelle page on se trouve
    if (isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    } else {
        $currentPage = 1;
    }

    // On se connecte à là base de données
    require_once('functions_custom.php');

    // On détermine le nombre total d'articles
    $sql = 'SELECT COUNT(*) AS nbPost FROM `post`;';
    $pdo = pdo_connect_mysql();
    $conn = pdo_connect_mysql();

    // On prépare la requête
    $query = $conn->prepare($sql);

    // On exécute
    $query->execute();

    // On récupère le nombre d'articles
    $result = $query->fetch();
    $nbArticles = (int) $result['nbPost'];

    // On détermine le nombre d'articles par page
    $parPage = 2;

    // On calcule le nombre de pages total
    $pages = ceil($nbArticles / $parPage);

    // Calcul du 1er article de la page
    $premier = ($currentPage * $parPage) - $parPage;
    $sql = 'SELECT * FROM `post` ORDER BY `date_publication` DESC LIMIT :premier, :parpage;';

    // On prépare la requête
    $query = $conn->prepare($sql);
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

    // On exécute
    $query->execute();

    // On récupère les valeurs dans un tableau associatif
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($articles as $article){ ?>
    <div class="container">
        <article >
            <h3>
                <?php echo htmlspecialchars($article['titre']); ?><br>
                <em>le <?php echo $article['date_publication']; ?></em><br>
            </h3>
            <p style="text-align:justify;">
                <?php echo htmlspecialchars($article['contenu']); ?><br>
                <em><a href="comments.php?billet=<?php echo $article['id']; ?>">Commentaires</a></em>
            </p>
        </article>
    </div>
<?php } ?>

    <br>
    
    <nav>
        <ul class="pagination" style="justify-content:center;">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                <a href="./?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
            </li>
            <?php for($page = 1; $page <= $pages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                    <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                </li>
            <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                <a href="./?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
            </li>
        </ul>
    </nav>

<?php echo template_footer(); ?>





