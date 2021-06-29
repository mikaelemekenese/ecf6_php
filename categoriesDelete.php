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

		$pdo_stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
		$pdo_stmt->execute([$_GET['id']]);
		$categories = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($_GET['confirm'])) {
			if ($_GET['confirm'] == 'yes') {
				$pdo_stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
				$pdo_stmt->execute([$_GET['id']]);
				header('Location: categories.php');
			} else {
				header('Location: categories.php');
				exit;
			}
		}
	}
?>

<?php echo template_header('Delete')?>

	<div class="container">
		<br><h2>Supprimer le categories #<?php echo $categories['id'] ?></h2><br>

		<p>Souhaitez-vous vraiment supprimer le categories #<?php echo $categories['id'] ?> (<?php echo $categories['nom_cat'] ?>) ?</p><br>

		<a href="categoriesDelete.php?id=<?php echo $categories['id'] ?>&confirm=yes" class="btn btn-success">Oui</a>
		<a href="categories.php?id=<?php echo $categories['id'] ?>&confirm=no" class="btn btn-danger">Non</a>
	</div>

<?php echo template_footer()?>