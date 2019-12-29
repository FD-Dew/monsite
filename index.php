<?php
require_once 'config/init.conf.php'; //Fait appel au fichier init.conf
require_once 'config/bdd.conf.php'; //Fait appel au fichier bdd.conf
require_once 'config/connexion.conf.php'; //Fait appel au fichier connexion.conf

/* @var $bdd PDO */


$page_courant = !empty($_GET['p']) ? $_GET['p'] : 1;

$nb_total_articles = nb_total_articles($bdd); //recuperer le nombre d'article 

//print_r2($nb_total_articles);
//print_r2($_nb_art_par_page);
$nb_total_pages = ceil((int)nb_total_articles / (int)_nb_art_par_page); //ceil retourne à l'entier supérieur
print_r2($nb_total_pages);
$index = pagination($page_courant, _nb_art_par_page); //Nombre d'article par page

$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y') AS date_fr, publie FROM articles WHERE publie = :publie LIMIT :index, :_nb_art_par_page");  //Requête SQL
$sth->bindValue(':publie', 1, PDO::PARAM_INT);   //Paramètre de la requête
$sth->bindValue(':index', $index, PDO::PARAM_INT);
$sth->bindValue(':_nb_art_par_page', _nb_art_par_page, PDO::PARAM_INT);
$sth->execute();    //Execution de la requête

$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC); //Affichage des articles

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
        <h1 class="mt-5">Mon super blog</h1><br/> <!-- Création d'un titre  -->
      </div>
      <?php
      foreach ($tab_articles as $value) { ?> <!-- Récupère le nombre d'article dans la BDD -->
        <div class="col-6"> <!--  -->
          <div class="card" style="width: 100%;"> <!-- Mise en forme de l'article -->
            <img src="img/<?= $value['id'] ?>.jpg" class="card-img-top"> <!-- Récupère l'image de chaque article -->
            <div class="card-body">
              <h5 class="card-title"><?= $value['titre'] ?></h5> <!-- Titre de l'article -->
              <p class="card-text"><?= $value['texte'] ?></p> <!-- Texte de l'article -->
              <p class="card-text"><small class="text-muted">Mis en ligne le <?= $value['date_fr'] ?></small></p> <!-- Affiche la date de la mise en ligne de l'article -->
			  <button type="submit" class="btn btn-primary" name="bouton">Modifier</button>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
			<div class="row">
        <div class="col-lg-12">
          <form method="post" enctype='multipart/form-data' action="index.php"> <!-- Formulaire pour la recherche d'un article -->
            <div class="form-group">
              <label for="nom">Recherche</label>
              <input type="nom" class="form-control" id="recherche" name="recherche"> <!-- Champ pour saisir la recherche d'un article -->
            </div>
			<button type="submit" class="btn btn-primary" name="bouton">Valider la saisie</button> <!-- Validation de la saisie de la recherche -->
          </form>
		</div>
	
	<div class="row">
	<nav aria-label="...">
		<ul class="pagination pagination-lg">
		<?php
		for ($index1 = 1; $index1 <= $nb_total_pages; $index1++) { //Incrémente la valeur de la page par rapport au nombre de page
		?>
			<li class="page-item"><a class="page-link" href="#">2</a></li>
		<?php 
		}
		?> 
		</ul>
	</nav>
  </div>
  </div>
  <!-- Footer -->
  <?php include_once 'includes/footer.inc.php'; ?> <!-- Inclus les informations du fichier pour l'affichage du footer -->
</body>

</html>