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

	if (isset($_GET['id'])) {

		$pdo_stmt = $pdo->prepare('SELECT * FROM comments WHERE id = ?');
		$pdo_stmt->execute([$_GET['id']]);
		$comm = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($_GET['confirm'])) {
			if ($_GET['confirm'] == 'yes') {
				$pdo_stmt = $pdo->prepare('DELETE FROM comments WHERE id = ?');
				$pdo_stmt->execute([$_GET['id']]);
				$msg = 'Commentaire supprimé !';
			} else {
				header('Location: comments.php');
				exit;
			}
		}
	}
?>

<?php echo template_header('Supprimer un commentaire')?>

	<div class="container">
		<br><h2>Supprimer le commentaire #<?php echo $comm['id'] ?></h2><br>

		<?php if ($msg): ?>
		<p><?=$msg?></p>
		<?php else: ?>

		<p>Souhaitez-vous vraiment supprimer le commentaire #<?php echo $comm['id'] ?> ?</p><br>

		<a href="comments-delete.php?id=<?php echo $comm['id'] ?>&confirm=yes" class="btn btn-success">Oui</a>
		<a href="comments-delete.php?id=<?php echo $comm['id'] ?>&confirm=no" class="btn btn-danger">Non</a>

		<?php endif; ?>
	</div>

<?php echo template_footer()?>