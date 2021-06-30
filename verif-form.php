<?php

    include 'functions_custom.php';
    $conn= pdo_connect_mysql();
    session_start();
    
    
	$query = $conn->prepare("SELECT  titre FROM post WHERE titre LIKE '%Lorem%'");
	$query->execute();
    $row = $query->fetch()
    
    //if(isset($_GET['user'])){
    //$user = (String) trim($_GET['user']);
 
   // $query = $conn->prepare("SELECT *
   //   FROM post
   //   WHERE titre  
  //    LIMIT 10");
   
  // $query->execute();
  // $row = $query->fetch()
  

  
?>