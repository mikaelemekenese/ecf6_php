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
        echo "<style>#delete-comm { display:none; }</style>";
    }

    $pdo = pdo_connect_mysql();
?>

<?php echo template_header('Article'); ?>

<div class="container">
        <div class="article">

            <?php     
                $req = $pdo->prepare('  SELECT  post.id, 
                                                post.titre, 
                                                post.contenu, 
                                                DATE_FORMAT(post.date_publication, \'%d/%m/%Y\') AS date_p 
                                        FROM    post
                                        WHERE   post.id = ?');
                $req->execute(array($_GET['billet']));
                $donnees = $req->fetch();
            ?>

            <h1>
                <?php echo htmlspecialchars($donnees['titre']); ?><br>
                <em>le <?php echo $donnees['date_p']; ?></em>
            </h1><br>
            
            <p><?php echo htmlspecialchars($donnees['contenu']); ?></p>
        </div>
    </div><br>

    <div class="container">
        <h3>Commentaires</h3><br>

        <a href="comments-create.php?billet=<?php echo $donnees['id']; ?>" class="btn btn-primary">Ajouter un commentaire</a><br><br>

        <?php
            $pdo_stmt = $pdo->prepare(' SELECT  comments.id, 
                                                comments.commentaire, 
                                                comments.date_comm, 
                                                comments.user_email, 
                                                comments.post_id
                                        FROM    comments');

            $pdo_stmt->execute();

            $comms = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Email</td>
                    <td>Commentaire</td>
                    <td>Date de publication</td>
                    <td>ID Post</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comms as $comm) : 
                    if ($donnees['id'] == $comm['post_id']) : ?>
                        <tr>
                            <td><?php echo $comm["id"] ?></td>
                            <td><?php echo $comm["user_email"] ?></td>
                            <td><?php echo $comm["commentaire"] ?></td>
                            <td><?php echo $comm["date_comm"] ?></td>
                            <td><?php echo $comm["post_id"] ?></td>
                            <td class="actions">
                                <a href="comments-delete.php?id=<?php echo $comm["id"] ?>" class="btn btn-danger" id="delete-comm">Supprimer</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php echo template_footer(); ?>