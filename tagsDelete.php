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

		$pdo_stmt = $pdo->prepare('SELECT * FROM tag WHERE id = ?');
		$pdo_stmt->execute([$_GET['id']]);
		$tag = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($_GET['confirm'])) {
			if ($_GET['confirm'] == 'yes') {
				$pdo_stmt = $pdo->prepare('DELETE FROM tag WHERE id = ?');
				$pdo_stmt->execute([$_GET['id']]);
				header('Location: tagsIndex.php');
			} else {
				header('Location: tagsIndex.php');
				exit;
			}
		}
	}
?>

<?php echo template_header('Delete')?>

	<div class="container">
		<br><h2>Supprimer le tag #<?php echo $tag['id'] ?></h2><br>

		<p>Souhaitez-vous vraiment supprimer le tag #<?php echo $tag['id'] ?> (<?php echo $tag['nom_tag'] ?>) ?</p><br>

		<a href="tagsDelete.php?id=<?php echo $tag['id'] ?>&confirm=yes" class="btn btn-success">Oui</a>
		<a href="tagsDelete.php?id=<?php echo $tag['id'] ?>&confirm=no" class="btn btn-danger">Non</a>
	</div>

<?php echo template_footer()?> 

<!-- L'admin peut delete un tag -->