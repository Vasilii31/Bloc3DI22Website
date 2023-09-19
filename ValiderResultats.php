<?php

    require "connectDB.php";
    require "Crud.php";
    require "utils.php";

    init_php_session();
    grant_access(true);

    $db = connect();

    if(isset($_POST))
    {
        //insert
        $res = Set_Resultats_complete($db, $_POST['IdMatch']);
        //header en fonction du resultat
        var_dump($res);
        if($res == true)
            header("location: DisplayAndRedirect.php?result=MATCHCOMPLETE");
        else
            header("location: DisplayAndRedirect.php?result=KO");
    }
    