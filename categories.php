<?php
    include 'functions_custom.php';
    $conn = pdo_connect_mysql();
    $reponse =$conn->query('SELECT * FROM categories');

    session_start();

    if (isset($_SESSION['nom_admin']) && isset($_SESSION['mdp'])) {
        $mdp = $_SESSION['mdp'];
        echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_admin'] ."</div>";
        echo "<style>#connected { display:none; }</style>";
    } else {
        echo "<style>#logout { display:none; }</style>";
        echo "<style>#post-create { display:none; }</style>";
        echo "<style>#createCat { display:none; }</style>";
        echo "<style>.actions { display:none; }</style>";
    }
    
    $pdo = pdo_connect_mysql(); 
        $msg = '';

$pdo = pdo_connect_mysql();

$pdo_stmt = $pdo->prepare('SELECT * FROM categories');
$pdo_stmt->execute();

$categories = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php echo template_header('Read'); ?>

<div class="content read">

	<div><h2>Liste des catégories du blog</h2> 
    <span><a id="createCat" href="categoriesCreate.php" class="add"><i class="fas fa-plus-square fa-xs"></i></a></span></div>

	<table class="table">
        <thead>
            <tr>
                <td>#</td>
                <td>Nom</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $categorie) : ?>
            <tr>
                <td><?php echo $categorie["id"] ?></td>
                <td><?php echo $categorie["nom_cat"] ?></td>
                <td class="actions">
                    <a href="categoriesUpdate.php?id=<?php echo $categorie["id"] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="categoriesDelete.php?id=<?php echo $categorie["id"] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<?php echo template_footer(); ?>