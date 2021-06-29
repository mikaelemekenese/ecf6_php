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

	if (isset($_GET['id'])) {

		$pdo_stmt = $pdo->prepare('SELECT * FROM post WHERE id = ?');
		$pdo_stmt->execute([$_GET['id']]);
		$post = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

		if (!$post) {
			exit('Aucun post n\'existe avec cet ID!');
		}

		if (isset($_GET['confirm'])) {
			if ($_GET['confirm'] == 'yes') {
				$pdo_stmt = $pdo->prepare('DELETE FROM post WHERE id = ?');
				$pdo_stmt->execute([$_GET['id']]);
				$msg = 'Post supprimé !';
			} else {
				header('Location: posts.php');
				exit;
			}
		}
	}
?>

<?php echo template_header('Effacer un post')?>

	<div class="container">
		<br><h2>Supprimer le post #<?php echo $post['id'] ?></h2><br>

		<?php if ($msg): ?>
		<p><?=$msg?></p>
		<?php else: ?>

		<p>Souhaitez-vous vraiment supprimer le post #<?php echo $post['id'] ?> ("<?php echo $post['titre'] ?>") ?</p><br>

		<a href="post-delete.php?id=<?php echo $post['id'] ?>&confirm=yes" class="btn btn-success">Oui</a>
		<a href="post-delete.php?id=<?php echo $post['id'] ?>&confirm=no" class="btn btn-danger">Non</a>

		<?php endif; ?>
	</div>

<?php echo template_footer()?>