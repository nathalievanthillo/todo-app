<?php

include_once(__DIR__ . '/classes/Lists.php');

session_start(); 

$result = Lists::deleteLists($_SESSION['userId'], $_GET['listId']); 
header("location:index.php");
?>

