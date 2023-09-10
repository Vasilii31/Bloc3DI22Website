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
        $contreSonCamp = ($_POST['ContreSonCamp'] == 1 ? true : false);
        //insert
        if(intval($_POST["IdMatch"]) > 0 && intval($_POST["equipe"]) > 0 && intval($_POST["buteur"]) > 0 && intval($_POST["buteur"]) > 0)
        {
            $res = Add_But($db, $_POST['equipe'], $_POST['IdMatch'], $_POST['buteur'], $contreSonCamp, $_POST['minute']);
        }

        //header en fonction du resultat
        if($res == "OK")
            header("location: ResultatsMatch.php?idFeuille=".$_POST['IdMatch']);
        else
            header("location: DisplayAndRedirect.php?result=KO");

    }
    