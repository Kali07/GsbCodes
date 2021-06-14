<?php
include("header.php") ;
require("connexion.php");

if(isset($_POST['email']) and isset($_POST['mdp']))
{
    $log = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars(hash('sha256',$_POST['mdp'])); 

   if(!empty($log) and !empty($mdp)){
    $req = $db->prepare("SELECT * FROM User, Statut st WHERE email=:email AND mdp =:mdp 
    AND statut = id_statut");
    $req->execute(array(':email'=>$log,
                        ':mdp'=>$mdp));
    $find = $req->fetch();
    if($find){
      $_SESSION['id_user'] = $find['id_user'];
      $_SESSION['prenom'] = $find['prenom'];
      $_SESSION['nom'] = $find['nom'];
      $_SESSION['statut'] = $find['libelle'];
      
        if($find['statut'] == 2){
            header('Location: profil.php');
        }else if($find['statut'] == 1){
          header('Location: comptable.php');
        }
      //echo $find['libelle'];
    }
    else{
      echo '<h4> Identifiant ou mot de passe incorrect </h4>';
    }
  }
}

?>

<section class="container">
<div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="mb-3">Connexion</h4>
      <form method = "POST"  action ="index.php" >
        <div class="row">
          <div class="mb-3">
            <label for="email">Votre mail</label>
            <div class="input-group">
              <div class="input-group-prepend">
              </div>
              <input type="email" name="email" class="form-control" id="email" placeholder="votremail@exemple.com" required>
            </div>
        </div>

        <div class="mb-3">
          <label for="mdp">Mot de passe</label>
          <input type="password" name="mdp" class="form-control" id="mdp" placeholder="*********" required>
        </div>

        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Se connecter</button>
      </form>

    </div>
  </div>

</section>