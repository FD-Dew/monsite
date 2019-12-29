<?php 

$connecte = FALSE;
//print_r2($_COOKIE);
if(isset($_COOKIE['sid'])){
	$sid = $_COOKIE['sid'];
	$sth_connexion = $bdd->prepare("SELECT * "
		. "FROM utilisateur "
		. "WHERE sid = :sid");
	$sth_connexion->bindValue(':sid', $sid, PDO::PARAM_STR);
	$sth_connexion->execute();
	if($sth_connexion->rowCount() > 0) {
		$connect = TRUE;
	}
}

