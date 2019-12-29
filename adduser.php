<?php
require_once 'config/init.conf.php'; //Fait appel au fichier init.conf
require_once 'config/bdd.conf.php'; //Fait appel au fichier bdd.conf
require_once 'config/connexion.conf.php'; //Fait appel au fichier connexion.conf
print_r2($_POST); 

if(isset($_POST['bouton'])){ //Récupère les valeurs du formulaire lors de la soumission du formulaire
	$nom = $_POST['nom']; //Récupère la valeur nom
	$prenom = $_POST['prenom'];//Récupère la valeur prenom
	$email = $_POST['email'];//Récupère la valeur email
	$mdp = $_POST['mdp'];//Récupère la valeur mdp


$sth = $bdd->prepare("INSERT INTO utilisateur "
		. "(nom, prenom, email, mdp)"
		. "VALUES (:nom, :prenom, :email, :mdp)"); //Requête SQL pour insérer les valeurs dans la BDD
		
$sth->bindValue(":nom" , $nom, PDO::PARAM_STR); //Assigne la valeur nom
$sth->bindValue(":prenom" , $prenom, PDO::PARAM_STR);//Assigne la valeur prenom	
$sth->bindValue(":email" , $email, PDO::PARAM_STR);//Assigne la valeur email
$sth->bindValue(":mdp" , $mdp, PDO::PARAM_STR);//Assigne la valeur mdp
$alerte = $sth->execute(); //Execute la requête
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <?php include_once 'includes/header.inc.php'; ?> <!-- Inclus les informations du fichier header pour l'affichage de l'entête -->

</head>

<body>

  <!-- Navigation -->
  <?php include_once 'includes/menu.inc.php'; ?> <!-- Inclus les informations du fichier menu pour l'affichage du menu -->
 
   <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Formulaire</h1><br/> <!-- Titre 1 -->
        <h2>Ajouter un utilisateur</h2> <!-- Titre de la page -->
      </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
          <form method="post" enctype='multipart/form-data' action="adduser.php"> <!-- Création du formulaire -->
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="nom" class="form-control" id="nom" name="nom"> <!-- Création du champ nom -->
            </div>
			<div class="form-group">
              <label for="prenom">Prenom</label>
              <input type="prenom" class="form-control" id="prenom" name="prenom"> <!-- Création du champ prenom -->
            </div>
			<div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email"> <!-- Création du champ email -->
            </div>
			<div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control" id="mdp" name="mdp"> <!-- Création du champ mot de passe -->
            </div>
            <button type="submit" class="btn btn-primary" name="bouton">Valider la saisie</button> <!-- Bouton pour valider la saisie du formulaire -->
          </form>
        </div>
    </div>
  </div>

  <?php include_once 'includes/footer.inc.php'; ?> <!-- Inclus les informations du fichier pour l'affichage du footer -->
</body>

</html>
