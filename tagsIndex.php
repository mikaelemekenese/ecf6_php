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
        echo "<style>#btntagcreate { display:none; }</style>";
        echo "<style>.actions { display:none; }</style>";
    }

    $pdo = pdo_connect_mysql();
        $msg = '';

$pdo = pdo_connect_mysql();

$pdo_stmt = $pdo->prepare('SELECT * FROM tag');
$pdo_stmt->execute();

$tags = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php echo template_header('Read'); ?>

<div class="content read">

	<div><h2>All Tags</h2> 
    <span><a id= "btntagcreate" href="tagsCreate.php" class="add"><i class="fas fa-plus-square fa-xs"></i></a></span></div>

	<table class="table">
        <thead>
            <tr>
                <td>#</td>
                <td>Nom</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $tag) : ?>
            <tr>
                <td><?php echo $tag["id"] ?></td>
                <td><?php echo $tag["nom_tag"] ?></td>
                <td class="actions">
                    <a href="tagsUpdate.php?id=<?php echo $tag["id"] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="tagsDelete.php?id=<?php echo $tag["id"] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<?php echo template_footer(); ?>

