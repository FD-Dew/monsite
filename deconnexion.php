<?php

setcookie('sid', '', -1); //Supprime le cookie créer par la connexion

header("Location: index.php");//Redirige vers la page d'accueil
exit();
?>