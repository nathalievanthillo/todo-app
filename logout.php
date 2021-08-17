<?php

session_start(); //Session wordt gestart en kijkt of dat we zijn ingelogd
session_destroy(); //Gooi de cookie weg
header("location:login.php"); //je wordt teruggestuurd naar login.php zodat je terug kan inloggen

?>