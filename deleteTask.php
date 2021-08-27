<?php

include_once(__DIR__ . '/classes/Task.php');

session_start(); 

Task::deleteTask($_SESSION['userId'], $_GET['taskId']);

header("location:index.php?listId=".$_GET['listId']);

?>
