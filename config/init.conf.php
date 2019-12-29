<?php
session_start();
//Affichage des erreurs et avertissements PHP
error_reporting(E_ALL);
ini_set("display_errors", 1);

function print_r2($ma_variable){
    echo '<pre>';
    print_r($ma_variable);
    echo '</pre>';
	
	return true;
}

date_default_timezone_set('Europe/Paris');

define('_nb_art_par_page', 2);

function pagination($page_courant, $nb_articles_par_page) { 
	$index = ($page_courant - 1) * $nb_articles_par_page;
	return $index;
}

function nb_total_articles($bdd){
	$sth = $bdd->prepare("SELECT COUNT(*) as total_articles "
		. "FROM articles "
		. "WHERE publie = :publie");
	$sth->bindValue('publie', 1, PDO::PARAM_BOOL);
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_ASSOC);
	$total_articles = (int)$result['total_articles'];
	return $total_articles;
}
	