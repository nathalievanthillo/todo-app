<?php

include_once(__DIR__ . '/classes/Lists.php');

session_start(); //Session wordt gestart en kijkt of dat we zijn ingelogd

$result = Lists::deleteLists($_SESSION['userId'], $_GET['listId']); //userId komt uit session en kan alleen verkregen worden door een login

header("location:index.php"); //je wordt teruggestuurd naar de pagina van de lijst
?>

