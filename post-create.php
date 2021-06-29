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
    $msg = '';

	if (!empty($_POST)) {

        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;

		$titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
		$contenu = isset($_POST['contenu']) ? htmlspecialchars($_POST['contenu']) : '';
        $date_publication = isset($_POST['date_publication']) ? htmlspecialchars(date('Y-m-d', strtotime($_POST['date_publication']))) : date('Y-m-d');
		$admin_id = isset($_POST['admin_id']) ? htmlspecialchars($_POST['admin_id']) : '';
        $cat_id = isset($_POST['cat_id']) ? htmlspecialchars($_POST['cat_id']) : '';
        $tag_id = isset($_POST['tag_id']) ? htmlspecialchars($_POST['tag_id']) : '';

		$pdo_stmt = $pdo->prepare('	INSERT INTO post
									VALUES 	(?, ?, ?, ?, ?, ?, ?)');
									
		$pdo_stmt->execute([$id, $titre, $contenu, $date_publication, $admin_id, $cat_id, $tag_id]);

        $msg = 'Ajouté avec succès !';

        header('Location: index.php');
        exit();
	}
?>

<?php echo template_header('Créer un post'); ?>

<div class="content create">
        <h2>Ajouter un nouveau post :</h2>

        <form action="post-create.php" method="POST">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" name="titre" id="titre">
            </div>
            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea type="text" class="form-control" name="contenu" id="contenu" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="date_publication">Date de publication</label>
                <input type="date" class="form-control" name="date_publication" id="date_publication">
            </div>
            <div class="form-group">
                <label for="admin_id">ID Admin</label>
                <input type="text" class="form-control" name="admin_id" id="admin_id">
            </div>
            <div class="form-group">
                <label for="cat_id">ID Catégorie</label>
                <input type="text" class="form-control" name="cat_id" id="cat_id">
            </div>
            <div class="form-group">
                <label for="tag_id">ID Tag</label>
                <input type="text" class="form-control" name="tag_id" id="tag_id">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-info" value="Ajouter">
            </div>
        </form>

        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>

    </div>

<?php echo template_footer(); ?>