<?php 
require_once 'config/init.conf.php'; //Fait appel au fichier init.conf
require_once 'config/bdd.conf.php'; //Fait appel au fichier bdd.conf
require_once 'config/connexion.conf.php'; //Fait appel au fichier connexion.conf
/* @var $bdd PDO */
//print_r2($_POST);
//print_r2($_FILES);
print_r2($_SESSION);



if(isset($_POST['bouton'])){ //Récupère les valeurs du formulaire lors de la soumission du formulaire
	$titre = $_POST['titre']; //Récupère la valeur titre
	$texte = $_POST['texte']; //Récupère la valeur texte
	$publie = isset($_POST['publie']) ? 1 : 0; //Recupère la valeur publie
	$date = date('Y-m-d'); //Récupère la valeur date sous la forme année-mois-jour


$sth = $bdd->prepare("INSERT INTO articles "
		. "(titre, texte, publie, date)"
		. "VALUES (:titre, :texte, :publie, :date)"); //Requête SQL d'insertion dans la BDD
		
$sth->bindValue(":titre" , $titre, PDO::PARAM_STR); //Assigne la valeur titre
$sth->bindValue(":texte" , $texte, PDO::PARAM_STR); //Assigne la valeur texte
$sth->bindValue(":publie" , $publie, PDO::PARAM_INT); //Assigne la valeur publie
$sth->bindValue(":date" , $date, PDO::PARAM_STR); //Assigne la valeur date
$alerte = $sth->execute(); //Execute la requête

$id_insert  = $bdd->lastInsertId(); 
if($_FILES['id']['error'] == 0){ 
	$ext = pathinfo($_FILES['id']['tmp_name'], PATHINFO_EXTENSION); 
	move_uploaded_file($_FILES['id']['tmp_name'], 'img/' . $id_insert . '.jpg'); //déplace les images en changeant leurs noms
}


header('Location: index.php'); //Redirige vers la page d'accueil
} else {


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
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Formulaire</h1><br/> <!-- Titre de la page -->
        <h2>Ajouter un article</h2> <!-- Titre 2 de la pge -->
      </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
          <form method="post" enctype='multipart/form-data' action="article.php"> <!-- Création du formulaire pour la rédaction des articles -->
            <div class="form-group">
              <label for="titre">Titre de l'article : </label>
              <input type="titre" class="form-control" id="titre" name="titre"> <!-- Création du champ titre --> 
            </div>
            <div class="form-group">
              <label for="texte">Contenu de l'article</label>
              <textarea class="form-control" id="texte" name="texte" rows="5"></textarea> <!-- Création du champ texte -->
            </div>
            <div class="form-group">
              <label for="id">Image liée à l'article</label>
              <input type="file" class="form-control-file" id="id" name="id"> <!-- Création du champ pour ajouter une image -->
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="publie" name="publie">
              <label class="form-check-label" for="exampleCheck1">Publier l'article</label> <!-- Création du champ pour publie l'article  -->
            </div>
            <button type="submit" class="btn btn-primary" name="bouton">Valider la saisie</button> <!-- Bouton pour valider la saisie -->
          </form>
        </div>
    </div>
  </div>
  <!-- Footer -->
  <?php include_once 'includes/footer.inc.php'; ?> <!-- Inclus les informations du fichier footer pour l'affichage du bas de la page -->
</body>

</html>
<?php } ?>