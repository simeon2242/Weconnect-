<?php

// CONCERVATION DE NOS THEMES DANS LE SESSION
@session_start();
if (isset($_POST["theme"])) {
    $_SESSION  ["theme"]=$_POST["theme"];
}


//Affichage du theme 'claire' par defaut
if (!isset($_SESSION["theme"])) {
    $_SESSION["theme"]="claire";
}

$theme=isset ($_SESSION["theme"])?$_SESSION["theme"]:"claire";

$transparent="transparent";

?>