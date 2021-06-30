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
    
    $pdo = pdo_connect_mysql();

    $pdo_stmt = $pdo->prepare(' SELECT  post.id, 
                                        post.titre, 
                                        post.date_publication, 
                                        admins.nom_admin, 
                                        categories.nom_cat,
                                        tag.nom_tag 
                                FROM    post
                                LEFT JOIN admins 
                                ON      post.admin_id = admins.id
                                LEFT JOIN categories
                                ON      post.cat_id = categories.id
                                LEFT JOIN tag
                                ON      post.tag_id = tag.id');
                                
    $pdo_stmt->execute();

    $posts = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php echo template_header('Liste des posts'); ?>

    <div class="content read" style="width:90%;">

        <div><h2>Liste des posts du blog</h2> 
        <span><a href="post-create.php" class="add" id="add-post"><i class="fas fa-plus-square fa-xs"></i></a></span></div>

        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Titre</td>
                    <td>Date de publication</td>
                    <td>Admin</td>
                    <td>Catégorie</td>
                    <td>Tag</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) : ?>
                <tr>
                    <td><?php echo $post["id"] ?></td>
                    <td><?php echo $post["titre"] ?></td>
                    <td><?php echo $post["date_publication"] ?></td>
                    <td><?php echo $post["nom_admin"] ?></td>
                    <td><?php echo $post["nom_cat"] ?></td>
                    <td><?php echo $post["nom_tag"] ?></td>
                    <td class="actions">
                        <a href="comments.php?billet=<?php echo $post['id']; ?>" class="read-more"><i class="fas fa-book fa-xs"></i></a>
                        <a href="post-update.php?id=<?php echo $post["id"] ?>" class="edit" id="edit-post"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="post-delete.php?id=<?php echo $post["id"] ?>" class="trash" id="delete-post"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php echo template_footer(); ?>