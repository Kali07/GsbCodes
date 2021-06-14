<?php
require("connexion.php");
/*
Traiter la validation 
*/
//$_SESSION['inter'] = $_GET['idvis']; 

if (isset($_GET['idvis']) AND !empty($_GET['idvis']) AND isset($_GET['moisfiche']) AND !empty($_GET['moisfiche']))
{
    
    
   $date_du_jour = date("Y-m-d");
    $id_visi = $_GET['idvis'];
    $moisV = $_GET['moisfiche'];
    $update = $db->query("UPDATE fichefrais  set etat = '2', dateModif = '$date_du_jour'  
    WHERE id_visiteur = '".$id_visi."'
    AND mois = '".$moisV."' " );
    
    
   // echo $id_visi;
}

header('Location: comptable.php');

?>