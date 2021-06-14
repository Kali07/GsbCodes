<?php 
include("header.php") ; 
require("connexion.php");
$id_user = $_SESSION['id_user'];
$mois_encours = date('m');


//faire 3 requettes pour recuperer les km, repas et nuitee 

if(isset($_POST['valid']))
{
  $mois_voulu = $_POST['moisD'];

  // requette repas 
  $repas = $db->query("SELECT quantite, l.id_frais, ff.dateModif, et.libelle 
  from  user u, lignefraisforfait l, fraisforfait f, fichefrais ff, etat et 
  where u.id_user = l.id_user and  l.id_frais = f.id_frais
  and ff.mois = l.mois and l.id_frais = 1
  and l.mois = $mois_voulu and  et.id_etat = ff.etat 
  and u.id_user = $id_user ");

$rrepas = $repas->fetch(); 

//requette Nuitee 

$nuitee = $db->query("SELECT quantite, l.id_frais, ff.dateModif, et.libelle 
from  user u, lignefraisforfait l, fraisforfait f, fichefrais ff, etat et 
where u.id_user = l.id_user and  l.id_frais = f.id_frais
and ff.mois = l.mois and l.id_frais = 2
and l.mois = $mois_voulu and  et.id_etat = ff.etat 
and u.id_user = $id_user ");


$rnuitee = $nuitee->fetch();


  //requette Km

  $km = $db->query("SELECT quantite, l.id_frais, ff.dateModif, et.libelle 
  from  user u, lignefraisforfait l, fraisforfait f, fichefrais ff, etat et 
  where u.id_user = l.id_user and  l.id_frais = f.id_frais
  and ff.mois = l.mois and l.id_frais = 3
  and l.mois = $mois_voulu and  et.id_etat = ff.etat 
  and u.id_user = $id_user ");

$rkm = $km->fetch();


//requette pour la date 

$dateMod = $db->query("SELECT dateModif from fichefrais
WHERE id_visiteur = $id_user AND mois = $mois_voulu ");

$recupdate = $dateMod->fetch();
  
//requette pour l'etat 

$etatfiche = $db->query("SELECT libelle from etat,fichefrais
WHERE etat = id_etat and id_visiteur = $id_user AND mois = $mois_voulu ");

$recupetat = $etatfiche->fetch();
  //requettes  initiale 


}




//Mes ajouts 
if(isset($_POST['send']))
{
    
    $repas = $_POST['repasM'];
    $nuitee = $_POST['nuitee'];
    $km = $_POST['km'];

    $date_du_jour = date("Y-m-d");



    if(isset($repas) and !empty($repas))
    {
        $repas= $db->query("INSERT INTO lignefraisforfait(id_user,id_frais,mois,quantite)
                            VALUES('$id_user',1,'$mois_encours','$repas') "); 
    }

    if(isset($nuitee) and !empty($nuitee))
    {
        $nuitee= $db->query("INSERT INTO lignefraisforfait(id_user,id_frais,mois,quantite)
                            VALUES('$id_user',2,'$mois_encours','$nuitee') "); 
    }

    if(isset($km) and !empty($km))
    {
        $km= $db->query("INSERT INTO lignefraisforfait(id_user,id_frais,mois,quantite)
                            VALUES('$id_user',3,'$mois_encours','$km') "); 
    }

    $fiche= $db->query("INSERT INTO fichefrais(mois,id_visiteur,dateModif)
    VALUES('$mois_encours','$id_user','$date_du_jour') "); 

    header("Refresh:0");

}


?>


<section class="container-fluid p-5">
    <div class="row">
    <aside class="col-6">



        <table class="table table-hover">
        <h4 class="mb-3"> Frais au Forfait </h4>


    <form method = "POST"  action ="profil.php">
     <div class="form-group col-md-4">
      <label for="inputState">State</label>
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
      <button type="submit" name ="valid" class="btn btn-primary mb-2">Submit</button>
    </div>
    
    </form>


        <thead>
            <tr>
            <th scope="col">Repas midi </th>
            <th scope="col">Nuitée </th>
            <th scope="col"> Km </th> 
            <th scope="col"> Situation </th>
            
            <th scope="col"> Date opération </th> 
            </tr>
        </thead>
        <tbody>
            <tr>
        <?php
        //pour eviter l'erreur de la non soumission du formulaire de filtre
            if(isset($_POST['valid'])){

            ?>
      
            <td> <?=$rrepas['quantite']?> </td>
                

            <td> <?=$rnuitee['quantite']?> </td>
            

            <td> <?=$rkm['quantite']?> </td>

            <td> <?=$recupetat['libelle']?> </td>

            <td> <?=$recupdate['dateModif']?> </td>


            

            
        <?php 
            }
            ?>
        </tr>
                
        
        </tbody>
        </table>

<!-- Partie hors forfait -->

        <table class="table table-hover">
        <h4 class="mb-3"> Hors Forfaits </h4>
        <thead>
            <tr>
            <th scope="col">Date </th>
            <th scope="col">Libellé </th>
            <th scope="col">Montant </th>
            <th scope="col"> Situation </th>
            <th scope="col"> Date opération </th> 
            </tr>
        </thead>
        <tbody>


        </tbody>
        </table>

<!-- Hors classification -->
        <table class="table table-hover">
        <h4 class="mb-3"> Hors Classification </h4>
        <thead>
            <tr>
            <th scope="col">Nb Justificatif </th>
            <th scope="col"> Montant </th>
            <th scope="col">Sitation </th>
            
            <th scope="col"> Date opération </th> 
            </tr>
        </thead>
        <tbody>
        

        </tbody>
        </table>

        
    </aside>



<!-- Partie Formulaire -->
    <aside class="col-6">
        <div class="row">
            <div class="col-md-10 order-md-2 mb-4">
            <h4 class="mb-3">Saisir une Fiche </h4>
            <form method = "POST"  action ="profil.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="mb-3 col-6">
                    <label for="Mois">Mois</label>
                    <input type="number" class="form-control" id="mois" name="mois" placeholder="<?=date("M")?>" disabled>
                </div>

                <div class="mb-3 col-6">
                    <label for="annee">Annee</label>
                    <input type="number" class="form-control" id="annee" name="annee" placeholder="<?=date("Y")?>" disabled>
                </div>
                
                </div>


                <div class="row">
                    <div class="mb-3 col-6">
                    <label for="repasM">Repas Midi</label>
                    <input type="text" class="form-control" id="repasM" name="repasM" placeholder="repas midi" >
                </div>

                <div class="mb-3 col-6">
                    <label for="nuitee">Nuitee</label>
                    <input type="number" class="form-control" id="nuitee" name="nuitee" placeholder="Nuitee" >



                    <label for="km">Km</label>
                    <input type="number" class="form-control" id="km" name="km" placeholder="km/h" >
            
                </div>
                
                </div>



                
                <h5 class="mb-3">Frais Hors forfaits  </h5>

                <div class="mb-3 col-6">

                    <label for="date">Date </label>
                    <input type="date" class="form-control" id="km" name="datehf" placeholder="km/h" >
                        
                    <label for="libelle">Libelle</label>
                    <input type="text" class="form-control" id="nuitee" name="libelehf" placeholder="libellé" >



            
                </div>
                
                <hr class="mb-4">
                <button class="btn btn-success btn-lg btn-block" name ="send" type="submit">Envoyer</button>
            </form>
            </div>
        </div>
    </aside>
    </div>   
   



</section>