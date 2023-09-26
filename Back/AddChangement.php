<?php

require "../Librairies/connectDB.php";
require "../Librairies/Crud.php";
require "../Librairies/utils.php";

init_php_session();
grant_access(true);

$db = connect();

if(isset($_POST))
{
    if(intval($_POST["IdMatch"]) > 0 && intval($_POST["equipe"]) > 0 && intval($_POST["minute"]) > 0 && intval($_POST["joueurEntrant"]) > 0 && intval($_POST["joueurSortant"]) > 0)
    {
        $idEquipe = Get_IdTeam_From_Player($db, $_POST['joueurEntrant']);
        if($idEquipe == "KO")
        {
            $res = "KO";
        }
        else
            $res = Add_Changement($db, $_POST['IdMatch'], $idEquipe["IdEquipe"], $_POST['joueurSortant'], $_POST['joueurEntrant'], $_POST['minute']);
    }

    if($res == "OK")
        header("location: ../Views/ResultatsMatch.php?idFeuille=".$_POST['IdMatch']);
    else
        header("location: ../Views/DisplayAndRedirect.php?result=KO");

}