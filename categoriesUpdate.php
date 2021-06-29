<?php
    include 'functions_custom.php';
    session_start();
    if (isset($_SESSION['nom_utilisateur']) && isset($_SESSION['mdp'])) {
        $mdp = $_SESSION['mdp'];
        echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_utilisateur'] ."</div>";
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
            $nom_cat = isset($_POST['nom_cat']) ? htmlspecialchars($_POST['nom_cat']) : '';
            $pdo_stmt = $pdo->prepare('UPDATE categories SET id = ?, nom_cat = ? WHERE id = ?');
            $pdo_stmt->execute([$id, $nom_cat, $_GET['id']]);

            header('Location: categories.php');
            exit();
        }
        $pdo_stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $pdo_stmt->execute([$_GET['id']]);
        $categories = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

    } else {
            exit('Pas d\'ID spécifié');
    }
?>

<?php echo template_header('Update'); ?>

    <div class="content update">
        <h2>Modifier les informations du categories #<?php echo $categories['id'] ?> (<?php echo $categories['nom_cat']?>) :</h2>

        <form action="categoriesUpdate.php?id=<?php echo $categories["id"] ?>" method="POST" style="display:block">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" name="nom_cat" value="<?php echo $categories['nom_cat']?>" id="nom_cat">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>

<?php echo template_footer(); ?>