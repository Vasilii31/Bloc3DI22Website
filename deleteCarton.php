<?php

require "connectDB.php";
require "Crud.php";

// if(!init_php_session() || !is_logged())
// {
//     header("location: /auth.php");
//     return;
// }

$db = connect();

if(isset($_GET))
{
    //var_dump($_POST);

    //delete
    Delete_Carton($db, $_GET["idCarton"]);

    //header en fonction du resultat
    header("location: ResultatsMatch.php?idFeuille=".$_GET['IdMatch']);

}