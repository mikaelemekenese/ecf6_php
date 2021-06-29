<?php
	include 'functions_custom.php';

    session_start();

    if (isset($_SESSION['nom_cat_admin']) && isset($_SESSION['mdp'])) {
        $mdp = $_SESSION['mdp'];
        echo "<div class='connected'>Connecté en tant que ". $login = $_SESSION['nom_cat_admin'] ."</div>";
        echo "<style>#connected { display:none; }</style>";
    } else {
        echo "<style>#logout { display:none; }</style>";
        echo "<style>#logout { display:none; }</style>";
        echo "<style>#logout { display:none; }</style>";
    }

        $pdo = pdo_connect_mysql();
        $msg = '';

	$pdo = pdo_connect_mysql();
    $msg = '';

	if (!empty($_POST)) {

        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
		$nom_cat = isset($_POST['nom_cat']) ? htmlspecialchars($_POST['nom_cat']) : '';
		

		$pdo_stmt = $pdo->prepare('INSERT INTO categories VALUES (?, ?)');
									
		$pdo_stmt->execute([$id, $nom_cat]);
        $msg = 'Ajouté avec succès !';

        header('Location: categories.php');
        exit();
	}
?>

<?php echo template_header('Categories/Create'); ?>

	<div class="content create">
        <h2>Ajouter un nouveau categories à la bibliotheque :</h2>

        <form action="categoriesCreate.php" method="POST">
            <div class="form-group">
                <label for="nom_cat">nom_cat</label>
                <input type="text" class="form-control" name="nom_cat" id="nom_cat">
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

