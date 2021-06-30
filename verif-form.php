<?php

    include 'functions_custom.php';
    $conn= pdo_connect_mysql();
    session_start();
    
    $Lorem=$_POST['search'];
	$query = $conn->prepare("SELECT  titre , contenu FROM post WHERE titre LIKE '%$Lorem%'");
	$query->execute();
    $row = $query->fetch();
  

?>
<?php echo template_header('Accueil'); ?>
<?php while ($post = $query->fetch()) { ?>
        <article>
            <h3>
                <?php echo htmlspecialchars($post['titre']); ?><br>
               
            </h3>
            <p>
                <?php echo htmlspecialchars($post['contenu']); ?><br>
            </p>
        </article>
    <?php } $query->closeCursor(); ?>

    <?php echo template_footer(); ?>
    
   
  

  
