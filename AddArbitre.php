<?php

require "connectDB.php";
require "Crud.php";
require "utils.php";

// if(!init_php_session() || !is_logged() || !isAdmin())
// {
//     header("location: /auth.php");
//     return;
// }

$db = connect();

if(isset($_POST))
{
    /*if(intval($_POST["IdMatch"]) > 0 && intval($_POST["equipe"]) > 0 && intval($_POST["minute"]) > 0 && intval($_POST["joueurSanctionne"]) > 0 && intval($_POST["carton"]) > 0)
    {
        $res = Add_Carton($db, $_POST['IdMatch'], $_POST['carton'], $_POST['equipe'], $_POST['joueurSanctionne'], $_POST['minute']);
    }*/

    /*if($res == "OK")
        header("location: ResultatsMatch.php?idFeuille=".$_POST['IdMatch']);
    else
        header("location: DisplayAndRedirect.php?result=KO");*/

}