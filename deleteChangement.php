<?php

require "connectDB.php";
require "Crud.php";
require "utils.php";

init_php_session();
grant_access(true);

$db = connect();

if(isset($_GET) && intval($_GET["idChangement"]) > 0)
{
    //var_dump($_POST);

    //delete
    Delete_Changement($db, $_GET["idChangement"]);

    //header en fonction du resultat
    header("location: ResultatsMatch.php?idFeuille=".$_GET['IdMatch']);

}