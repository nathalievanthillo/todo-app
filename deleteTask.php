<?php

include_once(__DIR__ . '/classes/Task.php');

session_start(); //Session wordt gestart en kijkt of dat we zijn ingelogd

Task::deleteTask($_SESSION['userId'], $_GET['taskId']); //userId komt uit session en kan alleen verkregen worden door een login

header("location:index.php?listId=".$_GET['listId']); //je wordt teruggestuurd naar de pagina van de lijst

?>