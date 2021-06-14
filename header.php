<html lang="fr">
<?php session_start(); ?>
  <head>
    <meta charset="utf-8">
    <title>GSB </title>
    <link href="css/bootstrap.css" rel="stylesheet">
    
  </head>

  <body>

<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal"><img src ="logo.png" alt="pas image" width="80" height="115"> </h5>
  <nav class="my-2 my-md-0 mr-md-3">
  
  <?php
  $statut = null;
  if( isset($_SESSION['id_user']) ){
  $statut = $_SESSION['statut']; ?> 
  <a class="p-2 text-dark" href="accueil.php"><strong>Bienvenu  <?=$_SESSION['nom']?></strong></a> 

  <?php } ?>

  <a class="p-2 text-dark" href="#">Accueil</a>

  <?php if( $statut == 'Visiteur' or $statut == 'Comptable') { ?>
  <a class="btn btn-outline-danger" href="deconnexion.php">Deconnexion</a>
  <?php }  ?>
  </nav>
  
</header>