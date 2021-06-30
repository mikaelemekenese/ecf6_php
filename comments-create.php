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
?>

<?php echo template_header('Article'); ?>

<div class="container comment"><br><br>

    <?php 
        if (!empty($_POST)) {

            $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
            $commentaire = isset($_POST['commentaire']) ? htmlspecialchars($_POST['commentaire']) : '';
            $date_comm = isset($_POST['date_comm']) ? htmlspecialchars(date('Y-m-d', strtotime($_POST['date_comm']))) : date('Y-m-d');
            $user_email = isset($_POST['user_email']) ? htmlspecialchars($_POST['user_email']) : '';
            $post_id = isset($_POST['post_id']) ? htmlspecialchars($_POST['post_id']) : '';

            $pdo_stmt = $pdo->prepare('INSERT INTO comments VALUES (?, ?, ?, ?, ?)');
                                    
            $pdo_stmt->execute([$id, $commentaire, $date_comm, $user_email, $post_id]);
        }
    ?>

    <h4>Ajouter un commentaire :</h4><br>

    <?php     
        $req = $pdo->prepare('SELECT post.id FROM post WHERE post.id = ?');
        $req->execute(array($_GET['billet']));
        $donnees = $req->fetch();
    ?>

    <form action="comments-create.php?billet=<?php echo $donnees['id'] ?>" method="POST">
        <div class="form-group">
            <label for="user_email">Email</label>
            <input type="text" class="form-control" name="user_email" id="user_email">
        </div>
        <div class="form-group">
            <label for="commentaire">Commentaire</label>
            <textarea type="text" class="form-control" name="commentaire" id="commentaire" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="date_comm">Date</label>
            <input type="date" class="form-control" name="date_comm" id="date_comm">
        </div>
        <div class="form-group">
            <label for="post_id">ID Post</label>
            <input type="text" class="form-control" name="post_id" id="post_id" value="<?php echo $donnees['id'] ?>" readonly>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Ajouter">
        </div>

        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>
    </form>
</div>