<?php

require "connectDB.php";
require "Crud.php";
require "utils.php";

init_php_session();
grant_access(true);

$db = connect();

if(isset($_POST))
{
    if(intval($_POST["IdMatch"]) > 0 && intval($_POST["equipe"]) > 0 && intval($_POST["minute"]) > 0 && intval($_POST["joueurSanctionne"]) > 0 && intval($_POST["carton"]) > 0)
    {
        $idEquipe = Get_IdTeam_From_Player($db, $_POST['joueurSanctionne']);
        if($idEquipe == "KO")
        {
            $res = "KO";
        }
        else
            $res = Add_Carton($db, $_POST['IdMatch'], $_POST['carton'], $idEquipe["IdEquipe"], $_POST['joueurSanctionne'], $_POST['minute']);
    }

    if($res == "OK")
        header("location: ResultatsMatch.php?idFeuille=".$_POST['IdMatch']);
    else
        header("location: DisplayAndRedirect.php?result=KO");

}