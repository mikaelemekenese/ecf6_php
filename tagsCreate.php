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
    $msg = '';

	if (!empty($_POST)) {

        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
		$nom_tag = isset($_POST['nom_tag']) ? htmlspecialchars($_POST['nom_tag']) : '';
		

		$pdo_stmt = $pdo->prepare('INSERT INTO tag VALUES (?, ?)');
									
		$pdo_stmt->execute([$id, $nom_tag]);
        $msg = 'Add with Success !';

        header('Location: tagsIndex.php');
        exit();
	}
?>

<?php echo template_header('tag/Create'); ?>

	<div class="content create">
        <h2>Ajouter un nouveau ''Tag'' :</h2>

        <form action="tagsCreate.php" method="POST">
            <div class="form-group">
                <label for="nom_tag">Nom</label>
                <input type="text" class="form-control" name="nom_tag" id="nom_tag">
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