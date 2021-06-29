<?php
    include 'functions_custom.php';

    session_start();

    if (isset($_SESSION['nom_admin']) && isset($_SESSION['mdp'])) {
        $mdp = $_SESSION['mdp'];
        echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_admin'] ."</div>";
        echo "<style>#connected { display:none; }</style>";
    } else {
        echo "<style>#logout { display:none; }</style>";
    }

        $pdo = pdo_connect_mysql();
        $msg = '';

    $pdo = pdo_connect_mysql();

    if (isset($_GET['id'])) {
        if (!empty($_POST)) {
            
            $id = $_GET['id'];

            $nom_tag = isset($_POST['nom_tag']) ? htmlspecialchars($_POST['nom_tag']) : '';
		    $reference = isset($_POST['reference']) ? htmlspecialchars($_POST['reference']) : '';

            $pdo_stmt = $pdo->prepare('UPDATE tag SET id = ?, nom_tag = ? WHERE id = ?');
            $pdo_stmt->execute([$id, $nom_tag, $_GET['id']]);

            header('Location: tagsIndex.php');
            exit();
        }

        $pdo_stmt = $pdo->prepare('SELECT * FROM tag WHERE id = ?');
        $pdo_stmt->execute([$_GET['id']]);
        $tag = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

    } else {
            exit('Pas d\'ID spécifié');
    }
?>

<?php echo template_header('Update'); ?>

    <div class="content update">
        <h2>Modifier les informations du rayon #<?php echo $tag['id'] ?> (<?php echo $tag['nom_tag']?>) :</h2>

        <form action="tagsUpdate.php?id=<?php echo $tag["id"] ?>" method="POST" style="display:block">
            <div class="form-group">
                <label for="name">Type</label>
                <input type="text" class="form-control" name="nom_tag" value="<?php echo $tag['nom_tag']?>" id="nom_tag">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>

<?php echo template_footer(); ?>