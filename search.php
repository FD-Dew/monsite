<?php
require_once 'config/init.conf.php'; //Fait appel au fichier init.conf
require_once 'config/bdd.conf.php'; //Fait appel au fichier bdd.conf
require_once 'config/connexion.conf.php'; //Fait appel au fichier connexion.conf
/* @var $bdd PDO */

if(!empty($_GET['recherche'])){ //Si le champ est différent de vide alors on récupère la valeur
	print_r2($_GET);
	
	$sth = $bdd->prepare("SELECT id, "
			. "titre, "
			. "texte, "
			. "DATE_FORMAT(date, '%d/%m/%Y') AS date_fr, "
			. "publie, "
			. "FROM articles, "
			. "WHERE publie = :publie"
			. "AND (titre LIKE :recherche OR texte LIKE :recherche) "
			. "LIMIT :index, :nb_art_par_page"); //Requête SQL pour sélectionner dans la BDD
			
	$sth->bindValue(':publie', 1, PDO::PARAM_BOOL);//Paramètre de la requete 
	$sth->bindValue(':index', $index, PDO::PARAM_INT);
	$sth->bindValue(':recherche', '%' . $_GET['recherche'] . '%', PDO::PARAM_INT);
	$sth->bindValue(':_nb_art_par_page', _nb_art_par_page, PDO::PARAM_INT);
	$sth->execute();    //Execution de la requête
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
  <!-- Page Content -->
 
     </div>
			<div class="row">
        <div class="col-lg-12">
          <form method="post" enctype='multipart/form-data' action="search.php"> <!-- Création du formulaire pour la recherche -->
            <div class="form-group">
              <label for="nom">Recherche</label>
              <input type="nom" class="form-control" id="recherche" name="recherche"> <!-- Création du champ recherche -->
            </div>
			<button type="submit" class="btn btn-primary" name="bouton">Valider la saisie</button> <!-- Bouton pour valider la saisie -->
          </form>
		</div>
	  </div>
  </div>
  <!-- Footer -->
  <?php include_once 'includes/footer.inc.php'; ?><!-- Inclus les informations du fichier footer pour l'affichage du bas de la page -->
</body>

</html>
	