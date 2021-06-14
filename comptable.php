<?php 
include("header.php") ; 
require("connexion.php");


$requete = $db->query("SELECT  id_user, nom, prenom from user where statut = 2 ");

if(isset($_POST['confirmation']))
{
   
    
    $userid = $_POST['userid'];
    $moisselect = $_POST['moisD'];




$requete2 = $db->query("SELECT  ff.dateModif, et.libelle, u.nom, u.id_user  
from  user u, fichefrais ff, etat et 
where u.id_user = ff.id_visiteur and ff.mois = $moisselect and  et.id_etat = ff.etat 
and u.id_user = $userid and ff.etat = 1"); 



$fiche = $requete2->fetch(); 


}






?>



<section class="container-fluid p-5">
    <div class="row">
    <aside class="col-6">

    <form method = "POST"  action ="comptable.php">

     <div class="form-group col-md-4">
      <label for="inputState"> Liste utilisateurs </label>
      
      <select id="inputState" class="form-control" name ="userid">
        <?php 
        
        while($user = $requete->fetch()){  ?>

        <option value = <?=$user['id_user'] ?> > <?=$user['nom'] ?> </option>
        <?php
                }
                $requete->closeCursor();
                ?> 
      </select>

      <select id="inputState" class="form-control" name ="moisD">
        <option value = 1 >JAN</option>
        <option value = 2>FEB</option>
        <option value = 3>MAR</option>
        <option value = 4>AVR</option>
        <option value = 5>MAI</option>
        <option value = 6>JUIN</option>
        <option value = 7>JUILLET</option>
        <option value = 8>AOUT</option>
        <option value = 9>SEP</option>
        <option value = 10>OCT</option>
        <option value = 11>NOV</option>
        <option value = 12>DEC</option>
      </select>

      <button type="submit" name ="confirmation" class="btn btn-primary mb-2">Submit</button>
    </div>
    
    </form>


        <table class="table table-hover">
        <h4 class="mb-3"> Demandes </h4>
        <thead>
            <tr>
            <th scope="col">Numero </th>
            <th scope="col">Nom </th>
            <th scope="col">Date </th>
            <th scope="col"> Statut </th>
            <th scope="col"> Actions </th>
             
            </tr>
        </thead>
        <tbody>
                <?php if (isset($fiche['id_user'] )) 
                {
                ?>
            <td> <?=$fiche['id_user']?> </td>
                

            <td> <?=$fiche['nom']?> </td>
            

            <td> <?=$fiche['dateModif']?> </td>

            <td> <?=$fiche['libelle']?> </td>
                    <?php
                }
                ?>
            <td> <a class="btn btn-primary" href="traitement.php?idvis=<?=$fiche['id_user']?>&moisfiche=<?=$_POST['moisD']?>" 
            role="button"> Valider </a>
                 <a class="btn btn-danger" href="refus.php?idvis=<?=$fiche['id_user']?>&moisfiche=<?=$_POST['moisD']?>" 
                 role="button"> Refuser  </a> </td>
            
        
        </tr>

        </tbody>
        </table>
        
    </aside>
</section>