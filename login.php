<?php
require_once 'config/init.conf.php'; //Fait appel au fichier init.conf
require_once 'config/bdd.conf.php'; //Fait appel au fichier bdd.conf
require_once 'config/connexion.conf.php'; //Fait appel au fichier connexion.conf

//print_r2($_POST);

if(isset($_POST['bouton'])){ //Récupère les valeurs du formulaire lors de la soumission du formulaire
	//print_r2($_POST);
	$email = $_POST['email']; //Récupère la valeur email
	$mdp = $_POST['mdp']; //Récupère la valeur mdp
	
    $sth = $bdd->prepare("SELECT *"
		. "FROM utilisateur"
		. "WHERE email = :email AND mdp = :mdp"); //Requête SQL pour chercher des valeurs correspondantes dans la BDD

		$sth->bindValue(":email" , $email, PDO::PARAM_STR); //Assigne la valeur email
		$sth->bindValue(":mdp" , $mdp, PDO::PARAM_STR); //Assigne la valeur mdp
		
		$sth->execute(); //Execution de la requête
		
		if($sth->rowCount()>1){ //On compte le nombre d'enregistrement
			$donnees = $sth->fetch(PDO::FETCH_ASSOC); 
			$sid = $donnees['email'] . time(); //sid est égale à la valeur données en fonction de l'email plus le temps 
			$sid_hache = md5($sid); //hashage du sid avec md5
			//echo $sid_hache
			
			setcookie("sid", $sid_hache, time() + 200); //création du cookie
			
			$sth_update = $bdd->prepare("UPDATE utilisateur "
				. "SET sid = :sid "
				. "WHERE id = :id"); //Mise à jour de la BDD
						
		$sth_update->bindValue(":sid" , $sid_hache, PDO::PARAM_STR); //Assigne la valeur sid
		$sth_update->bindValue(":id" , $donnees['id'], PDO::PARAM_INT); //Assigne la valeur id
		
		$result_connexion = $sth_update->execute(); //Execute la requête
		//var_dump($std_update);
		
		header('Location: index.php');//Redirige vers la page d'accueil
		exit();
		} else {
			
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
        <h1 class="mt-5">Formulaire</h1><br/> <!-- Titre de la page -->
        <h2>Connexion</h2> <!-- Titre 2 de la pge -->
      </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
          <form method="post" enctype='multipart/form-data' action="login.php"> <!-- Création du formulaire pour la connexion -->
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
<?php } ?>