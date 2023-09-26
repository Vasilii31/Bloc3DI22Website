<?php

require "../Librairies/connectDB.php";
require "../Librairies/Crud.php";
require "../Librairies/utils.php";

init_php_session();
grant_access(true);

$db = connect();

if(isset($_GET) && intval($_GET["idBut"]) > 0)
{
    //var_dump($_POST);

    //delete
    Delete_But($db, $_GET["idBut"]);

    //header en fonction du resultat
    header("location: ../Views/ResultatsMatch.php?idFeuille=".$_GET['IdMatch']);

}