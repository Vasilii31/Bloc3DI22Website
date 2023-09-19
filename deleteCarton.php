<?php

require "connectDB.php";
require "Crud.php";
require "utils.php";

init_php_session();
grant_access(true);

$db = connect();

if(isset($_GET) && intval($_GET["idCarton"]) > 0)
{
    //var_dump($_POST);

    //delete
    Delete_Carton($db, $_GET["idCarton"]);

    //header en fonction du resultat
    header("location: ResultatsMatch.php?idFeuille=".$_GET['IdMatch']);

}