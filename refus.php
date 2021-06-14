<?php
require("connexion.php");


if (isset($_GET['idvis']) AND !empty($_GET['idvis']) AND isset($_GET['moisfiche']) AND !empty($_GET['moisfiche']))
{
    
   $date_du_jour = date("Y-m-d");
    $id_visi = $_GET['idvis'];
    $moisV = $_GET['moisfiche'];
    $update = $db->query("UPDATE fichefrais  set etat = '3', dateModif = '$date_du_jour'  
    WHERE id_visiteur = '".$id_visi."'
    AND mois = '".$moisV."' " );
    //header("Refresh:0");
    header('Location: comptable.php');
   // echo $id_visi;

   /*print_r($update);
   var_dump($update);
   */
}

?>