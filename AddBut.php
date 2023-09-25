<?php

    require "connectDB.php";
    require "Crud.php";
    require "utils.php";

    init_php_session();
    grant_access(true);

    $db = connect();

    if(isset($_POST))
    {
        $contreSonCamp = ($_POST['ContreSonCamp'] == 1 ? true : false);
        
        //insert
        if(intval($_POST["IdMatch"]) > 0 && intval($_POST["equipe"]) > 0 && intval($_POST["buteur"]) > 0 && intval($_POST["buteur"]) > 0)
        {
            $idEquipe = Get_IdTeam_From_Player($db, $_POST['buteur']);
            if($idEquipe == "KO")
            {
                $res = "KO";
            }
            else
                $res = Add_But($db, $idEquipe["IdEquipe"], $_POST['IdMatch'], $_POST['buteur'], $contreSonCamp, $_POST['minute']);
        }

        //header en fonction du resultat
        if($res == "OK")
            header("location: ResultatsMatch.php?idFeuille=".$_POST['IdMatch']);
        else
            header("location: DisplayAndRedirect.php?result=KO");
        
    }
    