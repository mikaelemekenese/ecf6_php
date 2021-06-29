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

    if (isset($_GET['id'])) {
        if (!empty($_POST)) {
            $id = $_GET['id'];
            $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '';
			$contenu = isset($_POST['contenu']) ? htmlspecialchars($_POST['contenu']) : '';
			$date_publication = isset($_POST['date_publication']) ? htmlspecialchars(date('Y-m-d', strtotime($_POST['date_publication']))) : date('Y-m-d');
			$admin_id = isset($_POST['admin_id']) ? htmlspecialchars($_POST['admin_id']) : '';
            $cat_id = isset($_POST['cat_id']) ? htmlspecialchars($_POST['cat_id']) : '';
            $tag_id = isset($_POST['tag_id']) ? htmlspecialchars($_POST['tag_id']) : '';

            $pdo_stmt = $pdo->prepare(' UPDATE  post
                                        SET     id = ?, 
                                                titre = ?, 
                                                contenu = ?, 
                                                date_publication = ?, 
                                                admin_id = ?,
                                                cat_id = ?,
                                                tag_id = ?
                                        WHERE   id = ?');

            $pdo_stmt->execute([$id, $titre, $contenu, $date_publication, $admin_id, $cat_id, $tag_id, $id]);
            $msg = 'Edité avec succès !';

            header('Location: posts.php');
            exit();
        }

        $pdo_stmt = $pdo->prepare('SELECT * FROM post WHERE id = ?');
        $pdo_stmt->execute([$_GET['id']]);
        $post = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            exit('Aucun post n\'existe avec cet ID !');
        }

    } else {
            exit('Pas d\'ID spécifié');
    }
?>

<?php echo template_header('Editer le post'); ?>

    <div class="content update">
        <h2>Modifier les informations du post #<?php echo $post['id'] ?> ("<?php echo $post['titre'] ?>") :</h2>

        <form action="post-update.php?id=<?php echo $post["id"] ?>" method="POST" style="display:block">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" name="titre" value="<?php echo $post['titre'] ?>" id="titre">
            </div>
            <div class="form-group">
                <label for="contenu">Contenu</label>
                <input type="text" class="form-control" name="contenu" value="<?php echo $post['contenu'] ?>" id="contenu">
            </div>
            <div class="form-group">
                <label for="date">Date de publication</label>
                <input type="date" class="form-control" name="date" value="<?php echo $post['date_publication'] ?>" id="date">
            </div>
            <div class="form-group">
                <label for="admin_id">Admin</label>
                <input type="text" class="form-control" name="admin_id" value="<?php echo $post['admin_id'] ?>" id="admin_id">
            </div>
            <div class="form-group">
                <label for="cat_id">Admin</label>
                <input type="text" class="form-control" name="cat_id" value="<?php echo $post['cat_id'] ?>" id="cat_id">
            </div>
            <div class="form-group">
                <label for="tag_id">Admin</label>
                <input type="text" class="form-control" name="tag_id" value="<?php echo $post['tag_id'] ?>" id="tag_id">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>

        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?php echo template_footer(); ?>